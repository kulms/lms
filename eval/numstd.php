<? 
session_start();
require("../include/global_login.php");
include("./include/var.inc.php");
include('include/config.inc.php');
require("include/eval.class.php");


$evaluate= new  Evaluate($module_id,$course,$person['id']);
@list($e_name,$modules_id,,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std,$show_rs) = $evaluate->getCosDetail($evaluate);

@list($g_id,$g_name) = $evaluate->GetGroupQuestion($evaluate);

if($isStud==1){
		$hd ="stud_menu.html";
}else if($isStud==2){
		$hd ="stud_menu_r.html";
}else{
		$hd ="tea_menu.html";
}
										

//========================================================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'numstd.html',
																			'header'=>$hd,
																));
																
if($show_rs == 1){
					$template->assign_block_vars('SHOWMENU', '');
}

//header
$template->assign_vars(array('CNAME'=>$evaluate->getCourseName($_SESSION[course]),
															'QuesStandard'=>$Eval_StdQues,
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
												));

//-------------Questuin Std-----------------------------//
//get Alternatives
 $row=$evaluate->GetAlternatives($evaluate,1,0);
 $num=$row->numRows();
 if($num ==0)
		$template->assign_block_vars('nodata',array('NoData_std'=>"$Eval_NOTStdQues"));

while($rs=@$row->fetchRow(DB_FETCHMODE_ASSOC)){       //while alt
	$template->assign_block_vars('block',array( ));
	$row_std=$evaluate->GetStandardGroupAlt($evaluate,$rs['alt_id'],1,'');
	$row_std->numRows();
	for($i=1;$i<6;$i++){
		$res[$i]=$rs['res'.$i];
		$alt[$i]=$rs['alt'.$i];
		$template->assign_block_vars('block.block_alt',array('ALT'=>$alt[$i]."(".$res[$i].")",
																	));
	}
		//$a=0;
		$id=array();
		while($rs_std=@$row_std->fetchRow(DB_FETCHMODE_ASSOC)){
		$id[$ii]=$rs_std['g_id'];
		//$a++;
		++$ii;
		$sql_score=mysql_query("SELECT scores FROM  eval_usrd_answers WHERE q_id =".$rs_std['g_id']." AND modules_id=".$evaluate->getModule()."");
		$num_res1=0;
		$sum_res1=0;
		$num_res2=0;
		$num_res3=0;
		$num_res4=0;
		$num_res5=0;
		
		while($rs1=mysql_fetch_array($sql_score)){  //while std
			if($rs1['scores']==$rs['res1'])
				$num_res1=$num_res1+1;
			else if($rs1['scores']==$rs['res2'])
				$num_res2=$num_res2+1;
			else if($rs1['scores']==$rs['res3'])
				$num_res3=$num_res3+1;
			else if($rs1['scores']==$rs['res4'])
				$num_res4=$num_res4+1;
			else if($rs1['scores']==$rs['res5'])
				$num_res5=$num_res5+1;
			}
		$template->assign_block_vars('block.list',array('NO'=>$ii,
																								'QUES'=>$rs_std['question'],
																								'RES1'=>$num_res1,
																								'RES2'=>$num_res2,
																								'RES3'=>$num_res3,
																								'RES4'=>$num_res4,
																								'RES5'=>$num_res5,
																		));
	
	}

		$template->assign_block_vars('block.score',array('SumRES1'=>$evaluate->SumEval($evaluate,$rs['res1'],implode($id,","),'1'),
																	'SumRES2'=>$evaluate->SumEval($evaluate,$rs['res2'],implode($id,","),'1'),
																	'SumRES3'=>$evaluate->SumEval($evaluate,$rs['res3'],implode($id,","),'1'),
																	'SumRES4'=>$evaluate->SumEval($evaluate,$rs['res4'],implode($id,","),'1'),
																	'SumRES5'=>$evaluate->SumEval($evaluate,$rs['res5'],implode($id,","),'1'),
																	));
																	
}
//-------------Question Std-----------------------------//

//-------------Question By user-----------------------//
//get Alternatives



