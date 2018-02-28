<html lang="en">
  <head>
    <title>Fantasy draft 2017-18</title>
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
	
	.teaminfo, .bench, #awards	{ margin-left: 20%; }
    	.starting { text-align: center;}
      .goalkeeper, .defender, .midfielder, .forward{ display: inline-block; width: 200px; padding-bottom: 5px;}
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

<center>
<div id="header"><table><tr><td>
<h1>Fantasy Draft League 2017-18</h1>
<h2>You pays your money, you takes your choice. <br />Except in this case, you don't pays your money.</h2>
</td>
<td style="text-align:center;" id="header_image">
<img style="width:200px;" src="https://upload.wikimedia.org/wikipedia/commons/5/57/Mobfooty.jpg" />
</td></tr>
</table>

</div>
</center>
<?php

include_once('dataconnect.php');

include_once('playerfunctions.php');
	
$players = by_score($players);

//add star to best ten players
for ($i = 0; $i < 10; $i++){
$name = $players[$i]['name']; 
$players[$i]['name'] = "&star; " . $name;
}
	
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
echo "<div class='teaminfo'>\n<hr />\n<h4>" .$team['Name'] . "</h4>\n\n<h3>" . $team['Team'] . "</h3>\n\n";
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

echo "<div id='awards'>";
  
echo "<h5>MVPs</h5><ol>";
foreach ($mvps as $mvp){
echo "<li>{$mvp['name']} &ndash; {$mvp['points']}</li>";
}
echo "</ol>";

echo "<h5>Mingers</h5><ol>";
foreach ($mingers as $ming){
echo "<li>{$ming['name']} &ndash; {$ming['points']}</li>";
}
echo "</ol>";


echo "<h5>Golden Gloves</h5><ol>";
foreach ($goldengloves as $gold){
echo "<li>{$gold['name']} &ndash; {$gold['points']}</li>";
}
echo "</ol>";

             
  ?>
  
</div>
  
  </body>
    
    </html>
