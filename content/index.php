<?
session_start();
	    include("../include/global_login.php");
		include('include/config.inc.php');
// Teacher OR Admin
$_SESSION[course]= $courses;
$_SESSION[module_id] = $id;
session_register("course");
session_register("module_id");

$sql ="SELECT users
		FROM modules
		WHERE  id='$_SESSION[module_id]' ";
		$rs = mysql_query($sql);
		$arr= mysql_fetch_array($rs);
if($arr[users]==$person[id]){

		header("Location: t_index.php");
		
}else{

		header("Location: s_index.php");
		
}

?>