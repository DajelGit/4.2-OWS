<?php

use PHPUnit\Framework\TestCase;

include_once 'app\util.php';

final class SpiderTest extends TestCase
{

    // a. Een spin verplaatst zich door precies drie keer te verschuiven.
    public function testSpiderMoveThreeTiles(): void
    {
        $board = [
            // white
            '0,0' => [['0', 'Q']],
            '0,-1' => [['0', 'S']],
            '0,3' => [['0', 'G']],
            // black
            '0,1' => [['1', 'Q']],
            '0,2' => [['1', 'G']],
            '1,1' => [['1', 'G']],
            '-1,2' => [['1', 'B']],
        ];

        $player = 0;
        $to = '-1,3';
        $from = '0,-1';

        // *tijdelijk*
        if (AvailableSpiderPositions($board, $player, $to, $from) === true && countTiles($from, $to) == 3) {
            $ans = true;
        } else {
            $ans = false;
        }

        $this->assertEquals(true, $ans);
    }

    // b. Een verschuiving is een zet zoals de bijenkoningin die mag maken.
    public function testSpiderMoveLikeQueen(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'S']],
            '0,2' => [['1', 'A']]
        ];

        $player = 0;
        $to = '2,0';
        $from = '0,-1';

        $ans = AvailableSpiderPositions($board, $player, $to, $from);

        $this->assertEquals(true, $ans);
    }

    // c. Een spin mag zich niet verplaatsen naar het veld waar hij al staat.
    public function testMoveSpiderToSameTile(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'S']],
            '0,2' => [['1', 'A']]
        ];

        $player = 0;
        $to = '0,-1';
        $from = '0,-1';

        $ans = AvailableSpiderPositions($board, $player, $to, $from);

        // mag niet naar dezelfde tile verplaatsen
        $this->assertEquals(false, $ans);
    }

    // d. Een spin mag alleen verplaatst worden over en naar lege velden.
    public function testSpiderOnlyMoveToEmptyTile(): void
    {
        $board = [
            // white
            '0,0' => [['0', 'Q']],
            '0,-1' => [['0', 'S']],
            '0,3' => [['0', 'G']],
            // black
            '0,1' => [['1', 'Q']],
            '0,2' => [['1', 'G']],
            '1,1' => [['1', 'G']],
            '-1,2' => [['1', 'B']],
        ];

        $player = 0;
        $to = '-1,2';
        $from = '0,-1';

        $ans = AvailableSpiderPositions($board, $player, $to, $from);

        $this->assertEquals(false, $ans);
    }

    // e. Een spin mag tijdens zijn verplaatsing geen stap maken naar een veld waar hij
    // tijdens de verplaatsing al is geweest.
    public function testSpiderMoveOverPreviousTile(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'S']],
            '0,2' => [['1', 'A']]
        ];

        $player = 0;
        $to = '1,-1';
        $from = '0,-1';
        // in dit scenario gaat de spider eerst naar links, en daarna twee keer naar rechts
        // dus gaat hij weer opnieuw over de '0,-1' tile

        $ans = AvailableSpiderPositions($board, $player, $to, $from);

        $this->assertEquals(false, $ans);
    }

}

