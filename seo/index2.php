<?php
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
	$logo = "<div id=\"logo\"><a href=\"".$homePage."\"><font style=\"font-family: georgia, serif; font-size:24pt;\">".$mainTitle1."</font></a><br><br></div>";
}
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?42"></script>
<script type="text/javascript">
  VK.init({apiId: 2675226, onlyWidgets: true});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="verifyownership" content="fb04aee5557f19eaecf6914e26514f1f" />
<title><?
$lang = $_GET['lang'];
if ($mainTitle2 == 'SiteCostCalculator.ru') {
	$lang = 'ru';
}
if ($lang) {
include($lang.".php");
} else {
include("en.php");
}

$d = $_GET['d'];
if ($d) {

$sql = "SELECT worth, sccCost FROM worth WHERE domain = '$d' LIMIT 1";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$w = $row[worth];
	$sccCost = $row[sccCost];
	$worthInt = intval($w);
	if ($worthInt == 0) {
	 	$worthInt = 375;
	}
}
	$customTitle =  $n100." ".$mainTitle2.": ";
	$customTitle2 = $n101;
}
	if ($customTitle && $worthInt > 0) {
		if ($sccCost) {
			echo $d." ".$saleTitle_." $".number_format($sccCost, 0, ',', ',')."; ".$saleTitle2_." $".number_format($worthInt, 0, ',', ',');
			$keysD = $d." ".$saleTitle_2.", ".$d." ".$saleKeys1.", ".$saleKeys2." ".$d;
		} else {
			echo $d." ".$customTitle2." $".number_format($worthInt, 0, ',', ',').", ".$n100." ".$mainTitle2;
		}
	} else {
		echo $mainTitle1." - ".$n102;
	}
$keys_ = ($keysD) ? $keysD : $customKey;
?></title>
<meta name='keywords' content='<? echo $keys_.", ".$f1; ?>' />
<meta name='description' content='<? echo $f2; ?>' />
<link href="css/stylesheet.css" rel="stylesheet" type="text/css"/>
<link rel=alternate type=application/rss+xml title=RSS href=RSS/index.php>
<link href="whois.css" rel="stylesheet" type="text/css" />
<link href="modalbox.css" rel="stylesheet" type="text/css" />
<link href="pagination.css" rel="stylesheet" type="text/css">
<script src="scriptaculous.js" type="text/javascript"></script>
<script src="onload.js" type="text/javascript"></script>  
<script src="tooltip-v0.1.js" type="text/javascript"></script>
<script type="text/javascript" src="rounded-corners.js"></script>
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
<script type="text/javascript" src="prototype.js"> <!--
//--> </script>
<script type="text/javascript" src="prototype-effects.js"> <!--
//--> </script>
<script type="text/javascript" src="pr.js"> <!--
//--> </script>
<style type="text/css">
<!--
.currentStyle {
	font-size:1.5em;
	font-weight:bold;
}

#numbers a, #numbers span {
	display:block;
	width:20px;
	font:bold 12px/20px Arial, Helvetica, sans-serif;
	text-decoration:none;
	float:left;
	text-align:center;
	margin-right:7px;
	border:1px solid #999999;
}
#numbers a {
	background-color:#CCCCCC;
	color:#000000;
}
#numbers a:hover {
	color:#CCCCCC;
	background-color:#000000;
}
#numbers span.current {
	color:#FFFFFF;
	background-color:#990000;
}
-->
</style>
<style>
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

/* =links
----------------------------------------------- */

table.cool a {
		color:green;
		text-decoration:none;
}

table.cool a:hover {
		border-bottom: 1px dashed #bbb;
}

/* =head =foot
----------------------------------------------- */

thead.cool th, tfoot.cool th, tfoot.cool td {
		background:#333 url(llsh.gif) repeat-x;
		color:#fff
}

tfoot.cool td {
		text-align:right
}

/* =body
----------------------------------------------- */

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
</head>
<script type="text/javascript"> <!--

function ScrollToElement(theElement){

  var selectedPosX = 0;
  var selectedPosY = 0;
              
  while(theElement !== null){
    selectedPosX += theElement.offsetLeft;
    selectedPosY += theElement.offsetTop;
    theElement = theElement.offsetParent;
  }
                        		      
 window.scrollTo(selectedPosX,selectedPosY);

}

function getDomain(url) {
   return url.match(/:\/\/(.[^/]+)/)[1];
}


function addCookie(cName, cValue) {
   var dtExpires = new Date();
   var dtExpiryDate = "";

   dtExpires.setTime(dtExpires.getTime() + 24 * 60 * 60 * 100000);

   dtExpiryDate = dtExpires.toGMTString();

   document.cookie = cName + "=" + cValue + "; expires=" + dtExpiryDate;
}

