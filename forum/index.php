<? 
session_start();
$session_id = session_id();
require("../include/global_login.php");
require("../include/online.php");
include("../include/function.inc.php");
require("forum.class.php");


$a = 'index';
$a = $_GET['a'];
	if ($a == '')
	{
		$a = 'index';
		require ("main.php");
		
	}else{
			require ($a.".php");
	}


?>
