@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Welcome Section -->
    <div class="card mb-6">
        <div class="card-body">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                ¡Hola, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-gray-600">
                Aquí tienes un resumen de tu actividad en FitnessApp
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">0</div>
                <p class="text-gray-600">Entrenamientos Completados</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">0</div>
                <p class="text-gray-600">Ejercicios Favoritos</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">0</div>
                <p class="text-gray-600">Días Activos</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">0</div>
                <p class="text-gray-600">Metas Alcanzadas</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Acciones Rápidas</h2>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <a href="{{ route('exercises.index') }}" class="block bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <div class="text-2xl mr-3">🏋️‍♀️</div>
                            <div>
                                <div class="font-medium">Explorar Ejercicios</div>
                                <div class="text-sm text-gray-600">Descubre nuevos ejercicios</div>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('blog.index') }}" class="block bg-green-50 hover:bg-green-100 p-3 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <div class="text-2xl mr-3">📝</div>
                            <div>
                                <div class="font-medium">Leer Blog</div>
                                <div class="text-sm text-gray-600">Consejos y artículos</div>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('profile') }}" class="block bg-purple-50 hover:bg-purple-100 p-3 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <div class="text-2xl mr-3">⚙️</div>
                            <div>
                                <div class="font-medium">Configurar Perfil</div>
                                <div class="text-sm text-gray-600">Personaliza tu cuenta</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Actividad Reciente</h2>
            </div>
            <div class="card-body">
                <div class="text-center text-gray-500 py-8">
                    <div class="text-4xl mb-4">📊</div>
                    <p>No hay actividad reciente</p>
                    <p class="text-sm">¡Comienza tu primer entrenamiento!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Chart Placeholder -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Progreso Semanal</h2>
        </div>
        <div class="card-body">
            <div class="text-center text-gray-500 py-12">
                <div class="text-6xl mb-4">📈</div>
                <p class="text-lg">Gráfico de Progreso</p>
                <p class="text-sm">Aquí aparecerá tu progreso cuando tengas datos registrados</p>
            </div>
        </div>
    </div>
</div>
@endsection