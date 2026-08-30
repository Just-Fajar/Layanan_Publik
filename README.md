# Portal Layanan Publik Diskominfo Kabupaten Madiun

Portal Layanan Publik Diskominfo Kabupaten Madiun adalah platform digital terpadu Pemerintah Kabupaten Madiun yang mengintegrasikan tiga layanan publik utama dalam satu ekosistem: Buku Tamu Digital, Kalender Event Daerah, dan Komunitas Madiun Esport (M-GEN).

---

## Standar Kualitas Google Lighthouse

Seluruh modul publik telah dioptimasi dan memenuhi standar tertinggi Google Lighthouse pada perangkat Desktop dan Mobile:

| Halaman / Modul | Perangkat | Best Practices | Accessibility | SEO | Status |
| :--- | :---: | :---: | :---: | :---: | :---: |
| **Portal Beranda Utama (`/`)** | Desktop & Mobile | **100 / 100** | **100 / 100** | **100 / 100** | Terverifikasi |
| **Buku Tamu Digital (`/buku-tamu`)** | Desktop & Mobile | **100 / 100** | **100 / 100** | **100 / 100** | Terverifikasi |
| **Kalender Event (`/calendar`)** | Desktop & Mobile | **100 / 100** | **100 / 100** | **100 / 100** | Terverifikasi |
| **Madiun Esport (`/esport`)** | Desktop & Mobile | **100 / 100** | **100 / 100** | **100 / 100** | Terverifikasi |

---

## Modul Utama dan Akses Rute

### 1. Portal Utama
* Beranda Terpadu: `GET /`

### 2. Modul Buku Tamu Digital
* Formulir Presensi Pengunjung: `GET /buku-tamu`
* API Pendaftaran Presensi (Swafoto & GPS): `POST /api/visitors`
* API Statistik & Grafik Kunjungan: `GET /api/statistics`
* API Ekspor Laporan PDF: `GET /api/export/pdf`
* Dashboard Admin Buku Tamu: `GET /buku-tamu/admin/dashboard`
* Kalender Kunjungan Admin: `GET /buku-tamu/admin/dashboard/calendar`

### 3. Modul Kalender Event Daerah
* Katalog Event Publik: `GET /calendar`
* Tampilan Kalender Bulanan: `GET /calendar/view`
* Detail Informasi Event: `GET /calendar/{event}`
* Autentikasi Peserta:
  * Masuk Akun: `GET /calendar/login`
  * Registrasi Akun: `GET /calendar/register`
* Portal Peserta Event:
  * Dashboard Peserta: `GET /calendar/user/dashboard`
  * Riwayat Tiket & Barcode Presensi: `GET /calendar/user/events`
  * Pengaturan Profil: `GET /calendar/user/profile`
* Dashboard Admin Kalender: `GET /calendar/admin/events`

### 4. Modul Madiun Esport (M-GEN)
* Beranda Komunitas Esport: `GET /esport`
* Informasi Turnamen Game: `GET /esport/tournaments`
* Berita & Artikel Esport: `GET /esport/news`
* Autentikasi Pengguna:
  * Masuk Akun: `GET /esport/login`
  * Registrasi Akun: `GET /esport/register`
* Portal Atlet & Tim Esport:
  * Dashboard Pengguna: `GET /esport/user/dashboard`
  * Status Pendaftaran Turnamen: `GET /esport/user/tournaments`
  * Pengaturan Profil: `GET /esport/user/profile`
* Dashboard Admin Esport: `GET /esport/admin/tournaments`

### 5. Halaman Penanganan Kesalahan (Custom Error Pages)
Aplikasi menyediakan 4 halaman penanganan kesalahan khusus yang responsif dan animatif:
* `404`: Halaman Tidak Ditemukan (`resources/views/errors/404.blade.php`)
* `403`: Akses Terbatas / Ditolak (`resources/views/errors/403.blade.php`)
* `500`: Gangguan Server Backend (`resources/views/errors/500.blade.php`)
* `503`: Pemeliharaan Sistem / Maintenance Mode (`resources/views/errors/503.blade.php`)

---

## Struktur Bidang Resmi Diskominfo Kabupaten Madiun

Modul pencatatan kunjungan dan laporan resmi diselaraskan dengan 5 bidang resmi Diskominfo Kabupaten Madiun:
1. **Sekretariat** (`sekretariat`)
2. **Aplikasi Informatika** (`aplikasi_informatika`)
3. **Persandian & Keamanan Informasi** (`persandian_keamanan_informasi`)
4. **Informasi dan Komunikasi Publik** (`informasi_komunikasi_publik`)
5. **Statistik** (`statistik`)

---

## Arsitektur Autentikasi dan RBAC

Aplikasi menerapkan sistem multi-guard Laravel:
* **Guard `web`**: Autentikasi pengguna umum (tabel `users`) yang terintegrasi pada modul Kalender Event dan Madiun Esport.
* **Guard `admin`**: Autentikasi administrator terpadu (tabel `admins`) dengan hak akses berbasis peran (RBAC):
  * `super_admin`: Akses penuh ke seluruh modul administratif.
  * `buku_tamu`: Akses khusus modul buku tamu dan data pengunjung.
  * `calendar`: Akses khusus manajemen event daerah dan presensi peserta.
  * `esport`: Akses khusus manajemen turnamen, berita, dan registrasi tim.

Akses login admin terpusat: `GET /admin` atau `GET /buku-tamu/admin`.

---

## Persyaratan Sistem

* PHP >= 8.1
* Composer >= 2.x
* Node.js & NPM
* MySQL >= 8.0 (atau SQLite untuk pengujian otomatis)

---

## Panduan Instalasi

1. Clone repositori:
   ```bash
   git clone https://github.com/Just-Fajar/Layanan_Publik.git
   cd Layanan_Publik
   ```

2. Pasang dependensi backend dan frontend:
   ```bash
   composer install
   npm install
   ```

3. Konfigurasi berkas environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Jalankan migrasi dan seeder database:
   ```bash
   php artisan migrate --seed
   ```

5. Buat tautan simbolis penyimpanan file:
   ```bash
   php artisan storage:link
   ```

6. Kompilasi aset frontend dan jalankan server pengembangan:
   ```bash
   npm run build
   php artisan serve
   ```

---

## Pengujian Otomatis dan Kualitas Kode

Proyek ini teruji secara menyeluruh dengan **255 automated tests dan 880 assertions (100% PASS)** menggunakan PHPUnit:

```bash
# Menjalankan seluruh pengujian (Unit & Feature)
vendor/bin/phpunit

# Menjalankan pengujian Unit (Models, Services, Policies, Middleware)
vendor/bin/phpunit tests/Unit

# Menjalankan pengujian Feature per modul
vendor/bin/phpunit tests/Feature/BukuTamu
vendor/bin/phpunit tests/Feature/CalendarEvent
vendor/bin/phpunit tests/Feature/Esport
vendor/bin/phpunit tests/Feature/CustomErrorPagesTest.php
```

Standarisasi format dan gaya penulisan kode menggunakan Laravel Pint:
```bash
vendor/bin/pint
```
