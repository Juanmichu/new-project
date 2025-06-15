@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Hero Section -->
		<div class="bg-white rounded-xl shadow-sm p-8 sm:p-12 mb-8 text-center">
			<h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
				¡Bienvenido a FitCoacher! 💪
			</h1>
			<p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
				Tu aplicación completa para crear entrenamientos, ejercicios y consejos de fitness.
				Entrena y transforma tu cuerpo, ayuda a alcanzar los objetivos de tus clientes con nuestras herramientas profesionales.
			</p>
			@guest
				<div class="flex flex-col sm:flex-row gap-4 justify-center">
					<a href="{{ route('register') }}"
					   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
						Comenzar Ahora
					</a>
					<a href="{{ route('exercises.index') }}"
					   class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
						Ver Ejercicios
					</a>
				</div>
			@else
				<div class="flex flex-col sm:flex-row gap-4 justify-center">
					<a href="{{ route('dashboard') }}"
					   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
						Ir al Dashboard
					</a>
					<a href="{{ route('exercises.index') }}"
					   class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
						Ver Ejercicios
					</a>
				</div>
			@endguest
		</div>

		<!-- Features Section -->
		<div class="grid md:grid-cols-3 gap-6 mb-12">
			<!-- Feature 1 -->
			<div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
				<div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
					<div class="text-3xl">🏋️‍♀️</div>
				</div>
				<h3 class="text-xl font-semibold mb-3">Ejercicios Variados</h3>
				<p class="text-gray-600 mb-6">
					Accede a una amplia biblioteca de ejercicios para todos los niveles y objetivos de fitness, ¡o crea nuevos!
				</p>
				<a href="{{ route('exercises.index') }}"
				   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
					Explorar Ejercicios
				</a>
			</div>

			<!-- Feature 2 -->
			<div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
				<div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
					<div class="text-3xl">📝</div>
				</div>
				<h3 class="text-xl font-semibold mb-3">Blog de Fitness</h3>
				<p class="text-gray-600 mb-6">
					Lee artículos sobre nutrición, entrenamiento y consejos para mejorar su forma física.
				</p>
				<a href="{{ route('blog.index') }}"
				   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
					Leer Blog
				</a>
			</div>

			<!-- Feature 3 -->
			<div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
				<div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
					<div class="text-3xl">📊</div>
				</div>
				<h3 class="text-xl font-semibold mb-3">Seguimiento Personal</h3>
				<p class="text-gray-600 mb-6">
					Registra su progreso y mantén un seguimiento detallado de sus entrenamientos.
				</p>
				@auth
					<a href="{{ route('dashboard') }}"
					   class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
						Ver Dashboard
					</a>
				@else
					<a href="{{ route('register') }}"
					   class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
						Registrarse
					</a>
				@endauth
			</div>
		</div>

		<!-- Statistics Section -->
		<div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-sm p-8 mb-12 text-white">
			<div class="text-center mb-8">
				<h2 class="text-3xl font-bold mb-2">Únete a Nuestra Comunidad</h2>
				<p class="text-blue-100">Miles de entrenadores ya están transformando sus vidas</p>
			</div>

			<div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
				<div>
					<div class="text-3xl font-bold mb-1">150+</div>
					<div class="text-blue-100 text-sm">Ejercicios</div>
				</div>
				<div>
					<div class="text-3xl font-bold mb-1">1.2K+</div>
					<div class="text-blue-100 text-sm">Usuarios</div>
				</div>
				<div>
					<div class="text-3xl font-bold mb-1">5.6K+</div>
					<div class="text-blue-100 text-sm">Entrenamientos</div>
				</div>
				<div>
					<div class="text-3xl font-bold mb-1">45+</div>
					<div class="text-blue-100 text-sm">Artículos</div>
				</div>
			</div>
		</div>

		<!-- Featured Exercises -->
		<div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
			<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
				<div>
					<h2 class="text-2xl font-bold text-gray-900 mb-2">Ejercicios Destacados</h2>
					<p class="text-gray-600">Comienza con estos ejercicios fundamentales</p>
				</div>
				<a href="{{ route('exercises.index') }}"
				   class="mt-4 sm:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
					Ver Todos
				</a>
			</div>

			<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
				@php
					$featuredExercises = [
						['name' => 'Flexiones', 'muscle' => 'Pecho', 'difficulty' => 'Intermedio', 'color' => 'blue'],
						['name' => 'Sentadillas', 'muscle' => 'Piernas', 'difficulty' => 'Principiante', 'color' => 'green'],
						['name' => 'Dominadas', 'muscle' => 'Espalda', 'difficulty' => 'Avanzado', 'color' => 'red'],
						['name' => 'Plancha', 'muscle' => 'Core', 'difficulty' => 'Intermedio', 'color' => 'purple'],
					];
				@endphp

				@foreach($featuredExercises as $exercise)
					<div class="bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition-colors group cursor-pointer">
						<div class="flex items-center justify-between mb-2">
							<h4 class="font-semibold text-gray-900 group-hover:text-{{ $exercise['color'] }}-600 transition-colors">
								{{ $exercise['name'] }}
							</h4>
							<span class="w-3 h-3 bg-{{ $exercise['color'] }}-500 rounded-full"></span>
						</div>
						<p class="text-sm text-gray-600 mb-2">{{ $exercise['muscle'] }}</p>
						<span class="inline-block bg-{{ $exercise['color'] }}-100 text-{{ $exercise['color'] }}-800 text-xs px-2 py-1 rounded-full">
                        {{ $exercise['difficulty'] }}
                    </span>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection
