<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'filter', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "filterinfo.php" ?>
<?php include "userfn50.php" ?>
<?php include "admininfo.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Open connection to the database
$conn = ew_Connect();
?>
<?php
$Security = new cAdvancedSecurity();
?>
<?php
if (!$Security->IsLoggedIn()) $Security->AutoLogin();
if (!$Security->IsLoggedIn()) {
	$Security->SaveLastUrl();
	Page_Terminate("login.php");
}
?>
<?php

// Common page loading event (in userfn*.php)
Page_Loading();
?>
<?php

// Page load event, used in current page
Page_Load();
?>
<?php
$filter->Export = @$_GET["export"]; // Get export parameter
$sExport = $filter->Export; // Get export parameter, used in header
$sExportFile = $filter->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["domainname"] <> "") {
	$filter->domainname->setQueryStringValue($_GET["domainname"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$filter->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$filter->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($filter->domainname->CurrentValue == "") Page_Terminate($filter->getReturnUrl()); // Invalid key, exit
switch ($filter->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
			Page_Terminate($filter->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$filter->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Update successful"; // Update success
			Page_Terminate($filter->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$filter->RowType = EW_ROWTYPE_EDIT; // Render as edit
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "edit"; // Page id

//-->
</script>
<script type="text/javascript">
<!--

function ew_ValidateForm(fobj) {
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_domainname"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - domainname"))
				return false;
		}
	}
	return true;
}

//-->
</script>
<script type="text/javascript">
<!--

// js for DHtml Editor
//-->

</script>
<script type="text/javascript">
<!--

// js for Popup Calendar
//-->

</script>
<script type="text/javascript">
<!--
var ew_MultiPagePage = "Page"; // multi-page Page Text
var ew_MultiPageOf = "of"; // multi-page Of Text
var ew_MultiPagePrev = "Prev"; // multi-page Prev Text
var ew_MultiPageNext = "Next"; // multi-page Next Text

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="EziScript">Edit TABLE: Website Info<br><br><a href="<?php echo $filter->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="ffilteredit" id="ffilteredit" action="filteredit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">domainname<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $filter->domainname->CellAttributes() ?>><span id="cb_x_domainname">
<div<?php echo $filter->domainname->ViewAttributes() ?>><?php echo $filter->domainname->EditValue ?></div>
<input type="hidden" name="x_domainname" id="x_domainname" value="<?php echo ew_HtmlEncode($filter->domainname->CurrentValue) ?>">
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="   Edit   ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

// If control is passed here, simply terminate the page without redirect
Page_Terminate();

// -----------------------------------------------------------------
//  Subroutine Page_Terminate
//  - called when exit page
//  - clean up connection and objects
//  - if url specified, redirect to url, otherwise end response
function Page_Terminate($url = "") {
	global $conn;

	// Page unload event, used in current page
	Page_Unload();

	// Global page unloaded event (in userfn*.php)
	Page_Unloaded();

	 // Close Connection
	$conn->Close();

	// Go to url if specified
	if ($url <> "") {
		ob_end_clean();
		header("Location: $url");
	}
	exit();
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $filter;
	$filter->domainname->setFormValue($objForm->GetValue("x_domainname"));
}

// Restore form values
function RestoreFormValues() {
	global $filter;
	$filter->domainname->CurrentValue = $filter->domainname->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $filter;
	$sFilter = $filter->SqlKeyFilter();
	$sFilter = str_replace("@domainname@", ew_AdjustSql($filter->domainname->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$filter->Row_Selecting($sFilter);

	// Load sql based on filter
	$filter->CurrentFilter = $sFilter;
	$sSql = $filter->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$filter->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $filter;
	$filter->domainname->setDbValue($rs->fields('domainname'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $filter;

	// Call Row Rendering event
	$filter->Row_Rendering();

	// Common render codes for all row types
	// domainname

	$filter->domainname->CellCssStyle = "";
	$filter->domainname->CellCssClass = "";
	if ($filter->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($filter->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($filter->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// domainname
		$filter->domainname->EditCustomAttributes = "";
		$filter->domainname->EditValue = $filter->domainname->CurrentValue;
		if (!is_null($filter->domainname->EditValue)) $filter->domainname->EditValue = str_replace("\n", "<br>", $filter->domainname->EditValue); 
		$filter->domainname->CssStyle = "";
		$filter->domainname->CssClass = "";
		$filter->domainname->ViewCustomAttributes = "";
	} elseif ($filter->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$filter->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $filter;
	$sFilter = $filter->SqlKeyFilter();
	$sFilter = str_replace("@domainname@", ew_AdjustSql($filter->domainname->CurrentValue), $sFilter); // Replace key value
	$filter->CurrentFilter = $sFilter;
	$sSql = $filter->SQL();
	$conn->raiseErrorFn = 'ew_ErrorFn';
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';
	if ($rs === FALSE)
		return FALSE;
	if ($rs->EOF) {
		$EditRow = FALSE; // Update Failed
	} else {

		// Save old values
		$rsold =& $rs->fields;
		$rsnew = array();

		// Field domainname
		// Call Row Updating event

		$bUpdateRow = $filter->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($filter->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($filter->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $filter->CancelMessage;
				$filter->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Update cancelled";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$filter->Row_Updated($rsold, $rsnew);
	}
	$rs->Close();
	return $EditRow;
}
?>
<?php

// Page Load event
function Page_Load() {

	//echo "Page Load";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>