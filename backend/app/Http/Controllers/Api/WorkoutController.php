<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use App\Models\WorkoutSession;
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

            // If no workout exists for today for specific user, generate a default one and attach five random exercises to it.
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
			// Ensure the workout belongs to the user and is not already locked.
			$workout = Workout::where('user_id', $request->user()->_id)
				->where('_id', $workoutId)
				->firstOrFail();

			// Once a workout is completed it is locked: exercises can no longer be toggled.
			if ($workout->status === 'completed') {
				return response()->json([
					'success' => false,
					'message' => 'This workout is already completed and can no longer be modified.'
				], 423);
			}

			$workoutExercise = WorkoutExercise::where('workout_id', $workoutId)
				->where('_id', $exerciseId)
				->firstOrFail();

			// Accept an explicit `completed` value; if omitted, toggle the current state.
			$completed = $request->has('completed')
				? $request->boolean('completed')
				: !$workoutExercise->completed;

			$workoutExercise->update(['completed' => $completed]);

			return response()->json([
				'success' => true,
				'message' => $completed ? 'Exercise marked as completed' : 'Exercise marked as incomplete',
				'data' => $workoutExercise
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to update exercise: ' . $e->getMessage()
			], 500);
		}
	}

	/**
	 * Marks a workout as completed once all of its exercises are done.
	 *
	 * Creates a WorkoutSession record (so it shows up in the user's progress
	 * stats) and locks the workout for the rest of the day. The operation is
	 * idempotent: calling it again on an already-completed workout returns the
	 * existing state without creating a duplicate session.
	 */
	public function completeWorkout(Request $request, $id)
	{
		try {
			$workout = Workout::where('user_id', $request->user()->_id)
				->where('_id', $id)
				->with(['exercises.exercise'])
				->firstOrFail();

			// Idempotent: don't create a second session for an already-completed workout.
			if ($workout->status === 'completed') {
				return response()->json([
					'success' => true,
					'message' => 'Workout already completed',
					'already_completed' => true,
					'data' => [
						'workout' => $workout,
						'session' => $workout->sessions()->latest('completed_at')->first()
					]
				]);
			}

			$totalExercises = $workout->exercises->count();
			$completedExercises = $workout->exercises->where('completed', true)->count();

			// Guard: only allow completion when every exercise is done.
			if ($totalExercises === 0 || $completedExercises < $totalExercises) {
				return response()->json([
					'success' => false,
					'message' => 'All exercises must be completed before finishing the workout.'
				], 422);
			}

			$session = WorkoutSession::create([
				'user_id' => $request->user()->_id,
				'workout_id' => $workout->_id,
				'started_at' => $workout->created_at ?? now(),
				'completed_at' => now(),
				'duration' => $workout->total_duration ?? 0,
				'calories_burned' => $workout->calories_burned ?? 0,
				'exercises_completed' => $completedExercises,
				'total_exercises' => $totalExercises,
			]);

			$workout->update(['status' => 'completed']);

			return response()->json([
				'success' => true,
				'message' => 'Workout completed. Great job!',
				'already_completed' => true,
				'data' => [
					'workout' => $workout->load(['exercises.exercise']),
					'session' => $session
				]
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to complete workout: ' . $e->getMessage()
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

    /**
     * Generates a default workout for the user if none exists for today. Then, attaches five random exercises to it.
     * @param User $user
     * @return Workout|\Illuminate\Database\Eloquent\Model|null
     */
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
                'total_duration' => 45, // default duration in minutes
                'difficulty_level' => 'medium',
                'status' => 'planned',
                'notes' => null,
                'calories_burned' => 300
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
