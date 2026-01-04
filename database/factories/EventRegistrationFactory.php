<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\CalendarEvent\EventRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventRegistrationFactory extends Factory
{
    protected $model = EventRegistration::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'qr_code' => $this->generateQrCodeData(),
            'attendance_code' => strtoupper(Str::random(6)),
            'status' => 'registered',
            'attended_at' => null,
            'attended_by' => null,
            'attendance_notes' => null,
        ];
    }

    public function registered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'registered',
        ]);
    }

    public function attended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'attended',
            'attended_at' => now(),
            'attended_by' => 1,
            'attendance_notes' => 'Scanned QR code at entrance',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }

    protected function generateQrCodeData(): string
    {
        return json_encode([
            'registration_id' => fake()->uuid(),
            'user_id' => fake()->numberBetween(1, 1000),
            'event_id' => fake()->numberBetween(1, 100),
            'timestamp' => now()->timestamp,
        ]);
    }
}
