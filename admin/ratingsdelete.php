<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
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

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["id_2"] <> "") {
	$ratings->id_2->setQueryStringValue($_GET["id_2"]);
	if (!is_numeric($ratings->id_2->QueryStringValue)) {
		Page_Terminate($ratings->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $ratings->id_2->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($ratings->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($ratings->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`id_2`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in ratings class, ratingsinfo.php

$ratings->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$ratings->CurrentAction = $_POST["a_delete"];
} else {
	$ratings->CurrentAction = "I"; // Display record
}
switch ($ratings->CurrentAction) {
	case "D": // Delete
		$ratings->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Delete Successful"; // Set up success message
			Page_Terminate($ratings->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($ratings->getReturnUrl()); // Return to caller
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
<p><span class="EziScript">Delete from TABLE: Webiste Rating<br><br><a href="<?php echo $ratings->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="ratingsdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">id</td>
		<td valign="top">rating</td>
		<td valign="top">domain</td>
		<td valign="top">id 2</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$ratings->CssClass = "ewTableRow";
	$ratings->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$ratings->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$ratings->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $ratings->DisplayAttributes() ?>>
		<td<?php echo $ratings->id->CellAttributes() ?>>
<div<?php echo $ratings->id->ViewAttributes() ?>><?php echo $ratings->id->ViewValue ?></div>
</td>
		<td<?php echo $ratings->rating->CellAttributes() ?>>
<div<?php echo $ratings->rating->ViewAttributes() ?>><?php echo $ratings->rating->ViewValue ?></div>
</td>
		<td<?php echo $ratings->domain->CellAttributes() ?>>
<div<?php echo $ratings->domain->ViewAttributes() ?>><?php echo $ratings->domain->ViewValue ?></div>
</td>
		<td<?php echo $ratings->id_2->CellAttributes() ?>>
<div<?php echo $ratings->id_2->ViewAttributes() ?>><?php echo $ratings->id_2->ViewValue ?></div>
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
	global $conn, $Security, $ratings;
	$DeleteRows = TRUE;
	$sWrkFilter = $ratings->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in ratings class, ratingsinfo.php

	$ratings->CurrentFilter = $sWrkFilter;
	$sSql = $ratings->SQL();
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
			$DeleteRows = $ratings->Row_Deleting($row);
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
			$DeleteRows = $conn->Execute($ratings->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($ratings->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $ratings->CancelMessage;
			$ratings->CancelMessage = "";
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
			$ratings->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $ratings;

	// Call Recordset Selecting event
	$ratings->Recordset_Selecting($ratings->CurrentFilter);

	// Load list page sql
	$sSql = $ratings->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$ratings->Recordset_Selected($rs);
	return $rs;
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

		// id
		$ratings->id->ViewValue = $ratings->id->CurrentValue;
		$ratings->id->CssStyle = "";
		$ratings->id->CssClass = "";
		$ratings->id->ViewCustomAttributes = "";

		// rating
		$ratings->rating->ViewValue = $ratings->rating->CurrentValue;
		$ratings->rating->CssStyle = "";
		$ratings->rating->CssClass = "";
		$ratings->rating->ViewCustomAttributes = "";

		// domain
		$ratings->domain->ViewValue = $ratings->domain->CurrentValue;
		if (!is_null($ratings->domain->ViewValue)) $ratings->domain->ViewValue = str_replace("\n", "<br>", $ratings->domain->ViewValue); 
		$ratings->domain->CssStyle = "";
		$ratings->domain->CssClass = "";
		$ratings->domain->ViewCustomAttributes = "";

		// id_2
		$ratings->id_2->ViewValue = $ratings->id_2->CurrentValue;
		$ratings->id_2->CssStyle = "";
		$ratings->id_2->CssClass = "";
		$ratings->id_2->ViewCustomAttributes = "";

		// id
		$ratings->id->HrefValue = "";

		// rating
		$ratings->rating->HrefValue = "";

		// domain
		$ratings->domain->HrefValue = "";

		// id_2
		$ratings->id_2->HrefValue = "";
	} elseif ($ratings->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($ratings->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($ratings->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$ratings->Row_Rendered();
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
