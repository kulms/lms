<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
//******************************View  Evaluate  Teacher*******************************
 
$evaluate= new  Evaluate($module_id,$_SESSION[course],$person['id']);

@list($e_name,$modules_id,,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std,$show_rs) = $evaluate->getCosDetail($evaluate);
@list($g_id,$g_name,$g_order) = $evaluate->GetStdGroupQuestion($evaluate);
for($g=0;$g<count($g_id);$g++){ // gg == page   == 1 page
									if($g == $_GET[gg]){  
												$gp_id= $g_id[$g];
												$gg= $g;
												 $gp_name =  $g_name[$g];   
									  }
	}// closr for Group
if($gp_id==""){
				$gp_id = $g_id[0];
				$gp_name =  $g_name[0];  
				$g_order = $g_order[0];
				 $gg =0;
}				

if($_GET[esubmit]==1){  //  submit evaluAte form  ------Insert -------------------------------------------------------------------------------
		//standard
		@list($q_id,$alt_id,$question,$group_id) = $evaluate->GetSTDStandardQuestion($evaluate);
						for($i=0;$i<count($group_id);$i++){
											if($_SESSION["s_ques_gid$group_id[$i]"]== $group_id[$i]){
													if($_SESSION["s_ques_gvalue$group_id[$i]"] !=""){
																$evaluate->InsertAnswer($evaluate,$_SESSION["s_ques_gid$group_id[$i]"],$_SESSION["s_ques_gvalue$group_id[$i]"],'',1);
														}
														session_unregister("s_ques_gid$group_id[$i]");
														session_unregister("s_ques_gvalue$group_id[$i]");
											 }
											  //comment
											  if($_SESSION["comment_id$group_id[$i]"] == $group_id[$i]){
													$evaluate->InsertAnswer($evaluate,$_SESSION["comment_id$group_id[$i]"],'',$_SESSION["comment$group_id[$i]"],1);
													session_unregister("comment_id$group_id[$i]");
													session_unregister("comment$group_id[$i]");
											  } 
						}
		
			// No standard
			for($g=0;$g<count($g_id);$g++){
								//==============CHOICE==============
							@list($q_id,$alt_id,$question) = $evaluate->GetStudentQuestion($evaluate,$g_id[$g],1);
							for($i=0;$i<count($q_id);$i++){
								if($_SESSION["ques_id$q_id[$i]"]== $q_id[$i]){
										if($_SESSION["ques_value$q_id[$i]"] !=""){
												$tr =$evaluate->InsertAnswer($evaluate,$_SESSION["ques_id$q_id[$i]"],$_SESSION["ques_value$q_id[$i]"],'',0);
											}
										session_unregister("ques_id$q_id[$i]");
										session_unregister("ques_value$q_id[$i]");
								}
							}
							
							//========================Fill  Question=========
							@list($q_id,$alt_id,$question) = $evaluate->GetStudentQuestion($evaluate,$g_id[$g],2);
							for($i=0;$i<count($q_id);$i++){
								if($_SESSION["ques_id$q_id[$i]"]== $q_id[$i]){
										if($_SESSION["ques_value$q_id[$i]"] !=""){
												$tr =$evaluate->InsertAnswer($evaluate,$_SESSION["ques_id$q_id[$i]"],'',$_SESSION["ques_value$q_id[$i]"],0);
										}
										session_unregister("ques_id$q_id[$i]");
										session_unregister("ques_value$q_id[$i]");
								}
							}
			}//for
		header("Location: printSuccess.php?m_id=$module_id");
}
		
//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'std_eval.html',    
														'body1'=>'stud_menu.html',  
														'body2'=>'eval_head.html',
														'body3'=>'std_ques_stand.html',
														'body4'=>'std_view_ques.html',
														'body5' =>'suggestion.html', 
														
										)); 
										
										
			if($show_rs == 1){
								$template->assign_block_vars('SHOWMENU', '');
					}
										
