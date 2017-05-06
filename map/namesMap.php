<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
</head>
<body onload="load()" onunload="GUnload()">
<div id="map" style="width:350px;height:280px"></div>
<?

include("googleapi.php");
$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBRdftzjFjyq9TNVFuUqUR4Q7r7ANBQvtVgZA63dQFXf8BZ9K5eEdZND4w';

$country = $_GET['country'];
$city = $_GET['city'];
$countryStr = $_GET['countryStr'];
$cityStr = $_GET['cityStr'];
$lat = $_GET['lat'];
$long = $_GET['long'];
$text = $_GET['text'];
$url = $_GET['url'];

if ($url) {
   $meet = "<br><a href=\"".$url."\">Who is he/she?</a>";
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
        map.setCenter(new GLatLng('.$lat.', '.$long.'), 4);
		var marker = new GMarker(new GLatLng('.$lat.', '.$long.'));
		marker.html = "'.$text.'<br><br><strong>'.$countryStr.':</strong> '.$country.' <br>"+
            " <strong>'.$cityStr.':</strong> '.$city.'";
		GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(marker.html); });
		map.addOverlay(marker);
		marker.openInfoWindowHtml(marker.html);
      }
    }
     //]]>
    </script> ';

?>
</body>
</html>