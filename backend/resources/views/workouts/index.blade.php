@extends('layouts.app')

@section('title', 'Workouts')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Header -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Workouts</h1>
                    <p class="text-gray-600">Workouts you have created for your clients</p>
                </div>
                <a href="{{ route('workouts.create') }}" class="btn-primary mt-4 p-4 rounded bg-blue-600 text-white hover:bg-blue-700 transition">Create Workout</a>
            </div>
        </div>
    </div>

    <!-- Workouts table -->
    <div class="card">
        <div class="card-body overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Client</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Exercises</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($workouts as $workout)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $workout->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $workout->user->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $workout->workout_date ? \Illuminate\Support\Carbon::parse($workout->workout_date)->format('Y-m-d') : '—' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $workout->exercises->count() }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-800">{{ ucfirst($workout->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('workouts.edit', $workout->_id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">You haven't created any workouts yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $workouts->links() }}
    </div>
</div>
@endsection
