@extends('layouts.app')

@section('title', 'Editar Workout')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('workouts.index') }}" class="hover:text-blue-600">Workouts</a></li>
            <li>/</li>
            <li class="text-gray-900">Edit</li>
        </ol>
    </nav>

    <div class="card mb-6">
        <div class="card-body">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit workout</h1>
            <p class="text-gray-600">Update workout: {{ $workout->name }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @include('workouts._form', ['action' => route('workouts.update', $workout->_id)])
        </div>
    </div>
</div>
@endsection
