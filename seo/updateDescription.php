<? error_reporting(0);
function getMetaTitle($content){
$pattern = "|<[\s]*title[\s]*>([^<]+)<[\s]*/[\s]*title[\s]*>|Ui";
if(preg_match($pattern, $content, $match))
return $match[1];
else
return false;
}
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
$domain = $_GET['domain'];
$url = "http://www.".$domain;
$content = file_get_contents($url);

$metaC = get_meta_data($content);
$tags = get_meta_tags("http://www.".$domain);
$description = $tags['description'];
$metaC = preg_replace( '/\s+/', ' ', $metaC);
$metaC = str_replace (">", "", $metaC);
$metaC = str_replace ('"', '', $metaC);
list($notUsed, $contentType_) = explode(";", $metaC);
list($notUsed, $contentType) = explode("=", $contentType_);
$contentType = preg_replace( '/\s+/', ' ', $contentType);
list($contentTypeReal, $notUsed) = explode(" ", $contentType);
if ($contentTypeReal && $contentTypeReal != "utf-8") {
	$correct = iconv($contentTypeReal, "UTF-8", $description);
} else {
	if ($contentTypeReal && $contentTypeReal == "utf-8") {
		$correct = $description;
	} else {
		$correct = iconv("windows-1251", "UTF-8", $description);
	}
}

include ("config.php");
$sql = "UPDATE worth SET description = '".mysql_real_escape_string($correct)."' WHERE domain = '".$domain."' LIMIT 1";
$rs_result = mysql_query ($sql);
mysql_close($con);
echo $correct;
?>