{{--
    Shared create/edit form for coach workouts.
    Expects: $action (URL), $clients, $exercises, $difficulties, and optional $workout.
--}}
@php
    $isEdit = isset($workout);
    // Rows to pre-render: old input (after validation errors) > existing workout > one blank row.
    if (old('exercises')) {
        $rows = old('exercises');
    } elseif ($isEdit) {
        $rows = $workout->exercises->map(fn ($we) => [
            'exercise_id' => $we->exercise_id,
            'sets' => $we->sets,
            'reps' => $we->reps,
            'rest_time' => $we->rest_time,
            'weight' => $we->weight,
            'duration' => $we->duration,
        ])->values()->all();
    } else {
        $rows = [];
    }
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PATCH')
    @endif

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Client *</label>
            <select id="user_id" name="user_id" class="form-select" required>
                <option value="">Select a client...</option>
                @foreach($clients as $client)
                    <option value="{{ $client->_id }}" {{ old('user_id', $isEdit ? $workout->user_id : '') === $client->_id ? 'selected' : '' }}>
                        {{ $client->name }} ({{ $client->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Workout Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $isEdit ? $workout->name : '') }}" class="form-input" required>
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="workout_date" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
            <input type="date" id="workout_date" name="workout_date"
                   value="{{ old('workout_date', $isEdit && $workout->workout_date ? \Illuminate\Support\Carbon::parse($workout->workout_date)->format('Y-m-d') : '') }}"
                   class="form-input" required>
            @error('workout_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="difficulty_level" class="block text-sm font-medium text-gray-700 mb-1">Difficulty</label>
            <select id="difficulty_level" name="difficulty_level" class="form-select">
                <option value="">Select...</option>
                @foreach($difficulties as $level)
                    <option value="{{ $level }}" {{ old('difficulty_level', $isEdit ? $workout->difficulty_level : '') === $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
            @error('difficulty_level')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="total_duration" class="block text-sm font-medium text-gray-700 mb-1">Total Duration (min)</label>
            <input type="number" min="0" id="total_duration" name="total_duration" value="{{ old('total_duration', $isEdit ? $workout->total_duration : '') }}" class="form-input">
            @error('total_duration')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="calories_burned" class="block text-sm font-medium text-gray-700 mb-1">Calories Burned</label>
            <input type="number" min="0" id="calories_burned" name="calories_burned" value="{{ old('calories_burned', $isEdit ? $workout->calories_burned : '') }}" class="form-input">
            @error('calories_burned')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="md:col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="2" class="form-input">{{ old('description', $isEdit ? $workout->description : '') }}</textarea>
            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="md:col-span-2">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea id="notes" name="notes" rows="2" class="form-input">{{ old('notes', $isEdit ? $workout->notes : '') }}</textarea>
            @error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <!-- Exercises builder -->
    <div class="mt-8">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-xl font-semibold text-gray-900">Exercises *</h2>
            <button type="button" onclick="addExerciseRow()" class="btn-secondary">+ Add Exercise</button>
        </div>
        @error('exercises')<p class="text-red-500 text-sm mb-2">{{ $message }}</p>@enderror

        <div id="exercises-container" class="space-y-3">
            @foreach($rows as $i => $row)
                <div class="exercise-row grid grid-cols-12 gap-2 items-end border border-gray-200 rounded-md p-3">
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Exercise</label>
                        <select name="exercises[{{ $i }}][exercise_id]" class="form-select" required>
                            <option value="">Select...</option>
                            @foreach($exercises as $exercise)
                                <option value="{{ $exercise->_id }}" {{ ($row['exercise_id'] ?? '') === $exercise->_id ? 'selected' : '' }}>{{ $exercise->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-4 md:col-span-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Sets</label>
                        <input type="number" min="1" name="exercises[{{ $i }}][sets]" value="{{ $row['sets'] ?? 3 }}" class="form-input" required>
                    </div>
                    <div class="col-span-4 md:col-span-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Reps</label>
                        <input type="number" min="1" name="exercises[{{ $i }}][reps]" value="{{ $row['reps'] ?? 12 }}" class="form-input" required>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Rest (s)</label>
                        <input type="number" min="0" name="exercises[{{ $i }}][rest_time]" value="{{ $row['rest_time'] ?? 60 }}" class="form-input">
                    </div>
                    <div class="col-span-4 md:col-span-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Weight</label>
                        <input type="number" min="0" step="0.5" name="exercises[{{ $i }}][weight]" value="{{ $row['weight'] ?? '' }}" class="form-input">
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Duration (s)</label>
                        <input type="number" min="0" name="exercises[{{ $i }}][duration]" value="{{ $row['duration'] ?? '' }}" class="form-input">
                    </div>
                    <div class="col-span-12 md:col-span-1 flex justify-end">
                        <button type="button" onclick="removeExerciseRow(this)" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">×</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-between mt-8">
        <a href="{{ route('workouts.index') }}" class="btn-secondary cursor-pointer">Cancel</a>
        <div class="space-x-2">
            <button type="submit" class="btn-primary bg-blue-600 px-6 py-2 font-semibold text-white rounded-md hover:bg-blue-700 transition cursor-pointer">
                {{ $isEdit ? 'Update Workout' : 'Create Workout' }}
            </button>
            @if($isEdit)
                <button type="button" onclick="confirmDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded cursor-pointer">Delete</button>
            @endif
        </div>
    </div>
</form>

@if($isEdit)
    <form id="delete-form" action="{{ route('workouts.destroy', $workout->_id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endif

<!-- Template for a new exercise row; __INDEX__ is replaced by the JS counter -->
<template id="exercise-row-template">
    <div class="exercise-row grid grid-cols-12 gap-2 items-end border border-gray-200 rounded-md p-3">
        <div class="col-span-12 md:col-span-4">
            <label class="block text-xs font-medium text-gray-600 mb-1">Exercise</label>
            <select name="exercises[__INDEX__][exercise_id]" class="form-select" required>
                <option value="">Select...</option>
                @foreach($exercises as $exercise)
                    <option value="{{ $exercise->_id }}">{{ $exercise->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 md:col-span-1">
            <label class="block text-xs font-medium text-gray-600 mb-1">Sets</label>
            <input type="number" min="1" name="exercises[__INDEX__][sets]" value="3" class="form-input" required>
        </div>
        <div class="col-span-4 md:col-span-1">
            <label class="block text-xs font-medium text-gray-600 mb-1">Reps</label>
            <input type="number" min="1" name="exercises[__INDEX__][reps]" value="12" class="form-input" required>
        </div>
        <div class="col-span-4 md:col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1">Rest (s)</label>
            <input type="number" min="0" name="exercises[__INDEX__][rest_time]" value="60" class="form-input">
        </div>
        <div class="col-span-4 md:col-span-1">
            <label class="block text-xs font-medium text-gray-600 mb-1">Weight</label>
            <input type="number" min="0" step="0.5" name="exercises[__INDEX__][weight]" class="form-input">
        </div>
        <div class="col-span-4 md:col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1">Duration (s)</label>
            <input type="number" min="0" name="exercises[__INDEX__][duration]" class="form-input">
        </div>
        <div class="col-span-12 md:col-span-1 flex justify-end">
            <button type="button" onclick="removeExerciseRow(this)" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">×</button>
        </div>
    </div>
</template>

<script>
    // Start the running index after any server-rendered rows.
    let exerciseRowIndex = {{ count($rows) }};

    function addExerciseRow() {
        const template = document.getElementById('exercise-row-template').innerHTML;
        const html = template.replace(/__INDEX__/g, exerciseRowIndex++);
        document.getElementById('exercises-container').insertAdjacentHTML('beforeend', html);
    }

    function removeExerciseRow(button) {
        button.closest('.exercise-row').remove();
    }

    // Ensure there is always at least one row to fill in.
    if (exerciseRowIndex === 0) {
        addExerciseRow();
    }

    @if($isEdit)
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this workout? This cannot be undone.')) {
            document.getElementById('delete-form').submit();
        }
    }
    @endif
</script>
