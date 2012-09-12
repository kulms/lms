<? 
require("../include/global_login.php");

@list($info,$enddate,$name,$users,$active)=$quiz->getQuizInfo($quiz);

$CheckIfMany = mysql_query("SELECT oneOrMany,validation,quiztype,bgcolor  FROM q_module_prefs WHERE module_id=".$quiz->getModules().";");
$bg=mysql_result($CheckIfMany,0,"bgcolor");
$oneOrMany=mysql_result($CheckIfMany,0,"oneOrMany");
$validation=mysql_result($CheckIfMany,0,"validation");
$quiztype=mysql_result($CheckIfMany,0,"quiztype");
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

	if ($bg==""){
		$bg="white";
	}
$sql=mysql_query("SELECT question_type  FROM q_questions WHERE question_id  = $qid");
$question_type=mysql_result($sql,0,"question_type");

$GetQ=mysql_query("SELECT question, question_type, attached_file,comment FROM q_questions WHERE question_id=$qid;");
$question=mysql_result($GetQ,0,"question");
$question_type=mysql_result($GetQ,0,"question_type");
$attached_file=mysql_result($GetQ,0,"attached_file");
$comment=mysql_result($GetQ,0,"comment");
 if($attached_file !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$attached_file);
									$size_img=$quiz->imageResize($img[0], $img[1], 100);
					 }
if($question_type=='mltc') { //Multiple Choice
	 $ans_mltc = mysql_query("SELECT answer_id as id,answer_des as answers,answer_file as files FROM q_answers WHERE question_id=$qid AND active=1;");
}else if($question_type=='mcit') {  //Matching Item
	$quiz_mcit=mysql_query("SELECT * FROM q_question_mcit WHERE question_id=$qid");
	$ans_mcit=mysql_query("SELECT * FROM q_answer_mcit WHERE question_id=$qid ORDER BY mcit_ans_choice");
}
//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'view.html',
																));
	$template->assign_vars(array('Q_ID'=>$modules,
																'Q_NAME'=>$name,
																'VIEW_T'=>"View Question",
																'LINE'=>"<hr class=colcor1>",
																'CLOSE'=>$strClose,
																'BG'=>$bg,
																'DISPLAY'=>$displaytype,
																'SUBMIT'=>$strSubmit,
																'Q_TYPE'=>$quiztype,
																'VALI'=>$validation,
																'COMMENT'=>$comment,
																'MCIT'=>$strQuiz_MenuAddMatching,
																'Theme'=>$theme,
																'Cnt'=>$cnt,
																'Question'=>$Eval_Num,
																));
			if($question_type=='mltc') { //Multiple Choice
							$template->assign_block_vars('mltc',array('QUES'=>$question,
																												'IMG'=>($attached_file !="")?"<img src=./files/".$attached_file." ".$size_img.">":"",
																						));
							$n=1;
							while($ans_row=mysql_fetch_array($ans_mltc)){
								$files=$ans_row['files'];
								  if($files !=""){
										$allpath="./files";
										$img=getimagesize($allpath."/".$files);
										$size_img=$quiz->imageResize($img[0], $img[1], 100);
								 }
									$template->assign_block_vars('mltc.ans',array('ANS'=>$ans_row['answers'],
																									'IMG'=>($files !="")?"<img src=./files/".$files." ".$size_img.">":"",
																									'NUM'=>$n,
																						));
								$n++;
							}
			}else if($question_type=='fib') { //Fill-in-Blank
						$template->assign_block_vars('fib',array('QUES'=>$question,
																										  'IMG'=>($attached_file !="")?"<img src=./files/".$attached_file." ".$size_img.">":"",
																						));
			}else if($question_type=='tnf') { //True/False
						$template->assign_block_vars('tnf',array('QUES'=>$question,
																										  'IMG'=>($attached_file !="")?"<img src=./files/".$attached_file." ".$size_img.">":"",
																						));
			}else if($question_type=='mcit') {  //Matching Item
						$template->assign_block_vars('mcit',array('QUES'=>$comment,
																										));
						$i=0;
						while($quiz_row=mysql_fetch_array($quiz_mcit)){
							$i++;
							if($quiz_row['attached_file'] !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$quiz_row['attached_file']);
									$size_img=$quiz->imageResize($img[0], $img[1], 100);
							}
							$template->assign_block_vars('mcit.quiz',array('QUIZ'=>$quiz_row['mcit_des'],
																												'IMG'=>($quiz_row['attached_file'] !="")?"<img src=./files/".$quiz_row['attached_file']." ".$size_img.">":"",
																												'NUM'=>$i,
																						));
						}
						while($ans_row=mysql_fetch_array($ans_mcit)){
							if($ans_row['attached_file'] !=""){
									$allpath="./files";
									$img=getimagesize($allpath."/".$ans_row['attached_file']);
									$size_img=$quiz->imageResize($img[0], $img[1], 100);
							}
							$template->assign_block_vars('mcit.ans',array('ANS'=>$ans_row['mcit_ans_des'],
																												'IMG'=>($ans_row['attached_file'] !="")?"<img src=./files/".$ans_row['attached_file']." ".$size_img.">":"",
																												'CHOICE'=>$ans_row['mcit_ans_choice'],
																						));
						}
			}
$template->pparse('body');

?>