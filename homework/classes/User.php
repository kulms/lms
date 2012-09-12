<?php
require_once 'Utils.php';

// Message No Constants
define( 'UI_MSG_OK', 1 );
define( 'UI_MSG_ALERT', 2 );
define( 'UI_MSG_WARNING', 3 );
define( 'UI_MSG_ERROR', 4 );

// global variable holding the translation array
$GLOBALS['translate'] = array();

define( "UI_CASE_UPPER", 1 );
define( "UI_CASE_LOWER", 2 );
define( "UI_CASE_UPPERFIRST", 3 );

class User {

	// user id
	var $userId;
	
	// first name
	var $fname;

	// last name
	var $lname;

	// user  login
	var $login;

	// password
	var $password;

	// email
	var $email;
	
	//active
	var $active;
	
	// category
	var $category;

	function User($userId, $login, $password, $fname, $lname, $email, $category) {
		$this->userId = $userId;
		$this->login = $login;
		$this->password = $password;
		$this->fname = $fname;
		$this->lname = $lname;
		$this->email = $email;
		$this->category = $category;
	}

	function getUserId() {
		return $this->userId;
	}

	function getFirstName() {
		return $this->fname;
	}

	function setFirstName($name) {
		 $this->fname = $name;
	}

	function getLastName() {
		return $this->lname;
	}

	function getLogin() {
		return $this->login;
	}

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return $this->password;
	}
	
	function getCategory() {
		return $this->category;
	}

	function checkPassword($password) {
		if (strcmp($this->password, $password) == 0) {			
			return true;
		} else {		
			return false;
		}
	}
	
	function getModuleClass( $path=null, $name=null ) {
		if ($name) {			
			return "$path/dms/modules/$name/$name.class.php";			
		}
	}
	
	function _( $str, $case=0 ) {
		$str = trim($str);
		if (empty( $str )) {
			return '';
		}
		/*
		$x = @$GLOBALS['translate'][$str];
		if ($x) {
			$str = $x;
		} else if (@$this->cfg['locale_warn']) {
			if ($this->base_locale != $this->user_locale ||
				($this->base_locale == $this->user_locale && !in_array( $str, @$GLOBALS['translate'] )) ) {
				$str .= @$this->cfg['locale_alert'];
			}
		}
		*/
		switch ($case) {
			case UI_CASE_UPPER:
				$str = strtoupper( $str );
				break;
			case UI_CASE_LOWER:
				$str = strtolower( $str );
				break;
			case UI_CASE_UPPERFIRST:
				break;
		}
		return $str;
	}
	
}

?>