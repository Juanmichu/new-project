<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WorkoutController extends Controller
{
	public function index(Request $request)
	{
		$workouts = Workout::where('user_id', $request->user()->id)
			->with(['exercises.exercise'])
			->orderBy('workout_date', 'desc')
			->paginate(10);

		return response()->json($workouts);
	}

	public function todayWorkout(Request $request)
	{
		$today = Carbon::today();

		$workout = Workout::where('user_id', $request->user()->id)
			->whereDate('workout_date', $today)
			->with(['exercises.exercise'])
			->first();

		if (!$workout) {
			// Generate a default workout if none exists
			$workout = $this->generateDefaultWorkout($request->user());
		}

		return response()->json($workout);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'workout_date' => 'required|date',
			'exercises' => 'required|array|min:1',
			'exercises.*.exercise_id' => 'required|string',
			'exercises.*.sets' => 'required|integer|min:1',
			'exercises.*.reps' => 'required|integer|min:1',
			'exercises.*.rest_time' => 'nullable|integer|min:0'
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => 'Validation errors',
				'errors' => $validator->errors()
			], 422);
		}

		$workout = Workout::create([
			'user_id' => $request->user()->id,
			'name' => $request->name,
			'description' => $request->description,
			'workout_date' => $request->workout_date,
			'status' => 'planned'
		]);

		foreach ($request->exercises as $index => $exerciseData) {
			WorkoutExercise::create([
				'workout_id' => $workout->id,
				'exercise_id' => $exerciseData['exercise_id'],
				'sets' => $exerciseData['sets'],
				'reps' => $exerciseData['reps'],
				'rest_time' => $exerciseData['rest_time'] ?? 60,
				'order' => $index + 1,
				'completed' => false
			]);
		}

		return response()->json([
			'message' => 'Workout created successfully',
			'workout' => $workout->load(['exercises.exercise'])
		], 201);
	}

	public function show(Request $request, $id)
	{
		$workout = Workout::where('user_id', $request->user()->id)
			->where('id', $id)
			->with(['exercises.exercise'])
			->firstOrFail();

		return response()->json($workout);
	}

	public function update(Request $request, $id)
	{
		$workout = Workout::where('user_id', $request->user()->id)
			->where('id', $id)
			->firstOrFail();

		$validator = Validator::make($request->all(), [
			'name' => 'sometimes|string|max:255',
			'description' => 'sometimes|string',
			'status' => 'sometimes|in:planned,in_progress,completed,skipped',
			'notes' => 'sometimes|string'
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => 'Validation errors',
				'errors' => $validator->errors()
			], 422);
		}

		$workout->update($request->only(['name', 'description', 'status', 'notes']));

		return response()->json([
			'message' => 'Workout updated successfully',
			'workout' => $workout
		]);
	}

	public function markExerciseComplete(Request $request, $workoutId, $exerciseId)
	{
		$workoutExercise = WorkoutExercise::where('workout_id', $workoutId)
			->where('id', $exerciseId)
			->firstOrFail();

		$workoutExercise->update(['completed' => true]);

		return response()->json([
			'message' => 'Exercise marked as completed',
			'exercise' => $workoutExercise
		]);
	}

	private function generateDefaultWorkout($user)
	{
		// Get random exercises
		$exercises = Exercise::where('is_active', true)
			->take(5)
			->get();

		$workout = Workout::create([
			'user_id' => $user->id,
			'name' => 'Today\'s Workout',
			'description' => 'Your daily workout routine',
			'workout_date' => Carbon::today(),
			'status' => 'planned'
		]);

		foreach ($exercises as $index => $exercise) {
			WorkoutExercise::create([
				'workout_id' => $workout->id,
				'exercise_id' => $exercise->id,
				'sets' => 3,
				'reps' => 12,
				'rest_time' => 60,
				'order' => $index + 1,
				'completed' => false
			]);
		}

		return $workout->load(['exercises.exercise']);
	}
}