function findCookie(szName) {
  var i = 0;
  var nStartPosition = 0;
  var nEndPosition = 0;  
  var szCookieString = document.cookie;  

  while(i <= szCookieString.length) 
  {
    nStartPosition = i;
    nEndPosition = nStartPosition + szName.length;

    if(szCookieString.substring( 
        nStartPosition,nEndPosition) === szName)
    {
      nStartPosition = nEndPosition + 1;
      nEndPosition = 
        document.cookie.indexOf(";",nStartPosition);

      if(nEndPosition < nStartPosition)
        nEndPosition = document.cookie.length;

      return document.cookie.substring( 
          nStartPosition,nEndPosition);  
      break;    
    }
    i++;  
  }
  return "";
}


	function updateTags() {
		var domain = document.getElementById('updateT').value;
		document.getElementById('updateTw').innerHTML = "<img src='loader2.gif' style='margin-bottom:-7px;'>";			
		new Ajax.Request('getIdByDomain.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var id = response.responseText;
		      if (id === 'bad-1') {
			      document.getElementById('updateTw').innerHTML = "<? echo $saleUpd3; ?>";

		      } else {
			 if (id === 'bad-2') {
			      window.location.href="http://<? echo $mainTitle2; ?>/www." + domain;
			 } else {
				new Ajax.Request('seo/sale.php?domain=' + domain, {
				  onSuccess: function(response) {
				      var res = response.responseText;
				      if (res === 'good') {
					new Ajax.Request('saleInfo.php?domain=' + domain + '&lang=<? echo $lang; ?>', {
					  onSuccess: function(response) {
					      var html4 = response.responseText;
					     document.getElementById('updateTw').innerHTML = "<? echo $saleUpd1; ?>: <a href='http://<? echo $mainTitle2; ?>/www." + domain + "'>http://<? echo $mainTitle2; ?>/www." + domain + "</a><br>" + html4;
					  }
					});
				      }
				      if (res === 'bad') {
					document.getElementById('updateTw').innerHTML = "<? echo $saleUpd2; ?> (scc.language, scc.cost, scc.email)?";
				      }
				  }
				});

			}
		      }
		  }
		});
 	}


	function loadS(domain) {
		document.getElementById('url').value = domain;
		//sortAllPag(domain, '', '');
		getAll();
	}

	function updateAll(id) {
		document.getElementById('logo').innerHTML = "<center><b><? echo $f3; ?></b><br><img src='loader.gif'></center>";		
		document.getElementById('res').innerHTML = "";
		new Ajax.Request('getDomain.php?id=' + id, {
		  onSuccess: function(response) {
		        var domain = response.responseText;
				new Ajax.Request('main_lib_update.php', {
			    method: 'POST',
   				parameters: 'updateok=updateok&domain=' + domain + '&id=' + id,
				  onSuccess: function(response) {
					document.getElementById('logo').innerHTML = "<center><b><? echo $f3_; ?></b><br><img src='loader.gif'></center>";		
					new Ajax.Request('seo/prUpdate.php?domain=' + domain, {
					  onSuccess: function(response) {
						document.getElementById('logo').innerHTML = "<center><b><? echo $add3; ?></b><br><img src='loader.gif'></center>";						
						new Ajax.Request('seo/saveGoogleBacks.php?domain=' + domain, {
						  onSuccess: function(response) {
						      var html2 = response.responseText;
							document.getElementById('logo').innerHTML = "<center><b><? echo $add4; ?></b><br><img src='loader.gif'></center>";
							new Ajax.Request('seo/r.php?domain=' + domain, {
							  onSuccess: function(response) {
								document.getElementById('logo').innerHTML = "<center><b><? echo $add2_; ?></b><br><img src='loader.gif'></center>";
								new Ajax.Request('seo/saveYahooBacks.php?domain=' + domain, {
								  onSuccess: function(response) {
									document.getElementById('logo').innerHTML = "<center><b>3</b><br><img src='loader2.gif'></center>";
									new Ajax.Request('seo/updateTitle.php?domain=' + domain, {
									  onSuccess: function(response) {
										document.getElementById('logo').innerHTML = "<center><b>2</b><br><img src='loader2.gif'></center>";
										new Ajax.Request('seo/updateDescription.php?domain=' + domain, {
										  onSuccess: function(response) {
											document.getElementById('logo').innerHTML = "<center><b>1</b><br><img src='loader2.gif'></center>";
											new Ajax.Request('seo/updateKeys.php?domain=' + domain, {
											  onSuccess: function(response) {
												new Ajax.Request('seo/sale.php?domain=' + domain, {
												  onSuccess: function(response) {
													new Ajax.Request('getInfo2.php?domain=' + domain + '&what=all' + '&lang=<? echo $lang; ?>', {
													  onSuccess: function(response) {
													      var html2 = response.responseText;
													      document.getElementById('logo').innerHTML = '<? echo $logo; ?>';
													      document.getElementById('res').innerHTML = html2;
													      ScrollToElement(document.getElementById('gohere'));
													  }
													});											  
												  }
												});											  
											  }
											});											  
										  }
										});											  
									  }
									});											  
								  }
								});											  
							  }
							});											  
						  }
						});											  
					  }
					});											  

				  }
				});
		  }
		});
	}

	function loadUseful(key) {
		document.getElementById('useful').innerHTML = "<center><br><br><img src='loader.gif'></center>";			
		new Ajax.Request('useful.php?qq=' + key, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('useful').style.background='url(' + key + '.jpg)';
		      document.getElementById('useful').innerHTML = html3;
		  }
		});
 	}


	function loadSale() {
		document.getElementById('res').innerHTML = "<center><b><? echo $processing; ?></b><br><img src='loader.gif'><br><br></center></a>";
		new Ajax.Request('forsale.php?lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('gohere'));
		  }
		});	
 	}

	function saleSearch() {
		document.getElementById('res').innerHTML = "<center><b><? echo $processing; ?></b><br><img src='loader.gif'><br><br></center></a>";
		new Ajax.Request('saleSearch.php?lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('gohere'));
		  }
		});	
 	}


	function loadAlexa(domain, type, time) {
		document.getElementById('alexa').innerHTML = "<center><br><br><img src='loader.gif'></center>";
		new Ajax.Request('seo/alexa.php?domain=' + domain + '&type=' + type + '&time=' + time, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('alexa').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}

	function search(type) {
		var en = document.getElementById('en').checked;
		var ru = document.getElementById('ru').checked;
		var lang = "";
		if (en) {
			lang = "en";
		}
		if (ru) {
			lang = "ru";
		}
		if (!en && !ru) {
			lang = "all";
		}
		if (en && ru) {
			lang = "all";
		}
		var siteTitle = document.getElementById('siteTitle').value;
		siteTitle = siteTitle.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteDesc = document.getElementById('siteDesc').value;
		siteDesc = siteDesc.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteKeys = document.getElementById('siteKeys').value;
		siteKeys = siteKeys.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteAge = document.getElementById('siteAge').value;
		siteAge = siteAge.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var sitePr = document.getElementById('sitePr').value;
		sitePr = sitePr.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteCostFrom = document.getElementById('siteCostFrom').value;
		siteCostFrom = siteCostFrom.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteCostTo = document.getElementById('siteCostTo').value;
		siteCostTo = siteCostTo.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteInFrom = document.getElementById('siteInFrom').value;
		siteInFrom = siteInFrom.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteInTo = document.getElementById('siteInTo').value;
		siteInTo = siteInTo.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteOutFrom = document.getElementById('siteOutFrom').value;
		siteOutFrom = siteOutFrom.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteOutTo = document.getElementById('siteOutTo').value;
		siteOutTo = siteOutTo.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteIncomeTypes = document.getElementById('siteIncomeTypes').value;
		siteIncomeTypes = siteIncomeTypes.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		var siteAlexa = document.getElementById('siteAlexa').value;
		siteAlexa = siteAlexa.replace(/ /g,'').replace(/"/g,'').replace(/'/g,'');
		document.getElementById('searchRes').innerHTML = "<center><br><br><img src='loader.gif'></center>";
		var p = '';
		if (type) {
			p = 'lang=' + lang + '&siteTitle=' + siteTitle + '&siteDesc=' + siteDesc + '&siteKeys=' + siteKeys + '&siteAge=' + siteAge + '&sitePr=' + sitePr + '&siteCostFrom=' + siteCostFrom + '&siteCostTo=' + siteCostTo + '&siteInFrom=' + siteInFrom + '&siteInTo=' + siteInTo + '&siteOutFrom=' + siteOutFrom + '&siteOutTo=' + siteOutTo + '&siteIncomeTypes=' + siteIncomeTypes + '&siteAlexa=' + siteAlexa + '&language=<? echo $lang; ?>' + '&type=' + type;
		} else {
			p = 'lang=' + lang + '&siteTitle=' + siteTitle + '&siteDesc=' + siteDesc + '&siteKeys=' + siteKeys + '&siteAge=' + siteAge + '&sitePr=' + sitePr + '&siteCostFrom=' + siteCostFrom + '&siteCostTo=' + siteCostTo + '&siteInFrom=' + siteInFrom + '&siteInTo=' + siteInTo + '&siteOutFrom=' + siteOutFrom + '&siteOutTo=' + siteOutTo + '&siteIncomeTypes=' + siteIncomeTypes + '&siteAlexa=' + siteAlexa + '&language=<? echo $lang; ?>';
		}
		new Ajax.Request('seo/search.php', {
		  method: 'POST',
		  parameters: p,
		  onSuccess: function(response) {
		      var html = response.responseText;
		      document.getElementById('searchRes').innerHTML = html;
		  }
		});									  						      						      								      						      		
 	}

	function clearFields() {
		document.getElementById('en').checked = false;
		document.getElementById('ru').checked = false;
		document.getElementById('siteTitle').value = "";
		document.getElementById('siteDesc').value = "";
		document.getElementById('siteKeys').value = "";
		document.getElementById('siteAge').value = "";
		document.getElementById('sitePr').value = "";
		document.getElementById('siteCostFrom').value = "";
		document.getElementById('siteCostTo').value = "";
		document.getElementById('siteInFrom').value = "";
		document.getElementById('siteInTo').value = "";
		document.getElementById('siteOutFrom').value = "";
		document.getElementById('siteOutTo').value = "";
		document.getElementById('siteIncomeTypes').value = "";
		document.getElementById('siteAlexa').value = "";
 	}


	function updateTitle(domain) {
		document.getElementById('w_title').innerHTML = "<img src='loader2.gif'>";
		new Ajax.Request('seo/updateTitle.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('w_title').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}

	function updateDescription(domain) {
		document.getElementById('w_desc').innerHTML = "<img src='loader2.gif'>";
		new Ajax.Request('seo/updateDescription.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('w_desc').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}

	function updateKeys(domain) {
		document.getElementById('w_keys').innerHTML = "<img src='loader2.gif'>";
		new Ajax.Request('seo/updateKeys.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('w_keys').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}


	function updateLinks(domain) {
		document.getElementById('googleIndexedPages').innerHTML = "<center><img src='loader2.gif'></center>";
		new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=googleIndexedPages', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('googleIndexedPages').innerHTML = html3;
			document.getElementById('yahooIndexedPagesMainDomain').innerHTML = "<center><img src='loader2.gif'></center>";	
			new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=yahooIndexedPagesMainDomain', {
			  onSuccess: function(response) {
			      var html3 = response.responseText;
			      document.getElementById('yahooIndexedPagesMainDomain').innerHTML = html3;
				document.getElementById('yahooIndexedPagesSubdomains').innerHTML = "<center><img src='loader2.gif'></center>";	
				new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=yahooIndexedPagesSubdomains', {
				  onSuccess: function(response) {
				      var html3 = response.responseText;
				      document.getElementById('yahooIndexedPagesSubdomains').innerHTML = html3;
					document.getElementById('bingIndexedPages').innerHTML = "<center><img src='loader2.gif'></center>";	
					new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=bingIndexedPages', {
					  onSuccess: function(response) {
					      var html3 = response.responseText;
					      document.getElementById('bingIndexedPages').innerHTML = html3;
						document.getElementById('yahooLinksExceptFromThisDomain').innerHTML = "<center><img src='loader2.gif'></center>";	
						new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=yahooLinksExceptFromThisDomain', {
						  onSuccess: function(response) {
						      var html3 = response.responseText;
						      document.getElementById('yahooLinksExceptFromThisDomain').innerHTML = html3;
							document.getElementById('yahooLinksFromAllPages').innerHTML = "<center><img src='loader2.gif'></center>";	
							new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=yahooLinksFromAllPages', {
							  onSuccess: function(response) {
							      var html3 = response.responseText;
							      document.getElementById('yahooLinksFromAllPages').innerHTML = html3;
								document.getElementById('bingLinks').innerHTML = "<center><img src='loader2.gif'></center>";	
								new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=bingLinks', {
								  onSuccess: function(response) {
								      var html3 = response.responseText;
								      document.getElementById('bingLinks').innerHTML = html3;
									document.getElementById('alexaLinks').innerHTML = "<center><img src='loader2.gif'></center>";	
									new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=alexaLinks', {
									  onSuccess: function(response) {
									      var html3 = response.responseText;
									      document.getElementById('alexaLinks').innerHTML = html3;
										document.getElementById('advisorRel').innerHTML = "<center><img src='loader2.gif'></center>";	
										new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=advisorRel', {
										  onSuccess: function(response) {
										      var html3 = response.responseText;
										      document.getElementById('advisorRel').innerHTML = "<img src='" + html3 + "'>";
											document.getElementById('dmozCat').innerHTML = "<center><img src='loader2.gif'></center>";	
											new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=dmozCat', {
											  onSuccess: function(response) {
											      var html3 = response.responseText;
											      document.getElementById('dmozCat').innerHTML = html3;
												document.getElementById('advisor').innerHTML = "<center><img src='loader2.gif'></center>";	
												new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=advisor', {
												  onSuccess: function(response) {
												      var html3 = response.responseText;
												      document.getElementById('advisor').innerHTML = html3;
													document.getElementById('WOTRating').innerHTML = "<center><img src='loader2.gif'></center>";	
													new Ajax.Request('seo/r.php?domain=' + domain + '&custom=true&what=WOTRating', {
													  onSuccess: function(response) {
													      var html3 = response.responseText;
													      document.getElementById('WOTRating').innerHTML = html3;
													  }
													});
												  }
												});									  						      						      								      						      		
											  }
											});									  						      						      								      						      		
										  }
										});									  						      						      								      						      		
									  }
									});									  						      						      								      						      		
								  }
								});									  						      						      								      						      		
							  }
							});									  						      						      								      						      		
						  }
						});									  						      						      								      						      		
					  }
					});									  						      						      								      						      		
				  }
				});									  						      						      								      						      		
			  }
			});									  						      						      								      						      		
		  }
		});									  						      						      								      						      		
 	}


	function loadKeys(key, findType, sortBy, page) {
		document.getElementById('customKey').value = key;
		document.getElementById('semantic').innerHTML = "<center><br><br><img src='loader.gif'></center>";
		var params = "";
		if (page) {
			params = 'key=' + key + '&findType=' + findType + '&sortBy=' + sortBy + '&lang=<? echo $lang; ?>' + '&page=' + page;
		} else {
			params = 'key=' + key + '&findType=' + findType + '&sortBy=' + sortBy + '&lang=<? echo $lang; ?>';
		}
		new Ajax.Request('seo/semantic.php', {
		   method: 'GET',
		   parameters: params,
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('semantic').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}
	
 	
	function total() {
		new Ajax.Request('total.php?baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('total').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	}
 	 	
	function footer() {
		new Ajax.Request('footer.php', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('footer').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	 	 	
 	
	function similarPrPag(country, pr, page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('similarPrPag.php?country=' + country + '&pr=' + pr + '&page=' + page + '&baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	

	function sortYearsPag(years, country, page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortYearsPag.php?years=' + years + '&country=' + country + '&page=' + page + '&baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	
 	
	function sortWorthPag(country, page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortWorthPag.php?country=' + country + '&page=' + page + '&baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	

	function sortDpviewPag(country, page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortDpviewPag.php?country=' + country + '&page=' + page + '&baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	

	function sortBacksPag(country, page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortBacksPag.php?country=' + country + '&page=' + page + '&baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	

	function sortDearnPag(country, page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortDearnPag.php?country=' + country + '&page=' + page + '&baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	

	function similarPrAll(id) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('similarPrAll.php?id=' + id, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	}

	function sortYears(id) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortYears.php?id=' + id, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	}

	function sortYearsAll(id) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortYearsAll.php?id=' + id, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	}
 	
	function similarDomainNames(domain) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('similarDomainNames.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});					  						      						      								      						      		
 	}
 	
	function sortAllPag(domain, country, page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('sortAllPag.php?domain=' + domain + '&page=' + page + '&country=' + country + '&lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	}

	function lastCalculated(page) {
		document.getElementById('lastTitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('lastCalculated.php?page=' + page + '&lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('lastCalculated').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	
 	
	function topWorld(page) {
		document.getElementById('stitle').innerHTML = "<img src='loader.gif' align='center'>";
		new Ajax.Request('topWorld.php?page=' + page + '&baseLang=<? echo $baseLang; ?>', {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('sortable').innerHTML = html3;
		  }
		});											  						      						      								      						      		
 	} 	 	
 	 	
	function getTop() {
		document.getElementById('res').innerHTML = "<center><b><? echo $processing; ?></b><br><img src='loader.gif'></center></a>";
		new Ajax.Request('top.php', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('gohere'));		        
		  }
		});	
 	}

	function getAll() {
		var all;
		var domain = document.getElementById('url').value;
		domain = domain.replace(/ /g,'');
		domain = domain.replace("http://www.","");
		domain = domain.replace("http://","");
		if (domain.indexOf('www.') === 0) {
			domain = domain.replace("www.","");
		}
		document.getElementById('logo').innerHTML = "<center><b><? echo $f4; ?></b><br><img src='loader.gif'></center>";
		document.getElementById('res').innerHTML = "";
		new Ajax.Request('getInfo2.php?domain=' + domain + '&what=all' + '&lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		        all = html;
				html = html.replace(/^\s+|\s+$/g,"");
				if (html.length < 3) {
					document.getElementById('logo').innerHTML = "<center><b><? echo $f4_; ?></b><br><img src='loader.gif'></center>";					
					new Ajax.Request('web.php?url=' + domain, {
					  onSuccess: function(response) {
							document.getElementById('logo').innerHTML = "<center><b><? echo $add1; ?></b><br><img src='loader.gif'></center>";
							new Ajax.Request('seo/prUpdate.php?domain=' + domain, {
							  onSuccess: function(response) {
								document.getElementById('logo').innerHTML = "<center><b><? echo $add2; ?></b><br><img src='loader.gif'></center>";
								new Ajax.Request('seo/saveGoogleBacks.php?domain=' + domain, {
								  onSuccess: function(response) {
									document.getElementById('logo').innerHTML = "<center><b><? echo $add2_; ?></b><br><img src='loader.gif'></center>";
									new Ajax.Request('seo/saveYahooBacks.php?domain=' + domain, {
									  onSuccess: function(response) {
										document.getElementById('logo').innerHTML = "<center><b><? echo $add4; ?></b><br><img src='loader.gif'></center>";
										new Ajax.Request('seo/r.php?domain=' + domain, {
										  onSuccess: function(response) {
											document.getElementById('logo').innerHTML = "<center><b>3</b><br><img src='loader2.gif'></center>";
											new Ajax.Request('seo/updateTitle.php?domain=' + domain, {
											  onSuccess: function(response) {
												document.getElementById('logo').innerHTML = "<center><b>2</b><br><img src='loader2.gif'></center>";
												new Ajax.Request('seo/updateDescription.php?domain=' + domain, {
												  onSuccess: function(response) {
													document.getElementById('logo').innerHTML = "<center><b>1</b><br><img src='loader2.gif'></center>";
													new Ajax.Request('seo/updateKeys.php?domain=' + domain, {
													  onSuccess: function(response) {
														new Ajax.Request('seo/sale.php?domain=' + domain, {
														  onSuccess: function(response) {
															new Ajax.Request('getInfo2.php?domain=' + domain + '&what=all' + '&lang=<? echo $lang; ?>', {
															  onSuccess: function(response) {
															      var html2 = response.responseText;
															      if (html2.length < 3) {
																      document.getElementById('res').innerHTML = "Nope";
															      }
															      document.getElementById('logo').innerHTML = '<? echo $logo; ?>';
															      document.getElementById('res').innerHTML = html2;
															      ScrollToElement(document.getElementById('gohere'));
																new Ajax.Request('sortAllPag.php?domain=' + domain + '&lang=<? echo $lang; ?>', {
																  onSuccess: function(response) {
																      var html3 = response.responseText;
																      document.getElementById('sortable').innerHTML = html3;
																  }
																});											  						      						      								      						      		
															  }
															});											  						      						      								      						      		
														  }
														});											  						      						      								      						      		
													  }
													});											  						      						      								      						      		
												  }
												});											  						      						      								      						      		
											  }
											});											  						      						      								      						      		
											
										  }
										});											  						      						      								      						      		
									  }
									});											  						      						      								      						      		
								  }
							});											  						      						      								      						      		
						  }
						});											  
					  }
					});
				} else {
						document.getElementById('logo').innerHTML = '<? echo $logo; ?>';
						document.getElementById('res').innerHTML = all;
						ScrollToElement(document.getElementById('gohere'));
						new Ajax.Request('getCountry.php?domain=' + domain, {
						  onSuccess: function(response) {
						      var c = response.responseText;
						      new Ajax.Request('sortAllPag.php?domain=' + domain + '&lang=<? echo $lang; ?>', {
							onSuccess: function(response) {
						              var html3 = response.responseText;
							      document.getElementById('sortable').innerHTML = html3;
							  }
							});											  						      						      								      						      		
						  }
						});											  						      						      										
				}		      
		  }
		});
 	}
 	
function go(to) {
	window.location.href = to;
}

//--> </script>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<NOSCRIPT>
<center>
<? echo $f6; ?>
</center>
</NOSCRIPT>
<center>
<div style="width:1150px;position:relative;">
	<div id='lastCalculated' style="width:313px;height:440px;position:absolute;top:0;left:0;">
		<span id="lastTitle" style="font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold;"><strong><? echo $f7; ?></strong></span>
	</div>	
	<div style="width:524px;">
<?
$langStrEn = "<img src=\"en.png\" style=\"border:none;\">";
$langStrRu = "<img src=\"ru.png\" style=\"border:none;\">";
?>
<a href="<? echo $newEn; ?>"><? echo $langStrEn; ?></a>&nbsp;&nbsp;<a href="<? echo $newRu; ?>"><? echo $langStrRu; ?></a>
<br>
<a style="text-decoration:underline;cursor:pointer;color:blue;" onclick="getTop();"><? echo $f8; ?></a>&nbsp;|&nbsp;<a style="text-decoration:underline;cursor:pointer;color:blue;" onclick="go('http://www.facebook.com/pages/Site-Cost-Calculator/123508884403158');" target="_blank"><? echo $f9; ?></a>
<br><a href="index.php?fsh=true"><? echo $forSaleHelp; ?></a>&nbsp;|&nbsp;<a href="index.php?fs=true"><? echo $forSaleMainLink; ?></a>
<div style="margin-left:-10px;"><p>
<a href="http://twitter.com/share?text=<? echo $f10; ?>&url=http://<? echo $mainDomain; ?>" target="_blank" class="twitter-share-button" title="Share on Twitter"><img src="social/twitter.gif" style="height:16px; width:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.facebook.com/sharer.php?u=http://<? echo $mainDomain; ?>&t=<? echo $f10; ?>" target="_blank" title="Share On Facebook"><img alt="Share on Facebook" src="social/facebook.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.google.com/buzz/post?url=http://<? echo $mainDomain; ?>" target="_blank" title="Share On Google Buzz"><img alt="Share on Google Buzz" src="social/Buzz.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a>
<a href="http://del.icio.us/post?url=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>" target="_blank" title="Share on Del.icio.us"><img alt="Add To Del.icio.us" src="social/delicious.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://digg.com/submit?phase=2&url=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>" target="_blank" title="Share on Digg"><img alt="Share On Digg" src="social/digg.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://reddit.com/submit?url=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>" target="_blank" title="Share on Reddit"><img alt="Share On Reddit" src="social/reddit.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.linkedin.com/shareArticle?mini=true&url=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>" target="_blank" title="Share on LinkedIn"><img alt="Share On LinkedIn" src="social/linkedin.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.blogger.com/blog_this.pyra?t&u=http://<? echo $mainDomain; ?>&n=<? echo $f10; ?>&pli=1" target="_blank" title="Share on Blogger"><img alt="Post To Blogger" src="social/blogger.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.stumbleupon.com/submit?url=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>" target="_blank" title="Share on StumbleUpon"><img alt="Share On StumbleUpon" src="social/stumbleupon.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.friendfeed.com/share?link=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>" target="_blank" title="Share on Friend Feed"><img alt="Share On Friend Feed" src="social/friendfeed.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.myspace.com/Modules/PostTo/Pages/?u=http://<? echo $mainDomain; ?>&t=<? echo $f10; ?>" target="_blank" title="Share on MySpace"><img alt="Share On MySpace" src="social/myspace.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://buzz.yahoo.com/buzz?targetUrl=http://<? echo $mainDomain; ?>&headline=<? echo $f10; ?>" target="_blank" title="Share on Yahoo Buzz"><img alt="Share On Yahoo Buzz" src="social/yahoobuzz.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.google.com/reader/link?url=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>&srcUrl=http://submitarticlefree.net&srcTitle=SubmitArticleFree" target="_blank" title="Share on Google Reader"><img alt="Share On Google Reader" src="social/GoogleReader.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="http://www.google.com/bookmarks/mark?op=add&bkmk=http://<? echo $mainDomain; ?>&title=<? echo $f10; ?>" target="_blank" title="Google Bookmark"><img alt="Google Bookmark" src="social/google.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
<a href="mailto:?subject=How much does your website cost&body=http://<? echo $mainDomain; ?>" target="_blank" title="<? echo $f11; ?>"><img alt="<? echo $em; ?>" src="social/email.gif" style="width:16px; height:16px; padding:0; border:0; vertical-align:middle;"/></a> 
</p></span></div>


	
	<div id="temp" style="display:none;"></div>
	<? echo $logo; ?>
	<div id="total"></div><br>
	<input type="text" class="rc10" name="url" id="url"
		   style="margin-left:10px;margin-right:10px;width: 367px; height: 25px; background-color: rgb(230, 230, 221); border: 1px solid #b4b4b4; font-family: georgia, serif; color: #2a2a2a; font-size:14pt; color: #555555; text-align: center;"
		   onKeyPress="if (event.keyCode===13) { getAll(); }" />
		   <br><input type="button" value="<? echo $f12; ?>" style="height:25px;" onclick="getAll();"><br><br>
<center>
<a href="https://addons.mozilla.org/ru/firefox/addon/site-cost-calculator-tool/" target="_blank"><img src="firefox.png" class="nob" title="<? echo $ff__; ?>"></a>&nbsp;
<a href="https://chrome.google.com/webstore/detail/lckfdajgjbgkegjkobheebfkheadbikl" target="_blank"><img src="chrome.png" class="nob" title="<? echo $ch__; ?>"></a><br>
<a href="http://sitecostcalculator.com/flex/exe1.php"><img src="flex.png" class="nob" title="<? echo $fl__; ?>"></a>
	<script src="http://<? echo $mainDomain; ?>/parser2.php?lang=<? echo $lang; ?>" type="text/javascript"></script>
</center>

	<div id="sortable" style="width:313px;height:440px;position:absolute;top:0;right:0;"><center>
			<span id="stitle" style="font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold; font-weight: bold;"><strong><? echo $f16; ?></strong></span><br>
		</center></div><br>
</div></center>
<br>
<div id='gohere'>
<center>
<?
		$respURL = "http://sitecostcalculator.com/parser.php";
		$c = file_get_contents($respURL);
		if ($c == 'no') {
			?>
			<?
		} else {
		?>
			<script src="parser.php" type="text/javascript"></script>
		<? } ?>
	
</center>
<center>
<div id="res" style="width:1150px;position:relative;"><center>
<table>
<tr>
<td><iframe src="grDaily.php?lang=<? echo $lang; ?>" width="520" height="450" align="center" frameborder="no"></iframe></td>
<td><iframe src="grAge.php?lang=<? echo $lang; ?>" width="520" height="450" align="center" frameborder="no"></iframe></td>
</tr>
<?
$com = 1;
$net = 1;
$org = 1;
$info = 1;
$biz = 1;
$co = 1;
$us = 1;
$ru = 1;
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.com'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$com = $row[num];
}
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.net'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$net = $row[num];
}
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.org'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$org = $row[num];
}
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.info'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$info = $row[num];
}
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.biz'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$biz = $row[num];
}
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.co'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$co = $row[num];
}
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.us'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$us = $row[num];
}
$sql = "SELECT COUNT(*) as num FROM worth WHERE domain like '%.ru'";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$ru = $row[num];
}
?>
</table>
<br>
<img src="http://chart.apis.google.com/chart?chf=a,s,000000A5&chs=500x400&cht=p3&chco=00FF00|0000FF|80C65A|C3D9FF|B1B15F|AA0033|3399CC|DF0AFF&chd=t:<? echo $com.",".$net.",".$org.",".$info.",".$biz.",".$co.",".$us.",".$ru; ?>&chdl=COM+(<?echo number_format($com, 0, ',', ',');?>)|NET+(<?echo number_format($net, 0, ',', ',');?>)|ORG+(<?echo number_format($org, 0, ',', ',');?>)|INFO+(<?echo number_format($info, 0, ',', ',');?>)|BIZ+(<?echo number_format($biz, 0, ',', ',');?>)|CO+(<?echo number_format($co, 0, ',', ',');?>)|US+(<?echo number_format($us, 0, ',', ',');?>)|RU+(<?echo number_format($ru, 0, ',', ',');?>)&chp=0.3&chtt=<? echo $f17; ?>" width="500" height="400" alt="Most useful TLDs" /></center>
</div>
</center>
</div>
<?
if ($mainDomain == 'sitecostcalculator.ru') {
echo "<center><br><br><br><div id=\"vk_comments\"></div><script type=\"text/javascript\">
     //<![CDATA[
	VK.Widgets.Comments(\"vk_comments\", {limit: 10, width: \"496\", attach: \"*\"});
     //]]>
    </script></center>";
} else {
echo "<center><br><br><br><div class=\"fb-like-box\" data-href=\"http://www.facebook.com/pages/Site-Cost-Calculator/123508884403158\" data-width=\"1150\" data-height=\"300\" data-show-faces=\"true\" data-stream=\"false\" data-header=\"true\"></div></center>";
}
?>
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
mysql_close($con);
?>
<script type="text/javascript"> <!--
    lastCalculated(1);
	sortAllPag('', 'United States', 1);
//--> </script>
</body>
</html>