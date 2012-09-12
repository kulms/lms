<?php

require_once 'User.php';
require_once 'Utils.php';
//require_once 'UserSqlStmts.php';
require_once("DB.php");
require_once("../config/maxlearn_includes.php");

class UserStorage {

	function create($user) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}				 
		
	   $sql = "INSERT INTO users
			   (login , password, firstname , surname , email , category )
			   VALUES
			   ('".$user->getLogin()."', '".md5($user->getPassword())."', '".$user->getFirstName()."',
				'".$user->getLastName() ."','".$user->getEmail()."',".$user->getCategory().")";
				
		echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;	   	
		
	}

	function lookupbyId($login) {
		return UserStorage::lookupUser($login);
	}	

	function lookupUser($login) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT id, login, password, firstname, surname, email, category 
				FROM users WHERE login = '".$login."'";
		
		$result = $db->query($sql);

		$rs_user = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$user = UserStorage::createUserObject($rs_user);

		return $user;
	
	}

	function update($user) {
		
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "UPDATE users SET 
			   login = ".$user->getLogin().", 
			   password = ".md5($user->getPassword()).", 
			   firstname = ".$user->getFirstName().", 
			   lastname = ".$user->getLastName().", 
			   email = ".$user->getEmail().",
			   category = ".$user->getCategory()." 
			   WHERE id = ".$user->getUserId()."";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}

	function createUserObject($row) {			
		$id = $row['id'];
		$login = $row['login'];
		$password = $row['password'];
		$fname = $row['firstname'];
		$lname = $row['surname'];
		$email = $row['email'];
		$category = $row['category'];		
		$user =  new User($id, $login, $password, $fname, $lname, $email, $category);
		return $user;
	}

}


?>
