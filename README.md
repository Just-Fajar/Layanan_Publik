# 📘 Buku Tamu Digital - Diskominfo Kabupaten Madiun

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)

**Sistem Informasi Buku Tamu Digital dengan Fitur Geolocation & E-Sport Management**

[Fitur](#-fitur) • [Teknologi](#-teknologi) • [Instalasi](#-instalasi) • [Kontribusi](#-kontribusi) • [Lisensi](#-lisensi)

</div>

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#%EF%B8%8F-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Struktur Proyek](#-struktur-proyek)
- [API Endpoints](#-api-endpoints)
- [Kontribusi](#-kontribusi)
- [Tim Pengembang](#-tim-pengembang)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Proyek

**Buku Tamu Digital** adalah aplikasi web modern yang dikembangkan untuk Dinas Komunikasi dan Informatika Kabupaten Madiun. Aplikasi ini menyediakan sistem pencatatan kunjungan tamu secara digital dengan fitur-fitur canggih seperti validasi geolokasi, export PDF, QR Code, dan dashboard analitik real-time.

Selain itu, proyek ini juga dilengkapi dengan modul **E-Sport Management** untuk mengelola turnamen dan berita e-sport.

### 🎨 Demo

- **Frontend (Buku Tamu)**: `/buku-tamu`
- **Admin Dashboard**: `/buku-tamu/admin`
- **E-Sport Portal**: `/esport`

---

## ✨ Fitur Utama

### 📝 Modul Buku Tamu

#### **Untuk Pengunjung**
- ✅ Formulir pengisian data pengunjung yang user-friendly
- 📍 **Validasi Geolokasi** - Hanya pengunjung dalam radius tertentu yang dapat mengisi
- 📸 Upload foto pengunjung
- 🎯 Pilihan tujuan kunjungan (Sekretariat, Aplikasi Informatika, dll)
- 📱 Responsive design untuk semua perangkat

#### **Untuk Admin**
- 🔐 Sistem autentikasi aman (Laravel Sanctum)
- 📊 Dashboard analitik dengan Chart.js:
  - Total pengunjung (semua waktu)
  - Pengunjung hari ini
  - Pengunjung bulan ini
  - Statistik per semester
  - Rata-rata harian
- 📈 Grafik kunjungan per tujuan (Pie Chart)
- 📉 Trend kunjungan bulanan (Line Chart)
- 🔍 Filter data berdasarkan:
  - Nama pengunjung
  - Tujuan kunjungan
  - Tanggal
- 📄 Export laporan ke PDF dengan kop surat resmi
- 📅 Kalender view untuk melihat kunjungan per tanggal
- 🔲 Generate QR Code untuk link buku tamu
- 🖼️ Preview foto pengunjung (modal lightbox)
- 🗑️ Hapus data pengunjung
- 📱 Fully responsive admin panel

### 🎮 Modul E-Sport

#### **Frontend**
- 🏆 Halaman turnamen dengan detail lengkap
- 📰 Berita e-sport terkini
- 👥 Informasi tim dan kontak
- 🎨 Modern UI dengan animasi

#### **Admin E-Sport**
- ➕ CRUD turnamen (Create, Read, Update, Delete)
- ✍️ CRUD berita e-sport
- 📤 Upload gambar turnamen & berita

---

## 🛠 Teknologi

### Backend
- **Framework**: Laravel 10.x (PHP 8.1+)
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum (Token-based API auth)
- **PDF Generator**: DomPDF (untuk export laporan)
- **QR Code**: SimpleSoftwareIO Simple QR Code

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: TailwindCSS 3.x
- **JavaScript**: Vanilla JS + Alpine.js
- **Build Tool**: Vite 5.x
- **Charts**: Chart.js
- **Icons**: Heroicons (SVG)

### Fitur Khusus
- **Geolocation API**: Browser Geolocation + Haversine Distance
- **Responsive Design**: Mobile-first approach
- **Real-time Validation**: Client & Server-side validation

---

## ⚙️ Persyaratan Sistem

Sebelum memulai instalasi, pastikan sistem Anda memenuhi persyaratan berikut:

| Komponen | Versi Minimum | Rekomendasi |
|----------|---------------|-------------|
| **PHP** | 8.1 | 8.2+ |
| **Composer** | 2.0 | Latest |
| **Node.js** | 18.x | 20.x LTS |
| **NPM** | 9.x | Latest |
| **MySQL** | 8.0 | 8.0+ |
| **Web Server** | Apache/Nginx | Nginx |
| **OS** | Windows/Linux/macOS | Linux (Ubuntu 22.04) |

### Extension PHP yang Diperlukan
```bash
- php-mbstring
- php-xml
- php-curl
- php-zip
- php-gd
- php-mysql
- php-pdo
- php-tokenizer
- php-bcmath
- php-json
- php-openssl
```

---

## 🚀 Instalasi

### 1️⃣ Clone Repository

```bash
# Clone repository
git clone https://github.com/Just-Fajar/Layanan_Publik.git

# Masuk ke direktori proyek
cd Layanan_Publik
```

### 2️⃣ Install Dependencies PHP

```bash
# Install dependencies menggunakan Composer
composer install
```

### 3️⃣ Install Dependencies JavaScript

```bash
# Install dependencies menggunakan NPM
npm install
```

### 4️⃣ Setup Environment

```bash
# Copy file .env.example menjadi .env
copy .env.example .env
# Untuk Linux/macOS gunakan: cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5️⃣ Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=layanan_publik
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 6️⃣ Buat Database

```bash
# Buat database MySQL (jalankan di MySQL console)
CREATE DATABASE layanan_publik CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau gunakan phpMyAdmin/MySQL Workbench untuk membuat database.

### 7️⃣ Migrasi Database

```bash
# Jalankan migrasi untuk membuat tabel-tabel
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

### 8️⃣ Setup Storage Link

```bash
# Buat symbolic link untuk storage (upload foto)
php artisan storage:link
```

### 9️⃣ Build Assets Frontend

```bash
# Development (dengan hot reload)
npm run dev

# Production (optimized build)
npm run build
```

### 🔟 Jalankan Aplikasi

```bash
# Jalankan development server
php artisan serve

# Aplikasi akan berjalan di http://localhost:8000
```

Untuk production, gunakan web server seperti Nginx atau Apache dengan PHP-FPM.

---

## ⚙️ Konfigurasi

### 🌍 Konfigurasi Geolokasi

Untuk mengubah koordinat target geolokasi, edit file:

**`public/js/geolocation.js`**
```javascript
const TARGET_LAT = -7.628903;  // Latitude Diskominfo
const TARGET_LNG = 111.523674; // Longitude Diskominfo
const MAX_DISTANCE = 500;      // Radius dalam meter
```

**`app/Http/Controllers/VisitorController.php`**
```php
private const TARGET_LAT = -7.628903;
private const TARGET_LNG = 111.523674;
private const MAX_DISTANCE_KM = 0.5; // 500 meter
```

### 🔐 Akun Admin Default

Setelah menjalankan seeder, gunakan kredensial berikut untuk login admin:

```
Email: admin@diskominfo.madiunkab.go.id
Password: password123
```

**⚠️ PENTING**: Segera ubah password setelah login pertama kali untuk keamanan!

### 📧 Konfigurasi Email (Opsional)

Edit `.env` untuk mengaktifkan fitur email:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@diskominfo.madiunkab.go.id"
MAIL_FROM_NAME="Buku Tamu Digital"
```

### 🎨 Kustomisasi Logo

Ganti logo di file berikut:
- **Dashboard**: `public/images/logo-diskominfo.png`
- **PDF Header**: `public/images/123.png`

---

## 📖 Penggunaan

### Akses Aplikasi

| Halaman | URL | Deskripsi |
|---------|-----|-----------|
| **Homepage** | `/` | Halaman utama |
| **Buku Tamu (Pengunjung)** | `/buku-tamu` | Form pengisian tamu |
| **Admin Login** | `/buku-tamu/admin` | Login administrator |
| **Admin Dashboard** | `/buku-tamu/admin/dashboard` | Dashboard admin |
| **Kalender** | `/buku-tamu/admin/dashboard/calendar` | View kalender |
| **QR Code** | `/buku-tamu/admin/dashboard/qrcode` | Generate QR Code |
| **E-Sport Portal** | `/esport` | Portal e-sport publik |
| **E-Sport Admin** | `/buku-tamu/admin/esport` | Admin e-sport |

### Workflow Pengisian Buku Tamu

1. **Pengunjung membuka** `/buku-tamu`
2. **Browser meminta izin** geolokasi
3. **Sistem memvalidasi** posisi pengunjung (dalam radius?)
4. **Jika valid**, form buku tamu ditampilkan
5. **Pengunjung mengisi** nama, email, telepon, tujuan, dll
6. **Upload foto** (opsional)
7. **Submit** → Data tersimpan ke database
8. **Admin dapat melihat** di dashboard real-time

### Menonaktifkan Geolokasi

Jika ingin menonaktifkan fitur geolokasi tanpa menghapus kode:

**`resources/views/buku_tamu/visitor.blade.php`**
```javascript
// Ubah baris berikut (sekitar line 450)
// Dari:
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(onLocationSuccess, onLocationError);
}

// Menjadi:
// if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(onLocationSuccess, onLocationError);
// }
// Langsung aktifkan form tanpa cek lokasi
onLocationSuccess({ coords: { latitude: TARGET_LAT, longitude: TARGET_LNG } });
```

---

## 📁 Struktur Proyek

```
Layanan_Publik/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Autentikasi admin
│   │   │   ├── VisitorController.php       # CRUD pengunjung + API
│   │   │   ├── QRCodeController.php        # Generate QR Code
│   │   │   ├── EsportController.php        # E-Sport public
│   │   │   └── EsportAdminController.php   # E-Sport admin
│   │   ├── Middleware/                     # Custom middleware
│   │   └── Requests/                       # Form validation
│   └── Models/
│       ├── Visitor.php                     # Model pengunjung
│       ├── Admin.php                       # Model admin
│       ├── Tournament.php                  # Model turnamen
│       └── News.php                        # Model berita
├── database/
│   ├── migrations/                         # Database migrations
│   └── seeders/                            # Database seeders
├── public/
│   ├── js/
│   │   └── geolocation.js                  # Validasi geolokasi
│   ├── images/                             # Logo & assets
│   └── storage/                            # Upload files (symlink)
├── resources/
│   ├── views/
│   │   ├── homepage/                       # Landing page
│   │   ├── buku_tamu/
│   │   │   ├── visitor.blade.php           # Form tamu
│   │   │   ├── admin/
│   │   │   │   ├── dashboard.blade.php     # Admin dashboard
│   │   │   │   └── calendar.blade.php      # Kalender view
│   │   │   └── pdf/
│   │   │       └── visitors.blade.php      # Template PDF
│   │   └── esport/                         # E-Sport views
│   ├── css/
│   │   └── app.css                         # TailwindCSS
│   └── js/
│       └── app.js                          # Main JS entry
├── routes/
│   ├── web.php                             # Web routes
│   └── api.php                             # API routes
├── .env.example                            # Environment template
├── composer.json                           # PHP dependencies
├── package.json                            # NPM dependencies
├── tailwind.config.js                      # TailwindCSS config
├── vite.config.js                          # Vite build config
└── README.md                               # 📄 Anda di sini!
```

---

## 🔌 API Endpoints

### Autentikasi

| Method | Endpoint | Deskripsi | Auth |
|--------|----------|-----------|------|
| `POST` | `/api/login` | Login admin | ❌ |
| `POST` | `/api/logout` | Logout admin | ✅ Bearer |

### Statistik

| Method | Endpoint | Deskripsi | Auth |
|--------|----------|-----------|------|
| `GET` | `/api/statistics` | Statistik pengunjung | ✅ Bearer |

**Query Parameters**:
- `date` (YYYY-MM-DD): Filter tanggal tertentu
- `month` (1-12) & `year` (YYYY): Filter bulan tertentu

**Response Example**:
```json
{
  "success": true,
  "data": {
    "total": 220,
    "today": 5,
    "this_month": 53,
    "purpose_stats": [
      { "purpose": "sekretariat", "count": 46 },
      { "purpose": "aplikasi_informatika", "count": 89 }
    ],
    "monthly_stats": [
      { "month": 1, "year": 2025, "count": 12 },
      { "month": 2, "year": 2025, "count": 25 }
    ]
  }
}
```

### Pengunjung

| Method | Endpoint | Deskripsi | Auth |
|--------|----------|-----------|------|
| `GET` | `/api/visitors` | List pengunjung (paginated) | ✅ Bearer |
| `POST` | `/api/visitors` | Tambah pengunjung baru | ❌ |
| `DELETE` | `/api/visitors/{id}` | Hapus pengunjung | ✅ Bearer |

**Query Parameters (GET)**:
- `page` (int): Halaman pagination
- `name` (string): Cari berdasarkan nama
- `purpose` (string): Filter tujuan
- `date` (YYYY-MM-DD): Filter tanggal

**POST Body Example**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "081234567890",
  "asal_daerah": "Madiun",
  "purpose": "sekretariat",
  "notes": "Konsultasi sistem",
  "photo": "base64_encoded_image_or_file",
  "latitude": -7.628903,
  "longitude": 111.523674
}
```

### Export PDF

| Method | Endpoint | Deskripsi | Auth |
|--------|----------|-----------|------|
| `GET` | `/api/visitors/export/pdf` | Download PDF laporan | ✅ Bearer |

**Query Parameters**:
- `format` (a4/f4/letter/legal): Format kertas
- `orientation` (portrait/landscape): Orientasi

---

## 🤝 Kontribusi

Kami sangat terbuka untuk kontribusi dari komunitas! Berikut panduan untuk berkontribusi:

### Cara Berkontribusi

1. **Fork** repository ini
2. **Clone** fork Anda:
   ```bash
   git clone https://github.com/USERNAME-ANDA/Layanan_Publik.git
   ```
3. Buat **branch baru** untuk fitur/bugfix:
   ```bash
   git checkout -b feature/nama-fitur
   # atau
   git checkout -b bugfix/nama-bug
   ```
4. **Commit** perubahan Anda:
   ```bash
   git add .
   git commit -m "feat: deskripsi singkat fitur"
   ```
5. **Push** ke branch Anda:
   ```bash
   git push origin feature/nama-fitur
   ```
6. Buat **Pull Request** ke branch `main` repository utama

### Aturan Commit Message

Gunakan [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: menambahkan fitur export Excel
fix: memperbaiki bug geolokasi di iOS
docs: update dokumentasi API
style: format ulang kode dengan Laravel Pint
refactor: optimasi query database
test: tambah unit test untuk VisitorController
chore: update dependencies
```

### Coding Standards

- **PHP**: Ikuti [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
  ```bash
  # Jalankan Laravel Pint untuk format otomatis
  ./vendor/bin/pint
  ```
- **JavaScript**: Gunakan ESLint + Prettier
- **CSS**: Gunakan TailwindCSS utility classes
- **Blade**: Indentasi 4 spasi, tag self-closing jika tidak ada konten

### Menjalankan Tests

```bash
# Jalankan semua test
php artisan test

# Test spesifik
php artisan test --filter=VisitorTest
```

### Isu & Bug Report

Jika menemukan bug atau ingin request fitur, buat **Issue** dengan template:

**Bug Report**:
- Deskripsi bug
- Langkah reproduksi
- Expected behavior
- Actual behavior
- Screenshot (jika perlu)
- Environment (OS, Browser, PHP version)

**Feature Request**:
- Deskripsi fitur yang diinginkan
- Use case / manfaat
- Mockup/wireframe (jika ada)

---

## 👥 Tim Pengembang

Proyek ini dikembangkan oleh tim developer sebagai bagian dari program **Kerja Praktik** di:

**Dinas Komunikasi dan Informatika Kabupaten Madiun**

📍 Jalan Mastrip Nomor 23, Madiun 63117  
📞 Telp/Fax: (0351) 462927  
🌐 Website: [diskominfo.madiunkab.go.id](https://diskominfo.madiunkab.go.id)  
📧 Email: diskominfo@madiunkab.go.id

### Kontributor

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/Just-Fajar">
        <img src="https://github.com/Just-Fajar.png" width="100px;" alt="Just Fajar"/>
        <br />
        <sub><b>Just Fajar</b></sub>
      </a>
      <br />
      <sub>Lead Developer</sub>
    </td>
    <!-- Tambahkan kontributor lain di sini -->
  </tr>
</table>

---

## 📜 Lisensi

Proyek ini dilisensikan di bawah **MIT License** - lihat file [LICENSE](LICENSE) untuk detail.

```
MIT License

Copyright (c) 2025 Dinas Komunikasi dan Informatika Kabupaten Madiun

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction...
```

---

## 📞 Kontak & Dukungan

Jika Anda memiliki pertanyaan atau membutuhkan bantuan:

- 📧 **Email**: diskominfo@madiunkab.go.id
- 🐛 **Issues**: [GitHub Issues](https://github.com/Just-Fajar/Layanan_Publik/issues)
- 💬 **Discussions**: [GitHub Discussions](https://github.com/Just-Fajar/Layanan_Publik/discussions)

---

## 🙏 Acknowledgments

Terima kasih kepada:

- **Laravel Team** untuk framework yang luar biasa
- **TailwindCSS** untuk utility-first CSS
- **Chart.js** untuk library charting
- **SimpleSoftwareIO** untuk QR Code generator
- **DomPDF** untuk PDF generation
- **Dinas Komunikasi dan Informatika Kabupaten Madiun** untuk dukungan dan kesempatan

---

## 🗺️ Roadmap

### Versi 2.0 (Planned)

- [ ] Multi-language support (ID/EN)
- [ ] Dark mode
- [ ] Export to Excel
- [ ] Email notification untuk admin
- [ ] SMS notification untuk pengunjung
- [ ] Dashboard analytics yang lebih advanced
- [ ] Face recognition untuk absensi
- [ ] Mobile app (Flutter)
- [ ] API documentation dengan Swagger/OpenAPI
- [ ] Unit & Integration tests (coverage 80%+)

---

<div align="center">

**⭐ Jangan lupa beri Star jika proyek ini bermanfaat! ⭐**

Made with ❤️ by **Diskominfo Kabupaten Madiun**

</div>
