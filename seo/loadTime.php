<?
include 'class.seostats.php';
$url = new SEOstats("http://".$_GET['domain']);
$speedStr = $url->Alexa_Avg_Load_Time();
list($s1, $sec) = explode(" ", $speedStr);
$s = substr($sec, 1, strlen($sec));
if ($s == 'ata') {
	$s = 1;
}
echo $s;
?>