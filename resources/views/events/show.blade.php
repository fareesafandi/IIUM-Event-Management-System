@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">{{ $event->title }}</h1>
            <a href="{{ route('events.index') }}" class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                ← Back to Events
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Event Image -->
                            @if($event->poster_image_url)
                                <img src="{{ $event->poster_image_url }}" alt="{{ $event->title }}" class="w-full h-auto rounded-lg">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">No Image Available</span>
                                </div>
                            @endif

                            <!-- Event Details -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                        @if($event->status == 'open') bg-green-100 text-green-800
                                        @elseif($event->status == 'upcoming') bg-blue-100 text-blue-800
                                        @elseif($event->status == 'full') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                    @if($event->categories->count() > 0)
                                        @foreach($event->categories as $category)
                                            <span class="px-3 py-1 text-sm bg-indigo-100 text-indigo-800 rounded-full">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                                @if($isManager)
                                    <a href="{{ route('manager.events.edit', $event) }}" class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                                        Edit Event
                                    </a>
                                @endif
                            </div>

                            <!-- Description -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>
                            </div>

                            <!-- Event Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Date & Time</p>
                                        <p class="text-gray-900">{{ $event->date->format('l, F d, Y') }}</p>
                                        <p class="text-gray-900">{{ date('g:i A', strtotime($event->time)) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Venue</p>
                                        <p class="text-gray-900">{{ $event->venue }}</p>
                                    </div>
                                </div>

                                @if($event->organizer_name)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Organizer</p>
                                            <p class="text-gray-900">{{ $event->organizer_name }}</p>
                                            @if($event->organizer_contact)
                                                <p class="text-sm text-gray-600">{{ $event->organizer_contact }}</p>
                                            @endif
                                            @if($event->organizer_email)
                                                <p class="text-sm text-gray-600">{{ $event->organizer_email }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($event->max_participants)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Participants</p>
                                            <p class="text-gray-900">
                                                {{ $event->confirmed_participants_count }} / {{ $event->max_participants }}
                                                @if($event->available_slots !== null)
                                                    <span class="text-sm text-gray-600">
                                                        ({{ $event->available_slots }} spots remaining)
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Related Events -->
                            @if($relatedEvents->count() > 0)
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Events</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($relatedEvents as $relatedEvent)
                                            <a href="{{ route('events.show', $relatedEvent) }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                                <h4 class="font-semibold text-gray-900">{{ $relatedEvent->title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ $relatedEvent->date->format('M d, Y') }} • {{ $relatedEvent->venue }}
                                                </p>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Registration Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 p-6 rounded-lg sticky top-4">
                                @if($isRegistered)
                                    <div class="mb-4">
                                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                                            <p class="font-semibold">✓ Registered</p>
                                            <p class="text-sm mt-1">Status: {{ ucfirst($registrationStatus) }}</p>
                                        </div>
                                    </div>

                                    @if(!$event->isPast())
                                        <form action="{{ route('registrations.unregister', $event) }}" method="POST" class="mb-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium transition-colors">
                                                Unregister
                                            </button>
                                        </form>
                                    @endif

                                    @if($isManager)
                                        <a href="{{ route('manager.events.participants', $event) }}" class="block w-full text-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md font-medium transition-colors mb-4">
                                            View Participants
                                        </a>
                                    @endif
                                @else
                                    @auth
                                        @if($event->canAcceptRegistrations())
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Register for this Event</h3>
                                            <form action="{{ route('registrations.register', $event) }}" method="POST">
                                                @csrf
                                                
                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                                                            Full Name *
                                                        </label>
                                                        <input 
                                                            type="text" 
                                                            id="full_name" 
                                                            name="full_name" 
                                                            value="{{ old('full_name', auth()->user()->name) }}"
                                                            required
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        >
                                                        @error('full_name')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                                            Email Address *
                                                        </label>
                                                        <input 
                                                            type="email" 
                                                            id="email" 
                                                            name="email" 
                                                            value="{{ old('email', auth()->user()->email) }}"
                                                            required
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        >
                                                        @error('email')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">
                                                            Phone Number *
                                                        </label>
                                                        <input 
                                                            type="text" 
                                                            id="phone_number" 
                                                            name="phone_number" 
                                                            value="{{ old('phone_number', auth()->user()->phone_number) }}"
                                                            required
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        >
                                                        @error('phone_number')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label for="kulliyah" class="block text-sm font-medium text-gray-700 mb-1">
                                                            Kulliyah *
                                                        </label>
                                                        <input 
                                                            type="text" 
                                                            id="kulliyah" 
                                                            name="kulliyah" 
                                                            value="{{ old('kulliyah') }}"
                                                            placeholder="Enter your kulliyah"
                                                            required
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        >
                                                        @error('kulliyah')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <button type="submit" class="w-full px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md font-medium transition-colors">
                                                        Complete Registration
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
                                                <p class="font-semibold">Registration Closed</p>
                                                @if($event->isFull())
                                                    <p class="text-sm mt-1">This event is full.</p>
                                                @elseif($event->isPast())
                                                    <p class="text-sm mt-1">This event has already passed.</p>
                                                @else
                                                    <p class="text-sm mt-1">Registration is not currently available.</p>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                                            <p class="font-semibold mb-2">Login Required</p>
                                            <p class="text-sm mb-3">Please login to register for this event.</p>
                                            <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md font-medium transition-colors">
                                                Login
                                            </a>
                                        </div>
                                    @endauth
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
