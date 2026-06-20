@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
	<div class="max-w-4xl mx-auto px-4">
		<!-- Header -->
		<div class="card mb-6">
			<div class="card-body">
				<div class="flex justify-between items-start">
					<div>
						<h1 class="text-3xl font-bold text-gray-900 mb-2">My profile</h1>
						<p class="text-gray-600">Manage your personal account and configuration</p>
					</div>
					<a href="{{ route('profile.edit') }}" class="btn-primary">
						Edit Profile
					</a>
				</div>
			</div>
		</div>

		<div class="grid md:grid-cols-3 gap-6">
			<!-- Información Personal -->
			<div class="md:col-span-2">
				<div class="card">
					<div class="card-header">
						<h2 class="text-xl font-semibold">Personal Info</h2>
					</div>
					<div class="card-body">
						<div class="space-y-6">
							<div class="flex items-center">
								<div class="w-20 h-20 bg-gray-400 rounded-full flex items-center justify-center mr-6">
									<span class="text-2xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
								</div>
								<div>
									<h3 class="text-2xl font-semibold text-gray-900">{{ $user->name }}</h3>
									<p class="text-gray-600">{{ $user->email }}</p>
									<p class="text-sm text-gray-500">
										Member since {{ $user->created_at->format('d M Y') }}
									</p>
								</div>
							</div>

							<div class="grid md:grid-cols-2 gap-6">
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
									<div class="bg-gray-50 px-3 py-2 rounded-md">{{ $user->name }}</div>
								</div>
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
									<div class="bg-gray-50 px-3 py-2 rounded-md">{{ $user->email }}</div>
								</div>
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Register date</label>
									<div class="bg-gray-50 px-3 py-2 rounded-md">{{ $user->created_at->format('d/m/Y H:i') }}</div>
								</div>
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Last update</label>
									<div class="bg-gray-50 px-3 py-2 rounded-md">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Estadísticas -->
			<div class="space-y-6">
				<div class="card">
					<div class="card-header">
						<h2 class="text-lg font-semibold">Stats</h2>
					</div>
					<div class="card-body">
						<div class="space-y-4">
							<div class="text-center">
								<div class="text-2xl font-bold text-blue-600">0</div>
								<div class="text-sm text-gray-600">Workouts</div>
							</div>
							<div class="text-center">
								<div class="text-2xl font-bold text-green-600">0</div>
								<div class="text-sm text-gray-600">Favorite Exercises</div>
							</div>
							<div class="text-center">
								<div class="text-2xl font-bold text-purple-600">0</div>
								<div class="text-sm text-gray-600">Active days</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h2 class="text-lg font-semibold">Quick actions</h2>
					</div>
					<div class="card-body">
						<div class="space-y-3">
							<a href="{{ route('dashboard') }}" class="block bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition-colors">
								<div class="flex items-center">
									<div class="text-xl mr-3">📊</div>
									<div class="text-sm font-medium">Dashboard</div>
								</div>
							</a>
							<a href="{{ route('exercises.index') }}" class="block bg-amber-50 hover:bg-amber-100 p-3 rounded-lg transition-colors">
								<div class="flex items-center">
									<div class="text-xl mr-3">🏋️‍♀️</div>
									<div class="text-sm font-medium">Exercises</div>
								</div>
							</a>
							<a href="{{ route('settings') }}" class="block bg-purple-50 hover:bg-purple-100 p-3 rounded-lg transition-colors">
								<div class="flex items-center">
									<div class="text-xl mr-3">⚙️</div>
									<div class="text-sm font-medium">Configuration</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
