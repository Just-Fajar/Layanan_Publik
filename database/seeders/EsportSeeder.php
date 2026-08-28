<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class EsportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tournament::query()->delete();
        News::query()->delete();

        // 1. Tournaments
        $tournaments = [
            // Mobile Legends (Ongoing)
            [
                'title' => 'M-GEN Mobile Legends: Bang Bang Championship Season 2',
                'game' => 'Mobile Legends',
                'date' => now()->addDays(2),
                'location' => 'Main Stage Graha Praja Mukti Caruban & Live Streaming',
                'description' => "Turnamen resmi Mobile Legends: Bang Bang terbesar di Kabupaten Madiun.\n\nFormat Pertandingan:\n- Kualifikasi Online: Single Elimination Best of 3 (Bo3)\n- Semifinal & Grand Final: Offline Best of 5 (Bo5)\n- Hadiah: Total Rp 15.000.000 + Trophy Diskominfo + E-Certificate\n- Persyaratan: KTP / Kartu Pelajar Kabupaten Madiun (min. 3 pemain asal Madiun).",
                'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1200&auto=format&fit=crop&q=80',
                'status' => 'ongoing',
                'organizer_contact' => '081234567890 (Admin Panitia M-GEN)',
            ],

            // PUBG Mobile (Upcoming)
            [
                'title' => 'Madiun PUBG Mobile Squad Battle Royale League 2026',
                'game' => 'PUBG Mobile',
                'date' => now()->addDays(14),
                'location' => 'Online Qualifier & Offline Grand Final Caruban',
                'description' => "Kompetisi squad battle royale PUBG Mobile 16 tim terbaik se-Karesidenan Madiun.\n\nMap: Erangel, Miramar, Sanhok\nMode: TPP Squad (4 Player + 1 Cadangan)\nTotal Prize Pool: Rp 10.000.000\nSistem Poin: Standar Resmi PMGC 2026.",
                'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=1200&auto=format&fit=crop&q=80',
                'status' => 'upcoming',
                'organizer_contact' => '082198765432 (Sie Acara PUBG-M)',
            ],

            // Free Fire (Upcoming)
            [
                'title' => 'Free Fire Madiun Student Cup: Booyah Championship',
                'game' => 'Free Fire',
                'date' => now()->addDays(25),
                'location' => 'Hall Serbaguna Diskominfo Kab. Madiun',
                'description' => "Ajang pencarian bakat atlet muda Free Fire antar pelajar tingkat SMP/MTs & SMA/SMK/MA se-Kabupaten Madiun.\n\nMode: Battle Royale Squad\nHadiah: Beasiswa Pembinaan Atlet Muda + Uang Tunai Rp 7.500.000 + Piagam Resmi Pemkab Madiun.",
                'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1200&auto=format&fit=crop&q=80',
                'status' => 'upcoming',
                'organizer_contact' => '085712348899 (Helpdesk Student Cup)',
            ],

            // Valorant (Ongoing)
            [
                'title' => 'Valorant Regional Invitational Madiun 2026',
                'game' => 'Valorant',
                'date' => now()->addDays(5),
                'location' => 'Hybrid (Online Group Stage & LAN Final M-GEN Arena)',
                'description' => "Turnamen 5v5 tactical shooter PC paling bergengsi di Madiun Raya.\n\nServer: Singapore / Jakarta (Custom Game Mode Tournament)\nBracket: Double Elimination Bracket\nTotal Hadiah: Rp 8.000.000 + Gaming Gear Set untuk MVP Turnamen.",
                'image' => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?w=1200&auto=format&fit=crop&q=80',
                'status' => 'ongoing',
                'organizer_contact' => '087811229900 (Admin Valorant M-GEN)',
            ],

            // eFootball / EA FC (Finished)
            [
                'title' => 'eFootball & FC Mobile Madiun Community Cup Season 1',
                'game' => 'eFootball',
                'date' => now()->subDays(10),
                'location' => 'Aula Gedung Pemuda Caruban',
                'description' => "Turnamen 1v1 game simulasi sepak bola digital komunitas eFootball Madiun.\n\nSelamat kepada para pemenang turnamen Season 1 yang telah menunjukkan sportivitas dan strategi luar biasa.",
                'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=1200&auto=format&fit=crop&q=80',
                'status' => 'finished',
                'organizer_contact' => '081399887766 (Koordinator eFootball)',
            ],
        ];

        foreach ($tournaments as $tData) {
            Tournament::create($tData);
        }

        // 2. News
        $newsList = [
            // Tournament Info
            [
                'title' => 'Jadwal & Bagan Babak Playoff M-GEN Mobile Legends Championship Season 2',
                'category' => 'Tournament Info',
                'content' => "Babak Regular Season telah usai! Sebanyak 8 tim terbaik berhasil melaju ke babak Playoff M-GEN MLBB Championship Season 2.\n\nPertandingan babak perempat final akan disiarkan langsung melalui kanal YouTube resmi Diskominfo Kabupaten Madiun mulai Sabtu mendatang. Pastikan dukung tim jagoan Anda dan junjung tinggi sportivitas!",
                'image' => 'https://images.unsplash.com/photo-1560253023-3ec5d502959f?w=1200&auto=format&fit=crop&q=80',
            ],

            // Esport News
            [
                'title' => 'Bedah Strategi & Meta Gameplay Jawara Bertahan M-GEN di Season Ini',
                'category' => 'Esport News',
                'content' => "Tim Cyber Caruban Esports kembali menunjukkan performa impresif di fase grup berkat penguasaan makro gameplay dan rotasi tempo cepat.\n\nDalam sesi wawancara eksklusif, kapten tim membagikan tips pemilihan hero priority pick dan pentingnya komunikasi efektif antar pemain saat teamfight krusial.",
                'image' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=1200&auto=format&fit=crop&q=80',
            ],

            // Pengumuman
            [
                'title' => 'Diskominfo Madiun Buka Program Bootcamp & Pembinaan Wasit Esports Berlisensi',
                'category' => 'Pengumuman',
                'content' => "Untuk meningkatkan kualitas penyelenggaraan turnamen game kompetitif di Kabupaten Madiun, Diskominfo bersama Pengurus E-Sports Indonesia (ESI) membuka pendaftaran pelatihan Caster dan Wasit (Referee) berlisensi daerah.\n\nPendaftaran dibuka gratis bagi seluruh pemuda Kabupaten Madiun yang berminat mengembangkan karir di industri kreatif esports.",
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&auto=format&fit=crop&q=80',
            ],

            // Tournament Info (Recap)
            [
                'title' => 'Rekap Grand Final eFootball Cup: Tim Garuda Jiwan Sabet Juara 1',
                'category' => 'Tournament Info',
                'content' => "Perhelatan eFootball Community Cup Season 1 resmi berakhir dengan kemenangan dramatis tim perwakilan Kecamatan Jiwan dengan skor 3-2 di partai puncak.\n\nDiskominfo mengapresiasi antusiasme ratusan penonton dan peserta yang hadir memadati venue pertandingan.",
                'image' => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=1200&auto=format&fit=crop&q=80',
            ],
        ];

        foreach ($newsList as $nData) {
            News::create($nData);
        }
    }
}
