<script type="text/javascript" src="prototype.js"> <!--
//--> </script>
<script type="text/javascript" src="prototype-effects.js"> <!--
//--> </script>
<script type="text/javascript" src="pr.js"> <!--
//--> </script>
<script type="text/javascript"> <!--
<?
include ("config.php");
$sql = "SELECT COUNT(*) as num FROM worth";
$rs_result = mysql_query ($sql);
while ($row = mysql_fetch_assoc($rs_result)) {
	$num = $row[num];
}
$sql = "SELECT domain FROM worth";
$rs_result = mysql_query ($sql);
$out1 = "";
$out2 = "";
$count = 1;
while ($row = mysql_fetch_assoc($rs_result)) {
	$domain = $row[domain];
	$out1 .= "
	new Ajax.Request('updateTitle.php?domain=".$domain."', {\n
		  onSuccess: function(response) {\n
		      var html3 = response.responseText;\n
		      document.getElementById('domain1').innerHTML = '".$count." - ".$domain."<br>Title: ' + html3;\n  } });
	new Ajax.Request('updateDescription.php?domain=".$domain."', {\n
		  onSuccess: function(response) {\n
		      var html3 = response.responseText;\n
		      document.getElementById('domain2').innerHTML = '".$count." - ".$domain."<br>Description: ' + html3;\n  } });
	new Ajax.Request('updateKeys.php?domain=".$domain."', {\n
		  onSuccess: function(response) {\n
		      var html3 = response.responseText;\n
		      document.getElementById('domain3').innerHTML = '".$count." - ".$domain."<br>Keywords: ' + html3;\n } });";  
	$count++;
}
mysql_close($con);
echo $out1;
?>
//--> </script>
<div id="domain1"></div><br>
<div id="domain2"></div><br>
<div id="domain3"></div><br>