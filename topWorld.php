﻿<?phpinclude('config.php');$tbl_name = "worth";$adjacents = 1;$total_pages = 64;$targetpage = "topWorld.php";$limit = 16;$page = $_GET['page'];if ($page) {    $start = ($page - 1) * $limit;} else {    $start = 0;}$sql = "SELECT * FROM worth ORDER BY pagerank DESC LIMIT $start, $limit";$result = mysql_query($sql);/* Setup page vars for display. */if ($page == 0) $page = 1;$prev = $page - 1;$next = $page + 1;$lastpage = ceil($total_pages / $limit);$lpm1 = $lastpage - 1;$pagination = "";if ($lastpage > 1) {    $pagination .= "<div class=\"pagination\">";    if ($page > 1)        $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $prev . "');\"><</a>";    else        $pagination .= "<span class=\"disabled\"><</span>";    if ($lastpage < 7 + ($adjacents * 2)) {        for ($counter = 1; $counter <= $lastpage; $counter++) {            if ($counter == $page)                $pagination .= "<span class=\"current\">$counter</span>";            else                $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $counter . "');\">$counter</a>";        }    } elseif ($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some    {        if ($page < 1 + ($adjacents * 2)) {            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {                if ($counter == $page)                    $pagination .= "<span class=\"current\">$counter</span>";                else                    $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $counter . "');\">$counter</a>";            }            $pagination .= "...";            $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $lpm1 . "');\">$lpm1</a>";            $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $lastpage . "');\">$lastpage</a>";        } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {            $pagination .= "<a href=\"#\" onclick=\"topWorld('1');\">1</a>";            $pagination .= "<a href=\"#\" onclick=\"topWorld('2');\">2</a>";            $pagination .= "...";            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {                if ($counter == $page)                    $pagination .= "<span class=\"current\">$counter</span>";                else                    $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $counter . "');\">$counter</a>";            }            $pagination .= "...";            $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $lpm1 . "');\">$lpm1</a>";            $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $lastpage . "');\">$lastpage</a>";        } else {            $pagination .= "<a href=\"#\" onclick=\"topWorld('1');\">1</a>";            $pagination .= "<a href=\"#\" onclick=\"topWorld('2');\">2</a>";            $pagination .= "...";            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {                if ($counter == $page)                    $pagination .= "<span class=\"current\">$counter</span>";                else                    $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $counter . "');\">$counter</a>";            }        }    }    if ($page < $counter - 1)        $pagination .= "<a href=\"#\" onclick=\"topWorld('" . $next . "');\">></a>";    else        $pagination .= "<span class=\"disabled\">></span>";    $pagination .= "</div>\n";}$res = "<table><center><span id='lastTitle'><b>Top World Sites</b></span><br>";while ($row = mysql_fetch_assoc($result)) {    $domain = $row[domain];    $res = $res . "<translate><td align='center'><a href='#' onclick=loadS('" . $domain . "');>" . $domain . "</td></translate>";};$res = $res . "</table></center>";mysql_close($con);echo $res . "<center>" . $pagination . "</center>";?>
