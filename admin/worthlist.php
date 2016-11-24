<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
if ($worth->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($worth->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($worth->Export == "csv") {
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.csv');
}
?>
<?php

// Paging variables
$nStartRec = 0; // Start record index
$nStopRec = 0; // Stop record index
$nTotalRecs = 0; // Total number of records
$nDisplayRecs = 20;
$nRecRange = 10;
$nRecCount = 0; // Record count

// Search filters
$sSrchAdvanced = ""; // Advanced search filter
$sSrchBasic = ""; // Basic search filter
$sSrchWhere = ""; // Search where clause
$sFilter = "";

// Master/Detail
$sDbMasterFilter = ""; // Master filter
$sDbDetailFilter = ""; // Detail filter
$sSqlMaster = ""; // Sql for master record

// Handle reset command
ResetCmd();

// Get basic search criteria
$sSrchBasic = BasicSearchWhere();

// Build search criteria
if ($sSrchAdvanced <> "") {
	if ($sSrchWhere <> "") $sSrchWhere .= " AND ";
	$sSrchWhere .= "(" . $sSrchAdvanced . ")";
}
if ($sSrchBasic <> "") {
	if ($sSrchWhere <> "") $sSrchWhere .= " AND ";
	$sSrchWhere .= "(" . $sSrchBasic . ")";
}

// Save search criteria
if ($sSrchWhere <> "") {
	if ($sSrchBasic == "") ResetBasicSearchParms();
	$worth->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$worth->setStartRecordNumber($nStartRec);
} else {
	RestoreSearchParms();
}

// Build filter
$sFilter = "";
if ($sDbDetailFilter <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sDbDetailFilter . ")";
}
if ($sSrchWhere <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sSrchWhere . ")";
}

// Set up filter in Session
$worth->setSessionWhere($sFilter);
$worth->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($worth->Export == "xml" || $worth->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$worth->setReturnUrl("worthlist.php");
?>
<?php include "header.php" ?>
<?php if ($worth->Export == "") { ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "list"; // Page id

//-->
</script>
<script type="text/javascript">
<!--
var firstrowoffset = 1; // First data row start at
var lastrowoffset = 0; // Last data row end at
var EW_LIST_TABLE_NAME = 'ewlistmain'; // Table name for list page
var rowclass = 'ewTableRow'; // Row class
var rowaltclass = 'ewTableAltRow'; // Row alternate class
var rowmoverclass = 'ewTableHighlightRow'; // Row mouse over class
var rowselectedclass = 'ewTableSelectRow'; // Row selected class
var roweditclass = 'ewTableEditRow'; // Row edit class

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

function ew_SelectKey(elem) {
	var f = elem.form;	
	if (!f.elements["key_m[]"]) return;
	if (f.elements["key_m[]"][0]) {
		for (var i=0; i<f.elements["key_m[]"].length; i++)
			f.elements["key_m[]"][i].checked = elem.checked;	
	} else {
		f.elements["key_m[]"].checked = elem.checked;	
	}
	ew_ClickAll(elem);
}

function ew_Selected(f) {
	if (!f.elements["key_m[]"]) return false;
	if (f.elements["key_m[]"][0]) {
		for (var i=0; i<f.elements["key_m[]"].length; i++)
			if (f.elements["key_m[]"][i].checked) return true;
	} else {
		return f.elements["key_m[]"].checked;
	}
	return false;
}

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($worth->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $worth->Export <> "");
$bSelectLimit = ($worth->Export == "" && $worth->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $worth->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="EziScript" style="white-space: nowrap;">TABLE: Website info
<?php if ($worth->Export == "") { ?>
&nbsp;&nbsp;<a href="worthlist.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="worthlist.php?export=word">Export to Word</a>
&nbsp;&nbsp;<a href="worthlist.php?export=csv">Export to CSV</a>
<?php } ?>
</span></p>
<?php if ($worth->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<form name="fworthlistsrch" id="fworthlistsrch" action="worthlist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="EziScript">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($worth->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="worthlist.php?cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="EziScript"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($worth->getBasicSearchType() == "") { ?>checked<?php } ?>>Exact phrase&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($worth->getBasicSearchType() == "AND") { ?>checked<?php } ?>>All words&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($worth->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Any word</span></td>
	</tr>
</table>
</form>
<?php } ?>
<?php } ?>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<?php if ($worth->Export == "") { ?>
<form action="worthlist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<?php } ?>
<form method="post" name="fworthlist" id="fworthlist">
<?php if ($worth->Export == "") { ?>
<table>
	<tr><td><span class="EziScript">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="worthadd.php">Add</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fworthlist)) alert('No records selected'); else {document.fworthlist.action='worthdelete.php';document.fworthlist.encoding='application/x-www-form-urlencoded';document.fworthlist.submit();};return false;">Delete Selected Records</a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
	</span></td></tr>
</table>
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<table id="ewlistmain" class="ewTable">
<?php
	$OptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // copy
}
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // multi select
}
?>
	<!-- Table header -->
	<tr class="ewTableHeader">
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
id
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('id') ?>&ordertype=<?php echo $worth->id->ReverseSort() ?>">id<?php if ($worth->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
domain
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('domain') ?>&ordertype=<?php echo $worth->domain->ReverseSort() ?>">domain&nbsp;(*)<?php if ($worth->domain->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->domain->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
alexa
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('alexa') ?>&ordertype=<?php echo $worth->alexa->ReverseSort() ?>">alexa<?php if ($worth->alexa->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->alexa->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
country
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('country') ?>&ordertype=<?php echo $worth->country->ReverseSort() ?>">country&nbsp;(*)<?php if ($worth->country->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->country->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
datetime
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('datetime') ?>&ordertype=<?php echo $worth->datetime->ReverseSort() ?>">datetime&nbsp;(*)<?php if ($worth->datetime->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->datetime->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
worth
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('worth') ?>&ordertype=<?php echo $worth->worth->ReverseSort() ?>">worth<?php if ($worth->worth->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->worth->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
dearn
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('dearn') ?>&ordertype=<?php echo $worth->dearn->ReverseSort() ?>">dearn<?php if ($worth->dearn->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->dearn->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($worth->Export <> "") { ?>
dpview
<?php } else { ?>
	<a href="worthlist.php?order=<?php echo urlencode('dpview') ?>&ordertype=<?php echo $worth->dpview->ReverseSort() ?>">dpview<?php if ($worth->dpview->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($worth->dpview->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($worth->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><input type="checkbox" class="EziScript" onClick="ew_SelectKey(this);"></td>
<?php } ?>
<?php } ?>
	</tr>
<?php
if (defined("EW_EXPORT_ALL") && $worth->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$worth->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$worth->CssClass = "ewTableRow";
	$worth->CssStyle = "";

	// Init row event
	$worth->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$worth->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$worth->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $worth->DisplayAttributes() ?>>
		<!-- id -->
		<td<?php echo $worth->id->CellAttributes() ?>>
<div<?php echo $worth->id->ViewAttributes() ?>><?php echo $worth->id->ViewValue ?></div>
</td>
		<!-- domain -->
		<td<?php echo $worth->domain->CellAttributes() ?>>
<div<?php echo $worth->domain->ViewAttributes() ?>><?php echo $worth->domain->ViewValue ?></div>
</td>
		<!-- alexa -->
		<td<?php echo $worth->alexa->CellAttributes() ?>>
<div<?php echo $worth->alexa->ViewAttributes() ?>><?php echo $worth->alexa->ViewValue ?></div>
</td>
		<!-- country -->
		<td<?php echo $worth->country->CellAttributes() ?>>
<div<?php echo $worth->country->ViewAttributes() ?>><?php echo $worth->country->ViewValue ?></div>
</td>
		<!-- datetime -->
		<td<?php echo $worth->datetime->CellAttributes() ?>>
<div<?php echo $worth->datetime->ViewAttributes() ?>><?php echo $worth->datetime->ViewValue ?></div>
</td>
		<!-- worth -->
		<td<?php echo $worth->worth->CellAttributes() ?>>
<div<?php echo $worth->worth->ViewAttributes() ?>><?php echo $worth->worth->ViewValue ?></div>
</td>
		<!-- dearn -->
		<td<?php echo $worth->dearn->CellAttributes() ?>>
<div<?php echo $worth->dearn->ViewAttributes() ?>><?php echo $worth->dearn->ViewValue ?></div>
</td>
		<!-- dpview -->
		<td<?php echo $worth->dpview->CellAttributes() ?>>
<div<?php echo $worth->dpview->ViewAttributes() ?>><?php echo $worth->dpview->ViewValue ?></div>
</td>
<?php if ($worth->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="EziScript">
<a href="<?php echo $worth->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="EziScript">
<a href="<?php echo $worth->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="EziScript">
<a href="<?php echo $worth->CopyUrl() ?>">Copy</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="EziScript">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($worth->id->CurrentValue) ?>" class="EziScript" onclick='ew_ClickMultiCheckbox(this);'>
</span></td>
<?php } ?>
<?php } ?>
	</tr>
<?php
	}
	$rs->MoveNext();
}
?>
</table>
<?php if ($worth->Export == "") { ?>
<table>
	<tr><td><span class="EziScript">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="worthadd.php">Add</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fworthlist)) alert('No records selected'); else {document.fworthlist.action='worthdelete.php';document.fworthlist.encoding='application/x-www-form-urlencoded';document.fworthlist.submit();};return false;">Delete Selected Records</a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
	</span></td></tr>
</table>
<?php } ?>
<?php } ?>
</form>
<?php

