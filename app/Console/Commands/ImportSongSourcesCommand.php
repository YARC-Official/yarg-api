<?php

namespace App\Console\Commands;

use App\Enum\Source\GameTypeEnum;
use App\Enum\Source\SourceTypeEnum;
use App\Models\Source\Source;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportSongSourcesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yarg:import-sources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the latest sources from "yarc/OpenSource" repo.';

    /**
     * Constant URL to sources.
     */

    protected string $sourceUrl = 'https://raw.githubusercontent.com/YARC-Official/OpenSource/master/%s/index.json';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting...');

        collect(SourceTypeEnum::cases())
            ->map(fn (SourceTypeEnum $enum) => Http::get(sprintf($this->sourceUrl, $enum->value))->json())
            ->each(function (array $decodedSources) {
                $sourceEnum = SourceTypeEnum::from($decodedSources['type']);

                collect($decodedSources['sources'])
                    ->each(function ($rawSource) use ($sourceEnum) {
                        $name = $rawSource['names']['en-US'];
                        $this->info(sprintf('Adding from %s: %s', $sourceEnum->value, $name));
                        Source::query()->create([
                            'name' => $name,
                            'tags' => json_encode($rawSource['ids']),
                            'game_type' => GameTypeEnum::from($rawSource['type']),
                            'icon' => $rawSource['icon'],
                            'source_type' => $sourceEnum
                        ]);
                    });
            });

        return self::SUCCESS;
    }
}
