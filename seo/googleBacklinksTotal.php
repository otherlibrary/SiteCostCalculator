<?
include 'class.seostats.php';
try 
{
$url = new SEOstats('http://'.$_GET['domain']);
echo $url->Google_Backlinks_Total();
} 
catch (SEOstatsException $e) 
{
echo "error";
}
?>