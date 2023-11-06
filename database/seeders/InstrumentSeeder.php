<?php

namespace Database\Seeders;

use App\Models\Band\Instrument;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('yarg.instruments') as $instrument) {
            Instrument::query()
                ->updateOrCreate(['name' => $instrument['name']], $instrument);
        }
    }
}
