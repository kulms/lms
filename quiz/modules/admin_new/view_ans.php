<? 
require("../include/global_login.php");
include('classes/config.inc.php');
//require("header.php");

//==========================================
$quiz_name = mysql_query("SELECT m.name,qp.info,qp.quiztype FROM modules m,q_module_prefs qp WHERE m.id=$modules AND qp.module_id =$modules;");
$quizname = mysql_result($quiz_name,0,"name");

$user_name=mysql_query("SELECT u.firstname ,u.surname  FROM users u,q_occasions o WHERE o.occasion_id =$occ AND u.id=o.user_id");
$firstname = mysql_result($user_name,0,"firstname");
$surname = mysql_result($user_name,0,"surname");

$sql=mysql_query("SELECT DISTINCT question_id  FROM q_user_questions  WHERE  occasion_id=$occ ORDER BY question_id ");
$num_q=mysql_num_rows($sql);
$Q_id=array();
while($row=mysql_fetch_array($sql)){
	$Q_id[]=$row['question_id'];
}

if($num_q != ""){
$sql1="SELECT q.*,uq.user_question_id FROM q_user_questions uq, q_questions q WHERE uq.occasion_id=$occ AND q.question_id=uq.question_id  AND q.question_id IN(".implode($Q_id,",").") ";
$all=mysql_query($sql1);
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
$sql2=$sql1." LIMIT $start,$pagesize";
$all=mysql_query($sql2);
$q_type=array();
		while($q_row=mysql_fetch_array($all)){
			$user_qid[]=$q_row['user_question_id'];
			$q_name[]=$q_row["question"];
			$q_solution[]=$q_row["solution"];
			$q_id[]=$q_row["question_id"];
			$q_type[]=$q_row["question_type"];
			$q_file[]=$q_row["attached_file"];
			$q_comment[]=$q_row["comment"];
		}
}
		for($i=0;$i<$num;$i++){
			if ($q_type[$i]=="tnf" || $q_type[$i]=="mltc") {
				$alt=mysql_query("SELECT a.answer_des as answers,answer_file,choice  FROM q_answers a,q_user_answer ua WHERE ua.user_question_id=".$user_qid[$i]." AND ua.user_answer =a.answer_id ");
				$num_alt[]=mysql_num_rows($alt);
						while($answer_row=mysql_fetch_array($alt)){
							 $canswer[$i][]= $answer_row["answers"];
							 $file_ans[$i][]= $answer_row["answer_file"];
							 $choice[$i][]= $answer_row["choice"];
						}
			}else if ($q_type[$i]=="fib"){
				$alt=mysql_query("SELECT user_answer  as answers FROM q_user_answer  WHERE user_question_id =".$user_qid[$i]." ");
				$num_alt[]=mysql_num_rows($alt);
						while($answer_row=mysql_fetch_array($alt)){
							 $canswer[$i][]= $answer_row["answers"];
						}
			}else if($q_type[$i]=="mcit"){
				$alt=mysql_query("SELECT q.mcit_des,q.correct,q.attached_file as q_file,q.mcit_id,a.mcit_ans_des,a.attached_file as a_file FROM q_question_mcit q , q_answer_mcit a  WHERE q.question_id=".$q_id[$i]." AND q.question_id=a.question_id AND q.correct=a.mcit_ans_choice ORDER BY q.mcit_id ");
				$num_alt[]=mysql_num_rows($alt);
						while($answer_row=mysql_fetch_array($alt)){
							 $mcit_id[$i][]= $answer_row["mcit_id"];
							 $mcit_des[$i][]= $answer_row["mcit_des"];
							 $correct[$i][]= $answer_row["correct"];
							 $mcit_file[$i][]= $answer_row["q_file"];
							 $mcit_ans_des[$i][]= $answer_row["mcit_ans_des"];
							$mcit_ans_file[$i][]= $answer_row["a_file"];
						}
			$sql=mysql_query("SELECT user_answer,mcit_id FROM q_user_answer WHERE user_question_id =".$user_qid[$i]."  ORDER BY mcit_id");
			$num_a=mysql_num_rows($sql);
						while($answer=mysql_fetch_array($sql)){
							$user_answer[$i][]= $answer['user_answer'];
							$a_mcit_id[$i][]= $answer['mcit_id'];
						}
				/*for($a=0;$a<mysql_num_rows($alt);$a++){
					if($mcit_id[$a]==$a_mcit_id[$a]){
						if($correct[$a]==$user_answer[$a])
							$x[$a]=1;
						else
							$x[$a]=0;
					}
				}*/
			}
		}
