<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
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

// Paging variables
$nStartRec = 0; // Start record index
$nStopRec = 0; // Stop record index
$nTotalRecs = 0; // Total number of records
$nDisplayRecs = 1;
$nRecRange = 10;

// Load current record
$bLoadCurrentRecord = FALSE;
if (@$_GET["id"] <> "") {
	$worth->id->setQueryStringValue($_GET["id"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$worth->CurrentAction = $_POST["a_view"];
} else {
	$worth->CurrentAction = "I"; // Display form
}
switch ($worth->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // Set no record message
			Page_Terminate("worthlist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($worth->id->CurrentValue) == strval($rs->fields('id'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // Set no record message
				Page_Terminate("worthlist.php"); // Return to list
			} else {
				$worth->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Set return url
$worth->setReturnUrl("worthview.php");

// Render row
$worth->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="EziScript">View TABLE: Website info
<br><br>
<a href="worthlist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="worthadd.php">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $worth->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $worth->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $worth->DeleteUrl() ?>">Delete</a>&nbsp;
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
<form action="worthview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		<td<?php echo $worth->id->CellAttributes() ?>>
<div<?php echo $worth->id->ViewAttributes() ?>><?php echo $worth->id->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">domain</td>
		<td<?php echo $worth->domain->CellAttributes() ?>>
<div<?php echo $worth->domain->ViewAttributes() ?>><?php echo $worth->domain->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">alexa</td>
		<td<?php echo $worth->alexa->CellAttributes() ?>>
<div<?php echo $worth->alexa->ViewAttributes() ?>><?php echo $worth->alexa->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">google back</td>
		<td<?php echo $worth->google_back->CellAttributes() ?>>
<div<?php echo $worth->google_back->ViewAttributes() ?>><?php echo $worth->google_back->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">yahoo back</td>
		<td<?php echo $worth->yahoo_back->CellAttributes() ?>>
<div<?php echo $worth->yahoo_back->ViewAttributes() ?>><?php echo $worth->yahoo_back->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">altavista back</td>
		<td<?php echo $worth->altavista_back->CellAttributes() ?>>
<div<?php echo $worth->altavista_back->ViewAttributes() ?>><?php echo $worth->altavista_back->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">alltheweb back</td>
		<td<?php echo $worth->alltheweb_back->CellAttributes() ?>>
<div<?php echo $worth->alltheweb_back->ViewAttributes() ?>><?php echo $worth->alltheweb_back->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">ip</td>
		<td<?php echo $worth->ip->CellAttributes() ?>>
<div<?php echo $worth->ip->ViewAttributes() ?>><?php echo $worth->ip->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">pagerank</td>
		<td<?php echo $worth->pagerank->CellAttributes() ?>>
<div<?php echo $worth->pagerank->ViewAttributes() ?>><?php echo $worth->pagerank->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">country</td>
		<td<?php echo $worth->country->CellAttributes() ?>>
<div<?php echo $worth->country->ViewAttributes() ?>><?php echo $worth->country->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">title</td>
		<td<?php echo $worth->title->CellAttributes() ?>>
<div<?php echo $worth->title->ViewAttributes() ?>><?php echo $worth->title->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">age</td>
		<td<?php echo $worth->age->CellAttributes() ?>>
<div<?php echo $worth->age->ViewAttributes() ?>><?php echo $worth->age->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">dmoz</td>
		<td<?php echo $worth->dmoz->CellAttributes() ?>>
<div<?php echo $worth->dmoz->ViewAttributes() ?>><?php echo $worth->dmoz->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">yahoodir</td>
		<td<?php echo $worth->yahoodir->CellAttributes() ?>>
<div<?php echo $worth->yahoodir->ViewAttributes() ?>><?php echo $worth->yahoodir->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">inbound</td>
		<td<?php echo $worth->inbound->CellAttributes() ?>>
<div<?php echo $worth->inbound->ViewAttributes() ?>><?php echo $worth->inbound->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">outbound</td>
		<td<?php echo $worth->outbound->CellAttributes() ?>>
<div<?php echo $worth->outbound->ViewAttributes() ?>><?php echo $worth->outbound->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">loadtime</td>
		<td<?php echo $worth->loadtime->CellAttributes() ?>>
<div<?php echo $worth->loadtime->ViewAttributes() ?>><?php echo $worth->loadtime->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">datetime</td>
		<td<?php echo $worth->datetime->CellAttributes() ?>>
<div<?php echo $worth->datetime->ViewAttributes() ?>><?php echo $worth->datetime->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">worth</td>
		<td<?php echo $worth->worth->CellAttributes() ?>>
<div<?php echo $worth->worth->ViewAttributes() ?>><?php echo $worth->worth->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">dearn</td>
		<td<?php echo $worth->dearn->CellAttributes() ?>>
<div<?php echo $worth->dearn->ViewAttributes() ?>><?php echo $worth->dearn->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">dpview</td>
		<td<?php echo $worth->dpview->CellAttributes() ?>>
<div<?php echo $worth->dpview->ViewAttributes() ?>><?php echo $worth->dpview->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">keyword</td>
		<td<?php echo $worth->keyword->CellAttributes() ?>>
<div<?php echo $worth->keyword->ViewAttributes() ?>><?php echo $worth->keyword->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">description</td>
		<td<?php echo $worth->description->CellAttributes() ?>>
<div<?php echo $worth->description->ViewAttributes() ?>><?php echo $worth->description->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<form action="worthview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="worthview.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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

	// google_back
	$worth->google_back->CellCssStyle = "";
	$worth->google_back->CellCssClass = "";

	// yahoo_back
	$worth->yahoo_back->CellCssStyle = "";
	$worth->yahoo_back->CellCssClass = "";

	// altavista_back
	$worth->altavista_back->CellCssStyle = "";
	$worth->altavista_back->CellCssClass = "";

	// alltheweb_back
	$worth->alltheweb_back->CellCssStyle = "";
	$worth->alltheweb_back->CellCssClass = "";

	// ip
	$worth->ip->CellCssStyle = "";
	$worth->ip->CellCssClass = "";

	// pagerank
	$worth->pagerank->CellCssStyle = "";
	$worth->pagerank->CellCssClass = "";

	// country
	$worth->country->CellCssStyle = "";
	$worth->country->CellCssClass = "";

	// title
	$worth->title->CellCssStyle = "";
	$worth->title->CellCssClass = "";

	// age
	$worth->age->CellCssStyle = "";
	$worth->age->CellCssClass = "";

	// dmoz
	$worth->dmoz->CellCssStyle = "";
	$worth->dmoz->CellCssClass = "";

	// yahoodir
	$worth->yahoodir->CellCssStyle = "";
	$worth->yahoodir->CellCssClass = "";

	// inbound
	$worth->inbound->CellCssStyle = "";
	$worth->inbound->CellCssClass = "";

	// outbound
	$worth->outbound->CellCssStyle = "";
	$worth->outbound->CellCssClass = "";

	// loadtime
	$worth->loadtime->CellCssStyle = "";
	$worth->loadtime->CellCssClass = "";

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

	// keyword
	$worth->keyword->CellCssStyle = "";
	$worth->keyword->CellCssClass = "";

	// description
	$worth->description->CellCssStyle = "";
	$worth->description->CellCssClass = "";
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

		// google_back
		$worth->google_back->ViewValue = $worth->google_back->CurrentValue;
		$worth->google_back->CssStyle = "";
		$worth->google_back->CssClass = "";
		$worth->google_back->ViewCustomAttributes = "";

		// yahoo_back
		$worth->yahoo_back->ViewValue = $worth->yahoo_back->CurrentValue;
		$worth->yahoo_back->CssStyle = "";
		$worth->yahoo_back->CssClass = "";
		$worth->yahoo_back->ViewCustomAttributes = "";

		// altavista_back
		$worth->altavista_back->ViewValue = $worth->altavista_back->CurrentValue;
		$worth->altavista_back->CssStyle = "";
		$worth->altavista_back->CssClass = "";
		$worth->altavista_back->ViewCustomAttributes = "";

		// alltheweb_back
		$worth->alltheweb_back->ViewValue = $worth->alltheweb_back->CurrentValue;
		$worth->alltheweb_back->CssStyle = "";
		$worth->alltheweb_back->CssClass = "";
		$worth->alltheweb_back->ViewCustomAttributes = "";

		// ip
		$worth->ip->ViewValue = $worth->ip->CurrentValue;
		$worth->ip->CssStyle = "";
		$worth->ip->CssClass = "";
		$worth->ip->ViewCustomAttributes = "";

		// pagerank
		$worth->pagerank->ViewValue = $worth->pagerank->CurrentValue;
		if (!is_null($worth->pagerank->ViewValue)) $worth->pagerank->ViewValue = str_replace("\n", "<br>", $worth->pagerank->ViewValue); 
		$worth->pagerank->CssStyle = "";
		$worth->pagerank->CssClass = "";
		$worth->pagerank->ViewCustomAttributes = "";

		// country
		$worth->country->ViewValue = $worth->country->CurrentValue;
		$worth->country->CssStyle = "";
		$worth->country->CssClass = "";
		$worth->country->ViewCustomAttributes = "";

		// title
		$worth->title->ViewValue = $worth->title->CurrentValue;
		if (!is_null($worth->title->ViewValue)) $worth->title->ViewValue = str_replace("\n", "<br>", $worth->title->ViewValue); 
		$worth->title->CssStyle = "";
		$worth->title->CssClass = "";
		$worth->title->ViewCustomAttributes = "";

		// age
		$worth->age->ViewValue = $worth->age->CurrentValue;
		if (!is_null($worth->age->ViewValue)) $worth->age->ViewValue = str_replace("\n", "<br>", $worth->age->ViewValue); 
		$worth->age->CssStyle = "";
		$worth->age->CssClass = "";
		$worth->age->ViewCustomAttributes = "";

		// dmoz
		$worth->dmoz->ViewValue = $worth->dmoz->CurrentValue;
		if (!is_null($worth->dmoz->ViewValue)) $worth->dmoz->ViewValue = str_replace("\n", "<br>", $worth->dmoz->ViewValue); 
		$worth->dmoz->CssStyle = "";
		$worth->dmoz->CssClass = "";
		$worth->dmoz->ViewCustomAttributes = "";

		// yahoodir
		$worth->yahoodir->ViewValue = $worth->yahoodir->CurrentValue;
		if (!is_null($worth->yahoodir->ViewValue)) $worth->yahoodir->ViewValue = str_replace("\n", "<br>", $worth->yahoodir->ViewValue); 
		$worth->yahoodir->CssStyle = "";
		$worth->yahoodir->CssClass = "";
		$worth->yahoodir->ViewCustomAttributes = "";

		// inbound
		$worth->inbound->ViewValue = $worth->inbound->CurrentValue;
		if (!is_null($worth->inbound->ViewValue)) $worth->inbound->ViewValue = str_replace("\n", "<br>", $worth->inbound->ViewValue); 
		$worth->inbound->CssStyle = "";
		$worth->inbound->CssClass = "";
		$worth->inbound->ViewCustomAttributes = "";

		// outbound
		$worth->outbound->ViewValue = $worth->outbound->CurrentValue;
		if (!is_null($worth->outbound->ViewValue)) $worth->outbound->ViewValue = str_replace("\n", "<br>", $worth->outbound->ViewValue); 
		$worth->outbound->CssStyle = "";
		$worth->outbound->CssClass = "";
		$worth->outbound->ViewCustomAttributes = "";

		// loadtime
		$worth->loadtime->ViewValue = $worth->loadtime->CurrentValue;
		if (!is_null($worth->loadtime->ViewValue)) $worth->loadtime->ViewValue = str_replace("\n", "<br>", $worth->loadtime->ViewValue); 
		$worth->loadtime->CssStyle = "";
		$worth->loadtime->CssClass = "";
		$worth->loadtime->ViewCustomAttributes = "";

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

		// keyword
		$worth->keyword->ViewValue = $worth->keyword->CurrentValue;
		if (!is_null($worth->keyword->ViewValue)) $worth->keyword->ViewValue = str_replace("\n", "<br>", $worth->keyword->ViewValue); 
		$worth->keyword->CssStyle = "";
		$worth->keyword->CssClass = "";
		$worth->keyword->ViewCustomAttributes = "";

		// description
		$worth->description->ViewValue = $worth->description->CurrentValue;
		if (!is_null($worth->description->ViewValue)) $worth->description->ViewValue = str_replace("\n", "<br>", $worth->description->ViewValue); 
		$worth->description->CssStyle = "";
		$worth->description->CssClass = "";
		$worth->description->ViewCustomAttributes = "";

		// id
		$worth->id->HrefValue = "";

		// domain
		$worth->domain->HrefValue = "";

		// alexa
		$worth->alexa->HrefValue = "";

		// google_back
		$worth->google_back->HrefValue = "";

		// yahoo_back
		$worth->yahoo_back->HrefValue = "";

		// altavista_back
		$worth->altavista_back->HrefValue = "";

		// alltheweb_back
		$worth->alltheweb_back->HrefValue = "";

		// ip
		$worth->ip->HrefValue = "";

		// pagerank
		$worth->pagerank->HrefValue = "";

		// country
		$worth->country->HrefValue = "";

		// title
		$worth->title->HrefValue = "";

		// age
		$worth->age->HrefValue = "";

		// dmoz
		$worth->dmoz->HrefValue = "";

		// yahoodir
		$worth->yahoodir->HrefValue = "";

		// inbound
		$worth->inbound->HrefValue = "";

		// outbound
		$worth->outbound->HrefValue = "";

		// loadtime
		$worth->loadtime->HrefValue = "";

		// datetime
		$worth->datetime->HrefValue = "";

		// worth
		$worth->worth->HrefValue = "";

		// dearn
		$worth->dearn->HrefValue = "";

		// dpview
		$worth->dpview->HrefValue = "";

		// keyword
		$worth->keyword->HrefValue = "";

		// description
		$worth->description->HrefValue = "";
	} elseif ($worth->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($worth->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($worth->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$worth->Row_Rendered();
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $worth;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$worth->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$worth->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $worth->getStartRecordNumber();
		}
	} else {
		$nStartRec = $worth->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$worth->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$worth->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$worth->setStartRecordNumber($nStartRec);
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
