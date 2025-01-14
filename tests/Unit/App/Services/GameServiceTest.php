<?php

namespace Tests\Unit\App\Services;

use App\Services\GameService;
use App\Dto\GameResultDto;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    public function testPlay(): void
    {
        $gameService = new GameService();
        $gameResult = $gameService->play();

        $this->assertInstanceOf(GameResultDto::class, $gameResult);

        if ($gameResult->isWin()) {
            $this->assertGreaterThan(0, $gameResult->getWinAmount());
        } else {
            $this->assertEquals(0, $gameResult->getWinAmount());
        }
    }

    /**
     * @return array<string,array<int,string>>
     */
    public static function winAmountDataProvider(): array
    {
        return [
            'win' => [1, true, 0.1],
            'win_300' => [300, true, 30],
            'win_301' => [301, true, 90.3],
            'win_600' => [600, true, 180],
            'win_601' => [601, true, 300.5],
            'win_900' => [900, true, 450],
            'win_901' => [901, true, 630.7],
            'lose' => [1, false, 0],
        ];
    }

    #[DataProvider('winAmountDataProvider')] public function testCalculations(
        int $number,
        bool $isWin,
        float $expectedWinAmount
    ): void
    {
        $gameService = new GameService();
        $result = $gameService->calculateWinAmount($number, $isWin);
        $this->assertEquals($expectedWinAmount, $result);
    }
}
