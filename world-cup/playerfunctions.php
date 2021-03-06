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
  
//additions for world cup
  //by_disciplinary($players)
  //by_pk_misse($players)

*/

function sambasteam($player){
$output = False;
 if($player['manager'] == "Sam Batch"){
 $output = True;
 }
  return $output;
}

function twmsteam($player){
$output = false;
 if($player['manager'] == "Twm"){
 $output = True;
 }
  return $output;
}

function samuelsteam($player){
$output = False;
 if($player['manager'] == "Samuel E Green"){
 $output = True;
 }
  return $output;
}

function petesteam($player){
$output = False;
 if($player['manager'] == "Pete Harmer"){
 $output = True;
 }
  return $output;
}

function joesteam($player){
$output = False;
 if($player['manager'] == "Joe"){
 $output = True;
 }
  return $output;
}

function hollysteam($player){
$output = False;
 if($player['manager'] == "Holly 'The Hammer' Hamilton"){
 $output = True;
 }
  return $output;
}

function christsteam($player){
$output = False;
 if($player['manager'] == "Christ"){
 $output = True;
 }
  return $output;
}

function dansteam($player){
$output = False;
 if($player['manager'] == "Dan"){
 $output = True;
 }
  return $output;
}

//=========================


function selected($player){

//filter curl list of players down to those who have made it onto a roster

if($player['manager']){
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

if ($player['position']=="GK"){

$output[] = $player;

}

}

foreach ($players as $player){

if ($player['position']=="DEF"){

$output[] = $player;

}

}

foreach ($players as $player){

if ($player['position']=="MID"){

$output[] = $player;

}

}

foreach ($players as $player){

if ($player['position']=="STR"){

$output[] = $player;

}

}

return $output;

} // end function by_position($players)


//=========================


function by_score($players){

#var_dump($players);

//sorts players by score
//NOTE array length has to be same for all players, otherwise it gets messy
//so don't sort selected and unselected players together


for($i = 0;$i < count($players);$i++){

array_unshift($players[$i],$players[$i]['points']);
#var_dump($players[$i]);

}

rsort($players);

for($i = 0; $i < count($players); $i++){

$junk = array_shift($players[$i]);
//get rid of the score added to the start of the array
}
  
return $players;

} // end function by_score($players)

//=========================

function by_played($players){

//sorts players by games played

for($i = 0;$i < count($players);$i++){

array_unshift($players[$i],$players[$i]['games played']);

}

rsort($players);

for($i = 0; $i < count($players); $i++){

$junk = array_shift($players[$i]);
//get rid of the score added to the start of the array
}
  
return $players;

} // end function by_played($players)

//=========================

function by_disciplinary($players){

//sorts players by disciplinary

for($i = 0;$i < count($players);$i++){

array_unshift($players[$i],$players[$i]['disciplinary']);

}

rsort($players);

for($i = 0; $i < count($players); $i++){

$junk = array_shift($players[$i]);
//get rid of the score added to the start of the array
}
  
return $players;

} // end function by_disciplinary($players)

//=========================

function by_pk_missed($players){

//sorts players by pks haplessly shanked

for($i = 0;$i < count($players);$i++){

array_unshift($players[$i],$players[$i]['missedpen'] + $players[$i]['pensave']);

}

rsort($players);

for($i = 0; $i < count($players); $i++){

$junk = array_shift($players[$i]);
//get rid of the score added to the start of the array
}
  
return $players;

} // end function by_pk_missed($players)

//=========================

function by_goals($players){

//sorts players by goals & assists

for($i = 0;$i < count($players);$i++){

array_unshift($players[$i],$players[$i]['goals'] * 800 + $players[$i]['assists']);

}

rsort($players);

for($i = 0; $i < count($players); $i++){

$junk = array_shift($players[$i]);
//get rid of the score added to the start of the array
}
  
return $players;

} // end function by_goals($players)

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


if($subs[0]['position'] == "STR" && $subs[1]['position'] == "STR" && $subs[2]['position'] == "STR" ){

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

$total += $players[$i]['points'];

}

return($total);

} //end function net($players)



//=========================

function gross($players){

//gives points total for squad

$total = 0;

$players = lineup($players);

for ($i=0; $i<15; $i++){

$total += $players[$i]['points'];

}

return($total);

} //end function gross($players)



//=========================

function displayteam($players){

//returns team as html code, players separated into <div> tags which can be styled with CSS

$output = "";

$players = lineup($players);

echo "<div class='starting'>";

for ($i=0; $i<11; $i++){

if ($i == 0 || ($i > 0 && ( $players[$i]['position'] != $players[$i - 1]['position']))){
$output .= "<div class = 'row'>\n\n";
} 

$output .= "<form class='".strtolower($players[$i]['position'])."' method='post' action='form.php'>\n\n";


foreach($players[$i] as $attr=>$val){
	
	$output .= "<input type='hidden' name='$attr' value='$val' />\n\n";
}

$output .= "<input type='submit' value='";

if($players[$i]['star']){
  $output .= "&star; ";
}

$output .= "{$players[$i]['name']}: {$players[$i]['points']}'><br/><label>{$players[$i]['club']}</label>\n\n</form>\n\n";

if ( $players[$i]['position'] != $players[$i + 1]['position'] || $i == 10 ){
$output .= "</div>";
}

    
}


//close off eleven div and put the subs in
$output .= "</div><div class='bench'><h5>Subs</h5><div class='row'>";  
  
for ($i=11; $i<15; $i++){

$output .= "<div class='sub ".strtolower($players[$i]['position'])."'>{$players[$i]['name']} &ndash; {$players[$i]['points']}<br /><sup>{$players[$i]['club']}</sup></div>\n\n";

}

$output .= "</div>\n\n</div>";
  
return $output;

} //end function displayteam($players)

