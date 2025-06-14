<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\ExerciseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
	// Auth routes
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::post('/refresh', [AuthController::class, 'refresh']);
	Route::get('/me', [AuthController::class, 'me']);

	// User profile routes
	Route::get('/profile', [UserController::class, 'profile']);
	Route::put('/profile', [UserController::class, 'updateProfile']);

	// Workout routes
	Route::get('/workouts/today', [WorkoutController::class, 'today']);
	Route::post('/workouts/{workout}/complete', [WorkoutController::class, 'complete']);
	Route::apiResource('workouts', WorkoutController::class);

	// Exercise routes
	Route::get('/workouts/{workout}/exercises', [ExerciseController::class, 'index']);
	Route::post('/workouts/{workout}/exercises', [ExerciseController::class, 'store']);
	Route::get('/workouts/{workout}/exercises/{exercise}', [ExerciseController::class, 'show']);
	Route::put('/workouts/{workout}/exercises/{exercise}', [ExerciseController::class, 'update']);
	Route::delete('/workouts/{workout}/exercises/{exercise}', [ExerciseController::class, 'destroy']);
	Route::post('/workouts/{workout}/exercises/{exercise}/complete', [ExerciseController::class, 'complete']);

	// Admin only routes
	Route::middleware('admin')->group(function () {
		Route::apiResource('users', UserController::class);
	});
});

// Health check route
Route::get('/health', function () {
	return response()->json([
		'success' => true,
		'message' => 'API is running',
		'timestamp' => now()
	]);
});
