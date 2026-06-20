@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Welcome Section -->
    <div class="card mb-6">
        <div class="card-body">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                ¡Hi there, {{ $user->name }}! 👋
            </h1>
            <p class="text-gray-600">
                Here is a summary of your activity on FitCoacher
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">0</div>
                <p class="text-gray-600">Completed Workouts</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">0</div>
                <p class="text-gray-600">Favorite exercises</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">0</div>
                <p class="text-gray-600">Active Days</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">0</div>
                <p class="text-gray-600">Completed Goals</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Quick actions</h2>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <a href="{{ route('exercises.index') }}" class="block bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <div class="text-2xl mr-3">🏋️‍♀️</div>
                            <div>
                                <div class="font-medium">Explore Exercises</div>
                                <div class="text-sm text-gray-600">Discover new exercises</div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('blog.index') }}" class="block bg-amber-50 hover:bg-amber-100 p-3 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <div class="text-2xl mr-3">📝</div>
                            <div>
                                <div class="font-medium">Read Blog</div>
                                <div class="text-sm text-gray-600">Articles and Tips</div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('profile') }}" class="block bg-purple-50 hover:bg-purple-100 p-3 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <div class="text-2xl mr-3">⚙️</div>
                            <div>
                                <div class="font-medium">Manage Profile</div>
                                <div class="text-sm text-gray-600">Customize your account</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Recent Activity</h2>
            </div>
            <div class="card-body">
                <div class="text-center text-gray-500 py-8">
                    <div class="text-4xl mb-4">📊</div>
                    <p>No recent activity</p>
                    <p class="text-sm">Start your first training!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Chart Placeholder -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Weekly Progress</h2>
        </div>
        <div class="card-body">
            <div class="text-center text-gray-500 py-12">
                <div class="text-6xl mb-4">📈</div>
                <p class="text-lg">Progress Graphs</p>
                <p class="text-sm">Here you can check your trainees progress when it has been recorded</p>
            </div>
        </div>
    </div>
</div>
@endsection
