<?php
require_once('geoip.inc');
 function get_ip()
 {
 if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
 {
 $ip=$_SERVER['HTTP_CLIENT_IP'];
 }
 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
 {
 $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
 }
 else
 {
 $ip=$_SERVER['REMOTE_ADDR'];
 }
 return $ip;
 }

$open = geoip_open("GeoIP.dat", GEOIP_STANDARD);

echo "Country code - ".geoip_country_code_by_addr($open, get_ip());
geoip_close($open);
?>