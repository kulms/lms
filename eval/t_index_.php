<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************View  Evaluate  Teacher*******************************

		session_unregister("g_name");
		session_unregister("num_C");
		session_unregister("num_F");
		session_unregister("g_id");
 
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);
$a =0; $b=0;
//echo $evaluate->getModule();
//echo $evaluate->getCourse();
//echo $evaluate->getPersonID();
@list($semester,$year,$start_date,$end_date) = $evaluate->getCosDetail($evaluate);
@list($g_id,$g_name) = $evaluate->GetGroupQuestion($evaluate);
@list($score) = $evaluate->computeScore($evaluate,1);
if(count($score) >1){
		for($s=0;$s<count($score);$s++){
				$a= $a +$score[$s];
				$b =$b+ ($score[$s]*$score[$s]);
		}
		$doublenum = count($score)*count($score);		
		$x = $b/(count($score)-1);
		$y = $a/($doublenum-1);
		$z = $x- $y;
		$sd_std = sqrt($z)/100;  // SD OF  STANDARD QUESTION
		$sd_std =round($sd_std,2);
		$sd_std_num =$evaluate->getNumUser($evaluate,1);
}		
//not standard
if(count($score) >1){
		@list($score) = $evaluate->computeScore($evaluate,0);
		for($s=0;$s<count($score);$s++){
				$a= $a +$score[$s];
				$b =$b+ ($score[$s]*$score[$s]);
		}
		//echo $a ." BB==".$b,
		$doublenum = count($score)*count($score);		
		$x = $b/(count($score)-1);
		$y = $a/($doublenum-1);
		$z = $x- $y;
		$sd_notstd= sqrt($z)/100;                // SD OF  TEACHER QUESTION
		$sd_notstd =round($sd_notstd,2);
		$sd_notstd_num = $evaluate->getNumUser($evaluate,0);
		//echo $sd_notstd ;  
}
//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'t_index.html',
														'header'=>'tea_menu.html',                                          
														'body1'=>'res_eval.html',
														'body2'=>'view_ques_std.html',
														'body3'=>'view_ques.html',
														
										));   
// -------------------------------------------------------------------------  Standard  Question
				@list($q_id,$alt_id,$question,$grp_id) = $evaluate->GetStandardQuestion($evaluate,1,'');
				$m=1;
						for($i=0;$i<count($q_id);$i++){
											if($alt_id[$i] !=0){
													 @list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
													$template->assign_block_vars('StdQ', array(
																											'S_GID'=>$grp_id[$i],
																											'S_NUM'=>$m,
																											'S_Question'=>$question[$i],
																											'S_RADIO1'=>($alt1 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res1\"> $alt1":"",
																											'S_RADIO2'=>($alt2 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res2\"> $alt2":"",
																											'S_RADIO3'=>($alt3 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res3\"> $alt3":"",
																											'S_RADIO4'=>($alt4 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res4\"> $alt4":"",
																											'S_RADIO5'=>($alt5 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res5\"> $alt5":"",
																											
																											));
																		$m++;
														}
								}
										
						@list($q_id,$alt_id,$question,$grp_id) = $evaluate->GetStandardQuestion($evaluate,1,1);
									for($i=0;$i<count($q_id);$i++){
												$template->assign_block_vars('Suggest', array(
																									'SG_QUESTION'=>$question[$i],
																									'SG_ID'=>$grp_id[$i],
																									'SG_NUM'=>$m,
																								));
												$m++;
											}
											
					
// ---------------------------------------------------------------------END-----  Standard  Question

// Question from Teacher
			$n=1;
			for($g=0;$g<count($g_id);$g++){
									if($g_id[$g] == $_GET[grp_id]){  
												 $gp_name =  $g_name[$g];   
												 $group_name .=$g_name[$g]." | ";
									  }else{
									  			$group_name .="<a href=\"t_index.php?grp_id={$g_id[$g]}#QT\">".$g_name[$g]."</a> | ";
									  }
				}// closr for Group
				
$template->assign_vars(array('GROUP_NAME'=>$group_name,
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
								if(count($q_id) >0){
											$template->assign_block_vars('GroupQ.QC','');  
										}
									for($i=0;$i<count($q_id);$i++){
										if($alt_id[$i] !=0){
													 @list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
													
													$template->assign_block_vars('GroupQ.QC.Ques', array(
																											'Q_ID'=>$q_id[$i],
																											'Q_NUM'=>$n,
																											'Question'=>$question[$i],
																											'RADIO1'=>($alt1 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res1\"> $alt1":"",
																											'RADIO2'=>($alt2 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res2\"> $alt2":"",
																											'RADIO3'=>($alt3 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res3\"> $alt3":"",
																											'RADIO4'=>($alt4 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res4\"> $alt4":"",
																											'RADIO5'=>($alt5 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" disabled value=\"$res5\"> $alt5":"",
																											
																											));
																				$n++;
																			}
																			
											}// for
								@list($q_id,$alt_id,$question) = $evaluate->GetQuestion($evaluate,$gp_id,2);// Fill Questions
									for($i=0;$i<count($q_id);$i++){
																			
																$template->assign_block_vars('GroupQ.QuesFill', array(
																														'QF_ID'=>$q_id[$i],
																														'QF_NUM'=>$n,
																														'Question'=>$question[$i],
																														));
																$n++;
											}
			


		$template->assign_vars(array('STARTDATE' =>$start_date,  
																'ENDDATE'=>$end_date,
																'YEAR'=>$year,
																'SEMESTER'=>$semester,
																'COURSE' =>$evaluate->getCourse($evaluate),  
																'MODULE_ID'=>$evaluate->getModule($evaluate),
																'CNAME'=>$evaluate->getCourseName($_SESSION[course]),
																'SD1'=>($sd_std !='')?$sd_std:"0.00",
																'PERSON1'=>($sd_std_num !='')?$sd_std_num:"0",
																'SD2'=>($sd_notstd !='')?$sd_notstd:"0.00",
																'PERSON2'=>($sd_notstd_num !='')?$sd_notstd_num:"0",
		
														));
																
																
																
																
$template->assign_var_from_handle('HEADER','header');
$template->assign_var_from_handle('BODY1','body1');
$template->assign_var_from_handle('BODY2','body2');
$template->assign_var_from_handle('BODY3','body3');


$template->pparse('body');							


?>
