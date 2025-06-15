<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
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
			'preferences' => []
		]);

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json([
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
				'message' => 'Validation errors',
				'errors' => $validator->errors()
			], 422);
		}

		$user = User::where('email', $request->email)->first();

		if (!$user || !Hash::check($request->password, $user->password)) {
			throw ValidationException::withMessages([
				'email' => ['The provided credentials are incorrect.'],
			]);
		}

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json([
			'message' => 'Login successful',
			'user' => $user,
			'token' => $token
		]);
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();

		return response()->json([
			'message' => 'Logged out successfully'
		]);
	}

	public function user(Request $request)
	{
		return response()->json($request->user());
	}
}