$n=1;
		for($g=0;$g<count($g_id);$g++){
			if($g_id[$g] == $_GET[grp_id]){  
					$gp_name =  $g_name[$g];   
					$group_name .=$g_name[$g]." | ";
			}else{
					$group_name .="<a href=\"numstd.php?grp_id={$g_id[$g]}#QT\"><span class=\"Bcolor\">".$g_name[$g]."</span></a> | ";
					//$gp_name =  $g_name[$g];   
			}
		}
		$template->assign_vars(array('GROUP_NAME'=>$group_name,	));
		if($_GET[grp_id] !=""){
							$gp_id  =$_GET[grp_id];
				}else{
							$gp_id = $g_id[0];
							 $gp_name =  $g_name[0];  
				}
		if($gp_id !=""){
			$template->assign_vars(array('G_NAME'=>$gp_name,  ));
		}else{
			$gp_id=0;
		}
	
	
	   $rowU=$evaluate->GetAlternatives($evaluate,0,$gp_id);
       $numU=$rowU->numRows();
		
		if($numU==0)
			$template->assign_block_vars('nodata_',array('NoData_'=>"$Eval_NOTTeaQues"));

	    while($rsU=@$rowU->fetchRow(DB_FETCHMODE_ASSOC)){
			$template->assign_block_vars('blockU',array( ));
			$row_stdU=$evaluate->GetStandardGroupAlt($evaluate,$rsU['alt_id'],0,$gp_id);
			$row_stdU->numRows();
			for($ii=1;$ii<6;$ii++){
				$res[$ii]=$rsU['res'.$ii];
				$alt[$ii]=$rsU['alt'.$ii];
				$template->assign_block_vars('blockU.block_alt',array('ALT'=>($alt[$ii] !="")?$alt[$ii]."(".$res[$ii].")":"-",
																			));
			}
		//	$a=0;
			$idU=array();
			while($rs_stdU=@$row_stdU->fetchRow(DB_FETCHMODE_ASSOC)){
			//	echo $rs_stdU['question'];
				$idU[$a]=$rs_stdU['q_id'];
				++$a;
				$sql_score=mysql_query("SELECT scores FROM  eval_usrd_answers WHERE q_id =".$rs_stdU['q_id']." AND modules_id=".$evaluate->getModule()."");
				$num_res1=0;
				$num_res2=0;
				$num_res3=0;
				$num_res4=0;
				$num_res5=0;
						while($rs1=mysql_fetch_array($sql_score)){  //while std
							if($rs1['scores']==$rsU['res1'])
								$num_res1=$num_res1+1;
							else if($rs1['scores']==$rsU['res2'])
								$num_res2=$num_res2+1;
							else if($rs1['scores']==$rsU['res3'])
								$num_res3=$num_res3+1;
							else if($rs1['scores']==$rsU['res4'])
								$num_res4=$num_res4+1;
							else if($rs1['scores']==$rsU['res5'])
								$num_res5=$num_res5+1;
							}
						$template->assign_block_vars('blockU.list',array('NO'=>$a,
																												'QUES'=>$rs_stdU['question'],
																												'RES1'=>$num_res1,
																												'RES2'=>$num_res2,
																												'RES3'=>$num_res3,
																												'RES4'=>$num_res4,
																												'RES5'=>$num_res5,
																						));
			}
		$template->assign_block_vars('blockU.score',array('SumRES1'=>$evaluate->SumEval($evaluate,$rsU['res1'],implode($idU,","),'0'),
																			'SumRES2'=>$evaluate->SumEval($evaluate,$rsU['res2'],implode($idU,","),'0'),
																			'SumRES3'=>$evaluate->SumEval($evaluate,$rsU['res3'],implode($idU,","),'0'),
																			'SumRES4'=>$evaluate->SumEval($evaluate,$rsU['res4'],implode($idU,","),'0'),
																			'SumRES5'=>$evaluate->SumEval($evaluate,$rsU['res5'],implode($idU,","),'0'),
																			));
																			
		}

//-------------Question By user-----------------------//
$template->assign_var_from_handle('HEADER','header');
$template->pparse('body');		
?>