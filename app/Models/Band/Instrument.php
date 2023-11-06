<?php

namespace App\Models\Band;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrument extends Model
{
    use HasFactory;

    protected $table = 'instruments';

    protected $fillable = [
        'name'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
