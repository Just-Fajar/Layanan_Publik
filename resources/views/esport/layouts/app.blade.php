<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'M-GEN Esport - Diskominfo Kabupaten Madiun')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        dark: {
                            950: '#060911',
                            900: '#090d16',
                            850: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                        },
                        brand: {
                            cyan: '#06b6d4',
                            'cyan-hover': '#0891b2',
                            purple: '#8b5cf6',
                            gold: '#f59e0b',
                            emerald: '#10b981',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #090d16;
            color: #cbd5e1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: #ffffff;
        }
        .gaming-card {
            background: #0f172a;
            border: 1px solid #1e293b;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .gaming-card:hover {
            border-color: #06b6d4;
            transform: translateY(-3px);
            box-shadow: 0 14px 28px -8px rgba(6, 182, 212, 0.15);
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen flex flex-col justify-between bg-dark-900 text-slate-300">
    <!-- Navbar Header -->
    <header class="sticky top-0 z-50 bg-dark-900/90 backdrop-blur-md border-b border-dark-800 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Left: Portal Back Button & M-GEN Brand -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('homepage') }}" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-dark-700 bg-dark-850/60 text-slate-400 hover:text-white hover:border-brand-cyan text-xs font-semibold font-heading transition" title="Kembali ke Portal Utama Diskominfo">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Portal Utama</span>
                    </a>

                    <div class="h-6 w-px bg-dark-800 hidden sm:block"></div>

                    <a href="{{ route('esport.home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo-mgen.png') }}" alt="Logo M-GEN" class="h-10 w-auto object-contain group-hover:scale-105 transition">
                        <div>
                            <div class="font-heading font-extrabold text-white text-lg leading-tight tracking-wider group-hover:text-brand-cyan transition">
                                M-GEN <span class="text-xs px-2 py-0.5 rounded bg-brand-cyan/10 text-brand-cyan border border-brand-cyan/20">ESPORT</span>
                            </div>
                            <div class="text-xs text-slate-400 font-medium leading-none">
                                Diskominfo Kab. Madiun
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Center: Navigation Links (Esport Module ONLY) -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('esport.home') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('esport.home') ? 'bg-dark-800 text-brand-cyan font-bold border border-brand-cyan/30' : 'text-slate-400 hover:text-white hover:bg-dark-850' }}">
                        Beranda
                    </a>
                    <a href="{{ route('esport.tournaments.index') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('esport.tournaments.*') ? 'bg-dark-800 text-brand-cyan font-bold border border-brand-cyan/30' : 'text-slate-400 hover:text-white hover:bg-dark-850' }}">
                        <i class="fa-solid fa-trophy mr-1 text-xs opacity-70"></i> Turnamen
                    </a>
                    <a href="{{ route('esport.news.index') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('esport.news.*') ? 'bg-dark-800 text-brand-cyan font-bold border border-brand-cyan/30' : 'text-slate-400 hover:text-white hover:bg-dark-850' }}">
                        <i class="fa-solid fa-newspaper mr-1 text-xs opacity-70"></i> Berita
                    </a>
                    <a href="{{ route('esport.about') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('esport.about') ? 'bg-dark-800 text-brand-cyan font-bold border border-brand-cyan/30' : 'text-slate-400 hover:text-white hover:bg-dark-850' }}">
                        Tentang
                    </a>
                    <a href="{{ route('esport.contact') }}" class="px-3.5 py-2 rounded-lg font-heading text-sm font-semibold transition {{ request()->routeIs('esport.contact') ? 'bg-dark-800 text-brand-cyan font-bold border border-brand-cyan/30' : 'text-slate-400 hover:text-white hover:bg-dark-850' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Right: Auth / Profile -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <!-- Authenticated User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl border border-dark-700 bg-dark-850 hover:border-brand-cyan transition shadow-sm">
                                <div class="w-7 h-7 rounded-lg bg-brand-cyan/20 text-brand-cyan border border-brand-cyan/40 flex items-center justify-center font-heading font-bold text-xs">
                                    {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username ?? 'U', 0, 1)) }}
                                </div>
                                <span class="font-heading text-sm font-semibold text-white">{{ auth()->user()->name ?? auth()->user()->username }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-500"></i>
                            </button>
                            
                            <!-- Dropdown Box -->
                            <div class="absolute right-0 mt-2 w-56 bg-dark-850 rounded-2xl shadow-2xl border border-dark-700 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="px-4 py-2 border-b border-dark-700">
                                    <div class="text-xs text-slate-500 font-medium">Akun Gamers</div>
                                    <div class="font-heading font-bold text-sm text-white truncate">{{ auth()->user()->name ?? auth()->user()->username }}</div>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('esport.user.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-300 hover:bg-dark-800 hover:text-brand-cyan transition">
                                        <i class="fa-solid fa-gamepad text-slate-500"></i> Dashboard Tim
                                    </a>
                                    <a href="{{ route('esport.user.tournaments.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-300 hover:bg-dark-800 hover:text-brand-cyan transition">
                                        <i class="fa-solid fa-trophy text-slate-500"></i> Pendaftaran Saya
                                    </a>
                                    <a href="{{ route('esport.user.profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-300 hover:bg-dark-800 hover:text-brand-cyan transition">
                                        <i class="fa-regular fa-user text-slate-500"></i> Edit Profil
                                    </a>
                                </div>
                                <div class="border-t border-dark-700 pt-1">
                                    <form method="POST" action="{{ route('esport.auth.logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-400 hover:bg-red-950/40 hover:text-red-300 transition text-left">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Buttons -->
                        <a href="{{ route('esport.auth.login') }}" class="px-4 py-2 rounded-xl text-sm font-heading font-semibold text-slate-300 hover:text-white hover:bg-dark-850 transition">
                            Masuk
                        </a>
                        <a href="{{ route('esport.auth.register') }}" class="px-4 py-2 rounded-xl text-sm font-heading font-bold text-dark-950 bg-brand-cyan hover:bg-brand-cyan-hover transition shadow-sm shadow-cyan-500/20">
                            Daftar Gamers
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 rounded-lg text-slate-400 hover:bg-dark-850 hover:text-white" onclick="toggleMobileMenu()" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="hidden md:hidden pb-5 pt-2 border-t border-dark-800">
                <div class="flex flex-col space-y-1">
                    <a href="{{ route('homepage') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-500 hover:bg-dark-850 hover:text-white">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Portal Utama
                    </a>
                    <a href="{{ route('esport.home') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold {{ request()->routeIs('esport.home') ? 'bg-dark-800 text-brand-cyan' : 'text-slate-300 hover:bg-dark-850' }}">
                        Beranda
                    </a>
                    <a href="{{ route('esport.tournaments.index') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold {{ request()->routeIs('esport.tournaments.*') ? 'bg-dark-800 text-brand-cyan' : 'text-slate-300 hover:bg-dark-850' }}">
                        <i class="fa-solid fa-trophy mr-2"></i> Turnamen
                    </a>
                    <a href="{{ route('esport.news.index') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold {{ request()->routeIs('esport.news.*') ? 'bg-dark-800 text-brand-cyan' : 'text-slate-300 hover:bg-dark-850' }}">
                        <i class="fa-solid fa-newspaper mr-2"></i> Berita
                    </a>
                    <a href="{{ route('esport.about') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold {{ request()->routeIs('esport.about') ? 'bg-dark-800 text-brand-cyan' : 'text-slate-300 hover:bg-dark-850' }}">
                        Tentang M-GEN
                    </a>
                    <a href="{{ route('esport.contact') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold {{ request()->routeIs('esport.contact') ? 'bg-dark-800 text-brand-cyan' : 'text-slate-300 hover:bg-dark-850' }}">
                        Kontak Panitia
                    </a>

                    @auth
                        <div class="border-t border-dark-800 pt-2 mt-2">
                            <a href="{{ route('esport.user.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-300 hover:bg-dark-850 block">
                                <i class="fa-solid fa-gamepad mr-2"></i> Dashboard Tim
                            </a>
                            <a href="{{ route('esport.user.tournaments.index') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-300 hover:bg-dark-850 block">
                                <i class="fa-solid fa-trophy mr-2"></i> Pendaftaran Saya
                            </a>
                            <a href="{{ route('esport.user.profile.edit') }}" class="px-3 py-2 rounded-lg text-sm font-heading font-semibold text-slate-300 hover:bg-dark-850 block">
                                <i class="fa-regular fa-user mr-2"></i> Edit Profil
                            </a>
                            <form method="POST" action="{{ route('esport.auth.logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-heading font-semibold text-red-400 hover:bg-red-950/40">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-dark-800 pt-3 mt-2 grid grid-cols-2 gap-2">
                            <a href="{{ route('esport.auth.login') }}" class="px-3 py-2 rounded-xl text-center text-sm font-heading font-semibold border border-dark-700 text-slate-300 hover:bg-dark-850">
                                Masuk
                            </a>
                            <a href="{{ route('esport.auth.register') }}" class="px-3 py-2 rounded-xl text-center text-sm font-heading font-bold text-dark-950 bg-brand-cyan hover:bg-brand-cyan-hover">
                                Daftar Gamers
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-950 text-slate-400 border-t border-dark-800 mt-16 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-dark-800">
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-mgen.png') }}" alt="M-GEN" class="h-8 w-auto">
                        <h4 class="font-heading font-bold text-white text-base">M-GEN Esport Kabupaten Madiun</h4>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-md">
                        Wadah resmi pembinaan atlet, turnamen game kompetitif, dan komunitas gamers di bawah naungan Dinas Komunikasi dan Informatika Kabupaten Madiun.
                    </p>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h5 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-4">Navigasi Esport</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('esport.tournaments.index') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-xs opacity-50"></i> Jadwal Turnamen</a></li>
                        <li><a href="{{ route('esport.news.index') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-xs opacity-50"></i> Kabar & Berita</a></li>
                        <li><a href="{{ route('esport.about') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-xs opacity-50"></i> Profil Divisi M-GEN</a></li>
                        <li><a href="{{ route('homepage') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-xs opacity-50"></i> Portal Utama Diskominfo</a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact & Info -->
                <div>
                    <h5 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-4">Pusat Informasi</h5>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot mt-1 text-slate-500 text-xs"></i>
                            <span>Jl. Mastrip No.23, Mojorejo, Taman, Kota Madiun</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-slate-500 text-xs"></i>
                            <span>diskominfo@madiunkab.go.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} M-GEN Diskominfo Kabupaten Madiun. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-3">
                    <a href="https://www.instagram.com/kominfokabmadiun/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="Instagram"><i class="fa-brands fa-instagram text-base"></i></a>
                    <a href="https://www.youtube.com/@diskominfokabupatenmadiun717" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="YouTube"><i class="fa-brands fa-youtube text-base"></i></a>
                    <a href="https://madiunkab.go.id/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="Website Pemkab"><i class="fa-solid fa-globe text-base"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 600,
                    easing: 'ease-out-cubic',
                    once: true
                });
            }
        });

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) menu.classList.toggle('hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
