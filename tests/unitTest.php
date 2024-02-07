<?php

use PHPUnit\Framework\TestCase;

include_once 'app\util.php';

final class UnitTest extends TestCase
{

    public function testInvalidMove(): void
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
        $to = '5,5';

        $ans = AvailablePositions($board, $hand[$player], $player, $to);

        $this->assertEquals(false, $ans);
    }

    # bug #2
    public function testSlideQueen(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '1,0' => [['1', 'Q']]
        ];

        $from = '0,0';
        $to = '0,1';

        $ans = slide($board, $from, $to);

        $this->assertEquals(true, $ans);
    }

    public function testOccupiedPosition(): void
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
        $to = '1,0';

        $ans = AvailablePositions($board, $hand[$player], $player, $to);

        $this->assertEquals(false, $ans);
    }

    public function testIsNeighbour(): void
    {
        $a = '0,0';
        $b = '1,-1';

        $ans = isNeighbour($a, $b);

        // wel neighbours
        $this->assertEquals(true, $ans);
    }

    public function testIsNotNeighbour(): void
    {
        $a = '0,0';
        $b = '1,-2';

        $ans = isNeighbour($a, $b);

        // niet neighbours
        $this->assertEquals(false, $ans);
    }

    public function testIfEmptyTileHasNeighbour()
    {
        $board = [
            "0,0" => [[0, 'Q']],
            "1,0" => [[1, 'Q']]
        ];

        $pos = "0,1";

        $ans = HasNeighbour($pos, $board);

        $this->assertEquals(true, $ans);
    }

}

