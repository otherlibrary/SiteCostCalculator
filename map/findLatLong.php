<?
header("Content-type: text/xml"); 

include("geoipcity.inc");
include("geoipregionvars.php");
include("googleapi.php");
$gi = geoip_open("GeoLiteCity.dat",GEOIP_STANDARD);

$ipaddress = $_GET['ip'];

$record = geoip_record_by_addr($gi,$ipaddress);
$lat = $record->latitude;
$long = $record->longitude;
geoip_close($gi);  

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<calculator>
<lat>".$lat."</lat>
<long>".$long."</long>
</calculator>";

echo $xml;

?>