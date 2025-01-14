<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repository\LinkRepository;

class LinkController extends Controller
{
    public function __construct(
        private LinkRepository $linkRepository
    ) {
    }

    public function regenerate(string $uid)
    {
        $link = $this->linkRepository->findActiveAndNotExpiredByUidOrFail($uid);
        $user = $link->user();

        $newLink = $this->linkRepository->createByUserId($user->id);

        return view('success', [
            'access_url' => route('links.show', $newLink->uid),
            'expired_date' => $newLink->expired_date,
            'success_text' => 'Regeneration Successful!',
        ]);
    }

    public function show(string $uid)
    {
        $link = $this->linkRepository->findActiveAndNotExpiredByUidOrFail($uid);
        $user = $link->user();

        return view('link', [
            'user' => $user,
            'link' => $link,
        ]);
    }

    public function deactivate(string $uid)
    {
        $link = $this->linkRepository->findActiveAndNotExpiredByUidOrFail($uid);
        $this->linkRepository->deactivate($link);

        return view('success-deactivation', [
            'success_text' => 'Deactivation Successful!',
        ]);
    }
}
