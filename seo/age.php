<?
$domain = $_GET['domain'];
$page = file_get_contents("http://whois.domaintools.com/".$domain);
echo "http://whois.domaintools.com/".$domain;
?>