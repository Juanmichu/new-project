@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
	<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-md w-full space-y-8">
			<div class="text-center">
				<h2 class="text-3xl font-bold text-gray-900">
					Crear Cuenta
				</h2>
				<p class="mt-2 text-gray-600">
					Únete a FitCoacher y comienza tu transformación
				</p>
			</div>

			<div class="card">
				<div class="card-body">
					<form method="POST" action="{{ route('register') }}">
						@csrf

						<div class="space-y-4">
							<div>
								<label for="name" class="block text-sm font-medium text-gray-700 mb-1">
									Nombre
								</label>
								<input type="text" id="name" name="name" value="{{ old('name') }}"
									   class="form-input @error('name') border-red-500 @enderror" required autofocus>
								@error('name')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="email" class="block text-sm font-medium text-gray-700 mb-1">
									Email
								</label>
								<input type="email" id="email" name="email" value="{{ old('email') }}"
									   class="form-input @error('email') border-red-500 @enderror" required>
								@error('email')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="password" class="block text-sm font-medium text-gray-700 mb-1">
									Contraseña
								</label>
								<input type="password" id="password" name="password"
									   class="form-input @error('password') border-red-500 @enderror" required>
								@error('password')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
									Confirmar Contraseña
								</label>
								<input type="password" id="password_confirmation" name="password_confirmation"
									   class="form-input @error('password_confirmation') border-red-500 @enderror" required>
								@error('password_confirmation')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div class="flex items-center">
								<input type="checkbox" id="terms" name="terms" value="1" required
									   class="rounded border-gray-300 text-blue-600 @error('terms') border-red-500 @enderror">
								<label for="terms" class="ml-2 text-sm text-gray-600">
									Acepto los
									<a href="{{ route('terms') }}" class="text-blue-600 hover:text-blue-500">términos y condiciones</a>
								</label>
								@error('terms')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>
						</div>

						@if($errors->any())
							<div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
								<div class="text-sm text-red-600">
									@if($errors->has('error'))
										<p>{{ $errors->first('error') }}</p>
									@else
										<p>Por favor corrige los errores marcados en el formulario.</p>
									@endif
								</div>
							</div>
						@endif

						<button type="submit" class="btn-primary w-full mt-6">
							Crear Cuenta
						</button>
					</form>

					<div class="mt-6 text-center">
						<p class="text-sm text-gray-600">
							¿Ya tienes una cuenta?
							<a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium">
								Iniciar Sesión
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
