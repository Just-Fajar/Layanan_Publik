# Portal Layanan Publik Diskominfo Kabupaten Madiun

Portal Layanan Publik Diskominfo Kabupaten Madiun adalah aplikasi web terpadu yang menyatukan tiga layanan publik digital dalam satu platform: Buku Tamu Digital, Kalender Event Daerah, dan Madiun Esport (M-GEN).

---

## Modul Utama dan Akses Rute

### 1. Portal Utama
- Beranda Terpadu: `GET /`

### 2. Modul Buku Tamu
- Formulir Pengunjung: `GET /buku-tamu`
- API Registrasi Pengunjung: `POST /api/visitors`
- API Statistik Kunjungan: `GET /api/statistics`
- API Ekspor PDF: `GET /api/export/pdf`
- Dashboard Admin: `GET /buku-tamu/admin/dashboard`
- Kalender Kunjungan Admin: `GET /buku-tamu/admin/dashboard/calendar`

### 3. Modul Kalender Event
- Beranda Kalender: `GET /calendar`
- Detail Event: `GET /calendar/{event}`
- Autentikasi Pengguna:
  - Login Pengguna: `GET /calendar/login`
  - Registrasi Pengguna: `GET /calendar/register`
- Portal Pengguna:
  - Dashboard Pengguna: `GET /calendar/user/dashboard`
  - Riwayat Tiket & Barcode Kehadiran: `GET /calendar/user/events`
  - Pengaturan Profil: `GET /calendar/user/profile`
- Admin Kalender Event: `GET /calendar/admin/events`

### 4. Modul Madiun Esport (M-GEN)
- Beranda Esport: `GET /esport`
- Informasi Turnamen: `GET /esport/tournaments`
- Berita Esport: `GET /esport/news`
- Autentikasi Pengguna:
  - Login Pengguna: `GET /esport/login`
  - Registrasi Pengguna: `GET /esport/register`
- Portal Pengguna:
  - Dashboard Pengguna: `GET /esport/user/dashboard`
  - Pendaftaran & Status Turnamen: `GET /esport/user/tournaments`
  - Pengaturan Profil: `GET /esport/user/profile`
- Admin Esport: `GET /esport/admin/tournaments`

---

## Arsitektur Autentikasi dan RBAC

Aplikasi menerapkan arsitektur multi-guard Laravel:
- **Guard `web`**: Autentikasi pengguna umum (`users` table) yang digunakan bersama pada modul Kalender Event dan Madiun Esport.
- **Guard `admin`**: Autentikasi administrator terpadu (`admins` table) dengan kendali akses berbasis peran (RBAC):
  - `super_admin`: Akses penuh ke seluruh modul administratif.
  - `buku_tamu`: Akses khusus modul buku tamu dan data pengunjung.
  - `calendar`: Akses khusus manajemen event, pendaftar, dan presensi.
  - `esport`: Akses khusus manajemen turnamen, berita, dan verifikasi tim.

Login administrator terpusat di `GET /buku-tamu/admin`.

---

## Persyaratan Sistem

- PHP >= 8.1
- Composer >= 2.x
- Node.js & NPM
- MySQL >= 8.0 (atau SQLite untuk pengujian)

---

## Panduan Instalasi

1. Clone repositori:
   ```bash
   git clone https://github.com/Just-Fajar/Layanan_Publik.git
   cd Layanan_Publik
   ```

2. Install dependensi backend dan frontend:
   ```bash
   composer install
   npm install
   ```

3. Konfigurasi file environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Jalankan migrasi dan seeder database:
   ```bash
   php artisan migrate --seed
   ```

5. Buat symbolic link storage untuk upload file:
   ```bash
   php artisan storage:link
   ```

6. Jalankan aplikasi pada lingkungan pengembangan:
   ```bash
   npm run build
   php artisan serve
   ```

---

## Pengujian Otomatis

Proyek ini dilengkapi dengan unit test dan feature test otomatis menggunakan PHPUnit:

```bash
# Menjalankan seluruh rangkaian pengujian
vendor/bin/phpunit

# Menjalankan pengujian per modul
vendor/bin/phpunit tests/Feature/BukuTamu
vendor/bin/phpunit tests/Feature/CalendarEvent
vendor/bin/phpunit tests/Feature/Esport
vendor/bin/phpunit tests/Feature/HomepageTest.php
```

Standarisasi format kode menggunakan Laravel Pint:
```bash
vendor/bin/pint
```
