<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Event') }}
            </h2>
            <a href="{{ route('manager.events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                ← Back to Events
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('manager.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Event Title *
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title', $event->title) }}"
                            required
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder="Enter event title"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Description *
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="5"
                            required
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder="Enter event description"
                        >{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Date *
                            </label>
                            <input 
                                type="date" 
                                id="date" 
                                name="date" 
                                value="{{ old('date', $event->date->format('Y-m-d')) }}"
                                required
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Time *
                            </label>
                            <input 
                                type="time" 
                                id="time" 
                                name="time" 
                                value="{{ old('time', date('H:i', strtotime($event->time))) }}"
                                required
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >
                            @error('time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Venue -->
                    <div class="mb-4">
                        <label for="venue" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Venue *
                        </label>
                        <input 
                            type="text" 
                            id="venue" 
                            name="venue" 
                            value="{{ old('venue', $event->venue) }}"
                            required
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder="Enter venue location"
                        >
                        @error('venue')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categories -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Categories
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="categories[]" 
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', $event->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('categories.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status and Max Participants -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Status *
                            </label>
                            <select 
                                id="status" 
                                name="status"
                                required
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >
                                <option value="open" {{ old('status', $event->status) == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="closed" {{ old('status', $event->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="full" {{ old('status', $event->status) == 'full' ? 'selected' : '' }}>Full</option>
                                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Max Participants (Leave empty for unlimited)
                            </label>
                            <input 
                                type="number" 
                                id="max_participants" 
                                name="max_participants" 
                                value="{{ old('max_participants', $event->max_participants) }}"
                                min="1"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="Optional"
                            >
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Poster Image -->
                    <div class="mb-4">
                        <label for="poster_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Event Poster (JPG/PNG, max 2MB)
                        </label>
                        @if($event->poster_image_url && !filter_var($event->poster_image_url, FILTER_VALIDATE_URL))
                            <div class="mb-2">
                                <img src="{{ $event->poster_image_url }}" alt="Current poster" class="h-32 w-auto rounded">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Current poster</p>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            id="poster_image" 
                            name="poster_image" 
                            accept="image/jpeg,image/jpg,image/png"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Or provide an image URL below (leave empty to keep current)</p>
                        <input 
                            type="url" 
                            name="poster_image_url" 
                            value="{{ old('poster_image_url') }}"
                            placeholder="https://example.com/image.jpg"
                            class="mt-2 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                        @error('poster_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Organizer Information -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Organizer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="organizer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Organizer Name
                                </label>
                                <input 
                                    type="text" 
                                    id="organizer_name" 
                                    name="organizer_name" 
                                    value="{{ old('organizer_name', $event->organizer_name) }}"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    placeholder="Club/Organization name"
                                >
                                @error('organizer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="organizer_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Contact Number
                                </label>
                                <input 
                                    type="text" 
                                    id="organizer_contact" 
                                    name="organizer_contact" 
                                    value="{{ old('organizer_contact', $event->organizer_contact) }}"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    placeholder="Phone number"
                                >
                                @error('organizer_contact')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="organizer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email Address
                            </label>
                            <input 
                                type="email" 
                                id="organizer_email" 
                                name="organizer_email" 
                                value="{{ old('organizer_email', $event->organizer_email) }}"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="email@example.com"
                            >
                            @error('organizer_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('manager.events.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-medium transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition-colors">
                            Update Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
