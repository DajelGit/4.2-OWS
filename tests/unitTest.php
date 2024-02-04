<?php

use PHPUnit\Framework\TestCase;

include_once 'app\util.php';

final class UnitTest extends TestCase
{

    //Queen bug being bug where queen can't move to 0,1 from 0,0
    public function testForQueenBug(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '1,0' => [['1', 'Q']]
        ];

        $hand = [
            ["Q" => 0, "B" => 2, "S" => 2, "A" => 3, "G" => 3],
            ["Q" => 0, "B" => 2, "S" => 2, "A" => 3, "G" => 3]
        ];

        $player = 0;
        $to = '0,1';

        $this->assertFalse(AvailablePositions($board, $hand[$player], $player, $to));
    }

}


