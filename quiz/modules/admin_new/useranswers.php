<?
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
require_once("DB.php");
//=====================Query===========================
$quiz=new Quiz('',$modules,$courses);
$cnt=$quiz->getCountRun($quiz);                                                  //Total number of runs 

$row=$quiz->getCountUser($quiz); 
$uCnt = $row ->numRows();	                                                           //Unique participants

$row=$quiz->getCountNum($quiz);
//$num = $row ->numRows();																//Total question
$num_q = $row ->numRows();															//Total question

	$occclever=array(); $occweak=array();
 $getwp="SELECT COUNT(DISTINCT w.users) as numwp FROM wp w, modules m 
							WHERE m.id=$modules and m.courses = w.courses and
							w.admin=0" ;
 $rsgetwp=mysql_result(mysql_query($getwp),0,"numwp"); 
  // student   register ............................kae


	$cando=mysql_query("SELECT multiple FROM q_module_prefs WHERE module_id=$modules ");
	 $rscando=mysql_result($cando,0,"multiple");


//====================Get Group of clever and weak==========================

 if($rscando==0){
 $sql = "SELECT *
			FROM q_occasions  
			WHERE  module_id =".$quiz->getModules()."
			Order BY user_sum_score DESC ";
			$rsocc=mysql_query($sql);
		  while($perarr=mysql_fetch_array($rsocc)){
		  		$occ_id[]= $perarr[occasion_id] ;
		   		$userid[]=$perarr[user_id]  ;
				$percent[] = number_format(($perarr['user_sum_score']/$perarr['total_score'])*100,2,".",".");
		  		//echo "user".$perarr[user_id]."===".$perarr[user_sum_score]."===".$percent; echo "<br>";
		  }
		  
				$tspercent =round((27/100)*count($userid));
		  		$weakstart = count($userid)-$tspercent;
			for($ii=0;$ii<$tspercent;$ii++){
					$occclever[] =$occ_id[$ii];
					//echo "==clever===".$occ_id[$ii]."====<br>";
			}
			for($ii=$weakstart;$ii<count($userid);$ii++){
					$occweak[] =$occ_id[$ii];
					//echo "==weak===".$occ_id[$ii]."====<br>";
			}
			
				
//echo  "==count clever===".count($occclever);
$allclever = count($occclever);
//echo  "==count weak===".count($occweak);
$allweak = count($occweak);
}



// *************************************************************************************************
$pagesize=5;
//List Question
//$result_=$quiz->ListQuizAll($quiz,$page,$pagesize);
if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}		
	$numRow = " LIMIT ".$start.", ".$pagesize;
	$sql="SELECT DISTINCT mq.question_id as qid FROM q_modules_questions mq, q_user_questions usa, q_occasions o WHERE usa.question_id=mq.question_id AND mq.module_id=".$quiz->getModules()." AND usa.occasion_id=o.occasion_id AND o.module_id=".$quiz->getModules()." ".$numRow." ";
	$result_=mysql_query($sql);
//20/12/2548
//echo $num ."====";
@list($page,$totalpage)=$quiz->Page($quiz,$num_q,$page,$pagesize);			//return action page and totalpage
//echo $totalpage;
$all_occ=mysql_query("SELECT occasion_id AS id from q_occasions WHERE module_id=".$quiz->getModules()." AND finished =1  ORDER BY occasion_id ASC;");
$all_arr=array();
$a=0;
	while($all_row=mysql_fetch_array($all_occ)){
		$all_arr[$a]=$all_row["id"];
		$a++;
	}
