<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	/**
	 * Create a new AuthController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
			'age' => 'nullable|integer|min:13|max:120',
			'weight' => 'nullable|numeric|min:30|max:500',
			'height' => 'nullable|numeric|min:100|max:250',
			'fitness_level' => 'nullable|in:beginner,intermediate,advanced',
			'goals' => 'nullable|array'
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation errors',
				'errors' => $validator->errors()
			], 422);
		}

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'age' => $request->age,
			'weight' => $request->weight,
			'height' => $request->height,
			'fitness_level' => $request->fitness_level ?? 'beginner',
			'goals' => $request->goals ?? [],
			'preferences' => [],
			'role' => 'user',
			'is_active' => true
		]);

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json([
			'success' => true,
			'message' => 'User registered successfully',
			'user' => $user,
			'token' => $token
		], 201);
	}

	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'message' => 'Validation errors',
				'errors' => $validator->errors()
			], 422);
		}

		$user = User::where('email', $request->email)->first();

		if (!$user || !Hash::check($request->password, $user->password)) {
			return response()->json([
				'success' => false,
				'message' => 'Invalid credentials'
			], 401);
		}

		if (!$user->is_active) {
			return response()->json([
				'success' => false,
				'message' => 'Account is inactive'
			], 401);
		}

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json([
			'success' => true,
			'message' => 'Login successful',
			'user' => $user,
			'token' => $token
		]);
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();

		return response()->json([
			'success' => true,
			'message' => 'Logged out successfully'
		]);
	}

	public function user(Request $request)
	{
		return response()->json([
			'success' => true,
			'user' => $request->user()
		]);
	}

	public function updateProfile(Request $request)
	{
		$user = $request->user();

		$validator = Validator::make($request->all(), [
			'name' => 'sometimes|string|max:255',
			'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->_id,
			'current_password' => 'required_with:password|string',
			'password' => 'nullable|string|min:8|confirmed',
			'age' => 'sometimes|integer|min:13|max:120',
			'weight' => 'sometimes|numeric|min:30|max:500',
			'height' => 'sometimes|numeric|min:100|max:250',
			'fitness_level' => 'sometimes|in:beginner,intermediate,advanced',
			'goals' => 'sometimes|array'
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

		$data = $request->only(['name', 'email', 'age', 'weight', 'height', 'fitness_level', 'goals']);

		if ($request->filled('password')) {
			$data['password'] = Hash::make($request->password);
		}

		$user->update($data);

		return response()->json([
			'success' => true,
			'message' => 'Profile updated successfully',
			'user' => $user->fresh()
		]);
	}
}
