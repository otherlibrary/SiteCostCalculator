<?php
$db_username = 'vladkish_root';
$db_password = 'S1ac2X1!@';
$database = 'vladkish_scc';
$db_host = 'localhost';

###Warning!!! Dont Change these lines###
$con = mysql_connect("$db_host","$db_username","$db_password");
mysql_select_db("$database", $con);

###License Key Setting###
$siteurl = 'http://sitecostcalculator.com';             // Replace with your Website include http:// 
$title = 'Site Cost Calculator';                 // Replace with you Website Titile
$license = '22ab8f196c34dc94dbab4ba5bdeecf64';             // Add Your License key

###Capthca Setting###
$captcha = 'false';                // Security Capthca True/False  

###Update Setting###
$updateday = '30';        // Website Update every X day  ## Defalt 30 Day

###RSS Setting###
$rsslimit = '50';           // maximum item in RSS 

###Comment Setting###
$comment = '1';             // Comment Enable or Disable

###Currency Setting###
$c_symbol = '$';          // Currency Symbol
$c_value = '1';            // Currency Value 1 USD = .67 EUR
$c_symbol_placement = '0';    // Show Symbol Right or Left at Worth. 1=right  / 0=left

###Other Settings###
$www = '1';                // With or without www 1=with www / 0=without www  
$private_key = '';                // With or without www 1=with www / 0=without www  
$public_key = '';                // With or without www 1=with www / 0=without www  
$adultword = 'dick';
$domain_ext_block = 'xo.cr';
?>