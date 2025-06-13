@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
	<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-md w-full space-y-8">
			<div class="text-center">
				<h2 class="text-3xl font-bold text-gray-900">
					Iniciar Sesión
				</h2>
				<p class="mt-2 text-gray-600">
					Accede a tu cuenta de FitnessApp
				</p>
			</div>

			<div class="card">
				<div class="card-body">
					<form method="POST" action="{{ route('login') }}">
						@csrf

						<div class="space-y-4">
							<div>
								<label for="email" class="block text-sm font-medium text-gray-700 mb-1">
									Email
								</label>
								<input type="email" id="email" name="email" value="{{ old('email') }}"
									   class="form-input" required autofocus>
								@error('email')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="password" class="block text-sm font-medium text-gray-700 mb-1">
									Contraseña
								</label>
								<input type="password" id="password" name="password"
									   class="form-input" required>
								@error('password')
								<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
								@enderror
							</div>

							<div class="flex items-center justify-between">
								<div class="flex items-center">
									<input type="checkbox" id="remember" name="remember"
										   class="rounded border-gray-300 text-blue-600">
									<label for="remember" class="ml-2 text-sm text-gray-600">
										Recordarme
									</label>
								</div>

								<a href="#" class="text-sm text-blue-600 hover:text-blue-500">
									¿Olvidaste tu contraseña?
								</a>
							</div>
						</div>

						<button type="submit" class="btn-primary w-full mt-6">
							Iniciar Sesión
						</button>
					</form>

					<div class="mt-6 text-center">
						<p class="text-sm text-gray-600">
							¿No tienes una cuenta?
							<a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">
								Registrarse
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
