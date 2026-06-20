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

        return view('dashboard', compact('user'));
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
}
