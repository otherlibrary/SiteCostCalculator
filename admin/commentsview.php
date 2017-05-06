<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
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

// Paging variables
$nStartRec = 0; // Start record index
$nStopRec = 0; // Stop record index
$nTotalRecs = 0; // Total number of records
$nDisplayRecs = 1;
$nRecRange = 10;

// Load current record
$bLoadCurrentRecord = FALSE;
if (@$_GET["id_2"] <> "") {
	$comments->id_2->setQueryStringValue($_GET["id_2"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$comments->CurrentAction = $_POST["a_view"];
} else {
	$comments->CurrentAction = "I"; // Display form
}
switch ($comments->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // Set no record message
			Page_Terminate("commentslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($comments->id_2->CurrentValue) == strval($rs->fields('id_2'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // Set no record message
				Page_Terminate("commentslist.php"); // Return to list
			} else {
				$comments->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Set return url
$comments->setReturnUrl("commentsview.php");

// Render row
$comments->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="EziScript">View TABLE: Comment Info
<br><br>
<a href="commentslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="commentsadd.php">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $comments->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $comments->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $comments->DeleteUrl() ?>">Delete</a>&nbsp;
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
<form action="commentsview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		<td<?php echo $comments->id->CellAttributes() ?>>
<div<?php echo $comments->id->ViewAttributes() ?>><?php echo $comments->id->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">email</td>
		<td<?php echo $comments->email->CellAttributes() ?>>
<div<?php echo $comments->email->ViewAttributes() ?>><?php echo $comments->email->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">name</td>
		<td<?php echo $comments->name->CellAttributes() ?>>
<div<?php echo $comments->name->ViewAttributes() ?>><?php echo $comments->name->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">comment</td>
		<td<?php echo $comments->comment->CellAttributes() ?>>
<div<?php echo $comments->comment->ViewAttributes() ?>><?php echo $comments->comment->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">time</td>
		<td<?php echo $comments->time->CellAttributes() ?>>
<div<?php echo $comments->time->ViewAttributes() ?>><?php echo $comments->time->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">domain</td>
		<td<?php echo $comments->domain->CellAttributes() ?>>
<div<?php echo $comments->domain->ViewAttributes() ?>><?php echo $comments->domain->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">id 2</td>
		<td<?php echo $comments->id_2->CellAttributes() ?>>
<div<?php echo $comments->id_2->ViewAttributes() ?>><?php echo $comments->id_2->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<form action="commentsview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="commentsview.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $comments;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$comments->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$comments->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $comments->getStartRecordNumber();
		}
	} else {
		$nStartRec = $comments->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$comments->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$comments->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$comments->setStartRecordNumber($nStartRec);
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
