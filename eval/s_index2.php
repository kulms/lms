<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************   Student  View  *******************************
$evaluate= new  Evaluate($m_id,$_SESSION[course],$person['id']);

if(isset($Submit)){
		for($i=0;$i<=$sum_i;$i++){
				if($_POST["score$i"]){    // Insert ANSWER  
				//echo $_POST["ID$i"]."===".$_POST["score$i"];  echo "<br>";
					$evaluate->InsertAnswer($evaluate,$_POST["ID$i"],$_POST["score$i"],'',1);
				}
		}
		header("Location: printSuccess.php?survey=1&m_id=$m_id");
}

@list($e_name,$modules_id,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std,$show_rs) = $evaluate->getCosDetail($evaluate);
//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'s_index2.html',
															'body1'=>'std_survey_menu.html',
															'body2'=>'survey_detail.html',
										));   
										
				if($show_rs == 1){
								$template->assign_block_vars('SHOWMENU', '');
					}

$sql_alt   ="SELECT alt_id FROM eval_usrd_questions WHERE  users_id=-1 AND std_q =1 AND is_perceptual='1'  GROUP BY alt_id";
$result= mysql_query($sql_alt);  	
while($arr=mysql_fetch_array($result)){  
  @list($alt1,$alt2,$alt3,$alt4,$alt5) = $evaluate->GetAltOfQ($evaluate,$arr[alt_id]);
}
	$sql  ="SELECT *
	FROM eval_usrd_questions 
	WHERE  users_id=-1 
	AND std_q =1 
	AND is_perceptual='1'  ORDER BY q_order  ASC";
	$res = mysql_query($sql);  	
	$i=0;
		while($rs=mysql_fetch_array($res)){   
		@list($a_id,$a_score) = $evaluate->GetSurveyAnswer($evaluate,$person['id'],$rs[q_order]);
		//echo $a_id[0]."===".$a_score[0]."<br>";
			if($a_id[0] !='' && $a_score[0] !='')  $alreadyAns =1;
							$template->assign_block_vars('block', array('NO'=>$i+1,
																								       'QUES'=>$rs[question],
																									   'Q_ID'=>$rs[q_order],
																									   'C1'=>($a_id[0] == $rs[q_order] && $a_score[0]==5)?"checked":"",
																									   'C2'=>($a_id[0] == $rs[q_order] && $a_score[0]==4)?"checked":"",
																									   'C3'=>($a_id[0] == $rs[q_order] && $a_score[0]==3)?"checked":"",
																									   'C4'=>($a_id[0] == $rs[q_order] && $a_score[0]==2)?"checked":"",
																									   'C5'=>($a_id[0] == $rs[q_order] && $a_score[0]==1)?"checked":"",
																									   'COLOR'=>($i%2==1)?"tdbackground1":"tdbackground_white",
																		   ));
								$i++;
		}

				$template->assign_vars(array('Eval_Num'=>$Eval_Num,
																		'Eval_Question'=>$Eval_Question,
																		'THEME_NAME'=>$theme,
																		'CH1'=>$alt1,
																		'CH2'=>$alt2,
																		'CH3'=>$alt3,
																		'CH4'=>$alt4,
																		'CH5'=>$alt5,
																		'TITLEDESC'=>$strCalendar_LabDesc,
																		'EVAL_title'=>$INFO_EVAL_title,
																		'EVAL_NAME'=>$e_name,
																		'SUBJ_TITLE'=>$strSystem_RMenuCourse,
																		'CNAME'=>$evaluate->getCourseName($_SESSION[course]),
																		'DESCRIP'=>$Eval_descripe,
																		'EVAL_DETAIL'=>$info,
																		'STARTDATE' =>$start_date,  
																		'ENDDATE'=>$end_date,
																		'YEAR_TLTLE'=>$Eval_year,
																		'YEAR'=>$year,
																		'SEME'=>$Eval_semester,
																		'SEMESTER'=>$semester,
																		'STDATE'=>$Eval_startDate,
																		'ENDD'=>$Eval_endDate,
																		'MID'=>$m_id,
																		'SUM_I'=>$i,
																		'SUBMIT'=>($alreadyAns==1)?"":"<input type=\"submit\" name=\"Submit\" value=\"Submit\" class=\"button\">",
																		'DISABLED'=>($alreadyAns==1)?"disabled":"",
																		'EVAL_SURVEY_RES'=>$EVAL_SURVEY_RES,
																		'HOME'=>$HOME_Link,
																));


$template->assign_var_from_handle('body1','body1');
$template->assign_var_from_handle('body2','body2');
$template->pparse('body');							

?>
