<?php

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

// Exercise Routes
Route::apiResource('exercises', ExerciseController::class);

// Workout Routes
Route::apiResource('workouts', WorkoutController::class);

// Get workouts by user
Route::get('users/{userId}/workouts', function ($userId) {
	return Workout::where('user_id', $userId)->with('user')->get();
});

