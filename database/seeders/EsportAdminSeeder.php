<?php

namespace Database\Seeders;

use App\Models\Esport\EsportAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EsportAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EsportAdmin::create([
            'name' => 'E-sport Admin',
            'username' => 'esportadmin',
            'email' => 'esport@admin.com',
            'password' => Hash::make('password'),
        ]);
    }
}
