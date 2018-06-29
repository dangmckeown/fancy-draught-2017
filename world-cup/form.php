<?php

// Single-player form guide

if (! $_POST ){
	header('Location: index.php');
	exit;
}
else{
	$player = $_POST;
{
	echo "<h1>{$player['name']}</h1>\n\n";
	echo "<h2>{$player['position']} | {$player['club']}</h2>\n\n";
	echo "<h3>{$player['points']} points | {$player['manager']}</h3>\n\n";
	unset($player['name']);
	unset($player['position']);
	unset($player['club']);
	unset($player['points']);
	unset($player['manager']);
?>

<table>

<?php	
	foreach($player as $attr=>$val){
		if($val && $attr != 'star' && $attr != 'disciplinary'){
			$row = "<tr><td><b>{$attr}</b></td><td style='text-align: right;'>_pre_{$val}_post_</td></tr>\n\n";
	
		if($attr == 'value'){
			$row = preg_replace("/_pre_/","£",$row);
			$row = preg_replace("/_post_/","m",$row);
		}
		
		$row = preg_replace("/_pre_/","",$row);
		$row = preg_replace("/_post_/","",$row);
		echo $row;
		}
	}	
}


?>

</table>

<p><a href="index.php">Return to main page</a></p>

<?php
}