// Close recordset and connection
if ($rs) $rs->Close();
?>
<?php if ($worth->Export == "") { ?>
<form action="worthlist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="EziScript">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="worthlist.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<?php } ?>
<?php if ($worth->Export == "") { ?>
<?php } ?>
<?php if ($worth->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
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

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`domain` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`google_back` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`yahoo_back` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`altavista_back` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`alltheweb_back` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`ip` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`pagerank` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`country` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`title` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`age` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`dmoz` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`yahoodir` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`inbound` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`outbound` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`loadtime` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`datetime` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`keyword` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`description` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $worth;
	$sSearchStr = "";
	$sSearchKeyword = ew_StripSlashes(@$_GET[EW_TABLE_BASIC_SEARCH]);
	$sSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	if ($sSearchKeyword <> "") {
		$sSearch = trim($sSearchKeyword);
		if ($sSearchType <> "") {
			while (strpos($sSearch, "  ") !== FALSE)
				$sSearch = str_replace("  ", " ", $sSearch);
			$arKeyword = explode(" ", trim($sSearch));
			foreach ($arKeyword as $sKeyword) {
				if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
				$sSearchStr .= "(" . BasicSearchSQL($sKeyword) . ")";
			}
		} else {
			$sSearchStr = BasicSearchSQL($sSearch);
		}
	}
	if ($sSearchKeyword <> "") {
		$worth->setBasicSearchKeyword($sSearchKeyword);
		$worth->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $worth;
	$sSrchWhere = "";
	$worth->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $worth;
	$worth->setBasicSearchKeyword("");
	$worth->setBasicSearchType("");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $worth;
	$sSrchWhere = $worth->getSearchWhere();
}

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $worth;

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$worth->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$worth->CurrentOrderType = @$_GET["ordertype"];

		// Field id
		$worth->UpdateSort($worth->id);

		// Field domain
		$worth->UpdateSort($worth->domain);

		// Field alexa
		$worth->UpdateSort($worth->alexa);

		// Field country
		$worth->UpdateSort($worth->country);

		// Field datetime
		$worth->UpdateSort($worth->datetime);

		// Field worth
		$worth->UpdateSort($worth->worth);

		// Field dearn
		$worth->UpdateSort($worth->dearn);

		// Field dpview
		$worth->UpdateSort($worth->dpview);
		$worth->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $worth->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($worth->SqlOrderBy() <> "") {
			$sOrderBy = $worth->SqlOrderBy();
			$worth->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $worth;

	// Get reset cmd
	if (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];

		// Reset search criteria
		if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall") {
			ResetSearchParms();
		}

		// Reset Sort Criteria
		if (strtolower($sCmd) == "resetsort") {
			$sOrderBy = "";
			$worth->setSessionOrderBy($sOrderBy);
			$worth->id->setSort("");
			$worth->domain->setSort("");
			$worth->alexa->setSort("");
			$worth->country->setSort("");
			$worth->datetime->setSort("");
			$worth->worth->setSort("");
			$worth->dearn->setSort("");
			$worth->dpview->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$worth->setStartRecordNumber($nStartRec);
	}
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

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $worth;
	$sCsvStr = "";
	$rs = LoadRecordset();
	$nTotalRecs = $rs->RecordCount();
	$nStartRec = 1;

	// Export all
	if (defined("EW_EXPORT_ALL")) {
		$nStopRec = $nTotalRecs;
	} else { // Export 1 page only
		SetUpStartRec(); // Set Up Start Record Position

		// Set the last record to display
		if ($nDisplayRecs < 0) {
			$nStopRec = $nTotalRecs;
		} else {
			$nStopRec = $nStartRec + $nDisplayRecs - 1;
		}
	}
	if ($worth->Export == "csv") {
		$sCsvStr .= "id" . ",";
		$sCsvStr .= "domain" . ",";
		$sCsvStr .= "alexa" . ",";
		$sCsvStr .= "country" . ",";
		$sCsvStr .= "datetime" . ",";
		$sCsvStr .= "worth" . ",";
		$sCsvStr .= "dearn" . ",";
		$sCsvStr .= "dpview" . ",";
		$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
		$sCsvStr .= "\n";
	}

	// Move to first record directly for performance reason
	$nRecCount = $nStartRec - 1;
	if (!$rs->EOF) {
		$rs->MoveFirst();
		$rs->Move($nStartRec - 1);
	}
	while (!$rs->EOF && $nRecCount < $nStopRec) {
		$nRecCount++;
		if (intval($nRecCount) >= intval($nStartRec)) {
			LoadRowValues($rs);
			if ($worth->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->id->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->domain->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->alexa->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->country->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->datetime->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->worth->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->dearn->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($worth->dpview->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($worth->Export == "csv") {
		echo $sCsvStr;
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
