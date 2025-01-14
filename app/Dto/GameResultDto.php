<?php

declare(strict_types=1);

namespace App\Dto;

class GameResultDto
{
    public function __construct(
        private int   $number,
        private bool  $isWin,
        private float $winAmount
    ) {
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function isWin(): bool
    {
        return $this->isWin;
    }

    public function getWinAmount(): float
    {
        return $this->winAmount;
    }
}