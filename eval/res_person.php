<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************   Student  View  *******************************
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);



@list($e_name,$modules_id,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std) = $evaluate->getCosDetail($evaluate);
//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'res_person.html',
															'header'=>'survey_head.html',   
															'header2'=>'survey_detail.html',
										        ));   


	@list($user_id)= $evaluate->GetSurveyStudent($evaluate);
$x =$y=$z =1;
for($i=0;$i<count($user_id);$i++){

  //$sum_vis =0; $sum_tac=0;$sum_aud=0;$sum_grp =0;$sum_kin=0;$sum_ind =0;
		@list($std_id,$firstname,$surname,$email,$category,$admin) = $evaluate->GetDetailPerson($evaluate,$user_id[$i]);
		$fullname = $firstname."  ".$surname;
		
		@list($a_id,$a_score) = $evaluate->GetSurveyAnswer($evaluate,$user_id[$i],'');
		@list($major,$minor) = $evaluate->GetPreference($a_id,$a_score);

			 if($m==$major){
					$template->assign_block_vars('block', array('NO'=>$x,
																								       'STD_ID'=>$std_id,
																									   'FULLNAME'=>$fullname,
																									  'MAJOR'=>$major,
																									   'MINOR'=>$minor,
																		));      $x++;
				}
				 if($n==$minor){
					$template->assign_block_vars('block', array('NO'=>$y,
																								       'STD_ID'=>$std_id,
																									   'FULLNAME'=>$fullname,
																									  'MAJOR'=>$major,
																									   'MINOR'=>$minor,
																		));    $y++;
				}
				if($m=="" && $n==""){
					$template->assign_block_vars('block', array('NO'=>$z,
																								       'STD_ID'=>$std_id,
																									   'FULLNAME'=>$fullname,
																									  'MAJOR'=>$major,
																									   'MINOR'=>$minor,
																		));      $z++;
				}
} // for

@list($all_users)= $evaluate->GetstdOfCourse($evaluate);
//echo $i ."===".count($all_users);
				$template->assign_vars(array('NUM'=>$strCourses_LabStdNo,
																		'THEME_NAME'=>$theme,
																		  'NAME_TITLE'=>$strCourses_LabStdName,
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
																		'SUM_I'=>$i,
																		'SUBMIT'=>(count($a_id)!=0)?"":"<input type=\"submit\" name=\"Submit\" value=\"Submit\" class=\"button\">",
																		 'DISABLED'=>(count($a_id)>0)?"disabled":"",
																		 'FROM_WHO'=>$i." ".$EVAL_Persons." ".$strPersonal_msg_From.$EVAL_Student_All.count($all_users)." ".$EVAL_Persons ,
																		 'THEME_JS'=>"include/menuh_".$theme.".js",
																));
																
$template->assign_var_from_handle('HEADER','header');
$template->assign_var_from_handle('DETAIL','header2');

$template->pparse('body');							
?>
