<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
	public function index()
	{
		return Workout::with('user')->get();
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'user_id' => 'required|exists:users,_id',
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'date' => 'required|date',
			'duration_minutes' => 'required|integer|min:1',
			'exercises' => 'required|array',
			'exercises.*.exercise_id' => 'required|exists:exercises,_id',
			'exercises.*.sets' => 'required|integer|min:1',
			'exercises.*.reps' => 'required|integer|min:1',
			'exercises.*.weight_kg' => 'nullable|numeric|min:0'
		]);

		return Workout::create($validated);
	}

	public function show($id)
	{
		return Workout::with('user')->findOrFail($id);
	}

	public function update(Request $request, $id)
	{
		$workout = Workout::findOrFail($id);

		$validated = $request->validate([
			'user_id' => 'sometimes|exists:users,_id',
			'name' => 'sometimes|string|max:255',
			'description' => 'nullable|string',
			'date' => 'sometimes|date',
			'duration_minutes' => 'sometimes|integer|min:1',
			'exercises' => 'sometimes|array',
			'exercises.*.exercise_id' => 'required_with:exercises|exists:exercises,_id',
			'exercises.*.sets' => 'required_with:exercises|integer|min:1',
			'exercises.*.reps' => 'required_with:exercises|integer|min:1',
			'exercises.*.weight_kg' => 'nullable|numeric|min:0'
		]);

		$workout->update($validated);
		return $workout;
	}

	public function destroy($id)
	{
		Workout::findOrFail($id)->delete();
		return response()->noContent();
	}
}
