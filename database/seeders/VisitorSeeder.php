<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Visitor::query()->delete();

        $visitors = [
            // Bidang Aplikasi Informatika
            [
                'name' => 'Budi Santoso, S.Kom.',
                'email' => 'budi.santoso@desa-krajan.id',
                'phone' => '081234567890',
                'asal_daerah' => 'Pemerintah Desa Krajan, Kec. Mejayan',
                'purpose' => 'aplikasi_informatika',
                'notes' => 'Konsultasi integrasi Sistem Informasi Desa (SID) dengan portal SPBE Kabupaten Madiun.',
                'photo_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->setTime(8, 30),
            ],
            [
                'name' => 'Maya Indah Permata',
                'email' => 'maya.indah@poltekmadiun.ac.id',
                'phone' => '082145678901',
                'asal_daerah' => 'Politeknik Negeri Madiun, Kota Madiun',
                'purpose' => 'aplikasi_informatika',
                'notes' => 'Pengajuan izin riset dan pengujian API layanan publik untuk tugas akhir mahasiswa.',
                'photo_path' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDay()->setTime(10, 15),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.k@telkom-madiun.co.id',
                'phone' => '085712345678',
                'asal_daerah' => 'PT Telkom Witel Madiun, Kec. Jiwan',
                'purpose' => 'aplikasi_informatika',
                'notes' => 'Koordinasi pemeliharaan bandwidth fiber optic pada data center Diskominfo.',
                'photo_path' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(4)->setTime(13, 0),
            ],

            // Bidang Persandian & Keamanan Informasi
            [
                'name' => 'Eko Prasetyo, S.STP',
                'email' => 'eko.prasetyo@dinkes.madiunkab.go.id',
                'phone' => '081398765432',
                'asal_daerah' => 'Dinas Kesehatan Kab. Madiun, Kec. Wungu',
                'purpose' => 'persandian_keamanan_informasi',
                'notes' => 'Pengurusan penerbitan Tanda Tangan Elektronik (TTE) tersertifikasi BSRE untuk pejabat fungsional.',
                'photo_path' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->setTime(9, 45),
            ],
            [
                'name' => 'Rina Lestari, S.Tr.Kom',
                'email' => 'rina.lestari@rsud-caruban.id',
                'phone' => '082233445566',
                'asal_daerah' => 'RSUD Caruban, Kec. Pilangkenceng',
                'purpose' => 'persandian_keamanan_informasi',
                'notes' => 'Asistensi audit keamanan sistem informasi manajemen rumah sakit (SIMRS) pasca insiden malware.',
                'photo_path' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(2)->setTime(11, 20),
            ],
            [
                'name' => 'Agus Susanto, M.T.',
                'email' => 'agus.susanto@cyber-secure.id',
                'phone' => '087811223344',
                'asal_daerah' => 'Konsultan Keamanan Siber, Kota Surabaya',
                'purpose' => 'persandian_keamanan_informasi',
                'notes' => 'Pemaparan hasil vulnerability assessment website OPD di lingkungan Pemkab Madiun.',
                'photo_path' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(6)->setTime(14, 0),
            ],

            // Bidang Informasi & Komunikasi Publik
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra.wijaya@radarmadiun.co.id',
                'phone' => '081255667788',
                'asal_daerah' => 'Harian Radar Madiun, Kota Madiun',
                'purpose' => 'informasi_komunikasi_publik',
                'notes' => 'Wawancara khusus program Smart City dan peliputan perhelatan M-GEN Esports Championship.',
                'photo_path' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->setTime(11, 0),
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti.rahma@kim-madiun.or.id',
                'phone' => '085699887766',
                'asal_daerah' => 'KIM Saradan, Kec. Saradan, Kab. Madiun',
                'purpose' => 'informasi_komunikasi_publik',
                'notes' => 'Konsultasi publikasi konten potensi UMKM lokal dan jadwal sosialisasi keterbukaan informasi.',
                'photo_path' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(3)->setTime(9, 15),
            ],
            [
                'name' => 'Dian Permata Sari',
                'email' => 'dian.permata@jurnalis-jatim.com',
                'phone' => '081344556677',
                'asal_daerah' => 'Ikatan Jurnalis TV, Kec. Geger, Kab. Madiun',
                'purpose' => 'informasi_komunikasi_publik',
                'notes' => 'Konfirmasi liputan siaran pers Hari Jadi Kabupaten Madiun dan agenda festival daerah.',
                'photo_path' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(8)->setTime(10, 45),
            ],

            // Bidang Statistik
            [
                'name' => 'Tri Wahyudi, S.Si.',
                'email' => 'tri.wahyudi@bps-madiunkab.go.id',
                'phone' => '082199881122',
                'asal_daerah' => 'BPS Kab. Madiun, Kec. Balerejo',
                'purpose' => 'statistik',
                'notes' => 'Koordinasi Evaluasi Penyelenggaraan Statistik Sektoral (EPSS) dan Satu Data Indonesia (SDI).',
                'photo_path' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->setTime(13, 30),
            ],
            [
                'name' => 'Nurul Hidayah, S.E.',
                'email' => 'nurul.hidayah@bappeda.madiunkab.go.id',
                'phone' => '081233221100',
                'asal_daerah' => 'Bappedalitbang Kab. Madiun, Kec. Dagangan',
                'purpose' => 'statistik',
                'notes' => 'Sinkronisasi data agregat indikator makro ekonomi daerah untuk penyusunan RPJMD.',
                'photo_path' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(5)->setTime(14, 15),
            ],
            [
                'name' => 'Bayu Setiawan',
                'email' => 'bayu.setiawan@unesa.ac.id',
                'phone' => '085877665544',
                'asal_daerah' => 'Universitas Negeri Surabaya (UNESA)',
                'purpose' => 'statistik',
                'notes' => 'Permohonan data statistik spasial dan demografi penduduk untuk penelitian tesis magister.',
                'photo_path' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(10)->setTime(10, 0),
            ],

            // Sekretariat
            [
                'name' => 'Bambang Pamungkas, S.Sos.',
                'email' => 'bambang.p@setda.madiunkab.go.id',
                'phone' => '081122334455',
                'asal_daerah' => 'Bagian Umum Setda, Kec. Kebonsari',
                'purpose' => 'sekretariat',
                'notes' => 'Pengantaran berkas nota dinas Sekretaris Daerah terkait agenda koordinasi Forkopimda.',
                'photo_path' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->setTime(9, 0),
            ],
            [
                'name' => 'Anisa Putri Maharani',
                'email' => 'anisa.putri@student.uns.ac.id',
                'phone' => '089612345678',
                'asal_daerah' => 'Universitas Sebelas Maret (UNS), Magetan',
                'purpose' => 'sekretariat',
                'notes' => 'Penyerahan surat pengantar magang Program Kuliah Kerja Nyata / Magang Berdampak Diskominfo.',
                'photo_path' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(2)->setTime(11, 45),
            ],
            [
                'name' => 'Ratna Sari Dewi',
                'email' => 'ratna.sari@bkpsdm.madiunkab.go.id',
                'phone' => '082344556677',
                'asal_daerah' => 'BKPSDM Kab. Madiun, Kec. Mejayan',
                'purpose' => 'sekretariat',
                'notes' => 'Koordinasi pengiriman berkas usulan kenaikan pangkat dan verifikasi data kepegawaian ASN.',
                'photo_path' => 'https://images.unsplash.com/photo-1573496799652-408c2ac9fe98?w=400&auto=format&fit=crop&q=80',
                'visit_date' => now()->subDays(7)->setTime(13, 10),
            ],
        ];

        foreach ($visitors as $data) {
            Visitor::create($data);
        }
    }
}
