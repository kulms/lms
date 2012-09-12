<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************View  Evaluate  Teacher*******************************
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);

@list($q_id,$alt_id,$question) = $evaluate->GetStandardQuestion($evaluate,false,'');
if(isset($_POST[AddStd])){
			for($i=0;$i<count($q_id);$i++){
					$id_q[$i] = $_POST["check".$q_id[$i]];
					//$_POST["check".$q_id[$i]];
					if($id_q[$i]  !=""){
								//insert In  DB  [ eval_usrd_group] 
								$num =  $evaluate->CheckGroupRepeated($evaluate,$id_q[$i]);
										if($num <0 || $num ==0){
													$g_id[$i] =  $evaluate->AddGroupQ($evaluate,$id_q[$i],$_SESSION[module_id]); //One  Standard Question == one group
										}
				        }
			}
			header("Location: t_index.php");
}
//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'chooseStd.html',
														'header'=>'tea_menu.html',                                            
										));   
										
			$n=1;
			for($i=0;$i<count($q_id);$i++){
										if($alt_id[$i] !=0){
													 @list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
													$template->assign_block_vars('StdQ', array(
																											'Q_ID'=>$q_id[$i],
																											'Q_NUM'=>$n,
																											'Question'=>$question[$i],
																											'RADIO1'=>($alt1 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res1\"> $alt1":"",
																											'RADIO2'=>($alt2 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res2\"> $alt2":"",
																											'RADIO3'=>($alt3 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res3\"> $alt3":"",
																											'RADIO4'=>($alt4 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res4\"> $alt4":"",
																											'RADIO5'=>($alt5 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res5\"> $alt5":"",
																											'COLOR'=>($i%2==0)?"bgcolor class=\"tdbackground1\" ":"bgcolor class=\"tdbackground3\"",
																											));
																				$n++;
											}else{
											$template->assign_block_vars('Suggest',array('SUGGEST'=>$question[$i],
																									'SG_ID'=>$q_id[$i],
																									'COLOR'=>($i%2==0)?"bgcolor class=\"tdbackground1\" ":"bgcolor class=\"tdbackground3\"",
																								));
											}
					}// for


		$template->assign_vars(array('THEME_NAME'=>$theme,
																'HOME'=>$HOME_Link,
																'RES_Everage'=>$RES_Everage,
																'RES_Person'=>$RES_Person,
																'Check_no_Eval'=>$Check_no_Eval,													
																'Eval_Question'=>$Eval_Question,
																'Eval_StdQues'=>$Eval_StdQues,
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