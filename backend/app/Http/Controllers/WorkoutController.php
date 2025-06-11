<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkoutController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

	/**
	 * Display a listing of workouts.
	 */
	public function index(Request $request)
	{
		$user = auth()->user();
		$query = $user->isAdmin() ? Workout::with(['user', 'exercises']) : $user->workouts()->with('exercises');

		// Filter by date if provided
		if ($request->has('date')) {
			$query->whereDate('scheduled_date', $request->date);
		}

		// Filter by user if admin and user_id provided
		if ($user->isAdmin() && $request->has('user_id')) {
			$query->where('user_id', $request->user_id);
		}

		$workouts = $query->orderBy('scheduled_date', 'desc')->paginate(15);

		return response()->json([
			'success' => true,
			'data' => $workouts
		]);
	}

	/**
	 * Get today's workout for the authenticated user.
	 */
	public function today()
	{
		$user = auth()->user();
		$workout = $user->getTodayWorkout();

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'No workout scheduled for today'
			], 404);
		}

		$workout->load('exercises');

		return response()->json([
			'success' => true,
			'data' => $workout
		]);
	}

	/**
	 * Store a newly created workout.
	 */
	public function store(Request $request)
	{
		$user = auth()->user();

		if (!$user->isAdmin()) {
			return response()->json([
				'success' => false,
				'message' => 'Unauthorized'
			], 403);
		}

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,_id',
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'scheduled_date' => 'required|date',
			'duration_minutes' => 'nullable|integer|min:1',
			'difficulty_level' => 'nullable|in:beginner,intermediate,advanced',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		$workout = Workout::create($request->all());
		$workout->load(['user', 'exercises']);

		return response()->json([
			'success' => true,
			'message' => 'Workout created successfully',
			'data' => $workout
		], 201);
	}

	/**
	 * Remove the specified workout.
	 */
	public function destroy($id)
	{
		$user = auth()->user();

		if (!$user->isAdmin()) {
			return response()->json([
				'success' => false,
				'message' => 'Unauthorized'
			], 403);
		}

		$workout = Workout::find($id);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		// Delete associated exercises
		$workout->exercises()->delete();
		$workout->delete();

		return response()->json([
			'success' => true,
			'message' => 'Workout deleted successfully'
		]);
	}

	/**
	 * Mark workout as completed
	 */
	public function complete($id)
	{
		$user = auth()->user();

		$workout = $user->isAdmin()
			? Workout::find($id)
			: $user->workouts()->find($id);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$workout->markAsCompleted();

		return response()->json([
			'success' => true,
			'message' => 'Workout marked as completed',
			'data' => $workout
		]);
	}

	/**
	 * Display the specified workout.
	 */
	public function show($id)
	{
		$user = auth()->user();

		$workout = $user->isAdmin()
			? Workout::with(['user', 'exercises'])->find($id)
			: $user->workouts()->with('exercises')->find($id);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		return response()->json([
			'success' => true,
			'data' => $workout
		]);
	}

	/**
	 * Update the specified workout.
	 */
	public function update(Request $request, $id)
	{
		$user = auth()->user();

		if (!$user->isAdmin()) {
			return response()->json([
				'success' => false,
				'message' => 'Unauthorized'
			], 403);
		}

		$workout = Workout::find($id);

		if (!$workout) {
			return response()->json([
				'success' => false,
				'message' => 'Workout not found'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'user_id' => 'sometimes|exists:users,_id',
			'name' => 'sometimes|string|max:255',
			'description' => 'nullable|string',
			'scheduled_date' => 'sometimes|date',
			'duration_minutes' => 'nullable|integer|min:1',
			'difficulty_level' => 'nullable|in:beginner,intermediate,advanced',
			'is_completed' => 'sometimes|boolean',
			'notes' => 'nullable|string',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		$workout->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Workout updated successfully',
			'data' => $workout
		]);
	}
}
