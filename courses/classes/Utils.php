<?php

require_once 'Common.php';

class Utils {

	
	function logErrorMessage($functionName, $message) {
		global $errorLogFile;
		$strValue = sprintf("%s: %s \n", $functionName, $message);
		error_log ($strValue, 3, $errorLogFile);
	}

	
	function createSuccessMessage($successMessage) {
		$retValue = "<font size=\"4\" >" . 
					$successMessage .	
					"<br><br></font>";
		return $retValue;
	}

	function createErrorMessage($errorMessage) {
		$retValue = "<font color=\"#ff0000\">" . 
					$errorMessage .	
					"<br><br></font>";
		return $retValue;

	}

	function createPostgresArray($oids) {
		if (($oids == null) || (sizeof($oids) == 0)) {
			return null;
		} else {
			$str = "{";
			for ($i=0; $i < sizeof($oids); $i++) {
				$str .= $oids[$i];
				if ($i != (sizeof($oids) -1)) {
					$str .= ", ";
				}
			}
			$str .= "}";
			return $str;
		}
		
	}

	function  parsePostgresArrayString($arrayStr) {
		if ($arrayStr == null) {
			return null;
		}
		$arrayStr = trim($arrayStr);
		$retValue = explode (",", substr($arrayStr, 1, strlen($arrayStr)-2));
		return $retValue;
	}

	// Return date string in year-month-day format
	function getDateString($noOfDays) {
		$timeOfDay = gettimeofday();
		
		$noOfSecs = $timeOfDay["sec"];
		$noOfSecs += $noOfDays*24*60*60;

		$date = getdate($noOfSecs); 
		$month = $date['mon']; 
		$mday = $date['mday']; 
		$year = $date['year'];

		return  $year . '-' . $month . '-' . $mday;
	}
	
	function removeFromArray($arrayIn, $value) {
		$retValue = array();
		for ($i=0; $i <sizeof($arrayIn); $i++) {
			if ($arrayIn[$i] != $value) {
				$retValue[] = $arrayIn[$i];
			}
		}
			
		return $retValue;
	}

}

?>