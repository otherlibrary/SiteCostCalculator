<?php
//include ("config.php");

//$IP = $row["ip"];  // debug only

//$ipv2=country();

//echo $ipv2;

//echo $ipv;

//$result = mysql_query( "SELECT * FROM worth   LIMIT 17" )

  $result = mysql_query("SELECT * FROM worth WHERE country LIKE  '%$country%' ORDER BY alexa ASC LIMIT 17");

echo "<center>Top <b>".$country. "</b> sites in our Database:<br><br>";
while($row=mysql_fetch_array($result))

{ 

$ipr=$row["domain"];

echo "<a href='www.$ipr'>www.$ipr</a><br>";    

 }
echo "</center>";

?>