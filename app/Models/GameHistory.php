<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $random_number
 * @property bool $is_win
 * @property int $win_amount
 */
class GameHistory extends Model
{
    protected $fillable = [
        'user_id',
        'random_number',
        'is_win',
        'win_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
