<?
$ip = $_POST['content'];
include "whois/upk1.php";
$domain = $ip;
//echo  "$name $value";
include "whois/cwcconf.php";
if ($LookupTuring)
    $requireturing = 2;
if ($allowlookup)
    $i = upk1($domain, "", $reg, $turing);
else
    $i = -1;

if ($i == -1)
    echo "Whois lookup disabled<br>";
if ($i == 5)
    echo "Problem connecting with whois server<br>";
if ($i == 2)
    echo "Domain extension for $domain not recognised<br>";
if ($i == 3)
    echo "$domain is not valid <BR>";
echo "<p class=\"upk1lookup\">\n";
if (($i == 0) || ($i == 1) || ($i == 6)) {
    for ($k = 0; $k < count($reg); $k++) {
        //echo  ("$reg[$k]<BR>");
        global $whois;
        $whois .= "$reg[$k]<BR>";

    }
}
//                     echo $whois;
$pattern = '/\b\w+\@\w+[\.\w+]+\b/';

preg_match($pattern, $whois, $matches);
$whois_final = str_replace("$matches[0]", "<u>## Email Protect by SiteCostCalculator.com ##</u>", $whois);
echo $whois_final;
//echo "Email:" . $matches[0];
?>