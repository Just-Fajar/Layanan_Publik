<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar Event - Layanan Publik Kota Madiun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('homepage') }}">
                <i class="fas fa-home"></i> Layanan Publik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homepage') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('buku-tamu') }}">Buku Tamu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('esport.home') }}">Esport</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('calendar.index') }}">Calendar Event</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h1 class="mb-2"><i class="fas fa-calendar-alt text-primary"></i> Calendar Event</h1>
                    <p class="text-muted">Temukan berbagai event dan kegiatan menarik</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('calendar.view') }}" class="btn btn-outline-primary">
                        <i class="fas fa-calendar"></i> Lihat Kalender
                    </a>
                </div>
            </div>

            <!-- Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('calendar.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="category_filter" class="form-label">Kategori</label>
                            <select id="category_filter" name="category" class="form-select" aria-label="Pilih Kategori Event">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="search_event" class="form-label">Cari Event</label>
                            <input type="text" id="search_event" name="search" class="form-control" 
                                   placeholder="Cari berdasarkan judul atau lokasi..."
                                   value="{{ request('search') }}"
                                   aria-label="Cari berdasarkan judul atau lokasi">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-none d-md-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100" aria-label="Tombol Cari Event">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Events Grid -->
            @if($events->count() > 0)
                <div class="row g-4">
                    @foreach($events as $event)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm hover-shadow">
                                @if($event->image_url)
                                    <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-calendar-day fa-4x opacity-50"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $categories[$event->category] ?? $event->category }}</span>
                                        @if($event->is_upcoming)
                                            <span class="badge bg-success">Upcoming</span>
                                        @endif
                                    </div>
                                    <h5 class="card-title">{{ $event->title }}</h5>
                                    <p class="card-text text-muted small">
                                        {{ \Illuminate\Support\Str::limit($event->description, 100) }}
                                    </p>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i>
                                            {{ $event->start_date->format('d M Y') }}
                                        </small>
                                    </div>
                                    @if($event->location)
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $event->location }}
                                            </small>
                                        </div>
                                    @endif
                                    <a href="{{ route('calendar.show', $event) }}" class="btn btn-sm btn-outline-primary w-100">
                                        <i class="fas fa-info-circle"></i> Detail Event
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h4>Tidak ada event yang ditemukan</h4>
                    <p class="text-muted">Silakan coba dengan filter yang berbeda</p>
                </div>
            @endif
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Madiun</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
    </style>
</body>
</html>
