<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
	public function index(Request $request)
	{
		$query = Exercise::where('is_active', true);

		if ($request->has('category')) {
			$query->where('category', $request->category);
		}

		if ($request->has('muscle_group')) {
			$query->where('muscle_groups', 'in', [$request->muscle_group]);
		}

		if ($request->has('difficulty')) {
			$query->where('difficulty_level', $request->difficulty);
		}

		$exercises = $query->paginate(20);

		return response()->json($exercises);
	}

	public function show($id)
	{
		$exercise = Exercise::where('is_active', true)
			->findOrFail($id);

		return response()->json($exercise);
	}

	public function categories()
	{
		$categories = Exercise::where('is_active', true)
			->distinct('category')
			->pluck('category');

		return response()->json($categories);
	}
}
