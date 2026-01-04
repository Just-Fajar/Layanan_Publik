<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $date = fake()->dateTimeBetween('+1 week', '+3 months');

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'date' => $date->format('Y-m-d'),
            'time' => fake()->time('H:i:s'),
            'location' => fake()->address(),
            'max_participants' => fake()->numberBetween(50, 500),
            'category' => fake()->randomElement(['Workshop', 'Seminar', 'Conference', 'Webinar', 'Training', 'Meeting']),
            'organizer' => fake()->company(),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'registration_deadline' => $date->modify('-3 days')->format('Y-m-d'),
            'status' => 'upcoming',
            'banner_image' => 'events/default-banner.jpg',
        ];
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'upcoming',
            'date' => now()->addDays(fake()->numberBetween(1, 30))->format('Y-m-d'),
        ]);
    }

    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ongoing',
            'date' => now()->format('Y-m-d'),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'date' => now()->subDays(fake()->numberBetween(1, 30))->format('Y-m-d'),
        ]);
    }
}
