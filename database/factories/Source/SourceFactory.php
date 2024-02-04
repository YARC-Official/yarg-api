<?php

namespace Database\Factories\Source;

use App\Enum\Source\GameTypeEnum;
use App\Enum\Source\SourceTypeEnum;
use App\Models\Source\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{

    protected $model = Source::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Guitar Hero', 'Rock Band', 'Custom Charter']),
            'tags' => $this->faker->randomElement(['rb123', 'ghxd', 'daniel123']),
            'game_type' => $this->faker->randomElement(GameTypeEnum::cases()),
            'source_type' => $this->faker->randomElement(SourceTypeEnum::cases()),
            'icon' => $this->faker->word(),
        ];
    }
}
