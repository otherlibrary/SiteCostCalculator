<?

$ver = $_GET['version'];
$currentVersion = "1";

require "translate.php";
$tr = new Google_Translate_API;

$lang = $_GET['lang'];

require "langfinder.php";
$finder = new LangFinder;

$lang = $finder->find($lang);

$resp1 = "You are using latest version. Thanks.";
$resp2 = "Updates are available. Please, visit official page";

$resp1_ = $tr->translate($resp1, 'en', $lang);
$resp2_ = $tr->translate($resp2, 'en', $lang);
if ($resp1_) {
	$resp1 = $resp1_;
}
if ($resp2_) {
	$resp2 = $resp2_;
}


if ($ver == $currentVersion) {
	echo $resp1;
} else {
	echo $resp2.": http://sitecostcalculator.com";
}

?>