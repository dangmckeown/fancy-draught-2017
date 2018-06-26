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
$import_players[$i]['games played'] = (int)$temp[47];
$import_players[$i]['points'] = (int)$temp[15];
$import_players[$i]['fixture points'] = (int)$temp[17];
$import_players[$i]['value'] = (float)$temp[13];

if ($temp[21] != "-"){
$import_players[$i]['full clean sheet'] = (int)$temp[21];
$import_players[$i]['partial clean sheet'] = (int)$temp[23];
$import_players[$i]['conceded'] = (int)$temp[25];
}
else
{
$import_players[$i]['full clean sheet'] = False;
$import_players[$i]['partial clean sheet'] = False;
$import_players[$i]['conceded'] = False;
}

$import_players[$i]['goals'] = (int)$temp[41];
$import_players[$i]['assists'] = (int)$temp[19];
$import_players[$i]['yellow cards'] = (int)$temp[29];
$import_players[$i]['red cards'] = (int)$temp[31];
$import_players[$i]['disciplinary'] = 2 * $import_players[$i]['red cards'] + $import_players[$i]['yellow cards'];
$import_players[$i]['missedpen'] = (int)$temp[33];
$import_players[$i]['pensaved'] = (int)$temp[35];
$import_players[$i]['own goals'] = (int)$temp[27];
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
		// copy values across
		$new_player = $import;
		// initialise star property
		$new_player['star'] = False;
	}
	
	}

$players[] = $new_player;

}

}

//add star to best ten players
$players = by_score($players);
for ($i = 0; $i < 10; $i++){
$players[$i]['star'] = True;
}

$players = by_position(array_filter($players,"selected"));

