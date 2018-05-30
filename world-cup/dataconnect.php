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
$import_players[$i]['name'] = (string)$temp[9];
$import_players[$i]['club'] = (string)$temp[7];
$import_players[$i]['position'] = (string)$temp[5];
$import_players[$i]['points'] = (int)$temp[15];
$import_players[$i]['value'] = (float)$temp[13];
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

	}
	
	}

$players[] = $new_player;

}

}


$players = by_position(array_filter($players,"selected"));
