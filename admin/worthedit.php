<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
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

// Load key from QueryString
if (@$_GET["id"] <> "") {
	$worth->id->setQueryStringValue($_GET["id"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$worth->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$worth->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($worth->id->CurrentValue == "") Page_Terminate($worth->getReturnUrl()); // Invalid key, exit
switch ($worth->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
			Page_Terminate($worth->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$worth->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Update successful"; // Update success
			Page_Terminate($worth->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$worth->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
		elm = fobj.elements["x" + infix + "_domain"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - domain"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_alexa"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - alexa"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_alexa"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Incorrect integer - alexa"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_google_back"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - google back"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_yahoo_back"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - yahoo back"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_altavista_back"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - altavista back"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_alltheweb_back"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - alltheweb back"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_ip"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - ip"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_pagerank"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - pagerank"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_country"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - country"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_title"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - title"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_age"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - age"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_dmoz"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - dmoz"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_yahoodir"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - yahoodir"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_inbound"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - inbound"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_outbound"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - outbound"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_loadtime"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - loadtime"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_datetime"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - datetime"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_worth"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - worth"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_worth"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Incorrect integer - worth"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_dearn"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - dearn"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_dearn"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Incorrect integer - dearn"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_dpview"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - dpview"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_dpview"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Incorrect integer - dpview"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_keyword"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - keyword"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_description"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - description"))
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
<p><span class="EziScript">Edit TABLE: Website info<br><br><a href="<?php echo $worth->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fworthedit" id="fworthedit" action="worthedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">id</td>
		<td<?php echo $worth->id->CellAttributes() ?>><span id="cb_x_id">
<div<?php echo $worth->id->ViewAttributes() ?>><?php echo $worth->id->EditValue ?></div>
<input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($worth->id->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">domain<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->domain->CellAttributes() ?>><span id="cb_x_domain">
<input type="text" name="x_domain" id="x_domain"  size="30" maxlength="255" value="<?php echo $worth->domain->EditValue ?>"<?php echo $worth->domain->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">alexa<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->alexa->CellAttributes() ?>><span id="cb_x_alexa">
<input type="text" name="x_alexa" id="x_alexa"  size="30" value="<?php echo $worth->alexa->EditValue ?>"<?php echo $worth->alexa->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">google back<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->google_back->CellAttributes() ?>><span id="cb_x_google_back">
<input type="text" name="x_google_back" id="x_google_back"  size="30" maxlength="20" value="<?php echo $worth->google_back->EditValue ?>"<?php echo $worth->google_back->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">yahoo back<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->yahoo_back->CellAttributes() ?>><span id="cb_x_yahoo_back">
<input type="text" name="x_yahoo_back" id="x_yahoo_back"  size="30" maxlength="20" value="<?php echo $worth->yahoo_back->EditValue ?>"<?php echo $worth->yahoo_back->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">altavista back<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->altavista_back->CellAttributes() ?>><span id="cb_x_altavista_back">
<input type="text" name="x_altavista_back" id="x_altavista_back"  size="30" maxlength="20" value="<?php echo $worth->altavista_back->EditValue ?>"<?php echo $worth->altavista_back->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">alltheweb back<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->alltheweb_back->CellAttributes() ?>><span id="cb_x_alltheweb_back">
<input type="text" name="x_alltheweb_back" id="x_alltheweb_back"  size="30" maxlength="20" value="<?php echo $worth->alltheweb_back->EditValue ?>"<?php echo $worth->alltheweb_back->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">ip<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->ip->CellAttributes() ?>><span id="cb_x_ip">
<input type="text" name="x_ip" id="x_ip"  size="30" maxlength="250" value="<?php echo $worth->ip->EditValue ?>"<?php echo $worth->ip->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">pagerank<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->pagerank->CellAttributes() ?>><span id="cb_x_pagerank">
<textarea name="x_pagerank" id="x_pagerank" cols="35" rows="4"<?php echo $worth->pagerank->EditAttributes() ?>><?php echo $worth->pagerank->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">country<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->country->CellAttributes() ?>><span id="cb_x_country">
<input type="text" name="x_country" id="x_country"  size="30" maxlength="250" value="<?php echo $worth->country->EditValue ?>"<?php echo $worth->country->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">title<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->title->CellAttributes() ?>><span id="cb_x_title">
<textarea name="x_title" id="x_title" cols="35" rows="4"<?php echo $worth->title->EditAttributes() ?>><?php echo $worth->title->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">age<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->age->CellAttributes() ?>><span id="cb_x_age">
<textarea name="x_age" id="x_age" cols="35" rows="4"<?php echo $worth->age->EditAttributes() ?>><?php echo $worth->age->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">dmoz<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->dmoz->CellAttributes() ?>><span id="cb_x_dmoz">
<textarea name="x_dmoz" id="x_dmoz" cols="35" rows="4"<?php echo $worth->dmoz->EditAttributes() ?>><?php echo $worth->dmoz->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">yahoodir<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->yahoodir->CellAttributes() ?>><span id="cb_x_yahoodir">
<textarea name="x_yahoodir" id="x_yahoodir" cols="35" rows="4"<?php echo $worth->yahoodir->EditAttributes() ?>><?php echo $worth->yahoodir->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">inbound<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->inbound->CellAttributes() ?>><span id="cb_x_inbound">
<textarea name="x_inbound" id="x_inbound" cols="35" rows="4"<?php echo $worth->inbound->EditAttributes() ?>><?php echo $worth->inbound->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">outbound<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->outbound->CellAttributes() ?>><span id="cb_x_outbound">
<textarea name="x_outbound" id="x_outbound" cols="35" rows="4"<?php echo $worth->outbound->EditAttributes() ?>><?php echo $worth->outbound->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">loadtime<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->loadtime->CellAttributes() ?>><span id="cb_x_loadtime">
<textarea name="x_loadtime" id="x_loadtime" cols="35" rows="4"<?php echo $worth->loadtime->EditAttributes() ?>><?php echo $worth->loadtime->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">datetime<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->datetime->CellAttributes() ?>><span id="cb_x_datetime">
<input type="text" name="x_datetime" id="x_datetime"  size="30" maxlength="10" value="<?php echo $worth->datetime->EditValue ?>"<?php echo $worth->datetime->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">worth<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->worth->CellAttributes() ?>><span id="cb_x_worth">
<input type="text" name="x_worth" id="x_worth"  size="30" value="<?php echo $worth->worth->EditValue ?>"<?php echo $worth->worth->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">dearn<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->dearn->CellAttributes() ?>><span id="cb_x_dearn">
<input type="text" name="x_dearn" id="x_dearn"  size="30" value="<?php echo $worth->dearn->EditValue ?>"<?php echo $worth->dearn->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">dpview<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->dpview->CellAttributes() ?>><span id="cb_x_dpview">
<input type="text" name="x_dpview" id="x_dpview"  size="30" value="<?php echo $worth->dpview->EditValue ?>"<?php echo $worth->dpview->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">keyword<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->keyword->CellAttributes() ?>><span id="cb_x_keyword">
<textarea name="x_keyword" id="x_keyword" cols="35" rows="4"<?php echo $worth->keyword->EditAttributes() ?>><?php echo $worth->keyword->EditValue ?></textarea>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">description<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $worth->description->CellAttributes() ?>><span id="cb_x_description">
<textarea name="x_description" id="x_description" cols="35" rows="4"<?php echo $worth->description->EditAttributes() ?>><?php echo $worth->description->EditValue ?></textarea>
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
	global $objForm, $worth;
	$worth->id->setFormValue($objForm->GetValue("x_id"));
	$worth->domain->setFormValue($objForm->GetValue("x_domain"));
	$worth->alexa->setFormValue($objForm->GetValue("x_alexa"));
	$worth->google_back->setFormValue($objForm->GetValue("x_google_back"));
	$worth->yahoo_back->setFormValue($objForm->GetValue("x_yahoo_back"));
	$worth->altavista_back->setFormValue($objForm->GetValue("x_altavista_back"));
	$worth->alltheweb_back->setFormValue($objForm->GetValue("x_alltheweb_back"));
	$worth->ip->setFormValue($objForm->GetValue("x_ip"));
	$worth->pagerank->setFormValue($objForm->GetValue("x_pagerank"));
	$worth->country->setFormValue($objForm->GetValue("x_country"));
	$worth->title->setFormValue($objForm->GetValue("x_title"));
	$worth->age->setFormValue($objForm->GetValue("x_age"));
	$worth->dmoz->setFormValue($objForm->GetValue("x_dmoz"));
	$worth->yahoodir->setFormValue($objForm->GetValue("x_yahoodir"));
	$worth->inbound->setFormValue($objForm->GetValue("x_inbound"));
	$worth->outbound->setFormValue($objForm->GetValue("x_outbound"));
	$worth->loadtime->setFormValue($objForm->GetValue("x_loadtime"));
	$worth->datetime->setFormValue($objForm->GetValue("x_datetime"));
	$worth->worth->setFormValue($objForm->GetValue("x_worth"));
	$worth->dearn->setFormValue($objForm->GetValue("x_dearn"));
	$worth->dpview->setFormValue($objForm->GetValue("x_dpview"));
	$worth->keyword->setFormValue($objForm->GetValue("x_keyword"));
	$worth->description->setFormValue($objForm->GetValue("x_description"));
}

// Restore form values
function RestoreFormValues() {
	global $worth;
	$worth->id->CurrentValue = $worth->id->FormValue;
	$worth->domain->CurrentValue = $worth->domain->FormValue;
	$worth->alexa->CurrentValue = $worth->alexa->FormValue;
	$worth->google_back->CurrentValue = $worth->google_back->FormValue;
	$worth->yahoo_back->CurrentValue = $worth->yahoo_back->FormValue;
	$worth->altavista_back->CurrentValue = $worth->altavista_back->FormValue;
	$worth->alltheweb_back->CurrentValue = $worth->alltheweb_back->FormValue;
	$worth->ip->CurrentValue = $worth->ip->FormValue;
	$worth->pagerank->CurrentValue = $worth->pagerank->FormValue;
	$worth->country->CurrentValue = $worth->country->FormValue;
	$worth->title->CurrentValue = $worth->title->FormValue;
	$worth->age->CurrentValue = $worth->age->FormValue;
	$worth->dmoz->CurrentValue = $worth->dmoz->FormValue;
	$worth->yahoodir->CurrentValue = $worth->yahoodir->FormValue;
	$worth->inbound->CurrentValue = $worth->inbound->FormValue;
	$worth->outbound->CurrentValue = $worth->outbound->FormValue;
	$worth->loadtime->CurrentValue = $worth->loadtime->FormValue;
	$worth->datetime->CurrentValue = $worth->datetime->FormValue;
	$worth->worth->CurrentValue = $worth->worth->FormValue;
	$worth->dearn->CurrentValue = $worth->dearn->FormValue;
	$worth->dpview->CurrentValue = $worth->dpview->FormValue;
	$worth->keyword->CurrentValue = $worth->keyword->FormValue;
	$worth->description->CurrentValue = $worth->description->FormValue;
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
	} elseif ($worth->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($worth->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// id
		$worth->id->EditCustomAttributes = "";
		$worth->id->EditValue = $worth->id->CurrentValue;
		$worth->id->CssStyle = "";
		$worth->id->CssClass = "";
		$worth->id->ViewCustomAttributes = "";

		// domain
		$worth->domain->EditCustomAttributes = "";
		$worth->domain->EditValue = ew_HtmlEncode($worth->domain->CurrentValue);

		// alexa
		$worth->alexa->EditCustomAttributes = "";
		$worth->alexa->EditValue = ew_HtmlEncode($worth->alexa->CurrentValue);

		// google_back
		$worth->google_back->EditCustomAttributes = "";
		$worth->google_back->EditValue = ew_HtmlEncode($worth->google_back->CurrentValue);

		// yahoo_back
		$worth->yahoo_back->EditCustomAttributes = "";
		$worth->yahoo_back->EditValue = ew_HtmlEncode($worth->yahoo_back->CurrentValue);

		// altavista_back
		$worth->altavista_back->EditCustomAttributes = "";
		$worth->altavista_back->EditValue = ew_HtmlEncode($worth->altavista_back->CurrentValue);

		// alltheweb_back
		$worth->alltheweb_back->EditCustomAttributes = "";
		$worth->alltheweb_back->EditValue = ew_HtmlEncode($worth->alltheweb_back->CurrentValue);

		// ip
		$worth->ip->EditCustomAttributes = "";
		$worth->ip->EditValue = ew_HtmlEncode($worth->ip->CurrentValue);

		// pagerank
		$worth->pagerank->EditCustomAttributes = "";
		$worth->pagerank->EditValue = ew_HtmlEncode($worth->pagerank->CurrentValue);

		// country
		$worth->country->EditCustomAttributes = "";
		$worth->country->EditValue = ew_HtmlEncode($worth->country->CurrentValue);

		// title
		$worth->title->EditCustomAttributes = "";
		$worth->title->EditValue = ew_HtmlEncode($worth->title->CurrentValue);

		// age
		$worth->age->EditCustomAttributes = "";
		$worth->age->EditValue = ew_HtmlEncode($worth->age->CurrentValue);

		// dmoz
		$worth->dmoz->EditCustomAttributes = "";
		$worth->dmoz->EditValue = ew_HtmlEncode($worth->dmoz->CurrentValue);

		// yahoodir
		$worth->yahoodir->EditCustomAttributes = "";
		$worth->yahoodir->EditValue = ew_HtmlEncode($worth->yahoodir->CurrentValue);

		// inbound
		$worth->inbound->EditCustomAttributes = "";
		$worth->inbound->EditValue = ew_HtmlEncode($worth->inbound->CurrentValue);

		// outbound
		$worth->outbound->EditCustomAttributes = "";
		$worth->outbound->EditValue = ew_HtmlEncode($worth->outbound->CurrentValue);

		// loadtime
		$worth->loadtime->EditCustomAttributes = "";
		$worth->loadtime->EditValue = ew_HtmlEncode($worth->loadtime->CurrentValue);

		// datetime
		$worth->datetime->EditCustomAttributes = "";
		$worth->datetime->EditValue = ew_HtmlEncode($worth->datetime->CurrentValue);

		// worth
		$worth->worth->EditCustomAttributes = "";
		$worth->worth->EditValue = ew_HtmlEncode($worth->worth->CurrentValue);

		// dearn
		$worth->dearn->EditCustomAttributes = "";
		$worth->dearn->EditValue = ew_HtmlEncode($worth->dearn->CurrentValue);

		// dpview
		$worth->dpview->EditCustomAttributes = "";
		$worth->dpview->EditValue = ew_HtmlEncode($worth->dpview->CurrentValue);

		// keyword
		$worth->keyword->EditCustomAttributes = "";
		$worth->keyword->EditValue = ew_HtmlEncode($worth->keyword->CurrentValue);

		// description
		$worth->description->EditCustomAttributes = "";
		$worth->description->EditValue = ew_HtmlEncode($worth->description->CurrentValue);
	} elseif ($worth->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$worth->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $worth;
	$sFilter = $worth->SqlKeyFilter();
	if (!is_numeric($worth->id->CurrentValue)) {
		return FALSE;
	}
	$sFilter = str_replace("@id@", ew_AdjustSql($worth->id->CurrentValue), $sFilter); // Replace key value
	$worth->CurrentFilter = $sFilter;
	$sSql = $worth->SQL();
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
		// Field domain

		$worth->domain->SetDbValueDef($worth->domain->CurrentValue, "");
		$rsnew['domain'] =& $worth->domain->DbValue;

		// Field alexa
		$worth->alexa->SetDbValueDef($worth->alexa->CurrentValue, 0);
		$rsnew['alexa'] =& $worth->alexa->DbValue;

		// Field google_back
		$worth->google_back->SetDbValueDef($worth->google_back->CurrentValue, "");
		$rsnew['google_back'] =& $worth->google_back->DbValue;

		// Field yahoo_back
		$worth->yahoo_back->SetDbValueDef($worth->yahoo_back->CurrentValue, "");
		$rsnew['yahoo_back'] =& $worth->yahoo_back->DbValue;

		// Field altavista_back
		$worth->altavista_back->SetDbValueDef($worth->altavista_back->CurrentValue, "");
		$rsnew['altavista_back'] =& $worth->altavista_back->DbValue;

		// Field alltheweb_back
		$worth->alltheweb_back->SetDbValueDef($worth->alltheweb_back->CurrentValue, "");
		$rsnew['alltheweb_back'] =& $worth->alltheweb_back->DbValue;

		// Field ip
		$worth->ip->SetDbValueDef($worth->ip->CurrentValue, "");
		$rsnew['ip'] =& $worth->ip->DbValue;

		// Field pagerank
		$worth->pagerank->SetDbValueDef($worth->pagerank->CurrentValue, "");
		$rsnew['pagerank'] =& $worth->pagerank->DbValue;

		// Field country
		$worth->country->SetDbValueDef($worth->country->CurrentValue, "");
		$rsnew['country'] =& $worth->country->DbValue;

		// Field title
		$worth->title->SetDbValueDef($worth->title->CurrentValue, "");
		$rsnew['title'] =& $worth->title->DbValue;

		// Field age
		$worth->age->SetDbValueDef($worth->age->CurrentValue, "");
		$rsnew['age'] =& $worth->age->DbValue;

		// Field dmoz
		$worth->dmoz->SetDbValueDef($worth->dmoz->CurrentValue, "");
		$rsnew['dmoz'] =& $worth->dmoz->DbValue;

		// Field yahoodir
		$worth->yahoodir->SetDbValueDef($worth->yahoodir->CurrentValue, "");
		$rsnew['yahoodir'] =& $worth->yahoodir->DbValue;

		// Field inbound
		$worth->inbound->SetDbValueDef($worth->inbound->CurrentValue, "");
		$rsnew['inbound'] =& $worth->inbound->DbValue;

		// Field outbound
		$worth->outbound->SetDbValueDef($worth->outbound->CurrentValue, "");
		$rsnew['outbound'] =& $worth->outbound->DbValue;

		// Field loadtime
		$worth->loadtime->SetDbValueDef($worth->loadtime->CurrentValue, "");
		$rsnew['loadtime'] =& $worth->loadtime->DbValue;

		// Field datetime
		$worth->datetime->SetDbValueDef($worth->datetime->CurrentValue, "");
		$rsnew['datetime'] =& $worth->datetime->DbValue;

		// Field worth
		$worth->worth->SetDbValueDef($worth->worth->CurrentValue, 0);
		$rsnew['worth'] =& $worth->worth->DbValue;

		// Field dearn
		$worth->dearn->SetDbValueDef($worth->dearn->CurrentValue, 0);
		$rsnew['dearn'] =& $worth->dearn->DbValue;

		// Field dpview
		$worth->dpview->SetDbValueDef($worth->dpview->CurrentValue, 0);
		$rsnew['dpview'] =& $worth->dpview->DbValue;

		// Field keyword
		$worth->keyword->SetDbValueDef($worth->keyword->CurrentValue, "");
		$rsnew['keyword'] =& $worth->keyword->DbValue;

		// Field description
		$worth->description->SetDbValueDef($worth->description->CurrentValue, "");
		$rsnew['description'] =& $worth->description->DbValue;

		// Call Row Updating event
		$bUpdateRow = $worth->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($worth->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($worth->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $worth->CancelMessage;
				$worth->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Update cancelled";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$worth->Row_Updated($rsold, $rsnew);
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
