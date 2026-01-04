<?php

namespace Database\Seeders;

use App\Models\CalendarEvent\CalendarAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CalendarAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CalendarAdmin::create([
            'name' => 'Calendar Admin',
            'username' => 'calendaradmin',
            'email' => 'calendar@admin.com',
            'password' => Hash::make('password'),
        ]);
    }
}
