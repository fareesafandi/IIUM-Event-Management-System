@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        @if (session('status') === 'profile-updated')
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">Profile updated successfully!</span>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
            <div class="flex items-center space-x-6">
                <!-- Profile Picture -->
                <div class="relative">
                    <img src="{{ $user->profile_picture_url }}" 
                         alt="{{ $user->name }}" 
                         class="h-24 w-24 rounded-full object-cover border-4 border-gray-200">
                    <div class="absolute bottom-0 right-0 bg-teal-500 rounded-full p-2 border-4 border-white">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    @if($user->isEventManager())
                        <span class="inline-block mt-2 px-3 py-1 bg-teal-500 text-white text-sm font-medium rounded-md">Admin</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Information Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Profile Information</h2>
            
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Profile Picture -->
                <div>
                    <label for="profile_picture" class="block text-sm font-semibold text-gray-800 mb-2">
                        Profile Picture
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img src="{{ $user->profile_picture_url }}" 
                                 alt="Current profile picture" 
                                 class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                        </div>
                        <div class="flex-1">
                            <input 
                                type="file" 
                                id="profile_picture" 
                                name="profile_picture" 
                                accept="image/jpeg,image/jpg,image/png"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                            >
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG or GIF. Max size: 2MB</p>
                            <p class="mt-2 text-sm text-gray-600">Or provide an image URL:</p>
                            <input 
                                type="url" 
                                name="profile_picture_url" 
                                value="{{ old('profile_picture_url', filter_var($user->profile_picture, FILTER_VALIDATE_URL) ? $user->profile_picture : '') }}"
                                placeholder="https://example.com/image.jpg"
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            >
                        </div>
                    </div>
                    @error('profile_picture')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
                        Name *
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">
                        Email *
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Matric Number and Phone Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="matric_no" class="block text-sm font-semibold text-gray-800 mb-2">
                            Matric Number
                        </label>
                        <input 
                            type="text" 
                            id="matric_no" 
                            name="matric_no" 
                            value="{{ old('matric_no', $user->matric_no) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        >
                        @error('matric_no')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-semibold text-gray-800 mb-2">
                            Phone Number
                        </label>
                        <input 
                            type="text" 
                            id="phone_number" 
                            name="phone_number" 
                            value="{{ old('phone_number', $user->phone_number) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        >
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role (only if user has permission to change it) -->
                @if(auth()->user()->isEventManager() || auth()->user()->id === $user->id)
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-800 mb-2">
                            Role
                        </label>
                        <select 
                            id="role" 
                            name="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        >
                            <option value="public" {{ old('role', $user->role) === 'public' ? 'selected' : '' }}>Public User</option>
                            <option value="event_manager" {{ old('role', $user->role) === 'event_manager' ? 'selected' : '' }}>Event Manager</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Password Update -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>
                    <p class="text-sm text-gray-600 mb-4">Leave blank to keep current password</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">
                                New Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                autocomplete="new-password"
                            >
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-800 mb-2">
                                Confirm New Password
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                autocomplete="new-password"
                            >
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Logout Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Logout</h2>
            <p class="text-sm text-gray-600 mb-4">
                Click the button below to securely log out of your account.
            </p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-md transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

        <!-- Delete Account Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-red-600 mb-4">Delete Account</h2>
            <p class="text-sm text-gray-600 mb-4">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </p>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
