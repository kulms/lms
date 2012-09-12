<?
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");

//=====================Query===========================
$quiz=new Quiz('',$modules,$courses);
$num=$quiz->SelectQuizAll($quiz);
$pagesize=10;
@list($page,$totalpage)=$quiz->Page($quiz,$num,$page,$pagesize);			//return action page and totalpage
$result=$quiz->SelectQuiz($quiz,$page,$pagesize);

$CheckIfMany = mysql_query("SELECT oneOrMany,validation,quiztype,bgcolor  FROM q_module_prefs WHERE module_id=".$quiz->getModules().";");
$bg=mysql_result($CheckIfMany,0,"bgcolor");
$oneOrMany=mysql_result($CheckIfMany,0,"oneOrMany");
$validation=mysql_result($CheckIfMany,0,"validation");
$quiztype=mysql_result($CheckIfMany,0,"quiztype");

/*
	if($oneOrMany==1){
		while($rs =mysql_fetch_array($result)){
			$countCorrect = mysql_query("SELECT count(correct) AS corrCount FROM q_answers WHERE correct = 1 AND question_id=".$rs['question_id']." AND active=1;");
			if($corr_row=mysql_fetch_array($countCorrect)){
				if($corr_row["corrCount"] >1){
					$displaytype = "checkbox";
				}else{
					$displaytype = "radio";
				}
			}
		}
	}else{
		$displaytype = "checkbox";
	}
*/

