<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\User;
use App\Models\UserLanguages;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserLanguagesFactory extends Factory
{
    protected $model = UserLanguages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'language_id' => Language::factory()->create()->id,
            'preferred' => $this->faker->boolean,
        ];
    }
}
