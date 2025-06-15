<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Fitness App')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

	<!-- Scripts and Styles -->
	@if (app()->environment('local'))
		@vite(['resources/css/app.css', 'resources/css/custom_tailwind.css', 'resources/js/app.js'])
	@else
		<link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
		<script src="{{ asset('build/assets/app.js') }}" defer></script>
	@endif

	<style>
		/* Asegurar que las clases personalizadas estén disponibles */
		.card {
			@apply bg-white rounded-lg shadow-md;
		}
		.card-header {
			@apply px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg;
		}
		.card-body {
			@apply p-6;
		}
		.btn-primary {
			@apply bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 inline-block text-center no-underline;
		}
		.btn-secondary {
			@apply bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 inline-block text-center no-underline;
		}
		.form-input {
			@apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
		}

		/* Menu dropdown styles */
		.dropdown-menu {
			transform: translateY(-10px);
			opacity: 0;
			visibility: hidden;
			transition: all 0.2s ease-in-out;
		}
		.dropdown-menu.show {
			transform: translateY(0);
			opacity: 1;
			visibility: visible;
		}
	</style>
    </head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">
<div id="app">
	<!-- Navigation -->
	<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between items-center h-16">
				<!-- Logo and Brand -->
				<div class="flex items-center">
					<a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
						<div class="text-2xl mr-2">💪</div>
						<h1 class="text-xl font-bold text-gray-900">FitCoacher</h1>
					</a>

					<!-- Main Navigation Links -->
					<div class="hidden md:ml-8 md:flex md:items-center md:space-x-8">
						<a href="{{ route('home') }}"
						   class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
							Inicio
						</a>
						<a href="{{ route('exercises.index') }}"
						   class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('exercises.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
							Ejercicios
						</a>
						<a href="{{ route('blog.index') }}"
						   class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('blog.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
							Blog
						</a>
					</div>
				</div>

				<!-- Right Side Navigation -->
				<div class="flex items-center space-x-4">
					@auth
						<!-- User Dropdown -->
						<div class="relative">
							<button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 p-1"
									id="user-menu-button"
									onclick="toggleUserMenu()"
									type="button">
								<span class="sr-only">Abrir menú de usuario</span>
								<div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center">
									<span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
								</div>
								<span class="ml-2 text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
								<svg class="ml-1 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
								</svg>
							</button>

							<div class="dropdown-menu absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
								 id="user-menu">
								<div class="py-1">
									<a href="{{ route('dashboard') }}"
									   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
										<svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
										</svg>
										Dashboard
									</a>
									<a href="{{ route('profile') }}"
									   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
										<svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
										</svg>
										Mi Perfil
									</a>
									<div class="border-t border-gray-100"></div>
									<form method="POST" action="{{ route('logout') }}">
										@csrf
										<button type="submit"
												class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
											<svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
											</svg>
											Cerrar Sesión
										</button>
									</form>
								</div>
							</div>
						</div>
					@else
						<!-- Guest Navigation -->
						<a href="{{ route('login') }}"
						   class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
							Iniciar Sesión
						</a>
						<a href="{{ route('register') }}"
						   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
							Registrarse
						</a>
					@endauth

					<!-- Mobile menu button -->
					<div class="md:hidden">
						<button type="button"
								class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600 p-2"
								onclick="toggleMobileMenu()">
							<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
							</svg>
						</button>
					</div>
				</div>
			</div>

			<!-- Mobile Navigation Menu -->
			<div class="md:hidden hidden" id="mobile-menu">
				<div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
					<a href="{{ route('home') }}"
					   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
						Inicio
					</a>
					<a href="{{ route('exercises.index') }}"
					   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md {{ request()->routeIs('exercises.*') ? 'text-blue-600 bg-blue-50' : '' }}">
						Ejercicios
					</a>
					<a href="{{ route('blog.index') }}"
					   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md {{ request()->routeIs('blog.*') ? 'text-blue-600 bg-blue-50' : '' }}">
						Blog
					</a>
				</div>
			</div>
		</div>
	</nav>

	<!-- Main Content -->
	<main class="flex-1">
		<!-- Flash Messages -->
		@if(session('success'))
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
				<div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
					<div class="flex">
						<div class="flex-shrink-0">
							<svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
							</svg>
                    </div>
						<div class="ml-3">
							<p class="text-sm text-green-700">{{ session('success') }}</p>
						</div>
					</div>
				</div>
			</div>
		@endif

		@if(session('error'))
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
				<div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
					<div class="flex">
						<div class="flex-shrink-0">
							<svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
							</svg>
						</div>
						<div class="ml-3">
							<p class="text-sm text-red-700">{{ session('error') }}</p>
						</div>
					</div>
				</div>
			</div>
		@endif

		@if ($errors->any())
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
				<div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
					<div class="flex">
						<div class="flex-shrink-0">
							<svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
							</svg>
						</div>
						<div class="ml-3">
							<p class="text-sm text-red-700 font-medium">Hay algunos errores en el formulario:</p>
							<ul class="list-disc list-inside text-sm text-red-600 mt-1">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		@endif

            <!-- Page Content -->
		<div class="py-6">
			@yield('content')
		</div>
            </main>

	<!-- Footer -->
	<footer class="bg-gray-800 text-white mt-auto">
		<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
			<div class="grid md:grid-cols-4 gap-8">
				<div class="md:col-span-2">
					<div class="flex items-center mb-4">
						<div class="text-2xl mr-2">💪</div>
						<h3 class="text-xl font-bold">FitCoacher</h3>
					</div>
					<p class="text-gray-300 mb-4">
						Tu aplicación completa para entrenamientos, ejercicios y consejos de fitness.
						Alcanza tus objetivos con nuestras herramientas y recursos.
					</p>
				</div>

				<div>
					<h4 class="text-lg font-semibold mb-4">Enlaces Rápidos</h4>
					<ul class="space-y-2">
						<li><a href="{{ route('exercises.index') }}" class="text-gray-300 hover:text-white transition-colors">Ejercicios</a></li>
						<li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
						<li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors">Acerca de</a></li>
						<li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors">Contacto</a></li>
					</ul>
				</div>

				<div>
					<h4 class="text-lg font-semibold mb-4">Legal</h4>
					<ul class="space-y-2">
						<li><a href="{{ route('privacy') }}" class="text-gray-300 hover:text-white transition-colors">Privacidad</a></li>
						<li><a href="{{ route('terms') }}" class="text-gray-300 hover:text-white transition-colors">Términos</a></li>
					</ul>
        </div>
			</div>

			<div class="border-t border-gray-700 mt-8 pt-8 text-center">
				<p class="text-gray-300">&copy; {{ date('Y') }} FitCoacher. Todos los derechos reservados.</p>
			</div>
		</div>
	</footer>
</div>

<!-- JavaScript para funcionalidad interactiva -->
<script>
	// Toggle user menu
	function toggleUserMenu() {
		const menu = document.getElementById('user-menu');
		menu.classList.toggle('show');
	}

	// Toggle mobile menu
	function toggleMobileMenu() {
		const menu = document.getElementById('mobile-menu');
		menu.classList.toggle('hidden');
	}

	// Close menus when clicking outside
	document.addEventListener('click', function(event) {
		const userButton = document.getElementById('user-menu-button');
		const userMenu = document.getElementById('user-menu');
		const mobileMenu = document.getElementById('mobile-menu');

		// Close user menu if clicked outside
		if (userButton && userMenu && !userButton.contains(event.target) && !userMenu.contains(event.target)) {
			userMenu.classList.remove('show');
		}

		// Close mobile menu if clicked outside
		if (mobileMenu && !event.target.closest('#mobile-menu') && !event.target.closest('[onclick="toggleMobileMenu()"]')) {
			mobileMenu.classList.add('hidden');
		}
	});

	// Auto-hide flash messages after 5 seconds
	setTimeout(function() {
		const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
		alerts.forEach(function(alert) {
			if (alert.parentElement) {
				alert.style.transition = 'opacity 0.5s ease-out';
				alert.style.opacity = '0';
				setTimeout(function() {
					if (alert.parentElement) {
						alert.parentElement.removeChild(alert);
					}
				}, 500);
			}
		});
	}, 5000);
</script>
    </body>
</html>
