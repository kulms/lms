<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");

$quiz=new Quiz($qid,$modules,$courses);
//@list($page,$totalpage)=$quiz->Page($quiz,$num,$page,);			//return action page and totalpage

$check_if_used=mysql_query("SELECT makecopy FROM q_modules_questions WHERE  module_id=".$quiz->getModules()." AND question_id=$qid ");
//echo "SELECT makecopy FROM q_modules_questions WHERE  module_id=".$quiz->getModules()." AND question_id=$qid";
$makecopy=mysql_result($check_if_used,0,"makecopy");

if($makecopy==1){
	$check_name=mysql_query("SELECT m.name,u.firstname,u.surname,u.email  FROM q_modules_questions mq,modules m,users u WHERE mq.module_id <> ".$quiz->getModules()." AND m.id=mq.module_id AND u.id=m.users AND mq.question_id=$qid AND mq.makecopy=0");
		$c_row=mysql_fetch_array($check_name);
		/*
		Display modulename where question is included
		*/
		$get_course=mysql_query("SELECT wp.courses, c.name,c.fullname ,c.fullname_eng  FROM wp wp,courses c WHERE wp.modules=".$quiz->getModules()." AND wp.courses=c.id  ;");
			while( $get_c_row=mysql_fetch_array($get_course)){
				$courses_no=$get_c_row['name'];
				$courses_nameT=$get_c_row['fullname'];
				$courses_nameE=$get_c_row['fullname_eng'];
			}
		$check_cadmin=mysql_query("SELECT id FROM wp WHERE courses=".mysql_result($get_course,0,"courses")." AND admin=1 AND users=".$person["id"].";");
		if(mysql_num_rows($check_cadmin)!=0){
			$c_admin=1;
		}else{
			$c_admin=0;
		}
	$makecopy=1;
}else{
	$makecopy=0;
}

$GetQ=mysql_query("SELECT * FROM q_questions WHERE question_id=$qid;");
$question=mysql_result($GetQ,0,"question");
$question_type=mysql_result($GetQ,0,"question_type");
$attached_file=mysql_result($GetQ,0,"attached_file");
$real_attached_file=mysql_result($GetQ,0,"real_attached_file");
$cat=mysql_result($GetQ,0,"categories");
$comment=mysql_result($GetQ,0,"comment");
$solution=mysql_result($GetQ,0,"solution");
$score=mysql_result($GetQ,0,"score");
$Active=mysql_result($GetQ,0,"active");
 if($attached_file !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$attached_file);
									$size_img=$quiz->imageResize($img[0], $img[1], 100);
					 }

if($question_type=='mltc') { //Multiple Choice
	 $ans_mltc = mysql_query("SELECT answer_id as id,answer_des as answers,answer_file as files,correct,real_file  FROM q_answers WHERE question_id=$qid AND active=1;");
	$quiz_mltc=mysql_query("SELECT attached_file FROM q_questions WHERE question_id=$qid ");
	/*  if($files !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$files);
									$size_img=$quiz->imageResize($img[0], $img[1], 100);
					 }*/
}else if($question_type=='mcit') {  //Matching Item
	$quiz_mcit=mysql_query("SELECT * FROM q_question_mcit WHERE question_id=".$quiz->getQId()." ");
		$totquestion=mysql_num_rows($quiz_mcit);
	$ans_mcit=mysql_query("SELECT * FROM q_answer_mcit WHERE question_id=".$quiz->getQId()."  ORDER BY mcit_ans_choice");
		$totanswer=mysql_num_rows($ans_mcit);
}else if($question_type=='fib'){
	$sql=mysql_query("SELECT answer_des FROM q_answers WHERE question_id=".$quiz->getQId()." ");
	$answer=mysql_result($sql,0,"answer_des"); 
}

//Select Category
$cat_list = mysql_query("SELECT distinct(category_desc) as categories,category_id FROM q_categories ;");

@list($info,$enddate,$name,$users,$active,$q_type,$view,$endview,$time,$multiple,$grading)=$quiz->getQuizInfo($quiz);
if($grading==1){
	// score mtic,tnf.fib
		$sql="SELECT DISTINCT q.score  FROM q_questions q, q_modules_questions mq, modules m,q_module_prefs i WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id AND m.id=".$quiz->getModules()."  AND i.module_id =".$quiz->getModules()." AND q.question_type !='mcit' ";
		$data_sql=mysql_query($sql);
		$Cscore=mysql_result($data_sql,0,'score');
}

