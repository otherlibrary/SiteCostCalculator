<?
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$serferIp = $_SERVER['REMOTE_ADDR'];
//$serferIp = "72.113.33.44";
$ref = $_SERVER['HTTP_REFERER'];
$qq = $_GET['qq'];
$affId = file_get_contents('');
$sub = "10000";

function curPageURL()
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

preg_match("/^(http:\/\/)?([^\/]+)/i", curPageURL(), $matches);
$host = $matches[2];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

$mainDomain = "{$matches[0]}";

if ($mainDomain == 'sitecostcalculator.com') {
    $mainTitle2 = 'SiteCostCalculator.com';
    $mailTo = "support@sitecostcalculator.com";
}
if ($mainDomain == 'websitepricecalculator.net') {
    $mainTitle2 = 'WebsitePriceCalculator.net';
    $mailTo = "support@websitepricecalculator.net";
}
if ($mainDomain == 'websitecostcalculator.com') {
    $mainTitle2 = 'WebsiteCostCalculator.com';
    $mailTo = "support@websitecostcalculator.com";
}
if ($mainDomain == 'websitetrafficcalculator.com') {
    $mainTitle2 = 'WebsiteTrafficCalculator.com';
    $mailTo = "support@websitetrafficcalculator.com";
}
if ($mainDomain == 'websiteworthcalculator.net') {
    $mainTitle2 = 'WebsiteWorthCalculator.net';
    $mailTo = "support@websiteworthcalculator.net";
}
if ($mainDomain == 'websitecost.info') {
    $mainTitle2 = 'WebsiteCost.info';
    $mailTo = "support@websitecost.info";
}
if ($mainDomain == 'costofwebsite.net') {
    $mainTitle2 = 'costofwebsite.net';
    $mailTo = "support@websitecost.info";
}

$feedURL = "http://feed.searchanyway.com/search_xml.php?aff=" . $affId . "&subaff=" . $sub . "&ua=" . $userAgent . "&qq=" . $qq . "&surfer_ip=" . $serferIp . "&ref=" . $ref;
$xml = simplexml_load_file($feedURL);

$out = "<table style=\"float:left; width:100%\">
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[0]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[0]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[1]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[1]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[2]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[2]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[3]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[3]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[4]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[4]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[5]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[5]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[6]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[6]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[7]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[7]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[8]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[8]->description . "</font></a></td>
	</translate>
	<translate>
		<td><hr></td>
	</translate>
	<translate>
		<td><a target=\"_blank\" href=\"http://" . $mainTitle2 . "/go.php?to=" . $xml->search_results->record[9]->clickurl . "\"><font style=\"font-family: georgia, serif; font-size:13pt;\">" . $xml->search_results->record[9]->description . "</font></a></td>
	</translate>
	</table>";

echo $out;
?>