<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Show the exercises list.
     */
    public function index(Request $request)
    {
        $exercises = $this->getFilteredExercises($request);
        $muscleGroups = $this->getMuscleGroups();
        $difficulties = $this->getDifficulties();

        return view('exercises.index', compact('exercises', 'muscleGroups', 'difficulties'));
    }

    /**
     * Show a specific exercise.
     */
    public function show(string $id)
    {
        $exercise = $this->getExerciseById($id);

        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }

        $relatedExercises = $this->getRelatedExercises($exercise);

        return view('exercises.show', compact('exercise', 'relatedExercises'));
    }

    /**
     * Show the form for creating a new exercise.
     */
    public function create()
    {
        $muscleGroups = $this->getMuscleGroups();
        $difficulties = $this->getDifficulties();
        $equipmentTypes = $this->getEquipmentTypes();

        return view('exercises.create', compact('muscleGroups', 'difficulties', 'equipmentTypes'));
    }

    /**
     * Save new exercise
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'muscle_groups' => 'required|string',
            'difficulty_level' => 'required|in:Beginner,Intermediate,Advanced',
            'equipment_needed' => 'required|string',
            'instructions' => 'required|array',
            'instructions.*' => 'required|string'
        ]);

        // El formulario envía un único grupo muscular; lo almacenamos como array.
        $validated['muscle_groups'] = [$validated['muscle_groups']];

        Exercise::create($validated);

        return redirect()->route('exercises.index')
            ->with('success', 'Ejercicio creado exitosamente');
    }

    /**
     * Show the form for editing an existing exercise.
     */
    public function edit(string $id)
    {
        $exercise = $this->getExerciseById($id);

        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }

        $muscleGroups = $this->getMuscleGroups();
        $difficulties = $this->getDifficulties();
        $equipmentTypes = $this->getEquipmentTypes();

        return view('exercises.edit', compact('exercise', 'muscleGroups', 'difficulties', 'equipmentTypes'));
    }

    /**
     * Update exercise
     */
    public function update(Request $request, string $id)
    {
        $exercise = $this->getExerciseById($id);

        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'muscle_groups' => 'required|string',
            'difficulty_level' => 'required|string',
            'equipment_needed' => 'nullable|array',
            'instructions' => 'required|array'
        ]);

        // El formulario envía un único grupo muscular; lo almacenamos como array.
        $validated['muscle_groups'] = [$validated['muscle_groups']];

        $exercise->update($validated);

        return redirect()->route('exercises.show', $id)
            ->with('success', 'Ejercicio actualizado exitosamente');
    }

    /**
     * Delete exercise
     */
    public function destroy(string $id)
    {
        $exercise = $this->getExerciseById($id);

        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }

        // Aquí eliminarías de la base de datos
        $exercise->delete();

        return redirect()->route('exercises.index')
            ->with('success', 'Ejercicio eliminado exitosamente');
    }

    /**
     * Toggle favorite condition to certain exercise
     */
    public function toggleFavorite(string $id)
    {
        // Lógica para agregar/quitar de favoritos
        $exercise = $this->getExerciseById($id);

        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }

        $exercise->is_favorite = !$exercise->is_favorite;
        $exercise->save();

        return response()->json([
            'success' => true,
            'message' => 'Favorito actualizado',
            'is_favorite' => $exercise->is_favorite
        ]);
    }

    /**
     * Search exercises (API)
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $exercises = $this->searchExercises($query);

        return response()->json($exercises);
    }

    /**
     * Métodos helper privados
     */
    private function getFilteredExercises(Request $request)
    {
        // Lógica de páginación y filtrado según los parámetros de la solicitud. Mantenemos la lógica de abajo.
        $query = Exercise::query();
        if($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }
        if($request->filled('muscle_groups')) {
            // En MongoDB la igualdad sobre un campo array coincide si el array contiene el valor.
            $query->where('muscle_groups', $request->get('muscle_groups'));
        }
        if($request->filled('difficulty_level')) {
            $query->where('difficulty_level', $request->get('difficulty_level'));
        }
        if($request->filled('equipment_needed')) {
            $query->where('equipment_needed', $request->get('equipment_needed'));
        }
        if($request->filled('is_favorite')) {
            $query->where('is_favorite', $request->boolean('is_favorite'));
        }

        return $query->paginate(10);
    }

    private function getExerciseById(string $id)
    {
        // Conecta con BBDD de mongo
        $exercise = Exercise::find($id);

        return $exercise ?? null;
    }

    private function getRelatedExercises(Exercise $exercise)
    {
        // Conecta con BBDD de mongo
        $muscleGroup = is_array($exercise->muscle_groups)
            ? ($exercise->muscle_groups[0] ?? null)
            : $exercise->muscle_groups;

        return Exercise::where('muscle_groups', $muscleGroup)
            ->where('id', '!=', $exercise->id)
            ->get();
    }

    private function getMuscleGroups(): array
    {
        return ['Chest', 'Back', 'Legs', 'Arms', 'Biceps', 'Triceps', 'Core', 'Shoulders', 'Full Body', 'Cardio', 'Glutes', 'Calves', 'Forearms', 'Neck'];
    }

    private function getDifficulties(): array
    {
        return ['Beginner', 'Intermediate', 'Advanced'];
    }

    private function getEquipmentTypes(): array
    {
        return ['None', 'Dumbbell', 'Pull Up Bar', 'Machine', 'Elastic Band', 'Bodyweight'];
    }

    private function searchExercises(string $query)
    {
        // Implementar búsqueda
        return Exercise::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();
    }
}
