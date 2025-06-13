<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard del usuario
     */
    public function index()
    {
        $user = Auth::user();
        $stats = $this->getUserStats($user);
        $recentActivity = $this->getRecentActivity($user);
        $quickActions = $this->getQuickActions();
        
        return view('dashboard', compact('user', 'stats', 'recentActivity', 'quickActions'));
    }
    
    /**
     * Obtener estadísticas del usuario (API)
     */
    public function getStats(Request $request)
    {
        $user = Auth::user();
        $stats = $this->getUserStats($user);
        
        return response()->json($stats);
    }
    
    /**
     * Registrar actividad del usuario (API)
     */
    public function logActivity(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'description' => 'required|string',
            'data' => 'nullable|array'
        ]);
        
        // Aquí guardarías la actividad en la base de datos
        
        return response()->json([
            'success' => true,
            'message' => 'Actividad registrada exitosamente'
        ]);
    }
    
    /**
     * Métodos helper privados
     */
    private function getUserStats($user)
    {
        // Por ahora datos estáticos, luego conectarás con BD
        return [
            'workouts_completed' => 0,
            'favorite_exercises' => 0,
            'active_days' => 0,
            'goals_achieved' => 0,
            'total_time_trained' => '0 horas',
            'calories_burned' => 0,
            'current_streak' => 0,
            'longest_streak' => 0
        ];
    }
    
    private function getRecentActivity($user)
    {
        // Datos de ejemplo de actividad reciente
        return [
            [
                'type' => 'workout',
                'description' => 'Completó rutina de pecho',
                'date' => now()->subHours(2),
                'icon' => '🏋️‍♀️'
            ],
            [
                'type' => 'exercise',
                'description' => 'Agregó flexiones a favoritos',
                'date' => now()->subDay(),
                'icon' => '❤️'
            ]
        ];
    }
    
    private function getQuickActions()
    {
        return [
            [
                'title' => 'Explorar Ejercicios',
                'description' => 'Descubre nuevos ejercicios',
                'url' => route('exercises.index'),
                'icon' => '🏋️‍♀️',
                'color' => 'blue'
            ],
            [
                'title' => 'Leer Blog',
                'description' => 'Consejos y artículos',
                'url' => route('blog.index'),
                'icon' => '📝',
                'color' => 'green'
            ],
            [
                'title' => 'Configurar Perfil',
                'description' => 'Personaliza tu cuenta',
                'url' => route('profile'),
                'icon' => '⚙️',
                'color' => 'purple'
            ]
        ];
    }
}