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
    public function show($id)
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
            'muscle_group' => 'required|string',
            'difficulty' => 'required|in:principiante,intermedio,avanzado',
            'equipment' => 'required|string',
            'instructions' => 'required|array',
            'instructions.*' => 'required|string'
        ]);

        // Aquí guardarías en la base de datos
        Exercise::create($validated);

        return redirect()->route('exercises.index')
            ->with('success', 'Ejercicio creado exitosamente');
    }

    /**
     * Show the form for editing an existing exercise.
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        $exercise = $this->getExerciseById($id);

        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'muscle_group' => 'required|string',
            'difficulty' => 'required|in:principiante,intermedio,avanzado',
            'equipment' => 'required|string',
            'instructions' => 'required|array'
        ]);

        // Aquí actualizarías en la base de datos
        $exercise->update($validated);

        return redirect()->route('exercises.show', $id)
            ->with('success', 'Ejercicio actualizado exitosamente');
    }

    /**
     * Delete exercise
     */
    public function destroy($id)
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
    public function toggleFavorite($id)
    {
        // Lógica para agregar/quitar de favoritos
        $exercise = $this->getExerciseById($id);
        $exercise->is_favorite = !$exercise->is_favorite;
        $exercise->update();

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
        $query = $request->get('q', '');
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
        if($request->has('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }
        if($request->has('muscle_group')) {
            $query->where('muscle_group', $request->get('muscle_group'));
        }
        if($request->has('difficulty')) {
            $query->where('difficulty', $request->get('difficulty'));
        }
        if($request->has('equipment')) {
            $query->where('equipment', $request->get('equipment'));
        }
        if($request->has('is_favorite')) {
            $query->where('is_favorite', $request->get('is_favorite'));
        }

        return $query->paginate(10);
    }

    private function getExerciseById($id)
    {
        // Conecta con BBDD de mongo
        $exercise = Exercise::find($id);

        return $exercise ?? null;
    }

    private function getRelatedExercises($exercise)
    {
        // Datos estáticos. Sustituir por conexión a base de datos
        /*return [
            ['id' => 2, 'name' => 'Press de banca', 'muscle_group' => 'Pecho'],
            ['id' => 3, 'name' => 'Flexiones diamante', 'muscle_group' => 'Pecho'],
            ['id' => 4, 'name' => 'Flexiones inclinadas', 'muscle_group' => 'Pecho']
        ];*/
        // Conecta con BBDD de mongo
        return Exercise::where('muscle_group', $exercise->muscle_group)
            ->where('id', '!=', $exercise->id)
            ->get();
    }

    private function getMuscleGroups()
    {
        return ['pecho', 'espalda', 'piernas', 'brazos', 'core', 'hombros'];
    }

    private function getDifficulties()
    {
        return ['principiante', 'intermedio', 'avanzado'];
    }

    private function getEquipmentTypes()
    {
        return ['Sin equipo', 'Mancuernas', 'Barra', 'Máquinas', 'Bandas elásticas', 'Peso corporal'];
    }

    private function searchExercises($query)
    {
        // Implementar búsqueda
        return [];
    }
}
