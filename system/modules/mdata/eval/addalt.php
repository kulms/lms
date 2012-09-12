<? 
	session_start();
include('config.inc.php');
require("../eval/include/eval.class.php");
require("../include/global_login.php");

$evaluate= new  Evaluate('','','');

//@list($q_id,$alt_id,$question,$active)=$evaluate->GetQuestionOne($evaluate,$qid);
if($alt_id !=""){
$sql="SELECT * FROM eval_usrd_alternatives WHERE alt_id=".$alt_id."";
$data_sql=mysql_query($sql);
$alt1=mysql_result($data_sql,0,'alt1');
$alt2=mysql_result($data_sql,0,'alt2');
$alt3=mysql_result($data_sql,0,'alt3');
$alt4=mysql_result($data_sql,0,'alt4');
$alt5=mysql_result($data_sql,0,'alt5');
$res1=mysql_result($data_sql,0,'res1');
$res2=mysql_result($data_sql,0,'res2');
$res3=mysql_result($data_sql,0,'res3');
$res4=mysql_result($data_sql,0,'res4');
$res5=mysql_result($data_sql,0,'res5');
}
//=========================================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'index.html',
														       'main'=>'addalt.html',                                            
									));   

$template->assign_vars(array('EvaluationData'=>$strSystem_LabEvaluationData,
															'Evaluation'=>$strSystem_LabEvaluation,
															'Theme'=>$themem,
															'NumAll'=>$numAll,
															'Ques'=>$question,
															//'IS_CHECK_FILL'=>($alt_id ==0 && $qid !="")?"checked":"",
														//	'IS_CHECK_CHOICE'=>($alt_id !=0 || $qid =="")?"checked":"",
														//	'BLOCK'=>($alt_id !=0 || $qid =="")?"block":"none",
														//	'ACTIVE'=>($active ==1 || $active=="")?"checked":"",
														//	'Q_ID'=>$qid,
															'ALT1'=>($alt1=="" && $alt_id !="" )?"-":$alt1,
															'ALT2'=>($alt2=="" && $alt_id !="")?"-":$alt2,
															'ALT3'=>($alt3=="" && $alt_id !="")?"-":$alt3,
															'ALT4'=>($alt4=="" && $alt_id !="")?"-":$alt4,
															'ALT5'=>($alt5=="" && $alt_id !="")?"-":$alt5,
															'RES1'=>$res1,
															'RES2'=>$res2,
															'RES3'=>$res3,
															'RES4'=>$res4,
															'RES5'=>$res5,
															'ALT_ID'=>$alt_id,
												));


	//	$template->assign_block_vars('boxQ', array(
	//																'ALT'=>$evaluate->GetAltStd($evaluate,$alt_id),
	//														));

$template->assign_var_from_handle('MAIN','main');
$template->pparse('body');

?>