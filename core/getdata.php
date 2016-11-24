<?php
    include("config.php");

 $url3 = strtolower($_GET['url']);

$num424 = strtolower($_GET['url']);
$num2 = str_replace(" ","",$num424);
$num4 = str_replace("http://","",$num2);
$num = str_replace("https://","",$num4);
$find = "http://";
$pos = strpos($num, $find);

 ////// Block Adult Keywords Extenstion ///////
$adultwords = explode(',', $adultword);
 //print_r($adultwords);
 foreach ($adultwords as $adult) 
{
    if (preg_match("/$adult/",$num)) {
   // echo $
  header("Location: $siteurl/index.php?pass=ban");  
      die();
}}

////// Block Spammed Extenstions ///////
 $ext_block = explode(',', $domain_ext_block);
 //print_r($ext_block);
 foreach ($ext_block as $ext) 
{
    if (preg_match("/$ext/",$num)) {

  echo $num. " Domain Banned due to Spamming"; 
       die();
}}

$url=get_domain($num,$pos); // outputs 'somedomain.co.uk'

function get_domain($url,$pos)
{
 if ($pos === false) {
    $num1="http://".$url;
    $pieces = parse_url($num1);
    } else {
    $pieces = parse_url($url);
}
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}
$ip = str_replace("http://www.","",$url);

$ip2 = str_replace("http://","",$ip);    

$ip3 = str_replace("www.","",$ip2);

  $ip4 = str_replace("/","",$ip3);

$ip = str_replace("com/","com",$url);

$ip = str_replace("net/","net",$url);

$ip = str_replace("org/","org",$url);

$ip = str_replace("info/","info",$url);

$ip = str_replace("us/","us",$url);

$ip = str_replace("pk/","pk",$url);



//Domain Filter Start
        $ipvv="http://".$ip4;
            function validateURL($url)
{
$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
return preg_match($pattern, $url);
}
$result = validateURL($ip2);
//echo $result;
if ($result == "0") {
    echo $ip2. "Domain not Valid!";
} else {

$check=@file_get_contents($ipvv);
if (!$check) {
    //global $note;
    print "Not a Valid Domain!";
} else {
$ip22 = str_replace("http://","",$ipvv);
header ("Location: http://sitecostcalculator.com/index3.php"); 
}
}
?>