@extends('layouts.app')

@section('title', 'Flexiones - Detalle')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Inicio</a></li>
            <li>/</li>
            <li><a href="{{ route('exercises.index') }}" class="hover:text-blue-600">Ejercicios</a></li>
            <li>/</li>
            <li class="text-gray-900">Flexiones</li>
        </ol>
    </nav>

    <!-- Exercise Header -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-start">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Flexiones</h1>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Intermedio
                        </span>
                        <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                            Pecho
                        </span>
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                            Sin equipo
                        </span>
                    </div>
                    
                    <p class="text-gray-600 text-lg">
                        Las flexiones son un ejercicio básico y fundamental para desarrollar la fuerza del tren superior, 
                        especialmente el pecho, hombros y tríceps.
                    </p>
                </div>
                
                @auth
                    <div class="mt-4 md:mt-0 flex space-x-2">
                        <button class="btn-secondary">
                            ❤️ Favorito
                        </button>
                        <a href="{{ route('exercises.edit', 1) }}" class="btn-primary">
                            Editar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Instructions -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Instrucciones</h2>
            </div>
            <div class="card-body">
                <ol class="space-y-3">
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">1</span>
                        <span>Colócate en posición de plancha con las manos apoyadas en el suelo, separadas al ancho de los hombros.</span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">2</span>
                        <span>Mantén el cuerpo recto desde la cabeza hasta los talones, contrayendo el core.</span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">3</span>
                        <span>Desciende lentamente hasta que el pecho casi toque el suelo.</span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">4</span>
                        <span>Empuja el cuerpo hacia arriba hasta la posición inicial.</span>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">5</span>
                        <span>Repite el movimiento manteniendo la forma correcta.</span>
                    </li>
                </ol>
            </div>
        </div>

        <!-- Details -->
        <div class="space-y-6">
            <!-- Muscles Worked -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Músculos Trabajados</h2>
                </div>
                <div class="card-body">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Pectorales</span>
                            <span class="text-blue-600 font-medium">Principal</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tríceps</span>
                            <span class="text-green-600 font-medium">Secundario</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Deltoides anterior</span>
                            <span class="text-green-600 font-medium">Secundario</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Core</span>
                            <span class="text-yellow-600 font-medium">Estabilizador</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommendations -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Recomendaciones</h2>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        <div>
                            <strong class="text-gray-900">Repeticiones:</strong>
                            <span class="text-gray-600">8-15 repeticiones</span>
                        </div>
                        <div>
                            <strong class="text-gray-900">Series:</strong>
                            <span class="text-gray-600">3-4 series</span>
                        </div>
                        <div>
                            <strong class="text-gray-900">Descanso:</strong>
                            <span class="text-gray-600">60-90 segundos</span>
                        </div>
                        <div>
                            <strong class="text-gray-900">Frecuencia:</strong>
                            <span class="text-gray-600">2-3 veces por semana</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips -->
    <div class="card mt-6">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Consejos y Variaciones</h2>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">💡 Consejos</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Mantén la mirada hacia abajo para alinear el cuello</li>
                        <li>• No dejes que las caderas se hundan o se eleven</li>
                        <li>• Respira de forma controlada durante el ejercicio</li>
                        <li>• Si es muy difícil, apoya las rodillas en el suelo</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">🔄 Variaciones</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Flexiones con rodillas (principiantes)</li>
                        <li>• Flexiones diamante (tríceps)</li>
                        <li>• Flexiones inclinadas (hombros)</li>
                        <li>• Flexiones con palmada (explosivas)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="mt-8 flex justify-between">
        <a href="{{ route('exercises.index') }}" class="btn-secondary">
            ← Volver a Ejercicios
        </a>
        <a href="{{ route('exercises.show', 2) }}" class="btn-primary">
            Siguiente Ejercicio →
        </a>
    </div>
</div>
@endsection