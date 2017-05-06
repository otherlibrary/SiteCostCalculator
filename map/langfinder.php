<?

class LangFinder {

	function find($iso) {
		include "config.php";
		$sql = "SELECT * FROM countries WHERE iso = '$iso' LIMIT 1";
		$rs_result = mysql_query ($sql);
		while ($row = mysql_fetch_assoc($rs_result)) {
			$googleLang = $row[google];
		}
		return $googleLang;
	}
	
	
	
}

?>