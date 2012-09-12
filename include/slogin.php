<?php
	session_start();
	$session_id = session_id();

	require ("../config/config.inc.php");					

	$_SESSION['dbname']		= DB_NAME;
	$_SESSION['dbhost']		= DB_HOST;
	$_SESSION['dbuser']		= DB_USER;
	$_SESSION['dbpass']		= DB_PASSWORD;
	$_SESSION['dbtype']		= DB_TYPE;
	$_SESSION['dsn']		= DB_DSN;
	//$_SESSION['email_host'] = $email_host;
	$_SESSION['path']		= PATH;
	$_SESSION['realpath']	= REALPATH;
	$_SESSION['filepath']	= FILEPATH;
	//$_SESSION['title_name'] = $title_name;
	//$_SESSION['serverhost'] = $serverhost;

	mysql_connect($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpass']); 	
	mysql_select_db($_SESSION['dbname']);

	if($oldsystem=="1"){
		session_register("oldsystem");
		$check=mysql_query("SELECT * FROM users WHERE login='$slogin';");
	} else {
		/*	
		if ($smodules == "") {
			$check=mysql_query("SELECT * FROM users WHERE login='$slogin' AND password='$spassword' AND active=1;");
		} else {
			$check=mysql_query("SELECT * FROM users WHERE login='$slogin' AND active=1;");
		}
		*/
		if ($sipaddress == "") {
			if ($smodules == "") {
				$check=mysql_query("SELECT * FROM users WHERE login='$slogin' AND password='$spassword' AND active=1;");	
			} else {
				$check=mysql_query("SELECT * FROM users WHERE login='$slogin' AND active=1;");
			}			
		} else {
			$check=mysql_query("SELECT * FROM users WHERE login='$slogin' AND active=1;");
		}
		
	}
	// ####
		  // include 'regist_course.php';
		   include 'online.php';
	// ####
	if(mysql_num_rows($check)==0){
		header ("Location: ../login/ilogins.php?fail=1");
		exit;
	}else{
		if ($smodules == "") {	
			$person=mysql_fetch_array($check);
			mysql_query("UPDATE users set lastlogin=".time()." WHERE id=".$person["id"].";");
			Login($person["id"],$session_id);
			online($session_id,time(),$session_id,$person["category"],$person["id"]);
			session_register("slogin");
			session_register("spassword");	
			header("Location: ../index.php");
		} else {
			$person=mysql_fetch_array($check);
			mysql_query("UPDATE users set lastlogin=".time()." WHERE id=".$person["id"].";");
			Login($person["id"],$session_id);
                        online($session_id,time(),$session_id,$person["category"],$person["id"]);
			session_register("slogin");
			session_register("smodules");
			header("Location: ../dms/index.php?m=search");		
		}	
	}

?>
