<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $phone_number
 */
class User extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
    ];

    protected $casts = [
    ];

    public function gameHistories(): HasMany
    {
        return $this->hasMany(GameHistory::class);
    }
}