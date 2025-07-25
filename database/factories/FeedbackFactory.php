<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama'  => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'pesan' => $this->faker->sentence(12),
        ];
    }
}
