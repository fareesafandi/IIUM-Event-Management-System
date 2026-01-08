<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('IIUM Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-64">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Filters</h3>

                        <!-- Search -->
                        <form action="{{ route('events.search') }}" method="GET" class="mb-4">
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    name="q" 
                                    value="{{ request('q') }}" 
                                    placeholder="Search events..." 
                                    class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required
                                >
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>

                        <!-- Category Filter -->
                        <form action="{{ route('events.filter') }}" method="GET" id="filterForm">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Category
                                </label>
                                <select 
                                    name="category" 
                                    onchange="document.getElementById('filterForm').submit();"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status
                                </label>
                                <select 
                                    name="status" 
                                    onchange="document.getElementById('filterForm').submit();"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                </select>
                            </div>

                            <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                Clear Filters
                            </a>
                        </form>
                    </div>

                    <!-- Quick Links -->
                    @auth
                        <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Quick Links</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('registrations.my-events') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                        My Registered Events
                                    </a>
                                </li>
                                @if(auth()->user()->isEventManager())
                                    <li>
                                        <a href="{{ route('manager.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                            Manager Dashboard
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endauth
                </aside>

                <!-- Main Content -->
                <main class="flex-1">
                    @if(isset($searchTerm))
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Search results for: <span class="font-semibold">"{{ $searchTerm }}"</span>
                            </h3>
                        </div>
                    @endif

                    @if($events->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($events as $event)
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                                    @if($event->poster_image_url)
                                        <img src="{{ $event->poster_image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <span class="text-gray-400">No Image</span>
                                        </div>
                                    @endif

                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($event->status == 'open') bg-green-100 text-green-800
                                                @elseif($event->status == 'upcoming') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                            @if($event->categories->count() > 0)
                                                <span class="text-xs text-gray-500">
                                                    {{ $event->categories->first()->name }}
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                            <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">
                                                {{ $event->title }}
                                            </a>
                                        </h3>

                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                            {{ Str::limit($event->description, 100) }}
                                        </p>

                                        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $event->date->format('M d, Y') }} at {{ date('g:i A', strtotime($event->time)) }}
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->venue }}
                                            </div>
                                            @if($event->max_participants)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                    {{ $event->confirmed_participants_count }}/{{ $event->max_participants }} participants
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-4">
                                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $events->links() }}
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No events found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                @if(isset($searchTerm))
                                    Try adjusting your search criteria.
                                @else
                                    There are no upcoming events at the moment.
                                @endif
                            </p>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
