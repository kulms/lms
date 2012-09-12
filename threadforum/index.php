<? 
session_start();
$session_id = session_id();
require("../include/global_login.php");
require("../include/online.php");
require("../include/function.inc.php");
require("webboard.class.php");
if($refid=="")
	$refid=0;

$webboard=new Webboard('',0,'','','','',$person["id"],$id,$courses);
online_courses($session_id,$person["id"],$courses,time(),1);
mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");
$a = 'index';
$a = $_GET['a'];
	if ($a == '')
	{
		$a = 'index';
		$menu=1;
		require ("header.php");
		require ("main.php");
	}else{
		if($a=='search' || $a=='preferences')
			$menu=1;
		require ("header.php");
		require ($a.".php");
	}


?>
