@extends('errors.layout')

@section('title', '403 - Akses Dibatasi')

@section('content')
    <div class="error-visual-wrapper">
        <div class="error-code-badge" style="background: linear-gradient(135deg, #ffffff 30%, #f59e0b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">403</div>
    </div>

    <div class="error-icon-box" style="background: rgba(245, 158, 11, 0.15); border-color: rgba(245, 158, 11, 0.3); color: #f59e0b; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.2);">
        <i class="fa-solid fa-shield-halved"></i>
    </div>

    <h1 class="error-title">Akses Dibatasi</h1>

    <p class="error-desc">
        Akun Anda saat ini tidak memiliki wewenang atau hak akses untuk membuka halaman ini. Silakan kembali ke portal utama atau hubungi administrator sistem jika membutuhkan izin khusus.
    </p>

    <div class="error-actions">
        <a href="{{ route('homepage') }}" class="btn-action-primary">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Portal</span>
        </a>
        <a href="{{ route('admin.login') }}" class="btn-action-secondary">
            <i class="fa-solid fa-user-lock"></i>
            <span>Portal Admin</span>
        </a>
    </div>
@endsection
