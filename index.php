<?
$dobattle_ = $_GET['dobattle'];

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
	$mainTitle1_ = 'Site Cost Calculator 2.4';
	$mainTitle2 = 'SiteCostCalculator.com';
	$customKey = 'site cost calculator';
	$homePage = "http://sitecostcalculator.com";
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1_."</font></a><br></div>";
} 
if ($mainDomain == 'websitepricecalculator.net') {
	$mainTitle1 = 'Website Price Calculator';
	$mainTitle2 = 'WebsitePriceCalculator.net';
	$customKey = 'website price calculator';
	$homePage = "http://websitepricecalculator.net";
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websitecostcalculator.com') {
	$mainTitle1 = 'Website Cost Calculator';
	$mainTitle2 = 'WebsiteCostCalculator.com';
	$customKey = 'website cost calculator';
	$homePage = "http://websitecostcalculator.com";
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websitetrafficcalculator.com') {
	$mainTitle1 = 'Website Traffic Calculator';
	$mainTitle2 = 'WebsiteTrafficCalculator.com';
	$customKey = 'website traffic calculator';
	$homePage = "http://websitetrafficcalculator.com";
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websiteworthcalculator.net') {
	$mainTitle1 = 'Website Worth Calculator';
	$mainTitle2 = 'WebsiteWorthCalculator.net';
	$customKey = 'website worth calculator';
	$homePage = "http://websiteworthcalculator.net";
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1."</font></a><br></div>";
} 
if ($mainDomain == 'websitecost.info') {
	$mainTitle1 = 'Website Cost';
	$mainTitle2 = 'WebsiteCost.net';
	$customKey = 'website cost';
	$homePage = "http://websitecost.info";
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1."</font></a><br></div>";
}
if ($mainDomain == 'costofwebsite.net') {
	$mainTitle1 = 'Cost Of Website';
	$mainTitle2 = 'CostOfWebsite.net';
	$customKey = 'cost of website';
	$homePage = "http://costofwebsite.net";
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1."</font></a><br><br></div>";
}

if ($mainDomain == 'sitecostcalculator.ru') {
	$mainTitle2 = 'SiteCostCalculator.ru';
	$homePage = "http://sitecostcalculator.ru";
}
if ($mainDomain != 'sitecostcalculator.ru') {
	$ads_ = " href=\\";
	$leads = "<script type=\"text/javascript\" src=\"http://forms.aweber.com/form/39/121062939.js\"></script>";
}
$lang = $_GET['lang'];
if ($mainTitle2 == 'SiteCostCalculator.ru') {
	$lang = 'ru';
}
if ($lang) {
include($lang.".php");
} else {
$lang = "en";
include("en.php");
}
if ($mainTitle2 == 'SiteCostCalculator.ru') {
	$mainTitle1 = $mf1;
	$customKey = $mf2;
	$logo = "<div id='logo'><a href='$homePage'><font style='font-family: georgia, serif; font-size:24pt;'>".$mainTitle1."</font></a><br></div>";
	$sms = "<br><br><font style='font-family: georgia, serif; font-size:12pt;'><b>Совет дня</b></font><br><font style='font-family: georgia, serif; font-size:11pt;'><a href='https://market.android.com/details?id=com.mile.android.smsfilter' target='_blank'>Простой, удобный и бесплатный спам-фильтр для смс под Android</a></font><br>
		<font style='font-family: georgia, serif; font-size:12pt;'>и еще<br></font><font style='font-family: georgia, serif; font-size:11pt;'><a href='https://market.android.com/details?id=com.mile.android.gotasks' target='_blank'>Синхронизация с Google Tasks</a></font>";
}
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="verifyownership" content="fb04aee5557f19eaecf6914e26514f1f" />
<title><?
$d = $_GET['d'];
$fs = $_GET['fs'];
$fsh = $_GET['fsh'];

