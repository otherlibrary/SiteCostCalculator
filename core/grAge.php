<?
include("config.php");
$lang = $_GET['lang'];
if ($lang) {
include($lang.".php");
} else {
include("en.php");
}
$graph = "";
$sql = "SELECT * FROM worth ORDER BY id DESC LIMIT 10";
$rs_result = mysql_query ($sql);
$grCount = 0;
while ($row = mysql_fetch_assoc($rs_result)) {
	$domain = $row[domain];
                      $age=$row[age];
	list($years, $yearsStr, $days, $daysStr) = split(' ', $age);
	if ($years == 'Unknown') {
	    $years = '0';
	}
	$graph = $graph."data.setValue(".$grCount.", 0, '".$domain."');
	               data.setValue(".$grCount.", 1, ".$years.");	
	";
	$grCount = $grCount+1;
}
mysql_close($con);
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '<? echo $mmm4; ?>');
        data.addColumn('number', '<? echo $g32; ?>');
        data.addRows(10);
        <? echo $graph; ?>
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 500, height: 400, title: '<? echo $mmm1; ?>', colors: ['green'],
                          hAxis: {title: '<? echo $mmm2; ?>', titleTextStyle: {color: 'green'}},
                          vAxis: {title: '<? echo $mmm3; ?>', titleTextStyle: {color: 'green'}}
                         });
      }
    </script>


  </head>

  <body>
    <div id="chart_div"></div>
  </body>
</html>