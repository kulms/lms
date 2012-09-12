<? 
session_start();
include('config.inc.php');
require("../eval/include/eval.class.php");
require("../include/global_login.php");

$evaluate= new  Evaluate('','','');

// $row=$evaluate->GetAlternativesAdmin();
//echo $num=$row->numRows();
$sql="SELECT * FROM eval_usrd_alternatives WHERE users_id=-1";
$data_sql=mysql_query($sql);
$num=mysql_num_rows($data_sql);
//=========================================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'index.html',
														       'main'=>'list_alt.html',                                            
									));   

$template->assign_vars(array('EvaluationData'=>$strSystem_LabEvaluationData,
															'Evaluation'=>$strSystem_LabEvaluation,
															'Theme'=>$themem,
												));
$i=0;
while($rs=mysql_fetch_array($data_sql)){
	++$i;
	$name_alt="";
	$name_res="";
	//echo $rs['alt1'];
	for($ii=1;$ii<=5;$ii++){
			$a=$ii+1;
//			echo $rs["alt".$a];
			if($rs["alt".$a] !="") {$comma="&nbsp;,&nbsp; ";}else{$comma="";}

			if($rs["alt".$ii] !=""){
						$name_alt.= $rs["alt".$ii].$comma;
						$name_res.=$rs["res".$ii].$comma;
				}
	}

	//echo $name_alt."<br>";
	$template->assign_block_vars('block',array('NO'=>$i,
																							'ALT'=>$name_alt,
																							'RES'=>$name_res,
																							'ALT_ID'=>$rs['alt_id'],
																));
}

$template->assign_var_from_handle('MAIN','main');
$template->pparse('body');

?>