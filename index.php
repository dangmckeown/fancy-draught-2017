<?php

include_once('dataconnect.php');

include_once('playerfunctions.php');

foreach ($teams as $team){

echo $team['Name'] . "<br />" . $team['Team'];

$squad = array();

foreach ($players as $player){

if($player['manager'] == $team['Name']){
$squad[] = $player;
}


}

echo displayteam($squad);
echo "<p>Score: " . net($squad) . "</p>";


}