<?php

namespace Database\Factories\Band;

use App\Models\Band\Instrument;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstrumentFactory extends Factory
{
    protected $model = Instrument::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['guitar', 'bass', 'drum'])
        ];
    }
}
