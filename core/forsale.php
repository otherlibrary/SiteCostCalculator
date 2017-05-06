<?php
$lang = $_GET['lang'];
if ($mainTitle2 == 'SiteCostCalculator.ru') {
	$lang = 'ru';
}
if ($lang) {
include($lang.".php");
} else {
include("en.php");
}
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
$newRu = str_replace ($mainDomain, "sitecostcalculator.ru", curPageURL());
$newEn = str_replace ($mainDomain, "sitecostcalculator.com", curPageURL());
$mainTitle1 = "";
$mainTitle2 = "";

if ($mainDomain == 'sitecostcalculator.com') {
	$mainTitle1 = 'Site Cost Calculator';
	$mainTitle1_ = 'Site Cost Calculator v2.0';
	$mainTitle2 = 'SiteCostCalculator.com';
	$customKey = 'site cost calculator';
	$homePage = "http://sitecostcalculator.com";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1_."</font></a><br></div>";
} 
if ($mainDomain == 'websitepricecalculator.net') {
	$mainTitle1 = 'Website Price Calculator';
	$mainTitle2 = 'WebsitePriceCalculator.net';
	$customKey = 'website price calculator';
	$homePage = "http://websitepricecalculator.net";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websitecostcalculator.com') {
	$mainTitle1 = 'Website Cost Calculator';
	$mainTitle2 = 'WebsiteCostCalculator.com';
	$customKey = 'website cost calculator';
	$homePage = "http://websitecostcalculator.com";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websitetrafficcalculator.com') {
	$mainTitle1 = 'Website Traffic Calculator';
	$mainTitle2 = 'WebsiteTrafficCalculator.com';
	$customKey = 'website traffic calculator';
	$homePage = "http://websitetrafficcalculator.com";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websiteworthcalculator.net') {
	$mainTitle1 = 'Website Worth Calculator';
	$mainTitle2 = 'WebsiteWorthCalculator.net';
	$customKey = 'website worth calculator';
	$homePage = "http://websiteworthcalculator.net";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websitecost.info') {
	$mainTitle1 = 'Website Cost';
	$mainTitle2 = 'WebsiteCost.net';
	$customKey = 'website cost';
	$homePage = "http://websitecost.info";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br></div>";
}
if ($mainDomain == 'costofwebsite.net') {
	$mainTitle1 = 'Cost Of Website';
	$mainTitle2 = 'CostOfWebsite.net';
	$customKey = 'cost of website';
	$homePage = "http://costofwebsite.net";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br><br></div>";
}
if ($mainDomain == 'sitecostcalculator.ru') {
	$mainTitle1 = 'Калькулятор стоимости сайта';
	$mainTitle2 = 'SiteCostCalculator.ru';
	$customKey = 'калькулятор стоимости сайта, сколько стоит мой сайт, цена сайта';
	$homePage = "http://sitecostcalculator.ru";
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br></div>";
}
include("config.php");
$sql = "SELECT worth, sccCost FROM worth WHERE domain = 'kishlaly.com' LIMIT 1";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$w = $row[worth];
	$sccCost = $row[sccCost];
	$worthInt = intval($w);
	$worthInt = worthInt * 3;
	if ($worthInt == 0) {
	 	$worthInt = 100;
	}
}
	$customTitle =  $n100." ".$mainTitle2.": ";
	$customTitle2 = $n101;
