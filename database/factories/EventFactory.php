<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 week', '+3 months');
        $endDate = (clone $startDate)->modify('+2 hours');

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => fake()->address(),
            'max_participants' => fake()->numberBetween(50, 500),
            'category' => fake()->randomElement(['workshop', 'seminar', 'training', 'conference', 'competition', 'exhibition', 'other']),
            'organizer' => fake()->company(),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'registration_deadline' => (clone $startDate)->modify('-3 days'),
            'status' => 'published',
            'image' => 'events/default-banner.jpg',
            'is_public' => true,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }

    public function upcoming(): static
    {
        $startDate = now()->addDays(fake()->numberBetween(1, 30));

        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->modify('+2 hours'),
        ]);
    }

    public function completed(): static
    {
        $startDate = now()->subDays(fake()->numberBetween(1, 30));

        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->modify('+2 hours'),
        ]);
    }
}
