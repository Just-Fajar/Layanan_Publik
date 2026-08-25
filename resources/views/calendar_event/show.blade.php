<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Calendar Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('homepage') }}">
                <i class="fas fa-home"></i> Layanan Publik
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('calendar.index') }}">← Kembali ke Calendar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        @if($event->image_url)
                            <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="max-height: 400px; object-fit: cover;">
                        @endif
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <span class="badge bg-primary">{{ $event->category_label ?? $event->category }}</span>
                                <span class="badge bg-success">{{ ucfirst($event->status) }}</span>
                            </div>
                            <h1 class="card-title h2 mb-3">{{ $event->title }}</h1>
                            <div class="row g-3 mb-4 text-muted">
                                <div class="col-sm-6">
                                    <i class="fas fa-calendar-alt text-primary"></i> 
                                    <strong>Mulai:</strong> {{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }}
                                </div>
                                <div class="col-sm-6">
                                    <i class="fas fa-calendar-check text-primary"></i> 
                                    <strong>Selesai:</strong> {{ $event->end_date ? $event->end_date->format('d M Y, H:i') : '-' }}
                                </div>
                                @if($event->location)
                                    <div class="col-12">
                                        <i class="fas fa-map-marker-alt text-danger"></i> 
                                        <strong>Lokasi:</strong> {{ $event->location }}
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <h5 class="fw-bold mb-3">Deskripsi Kegiatan</h5>
                            <p class="card-text text-secondary" style="white-space: pre-line;">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Madiun</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
