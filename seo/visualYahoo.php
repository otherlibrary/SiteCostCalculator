﻿<?
include("config.php");
$lang = $_GET['lang'];
if ($lang) {
include("../".$lang.".php");
} else {
include("../en.php");
}
$domain = $_GET['domain'];
$graph = "";
$sql = "SELECT yahoo_links FROM worth WHERE domain = '$domain' LIMIT 1";
$rs_result = mysql_query($sql);
$grCount = 0;
$arr = array();
$count = 0;
while ($row = mysql_fetch_assoc($rs_result)) {
	$links = $row[yahoo_links];
	$googleLinks = explode(",", $links);
	$count = 0;
	foreach ($googleLinks as $googleLink) {
		if (!is_numeric($googleLink)) {
			list($d, $n) = explode(' ', $googleLink);
			$n = str_replace(array(')','('), array('',''), $n);
			list($d2, $tld) = explode('.', $d);
			for ($i = 1; $i <= $n; $i++) {
				$arr[] = $tld;
			}			
		}
	}
}
foreach ($arr as $key => $value) {
  if (is_null($value)) {
    unset($arr[$key]);
  }
}
$backsArr = array();
$q=array_count_values($arr);
$i = 0;
foreach ($q as $k=>$v) {
	$backsArr[$i]['tld'] = $k;
	$backsArr[$i]['count'] = $v;
	$i++;
}
$countKeys = array();
foreach ($backsArr as $key => $item) {
    $countKeys[$key] = $item['count'];
}
array_multisort($countKeys, SORT_DESC, $backsArr);
$i = 1;
$backsOut = "";
foreach ($backsArr as $key => $item) {
	if ($i <= 10) {
		$graph = $graph."data.setValue(".$grCount.", 0, '".$item[tld]."'); data.setValue(".$grCount.", 1, ".$item[count].");";
		$grCount++;
	}
	$i++;
}
mysql_close($con);
$height = 300;
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '<? echo $mmm8 ?>');
        data.addColumn('number', '<? echo $mmm9 ?>');
	data.addRows(<? echo $grCount ?>);
        <? echo $graph; ?>
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 1100, height: <? echo $height; ?>, title: '<? echo $mmm7; ?>',
                          vAxis: {title: '<? echo $mmm8; ?>', titleTextStyle: {color: 'blue'}},
                          hAxis: {title: '<? echo $mmm9; ?>', titleTextStyle: {color: 'blue'}},
                         });
      }
    </script>

  </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html>