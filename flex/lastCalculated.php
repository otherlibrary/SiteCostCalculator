<?php

header("Content-type: text/xml");

include('config.php');

$sql = "SELECT * FROM worth ORDER BY id DESC LIMIT 100"; 
$result = mysql_query($sql);

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><sites>";

while ($row = mysql_fetch_assoc($result)) { 
	$domain=$row[domain];
		 $worthInt = intval($row[worth]);
		 $worthInt = $worthInt * 3;
		 if ($worthInt == 0) {
		 	$worthInt = 100;
		 }
		 $dearn=$row[dearn];
		 $dearnInt = intval($dearn);
		 $dearnInt = $dearnInt * 11;		 
		 if ($dearnInt == 0) {
		 	$dearnInt = 1;
		 }
		 $monthly = $dearnInt*30;
		 $dpview=$row[dpview];
		 $dpviewInt = intval($dpview);
		 $dpviewInt = $dpviewInt / 11;
		 $dpviewInt = round($dpviewInt);
		 if ($dpviewInt < 20) {
		 	$dp = '< 20';
		 } else {
		 	$dp = $dpviewInt;
		 }
	$xml = $xml."<domain><name>".$domain."</name><cost>".$worthInt."</cost><daily>".$dearnInt."</daily><monthly>".$monthly."</monthly></domain>\n";
};
mysql_close($con);

$xml = $xml."</sites>";


echo $xml;

?>