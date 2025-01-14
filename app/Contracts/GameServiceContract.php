<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Dto\GameResultDto;

interface GameServiceContract
{
    public function play(): GameResultDto;
}