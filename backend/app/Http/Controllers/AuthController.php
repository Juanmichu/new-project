<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
// app/Http/Controllers/AuthController.php
	public function login(Request $request)
	{
		if (!Auth::attempt($request->only('email', 'password'))) {
			return response()->json(['message' => 'Unauthorized'], 401);
		}

		return response()->json([
			'token' => $request->user()->createToken('auth_token')->plainTextToken,
			'user' => $request->user()
		]);
	}

}
