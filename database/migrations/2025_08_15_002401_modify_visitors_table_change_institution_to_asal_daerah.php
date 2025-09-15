<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Tambah kolom asal_daerah jika belum ada
        if (!Schema::hasColumn('visitors', 'asal_daerah')) {
            Schema::table('visitors', function (Blueprint $table) {
                $table->string('asal_daerah')->nullable();
            });
        }

        // 2) Jika masih ada kolom institution: salin nilai ke asal_daerah lalu hapus kolomnya
        if (Schema::hasColumn('visitors', 'institution')) {
            // salin: asal_daerah = institution (hanya yg null)
            DB::table('visitors')
                ->whereNull('asal_daerah')
                ->update(['asal_daerah' => DB::raw('institution')]);

            Schema::table('visitors', function (Blueprint $table) {
                $table->dropColumn('institution');
            });
        }

        // 3) Atur kolom purpose sesuai DB driver
        $allowed = [
            'sekretariat',
            'aplikasi_informatika',
            'persandian_keamanan_informasi',
            'informasi_komunikasi_publik',
            'statistik',
        ];

        if (DB::getDriverName() === 'pgsql') {
            // --- PostgreSQL: gunakan CHECK CONSTRAINT ---

            $inList = "'" . implode("','", $allowed) . "'";

            // Pastikan semua nilai existing valid agar tidak gagal saat tambah constraint
            DB::statement("
                UPDATE visitors
                SET purpose = '{$allowed[0]}'
                WHERE purpose IS NULL OR purpose NOT IN ($inList)
            ");

            // Pastikan tipe kolom adalah VARCHAR (hindari ENUM/tipe lama)
            DB::statement("ALTER TABLE visitors ALTER COLUMN purpose TYPE VARCHAR(64)");

            // Hapus constraint lama jika ada (agar migration idempotent)
            DB::statement("ALTER TABLE visitors DROP CONSTRAINT IF EXISTS purpose_allowed_values");

            // Tambah constraint baru
            DB::statement("ALTER TABLE visitors ADD CONSTRAINT purpose_allowed_values CHECK (purpose IN ($inList))");

            // Jadikan NOT NULL
            DB::statement("ALTER TABLE visitors ALTER COLUMN purpose SET NOT NULL");
        } else {
            // --- MySQL/MariaDB: gunakan ENUM seperti sebelumnya ---
            $enumList = "'" . implode("','", $allowed) . "'";
            DB::statement("
                ALTER TABLE visitors
                MODIFY COLUMN purpose
                ENUM($enumList)
                NOT NULL
            ");
        }
    }

    public function down(): void
    {
        // Revert constraints/tipe purpose
        if (DB::getDriverName() === 'pgsql') {
            // Lepas CHECK constraint di PostgreSQL
            DB::statement("ALTER TABLE visitors DROP CONSTRAINT IF EXISTS purpose_allowed_values");
            // Biarkan purpose tetap VARCHAR(64) NOT NULL (aman untuk rollback dasar)
        } else {
            // MySQL: kembalikan ke VARCHAR dulu agar aman
            DB::statement("ALTER TABLE visitors MODIFY COLUMN purpose VARCHAR(64) NOT NULL");

            // (Opsional) kalau mau balik ke enum lama, isi daftarnya di sini:
            // $prev = ['aplikasi','persandian','statistik'];
            // $enumPrev = "'" . implode("','", $prev) . "'";
            // DB::statement("ALTER TABLE visitors MODIFY COLUMN purpose ENUM($enumPrev) NOT NULL");
        }

        // Pulihkan kolom institution bila perlu
        if (!Schema::hasColumn('visitors', 'institution')) {
            Schema::table('visitors', function (Blueprint $table) {
                $table->string('institution')->nullable();
            });
        }

        if (Schema::hasColumn('visitors', 'asal_daerah')) {
            // salin balik: institution = asal_daerah (hanya yg null)
            DB::table('visitors')
                ->whereNull('institution')
                ->update(['institution' => DB::raw('asal_daerah')]);

            Schema::table('visitors', function (Blueprint $table) {
                $table->dropColumn('asal_daerah');
            });
        }
    }
};
