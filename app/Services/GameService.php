<?php

namespace App\Services;

use App\Contracts\GameServiceContract;
use App\Dto\GameResultDto;

class GameService implements GameServiceContract
{
    public function play(): GameResultDto
    {
        $randomNumber = random_int(1, 1000);
        $isWin = $randomNumber % 2 === 0;
        $winAmount = $this->calculateWinAmount($randomNumber, $isWin);

        return new GameResultDto(
            number: $randomNumber,
            isWin: $isWin,
            winAmount: $winAmount
        );
    }

    public function calculateWinAmount(int $number, bool $isWin): float
    {
        if (!$isWin) {
            return 0;
        }

        $percentage = match(true) {
            $number > 900 => 0.7,
            $number > 600 => 0.5,
            $number > 300 => 0.3,
            default => 0.1,
        };

        return round($number * $percentage, 2);
    }
}