@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="mt-8 mb-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Image Container with Rounded Corners -->
        <div class="relative h-[600px] md:h-[700px] rounded-2xl overflow-hidden shadow-xl">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/scene_1.jpg') }}"
                     alt="IIUM Campus Aerial View"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 to-gray-900/40"></div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 h-full flex flex-col justify-center px-4 sm:px-6 lg:px-8">
                <!-- Text Content -->
                <div class="text-white max-w-2xl">
                    <p class="text-lg md:text-xl mb-4 font-medium">FIND OR CREATE EVERY EVENT, PROGRAM, AND OPPORTUNITY HAPPENING ACROSS THE CAMPUS</p>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Your Campus Life, Happening Now!
                    </h1>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        @auth
                            @if(auth()->user()->isEventManager())
                                <a href="{{ route('manager.events.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md transition-colors">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Create An Event Now
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create An Event Now
                            </a>
                        @endauth

                        <!-- Play Button -->
                        <button class="inline-flex items-center justify-center w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Social Media Icons -->
                    <div class="mb-8">
                        <p class="text-sm mb-3 opacity-90">Follow Us</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-white hover:text-teal-400 transition-colors">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-white hover:text-teal-400 transition-colors">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-white hover:text-teal-400 transition-colors">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-white hover:text-teal-400 transition-colors">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Card - Bottom Right Corner -->
            <div class="absolute bottom-0 right-0 z-20 hidden lg:block">
                <div class="bg-teal-500 rounded-t-3xl p-6 text-white shadow-2xl max-w-sm">
                    <a href="{{ route('events.index') }}" class="flex items-center justify-between mb-4 hover:underline">
                        <span class="font-semibold">Explore More</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">IIUM</div>
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">ES</div>
                        </div>
                        <p class="text-sm opacity-90">Interesting Events Secure Your Spot. Filter Events</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Events Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Popular Event</h2>
            <p class="text-gray-600 text-lg">Don't Miss Out! Spots Fill Up Fast.</p>
        </div>

        <!-- Events Grid -->
        @php
            $popularEvents = \App\Models\Event::query()
                ->with(['categories', 'manager'])
                ->where('status', \App\Models\Event::STATUS_OPEN)
                ->upcoming()
                ->orderBy('date', 'asc')
                ->limit(6)
                ->get();
        @endphp

        @if($popularEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>

            <!-- View All Events Button -->
            <div class="text-center mt-12">
                <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md transition-colors">
                    View All Events
                    <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">No popular events at the moment. Check back soon!</p>
            </div>
        @endif
    </div>
</section>
@endsection
