<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Layanan Publik Kota Madiun</title>

  <!-- CSS libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --font-ui: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
      --font-heading: "Plus Jakarta Sans", "Inter", -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      --header-h: 70px;
    }

    /* Base */
    html,body{height:100%}
    body{
      font-family: var(--font-ui);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      background:#f8f9fa;
    }

    /* Header */
    .site-header{
      min-height: var(--header-h);
      background: rgba(255,255,255,.82);
      backdrop-filter: saturate(180%) blur(10px);
      border-bottom: 1px solid rgba(2,132,199,.12);
      box-shadow: 0 10px 30px rgba(2,6,23,.06);
      z-index: 1050;
    }
    .site-header::after{
      content:""; position:absolute; left:0; right:0; bottom:-1px; height:1px;
      background: linear-gradient(90deg, transparent, rgba(2,132,199,.22), transparent);
    }
    .page-offset{ padding-top: var(--header-h); }

    /* Greeting (transparent) */
    .site-header .login-name{
      font-family: var(--font-heading);
      font-weight:700; letter-spacing:.1px; color:#0f172a;
      background: transparent !important; border:0 !important; box-shadow:none !important;
      padding:0 !important; margin-right:.25rem; white-space:nowrap;
    }

    /* Hamburger dropdown button */
    .btn-hamburger{
      width:42px; height:38px; padding:0;
      border-radius:12px; border:1px solid rgba(2,132,199,.6);
      background:#fff; display:inline-flex; align-items:center; justify-content:center;
      transition: box-shadow .2s, transform .2s;
    }
    .btn-hamburger:hover{ transform: translateY(-1px); box-shadow:0 10px 22px rgba(2,132,199,.25); }
    .btn-hamburger .bar,
    .btn-hamburger .bar::before,
    .btn-hamburger .bar::after{
      content:""; display:block; width:18px; height:2px; background:#2563eb; position:relative; border-radius:2px;
    }
    .btn-hamburger .bar::before{ position:absolute; top:-6px; left:0; }
    .btn-hamburger .bar::after { position:absolute; top: 6px; left:0; }

    .dropdown-menu{ border-radius:14px; padding:.5rem; border:1px solid rgba(0,0,0,.06); }
    .dropdown-item{ border-radius:10px; }
    .dropdown-item:hover{ background:#f1f5f9; }

    /* Hero */
    .hero-section{
      min-height:calc(100vh - var(--header-h));
      display:flex; align-items:center; position:relative; overflow:hidden;
    }
    .hero-text h1{ font-family:var(--font-heading); font-weight:700; color:#004d40; }
    .hero-text p{ font-size:1.1rem; color:#555; }
    #particles-js{ position:absolute; inset:0; z-index:0; }

    /* CTA buttons */
    .btn-custom{
      margin-top:20px; padding:12px 30px; font-size:1rem; border-radius:50px;
      background:linear-gradient(45deg,#2196F3,#00BCD4); color:#fff; border:0; transition:.3s;
    }
    .btn-custom:hover{ transform:translateY(-3px); box-shadow:0 8px 25px rgba(33,150,243,.4); color:#fff; }
    .btn-esport{
      margin-top:20px; padding:12px 30px; font-size:1rem; border-radius:50px;
      background:linear-gradient(45deg,#FF5722,#FF9800); color:#fff; border:0; transition:.3s;
    }
    .btn-esport:hover{ transform:translateY(-3px); box-shadow:0 8px 25px rgba(255,87,34,.4); color:#fff; }

    /* Fancy login button (guest) */
    .btn-login{
      --c1:#22c1c3; --c2:#0ea5e9;
      border:0 !important; border-radius:9999px; padding:.55rem 1.15rem;
      font-weight:600; letter-spacing:.2px; color:#fff !important;
      background-image:linear-gradient(135deg,var(--c1),var(--c2)) !important;
      box-shadow:0 10px 26px rgba(14,165,233,.35), inset 0 -2px 0 rgba(0,0,0,.08);
      transition:transform .18s, box-shadow .18s, filter .18s;
    }
    .btn-login:hover{ transform:translateY(-2px); box-shadow:0 16px 36px rgba(14,165,233,.45); filter:brightness(1.02); }

    /* Footer */
    .site-footer{
      background: rgba(255,255,255,.9);
      backdrop-filter: saturate(160%) blur(8px);
      border-top: 1px solid rgba(2,132,199,.12);
      box-shadow: 0 -8px 30px rgba(2,6,23,.05);
    }
    .site-footer .nav-link{ color:#64748b; }
    .site-footer .nav-link:hover{ color:#0ea5e9; }

    /* Typography untuk deskripsi hero */
.hero-text .hero-kicker{
  display:inline-flex; align-items:center; gap:.5rem;
  font-family: var(--font-heading);
  font-weight:700; font-size:.95rem; letter-spacing:.3px;
  text-transform:uppercase;
  color:#0f766e; /* teal gelap agar match h1 #004d40 */
  background:linear-gradient(135deg,#e0f2f1,#d1fae5);
  border:1px solid rgba(13,148,136,.25);
  padding:.4rem .75rem; border-radius:999px;
  box-shadow:0 4px 14px rgba(13,148,136,.12) inset;
}

.hero-text .hero-lead{
  font-size:1.075rem; line-height:1.75rem;
  color:#334155; /* slate-700 */
  margin-top:1rem; margin-bottom:.75rem;
}

.hero-text .hero-desc{
  font-size:1rem; line-height:1.8rem;
  color:#475569; /* slate-600 */
  margin-bottom:1.25rem;
}

/* Util: justify yang rapi */
.text-justify{
  text-align: justify;
  text-justify: inter-word;
  hyphens: auto;
  -webkit-hyphens: auto;
  -ms-hyphens: auto;
}

/* Responsif kecil: sedikit perbesar leading agar enak dibaca */
@media (max-width: 992px){
  .hero-text .hero-lead{ font-size:1.02rem; line-height:1.85rem; }
  .hero-text .hero-desc{ font-size:1rem; line-height:1.9rem; }
}


/* ===== Duties (Tugas Pokok & Fungsi) ===== */
.duties-section{
  position:relative; padding:70px 0 90px;
  background: linear-gradient(180deg, rgba(2,132,199,.05), rgba(2,132,199,.08));
}
.duties-title{
  font-family: var(--font-heading); font-weight: 800; letter-spacing:.06em;
  text-transform: uppercase; color:#0f172a; opacity:.9; font-size:1rem;
}
.duties-heading{
  font-family: var(--font-heading); font-weight: 800; color:#0b4e9c;
  letter-spacing:.04em;
}
.duties-card{
  background:#1976d2; /* biru utama */
  border-radius:18px;
  box-shadow:0 24px 60px rgba(2,6,23,.22);
  padding:38px; color:#e8f1fd; position:relative; overflow:hidden;
}
.duties-grid{
  display:grid; grid-template-columns: 1fr 1fr; gap:34px 46px;
}
.duty{
  display:flex; gap:18px;
}
.duty .icon{
  flex:0 0 46px; height:46px; width:46px; border-radius:12px;
  background:rgba(255,255,255,.12); display:grid; place-items:center;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.25);
}
.duty .icon i{ font-size:20px; color:#fff; }
.duty h5{
  margin:0 0 .35rem; font-weight:800; letter-spacing:.02em; color:#fff;
}
.duty p{
  margin:0; color:#e4eefc; font-size:.95rem; line-height:1.7rem;
  text-align:justify; text-justify:inter-word;
}

/* Divider seperti di contoh: satu vertikal, dua horizontal */
.duties-card::before,
.duties-card::after{
  content:""; position:absolute; left:50%; top:30px; bottom:30px; width:1px;
  background:linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.06));
  transform:translateX(-.5px);
}
.duties-card::after{ /* horizontal garis tengah atas */
  left:30px; right:30px; top:calc(50% - .5px); height:1px; width:auto;
  background:linear-gradient(90deg, rgba(255,255,255,.18), rgba(255,255,255,.06));
}

/* Responsif */
@media (max-width: 992px){
  .duties-grid{ grid-template-columns: 1fr; gap:26px; }
  .duties-card::before, .duties-card::after{ display:none; }
  .duties-card{ padding:26px; }
}

/* ===== Slider Persandian ===== */
.unit-slider-section{
  position:relative; padding:64px 0 86px;
  background: linear-gradient(180deg, rgba(2,132,199,.06), rgba(2,132,199,.1));
}
.unit-title{
  font-family: var(--font-heading); font-weight: 800; letter-spacing:.05em;
  color:#0b4e9c;
}
.unit-card{
  background:#1976d2;
  border-radius:18px;
  box-shadow:0 24px 60px rgba(2,6,23,.22);
  padding:40px; color:#e8f1fd; overflow:hidden;
}
.unit-item{ display:flex; gap:18px; align-items:flex-start; }
.unit-item .icon{
  flex:0 0 50px; height:50px; width:50px; border-radius:14px;
  background:rgba(255,255,255,.12); display:grid; place-items:center;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.25);
}
.unit-item .icon i{ font-size:22px; color:#fff; }
.unit-item h4{
  margin:0 0 .5rem; font-weight:800; letter-spacing:.02em; color:#fff;
}
.unit-item p{
  margin:0; color:#e4eefc; font-size:1rem; line-height:1.8rem;
  text-align:justify; text-justify:inter-word;
}

/* Kontrol carousel diposisikan di bawah & kecil */
#unitCarousel .carousel-control-prev,
#unitCarousel .carousel-control-next{
  width:auto; bottom:10px; top:auto; opacity:.9;
  filter: drop-shadow(0 2px 8px rgba(0,0,0,.25));
}
#unitCarousel .carousel-control-prev{ left:50%; transform:translateX(-56px); }
#unitCarousel .carousel-control-next{ left:50%; transform:translateX(12px); }
#unitCarousel .carousel-indicators{
  bottom:16px;
}
#unitCarousel .carousel-indicators [data-bs-target]{
  background:#fff; opacity:.6;
}
#unitCarousel .carousel-indicators .active{ opacity:1; }

/* Responsif */
@media (max-width: 992px){
  .unit-card{ padding:26px; }
}

.btn-feature {
  display: inline-flex;
  align-items: center;
  gap: .6rem;
  padding: 14px 30px;
  font-size: 1.05rem;
  font-weight: 600;
  border-radius: 999px;
  color: #fff;
  text-decoration: none;
  background: linear-gradient(45deg, #06b6d4, #3b82f6);
  box-shadow: 0 8px 22px rgba(6,182,212,.35);
  transition: all .3s ease;
}
.btn-feature:hover {
  transform: translateY(-3px) scale(1.03);
  box-shadow: 0 12px 28px rgba(6,182,212,.45);
  color: #fff;
}
.btn-feature.orange {
  background: linear-gradient(45deg, #f97316, #facc15);
  box-shadow: 0 8px 22px rgba(249,115,22,.35);
}
.btn-feature.orange:hover {
  box-shadow: 0 12px 28px rgba(249,115,22,.45);
}

  </style>
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- HEADER -->
  <header class="site-header navbar">
    <div class="container d-flex align-items-center justify-content-between">
      <a class="navbar-brand fw-semibold d-flex align-items-center gap-2 text-decoration-none" href="{{ route('homepage') }}"><!-- ganti ke route('home') jika perlu -->
        <img src="{{ asset('images/logo-diskominfo.png') }}" width="200" height="50"  alt="Logo">
        <span class="text-dark"></span>
      </a>

      <div class="d-flex align-items-center gap-2">
        @auth
          <span class="login-name">Halo, <strong>{{ Auth::user()->name }}</strong></span>

          <div class="dropdown">
            <button class="btn btn-hamburger" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu pengguna">
              <span class="bar"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
              <li class="dropdown-header small text-muted ps-3 pe-3">
                Masuk sebagai<br><strong>{{ Auth::user()->email }}</strong>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('user.logout') }}" method="POST">@csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Log out
                  </button>
                </form>
              </li>
            </ul>
          </div>
        @else
          {{-- <a href="{{ route('user.login') }}" class="btn btn-primary btn-login rounded-pill shadow-lg">Masuk</a> --}}
        @endauth
      </div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="page-offset">
    <section class="hero-section container py-5">
      <div id="particles-js"></div>
      <div class="row align-items-center position-relative" style="z-index:1;">
        <!-- Gambar kiri -->
        <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
          <div class="hero-image text-center text-lg-start">
            <img src="{{ asset('images/123.png') }}" width="300" height="300" alt="Kabupaten Madiun" class="img-fluid">
          </div>
        </div>

        <!-- Teks kanan -->
        <div class="col-lg-6 hero-text" data-aos="fade-left">
  <h1 class="mb-4">Selamat Datang di DISKOMINFO<br>Kabupaten Madiun</h1>

  <!-- Opsi A: tetap <h5> -->
  <h5 class="hero-kicker mb-3">
    <i class="fa-solid fa-sparkles" aria-hidden="true"></i>
    Profil Singkat
  </h5>

  <p class="hero-lead text-justify">
    Dinas Komunikasi dan Informatika Kabupaten Madiun merupakan perangkat daerah yang melaksanakan
    urusan otonomi di bidang Sekretariat, Aplikasi dan Informatika, Komunikasi dan Informasi Publik,
    Persandian, dan Statistik.
  </p>

  <!-- Opsi B: tetap <h6> atau ganti <p>—dua-duanya pakai kelas hero-desc -->
  <p class="hero-desc text-justify">
    Dinas Komunikasi dan Informatika Kabupaten Madiun dibentuk berdasarkan Peraturan Menteri Dalam Negeri
    Nomor 99 Tahun 2018 tentang Kedudukan, Susunan Organisasi, Tugas, Fungsi, dan Tata Kerja Dinas
    Komunikasi dan Informatika. Dinas ini merupakan unsur pelaksana urusan pemerintahan daerah di
    bidang Sekretariat, Aplikasi dan Informatika, Komunikasi dan Informasi Publik, Persandian, dan
    Statistik. Dalam peraturan tersebut juga dijelaskan secara rinci mengenai tugas pokok dan fungsi
    Dinas Komunikasi dan Informatika Kabupaten Madiun.
  </p>
</div>
      </div>
    </section>

<!-- ===== TUGAS POKOK & FUNGSI ===== -->
<section class="duties-section">
  <div class="container">
    <div class="text-center mb-3" data-aos="fade-up" data-aos-offset="120">
      <div class="duties-title mb-1">
        <span class="me-2"><i class="fa-solid fa-bookmark"></i></span> Tugas Pokok dan Fungsi
      </div>
      <h2 class="duties-heading h1 mb-4">DINAS KOMUNIKASI DAN INFORMATIKA</h2>
    </div>

    <!-- Carousel -->
    <div id="dutiesCarousel" class="carousel slide" data-bs-touch="true" data-bs-interval="0">
      <div class="carousel-inner">

        <!-- SLIDE 1: 4 bidang -->
        <div class="carousel-item active">
          <div class="duties-card" data-aos="zoom-in" data-aos-duration="700">
            <div class="duties-grid">

              <!-- 1. Sekretariat -->
              <div class="duty">
                <div class="icon"><i class="fa-solid fa-book"></i></div>
                <div>
                  <h5>SEKRETARIAT</h5>
                  <p>Sekretariat bertugas merencanakan, melaksanakan, mengoordinasikan, serta mengendalikan kegiatan administrasi umum, kepegawaian, perlengkapan, pengelolaan aset, penyusunan program, penyusunan laporan, dan pengelolaan keuangan.</p>
                </div>
              </div>

              <!-- 2. Aplikasi dan Informatika -->
              <div class="duty">
                <div class="icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                <div>
                  <h5>APLIKASI DAN INFORMATIKA</h5>
                  <p>Bidang Aplikasi Informatika bertugas melaksanakan sebagian kewenangan Kepala Dinas, yang meliputi penyusunan kebijakan teknis, perencanaan program, penyelenggaraan, monitoring, evaluasi, serta pelaporan di bidang Infrastruktur Teknologi Informasi, Pengembangan Aplikasi, dan Ekosistem E-Government.</p>
                </div>
              </div>

              <!-- 3. Komunikasi & Informasi Publik -->
              <div class="duty">
                <div class="icon"><i class="fa-solid fa-bullhorn"></i></div>
                <div>
                  <h5>KOMUNIKASI DAN INFORMASI PUBLIK</h5>
                  <p>Bidang Komunikasi dan Pelayanan Informasi Publik bertugas menyusun kebijakan teknis, merencanakan program, menyelenggarakan kegiatan, melakukan monitoring, evaluasi, serta pelaporan di bidang penyediaan konten lintas sektoral, pengelolaan media komunikasi publik, layanan hubungan media, penguatan kapasitas sumber daya komunikasi publik, serta penyediaan akses informasi.</p>
                </div>
              </div>

              <!-- 4. Statistik -->
              <div class="duty">
                <div class="icon"><i class="fa-solid fa-chart-column"></i></div>
                <div>
                  <h5>STATISTIK</h5>
                  <p>Bidang Statistik bertugas menyusun kebijakan teknis, merencanakan program, menyelenggarakan, mengoordinasikan, memfasilitasi, mendiseminasikan, melakukan monitoring, evaluasi, serta menyusun pelaporan di bidang statistik sektoral.</p>
                </div>
              </div>

            </div>
          </div>
        </div><!-- end slide 1 -->

        <!-- SLIDE 2: Persandian -->
        <div class="carousel-item">
          <div class="duties-card" data-aos="zoom-in" data-aos-duration="700">
            <div class="duties-grid">
              <div class="duty">
                <div class="icon"><i class="fa-solid fa-qrcode"></i></div>
                <div>
                  <h5>PERSANDIAN</h5>
                  <p>Bidang Persandian bertugas menyusun kebijakan teknis, merencanakan program, menyelenggarakan kegiatan, melakukan monitoring, evaluasi, serta pelaporan di bidang persandian untuk mendukung pengamanan informasi.</p>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end slide 2 -->

      </div><!-- /.carousel-inner -->

      <!-- Kontrol di bawah -->
      <!-- Kontrol di bawah -->
<div class="d-flex justify-content-center mt-3">
  <button id="prevBtn" class="btn btn-outline-dark me-2" type="button" data-bs-target="#dutiesCarousel" data-bs-slide="prev" disabled>
    <i class="fa-solid fa-chevron-left"></i> Sebelumnya
  </button>
  <button id="nextBtn" class="btn btn-outline-dark" type="button" data-bs-target="#dutiesCarousel" data-bs-slide="next">
    Berikutnya <i class="fa-solid fa-chevron-right"></i>
  </button>
</div>

    </div><!-- /.carousel -->

  </div>
</section>
<!-- ===== END TUGAS POKOK & FUNGSI ===== -->

<!-- ===== FITUR KHUSUS ===== -->
<section class="features-section py-5">
  <div class="container text-center">
    <div class="mb-4" data-aos="fade-up">
      <h2 class="h1 fw-bold">Fitur Layanan Khusus</h2>
      <p class="text-muted">Nikmati layanan digital unggulan dari Dinas Komunikasi dan Informatika Kabupaten Madiun</p>
    </div>

<div class="d-flex justify-content-center gap-4 flex-wrap">
  <!-- Buku Tamu Digital -->
  <a href="{{ route('buku-tamu') }}" 
     class="d-flex align-items-center p-3 border rounded shadow-sm text-decoration-none" 
     data-aos="zoom-in" data-aos-delay="100">

    <!-- Logo / Icon -->
    <img src="{{ asset('images/logo-buku.png') }}" 
         alt="Logo Buku Tamu" 
         width="50" height="50" 
         class="me-3">

    <!-- Text -->
    <div>
      <h5 class="mb-0 fw-bold text-dark">Buku Tamu</h5>
      <small class="text-muted">Lihat Selengkapnya »</small>
    </div>
  </a>

  <!-- Madiun Esport -->
  <a href="{{ route('esport.home') }}" 
     class="d-flex align-items-center p-3 border rounded shadow-sm text-decoration-none" 
     data-aos="zoom-in" data-aos-delay="200">

    <!-- Logo / Icon -->
    <img src="{{ asset('images/logo-mgen.png') }}" 
         alt="Logo Madiun Esport" 
         width="50" height="50" 
         class="me-3">

    <!-- Text -->
    <div>
      <h5 class="mb-0 fw-bold text-dark">Madiun Esport (M-GEN)</h5>
      <small class="text-muted">Lihat Selengkapnya »</small>
    </div>
  </a>
</div>

</section>

  </main>

  <!-- FOOTER -->
<footer class="bg-dark text-light pt-5 pb-3 mt-auto">
  <div class="container">
    <div class="row">
      <!-- Info instansi -->
      <div class="col-md-6">
        <h5 class="fw-bold">Kominfo Kabupaten Madiun</h5>
        <p class="mb-1">Jl. Mastrip No.23, Mojorejo,<br>
          Kec. Taman,<br>
          Kota Madiun, Jawa Timur 63139.</p>

        <p class="mb-1 fw-semibold">Jam Pelayanan:</p>
        <p class="mb-1">Senin – Kamis (07.30 – 15.15)</p>
        <p class="mb-3">Jumat (07.00 – 14.30)</p>

        <p class="mb-1 fw-semibold">Kontak:</p>
        <p class="mb-1">Telp: 0351-462927</p>
        <p class="mb-1">Fax: 0351-462927</p>
        <p>Email: <a href="mailto:diskominfo@madiunkab.go.id" class="text-decoration-none text-light">diskominfo@madiunkab.go.id</a></p>
      </div>

      <!-- Sosmed -->
      <div class="col-md-6 d-flex align-items-center justify-content-md-end justify-content-start gap-3 mt-3 mt-md-0">
        <a href="https://www.instagram.com/kominfokabmadiun/" class="btn btn-outline-light rounded-circle" aria-label="Instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://www.youtube.com/@diskominfokabupatenmadiun717" class="btn btn-outline-light rounded-circle" aria-label="YouTube">
          <i class="fa-brands fa-youtube"></i>
        </a>
         <a href="https://madiunkab.go.id/" target="_blank" class="d-inline-block" aria-label="Website Kabupaten Madiun">
          <img src="{{ asset('images/123.png') }}" alt="Kabupaten Madiun" 
               style="width:40px; height:40px; object-fit:contain;" class="rounded-circle bg-white p-1">
        </a>
      </div>
    </div>

    <!-- Garis pemisah -->
    <hr class="border-secondary mt-4">

    <!-- Copyright -->
    <div class="text-center small text-white">
      © {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Madiun — All rights reserved.
    </div>
  </div>
</footer>


  </div>
</footer>


  <!-- JS libs -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

  <script>
    AOS.init({ duration: 1000, once: true });

    particlesJS('particles-js', {
      particles: {
        number: { value: 50, density: { enable: true, value_area: 800 }},
        color: { value: '#2196F3' },
        shape: { type: 'circle' },
        opacity: { value: 0.4, random: true },
        size: { value: 3, random: true },
        move: { enable: true, speed: 1.5, random: true, out_mode: 'out' }
      }
    });
  </script>

  <script>
  const carousel = document.getElementById('dutiesCarousel');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  carousel.addEventListener('slid.bs.carousel', function () {
    const activeIndex = Array.from(carousel.querySelectorAll('.carousel-item'))
                             .findIndex(item => item.classList.contains('active'));
    const totalItems = carousel.querySelectorAll('.carousel-item').length;

    // Disable prev di slide pertama
    if (activeIndex === 0) {
      prevBtn.disabled = true;
    } else {
      prevBtn.disabled = false;
    }

    // Disable next di slide terakhir
    if (activeIndex === totalItems - 1) {
      nextBtn.disabled = true;
    } else {
      nextBtn.disabled = false;
    }
  });
</script>



</body>
</html>
