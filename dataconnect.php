<?php

include_once('teams.php');
include_once('playerfunctions.php');



$fh = file_get_contents('https://fantasy.premierleague.com/player-list/');
#$fh = file_get_contents('player-list.htm');


$first = explode("<h2>",$fh);

$second = array();

$third = array();

$fourth = array();

$players=array();

$discard = array_shift($first);

#$second = explode("<tr>",$first);

foreach ($first as $f){
$second[] = explode("</h2>",$f);
}

foreach($second as $s){
$third[preg_replace("/s$/","",$s[0])] = explode("<tr>",str_replace("<td>",",",$s[1]));
#preg_replace("/s$/","",$s[0]);
}

foreach($third as $k => $thi){
foreach($thi as $th){
$fourth[$k][] = explode(",",$th);
}
}

$i=0;

foreach($fourth as $k=>$fours){
foreach($fours as $four){
if (count($four) >= 4){
$players[$i]['name'] = trim((string)strip_tags($four[1]));
$players[$i]['club'] = trim((string)strip_tags($four[2]));
$players[$i]['position'] = (string)$k;
$players[$i]['points'] = (int)$four[3];
$losepound = explode("£",$four[4]);
$players[$i]['value'] = (float)$losepound[1];



$test = ([ $players[$i]['name'],$players[$i]['club'],$players[$i]['position'] ]);
foreach ($teams as $team){

foreach($team['Players'] as $picked){

$compare = ([ $picked[0],$picked[1],$picked[2] ]);

if($test == $compare){

$players[$i]['manager'] = $team['Name'];

}

}

}

}

$i++;
} 

}






//add absent friends

foreach($teams as $team){
foreach($team['Players'] as $picked){

if (is_int($picked[1])){

#var_dump($picked);

$players[$i]['name'] = trim($picked[0]);
$players[$i]['club'] = $picked[1];
$players[$i]['position'] = $picked[2];
$players[$i]['points'] = $picked[1];
$players[$i]['value'] = "0" ;
$players[$i]['manager'] = $team['Name'];

}
$i++;
}

}

#var_dump($players);

# $players = by_position(array_filter($players,"selected"));

echo "<h1>".count($players)."</h1>";
