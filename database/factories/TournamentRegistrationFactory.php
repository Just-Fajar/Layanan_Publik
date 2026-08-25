<?php

namespace Database\Factories;

use App\Models\Esport\TournamentRegistration;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentRegistrationFactory extends Factory
{
    protected $model = TournamentRegistration::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tournament_id' => Tournament::factory(),
            'team_name' => fake()->words(2, true) . ' Team',
            'team_members' => [fake()->name(), fake()->name(), fake()->name()],
            'in_game_id' => fake()->userName(),
            'status' => 'pending',
            'rejection_reason' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'rejection_reason' => 'Incomplete requirements',
        ]);
    }
}
