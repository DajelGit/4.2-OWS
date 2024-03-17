<?php

use PHPUnit\Framework\TestCase;

include_once 'app\util.php';

final class GameStateTest extends TestCase
{

    // Een speler mag alleen passen als hij geen enkele steen kan spelen of
    // verplaatsen, dus als hij geen enkele andere geldige zet heeft.
    public function testPassConditions(): void
    {
        $board = [
            // white
            '0,0' => [['0', 'Q']],
            '0,-1' => [['0', 'A']],
            // black
            '0,1' => [['1', 'Q']],
            '1,-1' => [['1', 'G']],
            '1,-2' => [['1', 'G']],
            '-1,-1' => [['1', 'B']],
            '-1,0' => [['1', 'A']],
            '-1,-2' => [['1', 'A']],
        ];

        $player = 0;

        $ans = checkCanPass($board, $player);

        $this->assertEquals(false, $ans);
    }
}
