﻿<? error_reporting(0);include("config.php");$language = $_GET['language'];if ($language) {include("../".$language.".php");} else {include("../en.php");}$lang = $_GET['lang'];$data = $_GET['data'];$slqNum =  "SELECT COUNT(*) as num FROM worth WHERE keyword like '%".mysql_real_escape_string($siteKeys)."%'";$resultNum = mysql_query($slqNum);while ($row = mysql_fetch_assoc($resultNum)) {	$resCount = $row[num];}if ($resCount == 0) {	echo $sale_search_no;	return;}	$adjacents = 1;	$total_pages = $resCount;	$limit = 5;	$page = $_GET['page'];	if ($page) {		$start = ($page - 1) * $limit;	} else {		$start = 0;	}	$sql = "SELECT * FROM worth WHERE ".$langWhere." ".$titleWhere." ".$descWhere." ".$prWhere." ".$costWhere." ".$incomeWhere." ".$outcomeWhere." ".$keysWhere." ".$siteIncomeTypesWhere." ".$alexaWhere." ".$ageWhere." ".$final." LIMIT $start, $limit ";	$result = mysql_query($sql);		/* Setup page vars for display. */	if ($page == 0) $page = 1;	$prev = $page - 1;	$next = $page + 1;	$lastpage = ceil($total_pages/$limit);	$lpm1 = $lastpage - 1;	$pagination = "";	if($lastpage > 1)	{			$pagination .= "<div class=\"pagination\">";		if ($page > 1) 			$pagination.= "<span onclick=\"search(".$prev.", '');\" style=\"cursor:pointer;\"><a><</a></span>";		else			$pagination.= "<span class=\"disabled\"><</span>";		if ($lastpage < 7 + ($adjacents * 2))		{				for ($counter = 1; $counter <= $lastpage; $counter++)			{				if ($counter == $page)					$pagination.= "<span class=\"current\">$counter</span>";				else					$pagination.= "<span onclick=\"search(".$counter.", '');\" style=\"cursor:pointer;\"><a>$counter</a></span>";			}		}		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some		{			if($page < 1 + ($adjacents * 2))					{				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)				{					if ($counter == $page)						$pagination.= "<span class=\"current\">$counter</span>";					else						$pagination.= "<span onclick=\"search(".$counter.", '');\" style=\"cursor:pointer;\"><a>$counter</a></span>";				}				$pagination.= "...";				$pagination.= "<span onclick=\"search(".$lpm1.", '');\" style=\"cursor:pointer;\"><a>$lpm1</a></span>";				$pagination.= "<span onclick=\"search(".$lastpage.", '');\" style=\"cursor:pointer;\"><a>$lastpage</a></span>";					}			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))			{				$pagination.= "<span onclick=\"search(1, '');\" style=\"cursor:pointer;\"><a>1</a></span>";				$pagination.= "><a>2</a></span>";				$pagination.= "...";				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)				{					if ($counter == $page)						$pagination.= "<span class=\"current\">$counter</span>";					else						$pagination.= "<span onclick=\"search(".$counter.", '');\" style=\"cursor:pointer;\"><a>$counter</a></span>";				}				$pagination.= "...";				$pagination.= "<span onclick=\"search(".$lpm1.", '');\" style=\"cursor:pointer;\"><a>$lpm1</a></span>";				$pagination.= "<span onclick=\"search(".$lastpage.", '');\" style=\"cursor:pointer;\"><a>$lastpage</a></span>";			}			else			{				$pagination.= "<span onclick=\"search(1, '');\" style=\"cursor:pointer;\"><a>1</a></span>";				$pagination.= "><a>2</a></span>";				$pagination.= "...";				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)				{					if ($counter == $page)						$pagination.= "<span class=\"current\">$counter</span>";					else						$pagination.= "<span onclick=\"search(".$counter.", '');\" style=\"cursor:pointer;\"><a>$counter</a></span>";				}			}		}		if ($page < $counter - 1) 			$pagination.= "<span onclick=\"search(".$next.", '');\" style=\"cursor:pointer;\"><a>></a></span>";		else			$pagination.= "<span class=\"disabled\">></span>";		$pagination.= "</div>\n";	}class Website {	var $worth;	var $domain;	var $keyword;	var $pagerank;	var $title;	var $description;	var $years;	var $days;	var $age;	var $daysCount;	var $lang;	var $cost;	var $cause;	var $income;	var $outcome;	var $incomeTypes;	var $alexa;	var $email;	var $jabber;	var $skype;	var $icq;	var $phone;}function endings($n, $form1, $form2, $form5) {$n = abs($n) % 100;$n1 = $n % 10;if ($n > 10 && $n < 20) return $form5;if ($n1 > 1 && $n1 < 5) return $form2;if ($n1 == 1) return $form1;return $form5;}function curPageURL() { $pageURL = 'http'; if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";} $pageURL .= "://"; if ($_SERVER["SERVER_PORT"] != "80") {  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; } else {  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; } return $pageURL;}preg_match("/^(http:\/\/)?([^\/]+)/i", curPageURL(), $matches);$host = $matches[2];preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);$mainDomain = "{$matches[0]}";if ($mainDomain == 'sitecostcalculator.com') {	$mainTitle2 = 'SiteCostCalculator.com';	$mailTo = "support@sitecostcalculator.com";} if ($mainDomain == 'sitecostcalculator.ru') {	$mainTitle2 = 'SiteCostCalculator.ru';}if ($mainDomain == 'websitepricecalculator.net') {	$mainTitle2 = 'WebsitePriceCalculator.net';	$mailTo = "support@websitepricecalculator.net";} if ($mainDomain == 'websitecostcalculator.com') {	$mainTitle2 = 'WebsiteCostCalculator.com';	$mailTo = "support@websitecostcalculator.com";} if ($mainDomain == 'websitetrafficcalculator.com') {	$mainTitle2 = 'WebsiteTrafficCalculator.com';	$mailTo = "support@websitetrafficcalculator.com";} if ($mainDomain == 'websiteworthcalculator.net') {	$mainTitle2 = 'WebsiteWorthCalculator.net';	$mailTo = "support@websiteworthcalculator.net";}if ($mainDomain == 'websitecost.info') {	$mainTitle2 = 'WebsiteCost.info';	$mailTo = "support@websitecost.info";}if ($mainDomain == 'costofwebsite.net') {	$mainTitle2 = 'costofwebsite.net';	$mailTo = "support@websitecost.info";}function ageSort($s1, $s2) {	if ($s1->daysCount < $s2->daysCount) return 1;	elseif($s1->daysCount > $s2->daysCount) return -1;	else return 0;}function prSort($s1, $s2) {	if ($s1->pagerank < $s2->pagerank) return 1;	elseif($s1->pagerank > $s2->pagerank) return -1;	else return 0;}function worthSort($s1, $s2) {	if ($s1->worth < $s2->worth) return 1;	elseif($s1->worth > $s2->worth) return -1;	else return 0;}function domainSort($s1, $s2) {	if ($s1->domain < $s2->domain) return -1;	elseif($s1->domain > $s2->domain) return 1;	else return 0;}function titleSort($s1, $s2) {	if ($s1->title < $s2->daysCtitleount) return -1;	elseif($s1->title > $s2->title) return 1;	else return 0;}function descriptionSort($s1, $s2) {	if ($s1->description < $s2->description) return -1;	elseif($s1->description > $s2->description) return 1;	else return 0;}	while ($row = mysql_fetch_assoc($result)) {	if ($age) {		if ($row[age] != 'Unknown') {			list($years2, $yearsStr, $days, $daysStr) = split(' ', $row[age]);			if ($years2 == $age) {				$website = new Website();				$website->domain = $row[domain];				$website->keyword = $row[keyword];				$website->worth = $row[worth];				$website->pagerank = $row[pagerank];				$website->title = $row[title];				$website->description = $row[description];				if ($row[age] != 'Unknown') {					list($website->years, $bebebe1, $website->days, $bebebe2) = explode(" ", $row[age]);					$website->age = $row[age];					$website->daysCount = ($website->years * 365) + $website->days;				}				$website->lang = $row[sccLanguage];				$website->cost = $row[sccCost];				$website->income = $row[sccMonthlyIncome];				$website->outcome = $row[sccMonthlyOutcome];				$website->incomeTypes = $row[sccIncomeTypes];				$website->cause = $row[sccCause];				$website->alexa = $row[alexa];				$website->email = $row[sccEmail];				$website->jabber = $row[sccJabber];				$website->skype = $row[sccSkype];				$website->icq = $row[sccIcq];				$website->phone = $row[sccPhone];				$arr[] = $website;			}		}	} else {	$website = new Website();	$website->domain = $row[domain];	$website->keyword = $row[keyword];	$website->worth = $row[worth];	$website->pagerank = $row[pagerank];	$website->title = $row[title];	$website->description = $row[description];	if ($row[age] != 'Unknown') {		list($website->years, $bebebe1, $website->days, $bebebe2) = explode(" ", $row[age]);		$website->age = $row[age];		$website->daysCount = ($website->years * 365) + $website->days;	}	$website->lang = $row[sccLanguage];	$website->cost = $row[sccCost];	$website->income = $row[sccMonthlyIncome];	$website->outcome = $row[sccMonthlyOutcome];	$website->incomeTypes = $row[sccIncomeTypes];	$website->cause = $row[sccCause];	$website->alexa = $row[alexa];	$website->email = $row[sccEmail];	$website->jabber = $row[sccJabber];	$website->skype = $row[sccSkype];	$website->icq = $row[sccIcq];	$website->phone = $row[sccPhone];	$arr[] = $website;	}}mysql_close($con);	$out = "<table class=\"sortable\"><translate><td>".$pagination."</td></translate><translate><td>&nbsp;</td></translate>";	if (count($arr) > 0) {	$spanCount = 1;	foreach($arr as $site) {		if ($site->incomeTypes) {			$incomeTypesEnum = $site->incomeTypes;			$splitted = array_map('trim',explode(",",$incomeTypesEnum));		}		if ($site->years) {			$siteAge = $site->years." ".endings($site->years, $ageYears1, $ageYears2, $ageYears5)." ".$site->days." ".endings($site->days, $ageDays1, $ageDays2, $ageDays5);		} else {			$siteAge = $ageNot;		}		 $worth=$site->worth;		 $worthInt = intval($worth);		 $worthInt = $worthInt * 3;		 if ($worthInt == 0) {		 	$worthInt = 100;		 }				$emailC = ($site->email) ? "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='<a href=mailto:".$site->email.">".$site->email."</a>';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/email_icon_small.png\" style=\"border:none; margin-bottom:-4px;\"></a>" : "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$sale_con_no."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/email_icon_small.png\" style=\"border:none; margin-bottom:-4px; opacity: 0.2;\"></a>";		$jabberC = ($site->jabber) ? "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$site->jabber."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/jabber_icon_small.png\" style=\"border:none; margin-bottom:-4px;\"></a>" : "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$sale_con_no."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/jabber_icon_small.png\" style=\"border:none; margin-bottom:-4px; opacity: 0.2;\"></a>";		$skypeC = ($site->skype) ? "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$site->skype."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/skype_icon_small.png\" style=\"border:none; margin-bottom:-4px;\"></a>" : "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$sale_con_no."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/skype_icon_small.png\" style=\"border:none; margin-bottom:-4px; opacity: 0.2;\"></a>";		$icqC = ($site->icq) ? "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$site->icq."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/icq_icon_small.png\" style=\"border:none; margin-bottom:-4px;\"></a>" : "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$sale_con_no."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/icq_icon_small.png\" style=\"border:none; margin-bottom:-4px; opacity: 0.2;\"></a>";		$phoneC = ($site->phone) ? "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$site->phone."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/phone_icon_small.png\" style=\"border:none; margin-bottom:-4px;\"></a>" : "&nbsp;<a onclick=\"document.getElementById('show_s_".$spanCount."').innerHTML='".$sale_con_no."';\" style=\"cursor:pointer;\"><img src=\"http://".$mainTitle2."/phone_icon_small.png\" style=\"border:none; margin-bottom:-4px; opacity: 0.2;\"></a>";		$monthlyIncome = ($site->income) ? $ss_in.": <b><span style=\"background-color:rgb(175, 235, 248);\">$".$site->income."</span></b>&nbsp;&nbsp;&nbsp;" : "";		$monthlyOutcome = ($site->outcome) ? $ss_out.": <b><span style=\"background-color:rgb(223, 237, 173);\">$".$site->outcome."</span></b>" : "";		$cause = ($site->cause) ? "<br><b>".$sale1.": </b>".$site->cause : "";		$out .= "<translate><td><a href=\"go.php?to=http://".$site->domain."\" target=\"_blank\">			 <img height=\"90\" style=\"border:solid 1px gray; float:left; margin-right:10px;\" width=\"120\" src=\"http://open.thumbshots.org/image.pxf?url=".$site->domain."\" title=\"".$site->domain."\" alt=\"".$site->domain."\"></a>		         <font style=\"font-family: georgia, serif; font-size:11pt;\">			 <b><a href=\"www.".$site->domain."\">".$site->domain."</a></b>			 </font>&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"pr".$site->pagerank.".gif\" style=\"margin-bottom:-4px;\">&nbsp;&nbsp;&nbsp;&nbsp;			<font style=\"font-family: georgia, serif; font-size:10pt;\">			<i>".$ss_req_cost.":&nbsp;<span style=\"background-color:rgb(248, 203, 204);\">$".$site->cost."</span></i>&nbsp;&nbsp;&nbsp;&nbsp;			<i>".$ss_est_cost.":&nbsp<span style=\"background-color:rgb(213, 252, 209);\">$".number_format($worthInt, 0, ',', ',')."</span></i>&nbsp;&nbsp;&nbsp;&nbsp;			<i>".$siteAge."</i>			</font>			<br>		         <font style=\"font-family: georgia, serif; font-size:10pt;\">			 <b>".$site->title."</b>			 </font>			 <br>		         <font style=\"font-family: georgia, serif; font-size:10pt;\">			 ".$site->description."			 </font>";		$out .= "<br>".$monthlyIncome.$monthlyOutcome.$cause;		if (count($splitted) > 0) {			$out .= "<br><b>".$sale3.":</b> ";			$sCount = 1;			foreach($splitted as $type) {				if ($sCount % 12 == 0) {					$out .= "<br>";				} else {					$out .= "<span style=\"text-decoration:none; color:green; cursor:pointer;background-color:#EDF8FC;font-family: georgia, serif; font-size:11pt;\" onclick=\"document.getElementById('siteIncomeTypes').value = '".$type."'; search(1, '".$type."'); return false;\">".$type."</span>&nbsp;&nbsp;&nbsp;";				}				$sCount++;			}		}		$out .= "<br><b>".$sale_con.":</b>".$emailC.$skypeC.$jabberC.$icqC.$phoneC;		$out .= "&nbsp;&nbsp;&nbsp;<span id=\"show_s_".$spanCount."\"></span>";		$out .= "</td></translate><translate><td>&nbsp</td></translate>";		$spanCount++;	}	}	$out .= "<translate><td>".$pagination."</td></translate></table>";unset($arr);echo $out;?>