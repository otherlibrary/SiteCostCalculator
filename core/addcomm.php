<?php
include 'config.php';
$domain = $_POST['domain'];
$site = $_POST['site'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$sql = "INSERT INTO comments (domain, site, name, comment, time) VALUES ('".mysql_real_escape_string($domain)."',
		'".mysql_real_escape_string($site)."',
		'".mysql_real_escape_string($name)."',
		'".mysql_real_escape_string(strip_tags($comment))."', NOW())";
$sqlRes = mysql_query($sql);
mysql_close($con);
echo $sqlRes; 
?>