<?
include ("config.php");
$lang = $_GET['lang'];
if ($lang) {
include("../".$lang.".php");
} else {
include("../en.php");
}
$domain = $_GET['domain'];
$lang = $_GET['lang'];
$sql = "SELECT * FROM worth WHERE domain = '$domain' LIMIT 1";
$rs_result = mysql_query ($sql); 
while ($row = mysql_fetch_assoc($rs_result)) { 
	 $dpviewInt = intval($row[dpview]);
if ($dpviewInt > 10000) {
	 $dpviewInt = $dpviewInt / 11;
	 $dpviewInt = round($dpviewInt);
}
	 if ($dpviewInt < 20) {
	 	$dp = '~ 20-50';
	 } else {
	 	$dp = $dpviewInt;
	 }
}
mysql_close($con);

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

if ($mainDomain == 'sitecostcalculator.com') {
	$href = 'SiteCostCalculator.com';
} 
if ($mainDomain == 'websitepricecalculator.net') {
	$href = 'WebsitePriceCalculator.net';
} 
if ($mainDomain == 'websitecostcalculator.com') {
	$href = 'WebsiteCostCalculator.com';
} 
if ($mainDomain == 'websitetrafficcalculator.com') {
	$href = 'WebsiteTrafficCalculator.com';
} 
if ($mainDomain == 'websiteworthcalculator.net') {
	$href = 'WebsiteWorthCalculator.net';
}
if ($mainDomain == 'websitecost.info') {
	$href = 'WebsiteCost.info';
}

echo "document.write(\"<div style='width:177px;height:77px;background-image:url(http://sitecostcalculator.com/widgets/dpviewWidget.png);'><center>\");
	document.write(\"<div style='font-size:9pt'>".$mySiteHas."</div>\");
	document.write(\"<div style='font-size:12pt;'><b>".$dp."</b></div>\");
	document.write(\"<div style='font-size:12pt;'>".$visitorsPerDay."</div>\");
	document.write(\"<div style='font-size:8pt;padding-top:8px;'>by <a href='http://".$mainDomain."/'>".$href."</a></div>\");		
	document.write(\"</div>\");";

?>