// ----------------------------------------------- Standard  Question------session==  g_id
@list($q_id,$alt_id,$question,$grp_id) = $evaluate->GetSTDStandardQuestion($evaluate);
			$m=1;
			$num_comm=1;
			if(count($grp_id) >0){
					$template->assign_block_vars('HaveStd','');
					
			}
			for($i=0;$i<count($grp_id);$i++){
										if($alt_id[$i] !=0){
													 @list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
									if($_SESSION["s_ques_gid$grp_id[$i]"]== $grp_id[$i]){
											if($_SESSION["s_ques_gvalue$grp_id[$i]"] !=""){
															 if($_SESSION["s_ques_gvalue$grp_id[$i]"]==$res1){ 
																		  $C1["$grp_id[$i]"]= "checked";      
															   }else  if($_SESSION["s_ques_gvalue$grp_id[$i]"]==$res2){ 
																		  $C2["$grp_id[$i]"]= "checked";     
															   }else if($_SESSION["s_ques_gvalue$grp_id[$i]"]==$res3){
																		  $C3["$grp_id[$i]"]= "checked";     
															 }else if($_SESSION["s_ques_gvalue$grp_id[$i]"]==$res4){ 
																		  $C4["$grp_id[$i]"] = "checked";      
															   }else if($_SESSION["s_ques_gvalue$grp_id[$i]"]==$res5){ 
																			$C5["$grp_id[$i]"] = "checked";    
																  }
														}
											}
											
													$template->assign_block_vars('HaveStd.StdQ', array(
																											'S_GID'=>$grp_id[$i],
																											'S_QID'=>$q_id[$i],
																											'S_Question'=>$question[$i],
																											'S_RADIO1'=>($alt1 != null)?"<input type=\"radio\" name=\"sqv".$grp_id[$i]."\"  value=\"$res1\" ".$C1["$grp_id[$i]"]."> $alt1":"",
																											'S_RADIO2'=>($alt2 != null)?"<input type=\"radio\" name=\"sqv".$grp_id[$i]."\"  value=\"$res2\"  ".$C2["$grp_id[$i]"]."> $alt2":"",
																											'S_RADIO3'=>($alt3 != null)?"<input type=\"radio\" name=\"sqv".$grp_id[$i]."\"  value=\"$res3\"  ".$C3["$grp_id[$i]"]."> $alt3":"",
																											'S_RADIO4'=>($alt4 != null)?"<input type=\"radio\" name=\"sqv".$grp_id[$i]."\"  value=\"$res4\"  ".$C4["$grp_id[$i]"]."> $alt4":"",
																											'S_RADIO5'=>($alt5 != null)?"<input type=\"radio\" name=\"sqv".$grp_id[$i]."\"  value=\"$res5\"  ".$C5["$grp_id[$i]"]."> $alt5":"",
																											'M'=>$m,
																											'COLOR'=>($i%2==0)?"bgcolor class=\"tdbackground1\" ":"bgcolor class=\"tdbackground3\"",
																											));
																		$m++;
																		
														}else{  //  Have Suggestion
														if(count($g_id) ==0 || $_GET[gg]==count($g_id)-1){
																$template->assign_block_vars('Suggest',array('SG_QUESTION'=>$question[$i],
																														'SG_ID'=>$grp_id[$i],
																														'TEXT'=>($_SESSION["comment_id$grp_id[$i]"]==$grp_id[$i])?$_SESSION["comment$grp_id[$i]"]:"",
																														'NUMC'=>$num_comm,
																		));
																	$num_comm++;
																}
																	
											}
														
							}// for
							

// ----------------------------------------END---  Standard  Question


// Question from Teacher
$template->assign_vars(array('GROUP_NAME'=>$group_name,
																		'G_ORDER'=> $g_order ,
																		'MID'=>$module_id,
																		'GG'=>$gg,
											));


