<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Mostrar lista de ejercicios con filtros
     */
    public function index(Request $request)
    {
        $exercises = $this->getFilteredExercises($request);
        $muscleGroups = $this->getMuscleGroups();
        $difficulties = $this->getDifficulties();
        
        return view('exercises.index', compact('exercises', 'muscleGroups', 'difficulties'));
    }
    
    /**
     * Mostrar un ejercicio específico
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
     * Mostrar formulario para crear ejercicio
     */
    public function create()
    {
        $muscleGroups = $this->getMuscleGroups();
        $difficulties = $this->getDifficulties();
        $equipmentTypes = $this->getEquipmentTypes();
        
        return view('exercises.create', compact('muscleGroups', 'difficulties', 'equipmentTypes'));
    }
    
    /**
     * Guardar nuevo ejercicio
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
        // Exercise::create($validated);
        
        return redirect()->route('exercises.index')
            ->with('success', 'Ejercicio creado exitosamente');
    }
    
    /**
     * Mostrar formulario de edición
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
     * Actualizar ejercicio
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
        
        return redirect()->route('exercises.show', $id)
            ->with('success', 'Ejercicio actualizado exitosamente');
    }
    
    /**
     * Eliminar ejercicio
     */
    public function destroy($id)
    {
        $exercise = $this->getExerciseById($id);
        
        if (!$exercise) {
            abort(404, 'Ejercicio no encontrado');
        }
        
        // Aquí eliminarías de la base de datos
        
        return redirect()->route('exercises.index')
            ->with('success', 'Ejercicio eliminado exitosamente');
    }
    
    /**
     * Alternar favorito
     */
    public function toggleFavorite($id)
    {
        // Lógica para agregar/quitar de favoritos
        
        return response()->json([
            'success' => true,
            'message' => 'Favorito actualizado',
            'is_favorite' => true // o false
        ]);
    }
    
    /**
     * Buscar ejercicios (API)
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
        // Datos estáticos por ahora, luego conectarás con BD
        $allExercises = [
            [
                'id' => 1,
                'name' => 'Flexiones',
                'muscle_group' => 'pecho',
                'difficulty' => 'intermedio',
                'description' => 'Ejercicio básico para desarrollar la fuerza del tren superior.',
                'equipment' => 'Sin equipo'
            ],
            [
                'id' => 2,
                'name' => 'Sentadillas',
                'muscle_group' => 'piernas',
                'difficulty' => 'principiante',
                'description' => 'Ejercicio fundamental para fortalecer las piernas y glúteos.',
                'equipment' => 'Sin equipo'
            ],
            [
                'id' => 3,
                'name' => 'Dominadas',
                'muscle_group' => 'espalda',
                'difficulty' => 'avanzado',
                'description' => 'Ejercicio completo para el desarrollo de la espalda y brazos.',
                'equipment' => 'Barra de dominadas'
            ],
            [
                'id' => 4,
                'name' => 'Plancha',
                'muscle_group' => 'core',
                'difficulty' => 'intermedio',
                'description' => 'Ejercicio isométrico para fortalecer el core.',
                'equipment' => 'Sin equipo'
            ],
            [
                'id' => 5,
                'name' => 'Press de Banca',
                'muscle_group' => 'pecho',
                'difficulty' => 'intermedio',
                'description' => 'Ejercicio clásico para el desarrollo del pecho.',
                'equipment' => 'Banca y barra'
            ],
            [
                'id' => 6,
                'name' => 'Peso Muerto',
                'muscle_group' => 'espalda',
                'difficulty' => 'avanzado',
                'description' => 'Ejercicio compuesto para trabajar múltiples grupos musculares.',
                'equipment' => 'Barra y discos'
            ]
        ];
        
        // Aplicar filtros
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allExercises = array_filter($allExercises, function($exercise) use ($search) {
                return strpos(strtolower($exercise['name']), $search) !== false;
            });
        }
        
        if ($request->filled('muscle_group')) {
            $allExercises = array_filter($allExercises, function($exercise) use ($request) {
                return $exercise['muscle_group'] === $request->muscle_group;
            });
        }
        
        if ($request->filled('difficulty')) {
            $allExercises = array_filter($allExercises, function($exercise) use ($request) {
                return $exercise['difficulty'] === $request->difficulty;
            });
        }
        
        return array_values($allExercises);
    }
    
    private function getExerciseById($id)
    {
        $exercises = [
            1 => [
                'id' => 1,
                'name' => 'Flexiones',
                'muscle_group' => 'Pecho',
                'difficulty' => 'Intermedio',
                'description' => 'Las flexiones son un ejercicio básico y fundamental para desarrollar la fuerza del tren superior, especialmente el pecho, hombros y tríceps.',
                'equipment' => 'Sin equipo',
                'instructions' => [
                    'Colócate en posición de plancha con las manos apoyadas en el suelo, separadas al ancho de los hombros.',
                    'Mantén el cuerpo recto desde la cabeza hasta los talones, contrayendo el core.',
                    'Desciende lentamente hasta que el pecho casi toque el suelo.',
                    'Empuja el cuerpo hacia arriba hasta la posición inicial.',
                    'Repite el movimiento manteniendo la forma correcta.'
                ],
                'muscles_worked' => [
                    ['name' => 'Pectorales', 'type' => 'Principal'],
                    ['name' => 'Tríceps', 'type' => 'Secundario'],
                    ['name' => 'Deltoides anterior', 'type' => 'Secundario'],
                    ['name' => 'Core', 'type' => 'Estabilizador']
                ],
                'recommendations' => [
                    'repetitions' => '8-15 repeticiones',
                    'sets' => '3-4 series',
                    'rest' => '60-90 segundos',
                    'frequency' => '2-3 veces por semana'
                ]
            ]
        ];
        
        return $exercises[$id] ?? null;
    }
    
    private function getRelatedExercises($exercise)
    {
        return [
            ['id' => 2, 'name' => 'Press de banca', 'muscle_group' => 'Pecho'],
            ['id' => 3, 'name' => 'Flexiones diamante', 'muscle_group' => 'Pecho'],
            ['id' => 4, 'name' => 'Flexiones inclinadas', 'muscle_group' => 'Pecho']
        ];
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