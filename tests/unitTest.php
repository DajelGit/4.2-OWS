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

        $this->assertEquals(false, AvailablePositions($board, $hand[$player], $player, $to));
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

        $this->assertEquals(true, slide($board, $from, $to));
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

        $this->assertEquals(false, AvailablePositions($board, $hand[$player], $player, $to));
    }

    // public function testHasNeighbour(): void
    // {
    //     $board = [
    //         '0,0' => [['0', 'Q']],
    //         '1,-1' => [['0', 'B']],
    //         '0,-2' => [['0', 'B']],

    //         '1,0' => [['1', 'Q']],
    //         '1,1' => [['1', 'B']],
    //         '1,2' => [['1', 'B']]
    //     ];

    //     $pos = '0,-2';

    //     $this->assertEquals(false, hasNeighBour($pos, $board));

    // }

    public function testIsNeighbour(): void
    {
        $a = '0,0';
        $b = '1,-1';
        $c = '1,-2';

        // wel neighbours
        $this->assertEquals(true, isNeighbour($a, $b));
        // niet neighbours
        $this->assertEquals(false, isNeighbour($a, $c));
    }

    public function testIfEmptyTileHasNeighbour()
    {
        $board = [
            "0,0" => [[0, 'Q']],
            "1,0" => [[1, 'Q']]
        ];

        $pos = "0,1";
        $this->assertEquals(true, HasNeighbour($pos, $board));
    }

}

