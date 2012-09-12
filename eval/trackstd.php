<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");

//******************************View  Evaluate  Teacher*******************************
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);
@list($e_name,$modules_id,,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std)= $evaluate->getCosDetail($evaluate);
@list($users)= $evaluate->GetstdOfCourse($evaluate);

if(isset($_POST[send])){ //Sent msg to Student 
			for($i=1;$i<$_POST[n];$i++){
					if($_POST["to$i"] !=""){
							$evaluate->sentMsg(3,$_POST[subject],$_POST[message],$person[id],$_POST["to$i"]); // Send Message
					}
			}
		header("Location: temp/sentSuccess.html");

}

 $template= new Template(C_SKIN);
							$template->set_filenames(array('body' =>'trackstd.html',
																					'header'=>'tea_menu.html',  
																				));

$n=1;
for($i=0;$i<count($users);$i++){
		 	$rs = $evaluate->GetstdNotEval($evaluate,$users[$i]);
			if($rs ==false){
					$abno=  $users[$i];
					//echo $users[$i];
					 @list($id,$firstname,$surname,$email,$category,$admin) = $evaluate->GetDetailPerson($evaluate,$users[$i]);
					$template->assign_block_vars('StdList',array('UID'=>$users[$i],
																										'NUM'=>$n,
																										'NAME'=>$firstname." ".$surname,  
																										'COLOR'=>($i%2==0)?"bgcolor class=\"tdbackground1\" ":"bgcolor class=\"tdbackground3\"",
																				));
					$n++;
			}
}
					//echo $n;
			 @list($id,$firstname,$surname,$email,$category,$admin) = $evaluate->GetDetailPerson($evaluate,$person[id]);

$template->assign_vars(array('STARTDATE' =>$start_date,  
																'ENDDATE'=>$end_date,
																'YEAR'=>$year,
																'SEMESTER'=>$semester,
																'COURSE' =>$evaluate->getCourse($evaluate),  
																'MODULE_ID'=>$evaluate->getModule($evaluate),
																'CNAME'=>$evaluate->getCourseName($_SESSION[course]),
																'TEACHER'=>$firstname." ".$surname,
																'N'=>$n,
																'THEME_NAME'=>$theme,
																'LISTSTD'=>$listSTD,
																'Eval_StdNum'=>$Eval_StdNum,
																'Eval_SendMail'=>$Eval_SendMail,
																'Eval_SendAll'=>$Eval_SendAll,
																'Std_NAME'=>$Std_NAME,
																'SUBJ'=>$strPersonal_msg_Subject,
																'FROM'=>$strPersonal_msg_From,
																'MSG'=>$strPersonal_msg_Message,
																'Send'=>$strSend,
																'HOME'=>$HOME_Link,
																'RES_Everage'=>$RES_Everage,
																'RES_Person'=>$RES_Person,
																'Check_no_Eval'=>$Check_no_Eval,
														));
														
$template->assign_var_from_handle('HEADER','header');														
$template->pparse('body');							


?>