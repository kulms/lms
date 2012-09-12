<?
	require("../include/global_login.php");
	session_start();
	$session_id = session_id();
	require ("../include/global_login.php");
	require("../include/online.php");
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );		
	$user = UserStorage::lookupById($person["login"]);	
	session_register( 'user' ); 
			
	switch ($user->getCategory()) {
		case 0:
			$uistyle = "admin";
			break;
		case 1:
			$uistyle = "admin";
			break;
		case 2:
			$uistyle = "teacher";
			break;
		case 3:
			$uistyle = "student";	
			break;
		default:
			$uistyle = "guest";	
		}				
	
	$next=mysql_query("SELECT id,modules FROM homework WHERE modules=$modules ORDER BY id;");
	$hw_id=@mysql_result($next,$num,"id");
	
	
	$p=mysql_query("SELECT * FROM homework WHERE id=$hw_id ORDER BY id;");
	$points = @mysql_result($p,0,"points");		
	$name = @mysql_result($p,0,"name");
	
	//echo $name;
	

?>