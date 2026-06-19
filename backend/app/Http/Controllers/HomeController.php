<?php

namespace App\Http\Controllers;

use App\Http\Constants\Exercises;
use App\Models\Exercise;

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
        $colorDifficultyLevels  = Exercises::COLOR_DIFFICULTY_LEVELS;
        $stats = $this->getGeneralStats();

        return view('home', compact('featuredExercises', 'colorDifficultyLevels'));
    }

    /**
     * Obtener ejercicios destacados para la página principal
     */
    private function getFeaturedExercises()
    {
        // Get 5 exercises marked as favorites
        return Exercise::where('is_favorite', true)->limit(5)->get()->toArray();
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
