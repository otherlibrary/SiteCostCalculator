<?php
include("geoipcity.inc");
include("geoipregionvars.php");
include("googleapi.php");

require "translate.php";
$tr = new Google_Translate_API;

$lang = $_GET['lang'];

require "langfinder.php";
$finder = new LangFinder;

$lang = $finder->find($lang);

$gi = geoip_open("GeoLiteCity.dat",GEOIP_STANDARD);

$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBRdftzjFjyq9TNVFuUqUR4Q7r7ANBQvtVgZA63dQFXf8BZ9K5eEdZND4w';
$ipaddress = $_GET['ip'];

$record = geoip_record_by_addr($gi,$ipaddress);

$countryStr = "Country";
$cityStr = "City";
$country = $record->country_name;
$city = $record->city;
$latitude = "Latitude";
$longitude = "Longitude"

$countryStr_ = $tr->translate($countryStr, 'en', $lang);
$cityStr_ = $tr->translate($cityStr, 'en', $lang);
$country_ = $tr->translate($country_ , 'en', $lang);
$city_ = $tr->translate($city_, 'en', $lang);
$latitude_ = $tr->translate($latitude_, 'en', $lang);
$longitude_ = $tr->translate($longitude_, 'en', $lang);

if ($countryStr_) {
	$countryStr = $countryStr_;
}
if ($cityStr_) {
	$cityStr = $cityStr_;
}
if ($country_) {
	$country = $country_;
}
if ($city_) {
	$city = $countryStr_;
}
if ($latitude_) {
	$latitude = $latitude_;
}
if ($longitude_) {
	$longitude = $longitude_;
}

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
            "<strong>'.$countryStr.':</strong> '. $countryStr . ' <br>"+
            " <strong>'.$cityStr.':</strong> '. $cityStr .' <br>"+
            "<strong>'.$latitude.':</strong> ' . $record->latitude . '<br>"+
			"<strong>'.$longitude.':</strong> ' . $record->longitude . '";
		GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(marker.html); });
		map.addOverlay(marker);
		marker.openInfoWindowHtml(marker.html);
      }
    }
     //]]>
    </script> ';
geoip_close($gi);  
?>