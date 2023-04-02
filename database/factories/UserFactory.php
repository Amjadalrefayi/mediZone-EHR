<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use App\Enums\MaritalStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_number' => $this->faker->uuid,
            'name' => fake()->name(),
            'family' => $this->faker->name,
            'prefix' => $this->faker->name,
            'suffix' => $this->faker->name,
            'marital_status' => MaritalStatus::getRandomValue(),
            'gender' => GenderEnum::getRandomValue(),
            'type' => UserType::getRandomValue(),
            'photo' => 'image.png',
            'deceased' => false,
            'birth_date' => $this->faker->dateTime,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