//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
																'main'=>'quiz_result.html'));
		$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																   'QUES_NO'=>$strQuiz_LabQuizNo,
																   'Q_ID'=>$modules,
																  'Q_NAME'=>$name,
																'CNT'=>$cnt ,
																'UCNT'=>($uCnt =="")?"0":"$uCnt",
																'NUM'=>($num_q=="")?"0":"$num_q",
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
																'charttitle'=>"Graph show Completion & Dropout",
																'piechart'=>"<img src=./classes/chart.php?all=$rsgetwp&do=$uCnt>",
													
																));	  //echo $rsgetwp,$uCnt;
				if($uCnt !=0){
						$template->assign_block_vars('block',array());
				}else{
						$template->assign_block_vars('error',array('ERROR'=>$strQuiz_LabNoRecord));
				}
				$i=0;
				
				
				while($rs=mysql_fetch_array($result_)){
					$i++;
					  $countall=0;				
			   $countexcellent=0;		
			    $countweak=0;
					
					$qid=$rs['qid'];
					 $quest=mysql_query("SELECT question, question_type, correct_answer,comment ,attached_file FROM q_questions WHERE question_id=$qid;");
					@$qtype =  mysql_result($quest,0,"question_type");
					@$question=mysql_result($quest,0,"question");
					@$attached_file=mysql_result($quest,0,"attached_file");
					@$comment=mysql_result($quest,0,"comment");
					 if($attached_file !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$attached_file);
									$size_img=$quiz->imageResize($img[0], $img[1], 50);
					 }
							$template->assign_block_vars('list', array('NUM'=>$i+$start .".",
																							));
					if($qtype=="fib"){    //Fill-in-Blank
							$sql=mysql_query("SELECT answer_des FROM q_answers WHERE question_id=$qid ");
							$q_c_answer =  mysql_result($sql,0,"answer_des") ;

							$stats_t=mysql_query("SELECT count(user_answer_id) as stat FROM q_user_questions q,q_user_answer a WHERE q.question_id=$qid AND a.user_answer='".$q_c_answer."' AND q.occasion_id IN (".implode($all_arr,",").") AND q.user_question_id=a.user_question_id  ;");
							 $stats_f=mysql_query("SELECT count(user_answer_id) as stat FROM q_user_questions q,q_user_answer a  WHERE q.question_id=$qid AND a.user_answer<>".$q_c_answer." AND q.occasion_id IN (".implode($all_arr,",").") AND q.user_question_id=a.user_question_id  ;");
							@$ans_t=mysql_result($stats_t,0,"stat");
							 @$ans_f=mysql_result($stats_f,0,"stat");
							 
							  $totalstd = $ans_t+$ans_f;
							   $percentage_T = @number_format(($ans_t/$totalstd )*100,2,'.','');
								$chartwidth_T = (150*$percentage_T)/100;
								 $percentage_F = @number_format(($ans_f/$totalstd )*100,2,'.','');
								$chartwidth_F = (150*$percentage_F)/100;
							  $t=$ans_t*5;
							  $f=$ans_f*5;
							$template->assign_block_vars('list.fib', array('QUES'=>$strHome_LabQuestion." :  ".$question.".",
																													'QUES_F'=>($attached_file !="")?"<br><img src=./files/".$attached_file." ".$size_img.">":"",
																													'CHOICE'=>"<span class=red>*</span>$q_c_answer",
																													'LINE'=>"<hr class=colcor1>",
																													'ANS_T'=>$ans_t,
																													'ANS_F'=>$ans_f,
																													'PERCENT_T'=>$percentage_T,
																													'PERCENT_F'=>$percentage_F,
																												  'CHART_T'=>($ans_t !=0)?"<img src=../images/1.gif width=$chartwidth_T  height=15  alt=Alternative 1 border=0>":"--",
																													'CHART_F'=>($ans_f !=0)?"<img src=../images/1.gif width=$chartwidth_F  height=15  alt=Alternative 1 border=0>":"--", 
																													 'COLOR1'=>"class=\"tdbackground\"" ,
																												 	'COLOR2'=>"class=\"tdbackground_white\"",
																													'LINE'=>"<hr class=colorLine>",
																													'totalstd' =>$totalstd,
																							));
							
														
					}
					
					
