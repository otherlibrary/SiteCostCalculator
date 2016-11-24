<?php
define("EW_PAGE_ID", "ewbv", TRUE); // Page ID
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php

// Get resize parameters
$resize = (@$_GET["resize"] <> "");
$width = (@$_GET["width"] <> "") ? $_GET["width"] : 0;
$height = (@$_GET["height"] <> "") ? $_GET["height"] : 0;
if (@$_GET["width"] == "" && @$_GET["height"] == "") {
	$width = EW_THUMBNAIL_DEFAULT_WIDTH;
	$height = EW_THUMBNAIL_DEFAULT_HEIGHT;
}
$quality = (@$_GET["quality"] <> "") ? $_GET["quality"] : EW_THUMBNAIL_DEFAULT_QUALITY;

// Resize image from physical file
if (@$_GET["fn"] <> "") {
	$fn = ew_StripSlashes($_GET["fn"]);
	$fn = str_replace("\0", "", $fn);
	if (file_exists($fn)) {
		$pathinfo = pathinfo($fn);
		$ext = strtolower($pathinfo['extension']);
		if (in_array($ext, explode(',', EW_IMAGE_ALLOWED_FILE_EXT))) {
			$size = getimagesize($fn);
			if ($size) header("Content-type: {$size['mime']}");
			echo ew_ResizeFileToBinary($fn, $width, $height, $quality);
		}
	}
	exit();
} else { // Display image from Session
	if (@$_GET["tbl"] <> "") {
		$tbl = $_GET["tbl"];
	} else {
		exit();
	}
	if (@$_GET["fld"] <> "") {
		$fld = $_GET["fld"];
	} else {
		exit();
	}

	// Get blob field
	$obj = new cUpload($tbl, $fld, TRUE);
	$obj->RestoreFromSession();
	if (!file_exists($obj->Value)) exit();
	$size = getimagesize($obj->Value);
	if ($size) header("Content-type: {$size['mime']}");
	if ($resize) {
		$obj->Resize($width, $height, $quality);
		echo $obj->Binary;
	} else {
		readfile($obj->Value);
	}
	exit();
}
?>
