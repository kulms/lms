<?
session_start();
include("../include/global_login.php");
include("./include/var.inc.php");
require("include/eval.class.php");
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
		
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);
@list($e_name,$modules_id,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std) = $evaluate->getCosDetail($evaluate);
$y=substr($end_date,0,4);
$m=substr($end_date,5,2);
$d=substr($end_date,8,2);

$end =$y.$m.$d;
$today = date('Ymd');

if($arr[users]==$person[id]){
		if($eval_type==1)  header("Location: t_index.php");
		     else  header("Location: t_index2.php");
		
}else{
		if($end< $today){
				header("Location: deadline.php?eval_type=$eval_type");
		}else{
			  header("Location: s_index.php");
		}
}

?>