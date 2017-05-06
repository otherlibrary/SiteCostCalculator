<?
include 'class.seostats.php';
$url = new SEOstats("http://".$_GET['domain']);
echo $url->Google_Page_Rank();
?>