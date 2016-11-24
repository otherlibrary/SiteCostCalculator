<?php 
include ("template_config.php");
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$title";?></title>
<meta name='keywords' content='<?php echo '$url2 Web Worth, Domain Information, Website stats, PageRank, Alexa Rank, Whois';?>' />
<meta name='description' content='<?php echo '$url2 Complete Website Information and Worth';?>' />
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<?php if($slider==1) { ?>
<link href="css/carousel.css" rel="stylesheet" type="text/css" />
<?php 
} else {
}
?>
<script type="text/javascript">
function clickclear(thisfield, defaulttext) {
if (thisfield.value == defaulttext) {
thisfield.value = "";
}
}

function clickrecall(thisfield, defaulttext) {
if (thisfield.value == "") {
thisfield.value = defaulttext;
}
}
</script>
</head>

<body>
	<div class="container">
   	   <div class="content">
       		<div class="top_menu">
            	<ul>
                	<li><?php echo $top_seo_text; ?></li>
                </ul>
            </div>
            <div class="menu">
            	<?php include("topmenu.php"); ?>
            </div>
            <div class="social">
            	<ul>
                	<li><a href="<?php echo $facebook_url; ?>"><img src="images/facebook_icon.png" alt="" /></a></li>
                    <li><a href="<?php echo $tweet_url;?>"><img src="images/twitter.png" alt="" /></a></li>
                    <li><a href="rss/index.php"><img src="images/rss.png" alt="" /></a></li>
                </ul>
            </div>
            <div class="under_content">
            	<div class="up"></div>
                <div class="mid">
                	<div class="main_content">
                    	<div class="inside_content">
                            <div class="top_content">
                                <div class="logo"><a href="<?php echo "$siteurl";?>"><img src="images/logo.gif" alt="" /></a></div>
                                 <form method="post" name="daf" action="getdata.php">
                                <div class="text_box">
                                    <div class="left"></div>
                                    <div class="middle">
                                        <input type="text" name="url" onclick="clickclear(this, 'eg. www.google.com or http://www.youtube.com')" onblur="clickrecall(this,'eg. www.google.com or http://www.youtube.com')" value="eg. www.google.com or http://www.youtube.com" class="middle" />
                                    </div>
                                    <div class="right"></div>
                                </div>
                                <div class="generate"><input type="image" src="images/generate_info.gif" /></div>
                                </form>
                          </div>
                                <div class="top_content2">
                                 <div class="home_ad_left_box"><a href="http://eziscript.com/" target="_blank" /><img src="images/ads.gif" width="250" height="87" alt="EziScript | PHP Script" longdesc="http://eziscript.com" /></a>
                                 
                                  </div>
                                <div class="big_ad"><a href=""><img src="images/big_ad.gif" alt="" /></a></div>
                                </div>
                                <div class="top_content3">
					<?php if($slider==1) { ?>
					<div class="top_sites">
					<?php include("scroll.php"); ?>
					</div>
					<?php 
					} else {
                    }
					?>
                                <div class="google_ad">
                                	<div class="go_ad">
                                    	<img src="images/text_ad.gif" alt="" />
                                    </div>
                                </div>
                                 <div class="top_content4">
                                   <div class="latest"><h3><img alt="" src="images/lastest_arrow.png">Frequently Asked Questions</h3></div>
                                   <div class="full_con">
                                     <h5>How it works?</h5>
                                     <p>Websiteoutlook contains a collection of actual  number of pageview from other websites. The visitor data is combined  with information about number of links that point towards the site,  country, Alexa ranking and other data that is available on-line. All  this information has been used to make a formula that uses the  information that is available on-line to estimate the number of  pageviews, its worth and possible daily incom that the site has. </p>
                                     <p>&nbsp;</p>
                                     <h5> How accurate is Worth.im?</h5>
                                     <p>It is not an exact  science, but it does give you a very good picture of how many pageview,  daily ads revenue a website has. It can be used for numerous purposes  especially when doing research. An Advertisers can get an estimate of  how many pageview a site has before buying adverts. If you want to buy  a website or domain Websiteoutlook can give you a pretty good idea  about the number of pageview and website worth the site has before  contacting the owner. Websiteoutlook is good for any initial research  or just because you're curious. </p>
                                     <p>&nbsp;</p>
                                     <h5>Update This Data Button</h5>