//==========================================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' => 'quiz_answer.html',));
$template->assign_vars(array('NAME' =>$quizname ,
															'FNAME'=>$firstname,
															'LNAME'=>$surname,
															 'TOTAL'=>"<b>".$strQuiz_LabTotal."  $num ".$strHome_LabAnswer." </b>",
															 'ERROR'=>($num_q==0)?"No Answers":"",
															 'PAGE'=>($num ==0)?"":"<b>".$strPage." : </b>",
															 'CLOSE'=>$strClose,
															 'ANSWER'=>$strHome_LabAnswer."&nbsp;".$strQuiz_LabFor."".$firstname."&nbsp;&nbsp;".$surname,
															 'TAns'=>$strHome_LabAnswer,
															 'Theme'=>$theme,
															 'DEL_'=>($num_quiz !=0)?"1":"0",
															 ));
	for($i=0;$i<$num;$i++){
		$count=$i+1;
		if($q_type[$i]=="mltc" || $q_type[$i]=="tnf" || $q_type[$i]=="fib" ){
				$template->assign_block_vars('errorlist', array(
																	'NUM'	=>$count.".",
																	'Q_NAME'=>$q_name[$i],
																	'Q_PIC'=>($q_file[$i] !="")?"<img src=./files/$q_file[$i] width=100height=70 border=0>":"" ,
																));
				for($ii=0;$ii<$num_alt[$i];$ii++){
					$pic[$ii]=$file_ans[$i][$ii];
					$template->assign_block_vars('errorlist.ans', array(																
																	'Q_ANS'=>$canswer[$i][$ii],
																	'Q_CHOICE'=>($q_type[$i]=="mltc")?$choice[$i][$ii].".":"",
																	'Q_ANS_P'=>($file_ans[$i][$ii] !="")?"<img src=./files/$pic[$ii] width=70 height=50 border=0>":"" ,
																	));
				}
		}else if($q_type[$i]=="mcit"){
					$template->assign_block_vars('errorlist', array(
																	'NUM'	=>$count.".",
																	'Q_NAME'=>$q_comment[$i],
																));

				for($ii=0;$ii<$num_alt[$i];$ii++){
						$n=$ii+1;
						$pic[$ii]=$mcit_file[$i][$ii];
					//	if($x[$i]==0){
					//		$mcit_ans_file[$i][$ii]="";
							$sql="SELECT * FROM q_answer_mcit WHERE mcit_ans_choice='".$user_answer[$i][$ii]."' AND question_id =".$q_id[$i]."";
							$data_sql=mysql_query($sql);
							$num_ans=mysql_num_rows($data_sql);
							$rs_ans=mysql_fetch_array($data_sql);
					//	}
							
						//$pic_a[$ii]=$mcit_ans_file[$i][$ii];
						if($rs_ans['attached_file'] !=""){
							$pic_a=$rs_ans['attached_file'];
						}
						$template->assign_block_vars('errorlist.ans', array(																
																	'Q_ANS'=>$mcit_des[$i][$ii],
																	'Q_ANS_MCIT'=>($user_answer[$i][$ii] != "")?"<b>".$user_answer[$i][$ii].".<b>":"",
																	'Q_ANS_P'=>($mcit_file[$i][$ii] !="")?"<img src=./files/$pic[$ii] width=70 height=50 border=0>":"" ,
																   // 'Q_A_DES'=>($x[$i]==1)?$mcit_ans_des[$i][$ii]:"-",
																	'Q_A_DES'=>($rs_ans['mcit_ans_des']!="")?$rs_ans['mcit_ans_des']:"-",
																	'Q_ANS_P_MCIT'=>($rs_ans['attached_file'] !="")?"<img src=./files/$pic_a width=70 height=50 border=0>":"" ,
																));
				}
		}
	}
//ส่วนนี้เป็นการสร้างไฮเปอร์ลิงค์เพื่อให้ผู้ใช้คลิกดูข้อมูลส่วน (หน้า) อื่นๆ
		for ($i=1; $i<=$totalpage; $i++) {
			 if ($i == $pageid) {
				$template->assign_block_vars('pagerows',array(
																				'PAGE'=>$i
																			));
			 }
			 else {
			 $j= "<a href=\"?a=view_ans&m=admin&pageid=$i&occ=$occ&modules=$modules\">$i</a>&nbsp;";
			 $template->assign_block_vars('pagerows',array(
																				'PAGE'=>$j
																			));
			 }
		}

$template->pparse('body');
?>