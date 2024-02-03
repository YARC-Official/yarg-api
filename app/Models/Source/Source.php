<?php

namespace App\Models\Source;

use App\Enum\Source\GameTypeEnum;
use App\Enum\Source\SourceTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'song_sources';

    protected $fillable = [
        'name',
        'tags',
        'game_type',
        'source_type',
        'icon'
    ];

    protected $casts = [
        'game_type' => GameTypeEnum::class,
        'source_type' => SourceTypeEnum::class,
        'tags' => 'json'
    ];
}
