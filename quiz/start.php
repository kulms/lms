<? 
require("../include/global_login.php");
require("classes/quiz.class.php");
require("classes/config.inc.php");
require("classes/template.class.php");
if($id != ""){
	$modules=$id;
}
$quiz=new Quiz('',$modules,$courses);
$sql=mysql_query("SELECT admin FROM wp WHERE users=".$person["id"]." AND courses=".$quiz->getCourses()." AND modules=".$quiz->getModules()."");
@$admin =  mysql_result($sql,0,"admin");
$m = $_GET['m'];
$u = $_GET['u'];
$a = $_GET['a'];

if($a=="" && $m==""){
	if($admin ==1){
		$m='admin';
		$a='index';
		require ("./modules/$m/" .$a. ".php");
	}
	else{
		$m='users';
		$a='index';
		require ("./modules/$m/" .$a. ".php");
	}
}else
		require ("./modules/$m/" .$a. ".php");
?>