$title= "<b>".$saleKeys3."</b>: kishlaly.com ".$saleTitle_." $".number_format($sccCost, 0, ',', ',')."; ".$saleTitle2_." $".number_format($worthInt, 0, ',', ',');
$keys = "<b>".$saleKeys4."</b>: kishlaly.com ".$saleTitle_2.", "."kishlaly.com ".$saleKeys1.", ".$saleKeys2." kishlaly.com";
?>
<center>
<div id="sale" style="width:1150px;position:relative;">
<center><font style="font-family: georgia, serif; font-size:17pt;"><? echo $forsale1; ?></font></center><br><br>
<font style="font-family: georgia, serif; font-size:11pt;">
<?
				echo "<table style=\"width:100%; float:left;\"><translate><td>
					".$sale9. ".$sale10.".<br>
					".$sale11." <a href=\"http://".$mainTitle2."/www.".$domain."\" target=\"_blank\">http://".$mainTitle2."/www.".$ys."</a> ".$sale12.".<br><br>
					".$sale13.".<br><br>
				</td><translate></table>
					<table style=\"width:50%; float:left;\">
						<translate><td align=\"center\"><b>".$sale14."</b>:</td></translate>
						<translate><td>&nbsp;</td></translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.language</b>' content='<b>".$sale15."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.cost</b>' content='<b>".$sale16."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.email</b>' content='<b>".$sale17."</b>' /&gt;</td>
						</translate>
						<translate><td>&nbsp;</td></translate>
						<translate><td align=\"center\"><b>".$sale31."</b>:</td></translate>
						<translate><td>&nbsp;</td></translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.cause</b>' content='<b>".$sale18."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.monthlyincome</b>' content='<b>".$sale20."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.monthlyout</b>' content='<b>".$sale20_."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.incometypes</b>' content='<b>".$sale21."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.jabber</b>' content='<b>".$sale23."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.skype</b>' content='<b>".$sale24."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.icq</b>' content='<b>".$sale25."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.phone</b>' content='<b>".$sale26."</b>' /&gt;</td>
						</translate>
						<translate>
							<td>&nbsp;</td>
						</translate>
					</table>
					<table style=\"width:50%; float:left;\">
						<translate>
							<td align=\"left\"><b>".$sale_eg."</b></td>
						</translate>
						<translate>
							<td align=\"left\">&nbsp;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.language'</b>' content='<b>".$sale_loc."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.cost</b>' content='<b>1000</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.email</b>' content='<b>vladimir.kishlaly@gmail.com</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.cause</b>' content='<b>".$sale19." ".$mainTitle2."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.monthlyincome</b>' content='<b>100</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.monthlyout</b>' content='<b>15</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.incometypes</b>' content='<b>".$sale22."</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.jabber</b>' content='<b>test_jabber</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.skype</b>' content='<b>vladimir.kishlaly</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.icq</b>' content='<b>273786093</b>' /&gt;</td>
						</translate>
						<translate>
							<td align=\"left\">&lt;meta name='<b>scc.phone</b>' phone='<b>+390661234567</b>' /&gt;</td>
						</translate>
					</table>
					<table style=\"width:100%; float:left;\">
						<translate><td>&nbsp;</td></translate>
						<translate><td><b>".$saleEx1." <a href=\"http://".$mainTitle2."/www.kishlaly.com\" target=\"_blank\">".$saleEx2."</a></b></td></translate>
						<translate><td>".$title."</td></translate>
						<translate><td>".$keys."</td></translate>
						<translate><td>&nbsp;</td></translate>
						<translate>
							<td>
								".$sale27." ".$sale28." ".$sale29." <a href=\"index.php?fs=true\">".$sale30."</a>.<br>
								".$forsale2.":<br><br>
							</td>
						</translate>
						<translate>
							<td>
								http://<input type=\"text\" id=\"updateT\" size=\"15\" onKeyPress=\"if (event.keyCode==13) { ScrollToElement(document.getElementById('updateTw')); updateTags(); }\">&nbsp;&nbsp;&nbsp;<input id=\"updB\" name=\"updB\" type=\"button\" value=\"".$saleRefresh."\" onclick=\"ScrollToElement(document.getElementById('updateTw')); updateTags();\">&nbsp;<span id=\"updateNew\"></span><br><br>
								<span id=\"updateTw\"></span><br>
							</td>
						</translate>
					</table>
				</span>"; 
?>
</font>
<br><br><br><br>
</div>
</center>
<?
mysql_close($con);
?>
</body>