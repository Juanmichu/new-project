<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
	public function index()
	{
		return Exercise::all();
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'muscle_group' => 'required|string',
			'equipment' => 'required|string',
			'difficulty' => 'required|string'
		]);

		return Exercise::create($validated);
	}

	public function show($id)
	{
		return Exercise::findOrFail($id);
	}

	public function update(Request $request, $id)
	{
		$exercise = Exercise::findOrFail($id);

		$validated = $request->validate([
			'name' => 'sometimes|string|max:255',
			'description' => 'nullable|string',
			'muscle_group' => 'sometimes|string',
			'equipment' => 'sometimes|string',
			'difficulty' => 'sometimes|string'
		]);

		$exercise->update($validated);
		return $exercise;
	}

	public function destroy($id)
	{
		Exercise::findOrFail($id)->delete();
		return response()->noContent();
	}
}
