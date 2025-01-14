<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $uid
 * @property \DateTime $expired_date
 * @property int $user_id
 * @property bool $is_active
 */
class Link extends Model
{
    protected $fillable = [
        'uid',
        'expired_date',
        'user_id',
        'is_active'
    ];

    protected $casts = [
        'expired_date' => 'datetime',
    ];

    public function user(): User
    {
        return $this->belongsTo(User::class)->firstOrFail();
    }
}