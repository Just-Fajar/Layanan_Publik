<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::query()->delete();

        $events = [
            // 1. Workshop (This Month / Upcoming)
            [
                'title' => 'Workshop Transformasi Digital & Akselerasi SPBE Desa 2026',
                'description' => "Workshop intensif bagi operator desa dan perangkat daerah dalam percepatan Sistem Pemerintahan Berbasis Elektronik (SPBE).\n\nAgenda meliputi:\n- Standarisasi Sistem Informasi Desa (SID) terintegrasi.\n- Penerapan portal satu data pelayanan kependudukan desa.\n- Pengelolaan keamanan data dan akun digital aparatur desa.",
                'start_date' => now()->addDays(5)->setTime(8, 30),
                'end_date' => now()->addDays(5)->setTime(16, 0),
                'location' => 'Aula Graha Praja Mukti, Puspem Kab. Madiun, Mejayan',
                'category' => 'workshop',
                'organizer' => 'Bidang Aplikasi Informatika Diskominfo',
                'contact_email' => 'spbe@madiunkab.go.id',
                'contact_phone' => '(0351) 462927',
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_PUBLISHED,
                'max_participants' => 120,
                'registration_deadline' => now()->addDays(3),
                'is_public' => true,
            ],

            // 2. Seminar (Next Month / Upcoming)
            [
                'title' => 'Seminar Nasional Kesiapan Keamanan Siber & Perlindungan Data Pribadi',
                'description' => "Seminar strategis bersama narasumber BSSN dan akademisi pakar cyber security.\n\nMembahas regulasi Undang-Undang Perlindungan Data Pribadi (UU PDP), mitigasi ancaman ransomware, serta tata kelola Information Security Management System (ISMS) di instansi pemerintahan.",
                'start_date' => now()->addDays(20)->setTime(9, 0),
                'end_date' => now()->addDays(20)->setTime(15, 30),
                'location' => 'Ballroom Hotel Merdeka, Kota Madiun',
                'category' => 'seminar',
                'organizer' => 'Bidang Persandian & Keamanan Informasi Diskominfo',
                'contact_email' => 'persandian@madiunkab.go.id',
                'contact_phone' => '(0351) 462928',
                'image' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_PUBLISHED,
                'max_participants' => 200,
                'registration_deadline' => now()->addDays(17),
                'is_public' => true,
            ],

            // 3. Training / Pelatihan (This Month / Upcoming)
            [
                'title' => 'Bimtek Literasi Digital & Pengelolaan Website Resmi OPD Kabupaten Madiun',
                'description' => 'Bimbingan teknis pembuatan konten informatif, optimasi SEO layanan publik, serta kepatuhan aksesibilitas website bagi admin pengelola web dinas dan kecamatan se-Kabupaten Madiun.',
                'start_date' => now()->addDays(12)->setTime(8, 0),
                'end_date' => now()->addDays(13)->setTime(16, 0),
                'location' => 'Laboratorium Komputer Terpadu Diskominfo Madiun',
                'category' => 'training',
                'organizer' => 'Bidang Informasi & Komunikasi Publik',
                'contact_email' => 'ikp@madiunkab.go.id',
                'contact_phone' => '(0351) 462927',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_PUBLISHED,
                'max_participants' => 60,
                'registration_deadline' => now()->addDays(9),
                'is_public' => true,
            ],

            // 4. Conference / Konferensi (2 Months Ahead)
            [
                'title' => 'Madiun Smart Regency Summit & E-Government Expo 2026',
                'description' => 'Konferensi tahunan tingkat regional Jawa Timur yang mempertemukan pemerintah daerah, akademisi, dan praktisi industri teknologi untuk merumuskan roadmap Smart Living, Smart Governance, dan Smart Economy berbasis kearifan lokal.',
                'start_date' => now()->addMonths(2)->setTime(8, 30),
                'end_date' => now()->addMonths(2)->addDays(1)->setTime(17, 0),
                'location' => 'Convention Center Puspem Caruban, Kab. Madiun',
                'category' => 'conference',
                'organizer' => 'Diskominfo & Bappeda Litbang Kab. Madiun',
                'contact_email' => 'summit@madiunkab.go.id',
                'contact_phone' => '(0351) 464000',
                'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_PUBLISHED,
                'max_participants' => 500,
                'registration_deadline' => now()->addMonths(2)->subDays(7),
                'is_public' => true,
            ],

            // 5. Competition / Kompetisi (Next Month)
            [
                'title' => 'Madiun Hackathon 2026: Inovasi Solusi Digital Pelayanan Masyarakat',
                'description' => 'Ajang kompetisi pembuatan prototipe aplikasi mobile/web bagi pelajar, mahasiswa, dan developer umum. Total hadiah 40 Juta Rupiah serta kesempatan implementasi proyek percontohan di Kabupaten Madiun.',
                'start_date' => now()->addDays(35)->setTime(9, 0),
                'end_date' => now()->addDays(36)->setTime(18, 0),
                'location' => 'Gedung Pertemuan Graha Praja Mukti Caruban',
                'category' => 'competition',
                'organizer' => 'Komite Inovasi Digital Madiun & Diskominfo',
                'contact_email' => 'hackathon@madiunkab.go.id',
                'contact_phone' => '081234567890',
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_PUBLISHED,
                'max_participants' => 40,
                'registration_deadline' => now()->addDays(28),
                'is_public' => true,
            ],

            // 6. Exhibition / Pameran (Next Month)
            [
                'title' => 'Madiun Creative Technology & UMKM Digital Expo 2026',
                'description' => 'Pameran produk teknologi informasi, startup daerah, booth layanan publik interaktif, serta display produk unggulan UMKM binaan digital Kabupaten Madiun.',
                'start_date' => now()->addDays(40)->setTime(10, 0),
                'end_date' => now()->addDays(42)->setTime(21, 0),
                'location' => 'Alun-alun Reksogati Caruban, Kab. Madiun',
                'category' => 'exhibition',
                'organizer' => 'Diskominfo & Dinas Perdagangan Kab. Madiun',
                'contact_email' => 'expo@madiunkab.go.id',
                'contact_phone' => '(0351) 462927',
                'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_PUBLISHED,
                'max_participants' => 1000,
                'registration_deadline' => now()->addDays(38),
                'is_public' => true,
            ],

            // 7. Other / Lainnya (Cultural Festival / Completed - Past Month)
            [
                'title' => 'Peringatan Hari Jadi Kabupaten Madiun: Pagelaran Seni Budaya & Wayang Kulit',
                'description' => 'Pagelaran wayang kulit semalam suntuk dan festival tari seni pesilat dalam rangka memeriahkan rangkaian Hari Jadi Kabupaten Madiun Kampung Pesilat Indonesia.',
                'start_date' => now()->subDays(20)->setTime(19, 30),
                'end_date' => now()->subDays(19)->setTime(4, 0),
                'location' => 'Panggung Terbuka Pendopo Muda Karya, Kota Madiun',
                'category' => 'other',
                'organizer' => 'Dinas Pendidikan & Kebudayaan Kab. Madiun',
                'contact_email' => 'budaya@madiunkab.go.id',
                'contact_phone' => '(0351) 462500',
                'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_COMPLETED,
                'max_participants' => 1500,
                'registration_deadline' => now()->subDays(22),
                'is_public' => true,
            ],

            // 8. Seminar (Completed - Past Month)
            [
                'title' => 'Sosialisasi Keterbukaan Informasi Publik & Penguatan PPID Desa',
                'description' => 'Evaluasi dan sosialisasi standar layanan informasi publik desa sesuai Perki No. 1 Tahun 2018 tentang Standar Layanan Informasi Publik Desa.',
                'start_date' => now()->subDays(15)->setTime(9, 0),
                'end_date' => now()->subDays(15)->setTime(14, 0),
                'location' => 'Ruang Command Center Diskominfo Madiun',
                'category' => 'seminar',
                'organizer' => 'Bidang IKP Diskominfo Madiun',
                'contact_email' => 'ppid@madiunkab.go.id',
                'contact_phone' => '(0351) 462927',
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200&auto=format&fit=crop&q=80',
                'status' => Event::STATUS_COMPLETED,
                'max_participants' => 80,
                'registration_deadline' => now()->subDays(18),
                'is_public' => true,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}
