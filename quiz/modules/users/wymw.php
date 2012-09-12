<?
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
if ($id!=""){
	$modules = $id;
}

//---------------getquiz_name
$quizname = mysql_query("SELECT m.name,qp.qlimit,qp.quiztype,qp.endview ,qp.info,qp.view  FROM modules m,q_module_prefs qp  WHERE m.id=$modules AND qp.module_id=$modules;");
	$name = mysql_result($quizname,0,"name");
	$info = str_replace("\n","<br>",mysql_result($quizname,0,"info"));
	$view = mysql_result($quizname,0,"view");
switch($what){
	case 1: //error
		$sql=mysql_query("SELECT uq.question_id  FROM q_user_questions uq ,q_user_answer ua WHERE  uq.user_question_id = ua.user_question_id  AND uq.occasion_id=$occ");
		$Qid=array();
		while($row=mysql_fetch_array($sql)){
			$Qid[]=$row["question_id"];
		}	
		$sql="SELECT q.* FROM q_user_scores ua, q_questions q WHERE ua.occasion_id=$occ AND ua.user_score != ua.question_score AND ua.question_id=q.question_id AND q.question_id IN(".implode($Qid,",").")  ";
		break;
	case 2: //all
		$sql=mysql_query("SELECT uq.question_id  FROM q_user_questions uq ,q_user_answer ua WHERE  uq.user_question_id = ua.user_question_id  AND uq.occasion_id=$occ");
		$Qid=array();
		while($row=mysql_fetch_array($sql)){
			$Qid[]=$row["question_id"];
		}	
		$sql="SELECT q.* FROM q_user_scores ua, q_questions q WHERE ua.occasion_id=$occ AND q.question_id=ua.question_id  AND q.question_id IN(".implode($Qid,",").") ";
		break;
}
$all=mysql_query($sql);
$num=mysql_num_rows($all);

//Page
$pagesize=15;
$totalpage =(int) ($num/$pagesize);
	if (($num % $pagesize) != 0)
		{
			$totalpage += 1;
		}
	if (isset($pageid)){
			$start = $pagesize * ($pageid -1);
	}else{
			$pageid =1;
			$start=0;
	}		
$sql1=$sql." LIMIT $start,$pagesize";
$q_type=array();
$all=mysql_query($sql1);
		while($q_row=mysql_fetch_array($all)){
			$q_name[]=$q_row["question"];
			$q_solution[]=$q_row["solution"];
			$q_id[]=$q_row["question_id"];
			$q_type[]=$q_row["question_type"];
			$q_file[]=$q_row["attached_file"];
			$q_comment[]=$q_row["comment"];
		}
	for($i=0;$i<$num;$i++){
			if ($q_type[$i]=="fib") {
				 $alt=mysql_query("SELECT answer_des as answers FROM q_answers  WHERE question_id=".$q_id[$i]." ");
				$num_alt[]=mysql_num_rows($alt);
						while($answer_row=mysql_fetch_array($alt)){
							 $canswer[$i][]= $answer_row["answers"];
							 $file_ans[$i][]= $answer_row["answer_file"];
						}
			}else if ($q_type[$i]=="mcit"){
				$alt=mysql_query("SELECT q.mcit_des,q.correct,q.attached_file as q_file,a.mcit_ans_des,a.attached_file as a_file FROM q_question_mcit q , q_answer_mcit a  WHERE q.question_id=".$q_id[$i]." AND q.question_id=a.question_id AND q.correct=a.mcit_ans_choice ");
				$num_alt[]=mysql_num_rows($alt);
						while($answer_row=mysql_fetch_array($alt)){
							 $mcit_des[$i][]= $answer_row["mcit_des"];
							 $correct[$i][]= $answer_row["correct"];
							$mcit_file[$i][]= $answer_row["q_file"];
							 $mcit_ans_des[$i][]= $answer_row["mcit_ans_des"];
							$mcit_ans_file[$i][]= $answer_row["a_file"];
						}
			}else if($q_type[$i]=="mltc" || $q_type[$i]=="tnf" ){
				 $alt=mysql_query("SELECT answer_des as answers,answer_file FROM q_answers WHERE question_id=".$q_id[$i]." AND correct=1 AND active=1");
				$num_alt[]=mysql_num_rows($alt);
						while($answer_row=mysql_fetch_array($alt)){
							 $canswer[$i][]= $answer_row["answers"];
							 $file_ans[$i][]= $answer_row["answer_file"];
						}

			} 
		
	}

 //================================================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' => 'quiz_view.html',
															//	'main' =>'quiz_view.html',
																));
$template->assign_vars(array('TEXT' =>"Welcome to Online Quiz" ,
															 'Q_INFO'=>$info,
															 'TEXT3'=>($num ==0)?"$strQuiz_LabNoError":"",
															 'VIEW'=>"<b>The Answer of   ".$name." </b>",
															 'TEXT2'=>($what==1)?"$strQuiz_LabAnswerCorrect":"$strQuiz_LabAnswerCorrectAll",
															 'BACK'=>"<a href=\"?a=stat&m=users&modules=".$quiz->getModules()."&submit=submit\" class=Tmenu>[ $strBack ]</a>",
															 'TOTAL'=>$strQuiz_LabTotal." ".$num." ".$strQuiz_LabQuestion."",
															 'PAGE'=>($num ==0)?"":"<b>$strPage : </b>",
															'LINE'=>'<hr class=colcor1>',
															'Q_NAME'=>$name,
															 ));
