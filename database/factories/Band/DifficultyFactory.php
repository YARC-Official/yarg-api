<?php

namespace Database\Factories\Band;

use App\Models\Band\Difficulty;
use Illuminate\Database\Eloquent\Factories\Factory;

class DifficultyFactory extends Factory
{

    protected $model = Difficulty::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['easy', 'medium', 'hard', 'expert']),
            'slug' => $this->faker->randomElement(['easy', 'medium', 'hard', 'expert']),
        ];
    }
}
