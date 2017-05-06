<?php ini_set('max_execution_time', 180);
 
include 'class.seostats.php';
include ("config.php");
try 
{
	$url = new SEOstats('http://'.$_GET['domain']);
	$pr = $url->Google_Page_Rank();
	$sql = "UPDATE worth SET worth.pagerank = $pr WHERE domain='$url'";
	$rs_result = mysql_query ($sql);	
} 
catch (SEOstatsException $e) 
{
	echo "error";
}
mysql_close($con);
?>