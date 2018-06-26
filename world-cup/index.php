<html lang="en">
  <head>
    <title>Fantasy World Cup 2018</title>
<meta name="viewport" content="width=device-width" initial-scale="1.0">
    
    <style>
    body {
		font-family: "Arial Narrow";
}

#header td{
	display: inline-block;
}

.teamscore {
	background-color: #e4e4f4;
	border-radius: 8px;
	padding-left: 15px;
	width: 200px;
}
   @media screen and (min-width: 401px){
   
   #header{
	text-align: center;
}
   
	#header-image{
	width:250px;
}
	.teaminfo, .bench, #awards	{ margin-left: 20%; }
    	.starting { text-align: center;}
      .gk, .def, .mid, .str{ display: inline-block; width: 200px; padding-bottom: 5px;}
      .row{ display: block;padding-bottom:15px;}
      .sub{display: block; padding:0;border: 1px black solid;}
      
     }
     
       @media screen and (max-width: 400px){

	#header table, #header tr, #header td, #header-image  {	width: 100%; }
    	.starting { text-align: left;}
      .goalkeeper, .defender, .midfielder, .forward{ display: inline-block; width: 200px; }
      .row{ display: block;padding-bottom:3px;}
      .sub{display: block; padding:0;border: 1px black solid;}
      
     }

     
    </style>
  </head>

<body>


<div id="header">
<h1>The Official* Tears of a Clown / 28 Years Later / I Got Something in my Eye and Now I'm Running Around Biting People Like Luis Suarez Memorial Fantasy World Cup Draft</h1>
<center><img style="width:200px;" src="https://i2-prod.chroniclelive.co.uk/sport/football/article7176220.ece/ALTERNATES/s615/preview_WA127551.jpg" /></center>
<h2>Sponsored by extremely dated pop culture references and the law of diminishing returns</h2>
<p><sup>*not <b>that</b> official</sup></p>


</div>

<?php

include_once('dataconnect.php');
	
$table = array();

foreach ($teams as $team){

$squad = array_filter($players,$team['Filter']);

$table[] = ([net($squad),$team['Name']]);
}

rsort($table);

?>

<center>
<table>
<thead><th>Manager</th><th>Points</th></thead>
<tbody>

<?php

foreach ($table as $tab){
	echo "<tr><td>{$tab[1]}</td><td style='text-align: right;'>{$tab[0]}</td></tr>";
}

?>

</tbody>

</table>
</center>
<?php


foreach ($teams as $team){
$squad = array_filter($players,$team['Filter']);
echo "<div class='teaminfo'>\n<hr />\n<h4>" .$team['Name'] . "</h4>\n\n";
if($team['Name'] != 'Pete Harmer'){
echo "<h3>" . $team['Team'] . "</h3>\n\n";
}
else{
echo "<marquee behavior=\"scroll\" direction=\"left\">{$team['Team']}</marquee>";
}
echo "<div class='teamscore'><p>Score: " . net($squad) . "<br />(With subs: ". gross($squad) .")</p>\n</div>\n</div>\n";
echo displayteam($squad);


} // end foreach ($teams as $team)
  
// get various player awards
$players = by_score($players);
$mvps = ([$players[0],$players[1],$players[2]]);
$count = count($players);
$mingers = ([$players[$count - 1], $players[$count - 2], $players[$count - 3]]);

$players = by_position($players);

$goldengloves = ([$players[0],$players[1],$players[2]]);

$players = by_goals($players);

$goldenboots = ([$players[0],$players[1],$players[2]]);

$players = by_disciplinary($players);

$disciplinary = ([$players[0],$players[1],$players[2]]);
	
$players = by_pk_missed($players);
	
$batties = ([$players[0],$players[1],$players[2]]);
	
?>

<div id="awards">

<?php
  
echo "<h5>The Mr Van Persie Memorial Award (MVPs)</h5><ol>";
foreach ($mvps as $mvp){
echo "<li>{$mvp['name']}: {$mvp['points']} points</li>";
}
echo "</ol>";

echo "<h5>The Oleg Salenko Banging Them In For Fun Memorial Award</h5><ol>";
foreach ($goldenboots as $gold){
echo "<li>{$gold['name']}: {$gold['goals']} goals ({$gold['assists']} assists)</li>";
}
echo "</ol>";

echo "<h5>The Lev Who? Rob Green Va-Va-Vuvuzela Memorial Golden Gloves Award</h5><ol>";
foreach ($goldengloves as $gold){
echo "<li>{$gold['name']}: {$gold['points']} points</li>";
}
echo "</ol>";

echo "<h5>The Theo Walcott Memorial Trophy (for anyone who's racked up as many World Cup points as Tyrone Mings)</h5><ol>";
foreach ($mingers as $ming){
echo "<li>{$ming['name']}: {$ming['points']}</li>";
}
echo "</ol>";

echo "<h5>The Benjamin Massing / Battle of Santiago Memorial Disciplinary Award</h5><ol>";
foreach ($disciplinary as $disciple){
echo "<li>{$disciple['name']}: {$disciple['red']} red cards, {$disciple['yellow']} yellow cards</li>";
}
echo "</ol>";

echo "<h5>The 50 Years of Hurt \"Kevin, you know him better than anyone - will he score?\" Memorial Award for Hapless Penalty Shanking</h5><ol>";
foreach ($batties as $batty){
echo "<li>{$batty['name']}: {$batty['missedpen']} missed, {$batty['pensaved']} saved</li>";
}
echo "</ol>";
             
  ?>
  
</div>
  
</body>
    
</html>
