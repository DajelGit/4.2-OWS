<?php

use PHPUnit\Framework\TestCase;

include_once 'app\util.php';

final class AiTest extends TestCase
{

    public function testGetAIMove(): void {
        $turn = 2;

        $board = [
            "0,0" => [[0, 'Q'], [1, "B"]],
        ];

        $hand = [
            ["Q"=>0,"B"=>2,"A"=>3,"S"=>2,"G"=>3],
            ["Q"=>1,"B"=>2,"A"=>3,"S"=>2,"G"=>3]
        ];

        $ans = getAIMove($turn, $board, $hand);

        $this->assertNotNull($ans);
    }
}
