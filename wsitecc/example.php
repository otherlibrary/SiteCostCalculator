¿<?php
$encoded = $decoded = $add = '';
//header('Content-Type: text/html; charset=utf-8');
require_once('idna_convert.class.php');
$idn_version = 2008;
$IDN = new idna_convert(array('idn_version' => $idn_version));
echo $IDN->encode("mail.ru");
?>