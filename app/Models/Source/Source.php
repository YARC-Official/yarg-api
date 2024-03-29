<?php

namespace App\Models\Source;

use App\Enum\Source\GameTypeEnum;
use App\Enum\Source\SourceTypeEnum;
use Database\Factories\Source\SourceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

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

    protected $appends = ['icon_url'];

    public function getIconUrlAttribute(): string
    {
        return sprintf(
            "https://yarc-official.github.io/OpenSource/%s/icons/%s.png",
            $this->source_type->value,
            $this->icon
        );
    }

    protected static function newFactory(): SourceFactory
    {
        return SourceFactory::new();
    }
}