if($gp_id !=""){
$n=1;
		$template->assign_block_vars('GroupQ', array(
																'GID' =>$gp_id,  
																'G_NAME'=>$gp_name,
															)); 
				@list($q_id,$alt_id,$question) = $evaluate->GetStudentQuestion($evaluate,$gp_id,1);
									if(count($q_id) >0){
											$template->assign_block_vars('GroupQ.QC','');  
										}
for($i=0;$i<count($q_id);$i++){
								
						if($alt_id[$i] !=0){
											 @list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id[$i]);
											
											if($_SESSION["ques_id$q_id[$i]"]== $q_id[$i]){
												if($_SESSION["ques_value$q_id[$i]"] !=""){
															 if($_SESSION["ques_value$q_id[$i]"]==$res1){ 
																		  $h1["$q_id[$i]"] = "checked";      
															   }else  if($_SESSION["ques_value$q_id[$i]"]==$res2){ 
																		  $h2["$q_id[$i]"]  = "checked";     
															   }else if($_SESSION["ques_value$q_id[$i]"]==$res3){
																		  $h3["$q_id[$i]"]  = "checked";     
															 }else if($_SESSION["ques_value$q_id[$i]"]==$res4){ 
																		  $h4["$q_id[$i]"]  = "checked";      
															   }else if($_SESSION["ques_value$q_id[$i]"]==$res5){ 
																			$h5["$q_id[$i]"]  = "checked";    
																  }
														}
											}
													$template->assign_block_vars('GroupQ.QC.Ques', array(
																											'Q_ID'=>$q_id[$i],
																											'Q_NUM'=>$n,
																											'Question'=>$question[$i],
																											'RADIO1'=>($alt1 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\"  value=\"$res1\" ".$h1["$q_id[$i]"]."> $alt1":"",
																											'RADIO2'=>($alt2 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\" value=\"$res2\" ".$h2["$q_id[$i]"]."> $alt2":"",
																											'RADIO3'=>($alt3 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\"  value=\"$res3\" ".$h3["$q_id[$i]"]."> $alt3":"",
																											'RADIO4'=>($alt4 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\"  value=\"$res4\" ".$h4["$q_id[$i]"]."> $alt4":"",
																											'RADIO5'=>($alt5 != null)?"<input type=\"radio\" name=\"qv".$q_id[$i]."\"  value=\"$res5\" ".$h5["$q_id[$i]"]."> $alt5":"",
																											'N'=>$n,
																											'COLOR'=>($i%2==0)?"bgcolor class=\"tdbackground1\" ":"bgcolor class=\"tdbackground3\"",
																											));
																							$n++;
																			}
																			
											}// for
											
			@list($q_id,$alt_id,$question) = $evaluate->GetStudentQuestion($evaluate,$gp_id,2);
											if(count($q_id) >0){
														$template->assign_block_vars('GroupQ.QF', '');
												}
								for($z=0;$z<count($q_id);$z++){
																$template->assign_block_vars('GroupQ.QF.QuesFill', array(
																														'QF_ID'=>$q_id[$z],
																														'QF_NUM'=>$n,
																														'Question'=>$question[$z],
																														'ANSWER'=>$_SESSION["ques_value$q_id[$z]"],
																														'N'=>$n,
																											));
																
																		$n++;
													}//for
													
}//if

		$template->assign_vars(array('EVAL_NAME'=>$e_name,
																'EVAL_DETAIL'=>$info,
																'STARTDATE' =>$start_date,  
																'ENDDATE'=>$end_date,
																'YEAR'=>$year,
																'SEMESTER'=>$semester,
																'COURSEID' =>$evaluate->getCourse($evaluate),  
																'MODULE_ID'=>$evaluate->getModule($evaluate),
																'CNAME'=>$evaluate->getCourseName($_SESSION[course]),
																'ALLN'=>$n,
																'ALLM'=>$m,
																'NEXT'=>($gg>-1 && $gg< count($g_id)-1)?"<input type=\"submit\" name=\"pnext\" value=\"NEXT\" class=\"button\">":"",
																'BACK'=>($gg>0)?"<input type=\"submit\" name=\"pback\" value=\"BACK\" class=\"button\">":"",
																'SUBMIT'=>($_GET[gg]==count($g_id)-1)?"<input type=\"submit\" name=\"submit\" value=\"SUBMIT\" class=\"button\">":"",
																'ALLNUMC'=>$num_comm,
																'THEME_NAME'=>$theme,
																'SUBJ_TITLE'=>$strSystem_RMenuCourse,
																'EVAL_title'=>$INFO_EVAL_title,
																'Eval_Num'=>$Eval_Num,
																'Eval_Question'=>$Eval_Question,
																'Eval_Action'=>$Eval_Action,
																'Eval_Score'=>$Eval_Score,
																'Eval_StdQues'=>$Eval_StdQues,
																'Eval_TeaQues'=>$Eval_TeaQues,
																'Eval_AddstdQues'=>$Eval_AddstdQues,
																'Eval_AddGroupQues'=>$Eval_AddGroupQues,
																'FullCharacters'=>$FullCharacters,
																'Eval_AddTeaQues'=>$Eval_AddTeaQues,
																'DESCRIP'=>$Eval_descripe,
																'YEAR_TLTLE'=>$Eval_year,
																'SEME'=>$Eval_semester,
																'STDATE'=>$Eval_startDate,
																'ENDD'=>$Eval_endDate,
																'TITLEDESC'=>$EVALDESCRIPT,
																'RESULT'=>$EVALRESULT ,
																'HOME'=>$HOME_Link,
																'RES_Everage'=>$RES_Everage,
																'RES_Person'=>$RES_Person,
														));
														
												
												if(count($g_id) ==0 && $m >1){   //   IF no  Q from Teacher
														$template->assign_vars(array('SUBMIT'=>"<input type=\"submit\" name=\"submit\" value=\"SUBMIT\" class=\"button\">",
																												));
													}
												if(count($g_id) ==0 && $m==1){   //   IF no  Q from Teacher
														$template->assign_vars(array('NOTDATA'=>$NO_DATA,
																										));
													}
																

$template->assign_var_from_handle('BODY1','body1');
$template->assign_var_from_handle('BODY2','body2');
$template->assign_var_from_handle('BODY3','body3');
$template->assign_var_from_handle('BODY4','body4');
$template->assign_var_from_handle('BODY5','body5');
$template->pparse('body');							


?>