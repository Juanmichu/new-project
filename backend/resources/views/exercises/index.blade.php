
@extends('layouts.app')

@section('title', 'Ejercicios')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Header -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Exercises Library</h1>
                    <p class="text-gray-600">Find the perfect exercise for your training</p>
                </div>
                @auth
                    <a href="{{ route('exercises.create') }}" class="btn-primary mt-4 md:mt-0">
                        Add Exercise
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('exercises.index') }}" class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nombre del ejercicio..."
                           class="form-input">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grupo Muscular</label>
                    <select name="muscle_group" class="form-input">
                        <option value="">Todos</option>
                        <option value="pecho" {{ request('muscle_group') == 'pecho' ? 'selected' : '' }}>Pecho</option>
                        <option value="espalda" {{ request('muscle_group') == 'espalda' ? 'selected' : '' }}>Espalda</option>
                        <option value="piernas" {{ request('muscle_group') == 'piernas' ? 'selected' : '' }}>Piernas</option>
                        <option value="brazos" {{ request('muscle_group') == 'brazos' ? 'selected' : '' }}>Brazos</option>
                        <option value="core" {{ request('muscle_group') == 'core' ? 'selected' : '' }}>Core</option>
                        <option value="hombros" {{ request('muscle_group') == 'hombros' ? 'selected' : '' }}>Hombros</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dificultad</label>
                    <select name="difficulty" class="form-input">
                        <option value="">Todas</option>
                        <option value="principiante" {{ request('difficulty') == 'principiante' ? 'selected' : '' }}>Principiante</option>
                        <option value="intermedio" {{ request('difficulty') == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="avanzado" {{ request('difficulty') == 'avanzado' ? 'selected' : '' }}>Avanzado</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Exercises Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($exercises as $exercise)
            <div class="card hover:shadow-lg transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $exercise['name'] }}</h3>
                        @if(isset($exercise['difficulty_level']))
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $exercise['difficulty_level']}}
                        </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        @if(isset($exercise['muscle_groups']))
                        <span class="inline-block bg-blue-600 text-white text-sm px-2 py-1 rounded mr-2">
                            {{ implode(', ', $exercise['muscle_groups']) }}
                        </span>
                        @endif
                        @if(isset($exercise['equipment_needed']))
                        <span class="inline-block bg-green-100 text-green-800 text-sm px-2 py-1 rounded">
                            {{ $exercise['equipment_needed'] ? implode(', ', $exercise['equipment_needed']) : 'None' }}
                        </span>
                        @endif
                    </div>

                    <p class="text-gray-600 mb-4">{{ $exercise['description'] ?? '' }}</p>

                    <div class="flex space-x-2">
                        <a href="{{ route('exercises.show', $exercise['id']) }}" class="btn-primary flex-1 text-center">
                            Ver Detalles
                        </a>
                        @auth
                            <button class="btn-secondary">
                                @php
                                    // Añadir funcionalidad al botón favoritos
                                @endphp
                                ❤️
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- No results -->
    @if(empty($exercises))
        <div class="card">
            <div class="card-body text-center py-12">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-semibold mb-2">No exercises found</h3>
                <p class="text-gray-600 mb-4">Try adjusting the search filters</p>
                <a href="{{ route('exercises.index') }}" class="btn-primary">
                    View All Exercises
                </a>
            </div>
        </div>
    @endif

    <!-- Pagination with page numbers and navigation. Using bootstrap 5. Check app/Providers/AppServiceProvider.php -->
    {{ $exercises->links() }}

</div>
@endsection
