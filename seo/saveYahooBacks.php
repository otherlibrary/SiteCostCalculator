<?
include 'class.seostats.php';
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
$seo = new SEOstats('http://'.$domain);
$linksTotal = $seo->Yahoo_Backlinks_Total();
if ($linksTotal != 'error' && $linksTotal != '0') {
$googleBackLinksArray = $seo->Yahoo_Backlinks_Array();
$arr = array();
$count = 0;
foreach ($googleBackLinksArray as $link) {
    preg_match("/^(http:\/\/)?([^\/]+)/i", $link['URL'], $matches);
    $host = $matches[2];
    preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
    $mainDomain = "{$matches[0]}";
    $arr[$count] = $mainDomain;
    $count++;
}
$backsOut = "";
$q=array_count_values($arr);
foreach ($q as $k=>$v) {
	$backsOut .= "".$k." (".$v."),";
} 
$backsOut .= $backsOut.$linksTotal;
	$sql = "UPDATE worth SET worth.yahoo_links = '$backsOut' WHERE domain='$domain' LIMIT 1";
	$rs_result = mysql_query($sql);
} else {
	$sql = "UPDATE worth SET worth.yahoo_links = '0' WHERE domain='$domain'";
	$rs_result = mysql_query($sql);

}
mysql_close($con);
?>