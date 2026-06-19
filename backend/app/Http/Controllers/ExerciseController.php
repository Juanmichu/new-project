<?php

namespace App\Http\Controllers;

use App\Http\Constants\Exercises;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Show the exercise list.
     */
    public function index(Request $request)
    {
        $exercises              = $this->getFilteredExercises($request);
        $muscleGroups           = $this->getMuscleGroups();
        $equipmentTypes         = $this->getEquipmentTypes();
        $difficulties           = $this->getDifficulties();
        $colorDifficultyLevels  = $this->getColorDifficultyLevels();

        return view('exercises.index', compact('exercises', 'muscleGroups', 'equipmentTypes' ,'difficulties', 'colorDifficultyLevels'));
    }

    /**
     * Show a specific exercise.
     */
    public function show(string $id)
    {
        $exercise               = $this->getExerciseById($id);
        $colorDifficultyLevels  = $this->getColorDifficultyLevels();

        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }

        $relatedExercises = $this->getRelatedExercises($exercise);

        return view('exercises.show', compact('exercise', 'relatedExercises', 'colorDifficultyLevels'));
    }

    /**
     * Show the form for creating a new exercise.
     */
    public function create()
    {
        $muscleGroups   = $this->getMuscleGroups();
        $difficulties   = $this->getDifficulties();
        $equipmentTypes = $this->getEquipmentTypes();

        return view('exercises.create', compact('muscleGroups', 'difficulties', 'equipmentTypes'));
    }

    /**
     * Save new exercise
     */
    public function store(Request $request)
    {
        $validated = $this->getValidatedExerciseData($request);

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

        $muscleGroups   = $this->getMuscleGroups();
        $difficulties   = $this->getDifficulties();
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

        $validated = $this->getValidatedExerciseData($request);

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
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        if($request->filled('muscle_groups')) {
            // En MongoDB la igualdad sobre un campo array coincide si el array contiene el valor.
            $query->where('muscle_groups', 'like', '%' . $request->input('muscle_groups') . '%');
        }
        if($request->filled('difficulty_level')) {
            $query->where('difficulty_level', $request->input('difficulty_level'));
        }
        if($request->filled('equipment_needed')) {
            $query->where('equipment_needed', 'like', '%' . $request->input('equipment_needed') . '%');
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
        return Exercises::MUSCLE_GROUPS;
    }

    private function getDifficulties(): array
    {
        return Exercises::DIFFICULTY_LEVELS;
    }

    private function getEquipmentTypes(): array
    {
        return Exercises::EQUIPMENT_TYPES;
    }

    private function searchExercises(string $query)
    {
        // Implementar búsqueda
        return Exercise::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getValidatedExerciseData(Request $request): array
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'muscle_groups'     => 'required|array',
            'difficulty_level'  => 'required|in:' . implode(',', Exercises::DIFFICULTY_LEVELS),
            'equipment_needed'  => 'nullable|array',
            'instructions'      => 'required|array',
            'instructions.*'    => 'required|string'
        ]);

        // Equipment needed is retrieved as string with words possibly separated by commas.
        // First, we check if there are spaces and replace them with commas. Then, we save the array by exploding
        // string with commas as separator
        $validated['equipment_needed'] = !empty($validated['equipment_needed']) ? $validated['equipment_needed'] : [Exercises::DEFAULT_EQUIPMENT_TYPE];

        return $validated;
    }

    /**
     * @return string[]
     */
    private function getColorDifficultyLevels(): array
    {
        return Exercises::COLOR_DIFFICULTY_LEVELS;
    }
}
