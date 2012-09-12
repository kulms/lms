<?require("../include/global_login.php");
include("../include/function.inc.php");
$quiz=new Quiz($qnr,$modules,$courses);

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
		$delete=0;
	else{
		if($check_copy==0)
			$delete=1;
		else
			$delete=0;
	}
}else{   //copy
	if($check_use==1)
		$delete=0;
	else
		$delete=2;
}


switch($delete) {
	case "0" :
		echo "<html>
					<head>
						<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">
						<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=?a=viewQuestion&m=admin&modules= $modules\">
					</head>
					<body bgcolor=\"#ffffff\">
					<p>&nbsp;</p>
						<div align=\"center\" class=\"h3\"><b>Sorry...</b></div>
						<div align=\"center\" class=\"main\"><b>Couldn't delete this question due to the students are still testing..</b></div>
					</body>
					</html> ";
	break;
	case "1":
		mysql_query("DELETE FROM q_modules_questions WHERE question_id=".$quiz->getQId()."");
		mysql_query("DELETE FROM q_questions WHERE question_id=".$quiz->getQId()."");
		mysql_query("DELETE FROM q_answers WHERE question_id=".$quiz->getQId()."");
		
		//delete question_type=mcit
		mysql_query("DELETE FROM q_answer_mcit WHERE question_id=".$quiz->getQId().""); 
		mysql_query("DELETE FROM q_question_mcit WHERE question_id=".$quiz->getQId().""); 

		//***********insert modules_history***************
		$action="Delete question";
		Imodules_h($modules,$action,$person["id"],$courses);
		mysql_query("DELETE FROM q_modules_questions WHERE question_id=".$quiz->getQId()." AND module_id=".$quiz->getModules() ."");

		echo "
			<html>
			<head>
			<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">
			<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=?a=viewQuestion&m=admin&modules=$modules \">
		</head>
		<body bgcolor=\"#ffffff\">
		<p>&nbsp;</p>
		<div align=\"center\" class=\"h3\"><b>The question has been deleted...</b></div>
		</body>
		</html>
		";
	break;
	case "2":
		mysql_query("DELETE FROM q_modules_questions WHERE question_id=".$quiz->getQId()." AND module_id = ".$quiz->getModules()." AND makecopy=1");
		echo "
			<html>
			<head>
			<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">
			<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=?a=viewQuestion&m=admin&modules=$modules \">
		</head>
		<body bgcolor=\"#ffffff\">
		<p>&nbsp;</p>
		<div align=\"center\" class=\"h3\"><b>The question has been deleted...</b></div>
		</body>
		</html>
		";
	break;
}
?>
