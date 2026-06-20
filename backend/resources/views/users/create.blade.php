@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('users.index') }}" class="hover:text-blue-600">Users</a></li>
            <li>/</li>
            <li class="text-gray-900">Create user</li>
        </ol>
    </nav>

    <div class="card mb-6">
        <div class="card-body">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create new user</h1>
            <p class="text-gray-600">Add a client or coach account</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required>
                        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                        <select id="role" name="role" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center mt-6">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active account</label>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('users.index') }}" class="btn-secondary cursor-pointer">Cancel</a>
                    <button type="submit" class="btn-primary px-6 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition cursor-pointer">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
