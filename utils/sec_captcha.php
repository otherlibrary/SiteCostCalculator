<?php

include("config.php");

//echo date("D M j G:i:s T Y");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$title";?></title>
<meta name='keywords' content='<?php echo '$url2 Web Worth, Domain Information, Website stats, PageRank, Alexa Rank, Whois';?>' />
<meta name='description' content='<?php echo '$url2 Complete Website Information and Worth';?>' />
<link href="Css/stylesheet.css" rel="stylesheet" type="text/css"/>
<link rel=alternate type=application/rss+xml title=RSS href=../RSS/index.php>
<script type="text/javascript"> <!--
document.writeln('<div id="waitDiv" style="position:absolute;left:40%;top:40%;visibility:hidden">');
document.writeln('<table cellpadding="6" cellspacing="0" border=1 bgcolor=#FFFFFF bordercolor=#80C400>');
document.writeln('<tr><td align="center">');
document.writeln('<font color="#619500" face=Arial size=4>Loading</font><br><br>');
document.writeln('<img src="loading.gif" border="0" alt="">');
document.writeln('<br><font color="#619500" face=Arial size=2>Please wait..</font>');
document.writeln('<\/td><\/tr><\/table><\/div>');
var DHTML = (document.getElementById || document.all || document.layers);
function ap_getObj(name) {
if (document.getElementById) {
return document.getElementById(name).style;
} else if (document.all) {
return document.all[name].style;
} else if (document.layers) {
return document.layers[name];
}
}
function ap_showWaitMessage(div,flag) {
if (!DHTML)
return;
var x = ap_getObj(div);
x.visibility = (flag) ? 'visible':'hidden';
if(! document.getElementById)
if(document.layers)
x.left=280/2;
// return true;
}
ap_showWaitMessage('waitDiv', 1);
//--> </script>
</head>

<body>
<div class="container">
	<div class="full_content">
		<div class="header">
			<a href='../index.php'><div class="logo"></div></a>
			<div class="google_ads">Your Ad Here</div>
		</div>
			<div class="menu_links">
		<div class="link1"><a href="http://www.worth.im"><span>Home</span></a></div>
		<div class="line_image"></div>
		<div class="link1"><a href="http://eziscript.com/download" target="_blank"><span>Download Demo</span></a></div>
		<div class="line_image"></div>
		<div class="link1"><a href="http://eziscript.com"><span>Product</span></a></div>
		<div class="line_image"></div>
		<div class="link1"><a href="http://eziscript.com" target="_blank"><span>Buy This Script</span></a></div>
		<div class="line_image"></div>
		<div class="link1"><a href="faq.htm"><span>Faq</span></a></div>
		<div class="line_image"></div>
		<div class="link1"><a href="contactus.htm"><span>Contact Us</span></a></div>
		<div class="line_image"></div>
		<div class="link1"></div>
		</div>
		<div class="text_contents">
			<div class="some_text">
			<div class="some_text_left"></div>
			<div class="some_text_centre">
			<div class="text">Checking Google PR | Alexa Rank | Backlinks Checker | Server IP | Domain Creation and Expiration Dates | Estimating Web Traffic | Analy5ing Potential Google Adsense Income and text Link Value | Check DMOZ Listings | Search Engine Backlinks | Number of Indexed Pages and more. Our tool is Free to Use Anytime by Anybody who want to check your Website Score. Each Score is Saved in the our database</div>
			</div>
			<div class="some_text_right"></div>
			</div>
            <form method=POST name=daf action=getdata.php>
			<div class="calculate_box">
			<div class="calculate_box_left"></div>
			            <div class="calculate_box_centre">
			<div class="search_info">
			<div class="search_input1"><input type="text" name="url" style="width:950px;height:40px;background-color:#dcf9bb;border:1px solid #b4b4b4;font-family:Arial, Helvetica, sans-serif;font-size:20px;padding-top:12px;font-weight:bold;padding-left:5px;color:#555555;" /></div>
				<span style="font-family:Arial, Helvetica, sans-serif;font-size:20px;font-weight:bold;color:#a1a1a1;float:left; width:900px;border:0 solid; text-align:center;">
                Eg www.google.com or http://www.youtube.com</span> 
				<div class="calculate_button1"><input type="submit" style="float:left;background-image:url(../images/calculate_big.gif);width:250px;height:41px;border:1px solid #c1c1c1;font-size:16px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;color:#FFFFFF" value="Calculate&amp;Info" /></div>
				</div>
				</div>
				<div class="calculate_box_right"></div>
				</div>
               
                </form>   <?php
                //include("scroll.php");
                ?> 
			<div class="google_ads5"><?php 
			$pass=$_GET[pass];
			if ($pass=="ban") {
				echo "<font color=red>Domain Name Restricted by Site Admin!!!</font>";
			} else {
			
				echo 'Your Ad Here';
} ?></div>
			<div class="under_content">
			<div class="left_under_content">
			 <form method="post" action="captcha_check.php">

    <?php

    $iscorrect= @$_GET['captcha'];

     $domain= $_GET['domain'];  

     ?>

     <input type="hidden" name="domain" value="<?php echo $domain;?>">

     <?php

    if ($iscorrect=="") {
      require_once('captcha/recaptchalib.php'); 
      echo recaptcha_get_html($public_key);
    } else {
 echo "Captcha Code Incorrect Try Again";
      require_once('captcha/recaptchalib.php'); 
      echo recaptcha_get_html($public_key);
}

    ?>

    <input type="submit" />

  </form>
