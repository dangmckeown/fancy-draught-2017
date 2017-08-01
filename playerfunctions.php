<?php

/*

//List of functions:

//selected($player)
  //filter array of players down to those who have made it onto a roster

//by_position($players)
  //sorts array of players by position

//by_score($players)
  //sorts array of players by score (highest to lowest)

//lineup($players)
  //returns array of team in order 
  //(highest-scoring 11 occupy first eleven places, sorted by position
  //  subs occupy last four places, sorted by position)  

//net($players)
  //gives points total for best viable 11

//gross($players)
  //gives points total for squad
  
//displayteam($players)
  //returns lined-up squad as html code, players separated into <div> tags 
  // which can be styled with CSS

*/


//=========================

function selected($player){

//filter curl list of players down to those who have made it onto a roster

global $managers;

$test = array_pop($player);

if (in_array($test,$managers)){

return True;

}

else

{

return False;

}


} //end function selected($player)


//=========================


function by_position($players){

//sorts players by position

$output = array();

foreach ($players as $player){

if ($player[2]=="Goalkeeper"){

$output[] = $player;

}

}

foreach ($players as $player){

if ($player[2]=="Defender"){

$output[] = $player;

}

}

foreach ($players as $player){

if ($player[2]=="Midfielder"){

$output[] = $player;

}

}

foreach ($players as $player){

if ($player[2]=="Forward"){

$output[] = $player;

}

}

return $output;

} // end function by_position($players)


//=========================


function by_score($players){

//sorts players by score
//NOTE array length has to be same for all players, otherwise it gets messy
//so don't sort selected and unselected players together


for($i = 0;$i < count($players);$i++){

array_unshift($players[$i],$players[$i][3]);

}

rsort($players);

for($i = 0; $i < count($players); $i++){

$junk = array_shift($players[$i]);

}

return $players;

} // end function by_score($players)



//=========================

function lineup($players){

//returns a text string laying out the team

$players = by_position($players);

$goalies = array();

$goalies[] = array_shift($players); 

$goalies[] = array_shift($players); 

$goalies = by_score($goalies);

$players = by_score($players);

$subs = array();

$subs[] = array_pop($players); 

$subs[] = array_pop($players); 

$subs[] = array_pop($players); 

if($subs[0][2] == "Forward" && $subs[1][2] == "Forward" && $subs[2][2] == "Forward" ){

$recall = array_shift($subs);

$drop = array_pop($players);

array_unshift($subs,$drop);

array_push($players,$recall);

}

$players[] = $goalies[0];

$players = by_position($players);

$subs[] = $goalies[1];

$subs = by_position($subs);

foreach($subs as $sub){

$players[] = $sub;

}

return $players;

} //end function lineup($players)



//=========================

function net($players){

//gives points total for best viable 11

$total = 0;

$players = lineup($players);

for ($i=0; $i<11; $i++){

$total += $players[$i][3];

}

return($total);

} //end function net($players)



//=========================

function gross($players){

//gives points total for squad

$total = 0;

$players = lineup($players);

for ($i=0; $i<15; $i++){

$total += $players[$i][3];

}

return($total);

} //end function gross($players)



//=========================

function displayteam($players){

//returns team as html code, players separated into <div> tags which can be styled with CSS

$output = "";

$players = lineup($players);

for ($i=0; $i<11; $i++){

$output .= "<div class='".strtolower($players[$i][2])."'>{$players[$i][0]} {$players[$i][3]}<br/>{$players[$i][1]}</div>\n\n";

}

for ($i=11; $i<15; $i++){

$output .= "<div class='sub ".strtolower($players[$i][2])."'>{$players[$i][0]} {$players[$i][3]}<br/>{$players[$i][1]}</div>\n\n";

}

return $output;

} //end function displayteam($players)
