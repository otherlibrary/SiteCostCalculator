<?php
include("config.php");
require_once("my_pagina_class.php");

$test = new MyPagina(500);
$test->number_links = 5;
$test->sql = "SELECT id, domain FROM worth WHERE domain like '%forum%'";
$result = $test->get_page_result();
$num_rows = $test->get_page_num_rows();
$nav_info = $test->page_info("Result: %d - %d of %d records");
$nav_links = $test->navigation(" | ", "currentStyle", false, false, false, true);
$numbers_only = $test->navigation("", "current", true);
$simple_nav_links = $test->back_forward_link(true);
$test->forw = "&#9658;";
$test->back = "&#9668;";
$simple_nav_txt_links = $test->back_forward_link();
$total_recs = $test->get_total_rows();
?>
<style type="text/css">
<!--
body {
	font-family:"Courier New", Courier, mono;
}
.currentStyle {
	font-size:1.5em;
	font-weight:bold;
}

#numbers a, #numbers span {
	display:block;
	width:20px;
	font:bold 12px/20px Arial, Helvetica, sans-serif;
	text-decoration:none;
	float:left;
	text-align:center;
	margin-right:7px;
	border:1px solid #999999;
}
#numbers a {
	background-color:#CCCCCC;
	color:#000000;
}
#numbers a:hover {
	color:#CCCCCC;
	background-color:#000000;
}
#numbers span.current {
	color:#FFFFFF;
	background-color:#990000;
}
-->
</style>
</head>

<body>
<p>
<?
echo $nav_info."<br><br>";
for ($i = 0; $i < $num_rows; $i++) {
	$id = mysql_result($result, $i, "id");
	$domain = mysql_result($result, $i, "domain");
	echo ($id <= 9) ? "&nbsp;".$id : $id;
	echo " -> ".$domain."<br>\n";
}
echo "<p id=\"numbers\">".$numbers_only."</p>\n";

$test->free_page_result();
mysql_close($con);
?>