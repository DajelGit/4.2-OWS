<?php

use PHPUnit\Framework\TestCase;

include_once 'app\util.php';

final class SoldierAntTest extends TestCase
{

    // a. Een soldatenmier verplaatst zich door een onbeperkt aantal keren te verschuiven
    public function testUnlimitedAntMove(): void
    {
        $board = [
            // white
            '0,0' => [['0', 'Q']],
            '0,-1' => [['0', 'B']],
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

        $ans = AvailableAntPositions($board, $player, $to, $from);

        $this->assertEquals(true, $ans);
    }

    // b. Een verschuiving is een zet zoals de bijenkoningin die mag maken.
    public function testAntMoveLikeQueen(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'A']],
            '0,2' => [['1', 'A']]
        ];

        $player = 0;
        $to = '1,-1';
        $from = '0,-1';

        $ans = AvailableAntPositions($board, $player, $to, $from);

        $this->assertEquals(true, $ans);
    }

    // c. Een soldatenmier mag zich niet verplaatsen naar het veld waar hij al staat
    public function testMoveAntToSameTile(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'A']],
            '0,2' => [['1', 'A']]
        ];

        $player = 0;
        $to = '0,-1';
        $from = '0,-1';

        $ans = AvailableAntPositions($board, $player, $to, $from);

        // mag niet naar dezelfde tile verplaatsen
        $this->assertEquals(false, $ans);
    }

    // d. Een soldatenmier mag alleen verplaatst worden over en naar lege velden.
    public function testAntOnlyMoveToEmptyTile(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'A']],
            '0,2' => [['1', 'A']]
        ];

        $player = 0;
        $to = '0,2';
        $from = '0,-1';

        $ans = AvailableAntPositions($board, $player, $to, $from);

        $this->assertEquals(false, $ans);
    }

}

