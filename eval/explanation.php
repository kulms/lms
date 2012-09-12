<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");

if($isstd==1)  $mid = $m_id;
else $mid = $_SESSION[module_id]; 

$evaluate= new  Evaluate($mid,$_SESSION[course],$person['id']);
@list($e_name,$modules_id,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std,$show_rs) = $evaluate->getCosDetail($evaluate);


//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'explanation.html',
										));   
if($isstd==1)  {
		$template->set_filenames(array('header'=>'std_survey_menu.html',    ));
		if($show_rs == 1){
								$template->assign_block_vars('SHOWMENU', '');
					}
}else{
		$template->set_filenames(array('header' =>'survey_head.html', ));
}

				$template->assign_vars(array('THEME_NAME'=>$theme,
																		'DESC'=>$strQuiz_LabDesc,
																		'EVAL_Perceptual_title'=>$EVAL_Perceptual_title,
																		'THEME_JS'=>"include/menuh_".$theme.".js",
																		'EVAL_Visual_DES'=>$EVAL_Visual_DES,
																		'EVAL_Tactile_DES'=>$EVAL_Tactile_DES,
																		'EVAL_Auditory_DES'=>$EVAL_Auditory_DES,
																		'EVAL_Group_DES'=>$EVAL_Group_DES,
																		'EVAL_Kinesthetic_DES'=>$EVAL_Kinesthetic_DES,
																		'EVAL_Individual_DES'=>$EVAL_Individual_DES,
																		
																		'EVAL_Visual_NAME'=>$EVAL_Visual_NAME,
																		'EVAL_Tactile_NAME'=>$EVAL_Tactile_NAME,
																		'EVAL_Auditory_NAME'=>$EVAL_Auditory_NAME,
																		'EVAL_Group_NAME'=>$EVAL_Group_NAME,
																		'EVAL_Kinesthetic_NAME'=>$EVAL_Kinesthetic_NAME,
																		'EVAL_Individual_NAME'=>$EVAL_Individual_NAME,
																		'EVAL_SURVEY_RES'=>$EVAL_SURVEY_RES,
																		'HOME'=>$HOME_Link,
																		'MID'=>$mid,
									                 ));
													 
$template->assign_var_from_handle('HEADER','header');

$template->pparse('body');							
?>
