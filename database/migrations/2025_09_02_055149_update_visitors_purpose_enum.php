<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah opsi baru 'persandian_keamanan_informasi' ke ENUM
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

    public function down(): void
    {
        // Kembalikan ke enum lama
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
};
