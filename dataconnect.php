<?php

include_once('teams.php');
include_once('playerfunctions.php');



$fh = json_decode(file_get_contents('https://fantasy.premierleague.com/api/bootstrap-static'));

$positions = array(
1 => 'Goalkeeper',
2 => 'Defender',
3 => 'Midfielder',
4 => 'Forward'
);

$clubs = array();

foreach($fh->teams as $team)
{
    $clubs[$team->id] = $team->name;
}

$data = $fh->elements;

$players = array();

$i = 0;

foreach($data as $datum){

foreach ($teams as $team){

foreach($team['Players'] as $picked){

if($picked == $datum->id){

$players[$i] = array(
    'manager' => $team['Name'],
    'name' => $datum->web_name,
    'position' => $positions[$datum->element_type],
    'club' => $clubs[$datum->team],
    'points' => $datum->total_points,
    'value' => $datum->now_cost / 10

);

$i++;
}

}

}

}



$players = by_position(array_filter($players,"selected"));
