<?

include ("config.php");
$domain = $_GET['domain'];
$sql = "SELECT id FROM worth WHERE domain = '$domain' LIMIT 1";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$id = $row[id];
	echo $id;
}
mysql_close($con);

?>