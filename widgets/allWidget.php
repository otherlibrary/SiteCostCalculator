<?php
include ("config.php");
$domain = $_GET['domain'];
$lang = $_GET['lang'];
if ($lang) {
include("../".$lang.".php");
} else {
include("../en.php");
}
$color = $_GET['color'];
if (!$color) {
	$color = "EDF8FC";
}
function endings($n, $form1, $form2, $form5) {
$n = abs($n) % 100;
$n1 = $n % 10;
if ($n > 10 && $n < 20) return $form5;
if ($n1 > 1 && $n1 < 5) return $form2;
if ($n1 == 1) return $form1;
return $form5;
}
$sql = "SELECT * FROM worth WHERE domain = '$domain' LIMIT 1";
$rs_result = mysql_query ($sql); 
while ($row = mysql_fetch_assoc($rs_result)) { 
		 $worth=$row[worth];
		 $worthInt = intval($worth);
		 if ($worthInt < 100) {
			$worthInt = $worthInt + 100;

		 }
		 $dpview=$row[dpview];
		 $dpviewInt = intval($dpview);
		 $dpviewInt = $dpviewInt / 11;
		 $dpviewInt = round($dpviewInt);
		 if ($dpviewInt < 20) {
		 	$dp = '< 20';
		 } else {
		 	$dp = $dpviewInt;
		 }
		 $dearn=$row[dearn];
		 $dearnInt = intval($dearn);
		 $dearnInt = $dearnInt * 11;		 
		 if ($dearnInt == 0) {
		 	$dearnInt = 1;
		 }
		 $yahoo_back=$row[yahoo_back];
		 $pagerank=$row[pagerank];
		 $alexa=$row[alexa];
		 $country=$row[country];
		 $ip=$row[ip];
		 $age=$row[age];
		 $yahoodir=$row[yahoodir];
		 $dmoz=$row[dmoz];
		 
		 if (!$yahoo_back) {
		 	$yahoo_back = "without";
		 }
		 if (!$pagerank) {
		 	$pagerank = "0";
		 }
		 if (!$alexa) {
		 	$alexa = "Unknown";
		 }
		 if (!$age) {
		 	$age = "Undefined";
		 }
		 if (!$country) {
		 	$country = "undefined country";
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
if ($mainDomain == 'costofwebsite.net') {
	$href = 'CostOfWebsite.net';
}
if ($mainDomain == 'sitecostcalculator.ru') {
	$href = 'SiteCostCalculator.ru';
}

$at1 = $g5;
$at2 = $g6;
$at3 = $g7;
$at4 = "";
$at5 = $g2." <b>".number_format($alexa, 0, ',', ',')."</b> ".$g3;

if ($age != 'Unknown') {
	$tAge = $g4." <b>".$age."</b>";
} else {
	$tAge = "";
}
if ($yahoo_back != 'without') {
	$tBacks = $g8." <b>".number_format($yahoo_back, 0, ',', ',')."</b> ".$g9;
} else {
	
}
if ($tAge) {
	$and = $g10;
}
$t1 = $g11." ".$country." ".$g12;
$t2 = "International sites with PR";
$t3 = $g13." ".$country."";
$yahooD = $yahoodir;

$at6 = $tAge.$and.$tBacks;
$tt = $g14;
$xml = $g15;

if ($age != 'Unknown') {
	list($ageYears, $ageYearsStr, $ageDays, $ageDaysStr) = explode(' ', $age);
	$ageStr = $ageYears." ".endings($ageYears, $ageYears1, $ageYears2, $ageYears5)." ".$ageDays." ".endings($ageDays, $ageDays1, $ageDays2, $ageDays5);
	$tAge = $g4." <b>".$ageStr."</b>";
} else {
	$tAge = "";
	$ageStr = $ageNot;
}

 
echo "document.write(\"<div style='background-color:#".$color.";width:200px;border:1px solid #D0D0D0;'><center>\");
		document.write(\"<div style='font-size:15pt;'><b>".$domain."</b></div>\");
		document.write(\"<div style='font-size:18pt;padding-top:7px;'><font color='green'><b>$".number_format($worthInt, 0, '.', ',')."</b></font></div>\");
		document.write(\"<div style='font-size:8pt;padding-top:8px;'><a href='http://".$mainDomain."/'>".$href."</a></div>\");		
	document.write(\"</center></div>\");";


?>