//--------------------------Multiple Choice---------------Multiple Choice-------------------------------Multiple Choice-------------------------------------------------------
					if ($qtype=="mltc") {  //Multiple Choice
							$ii=0;
							  $totalstd =0;
							$template->assign_block_vars('list.mltc', array('QUES'=>$strHome_LabQuestion." :  ".$question.".",
																												'QUES_F'=>($attached_file !="")?"<br><img src=./files/".$attached_file." ".$size_img." align=absmiddle>":"",
																												'LINE'=>"<hr class=colorLine>",
																							));
						
		 $out_alt=mysql_query("SELECT  answer_id AS id,correct,answer_des as answers,choice,answer_file FROM q_answers WHERE question_id=$qid;");
						
						
	 $totalstd =0;
	  $totalstudent=mysql_query("SELECT count(a.user_answer_id) as total FROM q_user_questions q,q_user_answer a WHERE q.question_id=$qid  AND q.occasion_id IN (".implode($all_arr,",").") AND a.user_question_id=q.user_question_id;");
		$totalstd =mysql_result($totalstudent,0,"total");    //  total student  select this choice
		  $template->assign_vars(array('totalstd' =>$totalstd, ));  
						  //-----Choice
						  while($out_alt_row=mysql_fetch_array($out_alt)){
								$ii++;								
								
								 $detail_choice=$out_alt_row["answers"];
								$detail_file=$out_alt_row["answer_file"];
								
								$stats=mysql_query("SELECT count(a.user_answer_id) as stat FROM q_user_questions q,q_user_answer a WHERE q.question_id=$qid AND a.user_answer=".$out_alt_row["id"]." AND q.occasion_id IN (".implode($all_arr,",").") AND a.user_question_id=q.user_question_id;");
						
								 while($stats_row=mysql_fetch_array($stats)){
										  $stat=$stats_row["stat"];  //echo "====--".
										$correct=$out_alt_row["correct"];
										$totalstd +=$stat;
									}
								if($detail_file !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$detail_file);
									$size_img=$quiz->imageResize($img[0], $img[1], 50);
								}
								
								$percentage = @number_format(($stat/$totalstd )*100,2,'.','');
								$chartwidth = (150*$percentage)/100;

//Distracter Efficiency = (NL – NU)/(NL+NU)======================DE =====================
//NL = ???????????????????????????????????????????? 
//NU = ???????????????????????????????????????????
//????????????????? Distracter Efficiency ???????
if($correct==0  && $rscando==0){
//echo "---qid--".$qid."========$ii<br>";  //  choice wrong
$weakstdnumber[$ii]=0;
$excellentstdnumber[$ii]=0;

for($b=0;$b<count($occweak);$b++){
 $sql1="SELECT a.*,uq.user_question_id 
				FROM q_user_questions uq, q_user_answer ua ,q_answers a
				WHERE uq.occasion_id=".$occweak[$b]." 
				and uq.question_id  =$qid
				and uq.user_question_id =ua.user_question_id
				and ua.user_answer =a.answer_id ";
			$rsans=mysql_query($sql1);
					while($ans=mysql_fetch_array($rsans)){   
								if($out_alt_row["id"]==$ans["answer_id"]){
												 $weakstdnumber[$ii] ++;  
									}
						} 
}//  close for($b
//echo "????????????? ???????????????????? $ii ===".$weakstdnumber[$ii]."??";

for($a=0;$a<count($occclever);$a++){   // ???????? 
 $sql1="SELECT a.*,uq.user_question_id 
				FROM q_user_questions uq, q_user_answer ua ,q_answers a
				WHERE uq.occasion_id=".$occclever[$a]." 
				and uq.question_id  =$qid
				and uq.user_question_id =ua.user_question_id
				and ua.user_answer =a.answer_id ";
			$rsans=mysql_query($sql1);
					while($ans=mysql_fetch_array($rsans)){   
								if($out_alt_row["id"]==$ans["answer_id"]){
												 $excellentstdnumber[$ii] ++;  
									}
							
						} 
}//  close for($b
//echo "  ????????????? ??????????????????? $ii ===".$excellentstdnumber[$ii]."??";
//echo "<br>";
$NL[$ii] =$weakstdnumber[$ii] ;
$NU[$ii] =  $excellentstdnumber[$ii];
$de[$ii] = @number_format(($NL[$ii] -$NU[$ii])/($NL[$ii]+$NU[$ii]),2,'.','');	// 
//echo  $NL[$ii]." - ".$NU[$ii]."<br>";
//echo   "/";
//echo $NL[$ii]." + ".$NU[$ii];
//echo "====DE== ".$de[$ii];   echo "<br>";
}  ////if($correct!=1){

if ($correct ==1){
			for($a=0;$a<count($occclever);$a++){  
							$csql=mysql_query("SELECT s.user_score,s.question_score
																FROM  q_user_scores s
																WHERE s.question_id = $qid
																and   s.occasion_id =".$occclever[$a]."");
						while($rscsql=mysql_fetch_array($csql)){							
											if($rscsql["user_score"]==$rscsql["question_score"]){
															  $countexcellent++;
													 }		
						}
		}  //  close for($a
for($b=0;$b<count($occweak);$b++){
						$wsql=mysql_query("SELECT s.user_score,s.question_score
																FROM  q_user_scores s
																WHERE s.question_id = $qid
																and   s.occasion_id =".$occweak[$b]."");
							while($rswsql=mysql_fetch_array($wsql)){							
											if($rswsql["user_score"] ==$rswsql["question_score"]){
																  $countweak++;
													 }		
						}
}//  close for($b

//echo "??? H ==".$countexcellent."<br>";
//echo "??? L ==".$countweak."<br>";
}   

								$template->assign_block_vars('list.mltc.choice', array('CHOICE'=>($correct ==1)?"<span class=red>*</span>$ii.":"$ii.",
																																			'DETAIL_C'=>$detail_choice,
																																			'DETAIL_F'=>($detail_file !="")?"<img src=./files/".$detail_file." ".$size_img.">":"",
																																			'AMOUNT'=>$stat,
																																			'PERCENT'=>$percentage,
																																			 'CHART'=>($stat !=0)?"<img src=../images/1.gif width=$chartwidth  height=15  alt=Alternative ".$ii." border=0>":"--",
																																			 'COLOR'=>($correct ==1)?"class=\"tdbackground\" ":" class=\"tdbackground_white\"",
																																			 'devalue'=>($correct ==1&&$rscando==0)?"":$de[$ii],
																																			 'H_VALUE'=>($correct ==1&&$rscando==0)?$countexcellent:"",
																																			 'L_VALUE'=>($correct ==1&&$rscando==0)?$countweak:"",
																							  
																							       ));
						  }
		//=============P  &&  R  ========================	
		// p = ( H+L ) /n
		//H = ?????????????????????? (high) ???????????? ???? UP (UPPER)
		//L = ??????????????????????? (low) ????????????? ???? LO (LOWER)
		//n = ??????????????????????????????? (??????????????????)



 if($rscando==0){   //   can do  this quiz only 1 time  
/*
		for($a=0;$a<count($occclever);$a++){  

							$csql=mysql_query("SELECT s.user_score,s.question_score
																FROM  q_user_scores s
																WHERE s.question_id = $qid
																and   s.occasion_id =".$occclever[$a]."");
							
						while($rscsql=mysql_fetch_array($csql)){							
											if($rscsql["user_score"]==$rscsql["question_score"]){
															  $countexcellent++;
													
													 }		
						}
					
		}  //  close for($a
for($b=0;$b<count($occweak);$b++){
						$wsql=mysql_query("SELECT s.user_score,s.question_score
																FROM  q_user_scores s
																WHERE s.question_id = $qid
																and   s.occasion_id =".$occweak[$b]."");
							while($rswsql=mysql_fetch_array($wsql)){							
											if($rswsql["user_score"] ==$rswsql["question_score"]){
																  $countweak++;
															 	
													 }		
						}
}//  close for($b
				  */
//p = ( H+L ) /n	

$pvalue =@number_format(($countexcellent + $countweak)/($allclever+$allweak),2,'.','');	
//echo $pvalue."<br>";
//echo $countexcellent."................................".$countweak."<br>";
//r = ( H- L ) / (n/2)	
$nn =($allclever+$allweak)/2;
$rvalue = @number_format(($countexcellent - $countweak)/$nn,2,'.','');	
		 		$template->assign_block_vars('list.mltc.pr', array('pvalue'=>$pvalue,
																								'rvalue'=>$rvalue,
																));
		

		 }
						
}
					

		//==========END===P  &&  R  ========================				  
					
					
					
					
					if ($qtype=="tnf") {  //True/False
					 $totalstd =0;
							$stats_t=mysql_query("SELECT count(a.user_answer_id) as stat  FROM q_user_questions q,q_user_answer a ,q_answers ans WHERE q.question_id=$qid AND a.user_answer=ans.answer_id AND ans.choice='a' AND q.occasion_id IN (".implode($all_arr,",").")  AND q.user_question_id=a.user_question_id ;");
							 $stats_f=mysql_query("SELECT count(a.user_answer_id) as stat FROM q_user_questions q,q_user_answer a ,q_answers ans WHERE q.question_id=$qid AND a.user_answer=ans.answer_id AND ans.choice='b' AND q.occasion_id IN (".implode($all_arr,",").")  AND q.user_question_id=a.user_question_id ;");
							 $stats_cor=mysql_query("SELECT DISTINCT ans.choice,ans.correct FROM q_user_questions q,q_user_answer a ,q_answers ans WHERE q.question_id=$qid AND a.user_answer=ans.answer_id  AND q.occasion_id IN (".implode($all_arr,",").")  AND q.user_question_id=a.user_question_id ORDER BY ans.choice ASC  ;");
				//echo "SELECT DISTINCT ans.choice,ans.correct FROM q_user_questions q,q_user_answer a ,q_answers ans WHERE q.question_id=$qid AND a.user_answer=ans.answer_id  AND q.occasion_id IN (".implode($all_arr,",").")  AND q.user_question_id=a.user_question_id ORDER BY ans.choice ASC  ;";
							  @$ans_t=mysql_result($stats_t,0,"stat");
							  @$ans_f=mysql_result($stats_f,0,"stat");
									  @$cor_A=mysql_result($stats_cor,0,"correct");
									@$cor_B=mysql_result($stats_cor,1,"correct");
									
									//  echo @$ch_A=mysql_result($stats_cor,0,"choice"); echo "===".$cor_A;
									// echo	@$ch_B=mysql_result($stats_cor,1,"choice");echo "===".$cor_B;
									 $totalstd = $ans_t+$ans_f;
							  $t=$ans_t*5;
							  $f=$ans_f*5;
							  $percentage_T = @number_format(($ans_t/$totalstd )*100,2,'.','');
								$chartwidth_T = (150*$percentage_T)/100;
								 $percentage_F = @number_format(($ans_f/$totalstd )*100,2,'.','');
								$chartwidth_F = (150*$percentage_F)/100;
								$template->assign_block_vars('list.tnf', array('QUES'=>$strHome_LabQuestion." :  ".$question.".",
																											'QUES_F'=>($attached_file !="")?"<br><img src=./files/".$attached_file." ".$size_img.">":"",
																													'ANS_T'=>$ans_t,
																													'ANS_F'=>$ans_f,
																													'PERCENT_T'=>$percentage_T,
																													'PERCENT_F'=>$percentage_F,
																												  'CHART_T'=>($ans_t !=0)?"<img src=../images/1.gif width=$chartwidth_T  height=15  alt=Alternative 1 border=0>":"--",
																													'CHART_F'=>($ans_f !=0)?"<img src=../images/1.gif width=$chartwidth_F  height=15  alt=Alternative 1 border=0>":"--", 
																												 'COLOR1'=>($cor_A ==1)?"class=\"tdbackground\" ":" class=\"tdbackground_white\"",
																												 'COLOR2'=>($cor_B ==1)?"class=\"tdbackground\" ":" class=\"tdbackground_white\"",
																													'LINE'=>"<hr class=colorLine>",
																													'totalstd' =>$totalstd,
																							));
																			
					}
					if($qtype=="mcit"){  //Matching Item
							$template->assign_block_vars('list.mcit', array('QUES'=>$strHome_LabQuestion." :  ".$question.".",
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
							$m=1;
							for($q=0;$q<$mcit_i;$q++){
								$a=0;  
								 $totalmcit[$q] =0;
								for($r=0;$r<$mcit_a;$r++){
									$sql=mysql_query("SELECT count(user_answer_id) as stat FROM q_user_answer WHERE mcit_id=$mcit_id[$q] AND user_answer='$mcit_choice[$r]'");
									 @$totalm=mysql_result($sql,0,"stat");
									 $totalmcit[$q] +=$totalm;
									}
						
								$template->assign_block_vars('list.mcit.result', array('NO'=>$m.".",
																																'Q_MCIT_D'=>$mcit_des[$q],
																																'totalstd'=>$totalmcit[$q],
																								));									
																								
																								
								for($r=0;$r<$mcit_a;$r++){
									$sql=mysql_query("SELECT count(user_answer_id) as stat FROM q_user_answer WHERE mcit_id=$mcit_id[$q] AND user_answer='$mcit_choice[$r]'");
											$sqlrs=mysql_query("SELECT correct FROM q_question_mcit WHERE mcit_id=$mcit_id[$q]");
											 @$cor_mltc=mysql_result($sqlrs,0,"correct");
									
									while($rows=mysql_fetch_array($sql)){
										$a++;
										if($a>6){
											$a=1;
										}
										$stat=$rows['stat'];
										$h=$stat*5;
										
										  $percentage_T = @number_format(($stat/$totalmcit[$q] )*100,2,'.','');
										$chartwidth_T = (150*$percentage_T)/100;
								
										$template->assign_block_vars('list.mcit.result.chart', array('STRT'=>$stat,
																																				'CHOICE'=>($cor_mltc ==$mcit_choice[$r])?"<span class=red>*</span>$mcit_choice[$r]":$mcit_choice[$r],
																																				'PERCENT'=>$percentage_T,
																																				 'CHART'=>($stat !=0)?"<img src=../images/1.gif width=$chartwidth_T  height=15  alt=Alternative 1 border=0>":"--",
																																				'COLOR2'=>($cor_mltc ==$mcit_choice[$r])?"class=\"tdbackground\" ":" class=\"tdbackground_white\"",
																										));
									}
									
								}
							$m++;
							}
					}
				}

			if($num_q !=0){  
			//Page
				$prevpage = $page-1;
				$nextpage = $page+1;
				$template->assign_block_vars('page', array(
				'PREV'=>($page>1 && $page<=$totalpage) ?"<a href=\"?a=useranswers&m=admin&modules=".$quiz->getModules()."&page=".$prevpage."\"><img src=\"../images/back.gif\" border=0></a>":"",
				'NEXT'=>($page!=$totalpage)?"<a href=\"?a=useranswers&m=admin&modules=".$quiz->getModules()."&page=".$nextpage."\"><img src=\"../images/next_.gif\" border=0></a>":"",
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
					 $j= "<a href=\"?a=useranswers&m=admin&modules=".$quiz->getModules()."&page=".$i."\">$i</a>&nbsp;";
					 $template->assign_block_vars('pagerows',array(
																						'PAGE'=>$j
																					));
					 }
				}
			}
$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');
?>