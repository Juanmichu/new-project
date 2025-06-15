<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
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

		try {
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'age' => $request->age,
				'weight' => $request->weight,
				'height' => $request->height,
				'fitness_level' => $request->fitness_level ?? 'beginner',
				'goals' => $request->goals ?? [],
				'preferences' => []
			]);

			$token = $user->createToken('auth_token')->plainTextToken;

			return response()->json([
				'success' => true,
				'message' => 'User registered successfully',
				'user' => $user,
				'token' => $token
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Registration failed: ' . $e->getMessage()
			], 500);
		}
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

		try {
			$user = User::where('email', $request->email)->first();

			if (!$user || !Hash::check($request->password, $user->password)) {
				return response()->json([
					'success' => false,
					'message' => 'Invalid credentials'
				], 401);
			}

			// Delete old tokens
			$user->tokens()->delete();

			$token = $user->createToken('auth_token')->plainTextToken;

			return response()->json([
				'success' => true,
				'message' => 'Login successful',
				'user' => $user,
				'token' => $token
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Login failed: ' . $e->getMessage()
			], 500);
		}
	}

	public function logout(Request $request)
	{
		try {
			$request->user()->currentAccessToken()->delete();

			return response()->json([
				'success' => true,
				'message' => 'Logged out successfully'
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Logout failed: ' . $e->getMessage()
			], 500);
		}
	}

	public function user(Request $request)
	{
		try {
			return response()->json([
				'success' => true,
				'user' => $request->user()
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Failed to get user: ' . $e->getMessage()
			], 500);
		}
	}
}
