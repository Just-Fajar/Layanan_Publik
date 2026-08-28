<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Layanan Publik</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-diskominfo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-diskominfo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Admin Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-shield-alt"></i> Panel Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-book"></i> Buku Tamu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('esport.admin.*') ? 'active' : '' }}" href="{{ route('esport.admin.tournaments.index') }}">
                            <i class="fas fa-gamepad"></i> Esport
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('calendar.admin.*') ? 'active' : '' }}" href="{{ route('calendar.admin.events.index') }}">
                            <i class="fas fa-calendar-alt"></i> Calendar Event
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @if(Auth::guard('admin')->check())
                        <li class="nav-item me-3 text-white">
                            <i class="fas fa-user-circle"></i> {{ Auth::guard('admin')->user()->name }}
                            <span class="badge bg-light text-primary ms-1">{{ Auth::guard('admin')->user()->role }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-top py-3 mt-5">
        <div class="container-fluid text-center text-muted small">
            &copy; {{ date('Y') }} Layanan Publik DISKOMINFO Kabupaten Madiun. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
