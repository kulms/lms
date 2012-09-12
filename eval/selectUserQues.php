<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************View  Evaluate  Teacher*******************************
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);
//echo $gid.'........'.$gname;
//echo $allN."===".$allF;
if(isset($_POST[AddChoice]) || isset($_POST[AddFill])){
		if($gid!= ""){  // have already g_id
					$gp_id = $gid;
		}else{
					$gp_id = $evaluate->AddGroupQ($evaluate,$gname,$_SESSION[module_id]);
		}
	
// add  Choice
if(isset($_POST[AddChoice])){
	for($i=0;$i<$allN;$i++){
						if($_POST["ch".$i] !=""){
									$qid = $_POST["ch".$i]; 
									//echo   $qid , $_POST["ch_active".$i]; 
									@list($q_id,$alt_id,$users_id,,$question,$cat_id,$std_q) =$evaluate->GetQuestionOne($evaluate,$qid);
									if($_POST["ch_active".$i]==1) $active=1;
											else  $active =0;       
														//echo $alt_id."uuu".$users_id."qq==".$question."cat==".$cat_id."std=".$std_q."acti---".$active."<br>";
									$evaluate->InsertQuestion($evaluate,'',$alt_id,$gp_id,$question,$cat_id,$std_q,0,$active);
							}
		}
}
// add Fill Question
if(isset($_POST[AddFill])){
		for($i=0;$i<$allF;$i++){
					if($_POST["fill".$i] !=""){
							$qid =$_POST["fill".$i];  //q_id
							@list($q_id,$alt_id,$users_id,,$question,$cat_id,$std_q) =$evaluate->GetQuestionOne($evaluate,$qid);
									if($_POST["fill_active".$i]==1) $active=1;
											else      $active =0;
												//echo $alt_id."uuu".$users_id."qq==".$question."cat==".$cat_id."std=".$std_q."acti---".$active."<br>";
								$evaluate->InsertQuestion($evaluate,'',$alt_id,$gp_id,$question,$cat_id,$std_q,0,$active);
					}
		}
}
header("Location: t_index.php?grp_id=$gp_id#QT");
}
//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'selectUserQues.html',
														'header'=>'tea_menu.html',                                            
										));   
			
@list($q_id,$alt_id,$question,$active) = $evaluate->GetQuestionOfTeacher($evaluate,1);      // Choice Question
@list($q_id2,$alt_id2,$question2,$active2) = $evaluate->GetQuestionOfTeacher($evaluate,2);   // Fill Question
if(count($q_id) >0)   $start1=1;
if(count($q_id2) >0)  $start2=1;
									
if($action==2){
							$template->assign_block_vars('Start2', '');
							for($i=0;$i<count($q_id2);$i++){
											$template->assign_block_vars('Start2.Suggest',array('SUGGEST'=>$question2[$i],
																									'SG_ID'=>$q_id2[$i],
																									'COLOR'=>($i%2==0)?"bgcolor class=\"tdbackground1\" ":"bgcolor class=\"tdbackground3\"",
																									'CH_CHECK'=>($active2[$i]==1)?"checked":"",
																									'F'=>$i,
																								));
																	
									}
									$allF = $i;
}else{      // Choice Question

				$template->assign_block_vars('Start1', '');
			
			for($i=0;$i<count($q_id);$i++){
										if($alt_id[$i] !=0){
													 @list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
													$template->assign_block_vars('Start1.StdQ', array(
																											'Q_ID'=>$q_id[$i],
																											'N'=>$i,
																											'Question'=>$question[$i],
																											'CH_CHECK'=>($active[$i]==1)?"checked":"",
																											'RADIO1'=>($alt1 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res1\"> $alt1":"",
																											'RADIO2'=>($alt2 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res2\"> $alt2":"",
																											'RADIO3'=>($alt3 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res3\"> $alt3":"",
																											'RADIO4'=>($alt4 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res4\"> $alt4":"",
																											'RADIO5'=>($alt5 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res5\"> $alt5":"",
																											'COLOR'=>($i%2==0)?"bgcolor class=\"tdbackground1\" ":"bgcolor class=\"tdbackground3\"",
																											));
																				//$n++;
														}
						}// for
					$allN = $i;
					
}
		
		
				$link1 ="";
				$link2 = ""; 
				if($start1==1){
						$link1 ="[ <a href=\"selectUserQues.php?action=1&gid=$gid&gname=$gname\">$ChoiceQues</a> ]  &nbsp;";
				}
				 if($start2==1){
						$link2 ="[ <a href=\"selectUserQues.php?action=2&gid=$gid&gname=$gname\">$FillQues</a> ]";
				}
				$template->assign_vars(array('CATEGORY_LINKS'=>$link1."  ".$link2,
																		'GID'=>$gid,
																		'GNAME'=>$gname,
																		'ALLN'=>$allN,
																		'ALLF'=>$allF,
																		'THEME_NAME'=>$theme,
																		'HOME'=>$HOME_Link,
																		'RES_Everage'=>$RES_Everage,
																		'RES_Person'=>$RES_Person,
																		'Check_no_Eval'=>$Check_no_Eval,													
																		'CHOOSE_Q'=>$CHOOSE_Q,
																		'ChoiceQues'=>$ChoiceQues,
																		'FillQues'=>$FillQues,
																		'Eval_Question'=>$Eval_Question,
																		'Eval_Score'=>$Eval_Score,
																		'CHOICE_1'=>$CHOICE_1,
																		'CHOICE_2'=>$CHOICE_2,
																		'CHOICE_3'=>$CHOICE_3,
																		'CHOICE_4'=>$CHOICE_4,
																		'CHOICE_5'=>$CHOICE_5,
			                                        ));
																
$template->assign_var_from_handle('HEADER','header');
$template->pparse('body');							
?>