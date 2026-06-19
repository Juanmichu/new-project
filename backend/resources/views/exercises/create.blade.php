@extends('layouts.app')

@section('title', 'Crear Ejercicio')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('exercises.index') }}" class="hover:text-blue-600">Exercises</a></li>
            <li>/</li>
            <li class="text-gray-900">Create exercise</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card mb-6">
        <div class="card-body">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create new exercise</h1>
            <p class="text-gray-600">Add a new exercise to the library</p>
        </div>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('exercises.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Información básica -->
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Exercise Name *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-input" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="muscle_group" class="block text-sm font-medium text-gray-700 mb-1">
                                Muscle Group *
                            </label>
                            <select id="muscle_group" name="muscle_groups[]" class="form-select" required multiple>
                                <option value="">Select...</option>
                                @foreach($muscleGroups as $group)
                                    <option value="{{ $group }}" {{ old('muscle_groups') == $group ? 'selected' : '' }}>
                                        {{ ucfirst($group) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('muscle_groups')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-1">
                                Difficulty *
                            </label>
                            <select id="difficulty" name="difficulty_level" class="form-select" required>
                                <option value="">Select...</option>
                                @foreach($difficulties as $level)
                                    <option value="{{ $level }}" {{ old('difficulty_level') == $level ? 'selected' : '' }}>
                                        {{ ucfirst($level) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('difficulty_level')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="equipment" class="block text-sm font-medium text-gray-700 mb-1">
                               Required Equipment.*
                            </label>
                            <select id="equipment"
                                   name="equipment_needed[]"
                                   value="{{ old('equipment_needed') }}"
                                   placeholder="I.e: None, Dumbbells, PullUpBar..."
                                   class="form-select"
                                   multiple
                            >
                                @foreach($equipmentTypes as $equipment)
                                    <option value="{{ $equipment }}" {{ in_array($equipment, old('equipment_needed', $exercise['equipment_needed'] ?? [])) ? 'selected' : '' }}>{{ $equipment }}</option>
                                @endforeach
                            </select>
                            @error('equipment_needed')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción e instrucciones -->
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description *
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-input" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Instructions *
                            </label>
                            <div id="instructions-container">
                                @if(old('instructions'))
                                    @foreach(old('instructions') as $index => $instruction)
                                        <div class="instruction-item flex mb-2">
                                            <input type="text" name="instructions[]" value="{{ $instruction }}"
                                                   class="form-input flex-1" placeholder="Paso {{ $index + 1 }}...">
                                            <button type="button" onclick="removeInstruction(this)"
                                                    class="ml-2 btn-secondary px-2">×</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="instruction-item flex mb-2">
                                        <input type="text" name="instructions[]"
                                               class="form-input flex-1" placeholder="Paso 1...">
                                        <button type="button" onclick="removeInstruction(this)"
                                                class="ml-2 btn-secondary px-2">×</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addInstruction()" class="btn-secondary mt-2">
                                + Add Step
                            </button>
                            @error('instructions')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-between mt-8">
                    <a href="{{ route('exercises.index') }}" class="btn-secondary cursor-pointer">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary px-6 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition cursor-pointer">
                        Create Exercise
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addInstruction() {
    const container = document.getElementById('instructions-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'instruction-item flex mb-2';
    div.innerHTML = `
        <input type="text" name="instructions[]"
               class="form-input flex-1" placeholder="Paso ${count}...">
        <button type="button" onclick="removeInstruction(this)"
                class="ml-2 btn-secondary px-2">×</button>
    `;
    container.appendChild(div);
}

function removeInstruction(button) {
    if (document.querySelectorAll('.instruction-item').length > 1) {
        button.parentElement.remove();
    }
}
</script>
@endsection
