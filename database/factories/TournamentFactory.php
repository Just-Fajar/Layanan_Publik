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
            'title' => fake()->sentence(3),
            'game' => fake()->randomElement(['Mobile Legends', 'PUBG Mobile', 'Free Fire', 'Valorant', 'Dota 2', 'CS:GO']),
            'date' => fake()->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d'),
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'image' => 'tournaments/default-banner.jpg',
            'status' => 'upcoming',
            'organizer_contact' => fake()->phoneNumber(),
        ];
    }

    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ongoing',
            'date' => now()->format('Y-m-d'),
        ]);
    }

    public function finished(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'finished',
            'date' => now()->subDays(fake()->numberBetween(1, 30))->format('Y-m-d'),
        ]);
    }
}
