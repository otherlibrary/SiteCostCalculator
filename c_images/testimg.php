<?
header("Content-type: image/png");
$font = 'georgia.ttf';
$string = "фжыдолва";
for ($i=0; $i<strlen($string); $i++) {
	$output .= ord($string[$i])." ";
}
$image=imagecreateFromPNG("worthimg.png");
$black=ImageColorAllocate($image,000,000,000);
imagettftext($image,10,0,50,54,$black,$font, $output);
imagepng($image);
ImageDestroy($image);

?>