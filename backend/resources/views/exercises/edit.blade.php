
@extends('layouts.app')

@section('title', 'Editar Ejercicio')

@section('content')
	<div class="max-w-4xl mx-auto px-4">
		<!-- Breadcrumb -->
		<nav class="mb-6">
			<ol class="flex space-x-2 text-sm text-gray-600">
				<li><a href="{{ route('home') }}" class="hover:text-blue-600">Inicio</a></li>
				<li>/</li>
				<li><a href="{{ route('exercises.index') }}" class="hover:text-blue-600">Ejercicios</a></li>
				<li>/</li>
				<li><a href="{{ route('exercises.show', $exercise['id']) }}" class="hover:text-blue-600">{{ $exercise['name'] }}</a></li>
				<li>/</li>
				<li class="text-gray-900">Editar</li>
			</ol>
		</nav>

		<!-- Header -->
		<div class="card mb-6">
			<div class="card-body">
				<h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Ejercicio</h1>
				<p class="text-gray-600">Modificar información del ejercicio: {{ $exercise['name'] }}</p>
			</div>
		</div>

		<!-- Form -->
		<div class="card">
			<div class="card-body">
				<form action="{{ route('exercises.update', $exercise['id']) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PATCH')

					<div class="grid md:grid-cols-2 gap-6">
						<!-- Información básica -->
						<div class="space-y-4">
							<div>
								<label for="name" class="block text-sm font-medium text-gray-700 mb-1">
									Nombre del Ejercicio *
								</label>
								<input type="text" id="name" name="name"
									   value="{{ old('name', $exercise['name']) }}"
									   class="form-input" required>
								@error('name')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="muscle_group" class="block text-sm font-medium text-gray-700 mb-1">
									Grupo Muscular *
								</label>
								<select id="muscle_group" name="muscle_group" class="form-input" required>
									<option value="">Seleccionar...</option>
									<option value="pecho" {{ old('muscle_group', strtolower($exercise['muscle_group'])) == 'pecho' ? 'selected' : '' }}>Pecho</option>
									<option value="espalda" {{ old('muscle_group', strtolower($exercise['muscle_group'])) == 'espalda' ? 'selected' : '' }}>Espalda</option>
									<option value="piernas" {{ old('muscle_group', strtolower($exercise['muscle_group'])) == 'piernas' ? 'selected' : '' }}>Piernas</option>
									<option value="brazos" {{ old('muscle_group', strtolower($exercise['muscle_group'])) == 'brazos' ? 'selected' : '' }}>Brazos</option>
									<option value="core" {{ old('muscle_group', strtolower($exercise['muscle_group'])) == 'core' ? 'selected' : '' }}>Core</option>
									<option value="hombros" {{ old('muscle_group', strtolower($exercise['muscle_group'])) == 'hombros' ? 'selected' : '' }}>Hombros</option>
								</select>
								@error('muscle_group')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="difficulty" class="block text-sm font-medium text-gray-700 mb-1">
									Dificultad *
								</label>
								<select id="difficulty" name="difficulty" class="form-input" required>
									<option value="">Seleccionar...</option>
									<option value="principiante" {{ old('difficulty', strtolower($exercise['difficulty'])) == 'principiante' ? 'selected' : '' }}>Principiante</option>
									<option value="intermedio" {{ old('difficulty', strtolower($exercise['difficulty'])) == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
									<option value="avanzado" {{ old('difficulty', strtolower($exercise['difficulty'])) == 'avanzado' ? 'selected' : '' }}>Avanzado</option>
								</select>
								@error('difficulty')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="equipment" class="block text-sm font-medium text-gray-700 mb-1">
									Equipo Necesario *
								</label>
								<input type="text" id="equipment" name="equipment"
									   value="{{ old('equipment', $exercise['equipment']) }}"
									   class="form-input" required>
								@error('equipment')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>
						</div>

						<!-- Descripción e instrucciones -->
						<div class="space-y-4">
							<div>
								<label for="description" class="block text-sm font-medium text-gray-700 mb-1">
									Descripción *
								</label>
								<textarea id="description" name="description" rows="4"
										  class="form-input" required>{{ old('description', $exercise['description']) }}</textarea>
								@error('description')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label class="block text-sm font-medium text-gray-700 mb-1">
									Instrucciones *
								</label>
								<div id="instructions-container">
									@php
										$instructions = old('instructions', $exercise['instructions'] ?? []);
									@endphp
									@foreach($instructions as $index => $instruction)
										<div class="instruction-item flex mb-2">
											<input type="text" name="instructions[]" value="{{ $instruction }}"
												   class="form-input flex-1" placeholder="Paso {{ $index + 1 }}...">
											<button type="button" onclick="removeInstruction(this)"
													class="ml-2 btn-secondary px-2">×</button>
										</div>
									@endforeach
								</div>
								<button type="button" onclick="addInstruction()" class="btn-secondary mt-2">
									+ Agregar Paso
								</button>
								@error('instructions')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>
						</div>
					</div>

					<!-- Botones -->
					<div class="flex justify-between mt-8">
						<a href="{{ route('exercises.show', $exercise['id']) }}" class="btn-secondary">
							Cancelar
						</a>
						<div class="space-x-2">
							<button type="submit" class="btn-primary">
								Actualizar Ejercicio
							</button>
							<button type="button" onclick="confirmDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
								Eliminar
							</button>
						</div>
					</div>
				</form>

				<!-- Delete form -->
				<form id="delete-form" action="{{ route('exercises.destroy', $exercise['id']) }}" method="POST" class="hidden">
					@csrf
					@method('DELETE')
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

		function confirmDelete() {
			if (confirm('¿Estás seguro de que quieres eliminar este ejercicio? Esta acción no se puede deshacer.')) {
				document.getElementById('delete-form').submit();
			}
		}
	</script>
@endsection
