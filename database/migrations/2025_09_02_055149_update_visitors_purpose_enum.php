<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah opsi baru 'persandian_keamanan_informasi' ke ENUM
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE visitors
                MODIFY COLUMN purpose ENUM(
                    'sekretariat',
                    'aplikasi_informatika',
                    'persandian_keamanan_informasi',
                    'informasi_komunikasi_publik',
                    'statistik'
                ) NOT NULL
            ");
        }
    }

    public function down(): void
    {
        // Kembalikan ke enum lama
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE visitors
                MODIFY COLUMN purpose ENUM(
                    'sekretariat',
                    'aplikasi_informatika',
                    'informasi_komunikasi_publik',
                    'statistik'
                ) NOT NULL
            ");
        }
    }
};
