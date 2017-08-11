<html lang="en">
  <head>
    <title>Fantasy draft 2017-18</title>
  </head>

<body>

<?php

include_once('dataconnect.php');

include_once('playerfunctions.php');

foreach ($teams as $team){

echo "<h4>" .$team['Name'] . "</h4>\n\n<h3>" . $team['Team'] . "</h3>\n\n";

$squad = array();

foreach ($players as $player){

if($player['manager'] == $team['Name']){
$squad[] = $player;
}


}

echo displayteam($squad);
echo "<p>Score: " . net($squad) . "<br />(With subs: ". gross($squad) .")</p>\n\n";


}
  
$players = by_score($players);
$mvps = ([$players[0],$players[1],$players[2]]);
$count = count($players);
$mingers = ([$players[$count - 1], $players[$count - 2], $players[$count - 3]]);
$players = by_position($players);
$goldengloves([$players[0],$players[1],$players[2]]);
               
             
  ?>
  
  <p><?php var_dump($mvps); ?></p>
  <p><?php var_dump($mingers); ?></p>
  <p><?php var_dump($goldengloves); ?></p>
  
  </body>
    
    </html>
