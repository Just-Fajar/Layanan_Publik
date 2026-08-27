<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kalender Event Daerah - Diskominfo Kabupaten Madiun')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: {
                            900: '#0f172a',
                            950: '#0b1329',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
        }
    </style>
    
    @stack('styles')
</head>

<body class="min-h-screen flex flex-col justify-between bg-slate-50 text-slate-800">
    <!-- Navbar Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Left: Portal Back Button & Brand -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('homepage') }}" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:text-brand-600 hover:border-brand-300 hover:bg-brand-50 text-xs font-semibold font-heading transition" title="Kembali ke Portal Utama Diskominfo">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Portal Utama</span>
                    </a>

                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    <a href="{{ route('calendar.index') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-brand-50 border border-brand-200 flex items-center justify-center text-brand-600 group-hover:scale-105 transition">
                            <i class="fa-regular fa-calendar-days text-lg"></i>
                        </div>
                        <div>
                            <div class="font-heading font-extrabold text-slate-900 text-lg leading-tight group-hover:text-brand-600 transition">
                                Kalender Event
                            </div>
                            <div class="text-xs text-slate-500 font-medium leading-none">
                                Kabupaten Madiun
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Center: Navigation Links (Calendar Module ONLY) -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('calendar.index') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('calendar.index') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-list-ul mr-1.5 opacity-80"></i> Daftar Event
                    </a>

                    <a href="{{ route('calendar.view') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('calendar.view') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                        <i class="fa-regular fa-calendar-check mr-1.5 opacity-80"></i> Kalender Jadwal
                    </a>

                    @auth
                        <a href="{{ route('calendar.user.events.index') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('calendar.user.events.*') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-ticket mr-1.5 opacity-80"></i> Event Saya
                        </a>
                    @endauth
                </nav>

                <!-- Right: Auth Actions / Profile -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <!-- Authenticated User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2.5 px-3 py-2 rounded-xl border border-slate-200 bg-white hover:border-brand-300 hover:bg-slate-50 transition shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center font-heading font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username ?? 'U', 0, 1)) }}
                                </div>
                                <span class="font-heading text-sm font-semibold text-slate-800">{{ auth()->user()->name ?? auth()->user()->username }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                            </button>
                            
                            <!-- Dropdown Box -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <div class="text-xs text-slate-400 font-medium">Masuk sebagai</div>
                                    <div class="font-heading font-bold text-sm text-slate-800 truncate">{{ auth()->user()->name ?? auth()->user()->username }}</div>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('calendar.user.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition">
                                        <i class="fa-solid fa-gauge text-slate-400"></i> Dashboard Peserta
                                    </a>
                                    <a href="{{ route('calendar.user.events.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition">
                                        <i class="fa-solid fa-ticket text-slate-400"></i> Tiket & Event Saya
                                    </a>
                                    <a href="{{ route('calendar.user.profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition">
                                        <i class="fa-regular fa-user text-slate-400"></i> Pengaturan Akun
                                    </a>
                                </div>
                                <div class="border-t border-slate-100 pt-1">
                                    <form method="POST" action="{{ route('calendar.auth.logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Auth Buttons -->
                        <a href="{{ route('calendar.auth.login') }}" class="px-4 py-2 rounded-xl text-sm font-heading font-semibold text-slate-700 hover:text-brand-600 hover:bg-slate-100 transition">
                            Masuk
                        </a>
                        <a href="{{ route('calendar.auth.register') }}" class="px-4 py-2 rounded-xl text-sm font-heading font-bold text-white bg-brand-600 hover:bg-brand-700 transition shadow-sm shadow-brand-500/20">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100" onclick="toggleMobileMenu()" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Navigation Dropdown -->
            <div id="mobileMenu" class="hidden md:hidden pb-5 pt-2 border-t border-slate-200">
                <div class="flex flex-col space-y-1">
                    <a href="{{ route('homepage') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-500 hover:bg-slate-100">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Portal Utama
                    </a>
                    <a href="{{ route('calendar.index') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold {{ request()->routeIs('calendar.index') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-list-ul mr-2"></i> Daftar Event
                    </a>
                    <a href="{{ route('calendar.view') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold {{ request()->routeIs('calendar.view') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-100' }}">
                        <i class="fa-regular fa-calendar-check mr-2"></i> Kalender Jadwal
                    </a>
                    
                    @auth
                        <div class="border-t border-slate-200 pt-2 mt-2">
                            <a href="{{ route('calendar.user.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-700 hover:bg-slate-100 block">
                                <i class="fa-solid fa-gauge mr-2"></i> Dashboard Peserta
                            </a>
                            <a href="{{ route('calendar.user.events.index') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-700 hover:bg-slate-100 block">
                                <i class="fa-solid fa-ticket mr-2"></i> Event Saya
                            </a>
                            <a href="{{ route('calendar.user.profile.edit') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-700 hover:bg-slate-100 block">
                                <i class="fa-regular fa-user mr-2"></i> Edit Profil
                            </a>
                            <form method="POST" action="{{ route('calendar.auth.logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-heading font-semibold text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-slate-200 pt-3 mt-2 grid grid-cols-2 gap-2">
                            <a href="{{ route('calendar.auth.login') }}" class="px-3 py-2 rounded-xl text-center text-sm font-heading font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100">
                                Masuk
                            </a>
                            <a href="{{ route('calendar.auth.register') }}" class="px-3 py-2 rounded-xl text-center text-sm font-heading font-bold text-white bg-brand-600 hover:bg-brand-700">
                                Daftar Akun
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 mt-16 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-slate-800">
                <!-- Col 1: Identity -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white">
                            <i class="fa-regular fa-calendar-days text-sm"></i>
                        </div>
                        <h4 class="font-heading font-bold text-white text-base">Kalender Event Kabupaten Madiun</h4>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-md">
                        Platform agenda terpadu Dinas Komunikasi dan Informatika Kabupaten Madiun untuk menginformasikan seminar, festival budaya, sosialisasi publik, dan kegiatan daerah secara transparan.
                    </p>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h5 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-4">Navigasi Kalender</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('calendar.index') }}" class="hover:text-brand-400 transition flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-xs opacity-50"></i> Daftar Agenda Event</a></li>
                        <li><a href="{{ route('calendar.view') }}" class="hover:text-brand-400 transition flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-xs opacity-50"></i> Kalender Bulanan</a></li>
                        <li><a href="{{ route('homepage') }}" class="hover:text-brand-400 transition flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-xs opacity-50"></i> Portal Utama Diskominfo</a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact Info -->
                <div>
                    <h5 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-4">Pusat Informasi</h5>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot mt-1 text-slate-500 text-xs"></i>
                            <span>Jl. Mastrip No.23, Mojorejo, Taman, Kota Madiun</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-slate-500 text-xs"></i>
                            <span>(0351) 462927</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-slate-500 text-xs"></i>
                            <span>diskominfo@madiunkab.go.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Madiun. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-3">
                    <a href="https://www.instagram.com/kominfokabmadiun/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="Instagram"><i class="fa-brands fa-instagram text-base"></i></a>
                    <a href="https://www.youtube.com/@diskominfokabupatenmadiun717" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="YouTube"><i class="fa-brands fa-youtube text-base"></i></a>
                    <a href="https://madiunkab.go.id/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="Website Pemkab"><i class="fa-solid fa-globe text-base"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) menu.classList.toggle('hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