if ($d) {

$sql = "SELECT worth, sccCost FROM worth WHERE domain = '$d' LIMIT 1";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$w = $row[worth];
	$sccCost = $row[sccCost];
	$worthInt = intval($w);
	$worthInt = $worthInt * 3;
	if ($worthInt == 0) {
	 	$worthInt = 100;
	}
}
	$customTitle =  $n100." ".$mainTitle2.": ";
	$customTitle2 = $n101;
}
$titleOut = "";
if ($fs) {
	$titleOut = $mainTitle1." - ".$fsTitle;
} else
if ($fsh) {
	$titleOut = $mainTitle1." - ".$fshTitle;
} else
	if ($customTitle && $worthInt > 0) {
		if ($sccCost) {
			$titleOut = $d." ".$saleTitle_." $".number_format($sccCost, 0, ',', ',')."; ".$saleTitle2_." $".number_format($worthInt, 0, ',', ',');
			$keysD = $d." ".$saleTitle_2.", ".$d." ".$saleKeys1.", ".$saleKeys2." ".$d;
		} else {
			$titleOut = $d." ".$customTitle2." $".number_format($worthInt, 0, ',', ',').", ".$n100." ".$mainTitle2;
		}
	} else {
$battleshow = $_GET['battle'];
		if ($dobattle_ || $battleshow) {

$splitted = explode(',', $dobattle_);
$filtered = array_unique($splitted);

foreach ($filtered as $key => $link) {
    if (strlen($filtered[$key]) < 4 || (strrpos($filtered[$key], ".") === false)) {
        unset($filtered[$key]);
    }
}

$tA = str_replace("," , " VS ", implode(',', $filtered));

			$titleOut = $mainTitle1." - ".$nBattle." ".$tA;
		} else {
			$titleOut = $mainTitle1." - ".$n102;
		}
	}
echo $titleOut;
$keys_ = ($keysD) ? $keysD : $customKey;
?></title>
<meta name='keywords' content='<? echo $keys_.", ".$f1; ?>' />
<meta name='description' content='<? echo $f2; ?>' />
<link rel=alternate type=application/rss+xml title=RSS href=RSS/index.php>
<link href="core/whois.css" rel="stylesheet" type="text/css" />
<link href="widgets/modalbox.css" rel="stylesheet" type="text/css" />
<link href="pagination.css" rel="stylesheet" type="text/css">
<script src="js/onload.js" type="text/javascript"></script>
<script type="text/javascript" src="js/rounded-corners.js"></script>
<script type='text/javascript' src='js/common.js'></script>
<script type="text/javascript" src="u.js"></script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7412096-19']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_trackPageLoadTime']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script type="text/javascript" src="js/prototype.js"> <!--
//--> </script>
<style type="text/css">

.sprites {
    background: transparent url(csg-4ee23434bf328.png) no-repeat;
}
 
 #blogger_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -132px; 
 } 
 
 #Buzz_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 0
 } 
 
 #chrome_png { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -198px;
 } 
 
 #delicious_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -376px;
 } 
 
 #digg_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -442px;
 } 
 
 #email_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -508px;
 } 
 
 #en_png { 
    height               : 32px; 
    width                : 32px;
    background-position  : 0 -574px;
 } 
 
 #facebook_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -656px;
 } 
 
 #firefox_png { 
    height               : 128px; 
    width                : 128px; 
    background-position  : 0 -722px;
 } 
 
 #flex_png { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -900px;
 } 
 
 #friendfeed_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -1078px;
 } 
 
 #google_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  :  0 -1144px;
 } 
 
 #GoogleReader_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -66px;
 } 
 
 #linkedin_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -1210px;
 } 
 
 #myspace_gif { 
    height               : 16px;
    width                : 16px; 
    background-position  : 0 -1276px;
 } 
 
 #new_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -1342px;
 } 
 
 #reddit_gif { 
    height               : 128px; 
    width                : 128px; 
    background-position  : 0 -1406px;
 } 
 
 #ru_png { 
    height               : 32px;
    width                : 32px; 
    background-position  : 0 -1538px; 
 } 
 
 #share-buttons_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -1620px;
 } 
 
 #stumbleupon_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -1686px;
 } 
 
 #twitter_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -1752px;
 } 
 
 #yahoobuzz_gif { 
    height               : 16px; 
    width                : 16px; 
    background-position  : 0 -1818px;
 } 

