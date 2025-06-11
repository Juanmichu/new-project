<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExerciseController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

	/**
	 * Display a listing of exercises for a workout.
	 */
	public function index($workoutId)
	{
		$user = auth()->user();

		$workout = $user->isAdmin()
			? Workout::find($workoutId)
			: $user->workouts()->find($workoutId);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$exercises = $workout->exercises()->ordered()->get();

		return response()->json([
			'success' => true,
			'data' => $exercises
		]);
	}

	/**
	 * Store a newly created exercise.
	 */
	public function store(Request $request, $workoutId)
	{
		$user = auth()->user();

		if (!$user->isAdmin()) {
			return response()->json([
				'success' => false,
				'message' => 'Unauthorized'
			], 403);
		}

		$workout = Workout::find($workoutId);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'type' => 'required|in:cardio,strength,flexibility,balance,sports',
			'sets' => 'nullable|integer|min:1',
			'reps' => 'nullable|integer|min:1',
			'weight_kg' => 'nullable|numeric|min:0',
			'duration_seconds' => 'nullable|integer|min:1',
			'distance_meters' => 'nullable|numeric|min:0',
			'calories_burned' => 'nullable|integer|min:0',
			'rest_seconds' => 'nullable|integer|min:0',
			'order' => 'nullable|integer|min:1',
			'video_url' => 'nullable|url',
			'image_url' => 'nullable|url',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		$data = $request->all();
		$data['workout_id'] = $workoutId;

		// Set order if not provided
		if (!isset($data['order'])) {
			$data['order'] = $workout->exercises()->count() + 1;
		}

		$exercise = Exercise::create($data);

		return response()->json([
			'success' => true,
			'message' => 'Exercise created successfully',
			'data' => $exercise
		], 201);
	}

	/**
	 * Display the specified exercise.
	 */
	public function show($workoutId, $id)
	{
		$user = auth()->user();

		$workout = $user->isAdmin()
			? Workout::find($workoutId)
			: $user->workouts()->find($workoutId);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$exercise = $workout->exercises()->find($id);

		if (!$exercise) {
			return response()->json([
				'success' => false,
				'message' => 'Exercise not found'
			], 404);
		}

		return response()->json([
			'success' => true,
			'data' => $exercise
		]);
	}

	/**
	 * Update the specified exercise.
	 */
	public function update(Request $request, $workoutId, $id)
	{
		$user = auth()->user();

		if (!$user->isAdmin()) {
			return response()->json([
				'success' => false,
				'message' => 'Unauthorized'
			], 403);
		}

		$workout = Workout::find($workoutId);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$exercise = $workout->exercises()->find($id);

		if (!$exercise) {
			return response()->json([
				'success' => false,
				'message' => 'Exercise not found'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'name' => 'sometimes|string|max:255',
			'description' => 'nullable|string',
			'type' => 'sometimes|in:cardio,strength,flexibility,balance,sports',
			'sets' => 'nullable|integer|min:1',
			'reps' => 'nullable|integer|min:1',
			'weight_kg' => 'nullable|numeric|min:0',
			'duration_seconds' => 'nullable|integer|min:1',
			'distance_meters' => 'nullable|numeric|min:0',
			'calories_burned' => 'nullable|integer|min:0',
			'rest_seconds' => 'nullable|integer|min:0',
			'order' => 'nullable|integer|min:1',
			'is_completed' => 'sometimes|boolean',
			'notes' => 'nullable|string',
			'video_url' => 'nullable|url',
			'image_url' => 'nullable|url',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		$exercise->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Exercise updated successfully',
			'data' => $exercise
		]);
	}

	/**
	 * Remove the specified exercise.
	 */
	public function destroy($workoutId, $id)
	{
		$user = auth()->user();

		if (!$user->isAdmin()) {
			return response()->json([
				'success' => false,
				'message' => 'Unauthorized'
			], 403);
		}

		$workout = Workout::find($workoutId);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$exercise = $workout->exercises()->find($id);

		if (!$exercise) {
			return response()->json([
				'success' => false,
				'message' => 'Exercise not found'
			], 404);
		}

		$exercise->delete();

		return response()->json([
			'success' => true,
			'message' => 'Exercise deleted successfully'
		]);
	}

	/**
	 * Mark exercise as completed
	 */
	public function complete($workoutId, $id)
	{
		$user = auth()->user();

		$workout = $user->isAdmin()
			? Workout::find($workoutId)
			: $user->workouts()->find($workoutId);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$exercise = $workout->exercises()->find($id);

		if (!$exercise) {
			return response()->json([
				'success' => false,
				'message' => 'Exercise not found'
			], 404);
		}

		$exercise->markAsCompleted();

		return response()->json([
			'success' => true,
			'message' => 'Exercise marked as completed',
			'data' => $exercise
		]);
	}
}
