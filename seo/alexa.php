<?
include 'class.seostats.php';
$domain = $_GET['domain'];
$typeVal = $_GET['type'];
$timeVal = $_GET['time'];
$url = new SEOstats("http://$domain");
echo $url->Alexa_Graph($type=$typeVal, $width='660', $height='330', $period=$timeVal);
?>