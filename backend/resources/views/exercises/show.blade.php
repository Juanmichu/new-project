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
            <li>{{ $exercise->name }}</li>
        </ol>
    </nav>

    <!-- Exercise Header -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-start">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $exercise->name }}</h1>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            {{ $exercise->difficulty_level }}
                        </span>
                        <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                            {{ implode(', ', $exercise->muscle_groups) }}
                        </span>
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                            {{ $exercise->equipment ?? 'No equipment' }}
                        </span>
                    </div>

                    <p class="text-gray-600 text-lg"> {{ $exercise->description }} </p>
                </div>

                @auth
                    <div class="mt-4 md:mt-0 flex space-x-2">
                        <button class="btn-secondary">
                            ❤️ Favorite
                        </button>
                        <a href="{{ route('exercises.edit', 1) }}" class="btn-primary">
                            Edit
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
                <h2 class="text-xl font-semibold">Instructions</h2>
            </div>
            <div class="card-body">
                <ol class="space-y-3">
                    @foreach ($exercise->instructions as $key => $instruction)
                        <li class="flex">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">{{ $key + 1 }}</span>
                            <span>{{ $instruction }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <!-- Details -->
        <div class="space-y-6">
            <!-- Muscles Worked -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Muscles Worked</h2>
                </div>
                <div class="card-body">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span> {{ $exercise->muscle_groups[0] }}</span>
                            <span class="text-blue-600 font-medium">Main</span>
                        </div>
                        @foreach (array_slice($exercise->muscle_groups, 1) as $muscle)
                            <div class="flex justify-between">
                                <span>{{ $muscle }}</span>
                                <span class="text-green-400">Secondary</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Line of work -->
            @if (isset($exercise['recommendations']))
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Line of Work</h2>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @foreach($exercise->recommendations as $recommendation)
                            <div>
                                <strong class="text-gray-900">Repetitions:</strong>
                                <span class="text-gray-600">{{ $recommendation['repetitions'] }}</span>
                            </div>
                            <div>
                                <strong class="text-gray-900">Sets:</strong>
                                <span class="text-gray-600">{{ $recommendation['sets'] }}</span>
                            </div>
                            <div>
                                <strong class="text-gray-900">Rest Time:</strong>
                                <span class="text-gray-600">{{ $recommendation['rest'] }}</span>
                            </div>
                            <div>
                                <strong class="text-gray-900">Frequency:</strong>
                                <span class="text-gray-600">{{ $recommendation['frequency'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

    <!-- Tips -->
    @if(isset($exercise['tips']))
    <div class="card mt-6">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Tips and Variations</h2>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">💡 Tips</h3>
                    <ul class="space-y-2 text-gray-600">
                        @foreach($exercise['tips'] as $tip)
                            <li>• {{ $tip }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">🔄 Variations</h3>
                    <ul class="space-y-2 text-gray-600">
                        @foreach($exercise['variations'] as $variation)
                            <li>• {{ $variation }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<!-- Navigation -->
<div class="mt-8 flex justify-between">
    <a href="{{ route('exercises.index') }}" class="btn-secondary">
        ← Back to Exercises
    </a>
    <a href="{{ route('exercises.show', 2) }}" class="btn-primary">
        Next Exercise →
    </a>
</div>
@endsection
