<?php ini_set('max_execution_time', 180);
include ("config.php");
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

preg_match("/^(http:\/\/)?([^\/]+)/i", curPageURL(), $matches);
$host = $matches[2];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

$mainDomain = "{$matches[0]}";
$domain = $_GET['domain'];
$pr = file_get_contents('http://'.$mainDomain.'/seo/getPr.php?domain='.$domain);
echo $pr;
if ($pr != 'error') {
  $sql = "UPDATE worth SET worth.pagerank = $pr WHERE domain='$domain'";
}
$rs_result = mysql_query($sql);
$cDate = date('Y-m-d H:i:s');
$sql2 = "UPDATE worth SET worth.cDate = '".mysql_real_escape_string($cDate)."' WHERE domain='$domain'";
$rs_result2 = mysql_query($sql2);
mysql_close($con);
?>