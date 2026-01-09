@extends('layouts.app')

@section('title', 'IIUM Campus Events')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">IIUM Campus Events</h1>
            <p class="text-gray-600 text-lg">Discover and join exciting events happening across campus. From technical workshops to cultural celebrations, there's something for everyone.</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('events.search') }}" method="GET" class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q', $searchTerm ?? '') }}" 
                    placeholder="Search events, venues, or organizers..."
                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white"
                >
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>

        <!-- Filters & Sort Section -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    Filters & Sort
                    <svg class="h-5 w-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </h3>
            </div>

            <form action="{{ route('events.filter') }}" method="GET" id="filterForm" class="space-y-4">
                <!-- Category Pills -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <div class="flex flex-wrap gap-2">
                        <button 
                            type="button"
                            onclick="window.location.href='{{ route('events.index') }}'"
                            class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ !request('category') ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                        >
                            All Categories
                        </button>
                        @foreach($categories as $category)
                            <button
                                type="button"
                                onclick="document.getElementById('categoryInput').value='{{ $category->slug }}'; document.getElementById('filterForm').submit();"
                                class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request('category') == $category->slug ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                            >
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="categoryInput" name="category" value="{{ request('category') }}">
                </div>

                <!-- Status, Sort By, Order -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Status Dropdown -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select 
                            name="status" 
                            onchange="document.getElementById('filterForm').submit();"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white"
                        >
                            <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Events</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        </select>
                    </div>

                    <!-- Sort By Dropdown -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select 
                            name="sort" 
                            onchange="document.getElementById('filterForm').submit();"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white"
                        >
                            <option value="date" {{ request('sort') == 'date' || !request('sort') ? 'selected' : '' }}>Date</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="participants" {{ request('sort') == 'participants' ? 'selected' : '' }}>Participants</option>
                        </select>
                    </div>

                    <!-- Order Dropdown -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                        <select 
                            name="order" 
                            onchange="document.getElementById('filterForm').submit();"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white"
                        >
                            <option value="asc" {{ request('order') == 'asc' || !request('order') ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Events Grid -->
        @if(isset($searchTerm))
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800">
                    Search results for: <span class="font-semibold">"{{ $searchTerm }}"</span>
                </h3>
            </div>
        @endif

        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No events found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(isset($searchTerm))
                        Try adjusting your search criteria or <a href="{{ route('events.index') }}" class="text-teal-600 hover:text-teal-700 font-medium">view all events</a>.
                    @else
                        There are no events matching your filters. <a href="{{ route('events.index') }}" class="text-teal-600 hover:text-teal-700 font-medium">Clear filters</a>.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
