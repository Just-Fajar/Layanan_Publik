<?php

namespace Database\Factories;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    protected $model = Visitor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $purposes = ['sekretariat', 'aplikasi_informatika', 'persandian_keamanan_informasi', 'informasi_komunikasi_publik', 'statistik'];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'asal_daerah' => fake()->city(),
            'purpose' => fake()->randomElement($purposes),
            'notes' => fake()->sentence(),
            'photo_path' => 'photos/' . date('Y/m/') . 'visitor_' . uniqid() . '.jpg',
            'latitude' => fake()->latitude(-7.7, -7.5),
            'longitude' => fake()->longitude(111.4, 111.6),
            'visit_date' => now(),
        ];
    }
}
