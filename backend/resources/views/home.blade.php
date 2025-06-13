@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Hero Section -->
    <div class="card mb-8">
        <div class="card-body text-center py-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                ¡Bienvenido a FitnessApp! 💪
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Tu aplicación completa para entrenamientos, ejercicios y consejos de fitness
            </p>
            @guest
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="btn-primary inline-block">
                        Comenzar Ahora
                    </a>
                    <a href="{{ route('exercises.index') }}" class="btn-secondary inline-block">
                        Ver Ejercicios
                    </a>
                </div>
            @else
                <div class="space-x-4">
                    <a href="{{ route('dashboard') }}" class="btn-primary inline-block">
                        Ir al Dashboard
                    </a>
                    <a href="{{ route('exercises.index') }}" class="btn-secondary inline-block">
                        Ver Ejercicios
                    </a>
                </div>
            @endguest
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="card-body text-center">
                <div class="text-4xl mb-4">🏋️‍♀️</div>
                <h3 class="text-xl font-semibold mb-2">Ejercicios Variados</h3>
                <p class="text-gray-600">
                    Accede a una amplia biblioteca de ejercicios para todos los niveles y objetivos.
                </p>
                <a href="{{ route('exercises.index') }}" class="btn-primary mt-4 inline-block">
                    Explorar Ejercicios
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <div class="text-4xl mb-4">📝</div>
                <h3 class="text-xl font-semibold mb-2">Blog de Fitness</h3>
                <p class="text-gray-600">
                    Lee artículos sobre nutrición, entrenamiento y consejos para mejorar tu forma física.
                </p>
                <a href="{{ route('blog.index') }}" class="btn-primary mt-4 inline-block">
                    Leer Blog
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-xl font-semibold mb-2">Seguimiento Personal</h3>
                <p class="text-gray-600">
                    Registra tu progreso y mantén un seguimiento detallado de tus entrenamientos.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary mt-4 inline-block">
                        Ver Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary mt-4 inline-block">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Latest Exercises -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-2xl font-bold">Ejercicios Destacados</h2>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $featuredExercises = [
                        ['name' => 'Flexiones', 'muscle' => 'Pecho', 'difficulty' => 'Intermedio'],
                        ['name' => 'Sentadillas', 'muscle' => 'Piernas', 'difficulty' => 'Principiante'],
                        ['name' => 'Dominadas', 'muscle' => 'Espalda', 'difficulty' => 'Avanzado'],
                        ['name' => 'Plancha', 'muscle' => 'Core', 'difficulty' => 'Intermedio'],
                    ];
                @endphp

                @foreach($featuredExercises as $exercise)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900">{{ $exercise['name'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $exercise['muscle'] }}</p>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-2">
                            {{ $exercise['difficulty'] }}
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('exercises.index') }}" class="btn-primary">
                    Ver Todos los Ejercicios
                </a>
            </div>
        </div>
    </div>
</div>
@endsection