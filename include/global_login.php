<?php
session_start();
$session_id = session_id();

ini_set('include_path', '/data/httpd_course/html/pear');
// check if session has previously been initialised
ini_set('session.gc_maxlifetime',1800);
ini_set('session.gc_probability',1);
ini_set('session.gc_divisor',1);

if(isset($_SESSION["slogin"])){
		 $conn=mysql_pconnect($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpass']);		
		mysql_select_db($_SESSION['dbname']);
		$sql=("SELECT * FROM users WHERE login='".$_SESSION["slogin"]."' AND session_id='$session_id' AND active=1;");
		$check=mysql_query($sql);
	//	echo mysql_num_rows($check);

	        $person=mysql_fetch_array($check);


		if($person["language"]==0){
        	require($realpath."/lang/english.inc.php");
		} else {
			require($realpath."/lang/thai.inc.php");
		}

		$sql_theme=mysql_query("SELECT * FROM maxlearn_config;");
				
		$theme_style=mysql_fetch_array($sql_theme);
		
		$_SESSION['theme'] = $theme_style["default_theme"];
		$_SESSION['logo'] = $theme_style["site_logo"];
		$_SESSION['ssmsg'] = $theme_style["notify_Message"];
		$_SESSION['ssquiz'] = $theme_style["notify_Quiz"];
		$_SESSION['sscalendar'] = $theme_style["notify_Calendar"];
		$_SESSION['ssboard'] = $theme_style["notify_Webboard"];
		$_SESSION['sshomework'] = $theme_style["notify_Homework"];
		$_SESSION['sseval'] = $theme_style["notify_Evaluate"];
		
} else {
header("Location: https://".$_SERVER['HTTP_HOST']."/lms/include/session_timeout.php");
/*
<meta http-equiv="refresh" content="0;url=https://<?php echo $_SERVER["HTTP_HOST"];?>/lms/include/session_timeout.php">
*/
}
?>
