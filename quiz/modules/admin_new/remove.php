<?require("../include/global_login.php");
include("../include/function.inc.php");
$quiz=new Quiz($qnr,$quiz->getModules(),$courses);
//Courses_id
$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$quiz->getModules().";");
$courses=mysql_result($courseid,0,"courses");

//check real or copy
$sql=mysql_query("SELECT makecopy FROM q_modules_questions  WHERE question_id =".$quiz->getQId()." AND  module_id =".$quiz->getModules()." ");
$check_makecopy=mysql_result($sql,0,'makecopy');    //1=copy,0=real,

//check use
$check_use=$quiz->CheckUse($quiz);    //1=use,0=not use

//check_copy
$sql=mysql_query("SELECT * FROM q_modules_questions WHERE module_id <> $modules AND question_id=$qnr AND makecopy =1 ");
$check_copy=mysql_num_rows($sql);    //1=copy,0=not copy

if($check_makecopy==0){  //real
	if($check_use==1)
		$remove=0;
	else{
		if($check_copy==0)
			$remove=1;
		else
			$remove=0;
	}
}else{
	if($check_use==1)
		$remove=0;
	else
		$remove=1;
}

//remove 1=remove 0=not remove
if($remove==1){
	//***********insert modules_history***************
		$action="Remove question";
		Imodules_h($modules,$action,$person["id"],$courses);
		mysql_query("DELETE FROM q_modules_questions WHERE question_id=$qnr AND module_id=".$quiz->getModules() ."");
?>
	 <html>
	<head>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?a=viewQuestion&m=admin&modules=<? echo $quiz->getModules()?>">
	</head>
	<body bgcolor="#ffffff">
	<p>&nbsp;</p>
	<div align="center" class="h3"><b>The question has been removed from your quiz...</b></div>
	</body>
	</html>
<? }else{?>
	<html>
	<head>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?a=viewQuestion&m=admin&modules=<? echo $quiz->getModules()?>">
	</head>
	<body bgcolor="#ffffff">
	<p>&nbsp;</p>
	<div align="center" class="h3"><b>Sorry...</b></div>
	<div align="center" class="main"><b>Couldn't delete this question due to the students are still testing..</b></div>
	</body>
	</html>
<? }?>