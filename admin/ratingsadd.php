<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
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

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["id_2"] != "") {
  $ratings->id_2->setQueryStringValue($_GET["id_2"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $ratings->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $ratings->CurrentAction = "C"; // Copy Record
  } else {
    $ratings->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($ratings->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
      Page_Terminate($ratings->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$ratings->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Add New Record Successful"; // Set up success message
      Page_Terminate($ratings->KeyUrl($ratings->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$ratings->RowType = EW_ROWTYPE_ADD;  // Render add type
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "add"; // Page id

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
<p><span class="EziScript">Add to TABLE: Webiste Rating<br><br><a href="<?php echo $ratings->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fratingsadd" id="fratingsadd" action="ratingsadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
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
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="    Add    ">
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

// Load default values
function LoadDefaultValues() {
	global $ratings;
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
}

// Restore form values
function RestoreFormValues() {
	global $ratings;
	$ratings->id->CurrentValue = $ratings->id->FormValue;
	$ratings->rating->CurrentValue = $ratings->rating->FormValue;
	$ratings->domain->CurrentValue = $ratings->domain->FormValue;
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
	if ($ratings->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($ratings->RowType == EW_ROWTYPE_ADD) { // Add row

		// id
		$ratings->id->EditCustomAttributes = "";
		$ratings->id->EditValue = ew_HtmlEncode($ratings->id->CurrentValue);

		// rating
		$ratings->rating->EditCustomAttributes = "";
		$ratings->rating->EditValue = ew_HtmlEncode($ratings->rating->CurrentValue);

		// domain
		$ratings->domain->EditCustomAttributes = "";
		$ratings->domain->EditValue = ew_HtmlEncode($ratings->domain->CurrentValue);
	} elseif ($ratings->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($ratings->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$ratings->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $ratings;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $ratings->SqlKeyFilter();
	if (trim(strval($ratings->id_2->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@id_2@", ew_AdjustSql($ratings->id_2->CurrentValue), $sFilter); // Replace key value
	}
	if (!is_numeric($ratings->id_2->CurrentValue)) {
		$bCheckKey = FALSE;
	}
	if ($bCheckKey) {
		$rsChk = $ratings->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Duplicate value for primary key";
			$rsChk->Close();
			return FALSE;
		}
	}
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

	// Call Row Inserting event
	$bInsertRow = $ratings->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($ratings->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($ratings->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $ratings->CancelMessage;
			$ratings->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Insert cancelled";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {
		$ratings->id_2->setDbValue($conn->Insert_ID());
		$rsnew['id_2'] =& $ratings->id_2->DbValue;

		// Call Row Inserted event
		$ratings->Row_Inserted($rsnew);
	}
	return $AddRow;
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
