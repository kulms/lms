<? 
session_start();
$session_id = session_id();
require("../../include/global_login.php");
include('htmltool/config.php');

$check=mysql_query("SELECT c.name,c.info,c.fullname,c.section from wp,courses c  
															  WHERE	wp.courses=$courses AND wp.users=".$person["id"]." AND c.id=wp.courses;");

					if(mysql_num_rows($check)==0){
						echo "YOU DO NOT HAVE ACCESS TO THIS COURSE!!!!!";
						exit();
					}


$a = 'index';

$a = $_GET['a'];
	
	if ($a == '')
	{
		$a = 'index';
		require ("news.php");
		
	}else{
			require ($a.".php");
	}
	
	
	

	
	
	
	


?>