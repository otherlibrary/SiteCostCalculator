<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
</head>
<body onload="load()" onunload="GUnload()">
<div id="map" style="width:500px;height:280px"></div>
<?

include("geoipcity.inc");
include("geoipregionvars.php");
include("googleapi.php");

$gi = geoip_open("GeoLiteCity.dat",GEOIP_STANDARD);

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

preg_match("/^(http:\/\/)?([^\/]+)/i", curPageURL(), $matches);
$host = $matches[2];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

$domain = "{$matches[0]}";

if ($domain == 'sitecostcalculator.com') {
	$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBRdftzjFjyq9TNVFuUqUR4Q7r7ANBQvtVgZA63dQFXf8BZ9K5eEdZND4w';
} 
if ($domain == 'websitepricecalculator.net') {
	$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBT3DUu9tZeDlIlc2y7QHtx9YIo1BRRgrRBPtCyD7W-elyMhCVhNQKDYrA';
} 
if ($domain == 'websitecostcalculator.com') {
	$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBSUFkSBCsawaVzGK8frkFCmHF4nNRRYRpmG8PZJlxaIooDQdayj1JIlFA';
} 
if ($domain == 'websitetrafficcalculator.com') {
	$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBRmxPKnlLLa0HJ1MB6Mg8zIn4oGyBRVTiIHOjaff0t_kczyd-nrBQC6iw';
} 
if ($domain == 'websiteworthcalculator.net') {
	$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBT7IeiiPoPTnO8ihLXgYyAgR_GnxRQczwlT5BrJ_ycgw2uuDpRIPWZtUQ';
} 
if ($domain == 'websitecost.info') {
	$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBRjDEfyuZN2q-BvlE3DF7rsI9LX7RRCvUwoD3xIwthnF598pbMMKI4p_A';
}
if ($domain == 'costofwebsite.net') {
	$googleapi = 'ABQIAAAAqe2LZfUyWa4BBc2AR_YvOhQx5UwKQHBu5YVgbx2jfs8ZFU8ZgRSUlP4Y64dMUTnNivu8vycIRLtxeQ';
}
if ($domain == 'sitecostcalculator.ru') {
	$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBSglSvpGdY1WndrzWvb5x1QH8-t2RTzbrk64YYbTb4JWn8gC4RcA1YrLw';
} 

$ipaddress = $_GET['ip'];

$record = geoip_record_by_addr($gi,$ipaddress);

    echo '<div id=map></div><script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=' . $googleapi . '"
      type="text/javascript"></script> 
    <script type="text/javascript"> 
     //<![CDATA[
     function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(' . $record->latitude . ', ' . $record->longitude . '), 4);
		var marker = new GMarker(new GLatLng(' . $record->latitude . ', ' . $record->longitude . '));
		marker.html = "<strong>IP:</strong> ' . $ipaddress . ' <br>"+
            "<strong>Country:</strong> '. $record->country_name . ' <br>"+
            " <strong>City:</strong> '. $record->city .' <br>"+
            "<strong>Latitude:</strong> ' . $record->latitude . '<br>"+
			"<strong>Longitude:</strong> ' . $record->longitude . '";
		GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(marker.html); });
		map.addOverlay(marker);
		marker.openInfoWindowHtml(marker.html);
      }
    }
     //]]>
    </script> ';
geoip_close($gi);  

?>
</body>
</html>