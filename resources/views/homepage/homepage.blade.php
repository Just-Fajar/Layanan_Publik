<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portal integrasi layanan publik dan informasi resmi Diskominfo Kabupaten Madiun: Buku Tamu Digital, Kalender Event Daerah, dan Madiun Esport.">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Portal Layanan Publik Diskominfo Kabupaten Madiun">
    <meta property="og:description" content="Integrasi layanan digital dan informasi publik terpadu Diskominfo Kabupaten Madiun.">
    <meta property="og:image" content="{{ asset('images/logo-diskominfo.png') }}">
    <title>Portal Layanan Publik Diskominfo Kabupaten Madiun</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-diskominfo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-diskominfo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --brand-primary: #0369a1;
            --brand-primary-hover: #075985;
            --brand-dark: #0f172a;
            --brand-slate: #334155;
            --brand-muted: #64748b;
            --brand-light: #f8fafc;
            --brand-border: #e2e8f0;
            --header-h: 76px;
        }

        body {
            font-family: var(--font-body);
            color: var(--brand-slate);
            background-color: #ffffff;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            color: var(--brand-dark);
            font-weight: 700;
        }

        /* ===== Navbar Header ===== */
        .site-navbar {
            min-height: var(--header-h);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--brand-border);
            transition: all 0.3s ease;
            z-index: 1040;
        }

        .navbar-brand img {
            max-height: 46px;
            width: auto;
        }

        .nav-link-custom {
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 0.93rem;
            color: #334155 !important;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-custom:hover {
            color: var(--brand-primary) !important;
            background-color: #f0f9ff;
        }

        .nav-link-custom.active {
            color: #0369a1 !important;
            background-color: #e0f2fe;
        }

        .dropdown-menu-custom {
            border: 1px solid var(--brand-border);
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            padding: 8px;
        }

        .dropdown-item-custom {
            font-size: 0.9rem;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .dropdown-item-custom:hover {
            background-color: #f0f9ff;
            color: var(--brand-primary);
        }

        /* ===== Hero Section ===== */
        .hero-section {
            padding-top: calc(var(--header-h) + 40px);
            padding-bottom: 70px;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            color: #0369a1;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 0.84rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: 2.75rem;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 18px;
        }

        .hero-desc {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #475569;
            max-width: 600px;
            margin-bottom: 30px;
        }

        .hero-logo-box {
            position: relative;
            display: inline-block;
        }

        .hero-logo-box img {
            max-height: 340px;
            width: auto;
            filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.08));
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* ===== Services Section ===== */
        .services-section {
            padding: 80px 0;
            background: #ffffff;
        }

        .section-header {
            margin-bottom: 48px;
        }

        .section-tag {
            display: inline-block;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #0369a1;
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 2.1rem;
            letter-spacing: -0.01em;
            margin-bottom: 12px;
        }

        .section-subtitle {
            font-size: 1rem;
            color: #475569;
            max-width: 580px;
            margin: 0 auto;
        }

        .service-card {
            display: block;
            background: #ffffff;
            border: 1px solid var(--brand-border);
            border-radius: 18px;
            padding: 32px 28px;
            height: 100%;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .service-card:hover {
            transform: translateY(-6px);
            border-color: #7dd3fc;
            box-shadow: 0 20px 35px -10px rgba(2, 132, 199, 0.12);
        }

        .service-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: #f0f9ff;
            border: 1px solid #e0f2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            transition: transform 0.3s ease;
        }

        .service-card:hover .service-icon-box {
            transform: scale(1.08);
            background: #e0f2fe;
        }

        .service-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--brand-dark);
        }

        .service-card p {
            font-size: 0.92rem;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 20px;
        }

        .service-link {
            font-family: var(--font-heading);
            font-size: 0.9rem;
            font-weight: 700;
            color: #0369a1;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s;
        }

        /* ===== Tupoksi Grid Cards ===== */
        .tupoksi-section {
            padding: 80px 0;
            background-color: #f8fafc;
            border-top: 1px solid var(--brand-border);
            border-bottom: 1px solid var(--brand-border);
        }

        .tupoksi-card {
            background: #ffffff;
            border: 1px solid var(--brand-border);
            border-radius: 16px;
            padding: 28px;
            height: 100%;
            transition: all 0.25s ease;
        }

        .tupoksi-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04);
        }

        .tupoksi-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            margin-bottom: 16px;
        }

        .tupoksi-icon.blue { background-color: #eff6ff; color: #1d4ed8; }
        .tupoksi-icon.emerald { background-color: #ecfdf5; color: #047857; }
        .tupoksi-icon.amber { background-color: #fffbeb; color: #b45309; }
        .tupoksi-icon.purple { background-color: #faf5ff; color: #6d28d9; }

        .tupoksi-title {
            font-size: 1.05rem;
            margin-bottom: 10px;
            color: var(--brand-dark);
        }

        .tupoksi-card p {
            font-size: 0.88rem;
            line-height: 1.65;
            color: #475569;
            margin-bottom: 0;
        }

        /* ===== Footer ===== */
        .site-footer {
            background-color: #0b1329;
            color: #cbd5e1;
            padding: 60px 0 24px;
            font-size: 0.92rem;
        }

        .site-footer .footer-title {
            color: #f8fafc;
            font-size: 0.95rem;
            margin-bottom: 18px;
            letter-spacing: 0.02em;
        }

        .site-footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .site-footer a:hover {
            color: #38bdf8;
        }

        .site-footer .text-muted {
            color: #94a3b8 !important;
        }

        .social-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            background: var(--brand-primary);
            color: #ffffff;
        }

        .footer-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 40px 0 24px;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #ffffff;
                border: 1px solid var(--brand-border);
                border-radius: 16px;
                padding: 16px;
                margin-top: 12px;
                box-shadow: 0 16px 36px rgba(0, 0, 0, 0.08);
            }
            .navbar-nav {
                margin-bottom: 12px !important;
            }
            .nav-link-custom {
                padding: 10px 14px !important;
                width: 100%;
            }
            .dropdown-menu-custom {
                position: static !important;
                transform: none !important;
                float: none;
                width: 100%;
                margin-top: 8px;
                box-shadow: none;
                background: #f8fafc;
            }
            .hero-section {
                padding-top: calc(var(--header-h) + 24px);
                padding-bottom: 48px;
                text-align: center;
            }
            .hero-desc {
                margin: 0 auto 24px;
            }
            .hero-badge {
                margin: 0 auto 16px;
            }
            .hero-buttons-wrapper {
                justify-content: center !important;
            }
            .hero-logo-box {
                margin-top: 36px;
            }
            .hero-logo-box img {
                max-height: 240px;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: clamp(1.8rem, 6vw, 2.3rem);
            }
            .section-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-brand img {
                max-height: 38px;
            }
            .hero-title {
                font-size: 1.65rem;
                line-height: 1.25;
            }
            .hero-desc {
                font-size: 0.92rem;
            }
            .hero-logo-box img {
                max-height: 180px;
            }
            .btn-hero {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar Header -->
    <header class="site-navbar fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('homepage') }}" aria-label="Beranda Portal Layanan Publik Diskominfo Kabupaten Madiun">
                    <img src="{{ asset('images/logo-diskominfo.png') }}" alt="Diskominfo Kabupaten Madiun" width="160" height="46">
                </a>

                <button class="navbar-toggler border-0 shadow-none p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1">
                        <li class="nav-item">
                            <a class="nav-link-custom active" href="{{ route('homepage') }}">
                                <i class="fa-solid fa-house"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="{{ route('buku-tamu') }}">
                                <i class="fa-solid fa-book-open"></i> Buku Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="{{ route('calendar.index') }}">
                                <i class="fa-regular fa-calendar-days"></i> Kalender Event
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="{{ route('esport.home') }}">
                                <i class="fa-solid fa-gamepad"></i> Madiun Esport
                            </a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <div class="dropdown w-100">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 w-100" type="button" id="portalMenuBtn" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: 600; font-size: 0.9rem;">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                <span>Akses Portal</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom" aria-labelledby="portalMenuBtn">
                                <li><h6 class="dropdown-header text-uppercase text-muted" style="font-size: 0.72rem; font-weight: 700;">Portal Pengguna</h6></li>
                                <li>
                                    <a class="dropdown-item dropdown-item-custom d-flex align-items-center gap-2" href="{{ route('calendar.auth.login') }}">
                                        <i class="fa-regular fa-calendar-check text-primary"></i> Akun Kalender Event
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-item-custom d-flex align-items-center gap-2" href="{{ route('esport.auth.login') }}">
                                        <i class="fa-solid fa-trophy text-warning"></i> Akun Madiun Esport
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7" data-aos="fade-up" data-aos-duration="700">
                        <div class="hero-badge">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Portal Layanan Publik Resmi Diskominfo Kabupaten Madiun</span>
                        </div>
                        <h1 class="hero-title">Integrasi Layanan Digital dan Informasi Publik Terpadu</h1>
                        <p class="hero-desc">
                            Menghubungkan masyarakat dengan layanan pemerintahan yang transparan, modern, dan efisien. Akses presensi kunjungan dinas, agenda kegiatan daerah, hingga kompetisi esports dalam satu gerbang digital.
                        </p>
                        <div class="d-flex flex-wrap gap-3 hero-buttons-wrapper">
                            <a href="#layanan-unggulan" class="btn btn-primary btn-hero px-4 py-2 rounded-3 d-inline-flex align-items-center gap-2" style="font-weight: 600; background-color: var(--brand-primary); border-color: var(--brand-primary);">
                                <i class="fa-solid fa-compass"></i> Jelajahi Layanan
                            </a>
                            <a href="{{ route('buku-tamu') }}" class="btn btn-outline-secondary btn-hero px-4 py-2 rounded-3 d-inline-flex align-items-center gap-2" style="font-weight: 600;">
                                <i class="fa-solid fa-pen-to-square"></i> Isi Buku Tamu
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center mt-5 mt-lg-0" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                        <div class="hero-logo-box">
                            <img src="{{ asset('images/123.png') }}" alt="Lambang Kabupaten Madiun" width="280" height="340">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Layanan Unggulan -->
        <section class="services-section" id="layanan-unggulan">
            <div class="container">
                <div class="section-header text-center" data-aos="fade-up">
                    <span class="section-tag">Katalog Layanan</span>
                    <h2 class="section-title">Layanan Publik Digital</h2>
                    <p class="section-subtitle">Pilih layanan digital yang Anda butuhkan untuk kemudahan administrasi dan partisipasi publik.</p>
                </div>

                <div class="row g-4">
                    <!-- Feature 1: Buku Tamu Digital -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <a href="{{ route('buku-tamu') }}" class="service-card">
                            <div class="service-icon-box">
                                <img src="{{ asset('images/logo-buku.png') }}" alt="Buku Tamu Digital" width="36" height="36" loading="lazy">
                            </div>
                            <h3 class="service-title">Buku Tamu Digital</h3>
                            <p>Presensi tamu dan pengunjung dinas mandiri dengan swafoto kamera dan pencatatan keperluan kunjungan digital secara terstruktur.</p>
                            <span class="service-link">
                                Akses Buku Tamu <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>

                    <!-- Feature 2: Kalender Event -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('calendar.index') }}" class="service-card">
                            <div class="service-icon-box">
                                <img src="{{ asset('images/logo-web-event-madiun.jpg') }}" alt="Kalender Event" width="36" height="36" class="rounded" loading="lazy">
                            </div>
                            <h3 class="service-title">Kalender Event Daerah</h3>
                            <p>Informasi jadwal agenda kegiatan, seminar, sosialisasi, pendaftaran tiket pengunjung, serta QR presensi kegiatan daerah.</p>
                            <span class="service-link">
                                Lihat Kalender Event <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>

                    <!-- Feature 3: Madiun Esport -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('esport.home') }}" class="service-card">
                            <div class="service-icon-box">
                                <img src="{{ asset('images/logo-mgen.png') }}" alt="Madiun Esport" width="36" height="36" loading="lazy">
                            </div>
                            <h3 class="service-title">Madiun Esport (M-GEN)</h3>
                            <p>Platform turnamen game kompetitif resmi Diskominfo Kabupaten Madiun, pendaftaran tim esport, dan informasi berita terkini.</p>
                            <span class="service-link">
                                Masuk Portal Esport <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tugas Pokok dan Fungsi -->
        <section class="tupoksi-section">
            <div class="container">
                <div class="section-header text-center" data-aos="fade-up">
                    <span class="section-tag">Struktur & Tata Kelola</span>
                    <h2 class="section-title">Tugas Pokok & Fungsi Bidang</h2>
                    <p class="section-subtitle">Mendukung terwujudnya tata kelola pemerintahan berbasis digital dan keterbukaan informasi di Kabupaten Madiun.</p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="tupoksi-card">
                            <div class="tupoksi-icon blue">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h3 class="tupoksi-title">Sekretariat</h3>
                            <p>Perencanaan, koordinasi, serta pengendalian administrasi umum, kepegawaian, perlengkapan aset, penyusunan program, dan akuntabilitas keuangan dinas.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="tupoksi-card">
                            <div class="tupoksi-icon emerald">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <h3 class="tupoksi-title">Aplikasi & Informatika</h3>
                            <p>Pengelolaan infrastruktur teknologi informasi, pengembangan sistem informasi dan aplikasi terintegrasi, serta penyelenggaraan SPBE pemerintah daerah.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="tupoksi-card">
                            <div class="tupoksi-icon amber">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            <h3 class="tupoksi-title">Komunikasi & Informasi Publik</h3>
                            <p>Pengelolaan saluran komunikasi publik, diseminasi informasi kebijakan daerah, kemitraan media massa, serta pelayanan informasi publik (PPID).</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="tupoksi-card">
                            <div class="tupoksi-icon purple">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <h3 class="tupoksi-title">Statistik & Persandian</h3>
                            <p>Penyelenggaraan statistik sektoral daerah, tata kelola satu data, pengamanan informasi persandian, dan keamanan siber instansi pemerintah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="site-footer mt-auto">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h4 class="footer-title fw-bold">Diskominfo Kabupaten Madiun</h4>
                    <p class="mb-2">
                        Jl. Mastrip No.23, Mojorejo, Kec. Taman,<br>
                        Kota Madiun, Jawa Timur 63139.
                    </p>
                    <p class="mb-1"><strong>Telp:</strong> (0351) 462927</p>
                    <p class="mb-0"><strong>Email:</strong> <a href="mailto:diskominfo@madiunkab.go.id">diskominfo@madiunkab.go.id</a></p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-title fw-bold">Tautan Layanan</h4>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('buku-tamu') }}"><i class="fa-solid fa-angle-right me-2 text-muted"></i> Buku Tamu Digital</a></li>
                        <li><a href="{{ route('calendar.index') }}"><i class="fa-solid fa-angle-right me-2 text-muted"></i> Kalender Event</a></li>
                        <li><a href="{{ route('esport.home') }}"><i class="fa-solid fa-angle-right me-2 text-muted"></i> Madiun Esport (M-GEN)</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-title fw-bold">Jam Pelayanan</h4>
                    <p class="mb-1"><i class="fa-regular fa-clock me-2 text-muted"></i> Senin – Kamis: 07.30 – 15.15 WIB</p>
                    <p class="mb-1"><i class="fa-regular fa-clock me-2 text-muted"></i> Jumat: 07.00 – 14.30 WIB</p>
                    <p class="small text-muted mb-0">Sabtu, Minggu & Hari Libur: Tutup</p>
                </div>

                <div class="col-lg-2 col-md-6 text-lg-end">
                    <h4 class="footer-title fw-bold">Kanal Resmi</h4>
                    <div class="d-flex justify-content-lg-end justify-content-start gap-2">
                        <a href="https://www.instagram.com/kominfokabmadiun/" class="social-btn" target="_blank" rel="noopener noreferrer" aria-label="Instagram Diskominfo Madiun">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@diskominfokabupatenmadiun717" class="social-btn" target="_blank" rel="noopener noreferrer" aria-label="YouTube Diskominfo Madiun">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                        <a href="https://madiunkab.go.id/" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Website Pemkab Madiun">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="footer-divider">
            <div class="text-center small text-muted">
                &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Madiun. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 650,
                    easing: 'ease-out-cubic',
                    once: true
                });
            }
        });
    </script>
</body>
</html>