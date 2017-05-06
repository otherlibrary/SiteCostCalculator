<?
include 'class.seostats.php';
$url = new SEOstats("http://".$_GET['domain']);
$v = $url->Alexa_Pageviews();
echo $v['1 Month']['value'];
?>