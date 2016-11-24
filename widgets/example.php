<?php
require "translate.php";
$tr = new Google_Translate_API;
$res = $tr->translate('This is a text', 'en', 'en');
echo $res;

?>
