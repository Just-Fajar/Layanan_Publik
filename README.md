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

## Galeri Pratinjau Antarmuka (Screenshots)

### 1. Portal Utama
Beranda terpadu yang memuat profil instansi, pusat akses modul, dan pengumuman dinas:
![Portal Beranda Utama](docs/screenshots/01-portal/01-portal-beranda.png)

---

### 2. Modul Buku Tamu Digital
Pencatatan presensi pengunjung berbasis kamera swafoto real-time dan deteksi lokasi GPS:
![Formulir Presensi Pengunjung](docs/screenshots/02-buku-tamu/01-buku-tamu-form-publik.png)

<details>
<summary><b>Tampilkan Tangkapan Layar Lengkap Modul Buku Tamu (Admin & Rekap)</b></summary>

#### Login Admin Terpadu
![Login Admin](docs/screenshots/02-buku-tamu/02-admin-login.png)

#### Dashboard Statistik Kunjungan
![Dashboard Admin Buku Tamu](docs/screenshots/02-buku-tamu/03-buku-tamu-admin-dashboard.png)

#### Kalender Kunjungan Tamu Dinas
![Kalender Kunjungan](docs/screenshots/02-buku-tamu/04-buku-tamu-admin-calendar.png)

#### Data Pengunjung & Ekspor Laporan PDF
![Data Pengunjung](docs/screenshots/02-buku-tamu/05-buku-tamu-admin-visitors.png)

</details>

---

### 3. Modul Kalender Event Daerah
Publikasi agenda kegiatan dinas, registrasi peserta, dan verifikasi presensi berbasis QR Code:
![Katalog Event Publik](docs/screenshots/03-calendar/01-calendar-katalog-publik.png)

<details>
<summary><b>Tampilkan Tangkapan Layar Lengkap Modul Kalender Event (Jadwal, Tiket, & Admin)</b></summary>

#### Kalender Agenda Bulanan
![Kalender Bulanan](docs/screenshots/03-calendar/02-calendar-jadwal-bulanan.png)

#### Detail Informasi & Registrasi Event
![Detail Event](docs/screenshots/03-calendar/03-calendar-detail-event.png)

#### Autentikasi Peserta Event
![Autentikasi Peserta](docs/screenshots/03-calendar/04-calendar-auth-user.png)

#### Dashboard Peserta Event
![Dashboard Peserta](docs/screenshots/03-calendar/05-calendar-user-dashboard.png)

#### Tiket Digital & Barcode Presensi
![Tiket QR Code](docs/screenshots/03-calendar/06-calendar-user-ticket-qr.png)

#### Manajemen Event oleh Administrator
![Admin Manajemen Event](docs/screenshots/03-calendar/07-calendar-admin-management.png)

</details>

---

### 4. Modul Madiun Esport (M-GEN)
Portal komunitas game kompetitif, registrasi turnamen, kabar berita, dan manajemen tim atlet:
![Beranda Madiun Esport](docs/screenshots/04-esport/01-esport-beranda.png)

<details>
<summary><b>Tampilkan Tangkapan Layar Lengkap Modul Esport (Turnamen, Berita, & Portal Atlet)</b></summary>

#### Katalog Turnamen Game
![Daftar Turnamen](docs/screenshots/04-esport/02-esport-daftar-turnamen.png)

#### Detail Regulasi Turnamen & Pendaftaran Tim
![Detail Turnamen](docs/screenshots/04-esport/03-esport-detail-turnamen.png)

#### Kabar & Berita Esport Terkini
![Kabar Berita](docs/screenshots/04-esport/04-esport-kabar-berita.png)

#### Baca Artikel Berita
![Detail Berita](docs/screenshots/04-esport/05-esport-detail-berita.png)

#### Autentikasi Pengguna & Atlet Gamer
![Autentikasi Gamer](docs/screenshots/04-esport/06-esport-auth-user.png)

#### Dashboard Atlet & Tim Esport
![Dashboard Atlet](docs/screenshots/04-esport/07-esport-user-dashboard.png)

#### Status Pendaftaran Turnamen
![Status Pendaftaran](docs/screenshots/04-esport/08-esport-user-tournaments.png)

#### Manajemen Turnamen oleh Administrator
![Admin Manajemen Turnamen](docs/screenshots/04-esport/09-esport-admin-tournaments.png)

</details>

---

### 5. Halaman Penanganan Kesalahan (Custom Error Pages)
Antarmuka penanganan kesalahan sistem bertema resmi Diskominfo yang responsif dan animatif tanpa emoji:

<details>
<summary><b>Tampilkan Tangkapan Layar Halaman Error (404, 403, 500, 503)</b></summary>

#### Error 404: Halaman Tidak Ditemukan
![Error 404](docs/screenshots/05-errors/01-error-404.png)

#### Error 403: Akses Dibatasi
![Error 403](docs/screenshots/05-errors/02-error-403.png)

#### Error 500: Gangguan Server Backend
![Error 500](docs/screenshots/05-errors/03-error-500.png)

#### Error 503: Pemeliharaan Sistem (Maintenance Mode)
![Error 503](docs/screenshots/05-errors/04-error-503.png)

</details>

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
