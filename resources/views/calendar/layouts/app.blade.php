<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Calendar Event - Public Services')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('calendar.index') }}" class="flex items-center space-x-3">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                        <span class="text-white text-xl font-bold">Calendar Event</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('calendar.index') }}" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-calendar-alt mr-1"></i> Events
                    </a>

                    @auth
                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-white hover:text-gray-200 transition">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span>{{ auth()->user()->name ?? auth()->user()->username }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <a href="{{ route('calendar.user.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50 transition">
                                        <i class="fas fa-home mr-2 text-blue-600"></i> Dashboard
                                    </a>
                                    <a href="{{ route('calendar.user.profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50 transition">
                                        <i class="fas fa-user-edit mr-2 text-green-600"></i> Edit Profile
                                    </a>
                                    <a href="{{ route('calendar.user.events.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50 transition">
                                        <i class="fas fa-calendar-check mr-2 text-purple-600"></i> My Events
                                    </a>
                                    <div class="border-t my-2"></div>
                                    <form method="POST" action="{{ route('calendar.auth.logout') }}" class="px-4 py-2">
                                        @csrf
                                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-800 transition">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Links -->
                        <a href="{{ route('calendar.auth.login') }}" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="{{ route('calendar.auth.register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('calendar.index') }}" class="text-white hover:text-gray-200 transition py-2">
                        <i class="fas fa-calendar-alt mr-2"></i> Events
                    </a>
                    
                    @auth
                        <div class="border-t border-white border-opacity-20 mt-2 pt-2">
                            <a href="{{ route('calendar.user.dashboard') }}" class="text-white hover:text-gray-200 transition py-2 block">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                            <a href="{{ route('calendar.user.profile.edit') }}" class="text-white hover:text-gray-200 transition py-2 block">
                                <i class="fas fa-user-edit mr-2"></i> Edit Profile
                            </a>
                            <a href="{{ route('calendar.user.events.index') }}" class="text-white hover:text-gray-200 transition py-2 block">
                                <i class="fas fa-calendar-check mr-2"></i> My Events
                            </a>
                            <form method="POST" action="{{ route('calendar.auth.logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="text-white hover:text-gray-200 transition py-2 w-full text-left">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-white border-opacity-20 mt-2 pt-2">
                            <a href="{{ route('calendar.auth.login') }}" class="text-white hover:text-gray-200 transition py-2 block">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>
                            <a href="{{ route('calendar.auth.register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition block text-center mt-2">
                                <i class="fas fa-user-plus mr-1"></i> Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Calendar Event</h3>
                    <p class="text-gray-400">Your gateway to exciting events and activities.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('calendar.index') }}" class="text-gray-400 hover:text-white transition">Events</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@calendarevent.com</li>
                        <li><i class="fas fa-phone mr-2"></i> +62 xxx xxxx xxxx</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Your Location</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Calendar Event. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
