﻿<?include("gzip.php");include("config.php");$lang = $_GET['lang'];if ($lang) {include($lang.".php");} else {include("en.php");}$graph = "";$sql = "SELECT * FROM worth ORDER BY id DESC LIMIT 10";$rs_result = mysql_query ($sql);$grCount = 0;while ($row = mysql_fetch_assoc($rs_result)) {	$domain = $row[domain];	 $dearn=$row[dearn];	 $dearnInt = intval($dearn);	 $dearnInt = $dearnInt * 11;		 	 if ($dearnInt == 0) {	 	$dearnInt = 1;	 }	$graph = $graph."data.setValue(".$grCount.", 0, '".$domain."');	               data.setValue(".$grCount.", 1, ".$dearnInt.");		";	$grCount = $grCount+1;}mysql_close($con);?><html>  <head>    <script type="text/javascript" src="https://www.google.com/jsapi"></script>    <script type="text/javascript">      google.load("visualization", "1", {packages:["corechart"]});      google.setOnLoadCallback(drawChart);      function drawChart() {        var data = new google.visualization.DataTable();        data.addColumn('string', 'Site');        data.addColumn('number', '$daily');        data.addRows(10);        <? echo $graph; ?>        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));        chart.draw(data, {width: 500, height: 400, title: '<? echo $mmm5; ?>',                          vAxis: {title: '<? echo $mmm2; ?>', titleTextStyle: {color: 'blue'}},                          hAxis: {title: '<? echo $mmm6; ?>', titleTextStyle: {color: 'blue'}}        });      }    </script>  </head>  <body>    <div id="chart_div"></div>  </body></html>