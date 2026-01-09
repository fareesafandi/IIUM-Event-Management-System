@props(['event'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <!-- Event Poster Image -->
    <div class="relative h-48 w-full overflow-hidden">
        @if($event->poster_image_url)
            <img src="{{ $event->poster_image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center">
                <svg class="h-16 w-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif

        <!-- Status Badge (top left) -->
        <div class="absolute top-2 left-2">
            <x-status-badge :status="$event->status" />
        </div>

        <!-- Bookmark Icon (top right) -->
        <button class="absolute top-2 right-2 p-2 bg-white/90 rounded-full hover:bg-white transition-colors">
            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
            </svg>
        </button>

        <!-- Registration Count (if applicable) -->
        @if($event->max_participants)
            <div class="absolute bottom-2 right-2 px-2 py-1 bg-black/70 rounded text-white text-xs font-medium">
                {{ $event->confirmed_participants_count }}/{{ $event->max_participants }}
            </div>
        @endif
    </div>

    <!-- Event Details -->
    <div class="p-6">
        <!-- Category Badge -->
        @if($event->categories->count() > 0)
            <div class="mb-2">
                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded">
                    {{ $event->categories->first()->name }}
                </span>
            </div>
        @endif

        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-1">
            {{ $event->title }}
        </h3>

        <!-- Description -->
        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
            {{ $event->description }}
        </p>

        <!-- Event Info -->
        <div class="space-y-2 mb-4">
            <!-- Date & Time -->
            <div class="flex items-center text-sm text-gray-600">
                <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $event->date->format('M d, Y') }} at {{ date('g:i A', strtotime($event->time)) }}</span>
            </div>

            <!-- Venue -->
            <div class="flex items-center text-sm text-gray-600">
                <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="line-clamp-1">{{ $event->venue }}</span>
            </div>

            <!-- Organizer -->
            @if($event->organizer_name)
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="line-clamp-1">{{ $event->organizer_name }}</span>
                </div>
            @endif
        </div>

        <!-- View Details Button -->
        <a href="{{ route('events.show', $event) }}" class="block w-full text-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md font-medium transition-colors flex items-center justify-center">
            <span>View Details</span>
            <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
        </a>
    </div>
</div>
