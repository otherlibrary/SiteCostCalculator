<?
include 'class.seostats.php';
try 
{
	$url = new SEOstats('http://'.$_GET['domain']);
	
	
$googleBackLinksArray = $url->Google_Backlinks_Array();
$arr = array();
$count = 0;
foreach ($googleBackLinksArray as $link) {
    preg_match("/^(http:\/\/)?([^\/]+)/i", $link['url'], $matches);
    $host = $matches[2];
    preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
    $mainDomain = "{$matches[0]}";
    $arr[$count] = $mainDomain;
    $count++;
}
$backsOut = "";
$q=array_count_values($arr);
foreach ($q as $k=>$v) {
	$backsOut .= "".$k." (".$v."),";
}
echo $backsOut;
} 
catch (SEOstatsException $e) 
{
	echo "error";
}
?>