//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array(//'body' =>  'main_menu.html',
																'body'=>'view_all.html'));
		$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																   'QUES_NO'=>$strHome_LabNo,
																   'Q_ID'=>$modules,
																  'Q_NAME'=>$name,
																'CNT'=>$cnt ,
																'UCNT'=>($uCnt =="")?"0":"$uCnt",
																'NUM'=>($num=="")?"0":"$num",
																'PAGE' =>($num !=0)?"<b>".$strPage." : </b>":"" ,
																'T_RESULT'=>$strQuiz_MenuResult,
																'VIEW'=>$strQuiz_MenuResult ,
																'BY'=>"(".$strQuiz_MenuResultByQuestion.")",
																'EDIT'=>$strQuiz_MenuEditPreference,
																'ADD'=>$strQuiz_MenuAddQuestion,
																'ADD1'=>$strQuiz_MenuAddMultipleChoice,
																'ADD2'=>$strQuiz_MenuAddTrueFalse,
																'ADD3'=>$strQuiz_MenuAddMatching,
																'ADD4'=>$strQuiz_MenuAddFilling,
																'SET'=>$strQuiz_MenuSetActive,
																'VIEWQ'=>$strQuiz_MenuViewAdd,
																'SEARCH'=>$strQuiz_MenuSearchQuestion,
																'DEL'=>$strQuiz_MenuDeleteQuiz,
																'RESULT'=>$strQuiz_MenuResult,
																'RESULT1'=>$strQuiz_MenuResultByUser,
																'RESULT2'=>$strQuiz_MenuResultByQuestion,
																'RESULTBY'=>$strQuiz_MenuResult,
																'TOTAL_RUN'=>$strQuiz_LabNrRun,
																'TOTAL_USER'=>$strQuiz_LabUniPart,
																'TOTAL_Q'=>$strQuiz_LabTotalQuestion,
																'OTHER'=>$strQuiz_LabOther,
																'DEL_'=>($num_quiz !=0)?"1":"0",
																 'Theme'=>$theme,
																// 'DISPLAY'=>$displaytype,
																));	
				$i=0;
				while($rs =mysql_fetch_array($result)){
					$i++;
					$qid=$rs['question_id'];
					 $quest=mysql_query("SELECT question, question_type, correct_answer,comment ,attached_file FROM q_questions WHERE question_id=$qid;");
				//	 echo "SELECT question, question_type, correct_answer,comment ,attached_file FROM q_questions WHERE question_id=$qid";
					@$qtype =  mysql_result($quest,0,"question_type");
					@$question=mysql_result($quest,0,"question");
					@$attached_file=mysql_result($quest,0,"attached_file");
					@$comment=mysql_result($quest,0,"comment");
					 if($attached_file !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$attached_file);
									$size_img=$quiz->imageResize($img[0], $img[1], 50);
					 }
							$template->assign_block_vars('list', array('NUM'=>$i.".",
																							'EDIT'=>"<a href=JavaScript:closewin(".$qid.",".$quiz->getModules().");><img src=\"../images/edit4.gif\" border=\"0\" align=\"middle\"></a>",
																							'QID'=>$qid,
																							));
					if($qtype=="fib"){    //Fill-in-Blank
							$sql=mysql_query("SELECT answer_des FROM q_answers WHERE question_id=$qid ");
							$q_c_answer =  mysql_result($sql,0,"answer_des") ;

						//	$stats_t=mysql_query("SELECT count(user_answer_id) as stat FROM q_user_questions q,q_user_answer a WHERE q.question_id=$qid AND a.user_answer='".$q_c_answer."' AND q.occasion_id IN (".implode($all_arr,",").") AND q.user_question_id=a.user_question_id  ;");
						//	 $stats_f=mysql_query("SELECT count(user_answer_id) as stat FROM q_user_questions q,q_user_answer a  WHERE q.question_id=$qid AND a.user_answer<>".$q_c_answer." AND q.occasion_id IN (".implode($all_arr,",").") AND q.user_question_id=a.user_question_id  ;");
						//	@ $ans_t=mysql_result($stats_t,0,"stat");
						//	 @$ans_f=mysql_result($stats_f,0,"stat");
						//	  $t=$ans_t*5;
						//	  $f=$ans_f*5;
							$template->assign_block_vars('list.fib', array('QUES'=>$question,
																													'QUES_F'=>($attached_file !="")?"<br><img src=./files/".$attached_file." ".$size_img.">":"",
																													'CHOICE'=>$q_c_answer,
																													'LINE'=>"<hr class=colcor1>",
																								//					'ANS_T'=>$ans_t,
																								//					'ANS_F'=>$ans_f,
																								//					'CHART_T'=>($ans_t !=0)?"<img align=absbottom src=../images/1.gif width=20 height= ".$t."  alt=Alternative 1 border=0>":"--",
																								//					'CHART_F'=>($ans_f !=0)?"<img align=absbottom src=../images/2.gif width=20 height= ".$f."  alt=Alternative 2 border=0>":"--",
																													'LINE'=>"<hr class=colorLine>",
																														
																							));
							
														
					}
					if ($qtype=="mltc") {  //Multiple Choice
							$ii=0;

							$template->assign_block_vars('list.mltc', array('QUES'=>$question,
																														'QUES_F'=>($attached_file !="")?"<br><img src=./files/".$attached_file." ".$size_img.">":"",
																														'LINE'=>"<hr class=colorLine>",
																							));
						  $all_alt=mysql_query("SELECT answer_id AS id,correct FROM q_answers WHERE question_id=$qid;");
						  $out_alt=mysql_query("SELECT answer_des as answers,answer_file,correct FROM q_answers WHERE question_id=$qid;");
						  //-----Choice
						  while($out_alt_row=mysql_fetch_array($out_alt)){
								$ii++;								
								$detail_choice=$out_alt_row["answers"];
								$detail_file=$out_alt_row["answer_file"];
								
								if($detail_file !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$detail_file);
									$size_img=$quiz->imageResize($img[0], $img[1], 50);
								}
								if($oneOrMany==1){
									$countCorrect = mysql_query("SELECT count(correct) AS corrCount FROM q_answers WHERE correct = 1 AND question_id=$qid AND active=1;");
									if($corr_row=mysql_fetch_array($countCorrect)){
										if($corr_row["corrCount"] >1){
											$displaytype = "checkbox";
										}else{
											$displaytype = "radio";
										}
									}
								}else{
									$displaytype = "checkbox";
								}
								$template->assign_block_vars('list.mltc.choice', array('CHOICE'=>$ii.".",
																																			'DETAIL_C'=>$detail_choice,
																																			'DETAIL_F'=>($detail_file !="")?"<img src=./files/".$detail_file." ".$size_img.">":"",
																																			 'DISPLAY'=>$displaytype,
																																			'CHECKED'=>($out_alt_row['correct']==1)?"checked":"",
																							       ));
						  }
						  //---Chart
						  /*
						  $iii=0;
							while($all_alt_row=mysql_fetch_array($all_alt)){
								$iii++;
								  $stats=mysql_query("SELECT count(a.user_answer_id) as stat FROM q_user_questions q,q_user_answer a WHERE q.question_id=$qid AND a.user_answer=".$all_alt_row["id"]." AND q.occasion_id IN (".implode($all_arr,",").") AND a.user_question_id=q.user_question_id;");
								  while($stats_row=mysql_fetch_array($stats)){
									$stat=$stats_row["stat"];
									$correct=$all_alt_row["correct"];
									$chart=$stat*5;
											$template->assign_block_vars('list.mltc.chart', array('STRT'=>($correct ==1)?"$stat":"$stat",
																																				 'CHART'=>($stat !=0)?"<img src=../images/".$iii.".gif width=20 height=$chart alt=Alternative ".$iii." border=0>":"--",
																																				 'NUM'=>$iii,
																							       ));
								  }
							}
							*/
					}
					if ($qtype=="tnf") {  //True/False
							//$stats_t=mysql_query("SELECT count(a.user_answer_id) as stat FROM q_user_questions q,q_user_answer a ,q_answers ans WHERE q.question_id=$qid AND a.user_answer=ans.answer_id AND ans.choice='a' AND q.occasion_id IN (".implode($all_arr,",").")  AND q.user_question_id=a.user_question_id ;");
							// $stats_f=mysql_query("SELECT count(a.user_answer_id) as stat FROM q_user_questions q,q_user_answer a ,q_answers ans WHERE q.question_id=$qid AND a.user_answer=ans.answer_id AND ans.choice='b' AND q.occasion_id IN (".implode($all_arr,",").")  AND q.user_question_id=a.user_question_id ;");
							//  @$ans_t=mysql_result($stats_t,0,"stat");
						//	  @$ans_f=mysql_result($stats_f,0,"stat");
						//	  $t=$ans_t*5;
						//	  $f=$ans_f*5;
								$GetQ=mysql_query("SELECT * FROM q_questions WHERE question_id=$qid;");
								 $answer=mysql_result($GetQ,0,"correct_answer"); 
								$template->assign_block_vars('list.tnf', array('QUES'=>$question,
																											'QUES_F'=>($attached_file !="")?"<br><img src=./files/".$attached_file." ".$size_img.">":"",
																									//				'ANS_T'=>$ans_t,
																									//				'ANS_F'=>$ans_f,
																									//				'CHART_T'=>($ans_t !=0)?"<img align=absbottom src=../images/1.gif width=20 height= ".$t."  alt=Alternative 1 border=0>":"--",
																									//				'CHART_F'=>($ans_f !=0)?"<img align=absbottom src=../images/2.gif width=20 height= ".$f."  alt=Alternative 2 border=0>":"--",
																												'LINE'=>"<hr class=colorLine>",
																												'SELECT_T'=>($answer=='a')?"checked":"",
																												'SELECT_F'=>($answer=='b')?"checked":"",

																							));
					}
					if($qtype=="mcit"){  //Matching Item
							$template->assign_block_vars('list.mcit', array('QUES'=>$question.".",
																												    'QUES_F'=>($attached_file !="")?"<br><img src=./files/".$attached_file." ".$size_img.">":"",
																														'COMMENT'=>$comment,
																														'LINE'=>"<hr class=colorLine>",
																														));
							// List Question
							$sql_q=mysql_query("SELECT mcit_id,mcit_des,correct,attached_file FROM q_question_mcit WHERE question_id=$qid");
							$mcit_i=0;
							while($row_q=mysql_fetch_array($sql_q)){
								$mcit_i++;
								$mcit_des[]=$row_q['mcit_des'];
								$mcit_id[]=$row_q['mcit_id'];
								$q_mcit_img[]=$row_q['attached_file'];
								
								 if($row_q['attached_file'] !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$row_q['attached_file']);
									$size_img=$quiz->imageResize($img[0], $img[1], 50);
								 }	
								$template->assign_block_vars('list.mcit.quiz', array('NO'=>$mcit_i.".",
																																	'Q_MCIT_D'=>$row_q['mcit_des'],
																																	'Q_MCIT_F'=>($row_q['attached_file'] !="")?"<img src=./files/".$row_q['attached_file']." ".$size_img.">":"",
																																	'CORRECT'=>$row_q['correct'],
																								));
							}
							// List Answer
							$sql_a=mysql_query("SELECT * FROM q_answer_mcit WHERE question_id=$qid ORDER BY mcit_ans_choice");
							$mcit_a=0;
							//$mcit_choice =array() ;
							while($row_a=mysql_fetch_array($sql_a)){
								$mcit_a++;
								$mcit_choice[]=$row_a['mcit_ans_choice'];
								$mcit_des_a=$row_a['mcit_ans_des'];
								$a_mcit_img=$row_q['attached_file'];
								
								 if($a_mcit_img !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$a_mcit_img);
									$size_img=$quiz->imageResize($img[0], $img[1], 50);
								 }	
								$template->assign_block_vars('list.mcit.ans', array('ANS_CHOICE'=>$row_a['mcit_ans_choice'].".",
																																	'A_MCIT_D'=>$mcit_des_a,
																																	'A_MCIT_F'=>($a_mcit_img !="")?"<img src=./files/".$a_mcit_img." ".$size_img.">":"",
																																	
																								));
							}
							//Result
							/*
							$m=1;
							for($q=0;$q<$mcit_i;$q++){
								$a=0;
								$template->assign_block_vars('list.mcit.result', array('NO'=>$m.".",
																																	'Q_MCIT_D'=>$mcit_des[$q],
																								));									
								for($r=0;$r<$mcit_a;$r++){
									$sql=mysql_query("SELECT count(user_answer_id) as stat FROM q_user_answer WHERE mcit_id=$mcit_id[$q] AND user_answer='$mcit_choice[$r]'");
									while($rows=mysql_fetch_array($sql)){
										$a++;
										if($a>6){
											$a=1;
										}
										$stat=$rows['stat'];
										$h=$stat*5;
										$template->assign_block_vars('list.mcit.result.chart', array(
																																						'STRT'=>$stat,
																																						'CHART'=>($stat !=0)?"<img align=absbottom src=../images/".$a.".gif width=20 height= ".$h."  alt=Alternative  ".$a." border=0>":"--",
																																						'CHOICE'=>$mcit_choice[$r],
																																						));
									}
								}
							$m++;
							}
							*/
					}
				}

			if($num !=0){
			//Page
				$prevpage = $page-1;
				$nextpage = $page+1;
				$template->assign_block_vars('page', array(
				'PREV'=>($page>1 && $page<=$totalpage) ?"<a href=\"?a=view_all&m=admin&modules=".$quiz->getModules()."&page=".$prevpage."\"><img src=\"../images/back.gif\" border=0></a>":"",
				'NEXT'=>($page!=$totalpage)?"<a href=\"?a=view_all&m=admin&modules=".$quiz->getModules()."&page=".$nextpage."\"><img src=\"../images/next.gif\" border=0></a>":"",
				'PAGE'=>"[$page/$totalpage]",
																			));
				
				//pagerows
				for ($i=1; $i<=$totalpage; $i++) {
					 if ($i == $page) {
						$template->assign_block_vars('pagerows',array(
																						'PAGE'=>$i
																					));
					 }
					 else {
					 $j= "<a href=\"?a=view_all&m=admin&modules=".$quiz->getModules()."&page=".$i."\">$i</a>&nbsp;";
					 $template->assign_block_vars('pagerows',array(
																						'PAGE'=>$j
																					));
					 }
				}
			}
//$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');

?>