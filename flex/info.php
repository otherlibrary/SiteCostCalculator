<?
require "translate.php";
$tr = new Google_Translate_API;

$lang = $_GET['lang'];

require "langfinder.php";
$finder = new LangFinder;

$lang = $finder->find($lang);

$info = "";

$info_ = $tr->translate($info, 'en', $lang);
if ($info_) {
	$info = $info_;
}

echo $info;

?>