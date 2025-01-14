<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\GameServiceContract;
use App\Models\GameHistory;
use App\Repository\LinkRepository;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
        private readonly GameServiceContract $gameService,
    ) {
    }

    public function getHistory(string $linkUid): JsonResponse
    {
        $link = $this->linkRepository->findActiveAndNotExpiredByUidOrFail($linkUid);

        $history = $link->user()->gameHistories()
            ->latest()
            ->take(3)
            ->get();

        return response()->json($history);
    }

    public function playGame(string $linkUid): JsonResponse
    {
        $link = $this->linkRepository->findActiveAndNotExpiredByUidOrFail($linkUid);
        $gameDto = $this->gameService->play();

        GameHistory::create([
            'user_id' => $link->user()->id,
            'random_number' => $gameDto->getNumber(),
            'is_win' => $gameDto->isWin(),
            'win_amount' => $gameDto->getWinAmount()
        ]);

        return response()->json([
            'random_number' => $gameDto->getNumber(),
            'result' => $gameDto->isWin() ? 'Win' : 'Lose',
            'win_amount' => $gameDto->getWinAmount()
        ]);
    }
}
