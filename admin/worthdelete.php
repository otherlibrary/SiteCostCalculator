<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
define("EW_TABLE_NAME", 'worth', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "worthinfo.php" ?>
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
$worth->Export = @$_GET["export"]; // Get export parameter
$sExport = $worth->Export; // Get export parameter, used in header
$sExportFile = $worth->TableVar; // Get export file, used in header
?>
<?php

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["id"] <> "") {
	$worth->id->setQueryStringValue($_GET["id"]);
	if (!is_numeric($worth->id->QueryStringValue)) {
		Page_Terminate($worth->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $worth->id->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($worth->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($worth->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`id`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in worth class, worthinfo.php

$worth->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$worth->CurrentAction = $_POST["a_delete"];
} else {
	$worth->CurrentAction = "I"; // Display record
}
switch ($worth->CurrentAction) {
	case "D": // Delete
		$worth->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Delete Successful"; // Set up success message
			Page_Terminate($worth->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($worth->getReturnUrl()); // Return to caller
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
<p><span class="EziScript">Delete from TABLE: Website info<br><br><a href="<?php echo $worth->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="worthdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">id</td>
		<td valign="top">domain</td>
		<td valign="top">alexa</td>
		<td valign="top">country</td>
		<td valign="top">datetime</td>
		<td valign="top">worth</td>
		<td valign="top">dearn</td>
		<td valign="top">dpview</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$worth->CssClass = "ewTableRow";
	$worth->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$worth->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$worth->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $worth->DisplayAttributes() ?>>
		<td<?php echo $worth->id->CellAttributes() ?>>
<div<?php echo $worth->id->ViewAttributes() ?>><?php echo $worth->id->ViewValue ?></div>
</td>
		<td<?php echo $worth->domain->CellAttributes() ?>>
<div<?php echo $worth->domain->ViewAttributes() ?>><?php echo $worth->domain->ViewValue ?></div>
</td>
		<td<?php echo $worth->alexa->CellAttributes() ?>>
<div<?php echo $worth->alexa->ViewAttributes() ?>><?php echo $worth->alexa->ViewValue ?></div>
</td>
		<td<?php echo $worth->country->CellAttributes() ?>>
<div<?php echo $worth->country->ViewAttributes() ?>><?php echo $worth->country->ViewValue ?></div>
</td>
		<td<?php echo $worth->datetime->CellAttributes() ?>>
<div<?php echo $worth->datetime->ViewAttributes() ?>><?php echo $worth->datetime->ViewValue ?></div>
</td>
		<td<?php echo $worth->worth->CellAttributes() ?>>
<div<?php echo $worth->worth->ViewAttributes() ?>><?php echo $worth->worth->ViewValue ?></div>
</td>
		<td<?php echo $worth->dearn->CellAttributes() ?>>
<div<?php echo $worth->dearn->ViewAttributes() ?>><?php echo $worth->dearn->ViewValue ?></div>
</td>
		<td<?php echo $worth->dpview->CellAttributes() ?>>
<div<?php echo $worth->dpview->ViewAttributes() ?>><?php echo $worth->dpview->ViewValue ?></div>
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
	global $conn, $Security, $worth;
	$DeleteRows = TRUE;
	$sWrkFilter = $worth->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in worth class, worthinfo.php

	$worth->CurrentFilter = $sWrkFilter;
	$sSql = $worth->SQL();
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
			$DeleteRows = $worth->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['id'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($worth->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($worth->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $worth->CancelMessage;
			$worth->CancelMessage = "";
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
			$worth->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $worth;

	// Call Recordset Selecting event
	$worth->Recordset_Selecting($worth->CurrentFilter);

	// Load list page sql
	$sSql = $worth->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$worth->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $worth;
	$sFilter = $worth->SqlKeyFilter();
	if (!is_numeric($worth->id->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@id@", ew_AdjustSql($worth->id->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$worth->Row_Selecting($sFilter);

	// Load sql based on filter
	$worth->CurrentFilter = $sFilter;
	$sSql = $worth->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$worth->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $worth;
	$worth->id->setDbValue($rs->fields('id'));
	$worth->domain->setDbValue($rs->fields('domain'));
	$worth->alexa->setDbValue($rs->fields('alexa'));
	$worth->google_back->setDbValue($rs->fields('google_back'));
	$worth->yahoo_back->setDbValue($rs->fields('yahoo_back'));
	$worth->altavista_back->setDbValue($rs->fields('altavista_back'));
	$worth->alltheweb_back->setDbValue($rs->fields('alltheweb_back'));
	$worth->ip->setDbValue($rs->fields('ip'));
	$worth->pagerank->setDbValue($rs->fields('pagerank'));
	$worth->country->setDbValue($rs->fields('country'));
	$worth->title->setDbValue($rs->fields('title'));
	$worth->age->setDbValue($rs->fields('age'));
	$worth->dmoz->setDbValue($rs->fields('dmoz'));
	$worth->yahoodir->setDbValue($rs->fields('yahoodir'));
	$worth->inbound->setDbValue($rs->fields('inbound'));
	$worth->outbound->setDbValue($rs->fields('outbound'));
	$worth->loadtime->setDbValue($rs->fields('loadtime'));
	$worth->datetime->setDbValue($rs->fields('datetime'));
	$worth->worth->setDbValue($rs->fields('worth'));
	$worth->dearn->setDbValue($rs->fields('dearn'));
	$worth->dpview->setDbValue($rs->fields('dpview'));
	$worth->keyword->setDbValue($rs->fields('keyword'));
	$worth->description->setDbValue($rs->fields('description'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $worth;

	// Call Row Rendering event
	$worth->Row_Rendering();

	// Common render codes for all row types
	// id

	$worth->id->CellCssStyle = "";
	$worth->id->CellCssClass = "";

	// domain
	$worth->domain->CellCssStyle = "";
	$worth->domain->CellCssClass = "";

	// alexa
	$worth->alexa->CellCssStyle = "";
	$worth->alexa->CellCssClass = "";

	// country
	$worth->country->CellCssStyle = "";
	$worth->country->CellCssClass = "";

	// datetime
	$worth->datetime->CellCssStyle = "";
	$worth->datetime->CellCssClass = "";

	// worth
	$worth->worth->CellCssStyle = "";
	$worth->worth->CellCssClass = "";

	// dearn
	$worth->dearn->CellCssStyle = "";
	$worth->dearn->CellCssClass = "";

	// dpview
	$worth->dpview->CellCssStyle = "";
	$worth->dpview->CellCssClass = "";
	if ($worth->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$worth->id->ViewValue = $worth->id->CurrentValue;
		$worth->id->CssStyle = "";
		$worth->id->CssClass = "";
		$worth->id->ViewCustomAttributes = "";

		// domain
		$worth->domain->ViewValue = $worth->domain->CurrentValue;
		$worth->domain->CssStyle = "";
		$worth->domain->CssClass = "";
		$worth->domain->ViewCustomAttributes = "";

		// alexa
		$worth->alexa->ViewValue = $worth->alexa->CurrentValue;
		$worth->alexa->CssStyle = "";
		$worth->alexa->CssClass = "";
		$worth->alexa->ViewCustomAttributes = "";

		// country
		$worth->country->ViewValue = $worth->country->CurrentValue;
		$worth->country->CssStyle = "";
		$worth->country->CssClass = "";
		$worth->country->ViewCustomAttributes = "";

		// datetime
		$worth->datetime->ViewValue = $worth->datetime->CurrentValue;
		$worth->datetime->CssStyle = "";
		$worth->datetime->CssClass = "";
		$worth->datetime->ViewCustomAttributes = "";

		// worth
		$worth->worth->ViewValue = $worth->worth->CurrentValue;
		$worth->worth->CssStyle = "";
		$worth->worth->CssClass = "";
		$worth->worth->ViewCustomAttributes = "";

		// dearn
		$worth->dearn->ViewValue = $worth->dearn->CurrentValue;
		$worth->dearn->CssStyle = "";
		$worth->dearn->CssClass = "";
		$worth->dearn->ViewCustomAttributes = "";

		// dpview
		$worth->dpview->ViewValue = $worth->dpview->CurrentValue;
		$worth->dpview->CssStyle = "";
		$worth->dpview->CssClass = "";
		$worth->dpview->ViewCustomAttributes = "";

		// id
		$worth->id->HrefValue = "";

		// domain
		$worth->domain->HrefValue = "";

		// alexa
		$worth->alexa->HrefValue = "";

		// country
		$worth->country->HrefValue = "";

		// datetime
		$worth->datetime->HrefValue = "";

		// worth
		$worth->worth->HrefValue = "";

		// dearn
		$worth->dearn->HrefValue = "";

		// dpview
		$worth->dpview->HrefValue = "";
	} elseif ($worth->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($worth->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($worth->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$worth->Row_Rendered();
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
