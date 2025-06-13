@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
	<div class="max-w-4xl mx-auto px-4">
		<!-- Header -->
		<div class="card mb-6">
			<div class="card-body">
				<h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Perfil</h1>
				<p class="text-gray-600">Actualiza tu información personal y configuración de seguridad</p>
			</div>
		</div>

		<div class="space-y-6">
			<!-- Información Personal -->
			<div class="card">
				<div class="card-header">
					<h2 class="text-xl font-semibold">Información Personal</h2>
				</div>
				<div class="card-body">
					<form action="{{ route('profile.update') }}" method="POST">
						@csrf
						@method('PATCH')

						<div class="grid md:grid-cols-2 gap-6">
							<div>
								<label for="name" class="block text-sm font-medium text-gray-700 mb-1">
									Nombre *
								</label>
								<input type="text" id="name" name="name"
									   value="{{ old('name', $user->name) }}"
									   class="form-input" required>
								@error('name')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="email" class="block text-sm font-medium text-gray-700 mb-1">
									Email *
								</label>
								<input type="email" id="email" name="email"
									   value="{{ old('email', $user->email) }}"
									   class="form-input" required>
								@error('email')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>
						</div>

						<div class="flex justify-between mt-6">
							<a href="{{ route('profile.show') }}" class="btn-secondary">
								Cancelar
							</a>
							<button type="submit" class="btn-primary">
								Actualizar Información
							</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Cambiar Contraseña -->
			<div class="card">
				<div class="card-header">
					<h2 class="text-xl font-semibold">Cambiar Contraseña</h2>
				</div>
				<div class="card-body">
					<form action="{{ route('profile.update') }}" method="POST">
						@csrf
						@method('PATCH')

						<div class="space-y-4">
							<div>
								<label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
									Contraseña Actual
								</label>
								<input type="password" id="current_password" name="current_password"
									   class="form-input">
								@error('current_password')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div class="grid md:grid-cols-2 gap-4">
								<div>
									<label for="password" class="block text-sm font-medium text-gray-700 mb-1">
										Nueva Contraseña
									</label>
									<input type="password" id="password" name="password"
										   class="form-input">
									@error('password')
									<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
									@enderror
								</div>

								<div>
									<label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
										Confirmar Nueva Contraseña
									</label>
									<input type="password" id="password_confirmation" name="password_confirmation"
										   class="form-input">
								</div>
							</div>
						</div>

						<div class="flex justify-end mt-6">
							<button type="submit" class="btn-primary">
								Cambiar Contraseña
							</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Eliminar Cuenta -->
			<div class="card border-red-200">
				<div class="card-header bg-red-50">
					<h2 class="text-xl font-semibold text-red-800">Zona Peligrosa</h2>
				</div>
				<div class="card-body">
					<p class="text-gray-600 mb-4">
						Una vez que elimines tu cuenta, todos sus recursos y datos se eliminarán permanentemente.
						Esta acción no se puede deshacer.
					</p>

					<button type="button" onclick="confirmDelete()"
							class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
						Eliminar Cuenta
					</button>

					<!-- Delete form -->
					<form id="delete-form" action="{{ route('profile.destroy') }}" method="POST" class="hidden">
						@csrf
						@method('DELETE')
						<input type="password" name="password" id="delete-password" class="hidden">
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		function confirmDelete() {
			const password = prompt('Para confirmar la eliminación, ingresa tu contraseña:');
			if (password) {
				document.getElementById('delete-password').value = password;
				if (confirm('¿Estás absolutamente seguro? Esta acción no se puede deshacer.')) {
					document.getElementById('delete-form').submit();
				}
			}
		}
	</script>
@endsection
