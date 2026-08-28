<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Esport Admin') - Layanan Publik</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-mgen.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-mgen.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between hidden md:flex">
        <div>
            <div class="p-6 border-b border-slate-800 flex items-center space-x-3">
                <i class="fas fa-gamepad text-blue-400 text-2xl"></i>
                <span class="text-xl font-bold tracking-wide">Esport Admin</span>
            </div>
            
            <nav class="p-4 space-y-1">
                <a href="{{ route('esport.admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('esport.admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-chart-line w-5 mr-3 text-center"></i> Dashboard
                </a>
                <a href="{{ route('esport.admin.tournaments.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('esport.admin.tournaments*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-trophy w-5 mr-3 text-center"></i> Tournaments
                </a>
                <a href="{{ route('esport.admin.registrations.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('esport.admin.registrations*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-clipboard-list w-5 mr-3 text-center"></i> Registrations
                </a>
                <a href="{{ route('esport.admin.news.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('esport.admin.news*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-newspaper w-5 mr-3 text-center"></i> News
                </a>
                <a href="{{ route('esport.admin.users.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('esport.admin.users*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-users w-5 mr-3 text-center"></i> Users
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-800">
            <div class="px-4 py-2 text-xs text-slate-400">
                Log Layanan Publik &copy; {{ date('Y') }}
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Admin Utama
                </a>
            </div>

            <div class="flex items-center space-x-4">
                @if(Auth::guard('admin')->check())
                    <div class="text-right">
                        <div class="text-sm font-bold text-gray-800">{{ Auth::guard('admin')->user()->name }}</div>
                        <div class="text-xs text-blue-600 capitalize font-medium">{{ Auth::guard('admin')->user()->role }}</div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                @endif
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
