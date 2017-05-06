<?
include ("config.php");

function getGooglePages($host) {
	$request = "http://www.google.com/search?q=" . urlencode("site:" . $host) . "&hl=en";
	$data = getPageData($request);
	preg_match('/<div id=resultStats>(About )?([\d,]+) result/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "0";
	return $value;
}

function getGoogleLinks($host) {
	$request = "http://www.google.com/search?q=" . urlencode("link:" . $host) . "&hl=en";
	$data = getPageData($request);
	preg_match('/<div id=resultStats>(About )?([\d,]+) result/si', $data, $l);
	$value = ($l[2]) ? $l[2] : "0";
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getYahooPagesSubdomains($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=$host";
	$data = getPageData($request);
	//$begPos = strpos($data, '<span class="btn">Pages (');
	preg_match('/Pages \(([\d,]+)/si', $data, $p);
	$value = ($p[1]) ? $p[1] : "0";
	return $value;
}
function getYahooPagesMainDomain($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=$host&bwmf=d";
	$data = getPageData($request);
	//$begPos = strpos($data, '<span class="btn">Pages (');
	preg_match('/Pages \(([\d,]+)/si', $data, $p);
	$value = ($p[1]) ? $p[1] : "0";
	return $value;
}

function getYahooLinksExceptFromThisDomain($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=$host&bwmf=u&bwmo=d&bwm=i";
	$data = getPageData($request);
	preg_match('/Inlinks \(([\d,]+)/si', $data, $l);
	$value = ($l[1]) ? $l[1] : "0";
	return $value;
}

function getYahooLinksFromAllPages($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=$host&bwm=i&bwmo=&bwmf=u";
	$data = getPageData($request);
	preg_match('/Inlinks \(([\d,]+)/si', $data, $l);
	$value = ($l[1]) ? $l[1] : "0";
	return $value;
}

function getBingPages($host) {
	$request = "http://www.bing.com/search?q=" . urlencode("site:" . $host) . "&mkt=en-US";
	$data = getPageData($request);
	preg_match('/1-([\d]+) of ([\d,]+)/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "0";
	return $value;
}

function getBingLinks($host) {
	$request = "http://www.bing.com/search?q=" . urlencode("inbody:" . $host) . "&mkt=en-US";
	$data = getPageData($request);
	preg_match('/1-([\d]+) of ([\d,]+)/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "0";
	return $value;
}

function getAlexaRank($domain) {
	$request = "http://data.alexa.com/data?cli=10&dat=s&url=" . $domain;
	$data = getPageData($request);
	preg_match('/<POPULARITY URL="(.*?)" TEXT="([\d]+)"\/>/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "0";
	$string = "<a href=\"http://www.alexa.com/siteinfo/" . $domain . "\">" . number_format($value) . "</a>";
	return $string;
}

function getAlexaLinks($domain) {
	$request = "http://data.alexa.com/data?cli=10&dat=s&url=" . $domain;
	$data = getPageData($request);
	preg_match('/<LINKSIN NUM="([\d]+)"\/>/si', $data, $l);
	$value = ($l[1]) ? $l[1] : "0";
	return $value;
}

function getDMOZListings($domain) {
	$request = "http://data.alexa.com/data?cli=10&url=" . $domain;
	$data = getPageData($request);
	preg_match('/<SITE BASE="(.*?)" TITLE="(.*?)" DESC="(.*?)">/si', $data, $s);
	$value1 = ($s[1]) ? $s[1] : "";
	$value2 = ($s[2]) ? $s[2] : "";
	$value3 = ($s[3]) ? $s[3] : "";
	preg_match('/<CAT ID="(.*?)" TITLE="(.*?)" CID="(.*?)"\/>/si', $data, $c);
	$value4 = ($c[1]) ? $c[1] : "";
	$value5 = ($c[2]) ? $c[2] : "";
	$value6 = ($c[3]) ? $c[3] : "";
	$string = "";
	if($value4) {
		$string = "<a target=\"_blank\" href=\"../go.php?to=http://www.dmoz.org/".str_replace("Top/","", $value4)."\" title=\"".$value2." - ".$value3."\">".$value5."</a>";
	}
	else $string = "not listed";
	return $string;
}

function getSiteAdvisorRating($domain) {
	$request = "http://www.siteadvisor.com/sites/" . $domain . "?ref=safe&locale=en-US";
	$data = getPageData($request);
	preg_match('/(green|yellow|red)-xbg2\.gif/si', $data, $r);
	$value = ($r[1]) ? $r[1] : "grey";
	$string = "<a target='_blank' href='go.php?to=$request'><img src='$value.gif' style='border:none;'></a>";
	return $string;
}

function getWOTRating($domain) {
	$request = "http://api.mywot.com/0.4/public_query2?target=" . $domain;
	$data = getPageData($request);
	preg_match_all('/<application name="(\d+)" r="(\d+)" c="(\d+)"\/>/si', $data, $regs);
	$trustworthiness = ($regs[2][0]) ? $regs[2][0] : -1;
	$values = array("trustworthy","mostly","suspicious","untrustworthy","dangerous","unknown");
	if($trustworthiness >=80) $value = $values[0];
	elseif($trustworthiness>=60) $value = $values[1];
	elseif($trustworthiness>=40) $value = $values[2];
	elseif($trustworthiness>=20) $value = $values[3];
	elseif($trustworthiness>=0) $value = $values[4];
	else $value = $values[5];
	$string = "<a target='_blank' href='../go.php?to=http://www.mywot.com/en/scorecard/". $domain."'>".$value."</a>";
	return $string;
}

function getDomainAge($domain) {
	$request = "http://reports.internic.net/cgi/whois?whois_nic=" . $domain . "&type=domain";
	$data = getPageData($request);
	preg_match('/Creation Date: ([a-z0-9-]+)/si', $data, $p);
	if(!$p[1]) {
		$value = "Unknown";
	}
	else {
		$time = time() - strtotime($p[1]);
		$years = floor($time / 31556926);
		$days = floor(($time % 31556926) / 86400);
		if($years == "1") {
			$y= "1 year";
		}
		else {
			$y = $years . " years";
		}
		if($days == "1") {
			$d = "1 day";
		}
		else {
			$d = $days . " days";
		}
		$value = "$y, $d";
	}
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getPageData($url) {
	if(function_exists('curl_init')) {
		$ch = curl_init($url); // initialize curl with given url
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // add useragent
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
		if((ini_get('open_basedir') == '') && (ini_get('safe_mode') == 'Off')) {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // max. seconds to execute
		curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
		return @curl_exec($ch);
	}
	else {
		return @file_get_contents($url);
	}
}

function getDomainName($host) {
	$hostparts = explode('.', $host); // split host name to parts
	$num = count($hostparts); // get parts number
	if(preg_match('/^(ac|arpa|biz|co|com|edu|gov|info|int|me|mil|mobi|museum|name|net|org|pp|tv)$/i', $hostparts[$num-2])) { // for ccTLDs like .co.uk etc.
		$domain = $hostparts[$num-3] . '.' . $hostparts[$num-2] . '.' . $hostparts[$num-1];
	}
	else {
		$domain = $hostparts[$num-2] . '.' . $hostparts[$num-1];
	}
	return $domain;
}
$domain = $_GET['domain'];
if (isset($_GET['custom'])) {
	$what = $_GET['what'];
	if ($what == 'googleIndexedPages') {
		$googleIndexedPages = getGooglePages($domain);		
		$sql = "UPDATE worth SET worth.googleIndexedPages = '".mysql_real_escape_string($googleIndexedPages)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $googleIndexedPages;
	}
	if ($what == 'yahooIndexedPagesMainDomain') {
		$yahooIndexedPagesMainDomain = getYahooPagesMainDomain($domain);		
		$sql = "UPDATE worth SET worth.yahooIndexedPagesMainDomain = '".mysql_real_escape_string($yahooIndexedPagesMainDomain)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $yahooIndexedPagesMainDomain;
	}
	if ($what == 'yahooIndexedPagesSubdomains') {
		$yahooIndexedPagesSubdomains = getYahooPagesSubdomains($domain);		
		$sql = "UPDATE worth SET worth.yahooIndexedPagesSubdomains = '".mysql_real_escape_string($yahooIndexedPagesSubdomains)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $yahooIndexedPagesSubdomains;
	}
	if ($what == 'bingIndexedPages') {
		$bingIndexedPages = getBingPages($domain);		
		$sql = "UPDATE worth SET worth.bingIndexedPages = '".mysql_real_escape_string($bingIndexedPages)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $bingIndexedPages;
	}
	if ($what == 'yahooLinksExceptFromThisDomain') {
		$yahooLinksExceptFromThisDomain = getYahooLinksExceptFromThisDomain($domain);
		$sql = "UPDATE worth SET worth.yahooLinksExceptFromThisDomain = '".mysql_real_escape_string($yahooLinksExceptFromThisDomain)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $yahooLinksExceptFromThisDomain;
	}
	if ($what == 'yahooLinksFromAllPages') {
		$yahooLinksFromAllPages = getYahooLinksFromAllPages($domain);		
		$sql = "UPDATE worth SET worth.yahooLinksFromAllPages = '".mysql_real_escape_string($yahooLinksFromAllPages)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $yahooLinksFromAllPages;
	}
	if ($what == 'bingLinks') {
		$bingLinks = getBingLinks($domain);		
		$sql = "UPDATE worth SET worth.bingLinks = '".mysql_real_escape_string($bingLinks)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $bingLinks;
	}
	if ($what == 'alexaLinks') {
		$alexaLinks = getAlexaLinks($domain);		
		$sql = "UPDATE worth SET worth.alexaLinks = '".mysql_real_escape_string($alexaLinks)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $alexaLinks;
	}
	if ($what == 'dmozCat') {
		$dmozCat = getDMOZListings($domain);		
		$sql = "UPDATE worth SET worth.dmozCat = '".mysql_real_escape_string($dmozCat)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $dmozCat;
	}
	if ($what == 'advisor') {
		$advisor = getSiteAdvisorRating($domain);		
		$sql = "UPDATE worth SET worth.advisor = '".mysql_real_escape_string($advisor)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $advisor;
	}
	if ($what == 'advisorRel') {
		$advisorRel = "http://www.siteadvisor.com/sites/$domain/linkgraph/linkgraph.png";		
		$sql = "UPDATE worth SET worth.advisorRel = '".mysql_real_escape_string($advisorRel)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $advisorRel;
	}
	if ($what == 'WOTRating') {
		$WOTRating = getWOTRating($domain);		
		$sql = "UPDATE worth SET worth.WOTRating = '".mysql_real_escape_string($WOTRating)."' WHERE domain='$domain'";
		$rs_result = mysql_query($sql);
		echo $WOTRating;
	}
} else {
	$googleIndexedPages = getGooglePages($domain);
	$yahooIndexedPagesMainDomain = getYahooPagesMainDomain($domain);
	$yahooIndexedPagesSubdomains = getYahooPagesSubdomains($domain);
	$bingIndexedPages = getBingPages($domain);
	$yahooLinksExceptFromThisDomain = getYahooLinksExceptFromThisDomain($domain);
	$yahooLinksFromAllPages = getYahooLinksFromAllPages($domain);
	$bingLinks = getBingLinks($domain);
	$alexaLinks = getAlexaLinks($domain);
	$dmozCat = getDMOZListings($domain);
	$advisor = getSiteAdvisorRating($domain);
	$advisorRel = "http://www.siteadvisor.com/sites/$domain/linkgraph/linkgraph.png";
	$WOTRating = getWOTRating($domain);

	$allbacks =  str_replace (",", "", $yahooLinksFromAllPages) + str_replace (",", "", $bingLinks) + str_replace (",", "", $alexaLinks);

	$sql = "UPDATE worth SET
	worth.googleIndexedPages = '".mysql_real_escape_string($googleIndexedPages)."',
	worth.yahooIndexedPagesMainDomain = '".mysql_real_escape_string($yahooIndexedPagesMainDomain)."',
	worth.yahooIndexedPagesSubdomains = '".mysql_real_escape_string($yahooIndexedPagesSubdomains)."',
	worth.bingIndexedPages = '".mysql_real_escape_string($bingIndexedPages)."',
	worth.yahooLinksExceptFromThisDomain = '".mysql_real_escape_string($yahooLinksExceptFromThisDomain)."',
	worth.yahooLinksFromAllPages = '".mysql_real_escape_string($yahooLinksFromAllPages)."',
	worth.bingLinks = '".mysql_real_escape_string($bingLinks)."',
	worth.alexaLinks = '".mysql_real_escape_string($alexaLinks)."',
	worth.dmozCat = '".mysql_real_escape_string($dmozCat)."',
	worth.advisor = '".mysql_real_escape_string($advisor)."',
	worth.advisorRel = '".mysql_real_escape_string($advisorRel)."',
	worth.allbacks = '".mysql_real_escape_string($allbacks)."',
	worth.WOTRating = '".mysql_real_escape_string($WOTRating)."' WHERE domain='$domain'";
	$rs_result = mysql_query($sql);
	echo $rs_result;
}
mysql_close($con);
?>