This button will update the  website data. But this button will activate when &quot;last update is <?php echo $updateday; ?>  days ago&quot;. If listing is less then <?php echo $updateday; ?> days old then you cann't see this  button.</div>
                                    <div class="right_con">
                                    	<div class="med_ads">
                                        	<a href=""><img src="images/med_ad.gif" alt="" /></a>
                                            <a href=""><img src="images/med_ad.gif" alt="" /></a>
                                        </div>
                                        <div class="recent_reviews">
                                        	<div class="reviews_bg"><h2>Recent <?php echo $recent_review;?> Reviews</h2></div>
                                            <div class="reviews_mid">
                                                <div class="main_review">
                                                   <?php	
												include ("config.php");
												$sql = "SELECT * FROM comments ORDER BY id_2  DESC  LIMIT $recent_review"; 
												$rs_result = mysql_query ($sql); 
												while ($row = mysql_fetch_assoc($rs_result)) { 
												$website1=$row[domain];
												$comment=$row[comment];
												$small = strlen($comment)>45 ? substr($comment,0,45).'...' : $comment;
												//print "error";
												?><div class="reviews">
                                                        <a href=""><img src="http://images.pageglimpse.com/v1/thumbnails?url=http://<?php echo $website1;?>&size=small&devkey=aca714646d9ed96e77c2b191817ef727" width="76" height="63" alt="" /></a>
                                                        <h5><a href="www.<?php echo $website1; ?>"><?php echo $website1; ?></a></h5>
                                                        <p><?php echo $small; ?> <a href="www.<?php echo $website1; ?>">More >></a></p>
                                                    </div><?php }
												mysql_close($con);
			    								?>
                                                  <div class="spacer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      </div>
                  </div>
                            </div>
                       <div class="btm"></div>
                    </div>
                    <div class="under_content">
                        <div class="up"></div>
                        <div class="mid">
                            <div class="main_content">
                          	  <div class="inside_content">
                              	  <span>Worth.IM is a website assay tool, accouterment abstruse assay and SEO enhancement information. This website uses advice from Worth.IM for analysis.<br />
			    Selling your website could be a lot of assisting hypothesis for some businesses. Not alone you can accomplish a amount of money, you can aswell use this money to body your business to a next level.<br />
			    It is up to you to adjudge if to advertise your website.<br />
			    But I accept abiding for chargeless appraisal of how abundant is amount of your website.<br />
			    Quiet Light Brokerage, a business allowance close that focuses alone on affairs websites, is alms valuations to Home For Profits readers and subscribers.<br />
			    Please note. You do not accept to advertise your website &ndash; what you do with the advice is your decision, and the action is actually bland and actually free.<br />
			    Even if you do not wish to advertise it is fun alive what amount your basic acreage accept you accumulated.<br />
		      Let us get started.</span>
                              </div>
                            </div>
                        </div>
                        <div class="btm"></div>
                    </div>
                    <div class="footer">
                    	<div class="left_foot"></div>
                        <div class="mid_foot">
                        	<h6><a href="http://eziscript.com" target="_blank">Porwered by: EziScript.com </a></h6>
                            <h5><a href="<?php echo $siteurl; ?>">Worth.im &copy; 2009-2010</a></h5>
                        </div>
                        <div class="right_foot"></div>
                    </div>
                    <div class="under_content">
                        <div class="up"></div>
                        <div class="mid">
                            <div class="main_content">
                          	  <div class="inside_content">
                              	 <div class="nav">
                                 	<ul>
                                    	<?php  include("sitemapno.php"); ?>
                                    </ul>
                                 </div>
                              </div>
                            </div>
                        </div>
                        <div class="btm"></div>
                    </div>
            </div>
       </div>
</body>
</html>