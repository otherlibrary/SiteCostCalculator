<?
include 'class.seostats.php';
$domain = $_GET['domain'];
$url = new SEOstats("http://".$_GET['domain']);
$v = $url->Alexa_Pageviews();
$searchVisits = $v['1 Month']['value'];
$url = new SEOstats("http://".$_GET['domain']);
$speedStr = $url->Alexa_Avg_Load_Time();
list($s1, $sec) = explode(" ", $speedStr);
$s = substr($sec, 1, strlen($sec));
if ($s == 'ata') {
	$s = 1;
}
$loadTime = $s;
function GetPageRank($q,$host='toolbarqueries.google.com',$context=NULL) {
	$seed = "Mining PageRank is AGAINST GOOGLE'S TERMS OF SERVICE. Yes, I'm talking to you, scammer.";
	$result = 0x01020345;
	$len = strlen($q);
	for ($i=0; $i<$len; $i++) {
		$result ^= ord($seed{$i%strlen($seed)}) ^ ord($q{$i});
		$result = (($result >> 23) & 0x1ff) | $result << 9;
	}
	$ch=sprintf('8%x', $result);
	$url='http://%s/tbr?client=navclient-auto&ch=%s&features=Rank&q=info:%s';
	$url=sprintf($url,$host,$ch,$q);
	@$pr=file_get_contents($url,false,$context);
	return $pr?substr(strrchr($pr, ':'), 1):false;
}
$PR = GetPageRank($_GET['domain']);
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
	$string = $value;
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
$domainLength = strlen($domain);
$domainAge = getDomainAge($domain);
if (!$PR || $PR == 0) {
	$prRate = 1;
} else {
	$prRate = $PR;
}
if ($domainAge != 'Unknown') {
	list($y, $s) = explode(" ", $domainAge);
}
if ($y < 1) {
	$y = 1;
}
if ($loadTime == 'ast') {
	$loadTime = 1;
}
function getGooglePages($host) {
	$request = "http://www.google.com/search?q=" . urlencode("site:" . $host) . "&hl=en";
	$data = getPageData($request);
	preg_match('/<div id=resultStats>(About )?([\d,]+) result/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "0";
	return $value;
}


$googleIndexedPages = getGooglePages($domain);

if (is_nan($googleIndexedPages) || $googleIndexedPages == 0) {
	$googleIndexedPages = 1;
}


$formula = $prRate * $y * $domainLength * $searchVisits;
$formula = $formula * $loadTime;
$formula = $formula * $googleIndexedPages;
$formula = $formula * 10075 * 9;
$formula = round($formula);
echo $formula;
?>