table.cool {
border-collapse:collapse;
background:#EFF4FB url(teaser.gif) repeat-x;
border-left:1px solid #686868;
border-right:1px solid #686868;
font:0.8em/145% 'Trebuchet MS',helvetica,arial,verdana;
color: #333;
}
td.cool, th.cool {
text-align:center;
}
caption {
padding: 0 0 .5em 0;
text-align: left;
font-size: 1.4em;
font-weight: bold;
text-transform: uppercase;
color: #333;
background: transparent;
}
table.cool a {
color:green;
text-decoration:none;
}
table.cool a:hover {
border-bottom: 1px dashed #bbb;
}
thead.cool th, tfoot.cool th, tfoot.cool td {
background:#333 url(llsh.gif) repeat-x;
color:#fff
}
tfoot.cool td {
text-align:right
}
tbody th.cool, tbody td.cool {
border-bottom: dotted 1px #333;
}
tbody th {
white-space: nowrap;
}
tbody th a {
color:#333;
}
.odd {}
tbody.cool tr:hover {
background:#fafafa
}
</style>
<script type="text/javascript">
	var saleUpd1 = "<? echo $saleUpd1; ?>";
	var saleUpd2 = "<? echo $saleUpd2; ?>";
	var saleUpd3 = "<? echo $saleUpd3; ?>";
	var mainTitle = "<? echo $mainTitle2; ?>";
	var lang = "<? echo $lang; ?>";
	var saleUpd1 = "<? echo $saleUpd1; ?>";
	var saleGood = "<? echo $saleGood;  ?>";
	var unsale = "<? echo $unsale; ?>";
	var f3 = "<? echo $f3; ?>";
	var f4 = "<? echo $f4; ?>";
	var f4_ = "<? echo $f4_; ?>";
	var f4__ = "<? echo $f4__; ?>";
	var f3_ = "<? echo $f3_; ?>";
	var add1 = "<? echo $add1; ?>";
	var add2 = "<? echo $add2; ?>";
	var add2_ = "<? echo $add2_; ?>";
	var add3 = "<? echo $add3; ?>";
	var add4 = "<? echo $add4; ?>";
	var add2_ = "<? echo $add2_; ?>";
	var logo = "<? echo $logo; ?>";
	var processing = "<? echo $f4; ?>";
</script>
<script type="text/javascript" src="js/main-min.js"></script>
<script type="text/javascript" src="js/csite.js"></script>
<!-- Quantcast Tag -->
<script type="text/javascript">
var _qevents = _qevents || [];

(function() {
var elem = document.createElement('script');
elem.src = (document.location.protocol === "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
})();

_qevents.push({
qacct:"p-77YFQ0Mm3_8F2"
});
</script>

<noscript>
<div style="display:none;">
<img src="//pixel.quantserve.com/pixel/p-77YFQ0Mm3_8F2.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->
</head>
<body>
<NOSCRIPT>
<center>
<? echo $f6; ?>
</center>
</NOSCRIPT>
<center>
<div style="width:1280px;position:relative;">
	<div id='lastCalculated' style="width:313px;height:440px;position:absolute;top:0;left:0;">
		<span id="lastTitle" style="font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold;"><b><? echo $f7; ?></b></span>
	</div>	
	<div style="width:645px;">
<?
$langStrEn = "<div class=\"sprites\" id=\"en_png\"></div>";
$langStrRu = "<div class=\"sprites\" id=\"ru_png\"></div>";
?>
<div style="font-family: georgia, serif; font-size:12pt; background-color:#EDF8FC; width:100%;">
<a href="index.php?fsh=true"><? echo $forSaleHelp; ?></a>&nbsp;|&nbsp;<a href="index.php?fs=true"><? echo $forSaleMainLink; ?></a>&nbsp;|&nbsp;<a href="index.php?battle=true"><font style="color:red"><? echo $battle10; ?></font></a>
<table>
<tr><td><a href="<? echo $newEn; ?>"><? echo $langStrEn; ?></a></td><td>&nbsp;</td><td><a href="<? echo $newRu; ?>"><? echo $langStrRu; ?></a></td>
<td>&nbsp;</td><td>
<div class="a2a_kit a2a_default_style">
	<a class="a2a_dd" href="http://www.addtoany.com/share_save?linkurl=http%3A%2F%2Fwww.<? echo $mainDomain; ?>&amp;linkname=<? echo $shareit; ?>"></a>
</div>
<script type="text/javascript">
	function help() {
		document.getElementById('res').innerHTML = "<center><img src='a.gif'></center>";
		new Ajax.Request('help.php?lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('gohere'));
		  }
		});	
 	}

	function fight(data) {
		document.getElementById('res').innerHTML = "<center><img src='a.gif'></center>";
		new Ajax.Request('fight.php?lang=<? echo $lang; ?>&data=' + data, {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('gohere'));
		  }
		});	
 	}


	function getBattle() {
		document.getElementById('res').innerHTML = "<center><img src='a.gif'></center>";
		new Ajax.Request('battle.php?lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('gohere'));
		  }
		});	
 	}

	function loadComments(domain) {
	      document.getElementById('commbody').style.height = "30px";
	      document.getElementById('commbody').innerHTML = "<center><img src='a.gif'></center>";
		new Ajax.Request('comm.php?lang=<? echo $lang; ?>&domain=' + domain, {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('commbody').style.height = "250px";
		      document.getElementById('commbody').innerHTML = html;
		  }
		});	
 	}


	function addComment(domain) {
		var cName = Url.encode(document.getElementById('commentname').value.replace(/^\s+|\s+$/g,""));
		var cComm = Url.encode(document.getElementById('commenttext').value.replace(/^\s+|\s+$/g,""));
		var cSite = Url.encode(document.getElementById('commentsite').value.replace(/^\s+|\s+$/g,""));
		if (cComm.length < 1) {
		      document.getElementById('commenttext').style.backgroundColor = "#FFE4E1";
		      document.getElementById('commenttext').style.backgroundImage = "none";
		      return;
		}
		new Ajax.Request('addcomm.php', {
		  method:"POST",
		  parameters:"name=" + cName + "&comment=" + cComm + "&site=" + cSite + "&domain=" + domain,
		  onSuccess: function(response) {
		      var res = response.responseText;
		      document.getElementById('addcomment').style.height = "33px";
		      document.getElementById('commok').innerHTML = "<center><img src='ok_s.png'></center>";
		      loadComments(domain);
		  }
		});	
 	}


	function doBattle(data) {
		window.location = "<? echo $homePage; ?>/battle:" + data.replace(/\n/g, ',');
	}

