<?php

namespace App\Repository;

use App\Models\Link;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Str;

class LinkRepository
{
    public function __construct(
        private readonly Repository $config
    ) {
    }

    public function findActiveAndNotExpiredByUidOrFail(string $uid): Link
    {
        return Link::where('uid', $uid)
            ->where('is_active', true)
            ->where('token_expires_at', '>', now())
            ->firstOrFail();
    }

    public function createByUserId(int $userId): Link
    {
        $days = $this->config->get('app.days_to_expire_link');

        return Link::create([
            'uid' => Str::uuid(),
            'expired_date' => now()->addDays($days),
            'user_id' => $userId,
        ]);
    }

    public function deactivate(Link $link): bool
    {
        return $link->update(['is_active' => false]);
    }
}