for($i=0;$i<$num;$i++){
$count=$i+1;
if($q_type[$i]=="mltc" || $q_type[$i]=="tnf" || $q_type[$i]=="fib" ){
	if($q_solution[$i] == "")
		$q_sol[$i]="-";
	else
		$q_sol[$i]=$q_solution[$i];
	/*if($q_file[$i] !=""){
			list($twidth, $theight, $ttype, $tattr) = getimagesize("./files/$q_file[$i]");
								if($theight >80){
										$twidth= $twidth * 100 / $theight;
										$theight= 80;
								}
						}	*/
	$template->assign_block_vars('errorlist', array(
																	'NUM'	=>$count.".",
																	'Q_NAME'=>$q_name[$i],
																//	'Q_SOLU'=>($q_solution[$i] == "")?"-":"$q_solution[$i]",
																	'Q_PIC'=>($q_file[$i] !="")?"<img src=./files/$q_file[$i] width=100height=70 border=0>":"" ,
																	'SOL'=>($view ==0)?"":"<tr><td>&nbsp;</td><td colspan=2 class=Tmenu><b>วิธีทำ</b></td></tr><tr><td colspan=2 class=Tmenu>&nbsp;</td><td>$q_sol[$i]</td> </tr>",
																));
	for($ii=0;$ii<$num_alt[$i];$ii++){
		$pic[$ii]=$file_ans[$i][$ii];
	/*	if($file_ans[$i][$ii] !=""){
			
				list($twidth, $theight, $ttype, $tattr) = getimagesize("./files/$pic[$ii] ");
									if($theight >80){
											$twidth= $twidth * 70 / $theight;
											$theight= 50;
									}
							}	*/
		$template->assign_block_vars('errorlist.ans', array(																
																	'Q_ANS'=>$canswer[$i][$ii],
																	'Q_ANS_P'=>($file_ans[$i][$ii] !="")?"<img src=./files/$pic[$ii] width=70 height=50 border=0>":"" ,
																));
	}
}else if($q_type[$i]=="mcit"){
	if($q_solution[$i] == "")
		$q_sol[$i]="-";
	else
		$q_sol[$i]=$q_solution[$i];
		$template->assign_block_vars('errorlist', array(
																	'NUM'	=>$count.".",
																	'Q_NAME'=>$q_comment[$i],
																	 'SOL'=>($view ==0)?"":"<tr><td>&nbsp;</td><td colspan=2 class=Tmenu><b>วิธีทำ</b></td></tr><tr><td colspan=2 class=Tmenu>&nbsp;</td><td>$q_sol[$i]</td> </tr>",
																));
		for($ii=0;$ii<$num_alt[$i];$ii++){
			$n=$ii+1;
			$pic[$ii]=$mcit_file[$i][$ii];
			$pic_a[$ii]=$mcit_ans_file[$i][$ii];
		/*if($mcit_file[$i][$ii] !=""){
			
				list($twidth, $theight, $ttype, $tattr) = getimagesize("./files/$pic[$ii] ");
									if($theight >80){
											$twidth= $twidth * 70 / $theight;
											$theight= 50;
									}
							}	
		if($mcit_ans_file[$i][$ii] !=""){
			
				list($twidth, $theight, $ttype, $tattr) = getimagesize("./files/$pic_a[$ii] ");
									if($theight >80){
											$twidth= $twidth * 70 / $theight;
											$theight= 50;
									}
							}	*/
		$template->assign_block_vars('errorlist.ans', array(																
																	'Q_ANS'=>$mcit_des[$i][$ii],
																	'Q_ANS_P'=>($mcit_file[$i][$ii] !="")?"<img src=./files/$pic[$ii] width=70 height=50 border=0>":"" ,
																	'Q_ANS_MCIT'=>"<b>".$correct[$i][$ii].".</b>&nbsp;".$mcit_ans_des[$i][$ii],
																	'Q_ANS_P_MCIT'=>($mcit_ans_file[$i][$ii] !="")?"<img src=./files/$pic_a[$ii] width=70 height=50 border=0>":"" ,
																));
		}
}
}

$template->assign_vars(array('Q_NAME' =>$name ,
																));
//ส่วนนี้เป็นการสร้างไฮเปอร์ลิงค์เพื่อให้ผู้ใช้คลิกดูข้อมูลส่วน (หน้า) อื่นๆ
		for ($i=1; $i<=$totalpage; $i++) {
			 if ($i == $pageid) {
				$template->assign_block_vars('pagerows',array(
																				'PAGE'=>$i
																			));
			 }
			 else {
			 $j= "<a href=\"?a=wymw&m=users&pageid=$i&occ=$occ&what=$what&modules=$modules\">$i</a>&nbsp;";
			 $template->assign_block_vars('pagerows',array(
																				'PAGE'=>$j
																			));
			 }
		}
//$template->assign_var_from_handle('MAIN', 'main');
$template->pparse('body');
?>