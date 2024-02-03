<?php

namespace Tests\Feature\Console\Commands;

use App\Enum\Source\GameTypeEnum;
use App\Enum\Source\SourceTypeEnum;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ImportSongSourcesCommandTest extends TestCase
{
    use DatabaseMigrations;


    public function test_can_import_from_github()
    {
        // Act
        $this->artisan('yarg:import-sources');

        // Assert
        $expectations = [
            [
                'name' => 'YARG',
                'game_type' => GameTypeEnum::Game,
                'source_type' => SourceTypeEnum::Base
            ]
        ];

        foreach ($expectations as $expectation) {
            $this->assertDatabaseHas('song_sources', $expectation);
        }
    }
}