$sql="SELECT mp.pref_id FROM q_modules_questions mq,q_module_prefs mp WHERE mq.question_id=$qid AND mq.module_id=mp.module_id AND mq.makecopy=1 AND mp.grading=1 AND mq.module_id <> ".$quiz->getModules()."";
$result=mysql_query($sql);
$num_rows=mysql_num_rows($result);

//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
															//	'main'=>'quiz_editQuestionMltc.html',
																));
		$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																'Q_ID'=>$quiz->getModules(),
																'Q_NAME'=>$name,
																'VIEW'=>$strQuiz_MenuViewAdd ,
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
																'PAGE' =>($num !=0)?"<b>Page : </b>":"" ,
																//Edit
																'Action'=>($makecopy==0)?"changeQuestions":"sql_copyQ",
																'EDIT_B'=>$strUpdate,
																'RESET_B'=>$strReset,
																'QUES_TEXT'=>$strQuiz_LabQuiz,
																'FILE_TEXT'=>$strQuiz_LabFile,
																'CAT_TEXT'=>$strQuiz_LabCategory,
																'CAT_TEXT1'=>$strQuiz_LabForSearch,
																'ADD_CAT'=>$strAdd." ".$strQuiz_LabCategory,
																'SCORE_T'=>$strQuiz_LabScore,
																'SCORE_T1'=>$strQuiz_LabRecieveScore,
																'SCORE_MCIT'=>$strQuiz_LabScoreByQuiz,
																'CHOICE'=>$strQuiz_LabAlternate,
																'CORRECT'=>$strQuiz_LabCorrectAns,
																'SOL_T'=>$strQuiz_LabSolution,
																'SOL_T1'=>$strQuiz_LabSolutionDisplay,
																'COMMENT_T'=>$strQuiz_LabComment,
																'LINE'=>'<hr class=colcor1>',
																'Q_TYPE'=>$question_type,
																'QUIZ_TYPE'=>$q_type,
																'QUIZ_ID'=>$qid,
																'Makecopy'=>$makecopy,
																'QT'=>$question_type,
																'ANS_TEXT'=>$strQuiz_LabAnswer,
																'TRUE_TEXT'=>$strQuiz_LabAnswerTrue,
																'FALSE_TEXT'=>$strQuiz_LabAnswerFalse,
																'NUM_ONRY'=>$strQuiz_LabNumericOnly,
																'NUM_QUIZ'=>$strQuiz_LabTotalQuestion,
																'NUM_ANS'=>$strQuiz_LabTotalAnswer,
																'Active'=>$strQuiz_LabActive,
																'InActive'=>$strQuiz_LabInActive,
																'Desc'=>$strQuiz_LabDesc,
																'MCIT_ACTIVE'=>$active,
																'CORRECT_ANS'=>$strQuiz_LabCorrectAnswer,
																'CScore'=>($Cscore=="")?"0":$Cscore,
																'FileUpload'=>$strWebboard_LabUpload,
																'Score'=>$score,
																'NumRows'=>$num_rows,
																'Disabled'=>($num_rows !=0)?"disabled":"",
																'QID'=>($qid !="")?"$qid":"",			
													));
				//SelectCategory
				while($row_cat=mysql_fetch_array($cat_list)){
					$cat_id=$row_cat['category_id'];
					$cat_name=$row_cat['categories'];
					$template->assign_block_vars('cat_list',array('CAT_ID'=>$cat_id,
																											  'CAT_NAME'=>$cat_name,
																											  'IS_SELECT'=>($cat==$cat_id)?"selected":"",
																				));
				}
				if($makecopy==1){
						$template->assign_vars(array('Explanation'=>$strQuiz_LabExplanationCopy,
																							'Text_courses'=>$strQuiz_LabCoursesName,
																							'Text_modules'=>$strQuiz_LabModules,
																							'Text_create'=>$strQuiz_LabCreated,
																							));
						$template->assign_block_vars('copy',array('C_NO'=>$courses_no,
																														'C_NAMET'=>($courses_nameT != "")?"$courses_nameT":"",
																														'C_NAMEE'=>($courses_nameE !="")?"($courses_nameE)":"",
																														'M_NAME'=>$c_row["name"],
																														'CREATE'=>$c_row["firstname"]."&nbsp;".$c_row["surname"],
																							));
				}

				if($question_type=='mltc') { //Multiple Choice
							$num1=$quiz->CheckUse($quiz);
							//check_copy
							if($num1 ==0){
								$sql=mysql_query("SELECT * FROM q_modules_questions WHERE module_id <>  ".$quiz->getModules()." AND question_id= ".$quiz->getQId()." AND makecopy =1 ");
								$check_copy=mysql_num_rows($sql);    //1=copy,0=not copy
							}
							$template->set_filenames(array('main'=>'quiz_editQuestionMltc.html',
																							));						
							$template->assign_vars(array('QUES' =>$question ,
																						'IMG'=>($attached_file !="")?"<br><b>".$strQuiz_LabFileOld." : </b>".$real_attached_file."":"",
																						'DEL_P'=>($makecopy==0 && $attached_file !="")?"[$strDeletePic]":"",
																						'SOL'=>$solution,
																						'COMMENT'=>$comment,
																						'SCORE'=>number_format($score),
																						'IS_DISABLED'=>($num1==0)?"":"disabled",
																						'IS_DISABLED1'=>($check_copy==0)?"":"disabled",
																						'DONOT_COPY'=>($num1==0)?"":"$strQuiz_LabDonotCopy",
																						'DONOT_COPY1'=>($check_copy==0)?"":"$strQuiz_LabDonotCopy1",
																						'Old_pic_q'=>mysql_result($quiz_mltc,0,'attached_file'),
																			));						
						
							$alt_count=0;
							while($ans_row=mysql_fetch_array($ans_mltc)){
									$alt_count ++;
									$ans_id=$ans_row['id'];
									$files=$ans_row['files'];
									$template->assign_block_vars('editAns',array('ANS'=>$ans_row['answers'],
																													    'IMG'=>($files !="")?"<img src=/images/upload/".$files." ".$size_img.">":"",
																														'COUNT'=>$alt_count,
																														'DEL_Q'=>($makecopy==0)?"[$strDelete]":"",
																														'DEL_PA'=>($makecopy==0 && $files !="")?"[$strDeletePic]":"",
																														'ANS_ID'=>$ans_id,
																														'CHECKED'=>($ans_row['correct']==1)?"checked":"",
																														'REAT_FILE'=>($ans_row['real_file'] !="")?"<b>$strQuiz_LabFileOld :</b>".$ans_row['real_file']." ":"",
																														'Old_pic_a'=>$ans_row['files'],
																						));
							}

							for($a=$alt_count+1;$a<7;$a++){
								$template->assign_block_vars('addAns',array('COUNT'=>$a,
																								));
							}
			}else if($question_type=='tnf'){   //True/False
					$num1=$quiz->CheckUse($quiz);
					if($num1 ==0){
								$sql=mysql_query("SELECT * FROM q_modules_questions WHERE module_id <>  ".$quiz->getModules()." AND question_id= ".$quiz->getQId()." AND makecopy =1 ");
								$check_copy=mysql_num_rows($sql);    //1=copy,0=not copy
					}
					$answer=mysql_result($GetQ,0,"correct_answer"); 
					$template->set_filenames(array('main'=>'quiz_editQuestionTF.html',));	
					$template->assign_vars(array('QUES' =>$question,
																				'SELECT_T'=>($answer=='a')?"selected":"",
																				'SELECT_F'=>($answer=='b')?"selected":"",
																				'IMG'=>($attached_file !="")?"<br><b>".$strQuiz_LabFileOld." : </b>".$real_attached_file."":"",
																				'DEL_P'=>($makecopy==0 && $attached_file !="")?"[$strDeletePic]":"",
																				'SCORE'=>number_format($score),
																				'SOL'=>$solution,
																				'COMMENT'=>$comment,
																				'IS_DISABLED'=>($num1==0)?"":"disabled",
																				'IS_DISABLED1'=>($check_copy==0)?"":"disabled",
																				'DONOT_COPY'=>($num1==0)?"":"$strQuiz_LabDonotCopy",
																				'DONOT_COPY1'=>($check_copy==0)?"":"$strQuiz_LabDonotCopy1",
																				'Old_pic_q'=>($attached_file !="")?"$attached_file":"",
																				));
			}else if($question_type=='fib'){   //
				$num1=$quiz->CheckUse($quiz);
				if($num1 ==0){
								$sql=mysql_query("SELECT * FROM q_modules_questions WHERE module_id <>  ".$quiz->getModules()." AND question_id= ".$quiz->getQId()." AND makecopy =1 ");
								$check_copy=mysql_num_rows($sql);    //1=copy,0=not copy
					}
				$template->set_filenames(array('main'=>'quiz_editQuestionFib.html',));	
				$template->assign_vars(array('QUES' =>$question,
																			'ANSWER'=>$answer,
																			'IMG'=>($attached_file !="")?"<br><b>".$strQuiz_LabFileOld." : </b>".$real_attached_file."":"",
																			'DEL_P'=>($makecopy==0 && $attached_file !="")?"[$strDeletePic]":"",
																			'SOL'=>$solution,
																			'COMMENT'=>$comment,
																			'SCORE'=>number_format($score),
																			'IS_DISABLED'=>($num1==0)?"":"disabled",
																			'IS_DISABLED1'=>($check_copy==0)?"":"disabled",
																			'DONOT_COPY'=>($num1==0)?"":"$strQuiz_LabDonotCopy",
																			'DONOT_COPY1'=>($check_copy==0)?"":"$strQuiz_LabDonotCopy1",
																			'Old_pic_q'=>($attached_file !="")?"$attached_file":"",
																	));
			}else if($question_type=='mcit'){
				$cat_list = mysql_query("SELECT distinct(category_desc) as categories,category_id FROM q_categories ;");
				 $num1=$quiz->CheckUse($quiz);
				if($num1 ==0){
								$sql=mysql_query("SELECT * FROM q_modules_questions WHERE module_id <>  ".$quiz->getModules()." AND question_id= ".$quiz->getQId()." AND makecopy =1 ");
								$check_copy=mysql_num_rows($sql);    //1=copy,0=not copy
					}
				$template->set_filenames(array('main'=>'quiz_editQuestionMcit_q.htm',));
				$template->assign_block_vars('mcit',array('ACTIVE'=>$active,
																								));
				while($row_cat=mysql_fetch_array($cat_list)){
					$cat_id=$row_cat['category_id'];
					$cat_name=$row_cat['categories'];
					$template->assign_block_vars('mcit.cat_list',array('CAT_ID'=>$cat_id,
																											  'CAT_NAME'=>$cat_name,
																											  'IS_SELECT'=>($cat==$cat_id)?"selected":"",
																				));
				}
				$template->assign_vars(array('TOTAL_QUIZ'=>$totquestion,
																			'SCORE'=>number_format($score),
																			'TOTAL_ANS'=>$totanswer,
																			'DESC'=>$comment,
																			'IS_CHECK_AT'=>($Active==1)?"checked":"",
																			 'IS_CHECK_IAT'=>($Active==0)?"checked":"",
																		     'IS_DISABLED'=>($num1==0)?"":"disabled",
																			'IS_DISABLED1'=>($check_copy==0)?"":"disabled",
																			'DONOT_COPY'=>($num1==0)?"":"$strQuiz_LabDonotCopy",
																			'DONOT_COPY1'=>($check_copy==0)?"":"$strQuiz_LabDonotCopy1",
																	));
				$a=1;$b=1;
				while($row_quiz=mysql_fetch_array($quiz_mcit)){
					$qmcit_id=$row_quiz['mcit_id'];
					$question=$row_quiz['mcit_des'];
					$correct=$row_quiz['correct'];
					$attached_file=$row_quiz['attached_file'];
					$real_attached_file=$row_quiz['real_attached_file'];
					$template->assign_block_vars('quiz_list',array('COUNT'=>$a,
																												'QUES'=>$question,
																												'QMCIT_ID'=>$qmcit_id,
																												'CORRECT'=>$correct,
																												'IMG'=>($attached_file !="")?"<br><b>".$strQuiz_LabFileOld." : </b>".$real_attached_file."":"",
																												'DEL_P'=>($makecopy==0 && $attached_file !="")?"[$strDeletePic]":"",
																												'OLD_PIC'=>($attached_file !="")?$attached_file:"",
																								));
					$a++;
				}
				$choice="a"; 
				while($row_ans=mysql_fetch_array($ans_mcit)){
					$amcit_id=$row_ans['mcit_ans_id'];
					$attached_file=$row_ans['attached_file'];
					$real_attached_file=$row_ans['real_attached_file'];
					$template->assign_block_vars('ans_list',array('CHOICE'=>$choice,
																												 'COUNT'=>$b,
																												'ANS'=>$row_ans['mcit_ans_des'],
																												'AMCIT_ID'=>$amcit_id,
																												'IMG'=>($attached_file !="")?"<br><b>".$strQuiz_LabFileOld." : </b>".$real_attached_file."":"",
																												'DEL_P'=>($makecopy==0 && $attached_file !="")?"[$strDeletePic]":"",
																												'OLD_PIC'=>($attached_file !="")?$attached_file:"",
																									));
					$ascii_choice = ord($choice);
					$ascii_choice++;
					$choice = chr($ascii_choice);	
					$b++;
				}
			}
$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');
?>
