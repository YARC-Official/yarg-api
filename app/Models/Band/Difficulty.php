<?php

namespace App\Models\Band;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Difficulty extends Model
{
    use HasFactory;

    protected $table = 'gameplay_difficulties';

    protected $fillable = [
        'name',
        'slug'
    ];

    public function players(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
