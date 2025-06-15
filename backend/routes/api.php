<?php
// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WorkoutController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\NewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::prefix('auth')->group(function () {
	Route::post('/register', [AuthController::class, 'register']);
	Route::post('/login', [AuthController::class, 'login']);
});

// Public content routes
Route::prefix('exercises')->group(function () {
	Route::get('/', [ExerciseController::class, 'index']);
	Route::get('/categories', [ExerciseController::class, 'categories']);
	Route::get('/{id}', [ExerciseController::class, 'show']);
});

Route::prefix('articles')->group(function () {
	Route::get('/', [ArticleController::class, 'index']);
	Route::get('/{slug}', [ArticleController::class, 'show']);
});

Route::prefix('news')->group(function () {
	Route::get('/', [NewsController::class, 'index']);
	Route::get('/breaking', [NewsController::class, 'breaking']);
	Route::get('/{slug}', [NewsController::class, 'show']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
	// Auth routes
	Route::prefix('auth')->group(function () {
		Route::post('/logout', [AuthController::class, 'logout']);
		Route::get('/user', [AuthController::class, 'user']);
	});

	// User profile routes
	Route::prefix('user')->group(function () {
		Route::get('/profile', function (Request $request) {
			return response()->json($request->user());
		});

		Route::put('/profile', function (Request $request) {
			$user = $request->user();
			$user->update($request->only([
				'name', 'age', 'weight', 'height',
				'fitness_level', 'goals', 'preferences'
			]));
			return response()->json($user);
		});
	});

	// Workout routes
	Route::prefix('workouts')->group(function () {
		Route::get('/', [WorkoutController::class, 'index']);
		Route::post('/', [WorkoutController::class, 'store']);
		Route::get('/today', [WorkoutController::class, 'todayWorkout']);
		Route::get('/{id}', [WorkoutController::class, 'show']);
		Route::put('/{id}', [WorkoutController::class, 'update']);
		Route::delete('/{id}', [WorkoutController::class, 'destroy']);

		// Exercise completion
		Route::post('/{workoutId}/exercises/{exerciseId}/complete',
			[WorkoutController::class, 'markExerciseComplete']);
	});

	// Workout sessions (for tracking actual workout performance)
	Route::prefix('workout-sessions')->group(function () {
		Route::get('/', function (Request $request) {
			return response()->json(
				$request->user()->workoutSessions()
					->with('workout')
					->orderBy('started_at', 'desc')
					->paginate(10)
			);
		});

		Route::post('/', function (Request $request) {
			$session = $request->user()->workoutSessions()->create([
				'workout_id' => $request->workout_id,
				'started_at' => now(),
				'exercises_completed' => 0,
				'total_exercises' => $request->total_exercises ?? 0
			]);

			return response()->json($session, 201);
		});

		Route::put('/{id}/complete', function (Request $request, $id) {
			$session = $request->user()->workoutSessions()->findOrFail($id);
			$session->update([
				'completed_at' => now(),
				'duration' => $request->duration,
				'calories_burned' => $request->calories_burned,
				'exercises_completed' => $request->exercises_completed,
				'notes' => $request->notes,
				'rating' => $request->rating
			]);

			return response()->json($session);
		});
	});

	// User statistics
	Route::prefix('stats')->group(function () {
		Route::get('/dashboard', function (Request $request) {
			$user = $request->user();

			// Get today's workout
			$todayWorkout = $user->workouts()
				->whereDate('workout_date', today())
				->with(['exercises.exercise'])
				->first();

			// Calculate completion percentage
			$completionRate = 0;
			if ($todayWorkout && $todayWorkout->exercises->count() > 0) {
				$completedExercises = $todayWorkout->exercises->where('completed', true)->count();
				$totalExercises = $todayWorkout->exercises->count();
				$completionRate = round(($completedExercises / $totalExercises) * 100);
			}

			// Get week's statistics
			$weekWorkouts = $user->workouts()
				->whereBetween('workout_date', [now()->startOfWeek(), now()->endOfWeek()])
				->count();

			$totalWorkouts = $user->workouts()->count();

			return response()->json([
				'today_workout' => $todayWorkout,
				'completion_rate' => $completionRate,
				'week_workouts' => $weekWorkouts,
				'total_workouts' => $totalWorkouts,
				'user_level' => $user->fitness_level,
				'goals_count' => count($user->goals ?? [])
			]);
		});

		Route::get('/progress', function (Request $request) {
			$user = $request->user();

			// Get last 30 days of workout sessions
			$sessions = $user->workoutSessions()
				->where('completed_at', '>=', now()->subDays(30))
				->orderBy('completed_at')
				->get();

			// Calculate trends
			$totalCalories = $sessions->sum('calories_burned');
			$totalWorkouts = $sessions->count();
			$avgDuration = $sessions->avg('duration');
			$avgRating = $sessions->avg('rating');

			return response()->json([
				'total_calories' => $totalCalories,
				'total_workouts' => $totalWorkouts,
				'avg_duration' => round($avgDuration),
				'avg_rating' => round($avgRating, 1),
				'sessions' => $sessions
			]);
		});
	});

	// Content interaction routes
	Route::post('/articles/{id}/like', [ArticleController::class, 'like']);
});

// Health check route
Route::get('/health', function () {
	return response()->json([
		'status' => 'healthy',
		'timestamp' => now(),
		'version' => '1.0.0'
	]);
});
