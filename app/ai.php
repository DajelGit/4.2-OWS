<?php

session_start();

$turn = 0;

$db = include_once 'database.php';
$stmt = $db->prepare('SELECT * FROM moves WHERE game_id = '.$_SESSION['game_id']);
$stmt->execute();
$result = $stmt->get_result();

$board = $_SESSION['board'];
$player = $_SESSION['player'];
$hand = $_SESSION['hand'];

getAIMove($turn, $player, $hand);

    function getAIMove($turn ,$board, $hand){

        // used https://www.php.net/manual/en/context.http.php

        $postData = [
            'move_number' => $turn,
            'hand' => $hand,
            'board' => $board
        ];

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-type: application/json\r\n",
                'content' => json_encode($postData),
            )
        );

        $url = 'http://localhost:5000/';

        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);

        $result = json_decode($result, true);

        print_r($result);

        return $result;
}
