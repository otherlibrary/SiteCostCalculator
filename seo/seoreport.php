<?

function getGooglePages($host) {
	$request = "http://www.google.com/search?q=" . urlencode("site:" . $host) . "&amp;amp;hl=en";
	$data = getPageData($request);
	preg_match('/&lt;div id=resultStats&gt;(About )?([\d,]+) result/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getGoogleLinks($host) {
	$request = "http://www.google.com/search?q=" . urlencode("link:" . $host) . "&amp;amp;hl=en";
	$data = getPageData($request);
	preg_match('/&lt;div id=resultStats&gt;(About )?([\d,]+) result/si', $data, $l);
	$value = ($l[2]) ? $l[2] : "n/a";
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getYahooPages($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=" . urlencode("http://" . $host);
	$data = getPageData($request);
	preg_match('/Pages \(([\d,]+)/si', $data, $p);
	$value = ($p[1]) ? $p[1] : "n/a";
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getYahooLinks($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=" . urlencode("http://" . $host);
	$data = getPageData($request);
	preg_match('/Inlinks \(([\d,]+)/si', $data, $l);
	$value = ($l[1]) ? $l[1] : "n/a";
	$string.= "&lt;a href=\"" . $request . "&amp;amp;bwm=i\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getBingPages($host) {
	$request = "http://www.bing.com/search?q=" . urlencode("site:" . $host) . "&amp;amp;mkt=en-US";
	$data = getPageData($request);
	preg_match('/1-([\d]+) of ([\d,]+)/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getBingLinks($host) {
	$request = "http://www.bing.com/search?q=" . urlencode("inbody:" . $host) . "&amp;amp;mkt=en-US";
	$data = getPageData($request);
	preg_match('/1-([\d]+) of ([\d,]+)/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getAskPages($host) {
	$request = "http://www.ask.com/web?q=" . urlencode($host . " site:" . $host);
	$data = getPageData($request);
	preg_match('/&lt;span id=\'indexLast\' class=\'b\'&gt;([\d]+)&lt;\/span&gt; of ([\d,]+)/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getAlexaRank($domain) {
	$request = "http://data.alexa.com/data?cli=10&amp;amp;dat=s&amp;amp;url=" . $domain;
	$data = getPageData($request);
	preg_match('/&lt;POPULARITY URL="(.*?)" TEXT="([\d]+)"\/&gt;/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "&lt;a href=\"http://www.alexa.com/siteinfo/" . $domain . "\"&gt;" . number_format($value) . "&lt;/a&gt;";
	return $string;
}

function getAlexaLinks($domain) {
	$request = "http://data.alexa.com/data?cli=10&amp;amp;dat=s&amp;amp;url=" . $domain;
	$data = getPageData($request);
	preg_match('/&lt;LINKSIN NUM="([\d]+)"\/&gt;/si', $data, $l);
	$value = ($l[1]) ? $l[1] : "n/a";
	$string = "&lt;a href=\"http://www.alexa.com/site/linksin/" . $domain . "\"&gt;" . number_format($value) . "&lt;/a&gt;";
	return $string;
}

function getDMOZListings($domain) {
	$request = "http://data.alexa.com/data?cli=10&amp;amp;url=" . $domain;
	$data = getPageData($request);
	preg_match('/&lt;SITE BASE="(.*?)" TITLE="(.*?)" DESC="(.*?)"&gt;/si', $data, $s);
	$value1 = ($s[1]) ? $s[1] : "";
	$value2 = ($s[2]) ? $s[2] : "";
	$value3 = ($s[3]) ? $s[3] : "";
	preg_match('/&lt;CAT ID="(.*?)" TITLE="(.*?)" CID="(.*?)"\/&gt;/si', $data, $c);
	$value4 = ($c[1]) ? $c[1] : "";
	$value5 = ($c[2]) ? $c[2] : "";
	$value6 = ($c[3]) ? $c[3] : "";
	$string = "";
	if($value4) {
		$string = "&lt;a href=\"http://www.dmoz.org/" . str_replace("Top/","", $value4) . "\" title=\"" . $value2 . " - " . $value3 . "\"&gt;" . $value5 . "&lt;/a&gt;";
	}
	else $string = "n/a";
	return $string;
}

function getSiteAdvisorRating($domain) {
	$request = "http://www.siteadvisor.com/sites/" . $domain . "?ref=safe&amp;amp;locale=en-US";
	$data = getPageData($request);
	preg_match('/(green|yellow|red)-xbg2\.gif/si', $data, $r);
	$value = ($r[1]) ? $r[1] : "grey";
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getWOTRating($domain) {
	$request = "http://api.mywot.com/0.4/public_query2?target=" . $domain;
	$data = getPageData($request);
	preg_match_all('/&lt;application name="(\d+)" r="(\d+)" c="(\d+)"\/&gt;/si', $data, $regs);
	$trustworthiness = ($regs[2][0]) ? $regs[2][0] : -1;
	$values = array("trustworthy","mostly","suspicious","untrustworthy","dangerous","unknown");
	if($trustworthiness&gt;=80) $value = $values[0];
	elseif($trustworthiness&gt;=60) $value = $values[1];
	elseif($trustworthiness&gt;=40) $value = $values[2];
	elseif($trustworthiness&gt;=20) $value = $values[3];
	elseif($trustworthiness&gt;=0) $value = $values[4];
	else $value = $values[5];
	$string = "&lt;a href=\"http://www.mywot.com/en/scorecard/" . $domain . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getDomainAge($domain) {
	$request = "http://reports.internic.net/cgi/whois?whois_nic=" . $domain . "&amp;type=domain";
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
	$string = "&lt;a href=\"" . $request . "\"&gt;" . $value . "&lt;/a&gt;";
	return $string;
}

function getPageData($url) {
	if(function_exists('curl_init')) {
		$ch = curl_init($url); // initialize curl with given url
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // add useragent
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
		if((ini_get('open_basedir') == '') &amp;&amp; (ini_get('safe_mode') == 'Off')) {
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

echo getGooglePages('mail.ru');

?>