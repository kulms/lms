<? 
session_start();
include('config.inc.php');
require("../eval/include/eval.class.php");
require("../include/global_login.php");

$evaluate= new  Evaluate('','','');
//@list($q_id,$alt_id,$question) = $evaluate->GetStandardQuestion($evaluate,false);
//$numAll=count($q_id);

$sql="SELECT q_id FROM eval_usrd_questions WHERE users_id=-1";
$data_sql=mysql_query($sql);
$numAll=mysql_num_rows($data_sql);
//get Alternatives
 $row=$evaluate->GetAlternativesAdmin();
 $num=$row->numRows();

//set Active
if($set==1){
	$sql=mysql_query("UPDATE eval_usrd_questions SET active=0 WHERE std_q=1");
	for($i=1;$i<=$count;$i++)
	{
		$sql1=mysql_query("UPDATE eval_usrd_questions SET active=1 WHERE q_id=". $chk[$i]." ");
	}
}
//

//=========================================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'index.html',
														       'main'=>'list_std.html',                                            
									));   

$template->assign_vars(array('EvaluationData'=>$strSystem_LabEvaluationData,
															'Evaluation'=>$strSystem_LabEvaluation,
															'Theme'=>$themem,
															'NumAll'=>$numAll,
												));
$i=0;
while($rs=@$row->fetchRow(DB_FETCHMODE_ASSOC)){       //while alt
$alt="";
	for($n=0;$n<6;$n++){
		if($rs['alt'.$n] !=""){
			if($n !=5){
				$alt.=$rs['alt'.$n] .",";
			}else{
				$alt.=$rs['alt'.$n] ;
			}
		}
	}
	$template->assign_block_vars('block',array('ALT'=>$alt,
																));
	$alt_id=$rs['alt_id'];
	$sql="SELECT * FROM eval_usrd_questions WHERE alt_id=".$alt_id." AND std_q =1";
	$data_sql=mysql_query($sql);
	while($rs1=mysql_fetch_array($data_sql)){
		++$i;
		$question=$rs1['question'];
		$q_id=$rs1['q_id'];
		$active=$rs1['active'];
		$template->assign_block_vars('block.std', array('NO'=>$i,
																								       'QUES'=>$question,
																									   'Q_ID'=>$q_id,
																										'IS_CHECK'=>($active==1)?"checked":"",
																		));
	}
}

$sql="SELECT * FROM eval_usrd_questions WHERE alt_id=0 AND std_q =1";
$data_sql=mysql_query($sql);
$num_rows=mysql_num_rows($data_sql);
if($num_rows !=0){
	$template->assign_block_vars('block_',array( ));                //Fill
	while($rs=mysql_fetch_array($data_sql)){
		++$i;
		$question=$rs['question'];
		$q_id=$rs['q_id'];
		$active=$rs['active'];
		$template->assign_block_vars('block_.std_', array('NO'=>$i,
																								       'QUES'=>$question,
																									   'Q_ID'=>$q_id,
																										'IS_CHECK'=>($active==1)?"checked":"",
																		));
	}													
}


$template->assign_var_from_handle('MAIN','main');
$template->pparse('body');

?>