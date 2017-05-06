<?php
function offset2num($offset) { 
	$n = (int)$offset; $m = $n%100;
	$h = ($n-$m)/100; 
	return $h*3600+$m*60;
} 
$local = time(); 
$gmt = $local - offset2num("-0900");
print "Ukraine: ".date("D M j G:i:s",$gmt);
?>
