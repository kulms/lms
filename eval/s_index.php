<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
 
$evaluate= new  Evaluate('',$_SESSION[course],$person['id']);
$m=1;
$n=1;

//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'s_index.html',
														                                 
										));   


// NOT DO EVALUATION   *******************************************
@list($modules_id,$m_name,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std) = $evaluate->getModuleEval($evaluate,0);
	if(count($modules_id)>0){  
			$template->assign_block_vars('startB1',''  );
	}
			for($i=0;$i<count($modules_id);$i++){  //NOT  do
			
																			$template->assign_block_vars('startB1.boxQ', array(
																											'NUM'=>$n,
																											'EVAL_NAME'=>$m_name[$i],
																											'DEADLINE'=>$end_date[$i],
																											'STATUS'=>($eval_type[$i]==1)?"<a href=\"std_session.php?url=std_eval.php&m_id={$modules_id[$i]}\">$MUST_DO</a>":"<a href=\"s_index2.php?m_id=$modules_id[$i]\">$MUST_DO</a>",
																									));
																					$n++;
				}//for

// DO already*******************************************
@list($modules_id,$m_name,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std) = $evaluate->getModuleEval($evaluate,1);
	if(count($modules_id)>0){  
			$template->assign_block_vars('startB2',''  );
	}
			for($i=0;$i<count($modules_id);$i++){
													$template->assign_block_vars('startB2.boxE', array(
																											'NUM'=>$m,
																											'EVAL_NAME'=>$m_name[$i],
																											'DEADLINE'=>$end_date[$i],
																											'STATUS'=>($eval_type[$i]==1)?"<a href=\"std_session.php?url=result_eval.php&m_id={$modules_id[$i]}\">$LOOK_EVAL</a>":"<a href=\"s_index2.php?m_id=$modules_id[$i]\">$LOOK_EVAL</a>",
																									));
																						$m++;
			}																									

		$template->assign_vars(array('STARTDATE' =>$start_date,  
																'ENDDATE'=>$end_date,
																'YEAR'=>$year,
																'SEMESTER'=>$semester,
																'COURSE' =>$evaluate->getCourse($evaluate),  
																'MODULE_ID'=>$evaluate->getModule($evaluate),
																'CNAME'=>$evaluate->getCourseName($_SESSION[course]),
																'NOTEVAL'=>($m==1 && $n==1)?"<br><br>$EVAL_NOT":"",
																'NOTDO'=>$NOTDO,
																'ALREADYDO'=>$ALREADYDO,
																'EVAL_STATUS'=>$EVAL_STATUS,
																'EVALDeadLine'=>$INFO_EVAL_dead,
																'EVAL_TITLE'=>$INFO_EVAL_title ,
																'NO'=>$Eval_StdNum,
																'COS_EVAL'=>$COS_EVAL,
																'THEME_NAME'=>$theme,
														));
$template->pparse('body');							
?>