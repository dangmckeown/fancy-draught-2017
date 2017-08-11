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
  ?>
  
  </body>
    
    </html>
