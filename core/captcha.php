<?php
 
	$randomnr = rand(10000, 99999);
	$_SESSION['randomnr2'] = md5($randomnr);
 
	$im = imagecreatetruecolor(80, 25);
 
	$white = imagecolorallocate($im, 20, 155, 25);
	$grey = imagecolorallocate($im, 255, 160, 250);
	$black = imagecolorallocate($im, 211, 255, 155);
 
	imagefilledrectangle($im, 0, 0, 180, 25, $black);

	//path to font - this is just an example you can use any font you like:
	
	$font = dirName(__FILE__).'/font/karate/Karate.ttf';

	imagettftext($im, 15, 5, 15, 25, $grey, $font, $randomnr);
 
	imagettftext($im, 15, 5, 10, 25, $white, $font, $randomnr);
 	
	//prevent caching on client side:
	header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
 
	header ("Content-type: image/gif");
	imagegif($im);
	imagedestroy($im);
?>