</script>
<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
</td>
</tr>
</table>
</div>
<p>
	<div id="temp" style="display:none;"></div>
	<? echo $logo; ?>
	<div id="total"></div><br>
	<input type="text" class="rc10" name="url" id="url"
		   style="margin-left:10px;margin-right:10px;width: 367px; height: 25px; background-color: rgb(230, 230, 221); border: 1px solid #b4b4b4; font-family: georgia, serif; color: #2a2a2a; font-size:14pt; color: #555555; text-align: center;"
		   onKeyPress="if (event.keyCode===13) { getAll2(); }" />
		   <br><input type="button" value="<? echo $f12; ?>" style="height:25px;" onclick="getAll2();"><br><br>
<center>
<a href="https://addons.mozilla.org/ru/firefox/addon/site-cost-calculator-tool/" target="_blank"><img src="images/firefox.png" class="nob" BORDER=0 title="<? echo $ff__; ?>"></a>&nbsp;
<a href="https://chrome.google.com/webstore/detail/lckfdajgjbgkegjkobheebfkheadbikl" target="_blank"><img src="images/chrome.png" class="nob" BORDER=0 title="<? echo $ch__; ?>"></a><br>

<br><br>
<font style='font-family: georgia, serif; font-size:12pt;'>
Proudly present my new project:</font><br>
<font style='font-family: georgia, serif; font-size:15pt;'><a href="http://simpleamazonsearch.com/" target="_blank">Simple Amazon Search</a></font><br>
<font style='font-family: georgia, serif; font-size:12pt;'>Quick search for the best offers from thousands, without tedous filtering</font><br>
<font style='font-family: georgia, serif; font-size:12pt;'>Get only what you've searched for</font>


<?
//echo $out;
//echo"<br><br><font style='font-family: georgia, serif; font-size:14pt; color:red;'>".$help1_."</font><br><font style='font-family: georgia, serif; font-size:12pt;'><a onclick='help();' style='cursor: pointer; color: blue; text-decoration:underline;'>".$help2_."</a></font><br><br><br><br>";
if ($mainDomain != 'sitecostcalculator.ru') {
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
$lead_ = $_GET['addlead'];
if ($lead_) {
echo "<font style='font-family: georgia, serif; font-size:15pt; color:green;'><br><br><br><br><br><br><br><br><br><br><br><br></font>";
}
} else {
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
}
?></center>

	<div id="sortable" style="width:313px;height:440px;position:absolute;top:0;right:0;"><center>
			<span id="stitle" style="font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold;"><b><? echo $f16; ?></b></span><br>
		</center></div><br>
