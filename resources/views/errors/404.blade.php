@extends('errors.layout')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <div class="error-visual-wrapper">
        <div class="error-code-badge">404</div>
    </div>

    <div class="error-icon-box">
        <i class="fa-solid fa-compass"></i>
    </div>

    <h1 class="error-title">Halaman Tidak Ditemukan</h1>

    <p class="error-desc">
        Tautan yang Anda tuju mungkin telah dipindahkan, dihapus, atau terjadi kesalahan pengetikan alamat URL. Silakan kembali ke beranda untuk mengakses layanan lainnya.
    </p>

    <div class="error-actions">
        <a href="{{ route('homepage') }}" class="btn-action-primary">
            <i class="fa-solid fa-house"></i>
            <span>Kembali ke Beranda</span>
        </a>
        <a href="{{ route('buku-tamu') }}" class="btn-action-secondary">
            <i class="fa-solid fa-book-open"></i>
            <span>Buku Tamu</span>
        </a>
        <a href="{{ route('calendar.index') }}" class="btn-action-secondary">
            <i class="fa-regular fa-calendar-days"></i>
            <span>Kalender Event</span>
        </a>
    </div>
@endsection
