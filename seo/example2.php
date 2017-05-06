<?php ini_set('max_execution_time', 180);
 
include 'class.seostats.php';

try 
{
	$url = new SEOstats('http://trinixy.ru');
	
	
echo $url->print_array('Twitter_Mentions_Array');


} 
catch (SEOstatsException $e) 
{
	/**
	 * Error handling (print it, log it, leave it.. whatever you want.)
	 */
	die($e->getMessage());
}
?>