<footer class="bg-gray-800 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Happening@IIUM</h3>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Your one-stop platform for discovering and participating in college events. Stay connected with your campus community.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-teal-400 transition-colors">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}" class="text-sm text-gray-400 hover:text-teal-400 transition-colors">Browse Events</a>
                    </li>
                    @auth
                        @if(auth()->user()->isEventManager())
                            <li>
                                <a href="{{ route('manager.dashboard') }}" class="text-sm text-gray-400 hover:text-teal-400 transition-colors">Admin Panel</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Support</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>support@iium.edu.my</li>
                    <li>+1 (555) 123-4567</li>
                    <li>Mon-Fri 10AM-5PM</li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
            <p class="text-sm text-gray-400">© {{ date('Y') }} Happening@IIUM. All rights reserved.</p>
        </div>
    </div>
</footer>
