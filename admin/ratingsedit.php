<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'ratings', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "ratingsinfo.php" ?>
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
$ratings->Export = @$_GET["export"]; // Get export parameter
$sExport = $ratings->Export; // Get export parameter, used in header
$sExportFile = $ratings->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["id_2"] <> "") {
	$ratings->id_2->setQueryStringValue($_GET["id_2"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$ratings->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$ratings->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($ratings->id_2->CurrentValue == "") Page_Terminate($ratings->getReturnUrl()); // Invalid key, exit
switch ($ratings->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
			Page_Terminate($ratings->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$ratings->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Update successful"; // Update success
			Page_Terminate($ratings->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$ratings->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
		elm = fobj.elements["x" + infix + "_id"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - id"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_id"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Incorrect integer - id"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_rating"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - rating"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_rating"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Incorrect integer - rating"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_domain"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - domain"))
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
<p><span class="EziScript">Edit TABLE: Webiste Rating<br><br><a href="<?php echo $ratings->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fratingsedit" id="fratingsedit" action="ratingsedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">id<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $ratings->id->CellAttributes() ?>><span id="cb_x_id">
<input type="text" name="x_id" id="x_id"  size="30" value="<?php echo $ratings->id->EditValue ?>"<?php echo $ratings->id->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">rating<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $ratings->rating->CellAttributes() ?>><span id="cb_x_rating">
<input type="text" name="x_rating" id="x_rating"  size="30" value="<?php echo $ratings->rating->EditValue ?>"<?php echo $ratings->rating->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">domain<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $ratings->domain->CellAttributes() ?>><span id="cb_x_domain">
<textarea name="x_domain" id="x_domain" cols="35" rows="4"<?php echo $ratings->domain->EditAttributes() ?>><?php echo $ratings->domain->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">id 2</td>
		<td<?php echo $ratings->id_2->CellAttributes() ?>><span id="cb_x_id_2">
<div<?php echo $ratings->id_2->ViewAttributes() ?>><?php echo $ratings->id_2->EditValue ?></div>
<input type="hidden" name="x_id_2" id="x_id_2" value="<?php echo ew_HtmlEncode($ratings->id_2->CurrentValue) ?>">
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
	global $objForm, $ratings;
	$ratings->id->setFormValue($objForm->GetValue("x_id"));
	$ratings->rating->setFormValue($objForm->GetValue("x_rating"));
	$ratings->domain->setFormValue($objForm->GetValue("x_domain"));
	$ratings->id_2->setFormValue($objForm->GetValue("x_id_2"));
}

// Restore form values
function RestoreFormValues() {
	global $ratings;
	$ratings->id->CurrentValue = $ratings->id->FormValue;
	$ratings->rating->CurrentValue = $ratings->rating->FormValue;
	$ratings->domain->CurrentValue = $ratings->domain->FormValue;
	$ratings->id_2->CurrentValue = $ratings->id_2->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $ratings;
	$sFilter = $ratings->SqlKeyFilter();
	if (!is_numeric($ratings->id_2->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@id_2@", ew_AdjustSql($ratings->id_2->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$ratings->Row_Selecting($sFilter);

	// Load sql based on filter
	$ratings->CurrentFilter = $sFilter;
	$sSql = $ratings->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$ratings->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $ratings;
	$ratings->id->setDbValue($rs->fields('id'));
	$ratings->rating->setDbValue($rs->fields('rating'));
	$ratings->domain->setDbValue($rs->fields('domain'));
	$ratings->id_2->setDbValue($rs->fields('id_2'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $ratings;

	// Call Row Rendering event
	$ratings->Row_Rendering();

	// Common render codes for all row types
	// id

	$ratings->id->CellCssStyle = "";
	$ratings->id->CellCssClass = "";

	// rating
	$ratings->rating->CellCssStyle = "";
	$ratings->rating->CellCssClass = "";

	// domain
	$ratings->domain->CellCssStyle = "";
	$ratings->domain->CellCssClass = "";

	// id_2
	$ratings->id_2->CellCssStyle = "";
	$ratings->id_2->CellCssClass = "";
	if ($ratings->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($ratings->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($ratings->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// id
		$ratings->id->EditCustomAttributes = "";
		$ratings->id->EditValue = ew_HtmlEncode($ratings->id->CurrentValue);

		// rating
		$ratings->rating->EditCustomAttributes = "";
		$ratings->rating->EditValue = ew_HtmlEncode($ratings->rating->CurrentValue);

		// domain
		$ratings->domain->EditCustomAttributes = "";
		$ratings->domain->EditValue = ew_HtmlEncode($ratings->domain->CurrentValue);

		// id_2
		$ratings->id_2->EditCustomAttributes = "";
		$ratings->id_2->EditValue = $ratings->id_2->CurrentValue;
		$ratings->id_2->CssStyle = "";
		$ratings->id_2->CssClass = "";
		$ratings->id_2->ViewCustomAttributes = "";
	} elseif ($ratings->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$ratings->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $ratings;
	$sFilter = $ratings->SqlKeyFilter();
	if (!is_numeric($ratings->id_2->CurrentValue)) {
		return FALSE;
	}
	$sFilter = str_replace("@id_2@", ew_AdjustSql($ratings->id_2->CurrentValue), $sFilter); // Replace key value
	$ratings->CurrentFilter = $sFilter;
	$sSql = $ratings->SQL();
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

		// Field id
		$ratings->id->SetDbValueDef($ratings->id->CurrentValue, 0);
		$rsnew['id'] =& $ratings->id->DbValue;

		// Field rating
		$ratings->rating->SetDbValueDef($ratings->rating->CurrentValue, 0);
		$rsnew['rating'] =& $ratings->rating->DbValue;

		// Field domain
		$ratings->domain->SetDbValueDef($ratings->domain->CurrentValue, "");
		$rsnew['domain'] =& $ratings->domain->DbValue;

		// Field id_2
		// Call Row Updating event

		$bUpdateRow = $ratings->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($ratings->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($ratings->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $ratings->CancelMessage;
				$ratings->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Update cancelled";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$ratings->Row_Updated($rsold, $rsnew);
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
