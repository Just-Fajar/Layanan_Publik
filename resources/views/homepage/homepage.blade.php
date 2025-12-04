<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Publik Kota Madiun</title>

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
            --header-h: 70px;
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
         * 2. LAYOUT: HEADER & FOOTER
         * ============================================= */
        .site-header {
            min-height: var(--header-h);
            background: rgba(255, 255, 255, .82);
            backdrop-filter: saturate(180%) blur(10px);
            border-bottom: 1px solid rgba(2, 132, 199, .12);
            box-shadow: 0 10px 30px rgba(2, 6, 23, .06);
            z-index: 1050;
        }

        .site-header::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(2, 132, 199, .22), transparent);
        }

        .page-offset {
            padding-top: var(--header-h);
        }

        .site-footer {
            background: #212529; /* Menggunakan warna bg-dark dari Bootstrap */
            color: #f8f9fa;
        }

        .site-footer a {
            color: #f8f9fa;
            text-decoration: none;
        }
        .site-footer a:hover {
            color: #0ea5e9;
        }

        /* =============================================
         * 3. COMPONENTS
         * ============================================= */

        /* --- Header Components --- */
        .login-name {
            font-family: var(--font-heading);
            font-weight: 700;
            letter-spacing: .1px;
            color: #0f172a;
            white-space: nowrap;
        }

        .btn-hamburger {
            width: 42px;
            height: 38px;
            padding: 0;
            border-radius: 12px;
            border: 1px solid rgba(2, 132, 199, .6);
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: box-shadow .2s, transform .2s;
        }
        .btn-hamburger:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(2, 132, 199, .25);
        }
        .btn-hamburger .bar,
        .btn-hamburger .bar::before,
        .btn-hamburger .bar::after {
            content: "";
            display: block;
            width: 18px;
            height: 2px;
            background: #2563eb;
            position: relative;
            border-radius: 2px;
        }
        .btn-hamburger .bar::before { position: absolute; top: -6px; left: 0; }
        .btn-hamburger .bar::after  { position: absolute; top: 6px; left: 0; }

        .dropdown-menu {
            border-radius: 14px;
            padding: .5rem;
            border: 1px solid rgba(0, 0, 0, .06);
        }
        .dropdown-item { border-radius: 10px; }
        .dropdown-item:hover { background-color: #f1f5f9; }

        /* --- Hero Section --- */
        .hero-section {
            min-height: calc(100vh - var(--header-h));
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        #particles-js {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-text h1 {
            font-family: var(--font-heading);
            font-weight: 700;
            color: #004d40;
        }
        .hero-text .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: .95rem;
            letter-spacing: .3px;
            text-transform: uppercase;
            color: #0f766e;
            background: linear-gradient(135deg, #e0f2f1, #d1fae5);
            border: 1px solid rgba(13, 148, 136, .25);
            padding: .4rem .75rem;
            border-radius: 999px;
            box-shadow: 0 4px 14px rgba(13, 148, 136, .12) inset;
        }
        .hero-text .hero-lead {
            font-size: 1.075rem;
            line-height: 1.75rem;
            color: #334155;
            margin-top: 1rem;
            margin-bottom: .75rem;
        }
        .hero-text .hero-desc {
            font-size: 1rem;
            line-height: 1.8rem;
            color: #475569;
            margin-bottom: 1.25rem;
        }

        /* --- Duties Section (Tupoksi) --- */
        .duties-section {
            position: relative;
            padding: 70px 0 90px;
            background: linear-gradient(180deg, rgba(2, 132, 199, .05), rgba(2, 132, 199, .08));
        }
        .duties-title {
            font-family: var(--font-heading);
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #0f172a;
            opacity: .9;
            font-size: 1rem;
        }
        .duties-heading {
            font-family: var(--font-heading);
            font-weight: 800;
            color: #0b4e9c;
            letter-spacing: .04em;
        }
        .duties-card {
            background: #1976d2;
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(2, 6, 23, .22);
            padding: 38px;
            color: #e8f1fd;
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
            flex: 0 0 46px;
            height: 46px;
            width: 46px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .12);
            display: grid;
            place-items: center;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .25);
        }
        .duty .icon i { font-size: 20px; color: #fff; }
        .duty h5 { margin: 0 0 .35rem; font-weight: 800; letter-spacing: .02em; color: #fff; }
        .duty p { margin: 0; color: #e4eefc; font-size: .95rem; line-height: 1.7rem; }

        /* Decorative dividers inside the card for large screens */
        .duties-card::before,
        .duties-card::after {
            content: "";
            position: absolute;
            background: linear-gradient(180deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, .06));
        }
        .duties-card::before {
            left: 50%;
            top: 30px;
            bottom: 30px;
            width: 1px;
            transform: translateX(-.5px);
        }
        .duties-card::after {
            left: 30px;
            right: 30px;
            top: calc(50% - .5px);
            height: 1px;
            width: auto;
            background: linear-gradient(90deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, .06));
        }

        /* --- Features Section --- */
        .features-section {
            padding: 70px 0;
            background-color: #fff;
        }
        
        .feature-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .feature-link:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,.1);
        }

        /* =============================================
         * 4. RESPONSIVE STYLES
         * ============================================= */
        @media (max-width: 992px) {
            .hero-text .hero-lead { font-size: 1.02rem; line-height: 1.85rem; }
            .hero-text .hero-desc { font-size: 1rem; line-height: 1.9rem; }

            .duties-grid { grid-template-columns: 1fr; gap: 26px; }
            .duties-card { padding: 26px; }
            .duties-card::before, .duties-card::after { display: none; }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="site-header fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('homepage') }}">
                <img src="{{ asset('images/logo-diskominfo.png') }}" width="200" height="50" alt="Logo Diskominfo Kabupaten Madiun">
            </a>
            </div>
        </div>
    </header>

    <main class="page-offset">
        <section class="hero-section">
            <div id="particles-js"></div>
            <div class="container">
                <div class="row align-items-center position-relative" style="z-index:1;">
                    <div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start" data-aos="fade-right">
                        <img src="{{ asset('images/123.png') }}" width="300" height="300" alt="Lambang Kabupaten Madiun" class="img-fluid">
                    </div>
                    <div class="col-lg-6 hero-text" data-aos="fade-left">
                        <h1 class="mb-4">Selamat Datang di DISKOMINFO<br>Kabupaten Madiun</h1>
                        <h5 class="hero-kicker mb-3">
                            <i class="fa-solid fa-bookmark" aria-hidden="true"></i> Profil Singkat
                        </h5>
                        <p class="hero-lead text-justify">
                            Dinas Komunikasi dan Informatika Kabupaten Madiun merupakan perangkat daerah yang melaksanakan urusan otonomi di bidang Sekretariat, Aplikasi dan Informatika, Komunikasi dan Informasi Publik, Persandian, dan Statistik.
                        </p>
                        <p class="hero-desc text-justify">
                            Dinas Komunikasi dan Informatika Kabupaten Madiun dibentuk berdasarkan Peraturan Menteri Dalam Negeri Nomor 99 Tahun 2018 tentang Kedudukan, Susunan Organisasi, Tugas, Fungsi, dan Tata Kerja Dinas Komunikasi dan Informatika. Dinas ini merupakan unsur pelaksana urusan pemerintahan daerah di bidang Sekretariat, Aplikasi dan Informatika, Komunikasi dan Informasi Publik, Persandian, dan Statistik. Dalam peraturan tersebut juga dijelaskan secara rinci mengenai tugas pokok dan fungsi Dinas Komunikasi dan Informatika Kabupaten Madiun.
                        </p>
                    </div>
                </div>
            </div>
        </section>

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
                                            <p class="text-justify">Melaksanakan sebagian kewenangan Kepala Dinas, yang meliputi penyusunan kebijakan teknis, perencanaan program, penyelenggaraan, monitoring, evaluasi, serta pelaporan di bidang Infrastruktur Teknologi Informasi, Pengembangan Aplikasi, dan Ekosistem E-Government.</p>
                                        </div>
                                    </div>
                                    <div class="duty">
                                        <div class="icon"><i class="fa-solid fa-bullhorn"></i></div>
                                        <div>
                                            <h5>KOMUNIKASI DAN INFORMASI PUBLIK</h5>
                                            <p class="text-justify">Menyusun kebijakan teknis, merencanakan program, menyelenggarakan kegiatan, melakukan monitoring, evaluasi, serta pelaporan di bidang penyediaan konten lintas sektoral, pengelolaan media komunikasi publik, layanan hubungan media, penguatan kapasitas sumber daya komunikasi publik, serta penyediaan akses informasi.</p>
                                        </div>
                                    </div>
                                    <div class="duty">
                                        <div class="icon"><i class="fa-solid fa-chart-column"></i></div>
                                        <div>
                                            <h5>STATISTIK</h5>
                                            <p class="text-justify">Menyusun kebijakan teknis, merencanakan program, menyelenggarakan, mengoordinasikan, memfasilitasi, mendiseminasikan, melakukan monitoring, evaluasi, serta menyusun pelaporan di bidang statistik sektoral.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="duties-card" data-aos="zoom-in" data-aos-duration="700">
                                <div class="duty">
                                    <div class="icon"><i class="fa-solid fa-qrcode"></i></div>
                                    <div>
                                        <h5>PERSANDIAN</h5>
                                        <p class="text-justify">Mmenyusun kebijakan teknis, merencanakan program, menyelenggarakan kegiatan, melakukan monitoring, evaluasi, serta pelaporan di bidang persandian untuk mendukung pengamanan informasi.</p>
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

        <section class="features-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="h1 fw-bold">Fitur Layanan Khusus</h2>
                    <p class="text-muted fs-5">Layanan digital unggulan dari Diskominfo Kabupaten Madiun.</p>
                </div>
                <div class="row justify-content-center g-4">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <a href="{{ route('buku-tamu') }}" class="feature-link h-100">
                            <img src="{{ asset('images/logo-buku.png') }}" alt="Logo Buku Tamu" width="60" height="60" class="me-3">
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Buku Tamu Digital</h5>
                                <p class="mb-0 text-muted">Lihat Selengkapnya &raquo;</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('esport.home') }}" class="feature-link h-100">
                            <img src="{{ asset('images/logo-mgen.png') }}" alt="Logo Madiun Esport" width="60" height="60" class="me-3">
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Madiun Esport (M-GEN)</h5>
                                <p class="mb-0 text-muted">Lihat Selengkapnya &raquo;</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="#" class="feature-link h-100">
                            <img src="{{ asset('images/logo-web-event-madiun.jpg') }}" alt="Logo Kalender Event" width="60" height="60" class="me-3">
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Kalender Event</h5>
                                <p class="mb-0 text-muted">Lihat Selengkapnya &raquo;</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer pt-5 pb-4 mt-auto">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12">
                    <h5 class="fw-bold mb-3">Kominfo Kabupaten Madiun</h5>
                    <p class="mb-2 small">
                        Jl. Mastrip No.23, Mojorejo, Kec. Taman,<br>
                        Kota Madiun, Jawa Timur 63139.
                    </p>
                    <p class="mb-1 small"><strong>Telp/Fax:</strong> 0351-462927</p>
                    <p class="small"><strong>Email:</strong> <a href="mailto:diskominfo@madiunkab.go.id">diskominfo@madiunkab.go.id</a></p>
                </div>
                <div class="col-lg-4 col-md-6">
                     <h5 class="fw-bold mb-3">Jam Pelayanan</h5>
                     <p class="mb-1 small">Senin – Kamis: 07.30 – 15.15 WIB</p>
                     <p class="mb-1 small">Jumat: 07.00 – 14.30 WIB</p>
                </div>
                <div class="col-lg-3 col-md-6 text-md-end">
                    <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                    <div class="d-flex justify-content-md-end justify-content-start gap-2">
                        <a href="https://www.instagram.com/kominfokabmadiun/" class="btn btn-outline-light rounded-circle" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@diskominfokabupatenmadiun717" class="btn btn-outline-light rounded-circle" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                        <a href="https://madiunkab.go.id/" target="_blank" rel="noopener noreferrer" class="d-inline-block" aria-label="Website Kabupaten Madiun">
                            <img src="{{ asset('images/123.png') }}" alt="Logo Kabupaten Madiun" style="width:40px; height:40px;" class="rounded-circle bg-white p-1">
                        </a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small">
                © {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Madiun. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS (Animate On Scroll)
            AOS.init({
                duration: 800,
                once: true
            });

            // Initialize Particles.js
            particlesJS('particles-js', {
                particles: {
                    number: { value: 50, density: { enable: true, value_area: 800 } },
                    color: { value: '#2196F3' },
                    shape: { type: 'circle' },
                    opacity: { value: 0.4, random: true },
                    size: { value: 3, random: true },
                    move: { enable: true, speed: 1.5, random: true, out_mode: 'out' }
                }
            });

            // Logic for Tupoksi Carousel Buttons
            const carouselElement = document.getElementById('dutiesCarousel');
            if (carouselElement) {
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const totalItems = carouselElement.querySelectorAll('.carousel-item').length;

                carouselElement.addEventListener('slid.bs.carousel', function(event) {
                    const activeIndex = event.to;

                    // Enable/disable previous button
                    prevBtn.disabled = (activeIndex === 0);

                    // Enable/disable next button
                    nextBtn.disabled = (activeIndex === totalItems - 1);
                });
            }
        });
    </script>
</body>
</html>