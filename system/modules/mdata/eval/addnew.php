<? 
	session_start();
include('config.inc.php');
require("../eval/include/eval.class.php");
require("../include/global_login.php");

$evaluate= new  Evaluate('','','');

@list($q_id,$alt_id,$users_id,$g_id,$question,$cat_id,$std_q,$active) = $evaluate->GetQuestionOne($evaluate,$qid);
//@list($q_id,$alt_id,$question,$active)=$evaluate->GetQuestionOne($evaluate,$qid);
if($alt_id==0)
	$choice=0;
else
	$choice=1;
//=========================================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'index.html',
														       'main'=>'addnew.html',                                            
									));   

$template->assign_vars(array('EvaluationData'=>$strSystem_LabEvaluationData,
															'Evaluation'=>$strSystem_LabEvaluation,
															'Theme'=>$themem,
															'NumAll'=>$numAll,
															'Ques'=>$question,
															'IS_CHECK_FILL'=>($alt_id ==0 && $qid !="")?"checked":"",
															'IS_CHECK_CHOICE'=>($alt_id !=0 || $qid =="")?"checked":"",
															'BLOCK'=>($alt_id !=0 || $qid =="")?"block":"none",
															'ACTIVE'=>($active ==1 || $active=="")?"checked":"",
															'Q_ID'=>$qid,
															'CHOICE'=>$choice,
												));


	$template->assign_block_vars('boxQ', array(
																	'ALT'=>$evaluate->GetAltStd($evaluate,$alt_id),
															));

$template->assign_var_from_handle('MAIN','main');
$template->pparse('body');

?>