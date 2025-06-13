<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar la página de inicio
     */
    public function index()
    {
        // Aquí puedes agregar lógica para mostrar ejercicios destacados,
        // estadísticas generales, etc.
        
        $featuredExercises = $this->getFeaturedExercises();
        $stats = $this->getGeneralStats();
        
        return view('home', compact('featuredExercises', 'stats'));
    }
    
    /**
     * Obtener ejercicios destacados para la página principal
     */
    private function getFeaturedExercises()
    {
        // Por ahora datos estáticos, luego conectarás con la base de datos
        return [
            [
                'id' => 1,
                'name' => 'Flexiones',
                'muscle_group' => 'Pecho',
                'difficulty' => 'Intermedio',
                'image' => null
            ],
            [
                'id' => 2,
                'name' => 'Sentadillas',
                'muscle_group' => 'Piernas', 
                'difficulty' => 'Principiante',
                'image' => null
            ],
            [
                'id' => 3,
                'name' => 'Dominadas',
                'muscle_group' => 'Espalda',
                'difficulty' => 'Avanzado',
                'image' => null
            ],
            [
                'id' => 4,
                'name' => 'Plancha',
                'muscle_group' => 'Core',
                'difficulty' => 'Intermedio', 
                'image' => null
            ]
        ];
    }
    
    /**
     * Obtener estadísticas generales
     */
    private function getGeneralStats()
    {
        return [
            'total_exercises' => 150,
            'total_users' => 1250,
            'total_workouts' => 5680,
            'blog_articles' => 45
        ];
    }
}