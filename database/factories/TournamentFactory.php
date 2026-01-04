<?php

namespace Database\Factories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentFactory extends Factory
{
    protected $model = Tournament::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'game' => fake()->randomElement(['Mobile Legends', 'PUBG Mobile', 'Free Fire', 'Valorant', 'Call of Duty Mobile']),
            'description' => fake()->paragraph(),
            'tournament_type' => fake()->randomElement(['solo', 'team']),
            'max_participants' => fake()->numberBetween(16, 128),
            'prize_pool' => fake()->numberBetween(1000000, 50000000),
            'rules' => fake()->text(500),
            'registration_start' => now()->subDays(7),
            'registration_end' => now()->addDays(7),
            'tournament_start' => now()->addDays(14),
            'tournament_end' => now()->addDays(16),
            'location' => fake()->city(),
            'organizer' => fake()->company(),
            'contact_email' => fake()->email(),
            'contact_phone' => fake()->phoneNumber(),
            'status' => 'upcoming',
            'banner_image' => 'tournaments/default-banner.jpg',
        ];
    }
}
