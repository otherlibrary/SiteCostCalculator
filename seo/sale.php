<?
function get_meta_data($content) {
	$content = strtolower($content);
	$pos = strpos($content, 'content-type');
	$res_ = "";
	if ($pos === false) {
	} else {
		$content_ = substr($content, $pos, 200);
		$arr = str_split($content_);
		for ($i = 0; $i < count($arr); $i++) {
			if ($arr[$i] != '>') {
				$res_ .= $arr[$i];
			}
		}
	}
	return $res_;
}
function convertStr($str, $content) {
	$metaC = get_meta_data($content);
	$metaC = preg_replace( '/\s+/', ' ', $metaC);
	$metaC = str_replace (">", "", $metaC);
	$metaC = str_replace ('"', '', $metaC);
	list($notUsed, $contentType_) = explode(";", $metaC);
	list($notUsed, $contentType) = explode("=", $contentType_);
	$contentType = preg_replace( '/\s+/', ' ', $contentType);
	list($contentTypeReal, $notUsed) = explode(" ", $contentType);
	if ($contentTypeReal && $contentTypeReal != "utf-8") {
		$correct = iconv($contentTypeReal, "UTF-8", $str);
	} else {
		if ($contentTypeReal && $contentTypeReal == "utf-8") {
			$correct = $str;
		} else {
			$correct = iconv("windows-1251", "UTF-8", $str);
		}
	}
	return $correct;
}
function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function get_string_between($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
function getCause($content, $tag) {
	$find = get_string_between($content, $tag, "/>");
	list($notUsed, $used) = explode("content=", $find);
	$used = str_replace ('"', '', $used);
	$used = str_replace ("'", "", $used);
	return $used;
}
$domain = $_GET['domain'];
$content = file_get_contents_curl("http://".$domain);

$isDisabled =  convertStr(getCause($content, "scc.disable-scanner"), $content);
if ($isDisabled == 'yes') {
	echo 'disabled';
}


$sccLanguage =  convertStr(getCause($content, "scc.language"), $content);
$sccCost =  convertStr(getCause($content, "scc.cost"), $content);
$sccCause =  convertStr(getCause($content, "scc.cause"), $content);
$sccMonthlyIncome =  convertStr(getCause($content, "scc.monthlyincome"), $content);
$sccIncomeTypes =  convertStr(getCause($content, "scc.incometypes"), $content);
$sccEmail =  convertStr(getCause($content, "scc.email"), $content);
$sccJabber =  convertStr(getCause($content, "scc.jabber"), $content);
$sccSkype =  convertStr(getCause($content, "scc.skype"), $content);
$sccIcq =  convertStr(getCause($content, "scc.icq"), $content);
$sccPhone =  convertStr(getCause($content, "scc.phone"), $content);


$sccDate = date('Y-m-d H:i:s');
$sccMonthlyOutcome = convertStr(getCause($content, "scc.monthlyout"), $content);;
if ($sccLanguage && $sccCost && $sccEmail) {
	include ("config.php");
	$sql = "UPDATE worth SET
	worth.forSale = '1',
	worth.sccLanguage = '".mysql_real_escape_string($sccLanguage)."',
	worth.sccCost = '".mysql_real_escape_string($sccCost)."',
	worth.sccCause = '".mysql_real_escape_string($sccCause)."',
	worth.sccMonthlyIncome = '".mysql_real_escape_string($sccMonthlyIncome)."',
	worth.sccMonthlyOutcome = '".mysql_real_escape_string($sccMonthlyOutcome)."',
	worth.sccIncomeTypes = '".mysql_real_escape_string($sccIncomeTypes)."',
	worth.sccEmail = '".mysql_real_escape_string($sccEmail)."',
	worth.sccJabber = '".mysql_real_escape_string($sccJabber)."',
	worth.sccSkype = '".mysql_real_escape_string($sccSkype)."',
	worth.sccIcq = '".mysql_real_escape_string($sccIcq)."',
	worth.sccPhone = '".mysql_real_escape_string($sccPhone)."',
	worth.sccDate = '".mysql_real_escape_string($sccDate)."' WHERE domain='$domain'";
	$rs_result = mysql_query($sql);
	mysql_close($con);
	echo "good";
} else {
	include ("config.php");
	$sql = "UPDATE worth SET
	worth.forSale = '0' WHERE domain='$domain'";
	$rs_result = mysql_query($sql);
	mysql_close($con);
	echo "bad";
}
?>