<?
session_start();
require("../include/global_login.php");
include("./include/var.inc.php");
include('include/config.inc.php');
require("include/eval.class.php");

$evaluate= new  Evaluate($module_id,$course,$person['id']);
@list($e_name,$modules_id,,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std,$show_rs) = $evaluate->getCosDetail($evaluate);

//get standard
 $row=$evaluate->GetStandardQuestionByUser($evaluate);
 $num_std=$row->numRows();

//get question by user
@list($g_id,$g_name) = $evaluate->GetGroupQuestion($evaluate);
//-----------------------------------------Template--------------------------------------------------------------------
if($isStud==1){
		$hd ="stud_menu.html";
}else if($isStud==2){
		$hd ="stud_menu_r.html";
}else{
		$hd ="tea_menu.html";
}
										


 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'cresult.html',
														'body2' =>'cresult_user.html',
														'header'=>$hd,
												));
												
if($show_rs == 1){
					$template->assign_block_vars('SHOWMENU', '');
}

										
//header
$template->assign_vars(array('CNAME'=>$evaluate->getCourseName($_SESSION[course]),
												));

//Text 
$template->assign_vars(array('QuesStandard'=>$Eval_StdQues,
															'QuesNo'=>$Eval_Num,
															'Eval_Question'=>$Eval_Question,
															'Eval_Score'=>$Eval_Score,
															'MaxScore'=>$strEvalMaxScore,
															'AverageScore'=>$strEvalAverageScore,
															'Eval_TeaQues'=>$Eval_TeaQues,
															'TOTAL'=>$Eval_total,
															'unitPerStd'=>$unitPerStd,
															'THEME_NAME'=>$theme,
															'HOME'=>$HOME_Link,
															'RES_Everage'=>$RES_Everage,
															'RES_Person'=>$RES_Person,
															'Check_no_Eval'=>$Check_no_Eval,
															'MID'=>$module_id,
															'COURSEID' =>$evaluate->getCourse($evaluate),  
												));
	$i=0;
		@list($q_id,$alt_id,$question,$grp_id) = $evaluate->GetStandardQuestion($evaluate,1,'');
				$m=1;
						for($i=0;$i<count($q_id);$i++){
											if($alt_id[$i] !=0){
													 @list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
														$max_score="<script type=\"text/javascript\">
																document.write(Math.max($res1,$res2,$res3,$res4,$res5));
																</script>";
													
													$sql_score=mysql_query("SELECT SUM(scores) as sum 
													FROM eval_usrd_answers 
													WHERE q_id =".$grp_id[$i]." AND modules_id=".$evaluate->getModule()."");
													$sum_score=mysql_result($sql_score,0,"sum");
													
													$sql_num=mysql_query("SELECT ans_id 
													FROM  eval_usrd_answers 
													WHERE q_id =".$grp_id[$i]." AND modules_id=".$evaluate->getModule()."");
													$num=mysql_num_rows($sql_num);
													
													if($num !=0){
														$aver=number_format($sum_score/$num,2);
														$graph=$aver*25;
													}
													$template->assign_block_vars('block', array(
																											'NO'=>$m,
																											'QUES'=>$question[$i],
																											'SCORE'=>$max_score,
																											'GRAPH'=>($num !=0)?"<img src=\"./images/1.gif\" width=\"".$graph."\" height=\"10\">&nbsp;".$aver."" :"-",
																											));
																		$m++;
												}
						}
										
						@list($q_id,$alt_id,$question,$grp_id) = $evaluate->GetStandardQuestion($evaluate,1,1);
									for($i=0;$i<count($q_id);$i++){
										$sql=mysql_query("SELECT ans_id FROM eval_usrd_answers WHERE q_id=".$grp_id[$i]."");
										$num_rows=mysql_num_rows($sql);
												$template->assign_block_vars('Suggest', array(
																									'QUESTION'=>$question[$i],
																									'SG_ID'=>$grp_id[$i],
																									'NO'=>$m,
																									'COLOR'=>"background=\"images/fill_bg.gif\"",
																									 'Click'=>($num_rows !=0)?"<a href=JavaScript:test('$q_id[$i]',1,'$grp_id[$i]')>view</a>":"-",	
																									'SCORE'=>"-",
												));
												$m++;
											}
// ---------------------------------------------------------------------END-----  Standard  Question

		$n=1;
		for($g=0;$g<count($g_id);$g++){
									if($g_id[$g] == $_GET[grp_id]){  
												 $gp_name =  $g_name[$g];   
												 $group_name .=$g_name[$g]." | ";
									  }else{
									  			$group_name .="<a href=\"cresult.php?grp_id={$g_id[$g]}#QT\"><span class=\"Bcolor\">".$g_name[$g]."</span></a> | ";
												//$gp_name =  $g_name[$g];   
									  }

				}
		$template->assign_vars(array('GROUP_NAME'=>$group_name,
																//	'G_NAME'=>$gp_name,
																));
		if($_GET[grp_id] !=""){
							$gp_id  =$_GET[grp_id];
				}else{
							$gp_id = $g_id[0];
							 $gp_name =  $g_name[0];  
				}
		if($gp_id !=""){
			$template->assign_block_vars('GroupQ',array(
																			'GID'=>$gp_id,
																			'G_NAME'=>$gp_name,  
																	));
		}
		@list($q_id,$alt_id,$question) = $evaluate->GetQuestion($evaluate,$gp_id,1);// Choice Question
		$num_user=count($q_id);
		for($i=0;$i<count($q_id);$i++){
			@list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
			$max_score="<script type=\"text/javascript\">
																document.write(Math.max($res1,$res2,$res3,$res4,$res5));
																</script>";

			$sql_score=mysql_query("SELECT SUM(scores) as sum FROM eval_usrd_answers WHERE q_id =".$q_id[$i]." AND modules_id=".$evaluate->getModule()."");
			$sum_score=mysql_result($sql_score,0,"sum");
			
			$sql_num=mysql_query("SELECT ans_id FROM  eval_usrd_answers WHERE q_id =$q_id[$i] AND modules_id=".$evaluate->getModule()."");
			$num=mysql_num_rows($sql_num);
			
			if($num !=0){
				$aver=number_format($sum_score/$num,2);
				$graph=$aver*25;
			}
			$template->assign_block_vars('GroupQ.Ques', array('Question'=>$question[$i],
																										 'Num'=>$n,
																										'MaxScore'=>$max_score,
																										'GRAPH'=>($num !=0)?"<img src=\"./images/1.gif\" width=\"".$graph."\" height=\"10\">&nbsp;".$aver."" :"-",
																			));
			$n++;
		}
		@list($q_id,$alt_id,$question) = $evaluate->GetQuestion($evaluate,$gp_id,2);// ????????????????
		for($i=0;$i<count($q_id);$i++){
			$sql=mysql_query("SELECT ans_id FROM eval_usrd_answers WHERE q_id=".$q_id[$i]."");
			$num_rows=mysql_num_rows($sql);
			$template->assign_block_vars('GroupQ.QuesFill', array('QF_ID'=>$q_id[$i],
																										 'QF_NUM'=>$n,
																										 'Question'=>$question[$i],
																										 'MaxScore'=>"-",
																										 'Click'=>($num_rows !=0)?"<a href=JavaScript:test('$q_id[$i]',0,'')>view</a>":"-",
																		));
		   $n++;
			}
		
	if($num_std ==0){
		$template->assign_block_vars('error', array('NoData_std'=>"$Eval_NOTStdQues",
																		));
	}
	
	if($num_user ==0){
		$template->assign_block_vars('error_', array('NoData_'=>"$Eval_NOTTeaQues",
																		));
	}
	$template->assign_var_from_handle('QUES_USER','body2');
	

$template->assign_var_from_handle('HEADER','header');
$template->pparse('body');							

?>