<?php

session_start();

$turn = 0;

$db = include_once 'database.php';
$stmt = $db->prepare('SELECT * FROM moves WHERE game_id = '.$_SESSION['game_id']);
$stmt->execute();
$result = $stmt->get_result();

$turn = 1;

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

        print_r($board);

        $url = 'http://host.docker.internal:5000/';
    
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
    
        $result = json_decode($result, true);

        

        if ($result[0] == "play") {
            $to = $result[2];
            $piece = $result[1];

            $_SESSION['board'][$to] = [[$_SESSION['player'], $piece]];
            $_SESSION['hand'][$player][$piece]--;
            $_SESSION['player'] = 1 - $_SESSION['player'];

            $db = include_once 'database.php';
            $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state)
            values (?, "play", ?, ?, ?, ?)');
            $stmt->bind_param('issis', $_SESSION['game_id'], $piece, $to, $_SESSION['last_move'], get_state());
            $stmt->execute();

            $_SESSION['last_move'] = $db->insert_id;
        }

        elseif ($result[0] == "move") {
            $from = $result[1];
            $to = $result[2];
            $board[$to] = [$tile];

            $_SESSION['player'] = 1 - $_SESSION['player'];

            $db = include_once 'database.php';
            $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state)
            values (?, "move", ?, ?, ?, ?)');
            $stmt->bind_param('issis', $_SESSION['game_id'], $from, $to, $_SESSION['last_move'], get_state());
            $stmt->execute();

            $_SESSION['last_move'] = $db->insert_id;
            unset($board[$from]);
        }

        elseif ($result[0] == "pass") {
            $db = database();
            $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state)
            values (?, "pass", null, null, ?, ?)');
            $stmt->bind_param('iis', $_SESSION['game_id'], $_SESSION['last_move'], get_state());
            $stmt->execute();

            $_SESSION['last_move'] = $db->insert_id;
            $_SESSION['player'] = 1 - $_SESSION['player'];
        }

        print_r($result);
    
        return $result;
}
