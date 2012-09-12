<?
/*
$db="maxlearn";
$path="course";
$realpath="F:/Workshop/course";
$conn=mysql_pconnect('localhost','root','');                                        //öppna databasen
mysql_select_db($db);
*/
require_once("../config/config.inc.php");
//$conn=mysql_pconnect($dbhost,$dbuser,$dbpass);
$conn=mysql_pconnect(DB_HOST,DB_USER,DB_PASSWORD);
		
//mysql_select_db($dbname);
mysql_select_db(DB_NAME);

session_start();
$sql_theme=mysql_query("SELECT default_theme FROM maxlearn_config;");
		
$theme_style=mysql_fetch_array($sql_theme);

$_SESSION['theme'] = $theme_style["default_theme"];
//header("Expires: Mon, 28 Aug 2000 05:00:00 GMT");
//header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
//header("Cache-Control: no-cache, must-revalidate");
//header("Pragma: no-cache");
?>
