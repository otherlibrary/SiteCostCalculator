<?
require "translate.php";
include ("config.php");
$domain = $_GET['domain'];
$lang = $_GET['lang'];
$sql = "SELECT * FROM worth WHERE domain = '$domain' LIMIT 1";
$rs_result = mysql_query ($sql); 
while ($row = mysql_fetch_assoc($rs_result)) { 
	$alexa=$row[alexa];
}
mysql_close($con);
$t1 = "My site's has ranking";
$t2 = "Do you have higher?";

$tr = new Google_Translate_API;
$t1 = $tr->translate("My site's has ranking", "en", $lang);
$t2 = $tr->translate('Do you have higher?', 'en', $lang);

echo "document.write(\"<div style='width:177px;height:77px;background-image:url(http://sitecostcalculator.com/widgets/alexaWidget.png);'><center>\");
	document.write(\"<div style='font-size:9pt'>".$t1."</div>\");
	document.write(\"<div style='font-size:12pt;'><b>".$alexa."</b></div>\");
	document.write(\"<div style='font-size:10pt;'>".$t2."</div>\");
	document.write(\"<div style='font-size:8pt;padding-top:8px;'>by <a href='http://sitecostcalculator.com/'>SiteCostCalculator.com</a></div>\");		
	document.write(\"</div>\");";

?>