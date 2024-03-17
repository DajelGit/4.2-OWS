<?php

$GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

function isNeighbour($a, $b)
{
    $a = explode(',', $a);
    $b = explode(',', $b);
    if ($a[0] == $b[0] && abs($a[1] - $b[1]) == 1) {
        return true;
    }
    if ($a[1] == $b[1] && abs($a[0] - $b[0]) == 1) {
        return true;
    }
    if ($a[0] + $a[1] == $b[0] + $b[1]) {
        return true;
    }
    return false;
}

function hasNeighBour($a, $board)
{
    foreach (array_keys($board) as $b) {
        if (isNeighbour($a, $b)) {
            return true;
        }
    }
}

function neighboursAreSameColor($player, $a, $board)
{
    foreach ($board as $b => $st) {
        if (!$st) {
            continue;
        }
        $c = $st[count($st) - 1][0];
        if ($c != $player && isNeighbour($a, $b)) {
            return false;
        }
    }
    return true;
}

function len($tile)
{
    return $tile ? count($tile) : 0;
}

function slide($board, $from, $to)
{
    if (!hasNeighBour($to, $board)) {
        return false;
    }
    if (!isNeighbour($from, $to)) {
        return false;
    }
    $b = explode(',', $to);
    $common = [];
    foreach ($GLOBALS['OFFSETS'] as $pq) {
        $p = $b[0] + $pq[0];
        $q = $b[1] + $pq[1];
        if (isNeighbour($from, $p . "," . $q)) {
            $common[] = $p . "," . $q;
        }
    }

    if (!array_key_exists($common[0], $board) || !array_key_exists($common[1], $board)) {
        return true;
    }
    return false;
}

function AvailablePositions($board, $hand, $player, $to)
{
    if (isset($board[$to])) {
        return false;
    }
    if (count($board) && !hasNeighBour($to, $board)) {
        return false;
    }
    if (
        array_sum($hand) < 11 && !neighboursAreSameColor($player, $to, $board)
        || array_sum($hand) <= 8 && $hand['Q']
    ) {
        return false;
    }

    return true;
}

function getNeighbours($pos)
{
    $posNeighbours = [];
    [$x, $y] = explode(',', $pos);
    foreach ($GLOBALS['OFFSETS'] as [$dx, $dy]) {
        $nx = $x + $dx;
        $ny = $y + $dy;
        $posNeighbours = "$nx, $ny";
    }
    return $posNeighbours;
}

// na een half uur ben ik er achter gekomen dat isset een ding is ;-;
// function isEmpty($board, $from)
// {
//     $tile = array_pop($board[$from]);
//     $tiles_array = array("Q", "A", "B", "S", "G");

//     if (in_array($tile[1], $tiles_array)) {
//         return false;
//     } else {
//         return true;
//     }
// }

function AvailableGrasshopperPositions($board, $player, $to, $from)
{
    if (isset($board[$to]) || ($from == $to)) {
        return false;
    }
    if (count($board) && !hasNeighBour($to, $board)) {
        return false;
    }

    $f = explode(',', $from);
    $fx = $f[0];
    $fy = $f[1];
    $t = explode(',', $to);
    $tx = $t[0];
    $ty = $t[1];

    //echo "initial from: $from\n";
    //echo "initial to: $to\n";

    if ($fx != $tx) {
        if ($fx < $tx) {
            // inc = increment
            $inc = 1;
        } else {
            $inc = -1;
        }

        //echo "voor while 1: fx $fx, tx $tx\n";
        while ($fx != $tx) {
            $fx = $fx + $inc;
            $cords = "$fx,$fy";
            if ($cords == $to) {
                break;
            }
            if (!isset($board[$cords])) {
                //echo "$cords zijn empty\n";
                return false;
            }
        }
    } elseif ($fy != $ty) {
        if ($fy < $ty) {
            $inc = 1;
        } else {
            $inc = -1;
        }
        //echo "voor while 2: fy $fy, ty $ty\n";
        while ($fy != $ty) {
            $fy = $fy + $inc;
            $cords = "$fx,$fy";
            if ($cords == $to) {
                break;
            }
            if (!isset($board[$cords])) {
                //echo "$cords zijn empty\n";
                return false;
            }
        }
    }

    //check of over minstens 1 steen wordt gesprongen
    $toNeigbours = getNeighbours($to);
    $fromNeighbours = getNeighbours($from);

    foreach ($fromNeighbours as $neighbour) {
        if (!in_array($neighbour, $toNeigbours)) {
            return true;
        }
    }

    return true;
}

function AvailableAntPositions($board, $player, $to, $from)
{
    if (isset($board[$to]) || ($from == $to)) {
        return false;
    }
    if (count($board) && !hasNeighBour($to, $board)) {
        return false;
    }

    return true;
}

function AvailableSpiderPositions($board, $player, $to, $from)
{
    if (isset($board[$to])) {
        return false;
    }
    if (count($board) && !hasNeighBour($to, $board)) {
        return false;
    }

    return true;
}
