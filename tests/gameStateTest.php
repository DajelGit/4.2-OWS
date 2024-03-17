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

        $hand = [];
        $player = 0;

        $ans = checkCanPass($board, $player, $hand);

        $this->assertEquals(false, $ans);
    }

    /*
    Het spel geeft nog niet aan wanneer iemand gewonnen heeft of wanneer er sprake is
    van een gelijkspel.
    */

    // a. Een speler wint als alle zes velden naast de bijenkoningin van de tegenstander
    // bezet zijn.
    public function testWinBySurroundedPlayer0(): void
    {
        $board = [
            // white
            '0,0' => [['0', 'A']],
            '0,-1' => [['0', 'Q']],
            // black
            '0,1' => [['1', 'Q']],
            '1,-1' => [['1', 'G']],
            '1,-2' => [['1', 'G']],
            '-1,-1' => [['1', 'B']],
            '-1,0' => [['1', 'A']],
            '-1,-2' => [['1', 'A']],
            '0,-2' => [['1', 'B']]
        ];

        $player = 0;

        $ans = checkSurrounded($board, $player);

        // player 0 is surrounded dus player 1 moeten winnen
        $this->assertEquals(true, $ans);
    }

    public function testWinBySurroundedPlayer1(): void
    {
        $board = [
            // white
            '0,0' => [['0', 'A']],
            '0,-1' => [['0', 'Q']],
            // black
            '0,1' => [['1', 'Q']],
            '1,-1' => [['1', 'G']],
            '1,-2' => [['1', 'G']],
            '-1,-1' => [['1', 'B']],
            '-1,0' => [['1', 'A']],
            '-1,-2' => [['1', 'A']],
            '0,-2' => [['1', 'B']]
        ];

        $player = 1;

        $ans = checkSurrounded($board, $player);

        // check of player 1 is surrounded, en dat is die niet.
        $this->assertEquals(false, $ans);
    }

    // b. Als beide spelers tegelijk zouden winnen is het in plaats daarvan een gelijkspel.
    public function testDraw(): void
    {
        $board = [
            // white
            "0,0" => [[0, 'Q']],
            "-1,2" => [[0, 'A']],
            "1,1" => [[0, 'A']],
            "0,2" => [[0, 'A']],
            // black
            "0,1" => [[1, 'Q']],
            "-1,1" => [[1, 'G']],
            "1,0" => [[1, 'B']],
            "-1,0" => [[1, 'A']],
            "0,-1" => [[1, 'A']],
            "1,-1" => [[1, 'A']],
        ];

        $ans = checkIfDraw($board);

        // check of player 1 is surrounded, en dat is die niet.
        $this->assertEquals(true, $ans);
    }
}
