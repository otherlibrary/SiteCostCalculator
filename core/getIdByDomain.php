<?
include("config.php");
$domain = $_GET['domain'];
if (!$domain) {
	echo "bad-1";
	return;
}
$sql = "SELECT id FROM worth WHERE domain = '$domain'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$id = $row[id];
}
mysql_close($con);
if ($id) {
	echo $id;
	return;
} else {
	echo "bad-2";
}
?>