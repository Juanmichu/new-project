<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Fitness App')</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

	<!-- Scripts and Styles -->
	@if (app()->environment('local'))
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	@else
		<link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
		<script src="{{ asset('build/assets/app.js') }}" defer></script>
	@endif
</head>
<body class="font-sans antialiased bg-gray-100">
<div id="app">
	<!-- Navigation -->
	<nav class="bg-white shadow-lg">
		<div class="max-w-7xl mx-auto px-4">
			<div class="flex justify-between h-16">
				<div class="flex items-center">
					<a href="{{ route('home') }}" class="flex-shrink-0">
						<h1 class="text-xl font-bold text-gray-800">💪 FitnessApp</h1>
					</a>

					<!-- Navigation Links -->
					<div class="hidden md:ml-6 md:flex md:space-x-8">
						<a href="{{ route('home') }}"
						   class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-b-2 border-blue-500' : '' }}">
							Inicio
						</a>
						<a href="{{ route('exercises.index') }}"
						   class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('exercises.*') ? 'border-b-2 border-blue-500' : '' }}">
							Ejercicios
						</a>
						<a href="{{ route('blog.index') }}"
						   class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('blog.*') ? 'border-b-2 border-blue-500' : '' }}">
							Blog
						</a>
					</div>
				</div>

				<!-- User Menu -->
				<div class="flex items-center space-x-4">
					@auth
						<div class="relative">
							<button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
									id="user-menu-button" onclick="toggleUserMenu()">
								<span class="sr-only">Abrir menú de usuario</span>
								<div class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center">
									<span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
								</div>
							</button>
							<div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden"
								 id="user-menu">
								<div class="py-1">
									<a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
									<a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
									<form method="POST" action="{{ route('logout') }}">
										@csrf
										<button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
											Cerrar Sesión
										</button>
									</form>
								</div>
							</div>
						</div>
					@else
						<a href="{{ route('login') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium">
							Iniciar Sesión
						</a>
						<a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium">
							Registrarse
						</a>
					@endauth
				</div>
			</div>
		</div>
	</nav>

	<!-- Page Content -->
	<main class="py-4">
		@if(session('success'))
			<div class="max-w-7xl mx-auto px-4 mb-4">
				<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
					{{ session('success') }}
				</div>
			</div>
		@endif

		@if(session('error'))
			<div class="max-w-7xl mx-auto px-4 mb-4">
				<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
					{{ session('error') }}
				</div>
			</div>
		@endif

		@yield('content')
	</main>

	<!-- Footer -->
	<footer class="bg-gray-800 text-white">
		<div class="max-w-7xl mx-auto py-4 px-4">
			<div class="text-center">
				<p>&copy; {{ date('Y') }} FitnessApp. Todos los derechos reservados.</p>
			</div>
		</div>
	</footer>
</div>

<script>
	function toggleUserMenu() {
		const menu = document.getElementById('user-menu');
		menu.classList.toggle('hidden');
	}

	// Cerrar menu al hacer click fuera
	document.addEventListener('click', function(event) {
		const button = document.getElementById('user-menu-button');
		const menu = document.getElementById('user-menu');

		if (!button.contains(event.target) && !menu.contains(event.target)) {
			menu.classList.add('hidden');
		}
	});
</script>
</body>
</html>
