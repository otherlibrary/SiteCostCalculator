<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
</head>
<body onload="load()" onunload="GUnload()">
<div id="map" style="width:1024px;height:600px"></div>
<?

include("googleapi.php");
$googleapi = 'ABQIAAAAHW3zlLVhURWPdSISs7jvRBRdftzjFjyq9TNVFuUqUR4Q7r7ANBQvtVgZA63dQFXf8BZ9K5eEdZND4w';

$country = $_GET['country'];
$lat = $_GET['lat'];
$long = $_GET['long'];
$text = $_GET['text'];

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
		marker.html = "<strong>'.$country.'</strong><br>100 people";
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