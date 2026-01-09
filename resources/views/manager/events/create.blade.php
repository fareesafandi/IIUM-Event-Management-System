@extends('layouts.app')

@section('title', 'Create New Event')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modal-style container -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Create New Event</h2>
                <a href="{{ route('manager.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('manager.events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">
                            Title *
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title') }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Enter event title"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">
                            Description *
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 min-h-[100px]"
                            placeholder="Enter event description"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="date" class="block text-sm font-semibold text-gray-800 mb-2">
                                Date *
                            </label>
                            <input 
                                type="date" 
                                id="date" 
                                name="date" 
                                value="{{ old('date') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            >
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-semibold text-gray-800 mb-2">
                                Time *
                            </label>
                            <input 
                                type="time" 
                                id="time" 
                                name="time" 
                                value="{{ old('time', '09:00') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            >
                            @error('time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Venue -->
                    <div class="mb-6">
                        <label for="venue" class="block text-sm font-semibold text-gray-800 mb-2">
                            Venue *
                        </label>
                        <input 
                            type="text" 
                            id="venue" 
                            name="venue" 
                            value="{{ old('venue') }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Enter venue location"
                        >
                        @error('venue')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category and Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-800 mb-2">
                                Category
                            </label>
                            <select 
                                id="category" 
                                name="categories[]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            >
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-800 mb-2">
                                Status
                            </label>
                            <select 
                                id="status" 
                                name="status"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            >
                                <option value="upcoming" {{ old('status', 'upcoming') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Organizer Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="organizer_name" class="block text-sm font-semibold text-gray-800 mb-2">
                                Organizer
                            </label>
                            <input 
                                type="text" 
                                id="organizer_name" 
                                name="organizer_name" 
                                value="{{ old('organizer_name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Enter organizer name"
                            >
                            @error('organizer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="organizer_contact" class="block text-sm font-semibold text-gray-800 mb-2">
                                Organizer Contact
                            </label>
                            <input 
                                type="text" 
                                id="organizer_contact" 
                                name="organizer_contact" 
                                value="{{ old('organizer_contact') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Enter contact number"
                            >
                            @error('organizer_contact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="organizer_email" class="block text-sm font-semibold text-gray-800 mb-2">
                                Organizer Email
                            </label>
                            <input 
                                type="email" 
                                id="organizer_email" 
                                name="organizer_email" 
                                value="{{ old('organizer_email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Enter email address"
                            >
                            @error('organizer_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="max_participants" class="block text-sm font-semibold text-gray-800 mb-2">
                                Max Participants
                            </label>
                            <input 
                                type="number" 
                                id="max_participants" 
                                name="max_participants" 
                                value="{{ old('max_participants', 100) }}"
                                min="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            >
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Event Image URL -->
                    <div class="mb-6">
                        <label for="poster_image_url" class="block text-sm font-semibold text-gray-800 mb-2">
                            Event Image URL
                        </label>
                        <input 
                            type="url" 
                            id="poster_image_url" 
                            name="poster_image_url" 
                            value="{{ old('poster_image_url', 'https://images.unsplash.com/photo-1646579886135-068c738003087c') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="https://images.unsplash.com/photo-..."
                        >
                        <p class="mt-1 text-xs text-gray-500">Or upload a file below</p>
                        <input 
                            type="file" 
                            id="poster_image" 
                            name="poster_image" 
                            accept="image/jpeg,image/jpg,image/png"
                            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        >
                        @error('poster_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Event
                        </button>
                        <a href="{{ route('manager.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium rounded-md transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
