<?

header("Content-type: text/xml");

require "translate.php";
$tr = new Google_Translate_API;

require "langfinder.php";
$finder = new LangFinder;

$lang = $_GET['lang'];

 if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
 {
 $ip=$_SERVER['HTTP_CLIENT_IP'];
 }
 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
 {
 $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
 }
 else
 {
 $ip=$_SERVER['REMOTE_ADDR'];
 }
$cCode = "";
if (!$lang) {

	require_once ('geoip.inc');
	$open = geoip_open("GeoIP.dat", GEOIP_STANDARD);
	$code = geoip_country_code_by_addr($open, $ip);
	$cCode = $code;
	geoip_close($open);
	
	$googleLang = $finder->find($code);
	
	if (!$googleLang) {
		$googleLang = "en";
	}
	
	$lang = $googleLang;
} else {
	$lang = $finder->find($lang);
}

$t1 = "Worth";
$t2 = "Total";
$t3 = "Visits";
$t4 = "Daily income";
$t5 = "Monthly income";
$t6 = "Daily";
$t7 = "Monthly";
$t8 = "Location and details";
$t9 = "Country";
$t10 = "Age";
$t11 = "Backlinks";
$t12 = "IP address";
$t13 = "Calculate!";
$t14 = "View online";
$t15 = "Check for updates";

$t1_ = $tr->translate($t1, 'en', $lang);
if ($t1_) {
	$t1 = $t1_;
}
$t2_ = $tr->translate($t2, 'en', $lang);
if ($t2_) {
	$t2 = $t2_;
}
$t3_ = $tr->translate($t3, 'en', $lang);
if ($t3_) {
	$t3 = $t3_;
}
$t4_ = $tr->translate($t4, 'en', $lang);
if ($t4_) {
	$t4 = $t4_;
}
$t5_ = $tr->translate($t5, 'en', $lang);
if ($t5_) {
	$t5 = $t5_;
}
$t6_ = $tr->translate($t6, 'en', $lang);
if ($t6_) {
	$t6 = $t6_;
}
$t7_ = $tr->translate($t7, 'en', $lang);
if ($t7_) {
	$t7 = $t7_;
}
$t8_ = $tr->translate($t8, 'en', $lang);
if ($t8_) {
	$t8 = $t8_;
}
$t9_ = $tr->translate($t9, 'en', $lang);
if ($t9_) {
	$t9 = $t9_;
}
$t10_ = $tr->translate($t10, 'en', $lang);
if ($t10_) {
	$t10 = $t10_;
}
$t11_ = $tr->translate($t11, 'en', $lang);
if ($t11_) {
	$t11 = $t11_;
}
$t12_ = $tr->translate($t12, 'en', $lang);
if ($t12_) {
	$t12 = $t12_;
}
$t13_ = $tr->translate($t13, 'en', $lang);
if ($t13_) {
	$t13 = $t13_;
}
$t14_ = $tr->translate($t14, 'en', $lang);
if ($t14_) {
	$t14 = $t14_;
}
$t15_ = $tr->translate($t15, 'en', $lang);
if ($t15_) {
	$t15 = $t15_;
}

$t16 = "File";
$t17 = "Exit";
$t18 = "Help";
$t19 = "About";
$t20 = "About author";
$t21 = "Official page";
$t22 = "Leave feedback";
$t23 = "Report error";
$t24 = "Suggest new feature";
$t25 = "Updates";
$t26 = "Approximate cost of website - this is very popular question among webmasters from the whole world. Site cost calculator gives help in this question and provides almost precise cost of website, based on dozens parameters. But don't forget: final cost depends on site theme (blog/shop/gambling etc)";
$t27 = "founder and main developer. You can contact me via email (in main menu). All comments will be gladly reviewed.";

$t16_ = $tr->translate($t16, 'en', $lang);
if ($t16_) {
	$t16 = $t16_;
}
$t17_ = $tr->translate($t17, 'en', $lang);
if ($t17_) {
	$t17 = $t17_;
}
$t18_ = $tr->translate($t18, 'en', $lang);
if ($t18_) {
	$t18 = $t18_;
}
$t19_ = $tr->translate($t19, 'en', $lang);
if ($t19_) {
	$t19 = $t19_;
}
$t20_ = $tr->translate($t20, 'en', $lang);
if ($t20_) {
	$t20 = $t20_;
}
$t21_ = $tr->translate($t21, 'en', $lang);
if ($t21_) {
	$t21 = $t21_;
}
$t22_ = $tr->translate($t22, 'en', $lang);
if ($t22_) {
	$t22 = $t22_;
}
$t23_ = $tr->translate($t23, 'en', $lang);
if ($t23_) {
	$t23 = $t23_;
}
$t24_ = $tr->translate($t24, 'en', $lang);
if ($t24_) {
	$t24 = $t24_;
}
$t25_ = $tr->translate($t25, 'en', $lang);
if ($t25_) {
	$t25 = $t25_;
}
$t26_ = $tr->translate($t26, 'en', $lang);
if ($t26_) {
	$t26 = $t26_;
}
$t27_ = $tr->translate($t27, 'en', $lang);
if ($t27_) {
	$t27 = $t27_;
}
$t28 = "I found an bug!";
$t28_ = $tr->translate($t28, 'en', $lang);
if ($t28_) {
	$t28 = $t28_;
}
$t29 = "I want to suggest a new feature";
$t29_ = $tr->translate($t29, 'en', $lang);
if ($t29_) {
	$t29 = $t29_;
}
$t30 = "Recently calculated";
$t30_ = $tr->translate($t30, 'en', $lang);
if ($t30_) {
	$t30 = $t30_;
}
$t31 = "Website";
$t31_ = $tr->translate($t31, 'en', $lang);
if ($t31_) {
	$t31 = $t31_;
}
$t32 = "Advertisement";
$t32_ = $tr->translate($t32, 'en', $lang);
if ($t32_) {
	$t32 = $t32_;
}
$t33 = "Recalculating...";
$t33_ = $tr->translate($t33, 'en', $lang);
if ($t33_) {
	$t33 = $t33_;
}


$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<lang>
	<newLang>".$cCode."</newLang>
	<worth>".$t1."</worth>
	<total>".$t2."</total>
	<visits>".$t3."</visits>
	<dailyIncome>".$t4."</dailyIncome>
	<monthlyIncome>".$t5."</monthlyIncome>
	<daily>".$t6."</daily>
	<monthly>".$t7."</monthly>
	<locD>".$t8."</locD>
	<country>".$t9."</country>
	<age>".$t10."</age>
	<backlinks>".$t11."</backlinks>
	<ip>".$t12."</ip>
	<calculate>".$t13."</calculate>
	<viewOnline>".$t14."</viewOnline>
	<upd>".$t15."</upd>
	<file>".$t16."</file>
	<exit>".$t17."</exit>
	<help>".$t18."</help>
	<about>".$t19."</about>
	<aboutAuthor>".$t20."</aboutAuthor>
	<site>".$t21."</site>
	<feedback>".$t22."</feedback>
	<error>".$t23."</error>
	<feature>".$t24."</feature>
	<up>".$t25."</up>
	<helpAboutProgramLoc>".$t26."</helpAboutProgramLoc>
	<aboutMe>Kishlaly Vladimir - ".$t27."</aboutMe>
	<bug>".$t28."</bug>
	<newFeature>".$t29."</newFeature>
	<rcalc>".$t30."</rcalc>
	<website>".$t31."</website>
	<ads>".$t32."</ads>
	<recalculating>".$t33."</recalculating>
</lang>";

echo $xml;


?>