@extends('errors.layout')

@section('title', '500 - Gangguan Server')

@section('content')
    <div class="error-visual-wrapper">
        <div class="error-code-badge" style="background: linear-gradient(135deg, #ffffff 30%, #ef4444 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">500</div>
    </div>

    <div class="error-icon-box" style="background: rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.3); color: #f87171; box-shadow: 0 8px 20px rgba(239, 68, 68, 0.2);">
        <i class="fa-solid fa-gear fa-spin" style="--fa-animation-duration: 10s;"></i>
    </div>

    <h1 class="error-title">Terjadi Gangguan pada Server</h1>

    <p class="error-desc">
        Terjadi kendala teknis tak terduga pada server saat memproses permintaan Anda. Tim teknis Diskominfo sedang menangani kendala ini. Silakan muat ulang halaman atau coba kembali dalam beberapa saat.
    </p>

    <div class="error-actions">
        <button type="button" onclick="window.location.reload();" class="btn-action-primary">
            <i class="fa-solid fa-rotate-right"></i>
            <span>Muat Ulang Halaman</span>
        </button>
        <a href="{{ route('homepage') }}" class="btn-action-secondary">
            <i class="fa-solid fa-house"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </div>
@endsection
