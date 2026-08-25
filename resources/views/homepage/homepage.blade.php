<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Layanan Publik Diskominfo Kabupaten Madiun</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =============================================
         * 1. VARIABLES & BASE STYLES
         * ============================================= */
        :root {
            --font-ui: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            --font-heading: "Plus Jakarta Sans", "Inter", -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            --header-h: 74px;
            --primary-color: #0284c7;
            --primary-hover: #0369a1;
        }

        body {
            font-family: var(--font-ui);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f8f9fa;
        }

        .text-justify {
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
        }

        /* =============================================
         * 2. LAYOUT: HEADER & NAVBAR
         * ============================================= */
        .site-header {
            min-height: var(--header-h);
            background: rgba(255, 255, 255, .92);
            backdrop-filter: saturate(180%) blur(12px);
            border-bottom: 1px solid rgba(2, 132, 199, .15);
            box-shadow: 0 10px 30px rgba(2, 6, 23, .06);
            z-index: 1050;
            padding: 10px 0;
        }

        .site-header .nav-link {
            font-family: var(--font-heading);
            font-weight: 600;
            color: #334155;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .site-header .nav-link:hover,
        .site-header .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(2, 132, 199, 0.08);
        }

        .dropdown-menu {
            border-radius: 14px;
            padding: .6rem;
            border: 1px solid rgba(0, 0, 0, .08);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 0.8rem;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f0f9ff;
            color: var(--primary-color);
        }

        .page-offset {
            padding-top: var(--header-h);
        }

        /* =============================================
         * 3. HERO SECTION
         * ============================================= */
        .hero-section {
            min-height: calc(100vh - var(--header-h));
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f0fdfa 0%, #f8fafc 100%);
            padding: 60px 0;
        }

        #particles-js {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-text h1 {
            font-family: var(--font-heading);
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
        }

        .hero-text .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: .92rem;
            letter-spacing: .3px;
            text-transform: uppercase;
            color: #0f766e;
            background: linear-gradient(135deg, #e0f2f1, #d1fae5);
            border: 1px solid rgba(13, 148, 136, .25);
            padding: .4rem .85rem;
            border-radius: 999px;
            box-shadow: 0 4px 14px rgba(13, 148, 136, .12) inset;
        }

        .hero-text .hero-lead {
            font-size: 1.05rem;
            line-height: 1.75rem;
            color: #334155;
            margin-top: 1rem;
            margin-bottom: .75rem;
        }

        .hero-text .hero-desc {
            font-size: 0.98rem;
            line-height: 1.8rem;
            color: #475569;
            margin-bottom: 1.5rem;
        }

        /* =============================================
         * 4. DUTIES SECTION (TUPOKSI)
         * ============================================= */
        .duties-section {
            position: relative;
            padding: 80px 0;
            background: linear-gradient(180deg, rgba(2, 132, 199, .04), rgba(2, 132, 199, .08));
        }

        .duties-title {
            font-family: var(--font-heading);
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #0f172a;
            opacity: .9;
            font-size: 0.95rem;
        }

        .duties-heading {
            font-family: var(--font-heading);
            font-weight: 800;
            color: #0369a1;
            letter-spacing: .02em;
        }

        .duties-card {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(2, 132, 199, 0.25);
            padding: 40px;
            color: #f0f9ff;
            position: relative;
            overflow: hidden;
        }

        .duties-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 34px 46px;
        }

        .duty {
            display: flex;
            gap: 18px;
        }

        .duty .icon {
            flex: 0 0 48px;
            height: 48px;
            width: 48px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .15);
            display: grid;
            place-items: center;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);
        }

        .duty .icon i { font-size: 20px; color: #fff; }
        .duty h5 { margin: 0 0 .35rem; font-weight: 700; letter-spacing: .02em; color: #fff; font-size: 1.1rem; }
        .duty p { margin: 0; color: #e0f2fe; font-size: .92rem; line-height: 1.65rem; }

        /* =============================================
         * 5. FEATURES SECTION
         * ============================================= */
        .features-section {
            padding: 80px 0;
            background-color: #ffffff;
        }

        .feature-card {
            display: flex;
            flex-direction: column;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            text-decoration: none;
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: var(--primary-color);
        }

        .feature-icon-wrapper {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            background-color: #f0f9ff;
        }

        .feature-card h4 {
            font-family: var(--font-heading);
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
        }

        .feature-action {
            margin-top: auto;
            font-weight: 600;
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s ease;
        }

        .feature-card:hover .feature-action {
            gap: 10px;
        }

        /* =============================================
         * 6. FOOTER
         * ============================================= */
        .site-footer {
            background: #0f172a;
            color: #cbd5e1;
        }

        .site-footer h5 {
            color: #f8fafc;
            font-family: var(--font-heading);
        }

        .site-footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .site-footer a:hover {
            color: #38bdf8;
        }

        @media (max-width: 992px) {
            .duties-grid { grid-template-columns: 1fr; gap: 26px; }
            .duties-card { padding: 26px; }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Unified Navbar Header -->
    <header class="site-header fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('homepage') }}">
                    <img src="{{ asset('images/logo-diskominfo.png') }}" width="190" height="48" alt="Logo Diskominfo Kabupaten Madiun">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('homepage') }}">
                                <i class="fa-solid fa-house me-1"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('buku-tamu') }}">
                                <i class="fa-solid fa-book-open me-1"></i> Buku Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('calendar.index') }}">
                                <i class="fa-regular fa-calendar-days me-1"></i> Kalender Event
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('esport.home') }}">
                                <i class="fa-solid fa-gamepad me-1"></i> Madiun Esport
                            </a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Portal Login Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm" type="button" id="portalMenuBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: var(--primary-color); border: none; font-weight: 600;">
                                <i class="fa-solid fa-user-shield"></i>
                                <span>Portal & Login</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="portalMenuBtn">
                                <li><h6 class="dropdown-header text-uppercase" style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Portal Pengguna</h6></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('calendar.auth.login') }}">
                                        <i class="fa-regular fa-calendar-check text-primary"></i> Akun Kalender Event
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('esport.auth.login') }}">
                                        <i class="fa-solid fa-trophy text-warning"></i> Akun Madiun Esport
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header text-uppercase" style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Portal Administrator</h6></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.login') }}">
                                        <i class="fa-solid fa-lock text-danger"></i> Login Admin RBAC
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="page-offset">
        <!-- Hero Section -->
        <section class="hero-section">
            <div id="particles-js"></div>
            <div class="container">
                <div class="row align-items-center position-relative" style="z-index:1;">
                    <div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start" data-aos="fade-right">
                        <img src="{{ asset('images/123.png') }}" width="300" height="300" alt="Lambang Kabupaten Madiun" class="img-fluid">
                    </div>
                    <div class="col-lg-6 hero-text" data-aos="fade-left">
                        <h1 class="mb-4">Selamat Datang di Portal Layanan Publik<br>Diskominfo Kabupaten Madiun</h1>
                        <h5 class="hero-kicker mb-3">
                            <i class="fa-solid fa-bookmark" aria-hidden="true"></i> Profil Singkat
                        </h5>
                        <p class="hero-lead text-justify">
                            Dinas Komunikasi dan Informatika Kabupaten Madiun merupakan perangkat daerah yang melaksanakan urusan otonomi di bidang Sekretariat, Aplikasi dan Informatika, Komunikasi dan Informasi Publik, Persandian, dan Statistik.
                        </p>
                        <p class="hero-desc text-justify">
                            Dinas Komunikasi dan Informatika Kabupaten Madiun dibentuk berdasarkan Peraturan Menteri Dalam Negeri Nomor 99 Tahun 2018 tentang Kedudukan, Susunan Organisasi, Tugas, Fungsi, dan Tata Kerja Dinas Komunikasi dan Informatika sebagai unsur pelaksana urusan pemerintahan daerah yang andal dan transparan.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#layanan-unggulan" class="btn btn-primary btn-lg px-4 py-2 rounded-3 shadow-sm" style="background-color: var(--primary-color); border: none; font-weight: 600;">
                                <i class="fa-solid fa-compass me-2"></i> Jelajahi Layanan
                            </a>
                            <a href="{{ route('buku-tamu') }}" class="btn btn-outline-secondary btn-lg px-4 py-2 rounded-3" style="font-weight: 600;">
                                <i class="fa-solid fa-pen-to-square me-2"></i> Isi Buku Tamu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tupoksi Section -->
        <section class="duties-section">
            <div class="container">
                <div class="text-center mb-4" data-aos="fade-up">
                    <div class="duties-title mb-1">
                        <span class="me-2"><i class="fa-solid fa-list-check"></i></span> Tugas Pokok dan Fungsi
                    </div>
                    <h2 class="duties-heading h1">DINAS KOMUNIKASI DAN INFORMATIKA</h2>
                </div>

                <div id="dutiesCarousel" class="carousel slide" data-bs-touch="true" data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="duties-card" data-aos="zoom-in" data-aos-duration="700">
                                <div class="duties-grid">
                                    <div class="duty">
                                        <div class="icon"><i class="fa-solid fa-book"></i></div>
                                        <div>
                                            <h5>SEKRETARIAT</h5>
                                            <p class="text-justify">Merencanakan, melaksanakan, mengoordinasikan, serta mengendalikan kegiatan administrasi umum, kepegawaian, perlengkapan, pengelolaan aset, penyusunan program, penyusunan laporan, dan pengelolaan keuangan.</p>
                                        </div>
                                    </div>
                                    <div class="duty">
                                        <div class="icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                                        <div>
                                            <h5>APLIKASI DAN INFORMATIKA</h5>
                                            <p class="text-justify">Melaksanakan sebagian kewenangan Kepala Dinas di bidang Infrastruktur Teknologi Informasi, Pengembangan Aplikasi, dan Ekosistem E-Government Pemerintah Kabupaten Madiun.</p>
                                        </div>
                                    </div>
                                    <div class="duty">
                                        <div class="icon"><i class="fa-solid fa-bullhorn"></i></div>
                                        <div>
                                            <h5>KOMUNIKASI DAN INFORMASI PUBLIK</h5>
                                            <p class="text-justify">Menyusun kebijakan teknis, pengelolaan media komunikasi publik, layanan hubungan media, penguatan kapasitas sumber daya komunikasi publik, serta penyediaan akses informasi.</p>
                                        </div>
                                    </div>
                                    <div class="duty">
                                        <div class="icon"><i class="fa-solid fa-chart-column"></i></div>
                                        <div>
                                            <h5>STATISTIK</h5>
                                            <p class="text-justify">Menyusun kebijakan teknis, merencanakan program, menyelenggarakan, mengoordinasikan, memfasilitasi, mendiseminasikan, serta menyusun pelaporan di bidang statistik sektoral.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="duties-card" data-aos="zoom-in" data-aos-duration="700">
                                <div class="duty">
                                    <div class="icon"><i class="fa-solid fa-shield-halved"></i></div>
                                    <div>
                                        <h5>PERSANDIAN & KEAMANAN INFORMASI</h5>
                                        <p class="text-justify">Menyusun kebijakan teknis, merencanakan program, menyelenggarakan kegiatan, melakukan monitoring, evaluasi, serta pelaporan di bidang persandian untuk mendukung pengamanan informasi pemerintah daerah.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button id="prevBtn" class="btn btn-outline-dark me-2" type="button" data-bs-target="#dutiesCarousel" data-bs-slide="prev" disabled>
                            <i class="fa-solid fa-chevron-left"></i> Sebelumnya
                        </button>
                        <button id="nextBtn" class="btn btn-outline-dark" type="button" data-bs-target="#dutiesCarousel" data-bs-slide="next">
                            Berikutnya <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section (Layanan Unggulan) -->
        <section id="layanan-unggulan" class="features-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="h1 fw-bold text-slate-900">Layanan Digital Unggulan</h2>
                    <p class="text-muted fs-5">Akses cepat ke berbagai aplikasi dan fasilitas publik Diskominfo Kabupaten Madiun.</p>
                </div>
                <div class="row justify-content-center g-4">
                    <!-- Feature 1: Buku Tamu Digital -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <a href="{{ route('buku-tamu') }}" class="feature-card h-100">
                            <div class="feature-icon-wrapper">
                                <img src="{{ asset('images/logo-buku.png') }}" alt="Logo Buku Tamu" width="48" height="48">
                            </div>
                            <h4>Buku Tamu Digital</h4>
                            <p>Presensi tamu dan pengunjung dinas secara mandiri dengan swafoto kamera dan pencatatan keperluan kunjungan digital.</p>
                            <span class="feature-action">
                                Buka Layanan <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>

                    <!-- Feature 2: Madiun Esport -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('esport.home') }}" class="feature-card h-100">
                            <div class="feature-icon-wrapper">
                                <img src="{{ asset('images/logo-mgen.png') }}" alt="Logo Madiun Esport" width="48" height="48">
                            </div>
                            <h4>Madiun Esport (M-GEN)</h4>
                            <p>Platform turnamen game esport resmi, pendaftaran tim, informasi bagan bracket kompetisi, dan berita esport Kabupaten Madiun.</p>
                            <span class="feature-action">
                                Buka Portal Esport <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>

                    <!-- Feature 3: Kalender Event -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('calendar.index') }}" class="feature-card h-100">
                            <div class="feature-icon-wrapper">
                                <img src="{{ asset('images/logo-web-event-madiun.jpg') }}" alt="Logo Kalender Event" width="48" height="48" class="rounded-3">
                            </div>
                            <h4>Kalender Event Daerah</h4>
                            <p>Informasi jadwal agenda kegiatan, seminar, festival daerah, pendaftaran tiket pengunjung, dan barcode kehadiran digital.</p>
                            <span class="feature-action">
                                Buka Kalender Event <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="site-footer pt-5 pb-4 mt-auto">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">Diskominfo Kabupaten Madiun</h5>
                    <p class="mb-2 small">
                        Jl. Mastrip No.23, Mojorejo, Kec. Taman,<br>
                        Kota Madiun, Jawa Timur 63139.
                    </p>
                    <p class="mb-1 small"><strong>Telp/Fax:</strong> 0351-462927</p>
                    <p class="small"><strong>Email:</strong> <a href="mailto:diskominfo@madiunkab.go.id">diskominfo@madiunkab.go.id</a></p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3">Tautan Cepat Layanan</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('buku-tamu') }}"><i class="fa-solid fa-angle-right me-2"></i> Buku Tamu Digital</a></li>
                        <li><a href="{{ route('calendar.index') }}"><i class="fa-solid fa-angle-right me-2"></i> Kalender Event</a></li>
                        <li><a href="{{ route('esport.home') }}"><i class="fa-solid fa-angle-right me-2"></i> Madiun Esport (M-GEN)</a></li>
                        <li><a href="{{ route('admin.login') }}"><i class="fa-solid fa-lock me-2"></i> Login Administrator</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3">Jam Pelayanan</h5>
                    <p class="mb-1 small"><i class="fa-regular fa-clock me-2"></i> Senin – Kamis: 07.30 – 15.15 WIB</p>
                    <p class="mb-1 small"><i class="fa-regular fa-clock me-2"></i> Jumat: 07.00 – 14.30 WIB</p>
                    <p class="small text-muted">Sabtu – Minggu / Hari Libur Nasional: Tutup</p>
                </div>

                <div class="col-lg-2 col-md-6 text-lg-end">
                    <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                    <div class="d-flex justify-content-lg-end justify-content-start gap-2">
                        <a href="https://www.instagram.com/kominfokabmadiun/" class="btn btn-outline-light rounded-circle" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@diskominfokabupatenmadiun717" class="btn btn-outline-light rounded-circle" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                        <a href="https://madiunkab.go.id/" target="_blank" rel="noopener noreferrer" class="d-inline-block" aria-label="Website Kabupaten Madiun">
                            <img src="{{ asset('images/123.png') }}" alt="Logo Kabupaten Madiun" style="width:38px; height:38px;" class="rounded-circle bg-white p-1">
                        </a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small text-secondary">
                © {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Madiun. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true
                });
            }

            // Initialize Particles.js
            if (typeof particlesJS !== 'undefined' && document.getElementById('particles-js')) {
                particlesJS('particles-js', {
                    particles: {
                        number: { value: 45, density: { enable: true, value_area: 800 } },
                        color: { value: '#0284c7' },
                        shape: { type: 'circle' },
                        opacity: { value: 0.35, random: true },
                        size: { value: 3, random: true },
                        move: { enable: true, speed: 1.2, random: true, out_mode: 'out' }
                    }
                });
            }

            // Logic for Tupoksi Carousel Buttons
            const carouselElement = document.getElementById('dutiesCarousel');
            if (carouselElement) {
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const totalItems = carouselElement.querySelectorAll('.carousel-item').length;

                carouselElement.addEventListener('slid.bs.carousel', function(event) {
                    const activeIndex = event.to;
                    if (prevBtn) prevBtn.disabled = (activeIndex === 0);
                    if (nextBtn) nextBtn.disabled = (activeIndex === totalItems - 1);
                });
            }
        });
    </script>
</body>
</html>