<?
include("config.php");
$domain = $_GET["domain"];
$sql = "SELECT datetime FROM worth WHERE domain = '".mysql_real_escape_string($domain)."'";
$rs_result = mysql_query($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$date=$row[datetime];
	$exp = floor((mktime()-strtotime($date))/86400);
}
echo $exp;
mysql_close($con);
?>