<p>Captcha requried every 15 mint</p> 
<p>You must enable Cookies in your browser other wise you will need to type captcha every time when you want to see any website info</p></td>

     <script type="text/javascript"> <!--

        ap_showWaitMessage('waitDiv', 0);

    //--> </script>
			</div>
			<div class="right_under_content">
			<div class="google_ads6">You ad Here</div>
			<div class="google_ads6">You ad Here2</div>
			<div class="google_ads6">Some Other Ads</div>
			</div>
			</div>
			<div class="some_text">
			  <div class="some_text_centre">
			<div class="text">
			  <strong><h1>About:</h1></strong>
			  <p>Website Valued gives you an estimated amount of your online business by profiling your website for abstruse information, keywords, accessible company stats and again comparing them to the database of antecedent website and area sales.</p><h1>Worth.IM:
			  </h1>
			  <p>Worth.IM is a website assay tool, accouterment abstruse assay and SEO enhancement information. This website uses advice from Worth.IM for analysis.<br />
			    Selling your website could be a lot of assisting hypothesis for some businesses. Not alone you can accomplish a amount of money, you can aswell use this money to body your business to a next level.<br />
			    It is up to you to adjudge if to advertise your website.<br />
			    But I accept abiding for chargeless appraisal of how abundant is amount of your website.<br />
			    Quiet Light Brokerage, a business allowance close that focuses alone on affairs websites, is alms valuations to Home For Profits readers and subscribers.<br />
			    Please note. You do not accept to advertise your website &ndash; what you do with the advice is your decision, and the action is actually bland and actually free.<br />
			    Even if you do not wish to advertise it is fun alive what amount your basic acreage accept you accumulated.<br />
		      Let us get started.</p>
            </div>
			</div>
						</div>
		</div>
	</div>
	<div class="footer">
				<div class="footer_links">
				<span style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;color:#434343;padding-top:6px;padding-left:10px;"><a href="#" style="text-decoration:none;color:#434343;">Website Design and Programing By: EziScript.com</a></span>
				<span style=" padding-left:140px;"><a href="http://www.trendcounter.com/live/fo0de1yv.htm" target="_blank"><img src="http://www.trendcounter.com/w/blog/ffda8a_000000/fo0de1yv.png" border="0" alt="counter" /></a></span>
				<span style="float:right;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;color:#ff0000;padding-top:6px;padding-right:10px;"><a href="#" style="text-decoration:none; color:#ff0000;">Domain Tools and Websiteoutlook Clone V1.5 Updated</a></span>
				</div>
			</div>
</div>
</body>
</html>
<?
  include("sitemapno.php"); 
 include("analys.php"); 
?>