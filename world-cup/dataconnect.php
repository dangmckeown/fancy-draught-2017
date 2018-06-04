<?php

include_once('teams.php');
include_once('playerfunctions.php');

//Get data from source
$fh = file_get_contents('https://fantasyfootball.telegraph.co.uk/world-cup/json/getplayerstats');

//Scrape down to players
$html = json_decode($fh);

$players=array();

$data = explode('<',str_replace('>','',$html->playerstats));

foreach($data as $dat){
	if(strpos($dat,"playerstats")){
		$stats[] = $dat;
	}
}

foreach ($stats as $stat){
$temp = explode('"',$stat);
$i = $temp[3];
#var_dump($temp);
$import_players[$i]['name'] = (string)$temp[9];
$import_players[$i]['club'] = (string)$temp[7];
$import_players[$i]['position'] = (string)$temp[5];
$import_players[$i]['points'] = (int)$temp[15];
$import_players[$i]['value'] = (float)$temp[13];
$import_players[$i]['goals'] = (int)$temp[41];
$import_players[$i]['yellow'] = (int)$temp[29];
$import_players[$i]['red'] = (int)$temp[31];
$import_players[$i]['disciplinary'] = 2 * $import_players[$i]['red'] + $import_players[$i]['yellow'];
$import_players[$i]['missedpen'] = (int)$temp[33];
$import_players[$i]['pensaved'] = (int)$temp[35];
}


$players = array();

foreach($teams as $team){

foreach($team['Players'] as $player){

$new_player = array(
	'name' =>	$player[0],
	'club' =>	$player[1],
	'position' => $player[2],
	'manager' => $team['Name']
	);
	
	foreach($import_players as $import){
	
	if($new_player['name'] == $import['name'] && $new_player['club'] == $import['club'] && $new_player['position'] == $import['position']){
		$new_player['value'] = $import['value'];
		$new_player['points'] = $import['points'];
	 	$new_player['goals'] = $import['goals'];
		$new_player['yellow'] = $import['yellow']; 
		$new_player['red'] = $import['red'];
		$new_player['disciplinary'] = $import['disciplinary']; 
		$new_player['missedpen'] = $import['missedpen'];
		$new_player['pensaved'] = $import['pensaved'];
	}
	
	}

$players[] = $new_player;

}

}


$players = by_position(array_filter($players,"selected"));

#var_dump($players);
