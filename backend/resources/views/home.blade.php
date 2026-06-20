@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="bg-white rounded-xl shadow-sm p-8 sm:p-12 mb-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                Welcome to FitCoacher! 💪
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Your complete app to create workouts, exercises, and fitness tips.
                Train and transform your body, help your clients achieve their fitness goals with our professional tools.
            </p>
            @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
                        Start now
                    </a>
                    <a href="{{ route('exercises.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
                        Check Exercises
                    </a>
                </div>
            @else
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dashboard') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
                        Go to Dashboard
                    </a>
                    <a href="{{ route('exercises.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium py-3 px-8 rounded-lg text-lg transition duration-200">
                        Check exercises
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
                <h3 class="text-xl font-semibold mb-3">Exercise library</h3>
                <p class="text-gray-600 mb-6">
                    Access a wide exercise library for any level or fitness goals, or create new ones!
                </p>
                <a href="{{ route('exercises.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
                    Explore exercises
                </a>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <div class="text-3xl">📝</div>
                </div>
                <h3 class="text-xl font-semibold mb-3">Fitness Blog</h3>
                <p class="text-gray-600 mb-6">
                    Read nutrition, training and tips articles to improve your physical fitness.
                </p>
                <a href="{{ route('blog.index') }}"
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
                    Read blog
                </a>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <div class="text-3xl">📊</div>
                </div>
                <h3 class="text-xl font-semibold mb-3">Personal follow up</h3>
                <p class="text-gray-600 mb-6">
                    Register your progress and keep a detailed track of your workouts.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-block">
                        Register
                    </a>
                @endauth
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-sm p-8 mb-12 text-white">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold mb-2">Join our community</h2>
                <p class="text-blue-100">Thousands of trainers are already transforming lives</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-3xl font-bold mb-1">150+</div>
                    <div class="text-blue-100 text-sm">Exercises</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">1.2K+</div>
                    <div class="text-blue-100 text-sm">Users</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">5.6K+</div>
                    <div class="text-blue-100 text-sm">Trainings</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">45+</div>
                    <div class="text-blue-100 text-sm">Articles</div>
                </div>
            </div>
        </div>

        <!-- Featured Exercises -->
        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Featured exercises</h2>
                    <p class="text-gray-600">Start with these fundamental exercises</p>
                </div>
                <a href="{{ route('exercises.index') }}"
                   class="mt-4 sm:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                    See all
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($featuredExercises as $index => $exercise)
                    <div class="bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition-colors group cursor-pointer">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900 {{ $index == 0 ? 'group-hover:text-blue-600' : '' }} transition-colors">
                                {{ $exercise['name'] }}
                            </h4>
                            <span class="w-3 h-3 {{ $index == 0 ? 'bg-blue-500' : '' }} rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ implode( ', ' , $exercise['muscle_groups']) }}</p>
                        <span class="inline-block bg-{{ $colorDifficultyLevels[$exercise['difficulty_level']] }}-100 text-{{ $colorDifficultyLevels[$exercise['difficulty_level']] }}-800 text-xs px-2 py-1 rounded-full">
                        {{ $exercise['difficulty_level'] }}
                    </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
