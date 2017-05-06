<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
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

// Paging variables
$nStartRec = 0; // Start record index
$nStopRec = 0; // Stop record index
$nTotalRecs = 0; // Total number of records
$nDisplayRecs = 1;
$nRecRange = 10;

// Load current record
$bLoadCurrentRecord = FALSE;
if (@$_GET["id_2"] <> "") {
	$ratings->id_2->setQueryStringValue($_GET["id_2"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$ratings->CurrentAction = $_POST["a_view"];
} else {
	$ratings->CurrentAction = "I"; // Display form
}
switch ($ratings->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // Set no record message
			Page_Terminate("ratingslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($ratings->id_2->CurrentValue) == strval($rs->fields('id_2'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // Set no record message
				Page_Terminate("ratingslist.php"); // Return to list
			} else {
				$ratings->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Set return url
$ratings->setReturnUrl("ratingsview.php");

// Render row
$ratings->RowType = EW_ROWTYPE_VIEW;
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "view"; // Page id

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="EziScript">View TABLE: Webiste Rating
<br><br>
<a href="ratingslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="ratingsadd.php">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ratings->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ratings->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ratings->DeleteUrl() ?>">Delete</a>&nbsp;
<?php } ?>
</span>
</p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<p>
<form action="ratingsview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="EziScript">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	<span class="EziScript">Records <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sSrchWhere == "0=101") { ?>
	<span class="EziScript">Please enter search criteria</span>
	<?php } else { ?>
	<span class="EziScript">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<form>
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">id</td>
		<td<?php echo $ratings->id->CellAttributes() ?>>
<div<?php echo $ratings->id->ViewAttributes() ?>><?php echo $ratings->id->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">rating</td>
		<td<?php echo $ratings->rating->CellAttributes() ?>>
<div<?php echo $ratings->rating->ViewAttributes() ?>><?php echo $ratings->rating->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">domain</td>
		<td<?php echo $ratings->domain->CellAttributes() ?>>
<div<?php echo $ratings->domain->ViewAttributes() ?>><?php echo $ratings->domain->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">id 2</td>
		<td<?php echo $ratings->id_2->CellAttributes() ?>>
<div<?php echo $ratings->id_2->ViewAttributes() ?>><?php echo $ratings->id_2->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<form action="ratingsview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="ratingsview.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="EziScript">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	<span class="EziScript">Records <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sSrchWhere == "0=101") { ?>
	<span class="EziScript">Please enter search criteria</span>
	<?php } else { ?>
	<span class="EziScript">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<p>
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

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $ratings;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$ratings->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$ratings->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $ratings->getStartRecordNumber();
		}
	} else {
		$nStartRec = $ratings->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$ratings->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$ratings->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$ratings->setStartRecordNumber($nStartRec);
	}
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
