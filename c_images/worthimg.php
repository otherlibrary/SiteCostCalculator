<?
header("Content-type: image/png"); 
$site = $_GET['site'];
$db_username = 'vokacost_root';
$db_password = 's1ac2x1voFFka';
$database = 'vokacost_sce';
$db_host = 'localhost';       
$con = mysql_connect("$db_host","$db_username","$db_password");
mysql_select_db("$database", $con);

$sql = "SELECT * FROM worth WHERE domain = '$site' LIMIT 1";
$rs_result = mysql_query ($sql); 
$w = -1;
while ($row = mysql_fetch_assoc($rs_result)) {
  $w=$row[worth];
  $wInt = intval($w);
  $wInt = $wInt * 3;
		 if ($wInt == 0) {
		 	$wInt = 375;
		 }

}
if ($w >= 0) {
$im = imagecreatefrompng("worthimg.png"); 
$font_site = 3; 
$xpos_site = 3; 
$ypos_site = 3; 
$string_site = $site." costs"; 
$font_w = 5; 
$xpos_w = 50; 
$ypos_w = 20; 
$string_w = "$".$wInt; 
$font_str = 3; 
$xpos_str = 50; 
$ypos_str = 38; 
$string_str = "And yours?"; 
$font_author = 2; 
$xpos_author = 4; 
$ypos_author = 52; 
$string_author = "by SiteCostCalculator.com"; 
$white = imagecolorallocate($im, 0, 0, 0); 
$black = imagecolorallocate($im, 255, 255, 255); 
imagestring($im, $font_site, $xpos_site, $ypos_site, $string_site, $white); 
imagestring($im, $font_w, $xpos_w, $ypos_w, $string_w, $white); 
imagestring($im, $font_str, $xpos_str, $ypos_str, $string_str, $white); 
imagestring($im, $font_author, $xpos_author, $ypos_author, $string_author, $white);
imagepng($im);
}
mysql_close($con);

?>