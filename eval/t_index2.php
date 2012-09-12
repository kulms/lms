<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************View  Evaluate  Teacher*******************************
 
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);
@list($e_name,$modules_id,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std) = $evaluate->getCosDetail($evaluate);




//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'t_index2.html',
														'header'=>'survey_head.html',      
														'header2'=>'survey_detail.html',
										));   

$sql_alt   ="SELECT alt_id FROM eval_usrd_questions WHERE  users_id=-1 AND std_q =1 AND is_perceptual='1'  GROUP BY alt_id";
$result= mysql_query($sql_alt);  	
while($arr=mysql_fetch_array($result)){  
  @list($alt1,$alt2,$alt3,$alt4,$alt5) = $evaluate->GetAltOfQ($evaluate,$arr[alt_id]);
}

	$sql  ="SELECT *
	FROM eval_usrd_questions 
	WHERE  users_id=-1 
	AND std_q =1 
	AND is_perceptual='1'  ORDER BY q_order ";
	$res = mysql_query($sql);  	
	$i=0;
		while($rs=mysql_fetch_array($res)){   
					++$i;
					$template->assign_block_vars('block', array('NO'=>$i,
																								       'QUES'=>$rs[question],
																									   'Q_ID'=>$rs[q_id],
																									   'COLOR'=>($i%2==0)?"tdbackground1":"tdbackground_white",
																		));
		}

				$template->assign_vars(array('Eval_Num'=>$Eval_Num,
																		'Eval_Question'=>$Eval_Question,
																		'THEME_NAME'=>$theme,
																		'CH1'=>$alt1,
																		'CH2'=>$alt2,
																		'CH3'=>$alt3,
																		'CH4'=>$alt4,
																		'CH5'=>$alt5,
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
																		'TITLEDESC'=>$strCalendar_LabDesc,
																		'THEME_JS'=>"include/menuh_".$theme.".js",
																		
																		));
														

$template->assign_var_from_handle('HEADER','header');
$template->assign_var_from_handle('DETAIL','header2');

$template->pparse('body');							
?>
