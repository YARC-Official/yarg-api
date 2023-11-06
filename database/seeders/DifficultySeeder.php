<?php

namespace Database\Seeders;

use App\Models\Band\Difficulty;
use Illuminate\Database\Seeder;

class DifficultySeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('yarg.difficulties') as $difficulty) {
            Difficulty::query()
                ->updateOrCreate(['name' => $difficulty['name']], $difficulty);
        }
    }
}
