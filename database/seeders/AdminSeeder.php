<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@kominfo.go.id',
                'username' => 'superadmin',
                'password' => Hash::make('SuperAdmin123!'),
                'role' => Admin::ROLE_SUPER_ADMIN,
            ],
            [
                'name' => 'Admin Buku Tamu',
                'email' => 'admin_bukutamu@kominfo.go.id',
                'username' => 'admin_bukutamu',
                'password' => Hash::make('BukuTamu123!'),
                'role' => Admin::ROLE_BUKU_TAMU,
            ],
            [
                'name' => 'Admin Esport',
                'email' => 'admin_esport@kominfo.go.id',
                'username' => 'admin_esport',
                'password' => Hash::make('Esport123!'),
                'role' => Admin::ROLE_ESPORT,
            ],
            [
                'name' => 'Admin Calendar',
                'email' => 'admin_calendar@kominfo.go.id',
                'username' => 'admin_calendar',
                'password' => Hash::make('Calendar123!'),
                'role' => Admin::ROLE_CALENDAR,
            ],
            // Legacy admin accounts for backward compatibility
            [
                'name' => 'Administrator',
                'email' => 'admin@bukutamu.com',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => Admin::ROLE_BUKU_TAMU,
            ],
            [
                'name' => 'Fauzi Nurd',
                'email' => 'fauzinurd@gmail.com',
                'username' => 'fauzinurd',
                'password' => Hash::make('12345678'),
                'role' => Admin::ROLE_SUPER_ADMIN,
            ],
        ];

        foreach ($admins as $adminData) {
            Admin::updateOrCreate(
                ['username' => $adminData['username']],
                $adminData
            );
        }
    }
}