</div>
<?
$key1 = $_GET['key1'];
if ($key1) {
	echo "<div style=\"width:800px;text-align:left;\"><center><font style='font-family: georgia, serif; font-size:15pt;'>Website Worth</font></center><br><br>" .
			"<font style='font-family: georgia, serif; font-size:11pt;'>" .
			"<p>For those of you who are looking to buy or promote web sites which aren't very extremely valued it would be advisable should you truly determined not solely the sites worth but also just how a lot it's more likely to promote for. It will be significant that you just clearly understand the distinction between a website worth and a web site promoting price. If not you may end up changing into confused and end up selling for a lot less or paying far to much for a website.</p>
			<p>Subsequently earlier than you make the decision to both purchase or promote a website there is one question you should be asking your self first. It can be crucial that instead of asking what you think your web site is worth you have to be realizing the price at which it's prone to go for. Subsequently it could be smart to make the most of a website valuation service so as that you have the fitting data to hand. On this article we clarify why using the services of an internet site valuer are important particularly in case you are looking to earn cash online via buying and promoting websites.</p>
			<p>A website valuer or appraiser will take plenty of different factors into consideration some of which we will have a look at additional on in this article. However the primary ones that they look at is the cash stream situation and just how much revenue the site is actually making. But be warned with regards to figuring out a web sites value the strategies used are usually not accurate.</p>
			<p>But as well as sure numbers being taken into consideration when an internet site needs to be valued there are other factors that must be considered also. For example a site which is in high demand due to its name or as a result of it has excessive quantities of site visitors will command a much greater worth than one that does not. Additionally these sites that are in a position to generate a high degree of revenue automatically for the proprietor will command a high value as well. However those websites which don't as a result of they want work carried out to them first will not.</p>
			<p>An individual who is definitely building their own web site may use the providers of a website appraiser to see simply whether the work they've carried out on it is working for them or not. For those who build their very own web sites and then choose to sell them on the open market truly using this service can show to be invaluable and help them to command a much higher promoting price. However in an effort to worth the website correctly the appraiser needs to hold out a research first.</p>
			<p>It's throughout this study period that the valuer will take a close take a look at numerous various factors which give the final valuation figure. They'll have a look at what income if any the positioning is producing each at present and in its past. They take a look at what customer base the site has and whether this is increasing, reducing or is remaining static. They give the impression of being closely at the security controls the proprietor of the website has in place and can carry out some research into any known rivals to the site.</p>
			<p>For individuals who are interested in earning profits by shopping for websites to then promote on (flip) for a profit it's advisable that they use the services of an expert web site valuer. Unfortunately there are many web site sellers who will over inflate the costs of their sites with a purpose to flip a quick buck and the location won't truly be worth the paper it is written on. Some sellers simply place a value against the website they are promoting just to see if they get any interest in it. However by using the providers of a web site valuer it is possible for you to to clearly see whether it is a viable choice or not.</p>
			<p>Not too long ago me and my spouse Kelly went to the financial institution in order to consolidate our debt. We are attempting to eliminate all the loans/credit cards that we have and create just one large mortgage that we will concentrate on paying off. This may clear our headspace and make paying off our debt easier. It was a lot too troublesome having so many different smaller loans and it made our debt overwhelming. One of many issues that we needed to do in an effort to be authorised for the brand new mortgage was to calculate the entire internet value of every thing that we owned. We needed to mix the value of our cars, our rings, my pc, and all the opposite stuff that we own.</p>
			<p>In case your website is half decent then I am certain there might be somebody who's keen to buy it from you. The perfect place to sell your web site is sitepoint.com and there are folks selling websites for upwards of $a hundred,000 on sitepoint so you may make some huge cash from creating and promoting websites. So I bet you wish to know how you can make your website your most useful asset. I'm going to allow you to in on the major things that folks search for when they are shopping for a web site and how you can make your website extra valuable.</p>
			<p>Building constant traffic is without doubt one of the finest methods to extend the value of your website.</p>
			<p>Another great way to increase the value of your web site is to achieve RSS subscribers. One web site might have 10,000 pageviews per month but no subscribers and can promote for beneath the $1,000 mark. Take that same web site and give it 1,000+ RSS subscribers and it'll promote for $10,000+. You possibly can build RSS subscribers by writing great content and by placing your RSS subscription possibility in a distinguished place concerning the fold in your website. You may also offer people a freebie for subscribing via RSS or better yet you need to use a electronic mail administration program to build your RSS subscribers.</p>
			<p>I discussed above that you need to use an email administration program to construct your RSS subscribers. Using this method is perfect because you not only get extra RSS subscribers however you get e-mail e-newsletter subscribers that are even more valuable than RSS subscribers. You can build you e-newsletter subscribers by creating a freebie and placing a signup form within the sidebar of your website. You may as well create a squeeze web page and use regular traffic building strategies to achieve subscribers.</p>
			<p>More than traffic and RSS/Newsletter subscribers revenue will get people over the line into shopping for your website. Websites usually sell for about 10 months revenue, so in case you are making $1,000/month will probably be straightforward to promote your web site for $10,000. There are numerous alternative ways you may construct revenue by your website. You know the way they are saying you'll be able to't decide a guide by its cover? Effectively most people do choose books by their covers and so they also judge websites by the best way they look. If your web site seems unhealthy to you it will additionally look bad to prospects and due to this fact potential buyers. The higher your web site appears the more it would go for.</p>" .
			"</font>" .
			"</div>";
}
$key2 = $_GET['key2'];
if ($key2) {
	echo "<div style=\"width:800px;text-align:left;\"><center><font style='font-family: georgia, serif; font-size:15pt;'>Website Value</font></center><br><br>" .
			"<font style='font-family: georgia, serif; font-size:11pt;'>" .
			"<p>Nevertheless, if you're asking how a lot an internet site will value, you might be asking the unsuitable question. After I get requested this question, my response is always the identical, \"How much value do you are feeling your website will bring to your business.\" To find out how much a website will cost, have a look at what you anticipate to achieve by having a website. For instance, if you happen to personal a pizza store, how much income do you anticipate the website will generate in new business? Likelihood is the web site shouldn't be going to generate an additional $10,000 a year. The more doubtless state of affairs is that the website will help generate a further $500 - $1,000 in new business. So how much must you spend on a brand new website? I might say it is best to spend $500 - $1,000 for the new web site; in all probability favoring the lesser amount.</p>
			<p>Quite the opposite, what if need to launch an eCommerce web site the place you're hoping to promote $200,000 of inventory a 12 months? Nicely in case you suppose spending $2,500 for an eCommerce web site will yield $200k in annual revenue, then you might want to rethink the realities of situation. Think about this logically - if investing $2,500 might flip into $200k in income, don't you suppose everybody could be doing it? The opposite pitfall individuals are inclined to fall into when trying to determine how much an internet site will cost is to ask individuals they understand how much they spent for his or her website. The issue is they do not take note of the type of website the opposite individuals have in addition to the purpose of the website. In the event you ask somebody how much they spent they usually let you know $400, you may want to dig a bit of deeper. Is this other particular person's web site actually just there to supply primary contact information and directions to the office? How way back was the website developed? Does s/he feel the web site has benefited him/her?</p>
			<p>It's all too common for somebody to inform me that s/he spent a couple of hundred dollars on an internet site and feel prefer it was a waste because the website by no means appeared to yield any business. This goes again to identifying the potential value of the website first and making a funds that's in direct proportion to this value. In case your budget was properly beneath the potential worth of the website, this could possibly be the basis cause why it by no means yielded you new business. I had a gathering once with a physician who has a \"concierge\" medical practice. This is a practice the place patients pay an upfront charge out of pocket; this charge then provides sufferers with a guaranteed identical-day or next-day appointment when they're sick, the physician's cellular phone quantity, and the actual time spent with the doctor is between a half-hour to a full hour.</p>
			<p>For this explicit physician, each new patient pays $1,200 a year to the medical practice. After some discussions, we determined that the web site may conservatively yield two new patients a month. This represents a possible $28,800 a year in \"concierge\" fees; and this does not include the income from the patient's insurance for the precise doctor's go to, lab assessments, etc. So how much would ought to this doctor spend on an internet site? Unfortunately he had buddy who spent $1,000 on a website, in order that was the funds he felt he ought to spend. The good friend's website was not associated to his business in any method, but he lost give attention to the value. I needed to respectfully decline the chance as a result of I knew that for $1,000, I could not produce a website that will meet his expectations and possibly would haven't yielded one new patient.</p>
			<p>As a side be aware, the aforementioned assembly came about six months ago and the physician has yet to launch his website. My guess is that he's nonetheless in search of someone who can design knowledgeable website that clearly delivers a very distinctive marketing message, all for $1,000. So when you have a business and suppose it's time to launch an organization website, do not spend time getting quotes from net design corporations to determine how a lot the new site goes to price you. First, determine the worth the web site will deliver you and your business. After you have completed this, then it is time to get prices from numerous designers.</p>
			<p>A good internet design firm will find out about your small business first and work with you to create a proposal that is inline with the value the location will bring. You may discover that buying a $20 predesigned template and internet hosting it for $4/month is inline with the significance of the website. By figuring out the value first, it'll assist shield you spending too much or too little on your website.</p>
			<p>Visitors is the lifeblood of any web site or blog. With out visitors, a web site will be the identical as nearly all of every web site created, just one other lifeless dot in the universe we name the internet. Surprisingly, some individuals suppose that each one they must do to get site visitors to their website is buy a site identify, put up their web site and hey presto, visitors will come by the millions. Sadly, everyone knows that isn't true. If it was, I certainly would not be penning this now, I'd be creating as many sites as possible. Internet Traffic, as with most issues, requires a strategy, a plan of assault, knowledge. It is advisable to go where to go and what to do with the intention to entice site visitors to your sites.</p>
			<p>Presumably the largest and most necessary strategy at the moment. Social media is big, large but was totally unheard of some brief years ago. With the onset of the online 2.zero revolution, sites like Fb, MySpace and Twitter were born. So how can we tap into this proverbial oil effectively? By the art of conversation, probably the most powerful online and offline advertising tool. Inside websites like Facebook particularly, there will probably be groups for every niche. Be a part of one associated to the niche you might be in. Be part of within the discussions, reply to posts. Add worth to the group. DO NOT point out merchandise you are selling or start spamming the group. You'll end up with your popularity in tatters and banned. Now this isn't a get traffic quick scheme, not by a protracted shot. It will take time as you construct your reputation. However as it grows, the extra you may be seen and the more people will wish to discover out about you and click on the links in your profile. Remember, set up credibility by giving value and the site visitors will flow.</p>
			<p>A much underneath-rated, however on the identical time, a very fun method to create links to your site. Visit peoples blogs that are in a niche related to your site and add a remark to the posts. The remark field normally lets you add your web site which people can go to by clicking in your name. However, it wants more than simply saying \"nice submit\". Add value to the put up, explain what you like, expand on the points made in the post. Give experiences you've gotten that are relevant. Again, it is all about constructing relationships by giving value. The worth you give, the more folks will click your link. Don't spam the feedback field along with your links, you will not do your self any favours and they're going to normally be filtered out as spam anyway. Do it right, and you'll quickly get a stream of targeted traffic heading to your site.</p>
			<p>A really similar technique in driving site visitors to your sites. Search for forums which can be relevant to your niche. Take a look at the membership numbers and the post depend and the way regular posts are. If they are both excessive, then join. The vital level here is to fill in your profile correctly. Most boards will permit you to put a website link in your profile, some even enable you two or three. Most forums will also can help you add a signature link. This once more may very well be your blog / website or an affiliate link. However, read the principles of the forum first, all are different and have their own little method of doing things. Take the Warrior Forum for example, they do not permit affiliate hyperlinks in the signature, it needs to be your individual website. Start getting concerned in posts and discussions, thanking individuals for their advice. Start giving recommendation the place you're feeling it is appropriate. Again, it is about constructing credibility by giving value. The extra value you give, the more followers you will appeal to in a discussion board and in the end, they may want to know extra about you and click the hyperlinks in your profile and signature. Bear in mind, posts are on boards indefinitely and might create a nice evergreen stream of site visitors to your site.</p>
			<p>As you'll be able to collect, the artwork of building free, evergreen site visitors is by giving value. Including value by giving quality content will only improve your credibility and reputation. This in turn will drive targeted traffic to your web site, visitors that has already been warmed up, leaving your websites sales funnel to do the rest in converting this already focused traffic into opt-in leads or customers.</p>" .
			"</font>" .
			"</div>";
}
$key3 = $_GET['key3'];
if ($key3) {
	echo "<div style=\"width:800px;text-align:left;\"><center><font style='font-family: georgia, serif; font-size:15pt;'>Website Value Calculator</font></center><br><br>" .
			"<font style='font-family: georgia, serif; font-size:11pt;'>" .
			"<p>Building a website is only half of the battle. The other half is the powerful part, getting folks to visit. A quality web site is nugatory and not using a regular stream of individuals that can make use of the knowledge (and probably make you money, depending on the type of web site in question). By no means fear though, because we've got some great methods to convey site visitors to your website. Before you recognize it, you will have extra guests than you realize what to do with! The first point is the apparent one. You've got to have a web site worth visiting. Quality content material that's updated persistently is the key. Ask yourself, in case you had been only a regular visitor, would you need to go to this web site? Is there anything you would find of use? If the reply isn't any, start by altering that first.</p>
			<p>Getting hyperlinks to your site is an effective way to attain fast, high quality traffic. It can also be quite tough, since it's important to persuade a webmaster that your web site is good sufficient to point out their visitors. An easy approach, without dealing directly with people, is to go round and submit your web site to free directories. A easy Google search, with some creativity, will uncover hundreds of free directories that have classes for practically everything. These directories are superior ways to get traffic to your website, in addition to affect the search engines a little bit. The opposite way to get links is the quaint way. Hearth up your e mail shopper, and send out some emails to the homeowners of websites you're feeling could be willing to hyperlink to you. Do not spam sites, however write high quality emails to the owners asking if they might be excited by linking to your site. The most effective kind of web sites to email are these with \"links\" pages, as they're the most certainly to add you, since there's already a place to your website to go.</p>
			<p>By far the primary tool that folks use to seek out info, search engines like google and yahoo are positively one thing you wish to have on your site. Concentrate on the big three - Google, Yahoo! and MSN. Overlook the rest. The others will not convey you sufficient site visitors to make it value while. One of the simplest ways to tame a search engine is to get it to see loads of links to your site. Not spammy ones, because they are going to low cost your website for that, but direct links to your web site from prime quality websites. Keep in mind, if you wish to rank excessive in serps, it's a must to begin by going out and gathering links. There isn't any different reliable way. Manually submitting your site to a search engine would not do much, as when you have any variety of backlinks at all, the spiders will find your web site with no issues. If you don't have sufficient links for them to seek out you, then there isn't any approach you'll rank high anyway.</p>
			<p>Remember to have clear titles in your website. Don't use the identical title for each page on your site, make each a unique, descriptive title for each particular person page. This is very important. Do not panic if you do not rank effectively at first. Most engines, especially Google, have \"sandboxes\" that they put new websites in for the first few months. You probably will not rank nicely till after that period is over.</p>
			<p>Google makes use of a system of rating web sites referred to as PR, short for Page Rank. PR is a score, between 1 and 10, that's given to a person page based mostly upon the number and quality of links pointing to that web page. When a page with a PR score links to another web page, it \"passes on\" a few of its PR to that page. For instance, if I have a new internet web page, with no PR rating, and a PR 6 page links to it, that web page might finally have a PR score of, say, 4 or 5. Google uses the PR rating of a web page to assist resolve where to place it on search results for a selected keyword. Have in mind, nonetheless, that PR isn't the one factor used in deciding where you'll rank with search engines like google and yahoo, it is just one of many.</p>
			<p>Site owners generally use a form of linking referred to as reciprocal linking, which is just buying and selling links. Website A links to web site B, and website B hyperlinks again to website A. It is a good suggestion in idea, however, serps have began choosing up on it. Link buying and selling is not a superb factor to do. The perfect type of linking is to have a one-way hyperlink to your site (you'll be able to discuss a webmaster into it by being nice, or maybe by buying and selling companies, or maybe even buying a hyperlink from her or him), or by finding a webmaster with more than one site to hyperlink with.</p>
			<p>Should you select the latter, the most common means is so that you can link to someone's website, and for them to link back to your site on a different site of theirs. For example, you may have a website (we'll call it website B), and the other individual has two web sites (we'll name them web site A and site C). Site A hyperlinks to web site B, which hyperlinks to web site C. Search engines cannot figure this out, and also you each get high quality hyperlinks again to your sites. Just make certain that site C would not hyperlink to web site A to form a ring, different wise it's simply old style reciprocal linking with a 3rd site thrown in.</p>
			<p>A straightforward strategy to get visitors to your site is to situation press releases. It can be gold on the subject of visitors, but oddly sufficient, it is usually missed by webmasters. It would not take much time to arrange a press release, and there are many free PR publishing websites on the internet, so put aside some time to issue one. The rewards may fairly properly be price your time. An RSS news feed in your website is another strategy to get visitors to your web site that's often overlooked. Keep in mind, nonetheless, this will be ineffective until you update your website with quality content material, and infrequently too.</p>
			<p>If all else fails, there are two certain-fire ways to get traffic to your web site, however they may both cost you money. The primary is the best: Simply hire an SEO (Search-Engine-Optimization) firm. They are professionals focusing on making your website rank nicely in search engines. They may price you a fairly penny, but flip your site over to them, and so they'll do all the work for you.</p>" .
			"</font>" .
			"</div>";
}
?>
</center>
<div id='gohere'>
<center>
<div id="res" style="width:1150px;position:relative;"><center>
</div>
<br>

<center>

<br><br><br><div style="width:1000px;">

<hr>

<font style='font-family: georgia, serif; font-size:11pt;'><? echo $ps; ?></font>

</div>

<br><br>

&copy;&nbsp;2010-2013&nbsp;<a href="http://kishlaly.com" target="_blank">Vladimir Kishlaly</a>

</center>


<?
$d = $_GET['d'];
if ($d) {
echo '<script type="text/javascript"> 
     //<![CDATA[
		document.getElementById("url").value = "'.$d.'";
		getAll();
     //]]>
    </script>';
}
$fs = $_GET['fs'];
if ($fs) {
echo '<script type="text/javascript"> 
     //<![CDATA[
		saleSearch();
     //]]>
    </script>';
}
$fsh = $_GET['fsh'];
if ($fsh) {
echo '<script type="text/javascript"> 
     //<![CDATA[
		loadSale();
     //]]>
    </script>';
}
$help_ = $_GET['help'];
if ($help_) {
echo '<script type="text/javascript"> 
     //<![CDATA[
		help();
     //]]>
    </script>';
}
$battle = $_GET['battle'];
if ($battle) {
echo '<script type="text/javascript"> 
     //<![CDATA[
		getBattle();
     //]]>
    </script>';
}
$dobattle_ = $_GET['dobattle'];
if ($dobattle_) {
echo '<script type="text/javascript"> 
     //<![CDATA[
		fight("'.$dobattle_.'");
     //]]>
    </script>';
}
mysql_close($con);
?>
<script type="text/javascript"> <!--
    lastCalculated(1);
	sortAllPag('', 'United States', 1);
//--> </script>
<br>
</body>
</html>