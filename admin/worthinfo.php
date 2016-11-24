<?php

// EziScript configuration for Table worth
$worth = new cworth; // Initialize table object

// Define table class
class cworth {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $id;
	var $domain;
	var $alexa;
	var $google_back;
	var $yahoo_back;
	var $altavista_back;
	var $alltheweb_back;
	var $ip;
	var $pagerank;
	var $country;
	var $title;
	var $age;
	var $dmoz;
	var $yahoodir;
	var $inbound;
	var $outbound;
	var $loadtime;
	var $datetime;
	var $worth;
	var $dearn;
	var $dpview;
	var $keyword;
	var $description;
	var $fields = array();

	function cworth() {
		$this->TableVar = "worth";
		$this->TableName = "worth";
		$this->SelectLimit = TRUE;
		$this->id = new cField('worth', 'x_id', 'id', "`id`", 3, -1, FALSE);
		$this->fields['id'] =& $this->id;
		$this->domain = new cField('worth', 'x_domain', 'domain', "`domain`", 200, -1, FALSE);
		$this->fields['domain'] =& $this->domain;
		$this->alexa = new cField('worth', 'x_alexa', 'alexa', "`alexa`", 3, -1, FALSE);
		$this->fields['alexa'] =& $this->alexa;
		$this->google_back = new cField('worth', 'x_google_back', 'google_back', "`google_back`", 200, -1, FALSE);
		$this->fields['google_back'] =& $this->google_back;
		$this->yahoo_back = new cField('worth', 'x_yahoo_back', 'yahoo_back', "`yahoo_back`", 200, -1, FALSE);
		$this->fields['yahoo_back'] =& $this->yahoo_back;
		$this->altavista_back = new cField('worth', 'x_altavista_back', 'altavista_back', "`altavista_back`", 200, -1, FALSE);
		$this->fields['altavista_back'] =& $this->altavista_back;
		$this->alltheweb_back = new cField('worth', 'x_alltheweb_back', 'alltheweb_back', "`alltheweb_back`", 200, -1, FALSE);
		$this->fields['alltheweb_back'] =& $this->alltheweb_back;
		$this->ip = new cField('worth', 'x_ip', 'ip', "`ip`", 200, -1, FALSE);
		$this->fields['ip'] =& $this->ip;
		$this->pagerank = new cField('worth', 'x_pagerank', 'pagerank', "`pagerank`", 201, -1, FALSE);
		$this->fields['pagerank'] =& $this->pagerank;
		$this->country = new cField('worth', 'x_country', 'country', "`country`", 200, -1, FALSE);
		$this->fields['country'] =& $this->country;
		$this->title = new cField('worth', 'x_title', 'title', "`title`", 201, -1, FALSE);
		$this->fields['title'] =& $this->title;
		$this->age = new cField('worth', 'x_age', 'age', "`age`", 201, -1, FALSE);
		$this->fields['age'] =& $this->age;
		$this->dmoz = new cField('worth', 'x_dmoz', 'dmoz', "`dmoz`", 201, -1, FALSE);
		$this->fields['dmoz'] =& $this->dmoz;
		$this->yahoodir = new cField('worth', 'x_yahoodir', 'yahoodir', "`yahoodir`", 201, -1, FALSE);
		$this->fields['yahoodir'] =& $this->yahoodir;
		$this->inbound = new cField('worth', 'x_inbound', 'inbound', "`inbound`", 201, -1, FALSE);
		$this->fields['inbound'] =& $this->inbound;
		$this->outbound = new cField('worth', 'x_outbound', 'outbound', "`outbound`", 201, -1, FALSE);
		$this->fields['outbound'] =& $this->outbound;
		$this->loadtime = new cField('worth', 'x_loadtime', 'loadtime', "`loadtime`", 201, -1, FALSE);
		$this->fields['loadtime'] =& $this->loadtime;
		$this->datetime = new cField('worth', 'x_datetime', 'datetime', "`datetime`", 200, -1, FALSE);
		$this->fields['datetime'] =& $this->datetime;
		$this->worth = new cField('worth', 'x_worth', 'worth', "`worth`", 3, -1, FALSE);
		$this->fields['worth'] =& $this->worth;
		$this->dearn = new cField('worth', 'x_dearn', 'dearn', "`dearn`", 3, -1, FALSE);
		$this->fields['dearn'] =& $this->dearn;
		$this->dpview = new cField('worth', 'x_dpview', 'dpview', "`dpview`", 3, -1, FALSE);
		$this->fields['dpview'] =& $this->dpview;
		$this->keyword = new cField('worth', 'x_keyword', 'keyword', "`keyword`", 201, -1, FALSE);
		$this->fields['keyword'] =& $this->keyword;
		$this->description = new cField('worth', 'x_description', 'description', "`description`", 201, -1, FALSE);
		$this->fields['description'] =& $this->description;
	}

