<?php
if (isset($_GET['to'])) {
	$to = $_GET['to'];
	Header("Location: ".$to."");
} else {
die;
}
?>