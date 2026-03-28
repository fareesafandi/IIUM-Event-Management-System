@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<!-- Success Toast Notification -->
@if (session('success'))
<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 4000)"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed top-20 right-4 z-50">
    <div class="bg-teal-500 text-white px-6 py-4 rounded-lg shadow-xl flex items-center space-x-3">
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
        <button @click="show = false" class="ml-4 text-white hover:text-gray-200 transition-colors">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<!-- Error Toast Notification -->
@if (session('error'))
<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed top-20 right-4 z-50">
    <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl flex items-center space-x-3">
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
        <button @click="show = false" class="ml-4 text-white hover:text-gray-200 transition-colors">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modal-style container -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Edit Event</h2>
                <a href="{{ route('manager.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('manager.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">
                            Title *
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title', $event->title) }}"
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
                        >{{ old('description', $event->description) }}</textarea>
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
                                value="{{ old('date', $event->date->format('Y-m-d')) }}"
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
                                value="{{ old('time', date('H:i', strtotime($event->time))) }}"
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
                            value="{{ old('venue', $event->venue) }}"
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
                                @if($categories && count($categories) > 0)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ ($event->categories && in_array($category->id, old('categories', $event->categories->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('categories.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-800 mb-2">
                                Status *
                            </label>
                            <select 
                                id="status" 
                                name="status"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            >
                                <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="open" {{ old('status', $event->status) == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ old('status', $event->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="full" {{ old('status', $event->status) == 'full' ? 'selected' : '' }}>Full</option>
                                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                value="{{ old('organizer_name', $event->organizer_name) }}"
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
                                value="{{ old('organizer_contact', $event->organizer_contact) }}"
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
                                value="{{ old('organizer_email', $event->organizer_email) }}"
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
                                value="{{ old('max_participants', $event->max_participants) }}"
                                min="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Leave empty for unlimited"
                            >
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Event Image -->
                    @if($event->poster_image)
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">
                                Current Event Image
                            </label>
                            <div class="relative inline-block">
                                <img src="{{ $event->poster_image_url }}" alt="Current poster" class="h-32 w-auto rounded-lg border border-gray-200">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Upload a new image below to replace this one</p>
                        </div>
                    @endif

                    <!-- Event Image URL -->
                    <div class="mb-6">
                        <label for="poster_image_url" class="block text-sm font-semibold text-gray-800 mb-2">
                            Event Image URL
                        </label>
                        <input 
                            type="url" 
                            id="poster_image_url" 
                            name="poster_image_url" 
                            value="{{ old('poster_image_url') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="https://images.unsplash.com/photo-..."
                        >
                        <p class="mt-1 text-xs text-gray-500">Or upload a file below (leave both empty to keep current image)</p>
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
                        @error('poster_image_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
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
