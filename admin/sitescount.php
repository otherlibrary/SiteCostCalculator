<?php
include("config.php");
$sql = "SELECT COUNT(*) as num FROM worth";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
	$dbPopulation = $row[num];
}

 $myFile = "count"; 
 $handle = fopen($myFile, 'r'); 
 while (!feof($handle)) 
 { 
 $old = fgets($handle, 512);
 } 
 fclose($handle); 

$new = $dbPopulation - $old;

$fp = fopen('count', 'w');
fwrite($fp, $dbPopulation);
fclose($fp);

mysql_close($con);
mail('vladimir.kishlaly@gmail.com', $new.' new sites', "subj");
?>
