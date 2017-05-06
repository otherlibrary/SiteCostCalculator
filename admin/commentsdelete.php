<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
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

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["id_2"] <> "") {
	$comments->id_2->setQueryStringValue($_GET["id_2"]);
	if (!is_numeric($comments->id_2->QueryStringValue)) {
		Page_Terminate($comments->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $comments->id_2->QueryStringValue;
} else {
	$bSingleDelete = FALSE;
}
if ($bSingleDelete) {
	$nKeySelected = 1; // Set up key selected count
	$arRecKeys[0] = $sKey;
} else {
	if (isset($_POST["key_m"])) { // Key in form
		$nKeySelected = count($_POST["key_m"]); // Set up key selected count
		$arRecKeys = ew_StripSlashes($_POST["key_m"]);
	}
}
if ($nKeySelected <= 0) Page_Terminate($comments->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($comments->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`id_2`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in comments class, commentsinfo.php

$comments->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$comments->CurrentAction = $_POST["a_delete"];
} else {
	$comments->CurrentAction = "I"; // Display record
}
switch ($comments->CurrentAction) {
	case "D": // Delete
		$comments->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Delete Successful"; // Set up success message
			Page_Terminate($comments->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($comments->getReturnUrl()); // Return to caller
}
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "delete"; // Page id

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="EziScript">Delete from TABLE: Comment Info<br><br><a href="<?php echo $comments->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="commentsdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">id</td>
		<td valign="top">email</td>
		<td valign="top">name</td>
		<td valign="top">comment</td>
		<td valign="top">time</td>
		<td valign="top">domain</td>
		<td valign="top">id 2</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$comments->CssClass = "ewTableRow";
	$comments->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$comments->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$comments->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $comments->DisplayAttributes() ?>>
		<td<?php echo $comments->id->CellAttributes() ?>>
<div<?php echo $comments->id->ViewAttributes() ?>><?php echo $comments->id->ViewValue ?></div>
</td>
		<td<?php echo $comments->email->CellAttributes() ?>>
<div<?php echo $comments->email->ViewAttributes() ?>><?php echo $comments->email->ViewValue ?></div>
</td>
		<td<?php echo $comments->name->CellAttributes() ?>>
<div<?php echo $comments->name->ViewAttributes() ?>><?php echo $comments->name->ViewValue ?></div>
</td>
		<td<?php echo $comments->comment->CellAttributes() ?>>
<div<?php echo $comments->comment->ViewAttributes() ?>><?php echo $comments->comment->ViewValue ?></div>
</td>
		<td<?php echo $comments->time->CellAttributes() ?>>
<div<?php echo $comments->time->ViewAttributes() ?>><?php echo $comments->time->ViewValue ?></div>
</td>
		<td<?php echo $comments->domain->CellAttributes() ?>>
<div<?php echo $comments->domain->ViewAttributes() ?>><?php echo $comments->domain->ViewValue ?></div>
</td>
		<td<?php echo $comments->id_2->CellAttributes() ?>>
<div<?php echo $comments->id_2->ViewAttributes() ?>><?php echo $comments->id_2->ViewValue ?></div>
</td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</table>
<p>
<input type="submit" name="Action" id="Action" value="Confirm Delete">
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

// ------------------------------------------------
//  Function DeleteRows
//  - Delete Records based on current filter
function DeleteRows() {
	global $conn, $Security, $comments;
	$DeleteRows = TRUE;
	$sWrkFilter = $comments->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in comments class, commentsinfo.php

	$comments->CurrentFilter = $sWrkFilter;
	$sSql = $comments->SQL();
	$conn->raiseErrorFn = 'ew_ErrorFn';
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';
	if ($rs === FALSE) {
		return FALSE;
	} elseif ($rs->EOF) {
		$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
		$rs->Close();
		return FALSE;
	}
	$conn->BeginTrans();

	// Clone old rows
	$rsold = ($rs) ? $rs->GetRows() : array();
	if ($rs) $rs->Close();

	// Call row deleting event
	if ($DeleteRows) {
		foreach ($rsold as $row) {
			$DeleteRows = $comments->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['id_2'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($comments->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($comments->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $comments->CancelMessage;
			$comments->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Delete cancelled";
		}
	}
	if ($DeleteRows) {
		$conn->CommitTrans(); // Commit the changes
	} else {
		$conn->RollbackTrans(); // Rollback changes
	}

	// Call recordset deleted event
	if ($DeleteRows) {
		foreach ($rsold as $row) {
			$comments->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $comments;

	// Call Recordset Selecting event
	$comments->Recordset_Selecting($comments->CurrentFilter);

	// Load list page sql
	$sSql = $comments->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$comments->Recordset_Selected($rs);
	return $rs;
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

	// id_2
	$comments->id_2->CellCssStyle = "";
	$comments->id_2->CellCssClass = "";
	if ($comments->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$comments->id->ViewValue = $comments->id->CurrentValue;
		$comments->id->CssStyle = "";
		$comments->id->CssClass = "";
		$comments->id->ViewCustomAttributes = "";

		// email
		$comments->email->ViewValue = $comments->email->CurrentValue;
		$comments->email->CssStyle = "";
		$comments->email->CssClass = "";
		$comments->email->ViewCustomAttributes = "";

		// name
		$comments->name->ViewValue = $comments->name->CurrentValue;
		$comments->name->CssStyle = "";
		$comments->name->CssClass = "";
		$comments->name->ViewCustomAttributes = "";

		// comment
		$comments->comment->ViewValue = $comments->comment->CurrentValue;
		if (!is_null($comments->comment->ViewValue)) $comments->comment->ViewValue = str_replace("\n", "<br>", $comments->comment->ViewValue); 
		$comments->comment->CssStyle = "";
		$comments->comment->CssClass = "";
		$comments->comment->ViewCustomAttributes = "";

		// time
		$comments->time->ViewValue = $comments->time->CurrentValue;
		$comments->time->CssStyle = "";
		$comments->time->CssClass = "";
		$comments->time->ViewCustomAttributes = "";

		// domain
		$comments->domain->ViewValue = $comments->domain->CurrentValue;
		if (!is_null($comments->domain->ViewValue)) $comments->domain->ViewValue = str_replace("\n", "<br>", $comments->domain->ViewValue); 
		$comments->domain->CssStyle = "";
		$comments->domain->CssClass = "";
		$comments->domain->ViewCustomAttributes = "";

		// id_2
		$comments->id_2->ViewValue = $comments->id_2->CurrentValue;
		$comments->id_2->CssStyle = "";
		$comments->id_2->CssClass = "";
		$comments->id_2->ViewCustomAttributes = "";

		// id
		$comments->id->HrefValue = "";

		// email
		$comments->email->HrefValue = "";

		// name
		$comments->name->HrefValue = "";

		// comment
		$comments->comment->HrefValue = "";

		// time
		$comments->time->HrefValue = "";

		// domain
		$comments->domain->HrefValue = "";

		// id_2
		$comments->id_2->HrefValue = "";
	} elseif ($comments->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($comments->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($comments->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$comments->Row_Rendered();
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
