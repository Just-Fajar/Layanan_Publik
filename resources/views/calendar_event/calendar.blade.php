<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Kegiatan - Layanan Publik</title>
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
                        <a class="nav-link" href="{{ route('calendar.index') }}">← Tampilan Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-calendar-alt text-primary"></i> Agenda Bulan {{ \Carbon\Carbon::create($year, $month, 1)->locale('id')->isoFormat('MMMM Y') }}</h2>
                <div>
                    <a href="{{ route('calendar.view', ['year' => $month == 1 ? $year - 1 : $year, 'month' => $month == 1 ? 12 : $month - 1]) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-chevron-left"></i> Bulan Lalu
                    </a>
                    <a href="{{ route('calendar.view', ['year' => $month == 12 ? $year + 1 : $year, 'month' => $month == 12 ? 1 : $month + 1]) }}" class="btn btn-outline-secondary btn-sm">
                        Bulan Depan <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>

            <div class="row g-3">
                @forelse($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-start border-4 border-primary">
                            <div class="card-body">
                                <div class="badge bg-primary mb-2">{{ $event->category_label ?? $event->category }}</div>
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-calendar"></i> {{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }}
                                </p>
                                @if($event->location)
                                    <p class="card-text text-muted small mb-3">
                                        <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                    </p>
                                @endif
                                <a href="{{ route('calendar.show', $event) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                        <h5>Tidak ada kegiatan pada bulan ini</h5>
                    </div>
                @endforelse
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
