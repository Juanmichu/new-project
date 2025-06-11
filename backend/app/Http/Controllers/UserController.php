<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
		$this->middleware('admin')->except(['profile', 'updateProfile']);
	}

	/**
	 * Display a listing of users (Admin only).
	 */
	public function index(Request $request)
	{
		$query = User::query();

		// Search by name or email
		if ($request->has('search')) {
			$search = $request->search;
			$query->where(function($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
					->orWhere('email', 'like', "%{$search}%");
			});
		}

		// Filter by role
		if ($request->has('role')) {
			$query->where('role', $request->role);
		}

		// Filter by status
		if ($request->has('is_active')) {
			$query->where('is_active', $request->boolean('is_active'));
		}

		$users = $query->orderBy('created_at', 'desc')->paginate(15);

		return response()->json([
			'success' => true,
			'data' => $users
		]);
	}

	/**
	 * Store a newly created user (Admin only).
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
			'role' => 'required|in:admin,user',
			'is_active' => 'boolean',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'role' => $request->role,
			'is_active' => $request->is_active ?? true,
		]);

		return response()->json([
			'success' => true,
			'message' => 'User created successfully',
			'data' => $user
		], 201);
	}

	/**
	 * Display the specified user (Admin only).
	 */
	public function show($id)
	{
		$user = User::with('workouts')->find($id);

		if (!$user) {
			return response()->json([
				'success' => false,
				'message' => 'User not found'
			], 404);
		}

		return response()->json([
			'success' => true,
			'data' => $user
		]);
	}

	/**
	 * Update the specified user (Admin only).
	 */
	public function update(Request $request, $id)
	{
		$user = User::find($id);

		if (!$user) {
			return response()->json([
				'success' => false,
				'message' => 'User not found'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'name' => 'sometimes|string|max:255',
			'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
			'password' => 'nullable|string|min:8|confirmed',
			'role' => 'sometimes|in:admin,user',
			'is_active' => 'sometimes|boolean',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		$data = $request->except(['password', 'password_confirmation']);

		if ($request->filled('password')) {
			$data['password'] = Hash::make($request->password);
		}

		$user->update($data);

		return response()->json([
			'success' => true,
			'message' => 'User updated successfully',
			'data' => $user
		]);
	}

	/**
	 * Remove the specified user (Admin only).
	 */
	public function destroy($id)
	{
		$user = User::find($id);

		if (!$user) {
			return response()->json([
				'success' => false,
				'message' => 'User not found'
			], 404);
		}

		// Prevent admin from deleting themselves
		if ($user->id === auth()->id()) {
			return response()->json([
				'success' => false,
				'message' => 'Cannot delete your own account'
			], 403);
		}

		// Delete user's workouts and exercises
		foreach ($user->workouts as $workout) {
			$workout->exercises()->delete();
			$workout->delete();
		}

		$user->delete();

		return response()->json([
			'success' => true,
			'message' => 'User deleted successfully'
		]);
	}

	/**
	 * Get user profile (authenticated user).
	 */
	public function profile()
	{
		$user = auth()->user();
		$user->load(['workouts' => function($query) {
			$query->orderBy('scheduled_date', 'desc')->limit(5);
		}]);

		return response()->json([
			'success' => true,
			'data' => $user
		]);
	}

	/**
	 * Update user profile (authenticated user).
	 */
	public function updateProfile(Request $request)
	{
		$user = auth()->user();

		$validator = Validator::make($request->all(), [
			'name' => 'sometimes|string|max:255',
			'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
			'current_password' => 'required_with:password|string',
			'password' => 'nullable|string|min:8|confirmed',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		// Check current password if changing password
		if ($request->filled('password')) {
			if (!Hash::check($request->current_password, $user->password)) {
				return response()->json([
					'success' => false,
					'message' => 'Current password is incorrect'
				], 422);
			}
		}

		$data = $request->only(['name', 'email']);

		if ($request->filled('password')) {
			$data['password'] = Hash::make($request->password);
		}

		$user->update($data);

		return response()->json([
			'success' => true,
			'message' => 'Profile updated successfully',
			'data' => $user
		]);
	}
}
