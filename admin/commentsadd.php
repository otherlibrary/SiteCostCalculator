<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
define("EW_TABLE_NAME", 'comments', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "commentsinfo.php" ?>
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
$comments->Export = @$_GET["export"]; // Get export parameter
$sExport = $comments->Export; // Get export parameter, used in header
$sExportFile = $comments->TableVar; // Get export file, used in header
?>
<?php
// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["id_2"] != "") {
  $comments->id_2->setQueryStringValue($_GET["id_2"]);
} else {
  $bCopy = FALSE;
}
// Create form object
$objForm = new cFormObj();
// Process form if post back
if (@$_POST["a_add"] <> "") {
  $comments->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $comments->CurrentAction = "C"; // Copy Record
  } else {
    $comments->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}
// Perform action based on action code
switch ($comments->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
      Page_Terminate($comments->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$comments->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Add New Record Successful"; // Set up success message
      Page_Terminate($comments->KeyUrl($comments->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}
// Render row based on row type
$comments->RowType = EW_ROWTYPE_ADD;  // Render add type
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
	if (fobj.a_confirm && fobj.a_confirm.value === "F")
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
		elm = fobj.elements["x" + infix + "_email"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - email"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_name"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - name"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_comment"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - comment"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_time"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - time"))
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
<p><span class="EziScript">Add to TABLE: Comment Info<br><br><a href="<?php echo $comments->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fcommentsadd" id="fcommentsadd" action="commentsadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">id<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $comments->id->CellAttributes() ?>><span id="cb_x_id">
<input type="text" name="x_id" id="x_id"  size="30" value="<?php echo $comments->id->EditValue ?>"<?php echo $comments->id->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">email<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $comments->email->CellAttributes() ?>><span id="cb_x_email">
<input type="text" name="x_email" id="x_email"  size="30" maxlength="255" value="<?php echo $comments->email->EditValue ?>"<?php echo $comments->email->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">name<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $comments->name->CellAttributes() ?>><span id="cb_x_name">
<input type="text" name="x_name" id="x_name"  size="30" maxlength="255" value="<?php echo $comments->name->EditValue ?>"<?php echo $comments->name->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">comment<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $comments->comment->CellAttributes() ?>><span id="cb_x_comment">
<textarea name="x_comment" id="x_comment" cols="35" rows="4"<?php echo $comments->comment->EditAttributes() ?>><?php echo $comments->comment->EditValue ?></textarea>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">time<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $comments->time->CellAttributes() ?>><span id="cb_x_time">
<input type="text" name="x_time" id="x_time"  size="30" maxlength="26" value="<?php echo $comments->time->EditValue ?>"<?php echo $comments->time->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">domain<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $comments->domain->CellAttributes() ?>><span id="cb_x_domain">
<textarea name="x_domain" id="x_domain" cols="35" rows="4"<?php echo $comments->domain->EditAttributes() ?>><?php echo $comments->domain->EditValue ?></textarea>
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
	global $comments;
}
?>
<?php
// Load form values
function LoadFormValues() {
	// Load from form
	global $objForm, $comments;
	$comments->id->setFormValue($objForm->GetValue("x_id"));
	$comments->email->setFormValue($objForm->GetValue("x_email"));
	$comments->name->setFormValue($objForm->GetValue("x_name"));
	$comments->comment->setFormValue($objForm->GetValue("x_comment"));
	$comments->time->setFormValue($objForm->GetValue("x_time"));
	$comments->domain->setFormValue($objForm->GetValue("x_domain"));
}
// Restore form values
function RestoreFormValues() {
	global $comments;
	$comments->id->CurrentValue = $comments->id->FormValue;
	$comments->email->CurrentValue = $comments->email->FormValue;
	$comments->name->CurrentValue = $comments->name->FormValue;
	$comments->comment->CurrentValue = $comments->comment->FormValue;
	$comments->time->CurrentValue = $comments->time->FormValue;
	$comments->domain->CurrentValue = $comments->domain->FormValue;
}
?>
<?php
// Load row based on key values
function LoadRow() {
	global $conn, $Security, $comments;
	$sFilter = $comments->SqlKeyFilter();
	if (!is_numeric($comments->id_2->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@id_2@", ew_AdjustSql($comments->id_2->CurrentValue), $sFilter); // Replace key value
	// Call Row Selecting event
	$comments->Row_Selecting($sFilter);
	// Load sql based on filter
	$comments->CurrentFilter = $sFilter;
	$sSql = $comments->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values
			// Call Row Selected event
			$comments->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}
// Load row values from recordset
function LoadRowValues(&$rs) {
	global $comments;
	$comments->id->setDbValue($rs->fields('id'));
	$comments->email->setDbValue($rs->fields('email'));
	$comments->name->setDbValue($rs->fields('name'));
	$comments->comment->setDbValue($rs->fields('comment'));
	$comments->time->setDbValue($rs->fields('time'));
	$comments->domain->setDbValue($rs->fields('domain'));
	$comments->id_2->setDbValue($rs->fields('id_2'));
}
?>
<?php
// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $comments;
	// Call Row Rendering event
	$comments->Row_Rendering();
	// Common render codes for all row types
	// id
	$comments->id->CellCssStyle = "";
	$comments->id->CellCssClass = "";
	// email
	$comments->email->CellCssStyle = "";
	$comments->email->CellCssClass = "";
	// name
	$comments->name->CellCssStyle = "";
	$comments->name->CellCssClass = "";
	// comment
	$comments->comment->CellCssStyle = "";
	$comments->comment->CellCssClass = "";
	// time
	$comments->time->CellCssStyle = "";
	$comments->time->CellCssClass = "";
	// domain
	$comments->domain->CellCssStyle = "";
	$comments->domain->CellCssClass = "";
	if ($comments->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($comments->RowType == EW_ROWTYPE_ADD) { // Add row
		// id
		$comments->id->EditCustomAttributes = "";
		$comments->id->EditValue = ew_HtmlEncode($comments->id->CurrentValue);
		// email
		$comments->email->EditCustomAttributes = "";
		$comments->email->EditValue = ew_HtmlEncode($comments->email->CurrentValue);
		// name
		$comments->name->EditCustomAttributes = "";
		$comments->name->EditValue = ew_HtmlEncode($comments->name->CurrentValue);
		// comment
		$comments->comment->EditCustomAttributes = "";
		$comments->comment->EditValue = ew_HtmlEncode($comments->comment->CurrentValue);
		// time
		$comments->time->EditCustomAttributes = "";
		$comments->time->EditValue = ew_HtmlEncode($comments->time->CurrentValue);
		// domain
		$comments->domain->EditCustomAttributes = "";
		$comments->domain->EditValue = ew_HtmlEncode($comments->domain->CurrentValue);
	} elseif ($comments->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($comments->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}
	// Call Row Rendered event
	$comments->Row_Rendered();
}
?>
<?php
// Add record
function AddRow() {
	global $conn, $Security, $comments;
	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $comments->SqlKeyFilter();
	if (trim(strval($comments->id_2->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@id_2@", ew_AdjustSql($comments->id_2->CurrentValue), $sFilter); // Replace key value
	}
	if (!is_numeric($comments->id_2->CurrentValue)) {
		$bCheckKey = FALSE;
	}
	if ($bCheckKey) {
		$rsChk = $comments->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Duplicate value for primary key";
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();
	// Field id
	$comments->id->SetDbValueDef($comments->id->CurrentValue, 0);
	$rsnew['id'] =& $comments->id->DbValue;
	// Field email
	$comments->email->SetDbValueDef($comments->email->CurrentValue, "");
	$rsnew['email'] =& $comments->email->DbValue;
	// Field name
	$comments->name->SetDbValueDef($comments->name->CurrentValue, "");
	$rsnew['name'] =& $comments->name->DbValue;
	// Field comment
	$comments->comment->SetDbValueDef($comments->comment->CurrentValue, "");
	$rsnew['comment'] =& $comments->comment->DbValue;
	// Field time
	$comments->time->SetDbValueDef($comments->time->CurrentValue, "");
	$rsnew['time'] =& $comments->time->DbValue;
	// Field domain
	$comments->domain->SetDbValueDef($comments->domain->CurrentValue, "");
	$rsnew['domain'] =& $comments->domain->DbValue;
	// Call Row Inserting event
	$bInsertRow = $comments->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($comments->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($comments->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $comments->CancelMessage;
			$comments->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Insert cancelled";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {
		$comments->id_2->setDbValue($conn->Insert_ID());
		$rsnew['id_2'] =& $comments->id_2->DbValue;
		// Call Row Inserted event
		$comments->Row_Inserted($rsnew);
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
