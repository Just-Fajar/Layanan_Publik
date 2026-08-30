@extends('errors.layout')

@section('title', '503 - Pemeliharaan Sistem')

@section('content')
    <div class="error-visual-wrapper">
        <div class="error-code-badge" style="background: linear-gradient(135deg, #ffffff 30%, #38bdf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">503</div>
    </div>

    <div class="error-icon-box" style="background: rgba(56, 189, 248, 0.15); border-color: rgba(56, 189, 248, 0.3); color: #38bdf8; box-shadow: 0 8px 20px rgba(56, 189, 248, 0.2);">
        <i class="fa-solid fa-wrench"></i>
    </div>

    <h1 class="error-title">Pemeliharaan Sistem</h1>

    <p class="error-desc">
        Kami sedang melakukan peningkatan infrastruktur dan pemeliharaan sistem berkala agar layanan publik makin cepat dan handal. Sistem akan segera kembali beroperasi normal.
    </p>

    <div class="error-actions">
        <button type="button" onclick="window.location.reload();" class="btn-action-primary">
            <i class="fa-solid fa-rotate-right"></i>
            <span>Periksa Kembali</span>
        </button>
        <a href="https://madiunkab.go.id/" target="_blank" rel="noopener noreferrer" class="btn-action-secondary">
            <i class="fa-solid fa-globe"></i>
            <span>Website Pemkab</span>
        </a>
    </div>
@endsection
