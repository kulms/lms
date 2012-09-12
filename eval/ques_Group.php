<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
		
		
//echo $g_id,$gname;
if($g_id ==""){
				$gp_id = $_SESSION[g_id] ;
	}else{
				$gp_id = $g_id;
	}

		
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);


 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'ques_Group.html',
														'header'=>'tea_menu.html',                                           
										));   
										
			$template->assign_vars(array('GNAME'=>($gname !="")?"$gname":"$_SESSION[g_name]",
																	'GID'=>($g_id !="")?"$g_id":"$_SESSION[g_id]",
																	'DISA'=>($gp_id !='')?"disabled":"",
																	'BOX1'=>($gp_id !='')?"<input name=\"name\" type=\"text\" disabled size=\"60\" value=\"$gname\"><input name=\"g_name\" type=\"hidden\"  value=\"$gname\">":"<input name=\"g_name\" type=\"text\"  size=\"60\" value=\"$gname\">",
																	'CNAME'=>$evaluate->getCourseName($_SESSION[course]),
																	'THEME_NAME'=>$theme,
																	'chooseQues'=>$chooseQues,
																	'Eval_AddTeaQues'=>$Eval_AddTeaQues,
																	'Eval_Question'=>$Eval_Question,
																	'AddChoice'=>$AddChoice,
																	'AddFill'=>$AddFill,
																	'Back'=>$strBack,
																	'Eval_AddGroupQues'=>$Eval_AddGroupQues,
																	'Eval_GroupName'=>$Eval_GroupName,
																	'HOME'=>$HOME_Link,
																	'RES_Everage'=>$RES_Everage,
																	'RES_Person'=>$RES_Person,
																	'Check_no_Eval'=>$Check_no_Eval,
													));
										

$template->assign_var_from_handle('HEADER','header');
$template->pparse('body');							

	?>