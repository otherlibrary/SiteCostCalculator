<?
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
$lang = rtrim($_GET['lang'], '/');

preg_match("/^(http:\/\/)?([^\/]+)/i", curPageURL(), $matches);
$host = $matches[2];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

$mainDomain = "{$matches[0]}";

require_once('mobile_device_detect.php');
$mobile = mobile_device_detect();

$fullRedirect = str_replace ($mainDomain, "sitecostcalculator.com", curPageURL());

if (!$mobile) {
	//Header("Location: ".$fullRedirect);
}

if ($lang) {
include($lang.".php");
include($lang."_mob.php");
$newRu = str_replace("lang=en", "lang=ru", curPageURL());
$newEn = str_replace("lang=ru", "lang=en", curPageURL());
} else {
$lang = "en";
include("en.php");
include("en_mob.php");
$newRu = "http://sitecostcalculator.com/mob.php?lang=ru";
$newEn = "http://sitecostcalculator.com/mob.php?lang=en";
}


?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7412096-36']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Site Cost Calculator mobive version - Estimate website cost | Calculate traffic | Income from Contextual Advertising | Full domain and website statistics |  | Sell website | Buy website</title>
<meta name='keywords' content='site cost calculator, estimate web traffic, contextual advertising, number of indexed pages, website daily earning, buy websites, sell websites' />
<meta name='description' content='Free, easy and convenient tool for estimating the cost of site traffic, daily earnings, comparing with other sites; detailed information about the domain, and much more' />
<link href="../pagination.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/rounded-corners.js"></script>
<script type='text/javascript' src='../js/common.js'></script>
<script type="text/javascript" src="../js/prototype.js"></script>
<script type="text/javascript">

	function search(page, type) {
		var en = document.getElementById('en').checked;
		var ru = document.getElementById('ru').checked;
		var lang_ = "";
		if (en) {
			lang_ = "en";
		}
		if (ru) {
			lang_ = "ru";
		}
		if (!en && !ru) {
			lang_ = "all";
		}
		if (en && ru) {
			lang_ = "all";
		}
		var siteTitle = document.getElementById('siteTitle').value;
		siteTitle = siteTitle.replace(/"/g,'').replace(/'/g,'');
		var siteDesc = document.getElementById('siteDesc').value;
		siteDesc = siteDesc.replace(/"/g,'').replace(/'/g,'');
		var siteKeys = document.getElementById('siteKeys').value;
		siteKeys = siteKeys.replace(/"/g,'').replace(/'/g,'');
		var siteAge = document.getElementById('siteAge').value;
		siteAge = siteAge.replace(/"/g,'').replace(/'/g,'');
		var sitePr = document.getElementById('sitePr').value;
		sitePr = sitePr.replace(/"/g,'').replace(/'/g,'');
		var siteCostFrom = document.getElementById('siteCostFrom').value;
		siteCostFrom = siteCostFrom.replace(/"/g,'').replace(/'/g,'');
		var siteCostTo = document.getElementById('siteCostTo').value;
		siteCostTo = siteCostTo.replace(/"/g,'').replace(/'/g,'');
		var siteInFrom = document.getElementById('siteInFrom').value;
		siteInFrom = siteInFrom.replace(/"/g,'').replace(/'/g,'');
		var siteInTo = document.getElementById('siteInTo').value;
		siteInTo = siteInTo.replace(/"/g,'').replace(/'/g,'');
		var siteOutFrom = document.getElementById('siteOutFrom').value;
		siteOutFrom = siteOutFrom.replace(/"/g,'').replace(/'/g,'');
		var siteOutTo = document.getElementById('siteOutTo').value;
		siteOutTo = siteOutTo.replace(/"/g,'').replace(/'/g,'');
		var siteIncomeTypes = document.getElementById('siteIncomeTypes').value;
		siteIncomeTypes = siteIncomeTypes.replace(/"/g,'').replace(/'/g,'');
		var siteAlexa = document.getElementById('siteAlexa').value;
		siteAlexa = siteAlexa.replace(/"/g,'').replace(/'/g,'');
		document.getElementById('searchRes').innerHTML = "<center><br><br><img src='loader.gif'></center>";
		var p = 'lang=' + lang_ + '&siteTitle=' + siteTitle + '&siteDesc=' + siteDesc + '&siteKeys=' + siteKeys + '&siteAge=' + siteAge + '&sitePr=' + sitePr + '&siteCostFrom=' + siteCostFrom + '&siteCostTo=' + siteCostTo + '&siteInFrom=' + siteInFrom + '&siteInTo=' + siteInTo + '&siteOutFrom=' + siteOutFrom + '&siteOutTo=' + siteOutTo + '&siteIncomeTypes=' + siteIncomeTypes + '&siteAlexa=' + siteAlexa + '&language=<? echo $lang; ?>&page=' + page + '&type=' + type;
		new Ajax.Request('seo/search.php', {
		  method: 'GET',
		  parameters: p,
		  onSuccess: function(response) {
		      var html = response.responseText;
		      document.getElementById('searchRes').innerHTML = html;
		      ScrollToElement(document.getElementById('searchRes'));
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
	function loadMain2() {
		var domain = document.getElementById('url').value;
		domain = domain.replace(/ /g,'');
		domain = domain.replace("http://www.","");
		domain = domain.replace("http://","");
		if (domain.indexOf('www.') === 0) {
			domain = domain.replace("www.","");
		}
		window.location.href = "http://sitecostcalculator.com/mob.php?domain=" + domain + '&lang=<? echo $lang; ?>';
	}

	function updateTitle(domain) {
		document.getElementById('w_title').innerHTML = "<img src='loader2.gif' style='position:relative; padding-left:5px;margin-bottom:-5px;'>";
		new Ajax.Request('seo/updateTitle.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('w_title').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}
	function updateDescription(domain) {
		document.getElementById('w_desc').innerHTML = "<img src='loader2.gif' style='position:relative; padding-left:5px;margin-bottom:-5px;'>";
		new Ajax.Request('seo/updateDescription.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('w_desc').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}
	function updateKeys(domain) {
		document.getElementById('w_keys').innerHTML = "<img src='loader2.gif' style='position:relative; padding-left:5px;margin-bottom:-5px;'>";
		new Ajax.Request('seo/updateKeys.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var html3 = response.responseText;
		      document.getElementById('w_keys').innerHTML = html3;
		  }
		});									  						      						      								      						      		
 	}
function updateLinks(a){document.getElementById("googleIndexedPages").innerHTML="<center><img src='a.gif'></center>";new Ajax.Request("seo/r.php?domain="+a+"&custom=true&what=googleIndexedPages",{onSuccess:function(b){var c=b.responseText;document.getElementById("googleIndexedPages").innerHTML=c;document.getElementById("bingLinks").innerHTML="<center><img src='a.gif'></center>";new Ajax.Request("seo/r.php?domain="+a+"&custom=true&what=bingLinks",{onSuccess:function(b){var c=b.responseText;document.getElementById("bingLinks").innerHTML=c;document.getElementById("alexaLinks").innerHTML="<center><img src='a.gif'></center>";new Ajax.Request("seo/r.php?domain="+a+"&custom=true&what=alexaLinks",{onSuccess:function(b){var c=b.responseText;document.getElementById("alexaLinks").innerHTML=c;document.getElementById("bingIndexedPages").innerHTML="<center><img src='a.gif'></center>";new Ajax.Request("seo/r.php?domain="+a+"&custom=true&what=bingIndexedPages",{onSuccess:function(b){var c=b.responseText;document.getElementById("bingIndexedPages").innerHTML=c;document.getElementById("dmozCat").innerHTML="<center><img src='a.gif'></center>";new Ajax.Request("seo/r.php?domain="+a+"&custom=true&what=dmozCat",{onSuccess:function(b){var c=b.responseText;document.getElementById("dmozCat").innerHTML=c;document.getElementById("advisorRel").innerHTML="<center><img src='a.gif'></center>";new Ajax.Request("seo/r.php?domain="+a+"&custom=true&what=advisorRel",{onSuccess:function(b){var c=b.responseText;document.getElementById("advisorRel").innerHTML="<img src='"+c+"'>";document.getElementById("WOTRating").innerHTML="<center><img src='a.gif'></center>";new Ajax.Request("seo/r.php?domain="+a+"&custom=true&what=WOTRating",{onSuccess:function(a){var b=a.responseText;document.getElementById("WOTRating").innerHTML=b}})}})}})}})}})}})}})}
	function loadMain() {
		var all;
		var domain = document.getElementById('url').value;
		domain = domain.replace(/ /g,'');
		domain = domain.replace("http://www.","");
		domain = domain.replace("http://","");
		if (domain.indexOf('www.') === 0) {
			domain = domain.replace("www.","");
		}
		document.getElementById('logo').innerHTML = "<center><? echo $f4; ?><br><img src='loader.gif'></center>";
		document.getElementById('res').innerHTML = "";
		new Ajax.Request('getInfoMob.php?domain=' + domain + '&lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		        all = html;
				html = html.replace(/^\s+|\s+$/g,"");
				if (html.length < 3) {
					document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'><? echo $f4_; ?></font><br><img src='loader.gif'></center>";					
					new Ajax.Request('web.php?url=' + domain, {
					  onSuccess: function(response) {
							document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'><? echo $fadd1; ?></font><br><img src='loader.gif'></center>";
							new Ajax.Request('seo/prUpdate.php?domain=' + domain, {
							  onSuccess: function(response) {
								document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'><? echo $fadd2; ?></font><br><img src='loader.gif'></center>";
								new Ajax.Request('seo/saveGoogleBacks.php?domain=' + domain, {
								  onSuccess: function(response) {
									document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'><? echo $add2_; ?></font><br><img src='loader.gif'></center>";
									new Ajax.Request('seo/saveYahooBacks.php?domain=' + domain, {
									  onSuccess: function(response) {
										document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'><? echo $fadd4; ?></font><br><img src='loader.gif'></center>";
										new Ajax.Request('seo/r.php?domain=' + domain, {
										  onSuccess: function(response) {
											document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'>3</font><br><img src='loader2.gif'></center>";
											new Ajax.Request('seo/updateTitle.php?domain=' + domain, {
											  onSuccess: function(response) {
												document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'>2</font><br><img src='loader2.gif'></center>";
												new Ajax.Request('seo/updateDescription.php?domain=' + domain, {
												  onSuccess: function(response) {
													document.getElementById('logo').innerHTML = "<center><font style='font-family: georgia, serif; font-size:12pt;'>1</font><br><img src='loader2.gif'></center>";
													new Ajax.Request('seo/updateKeys.php?domain=' + domain, {
													  onSuccess: function(response) {
														new Ajax.Request('seo/sale.php?domain=' + domain, {
														  onSuccess: function(response) {
															new Ajax.Request('getInfoMob.php?domain=' + domain + '&lang=<? echo $lang; ?>', {
															  onSuccess: function(response) {
															      var html2 = response.responseText;
															      if (html2.length < 3) {
																      document.getElementById('res').innerHTML = "Nope";
															      }
															      document.getElementById('logo').innerHTML = "";
															      document.getElementById('res').innerHTML = html2;
															      ScrollToElement(document.getElementById('res'));
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
						document.getElementById('logo').innerHTML = "";				
						document.getElementById('res').innerHTML = all;
						ScrollToElement(document.getElementById('res'));
				}		      
		  }
		});
 	}
	function updateTags() {
		var domain = document.getElementById('updateT').value;
		document.getElementById('updateTw').innerHTML = "<img src='loader2.gif' style='margin-bottom:-7px;'>";
		new Ajax.Request('getIdByDomain.php?domain=' + domain, {
		  onSuccess: function(response) {
		      var id = response.responseText;
		      if (id === 'bad-1') {
			      document.getElementById('updateTw').innerHTML = '<? echo $saleUpd3; ?>';

		      } else {
			 if (id === 'bad-2') {
				updateNew(domain);
			 } else {
				new Ajax.Request('seo/sale.php?domain=' + domain, {
				  onSuccess: function(response) {
				      var res = response.responseText;
				      if (res === 'good') {
					new Ajax.Request('saleInfo.php?domain=' + domain + '&lang=<? echo $lang; ?>', {
					  onSuccess: function(response) {
					      var html4 = response.responseText;
					     document.getElementById('updateTw').innerHTML = "<? echo $saleUpd1; ?>: <a href='http://sitecostcalculator.com/mob.php?domain=" + domain + "&lang=<? echo $lang; ?>'>http://sitecostcalculator.com/mob.php?domain=" + domain + "&lang=<? echo $lang; ?></a><br><br><font style='background-color:rgb(175, 238, 166);'><? echo $saleGood; ?></font><br><br>" + html4 + "<br><br><? echo $unsale; ?>";
					  }
					});
				      }
				      if (res === 'bad') {
					document.getElementById('updateTw').innerHTML = "<? echo $saleUpd2; ?>";
				      }
				  }
				});

			}
		      }
		  }
		});
 	}
	function loadHowToSell() {
		document.getElementById('res').innerHTML = "<center><b><? echo $processing; ?></b><br><img src='loader.gif'><br><br></center></a>";
		new Ajax.Request('forsale.php?lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('res'));
		  }
		});	
 	}
	function loadSell() {
		document.getElementById('res').innerHTML = "<center><b><? $processing; ?></b><br><img src='loader.gif'><br><br></center></a>";
		new Ajax.Request('saleSearch.php?lang=<? echo $lang; ?>', {
		  onSuccess: function(response) {
		        var html = response.responseText;
		      document.getElementById('res').innerHTML = html;
		      ScrollToElement(document.getElementById('res'));
		  }
		});	
 	}

</script>
</head>
<body>
<div style="width:320px;position:relative;overflow:auto;">
	<div><center>
	<table>
	<tr><td><a href="<? echo $newEn; ?>"><img src="../images/en.png" style="border:none;"></a></td><td>&nbsp;&nbsp;</td><td><a href="<? echo $newRu; ?>"><img src="../images/ru.png" style="border:none;"></a></td></tr>
	</table>
	<font style='font-family: georgia, serif; font-size:10pt;'>
	<a href="#" onclick="loadHowToSell();"><? echo $mobH; ?></a><br><br><a href="#" onclick="loadSell();"><? echo $mobS; ?></a>
	</font>
	</center>
	<div>
<br>
<center><font style='font-family: georgia, serif; font-size:15pt;'><? echo $mobTitle; ?></font><br><br>
<div id="logo"></div><br>
<input type="text" class="rc10" name="url" id="url"
	   style="margin-left:10px;margin-right:10px;width: 160px; height: 25px; background-color: rgb(230, 230, 221); border: 1px solid #b4b4b4; font-family: georgia, serif; color: #2a2a2a; font-size:11pt; color: #555555; text-align: center;" />
	   <br><input type="button" value="<? echo $mobCalc; ?>" style="height:25px;" onclick="loadMain2();">
</center><br><br>
<div id="res"></div>
</div>
<?
$d = $_GET['domain'];
if ($d) {
echo "<script type=\"text/javascript\"> 
     //<![CDATA[
	document.getElementById(\"url\").value = \"".$d."\";
	loadMain();
     //]]>
    </script>";
}
?>
</body>
</html>