	// Records per page
	function getRecordsPerPage() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE];
	}

	function setRecordsPerPage($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	function getStartRecordNumber() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC];
	}

	function setStartRecordNumber($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC] = $v;
	}

	// Advanced search
	function getAdvancedSearch($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld];
	}

	function setAdvancedSearch($fld, $v) {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] <> $v) {
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] = $v;
		}
	}

	// Basic search Keyword
	function getBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic Search Type
	function getBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search where clause
	function getSearchWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE];
	}

	function setSearchWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE] = $v;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session WHERE Clause
	function getSessionWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE];
	}

	function setSessionWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	function getSessionOrderBy() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY];
	}

	function setSessionOrderBy($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY] = $v;
	}

	// Session Key
	function getKey($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld];
	}

	function setKey($fld, $v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld] = $v;
	}

	// Table level SQL
	function SqlSelect() { // Select
		return "SELECT * FROM `worth`";
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Report table sql
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return table sql with list page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		if ($this->CurrentFilter <> "") {
			if ($sFilter <> "") $sFilter .= " AND ";
			$sFilter .= $this->CurrentFilter;
		}
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return record count
	function SelectRecordCount() {
		global $conn;
		$cnt = -1;
		$sFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		if ($this->SelectLimit) {
			$sSelect = $this->SelectSQL();
			if (strtoupper(substr($sSelect, 0, 13)) == "SELECT * FROM") {
				$sSelect = "SELECT COUNT(*) FROM" . substr($sSelect, 13);
				if ($rs = $conn->Execute($sSelect)) {
					if (!$rs->EOF) $cnt = $rs->fields[0];
					$rs->Close();
				}
			}
		}
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $sFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= (is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO `worth` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `worth` SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=" .
					(is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
		$SQL = "DELETE FROM `worth` WHERE ";
		$SQL .= EW_DB_QUOTE_START . 'id' . EW_DB_QUOTE_END . '=' .	ew_QuotedValue($rs['id'], $this->id->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Return url
	function getReturnUrl() {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "worthlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("worthview.php");
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("worthedit.php");
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl("worthlist.php", "a=edit");
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("worthadd.php");
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl("worthlist.php", "a=copy");
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("worthdelete.php");
	}

	// Key url
	function KeyUrl($url, $action = "") {
		$sUrl = $url . "?";
		if ($action <> "") $sUrl .= $action . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:alert('Invalid Record! Key is null');";
		}
		return $sUrl;
	}

	// Function LoadRs
	// - Load Row based on Key Value
	function LoadRs($sFilter) {
		global $conn;

		// Set up filter (Sql Where Clause) and get Return Sql
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		return $conn->Execute($sSql);
	}

	// Load row values from rs
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->domain->setDbValue($rs->fields('domain'));
		$this->alexa->setDbValue($rs->fields('alexa'));
		$this->google_back->setDbValue($rs->fields('google_back'));
		$this->yahoo_back->setDbValue($rs->fields('yahoo_back'));
		$this->altavista_back->setDbValue($rs->fields('altavista_back'));
		$this->alltheweb_back->setDbValue($rs->fields('alltheweb_back'));
		$this->ip->setDbValue($rs->fields('ip'));
		$this->pagerank->setDbValue($rs->fields('pagerank'));
		$this->country->setDbValue($rs->fields('country'));
		$this->title->setDbValue($rs->fields('title'));
		$this->age->setDbValue($rs->fields('age'));
		$this->dmoz->setDbValue($rs->fields('dmoz'));
		$this->yahoodir->setDbValue($rs->fields('yahoodir'));
		$this->inbound->setDbValue($rs->fields('inbound'));
		$this->outbound->setDbValue($rs->fields('outbound'));
		$this->loadtime->setDbValue($rs->fields('loadtime'));
		$this->datetime->setDbValue($rs->fields('datetime'));
		$this->worth->setDbValue($rs->fields('worth'));
		$this->dearn->setDbValue($rs->fields('dearn'));
		$this->dpview->setDbValue($rs->fields('dpview'));
		$this->keyword->setDbValue($rs->fields('keyword'));
		$this->description->setDbValue($rs->fields('description'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->CssStyle = "";
		$this->id->CssClass = "";
		$this->id->ViewCustomAttributes = "";

		// domain
		$this->domain->ViewValue = $this->domain->CurrentValue;
		$this->domain->CssStyle = "";
		$this->domain->CssClass = "";
		$this->domain->ViewCustomAttributes = "";

		// alexa
		$this->alexa->ViewValue = $this->alexa->CurrentValue;
		$this->alexa->CssStyle = "";
		$this->alexa->CssClass = "";
		$this->alexa->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->CssStyle = "";
		$this->country->CssClass = "";
		$this->country->ViewCustomAttributes = "";

		// datetime
		$this->datetime->ViewValue = $this->datetime->CurrentValue;
		$this->datetime->CssStyle = "";
		$this->datetime->CssClass = "";
		$this->datetime->ViewCustomAttributes = "";

		// worth
		$this->worth->ViewValue = $this->worth->CurrentValue;
		$this->worth->CssStyle = "";
		$this->worth->CssClass = "";
		$this->worth->ViewCustomAttributes = "";

		// dearn
		$this->dearn->ViewValue = $this->dearn->CurrentValue;
		$this->dearn->CssStyle = "";
		$this->dearn->CssClass = "";
		$this->dearn->ViewCustomAttributes = "";

		// dpview
		$this->dpview->ViewValue = $this->dpview->CurrentValue;
		$this->dpview->CssStyle = "";
		$this->dpview->CssClass = "";
		$this->dpview->ViewCustomAttributes = "";

		// id
		$this->id->HrefValue = "";

		// domain
		$this->domain->HrefValue = "";

		// alexa
		$this->alexa->HrefValue = "";

		// country
		$this->country->HrefValue = "";

		// datetime
		$this->datetime->HrefValue = "";

		// worth
		$this->worth->HrefValue = "";

		// dearn
		$this->dearn->HrefValue = "";

		// dpview
		$this->dpview->HrefValue = "";
	}
	var $CurrentAction; // Current action
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message
	var $RowType; // Row Type
	var $CssClass; // Css class
	var $CssStyle; // Css style
	var $RowClientEvents; // Row client events

	// Display Attribute
	function DisplayAttributes() {
		$sAtt = "";
		if (trim($this->CssStyle) <> "") {
			$sAtt .= " style=\"" . trim($this->CssStyle) . "\"";
		}
		if (trim($this->CssClass) <> "") {
			$sAtt .= " class=\"" . trim($this->CssClass) . "\"";
		}
		if ($this->Export == "") {
			if (trim($this->RowClientEvents) <> "") {
				$sAtt .= " " . $this->RowClientEvents;
			}
		}
		return $sAtt;
	}

	// Export
	var $Export;

//	 ----------------
//	  Field objects
//	 ----------------
	function fields($fldname) {
		return $this->fields[$fldname];
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Row Inserting event
	function Row_Inserting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted(&$rs) {

		//echo "Row Inserted";
	}

	// Row Updating event
	function Row_Updating(&$rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Updated event
	function Row_Updated(&$rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Deleting event
	function Row_Deleting($rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}
}
?>
