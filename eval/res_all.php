<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************   Student  View  *******************************

if($isstd==1)  $mid = $m_id;
else $mid = $_SESSION[module_id]; 



$evaluate= new  Evaluate($mid,$_SESSION[course],$person['id']);
@list($e_name,$modules_id,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std,$show_rs) = $evaluate->getCosDetail($evaluate);
//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
	$template->set_filenames(array('body' =>'res_all.html',
															'header' =>'survey_head.html', 
															'header2'=>'survey_detail.html',
										      	   ));  

@list($user_id)= $evaluate->GetSurveyStudent($evaluate);

$maj_sum_vis = $maj_sum_tac =$maj_sum_aud=$maj_sum_grp=$maj_sum_kin=$maj_sum_ind=0;
$minor_sum_vis = $minor_sum_tac =$minor_sum_aud=$minor_sum_grp=$minor_sum_kin=$minor_sum_ind=0;

for($i=0;$i<count($user_id);$i++){
		@list($a_id,$a_score) = $evaluate->GetSurveyAnswer($evaluate,$user_id[$i],'');
		@list($major,$minor) = $evaluate->GetPreference($a_id,$a_score);
		
		switch ($major) {
				case "Visual":  
						   $maj_sum_vis = $maj_sum_vis+1;  //   number of person
				   break;
				case "Tactile":
						   $maj_sum_tac = $maj_sum_tac+1;
				   break;
				case "Auditory":
						   $maj_sum_aud = $maj_sum_aud+1;
				   break;
			 case "Group":
						   $maj_sum_grp= $maj_sum_grp+1;
				   break;
				case "Kinesthetic":
						   $maj_sum_kin = $maj_sum_kin+1;
				   break;
				 case "Individual":
						   $maj_sum_ind = $maj_sum_ind+1;
				   break;
		}

//****************************************
		switch ($minor) {
				case "Visual":  
						   $minor_sum_vis = $minor_sum_vis+1;  //   number of person
				   break;
				case "Tactile":
						   $minor_sum_tac = $minor_sum_tac+1;
				   break;
				case "Auditory":
						   $minor_sum_aud = $minor_sum_aud+1;
				   break;
			 case "Group":
						   $minor_sum_grp= $minor_sum_grp+1;
				   break;
				case "Kinesthetic":
						   $minor_sum_kin = $minor_sum_kin+1;
				   break;
				 case "Individual":
						   $minor_sum_ind = $minor_sum_ind+1;
				   break;
		}

} // for
@list($all_users)= $evaluate->GetstdOfCourse($evaluate);

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
																			'maj_sum_vis'=>($maj_sum_vis>0)?"<a href=\"res_person.php?m=Visual\">$maj_sum_vis</a>":$maj_sum_vis,
																			'maj_sum_tac'=>($maj_sum_tac>0)?"<a href=\"res_person.php?m=Tactile\">$maj_sum_tac</a>":$maj_sum_tac,
																			'maj_sum_aud'=>($maj_sum_aud>0)?"<a href=\"res_person.php?m=Auditory\">$maj_sum_aud</a>":$maj_sum_aud,
																			'maj_sum_grp'=>($maj_sum_grp>0)?"<a href=\"res_person.php?m=Group\">$maj_sum_grp</a>":$maj_sum_grp,
																			'maj_sum_kin'=>($maj_sum_kin>0)?"<a href=\"res_person.php?m=Kinesthetic\">$maj_sum_kin</a>":$maj_sum_kin,
																			'maj_sum_ind'=>($maj_sum_ind >0)?"<a href=\"res_person.php?m=Individual\">$maj_sum_ind</a>":$maj_sum_ind,
																			
																			'minor_sum_vis'=>($minor_sum_vis>0)?"<a href=\"res_person.php?n=Visual\">$minor_sum_vis</a>":$minor_sum_vis,
																			'minor_sum_tac'=>($minor_sum_tac>0)?"<a href=\"res_person.php?n=Tactile\">$minor_sum_tac</a>":$minor_sum_tac,
																			'minor_sum_aud'=>($minor_sum_aud>0)?"<a href=\"res_person.php?n=Auditory\">$minor_sum_aud</a>":$minor_sum_aud,
																			'minor_sum_grp'=>($minor_sum_grp>0)?"<a href=\"res_person.php?n=Group\">$minor_sum_grp</a>":$minor_sum_grp,
																			'minor_sum_kin'=>($minor_sum_kin>0)?"<a href=\"res_person.php?n=Kinesthetic\">$minor_sum_kin</a>":$minor_sum_kin,
																			'minor_sum_ind'=>($minor_sum_ind>0)?"<a href=\"res_person.php?n=Individual\">$minor_sum_ind</a>":$minor_sum_ind,
																			'EVAL_Amount'=>$EVAL_Amount,
																			'EVAL_Persons'=>$EVAL_Persons,
																			'EVAL_Perceptual_title'=>$EVAL_Perceptual_title,
																			'FROM_WHO'=>$i." ".$EVAL_Persons." ".$strPersonal_msg_From.$EVAL_Student_All.count($all_users)." ".$EVAL_Persons ,
																			'THEME_JS'=>"include/menuh_".$theme.".js",
																			'EVAL_SURVEY_RES'=>$EVAL_SURVEY_RES,
																			'HOME'=>$HOME_Link,
																			'MID'=>$evaluate->getModule($evaluate),
																));
																
$template->assign_var_from_handle('HEADER','header');
$template->assign_var_from_handle('DETAIL','header2');
$template->pparse('body');							
?>
