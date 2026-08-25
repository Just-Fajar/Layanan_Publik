<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => Admin::ROLE_BUKU_TAMU,
            'remember_token' => Str::random(10),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Admin::ROLE_SUPER_ADMIN,
        ]);
    }

    public function bukuTamu(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Admin::ROLE_BUKU_TAMU,
        ]);
    }

    public function esport(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Admin::ROLE_ESPORT,
        ]);
    }

    public function calendar(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Admin::ROLE_CALENDAR,
        ]);
    }
}
