<nav x-data="{ open: false }" class="relative bg-white">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Mobile menu button -->
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button type="button" @click="open = ! open" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-2 focus:-outline-offset-1 focus:outline-teal-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg x-show="open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- Logo and Navigation Links -->
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <!-- Crown/Group Icon -->
                        <svg class="h-8 w-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-black leading-tight">Happening@</span>
                            <span class="text-sm font-bold text-black leading-tight">IIUM</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                            Home
                        </a>
                        <a href="{{ route('events.index') }}" class="rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('events.*') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                            Event
                        </a>
                        @auth
                            <a href="{{ route('registrations.my-events') }}" class="rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('registrations.*') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                                My Events
                            </a>
                            @if(auth()->user()->isEventManager())
                                <a href="{{ route('manager.dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('manager.*') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                                    Admin Panel
                                </a>
                            @endif
                        @else
                            <a href="{{ route('registrations.my-events') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-teal-600 transition-colors">
                                My Events
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- User Section (Desktop) -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                @auth
                    <!-- Clickable Profile Icon and Name -->
                    <a href="{{ route('profile.edit') }}" class="relative flex items-center space-x-2 rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 hover:opacity-80 transition-opacity">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                        @if(auth()->user()->profile_picture)
                            <img src="{{ auth()->user()->profile_picture_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="h-8 w-8 rounded-full object-cover border-2 border-gray-300">
                        @else
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300">
                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                        <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    </a>
                    @if(auth()->user()->isEventManager())
                        <span class="ml-3 px-3 py-1 bg-teal-500 text-white text-sm font-medium rounded-md">Admin</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-teal-600 px-3 py-2 text-sm font-medium transition-colors">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="ml-3 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md text-sm font-medium transition-colors">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-cloak class="block sm:hidden">
        <div class="space-y-1 px-2 pt-2 pb-3">
            <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors {{ request()->routeIs('home') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                Home
            </a>
            <a href="{{ route('events.index') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors {{ request()->routeIs('events.*') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                Event
            </a>
            @auth
                <a href="{{ route('registrations.my-events') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors {{ request()->routeIs('registrations.*') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                    My Events
                </a>
                @if(auth()->user()->isEventManager())
                    <a href="{{ route('manager.dashboard') }}" class="block rounded-md px-3 py-2 text-base font-medium transition-colors {{ request()->routeIs('manager.*') ? 'bg-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                        Admin Panel
                    </a>
                @endif
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 px-3 py-2">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ auth()->user()->profile_picture_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="h-8 w-8 rounded-full object-cover">
                        @else
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <div class="text-sm text-gray-700 font-medium">{{ Auth::user()->name }}</div>
                            @if(auth()->user()->isEventManager())
                                <span class="text-xs px-2 py-0.5 bg-teal-500 text-white rounded">Admin</span>
                            @endif
                        </div>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                            Log Out
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 transition-colors">Log in</a>
                <a href="{{ route('register') }}" class="block rounded-md px-3 py-2 text-base font-medium bg-teal-500 text-white">Register</a>
            @endauth
        </div>
    </div>
</nav>

<style>
    [x-cloak] { display: none !important; }
</style>
