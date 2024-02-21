<?php

use PHPUnit\Framework\TestCase;

include_once 'app\util.php';

final class GrasshopperTest extends TestCase
{

    // a. Een sprinkhaan verplaatst zich door in een rechte lijn een sprong te maken
    // naar een veld meteen achter een andere steen in de richting van de sprong.
    public function testValidGrasshopperMove(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'G']],
            '0,2' => [['1', 'G']]
        ];

        $player = 0;
        $to = '0,3';
        $from = '0,-1';

        $ans = AvailableGrasshopperPositions($board, $player, $to, $from);

        $this->assertEquals(true, $ans);
    }

    public function testInvalidGrasshopperMove(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'G']],
            '0,2' => [['1', 'G']]
        ];

        $player = 0;
        $to = '2,5';
        $from = '0,-1';

        $ans = AvailableGrasshopperPositions($board, $player, $to, $from);

        $this->assertEquals(false, $ans);
    }

    // b. Een sprinkhaan mag zich niet verplaatsen naar het veld waar hij al staat
    public function testMoveToSameTile(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'G']],
            '0,2' => [['1', 'G']]
        ];

        $player = 0;
        $to = '0,-1';
        $from = '0,-1';

        $ans = AvailableGrasshopperPositions($board, $player, $to, $from);

        // mag niet naar dezelfde tile verplaatsen
        $this->assertEquals(false, $ans);
    }

    // c. Een sprinkhaan moet over minimaal één steen springen.
    public function testJumpOverMinOneTile(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'G']],
            '0,2' => [['1', 'G']]
        ];

        $player = 0;
        $to = '-1,0';
        $from = '0,-1';
        // grasshopper naar neighbour (niet valid)

        $ans = AvailableGrasshopperPositions($board, $player, $to, $from);

        $this->assertEquals(false, $ans);
    }

    // d. Een sprinkhaan mag niet naar een bezet veld springen.
    public function testMoveToOccupiedTile(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'G']],
            '0,2' => [['1', 'G']]
        ];

        $player = 0;
        $to = '0,2';
        $from = '0,-1';

        $ans = AvailableGrasshopperPositions($board, $player, $to, $from);

        $this->assertEquals(false, $ans);
    }

    // e. Een sprinkhaan mag niet over lege velden springen. Dit betekent dat alle
    // velden tussen de start- en eindpositie bezet moeten zijn.
    public function testJumpNoEmptyTiles(): void
    {
        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,-1' => [['0', 'G']],
            '0,2' => [['1', 'G']]
        ];

        $player = 0;
        $to = '0,4';
        $from = '0,-1';

        $ans = AvailableGrasshopperPositions($board, $player, $to, $from);

        $this->assertEquals(false, $ans);
    }

}

