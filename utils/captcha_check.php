<?php
session_start();
ini_set ("display_errors", "1");
error_reporting(E_ALL);  
 require_once('config.php');
 $domain= $_POST['domain'];  
  require_once('captcha/recaptchalib.php');
 // $privatekey = "your_private_key";
  $resp = recaptcha_check_answer ($private_key,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    header ("Location: sec_captcha.php?captcha=false&domain=$domain");   
  } else {
setcookie("captcha", "not_bot", time()+900, "/");
//echo " Your code here to handle a successful verification";
      header ("Location: www.".$domain.""); 
setcookie("captcha", "not_bot", time()+900, "/");

  }
?>