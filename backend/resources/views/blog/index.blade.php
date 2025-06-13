@extends('layouts.app')

@section('title', 'Blog de Fitness')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Header -->
    <div class="card mb-6">
        <div class="card-body text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Blog de Fitness</h1>
            <p class="text-gray-600">Consejos, nutrición y todo sobre el mundo del fitness</p>
        </div>
    </div>

    <!-- Featured Article -->
    <div class="card mb-8">
        <div class="card-body">
            <div class="flex items-center mb-2">
                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Destacado</span>
                <span class="mx-2 text-gray-400">•</span>
                <span class="text-sm text-gray-600">15 de Junio, 2025</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">
                <a href="{{ route('blog.show', 1) }}" class="hover:text-blue-600">
                    Guía Completa: Cómo Empezar en el Gimnasio
                </a>
            </h2>
            <p class="text-gray-600 mb-4">
                Si eres principiante y quieres comenzar tu journey fitness, esta guía te dará todas las 
                herramientas necesarias para empezar de forma segura y efectiva...
            </p>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Por: Admin</span>
                    <span class="text-sm text-gray-600">Lectura: 5 min</span>
                </div>
                <a href="{{ route('blog.show', 1) }}" class="btn-primary">
                    Leer Más
                </a>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-lg font-semibold mb-3">Categorías</h3>
            <div class="flex flex-wrap gap-2">
                <a href="?category=all" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200">
                    Todos
                </a>
                <a href="?category=ejercicios" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-gray-200">
                    Ejercicios
                </a>
                <a href="?category=nutricion" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-gray-200">
                    Nutrición
                </a>
                <a href="?category=consejos" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-gray-200">
                    Consejos
                </a>
                <a href="?category=rutinas" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-gray-200">
                    Rutinas
                </a>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $articles = [
                [
                    'id' => 1,
                    'title' => 'Los 10 Mejores Ejercicios para Principiantes',
                    'excerpt' => 'Descubre los ejercicios fundamentales que todo principiante debe conocer.',
                    'category' => 'Ejercicios',
                    'read_time' => '4 min',
                    'date' => '14 Jun 2025',
                    'author' => 'Dr. Fitness'
                ],
                [
                    'id' => 2,
                    'title' => 'Nutrición Pre y Post Entrenamiento',
                    'excerpt' => 'Aprende qué comer antes y después de entrenar para maximizar tus resultados.',
                    'category' => 'Nutrición',
                    'read_time' => '6 min',
                    'date' => '13 Jun 2025',
                    'author' => 'Nutri Coach'
                ],
                [
                    'id' => 3,
                    'title' => 'Rutina de 4 Semanas para Quemar Grasa',
                    'excerpt' => 'Un plan completo para transformar tu cuerpo en solo 4 semanas.',
                    'category' => 'Rutinas',
                    'read_time' => '8 min',
                    'date' => '12 Jun 2025',
                    'author' => 'Trainer Pro'
                ],
                [
                    'id' => 4,
                    'title' => 'Cómo Evitar Lesiones en el Gimnasio',
                    'excerpt' => 'Consejos esenciales para entrenar de forma segura y prevenir lesiones.',
                    'category' => 'Consejos',
                    'read_time' => '5 min',
                    'date' => '11 Jun 2025',
                    'author' => 'Dr. Fitness'
                ],
                [
                    'id' => 5,
                    'title' => 'Suplementos: ¿Necesarios o Marketing?',
                    'excerpt' => 'La verdad sobre los suplementos deportivos y cuáles realmente valen la pena.',
                    'category' => 'Nutrición',
                    'read_time' => '7 min',
                    'date' => '10 Jun 2025',
                    'author' => 'Nutri Coach'
                ],
                [
                    'id' => 6,
                    'title' => 'Ejercicios en Casa: Sin Excusas',
                    'excerpt' => 'Una rutina completa que puedes hacer en casa sin ningún equipo.',
                    'category' => 'Ejercicios',
                    'read_time' => '5 min',
                    'date' => '9 Jun 2025',
                    'author' => 'Home Trainer'
                ]
            ];
        @endphp

        @foreach($articles as $article)
            <article class="card hover:shadow-lg transition-shadow">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $article['category'] }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $article['date'] }}</span>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="{{ route('blog.show', $article['id']) }}" class="hover:text-blue-600">
                            {{ $article['title'] }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4">{{ $article['excerpt'] }}</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <span>Por: {{ $article['author'] }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $article['read_time'] }}</span>
                        </div>
                        <a href="{{ route('blog.show', $article['id']) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Leer más →
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <!-- Load More -->
    <div class="text-center mt-8">
        <button class="btn-primary">
            Cargar Más Artículos
        </button>
    </div>
</div>
@endsection