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
		try {
			$workouts = Workout::where('user_id', $request->user()->_id)
				->with(['exercises.exercise'])
				->orderBy('workout_date', 'desc')
				->paginate(10);

			return response()->json([
				'success' => true,
				'data' => $workouts
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to fetch workouts: ' . $e->getMessage()
			], 500);
		}
	}

	public function todayWorkout(Request $request)
	{
		try {
			$today = Carbon::today();

			$workout = Workout::where('user_id', $request->user()->_id)
				->whereDate('workout_date', $today)
				->with(['exercises.exercise'])
				->first();

			if (!$workout) {
				// Generate a default workout if none exists
				$workout = $this->generateDefaultWorkout($request->user());
			}

			return response()->json([
				'success' => true,
				'data' => $workout
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to fetch today\'s workout: ' . $e->getMessage()
			], 500);
		}
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
				'success' => false,
				'message' => 'Validation errors',
				'errors' => $validator->errors()
			], 422);
		}

		try {
			$workout = Workout::create([
				'user_id' => $request->user()->_id,
				'name' => $request->name,
				'description' => $request->description,
				'workout_date' => $request->workout_date,
				'status' => 'planned'
			]);

			foreach ($request->exercises as $index => $exerciseData) {
				WorkoutExercise::create([
					'workout_id' => $workout->_id,
					'exercise_id' => $exerciseData['exercise_id'],
					'sets' => $exerciseData['sets'],
					'reps' => $exerciseData['reps'],
					'rest_time' => $exerciseData['rest_time'] ?? 60,
					'order' => $index + 1,
					'completed' => false
				]);
			}

			return response()->json([
				'success' => true,
				'message' => 'Workout created successfully',
				'data' => $workout->load(['exercises.exercise'])
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to create workout: ' . $e->getMessage()
			], 500);
		}
	}

	public function show(Request $request, $id)
	{
		try {
			$workout = Workout::where('user_id', $request->user()->_id)
				->where('_id', $id)
				->with(['exercises.exercise'])
				->firstOrFail();

			return response()->json([
				'success' => true,
				'data' => $workout
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}
	}

	public function update(Request $request, $id)
	{
		try {
			$workout = Workout::where('user_id', $request->user()->_id)
				->where('_id', $id)
				->firstOrFail();

			$validator = Validator::make($request->all(), [
				'name' => 'sometimes|string|max:255',
				'description' => 'sometimes|string',
				'status' => 'sometimes|in:planned,in_progress,completed,skipped',
				'notes' => 'sometimes|string'
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'message' => 'Validation errors',
					'errors' => $validator->errors()
				], 422);
			}

			$workout->update($request->only(['name', 'description', 'status', 'notes']));

			return response()->json([
				'success' => true,
				'message' => 'Workout updated successfully',
				'data' => $workout
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to update workout: ' . $e->getMessage()
			], 500);
		}
	}

	public function markExerciseComplete(Request $request, $workoutId, $exerciseId)
	{
		try {
			$workoutExercise = WorkoutExercise::where('workout_id', $workoutId)
				->where('_id', $exerciseId)
				->firstOrFail();

			$workoutExercise->update(['completed' => true]);

			return response()->json([
				'success' => true,
				'message' => 'Exercise marked as completed',
				'data' => $workoutExercise
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to mark exercise as complete: ' . $e->getMessage()
			], 500);
		}
	}

	public function destroy(Request $request, $id)
	{
		try {
			$workout = Workout::where('user_id', $request->user()->_id)
				->where('_id', $id)
				->firstOrFail();

			// Delete associated exercises
			WorkoutExercise::where('workout_id', $workout->_id)->delete();
			$workout->delete();

			return response()->json([
				'success' => true,
				'message' => 'Workout deleted successfully'
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to delete workout: ' . $e->getMessage()
			], 500);
		}
	}

	private function generateDefaultWorkout($user)
	{
		try {
			// Get random exercises
			$exercises = Exercise::where('is_active', true)
				->take(5)
				->get();

			if ($exercises->isEmpty()) {
				return null;
			}

			$workout = Workout::create([
				'user_id' => $user->_id,
				'name' => 'Today\'s Workout',
				'description' => 'Your daily workout routine',
				'workout_date' => Carbon::today(),
				'status' => 'planned'
			]);

			foreach ($exercises as $index => $exercise) {
				WorkoutExercise::create([
					'workout_id' => $workout->_id,
					'exercise_id' => $exercise->_id,
					'sets' => 3,
					'reps' => 12,
					'rest_time' => 60,
					'order' => $index + 1,
					'completed' => false
				]);
			}

			return $workout->load(['exercises.exercise']);
		} catch (\Exception $e) {
			\Log::error('Failed to generate default workout: ' . $e->getMessage());
			return null;
		}
	}
}
