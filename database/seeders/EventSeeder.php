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
        $events = [
            [
                'title' => 'Workshop Digitalisasi Layanan Publik',
                'description' => 'Workshop mengenai transformasi digital dalam pelayanan publik dan implementasi sistem informasi terintegrasi untuk meningkatkan efisiensi layanan.',
                'start_date' => now()->addDays(15)->setTime(9, 0),
                'end_date' => now()->addDays(15)->setTime(16, 0),
                'location' => 'Aula Diskominfo Kota Madiun',
                'category' => 'workshop',
                'organizer' => 'Dinas Komunikasi dan Informatika',
                'contact_email' => 'workshop@diskominfo-madiun.go.id',
                'contact_phone' => '(0351) 464500',
                'status' => 'published',
                'max_participants' => 50,
                'registration_deadline' => now()->addDays(10),
                'is_public' => true,
            ],
            [
                'title' => 'Seminar Keamanan Siber dan Perlindungan Data',
                'description' => 'Seminar nasional tentang pentingnya keamanan siber, perlindungan data pribadi, dan strategi mitigasi risiko keamanan informasi di era digital.',
                'start_date' => now()->addDays(30)->setTime(8, 0),
                'end_date' => now()->addDays(30)->setTime(17, 0),
                'location' => 'Hotel Merdeka Madiun',
                'category' => 'seminar',
                'organizer' => 'Bidang Persandian dan Keamanan Informasi',
                'contact_email' => 'seminar@diskominfo-madiun.go.id',
                'contact_phone' => '(0351) 464501',
                'status' => 'published',
                'max_participants' => 100,
                'registration_deadline' => now()->addDays(25),
                'is_public' => true,
            ],
            [
                'title' => 'Pelatihan Aplikasi Smart City',
                'description' => 'Pelatihan penggunaan aplikasi smart city untuk ASN dan masyarakat dalam rangka meningkatkan literasi digital dan pemanfaatan teknologi informasi.',
                'start_date' => now()->addDays(20)->setTime(13, 0),
                'end_date' => now()->addDays(20)->setTime(16, 0),
                'location' => 'Lab Komputer Diskominfo',
                'category' => 'training',
                'organizer' => 'Bidang Aplikasi Informatika',
                'contact_email' => 'training@diskominfo-madiun.go.id',
                'contact_phone' => '(0351) 464502',
                'status' => 'published',
                'max_participants' => 30,
                'registration_deadline' => now()->addDays(15),
                'is_public' => true,
            ],
            [
                'title' => 'Konferensi E-Government Indonesia 2025',
                'description' => 'Konferensi nasional yang membahas perkembangan dan implementasi e-government di Indonesia, best practices, serta tantangan dalam transformasi digital pemerintahan.',
                'start_date' => now()->addDays(60)->setTime(8, 0),
                'end_date' => now()->addDays(61)->setTime(17, 0),
                'location' => 'Gedung Convention Center Madiun',
                'category' => 'conference',
                'organizer' => 'Kementerian Komunikasi dan Informatika',
                'contact_email' => 'conference@kominfo.go.id',
                'contact_phone' => '021-3509000',
                'status' => 'published',
                'max_participants' => 500,
                'registration_deadline' => now()->addDays(50),
                'is_public' => true,
            ],
            [
                'title' => 'Lomba Inovasi Aplikasi Pelayanan Publik',
                'description' => 'Kompetisi pengembangan aplikasi inovatif untuk meningkatkan kualitas pelayanan publik. Terbuka untuk mahasiswa dan umum dengan hadiah total 50 juta rupiah.',
                'start_date' => now()->addDays(45)->setTime(9, 0),
                'end_date' => now()->addDays(45)->setTime(18, 0),
                'location' => 'Aula Pemkot Madiun',
                'category' => 'competition',
                'organizer' => 'Dinas Komunikasi dan Informatika',
                'contact_email' => 'lomba@diskominfo-madiun.go.id',
                'contact_phone' => '(0351) 464500',
                'status' => 'published',
                'max_participants' => 20,
                'registration_deadline' => now()->addDays(35),
                'is_public' => true,
            ],
            [
                'title' => 'Pameran Teknologi Informasi Madiun Expo 2025',
                'description' => 'Pameran tahunan yang menampilkan berbagai produk teknologi informasi, startup lokal, dan inovasi digital dari berbagai sektor industri.',
                'start_date' => now()->addDays(90)->setTime(10, 0),
                'end_date' => now()->addDays(92)->setTime(20, 0),
                'location' => 'Madiun Convention Center',
                'category' => 'exhibition',
                'organizer' => 'Dinas Perdagangan dan Perindustrian',
                'contact_email' => 'expo@madiunkota.go.id',
                'contact_phone' => '(0351) 462000',
                'status' => 'published',
                'max_participants' => null, // Unlimited
                'registration_deadline' => null,
                'is_public' => true,
            ],
            [
                'title' => 'Sosialisasi Sistem Informasi Buku Tamu Digital',
                'description' => 'Sosialisasi dan pelatihan penggunaan sistem buku tamu digital untuk instansi pemerintah daerah.',
                'start_date' => now()->addDays(7)->setTime(14, 0),
                'end_date' => now()->addDays(7)->setTime(16, 0),
                'location' => 'Ruang Rapat Diskominfo',
                'category' => 'training',
                'organizer' => 'Diskominfo Kota Madiun',
                'contact_email' => 'sosialisasi@diskominfo-madiun.go.id',
                'contact_phone' => '(0351) 464500',
                'status' => 'published',
                'max_participants' => 25,
                'registration_deadline' => now()->addDays(5),
                'is_public' => false, // Internal only
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
