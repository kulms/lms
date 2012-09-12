<? 
session_start();
include('config.inc.php');
require("../eval/include/eval.class.php");
require("../include/global_login.php");

$evaluate= new  Evaluate('','','');
$num=$evaluate->CheckDelete($qid);
//=========================================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'index.html',
														    //  'main'=>'addnew.html',                                            
									));   

$template->assign_vars(array('EvaluationData'=>$strSystem_LabEvaluationData,
															'Evaluation'=>$strSystem_LabEvaluation,
															'Theme'=>$themem,
															'BACK'=>"<a href=\"?m=mdata&m1=eval&a=index\">กลับ</a>",
															'TEXT'=>"ไม่สามารถ ทำงานลบข้อมูลได้ เนื่องจากมีการใช้ข้อมูลแบบประเมิน ข้อนี้อยู่",
												));
		if($num !=0) {
			$template->set_filenames(array('main'=>'delete.html', 	));
			$template->assign_var_from_handle('MAIN','main');					 
		}else{
			$sql=mysql_query("DELETE FROM eval_usrd_questions WHERE q_id =".$qid."");
			$del="Delete  Complete !!";
		}
$template->pparse('body');
?>
<? if($num==0){?>
<html>
<head>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?m=mdata&m1=eval&a=index">
</head>
<body bgcolor="#ffffff">
<p>&nbsp;</p>
<div align="center" class="h3"><b><? echo $del ?></b></div>
</body>
</html>
<? }?>