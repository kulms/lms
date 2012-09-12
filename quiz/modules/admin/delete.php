<?
require("../include/global_login.php");
include("../include/function.inc.php");

//$sql_moduletype=mysql_query("SELECT modules_type FROM modules WHERE id=$module");
//$module_type=mysql_result($sql_moduletype,0,"modules_type");
$quiz=new Quiz('',$module,$courses);
$sql="SELECT DISTINCT(question_id) FROM q_modules_questions WHERE module_id =$module";
$data_sql=mysql_query($sql);
$i=0;


while($row=mysql_fetch_array($data_sql)){
	 $q_id[]=$row['question_id'];
}

$count=count($q_id);
$ii=0;
for($i=0;$i<$count;$i++){
	//check copy
	 $sql="SELECT * FROM q_modules_questions WHERE module_id <> $module AND question_id=".$q_id[$i]." AND makecopy =1";
	 $data_sql=mysql_query($sql);
	 //echo $sql;
	 $check_copy=mysql_num_rows($data_sql);    //1=copy,0=not copy
	 
	  //check std user
	  $sql="SELECT o.* FROM q_modules_questions mq,q_occasions o,q_user_questions uq WHERE mq.question_id=uq.question_id AND mq.module_id=o.module_id  AND o.occasion_id=uq.occasion_id AND mq.module_id= ".$module." AND mq.question_id= ".$q_id[$i]." AND o.finished=0";
	  $data_sql=mysql_query($sql);
	  $check_user=mysql_num_rows($data_sql);    //1 have std user,0 have't std user 
	 if($check_copy==1){
		$data="copy";
		$i=$count;
	 }else if($check_user==1){
		$data="user";
		$i=$count;
	 }else{
		$ii++;
	 }

}
if($count ==0){
	mysql_query("DELETE FROM q_module_prefs  WHERE  module_id =".$module ."");
	mysql_query("DELETE FROM modules WHERE  id=$module ");
	mysql_query("DELETE FROM wp WHERE modules=$module");
	echo "<html>
						<head>
						<script language=\"javascript\">
								top.ws_menu.location.reload();
						</script>
						<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">
						</head>
						<body onLoad=\"update()\" bgcolor=\"#ffffff\">
						<div align=\"center\" class=\"main\"> deleted.....</div>
						</body>
						</html> 
						";
}else if($data=="copy"){
	echo "<html>
					<head>
						<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">
					</head>
					<body bgcolor=\"#ffffff\">
					<p>&nbsp;</p>
						<div align=\"center\" class=\"h3\"><b>Sorry...</b></div>
						<div align=\"center\" class=\"main\"><b>$strQuiz_LabDonotCopy</b></div><br><br><br><br>
						<div align=\"center\" class=\"main\"><a href=\"?a=viewQuestion&m=admin&modules=$module\" ><img src=\"../images/back.gif\" width=\"15\" height=\"15\" align=\"middle\" border=\"0\"><b>$strBack</b></a></div>
					</body>
					</html> ";
}else if($data=="user"){
	echo "<html>
					<head>
						<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">
					</head>
					<body bgcolor=\"#ffffff\">
					<p>&nbsp;</p>
						<div align=\"center\" class=\"h3\"><b>Sorry...</b></div>
						<div align=\"center\" class=\"main\"><b>$strQuiz_LabDonotCopy1</b></div><br><br><br><br>
						<div align=\"center\" class=\"main\"><a href=\"?a=viewQuestion&m=admin&modules=$module\" ><img src=\"../images/back.gif\" width=\"15\" height=\"15\" align=\"middle\" border=\"0\"><b>$strBack</b></a></div>
					</body>
					</html> ";
}else if($ii==$count){
	//mysql_query("UPDATE modules SET temp=1 WHERE id=$module;");
	//mysql_query("UPDATE wp SET temp=1 WHERE modules=$module;");
		for($x=0;$x<$count;$x++){
				$data_question=mysql_query("SELECT * FROM q_modules_questions WHERE question_id=".$q_id[$x]." AND module_id =$module AND makecopy=1");	
				$num_makecopy=mysql_num_rows($data_question);
				mysql_query("DELETE FROM q_modules_questions WHERE question_id=".$q_id[$x]." AND module_id =$module");
				if( $num_makecopy !=0)
					$del=0;
				else
					$del=1;
				
				if($del==1){
					mysql_query("DELETE FROM q_questions WHERE question_id=".$q_id[$x]."");
					mysql_query("DELETE FROM q_answers WHERE question_id=".$q_id[$x]."");
			
					//delete question_type=mcit
					mysql_query("DELETE FROM q_answer_mcit WHERE question_id=".$q_id[$x].""); 
					mysql_query("DELETE FROM q_question_mcit WHERE question_id=".$q_id[$x].""); 
				}
				//***********insert modules_history***************
				$action="Delete";
				Imodules_h2(5,$action,$person["id"],0,0,$courses_id,0);
				//Imodules_h(5,$action,$person["id"],$courses);

			//mysql_query("DELETE FROM q_modules_questions WHERE question_id=".$q_id[$x]." AND module_id=".$module ."");
	}
	mysql_query("DELETE FROM q_module_prefs  WHERE  module_id =".$module ."");
	mysql_query("DELETE FROM modules WHERE  id=$module ");
	mysql_query("DELETE FROM wp WHERE modules=$module");
	echo "<html>
						<head>
						<script language=\"javascript\">
								top.ws_menu.location.reload();
						</script>
						<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">
						</head>
						<body onLoad=\"update()\" bgcolor=\"#ffffff\">
						<div align=\"center\" class=\"main\"> deleted.....</div>
						</body>
						</html> 
						";
}

?>