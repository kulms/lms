<? 
require("../include/global_login.php");
include('classes/config.inc.php');
if($submit =='submit')
	require("header.php");
if ($id!=""){
	$modules = $id;
}
list($num_quiz)=$quiz->CheckQuizNum($quiz);
//---------------getquiz_name
$quizname = mysql_query("SELECT m.name,qp.qlimit,qp.quiztype,qp.endview,qp.view,qp.info,qp.multiple,qp.timeLimited,qp.timeLimit FROM modules m,q_module_prefs qp  WHERE m.id=$modules AND qp.module_id=$modules;");
	$name = mysql_result($quizname,0,"name");
	$info = str_replace("\n","<br>",mysql_result($quizname,0,"info"));
	$qlimit=mysql_result($quizname,0,"qlimit");
	$quiztype=mysql_result($quizname,0,"quiztype"); 		//1=Survey , 0=quiz
	$multiple=mysql_result($quizname,0,"multiple");
	$endview=mysql_result($quizname,0,"endview");
	$view=mysql_result($quizname,0,"view");
	$timeLimited=mysql_result($quizname,0,"timeLimited");
	$timeLimit=mysql_result($quizname,0,"timeLimit");
	$GetUser = mysql_query("SELECT firstname, surname FROM users WHERE id=".$person["id"].";");
	$user_row=mysql_fetch_array($GetUser);
	$user=mysql_result($GetUser,0,"firstname")."&nbsp;".mysql_result($GetUser,0,"surname");


//Decide what comment to display to the user
switch($multiple){
	case "0":
		$comment = $strQuiz_LabSeveralComment."<br>";
		break;
	case "1":
		//29/03/05
			//check mcit
			$sql="SELECT matching FROM q_module_prefs WHERE module_id=".$quiz->getModules()."";
			$result=mysql_query($sql);
			$mcit=mysql_result($result,0,'matching');
			if($mcit ==1){
				$sql="SELECT q.* FROM q_questions q,q_modules_questions  mq WHERE mq.module_id=".$quiz->getModules()." AND mq.question_id=q.question_id AND q.question_type='mcit' ";
				$result=mysql_query($sql);
				$num_mcit=mysql_num_rows($result);
			}
		// end 29/03/05
		if($mcit ==1){
			if($num_mcit==0)
				$comment = "<p>".$strQuiz_LabNoNumMcit."<br>";
			else
				$comment = "<p>".$strQuiz_LabAgainComment."<br>";
		}else
			$comment = "<p>".$strQuiz_LabAgainComment."<br>";

		$target="ws_main";
		if($num_quiz !=0){
			if($mcit ==1){
				if($num_mcit==0)
					$comment .= "<form action=\"?a=main&m=users&id=$modules\" target=\"$target\" method=\"post\"><input type=\"submit\" name=\"skip1\" value=\" Y E S \" disabled></form>";
				else
					$comment .= "<form action=\"?a=main&m=users&id=$modules\" target=\"$target\" method=\"post\"><input type=\"submit\" name=\"skip1\" value=\" Y E S \" class=\"button\"></form>";
			}else
			$comment .= "<form action=\"?a=main&m=users&id=$modules\" target=\"$target\" method=\"post\"><input type=\"submit\" name=\"skip1\" value=\" Y E S \" class=\"button\"></form>";
		}else{
			$comment .= "<form action=\"?a=main&m=users&id=$modules\" target=\"$target\" method=\"post\"><input type=\"submit\" name=\"skip1\" value=\" Y E S \" disabled></form>";
		}
		break;
}
if($quiztype==0){
if($occ != ""){
//Submit ����ա�õ�Ǩ����
if($endview==2){
		$SqlStmt =mysql_query( "SELECT sum(user_score) AS Total  FROM q_user_scores WHERE occasion_id =$occ ;");
		$TotalScore = mysql_result($SqlStmt,0,"Total");
		//update q_occasions finished 
		 $d1=date('Y-m-d h:i:s');
		mysql_query("UPDATE q_occasions SET finished=1, finished_datetime='".$d1."',user_sum_score='".$TotalScore."' WHERE occasion_id=$occ;"); 
} /*�ѧ����ա�õ�Ǩ */else{
	//check answer
	$sel=mysql_query("SELECT question_id FROM q_user_questions  WHERE occasion_id=$occ");
	$num=mysql_num_rows($sel);
	while($rows=mysql_fetch_array($sel)){
		$q_id[]=$rows['question_id'];
	}
	if(mysql_num_rows(mysql_query("SELECT occasion_id FROM q_user_scores WHERE occasion_id=$occ ")) == ""){
		for($i=0;$i<$num;$i++){
			$sql=mysql_query("SELECT score,question_type FROM q_questions WHERE question_id=$q_id[$i]");
			$score_cor[$i]=mysql_result($sql,0,"score");
			$question_type[$i]=mysql_result($sql,0,"question_type");
			$sql1=mysql_query("SELECT a.user_answer FROM q_user_answer a,q_user_questions q WHERE  q.occasion_id=$occ  AND q.question_id=$q_id[$i] AND a.user_question_id=q.user_question_id ");
			$sql2=mysql_query("SELECT answer_id,answer_des FROM q_answers WHERE question_id=$q_id[$i] AND correct=1");
				if($question_type[$i] == mltc || $question_type[$i] == tnf  ){
								$num_sql1[$i]=mysql_num_rows($sql1);
									while($row1=mysql_fetch_array($sql1)){
										 $user_ans[$i][]=$row1['user_answer'];
									 }
								$num_sql2[$i]=mysql_num_rows($sql2);
									while($row2=mysql_fetch_array($sql2)){
										 $ans_cor[$i][]=$row2['answer_id'];
									}
								$n=0;
								if($num_sql1[$i]==$num_sql2[$i]){
									for($ii=0;$ii<$num_sql1[$i];$ii++){
										for($iii=0;$iii<$num_sql2[$i];$iii++){
											if($user_ans[$i][$ii]== $ans_cor[$i][$iii]){
											  $n=$n+1;
											}
										}
									}
									if($n==$num_sql2[$i]){
										 $score[$i]=$score_cor[$i];
									}else{
										 $score[$i]=0.00;
									}
								} //end if
								else{
									$score[$i]=0.00;
								}
						//Insert tb q_user_scores
						$sql_score=mysql_query("INSERT INTO q_user_scores (question_id,occasion_id,user_score,question_score) VALUES ($q_id[$i],$occ,$score[$i],$score_cor[$i])");				
				}/* end if mltc and fnf */ else if($question_type[$i] == fib){
						$user_ans=mysql_result($sql1,0,"user_answer");
						$ans_cor=mysql_result($sql2,0,"answer_des");
						if($user_ans==$ans_cor)
							 $score=$score_cor[$i];
						else
							$score=0.00;
						//Insert tb q_user_scores
						$sql_score=mysql_query("INSERT INTO q_user_scores (question_id,occasion_id,user_score,question_score) VALUES ($q_id[$i],$occ,$score,$score_cor[$i])");	
				}/* end if fib */else if($question_type[$i] == mcit){
					$score=0;
					$Tscore=0;
						$sql=mysql_query("SELECT mcit_id,correct FROM q_question_mcit WHERE question_id=$q_id[$i] ORDER BY mcit_id ");
						 $num2=mysql_num_rows($sql);
						while($row=mysql_fetch_array($sql)){
							$mcit_id[]=$row['mcit_id'];
							$correct[]=$row['correct'];
						}
						$sql_check=mysql_query("SELECT a.user_answer,a.mcit_id FROM q_user_answer a,q_user_questions q WHERE  q.occasion_id=$occ  AND q.question_id=$q_id[$i] AND a.user_question_id=q.user_question_id ORDER BY mcit_id");
						while($row_check=mysql_fetch_array($sql_check)){
							$mcit_ans_id[]=$row_check['mcit_id'];
							$answer[]=$row_check['user_answer'];
						}
						for($ii=0;$ii<$num2;$ii++){
							if($mcit_id[$ii]==$mcit_ans_id[$ii]){
								if($correct[$ii]==$answer[$ii])
									$score=$score_cor[$i];
								else
									$score=0.00;
							 $Tscore=$Tscore+$score;
							}
						}
						$Tscore_cor=$score_cor[$i] * $num2 ;
						$sql_score=mysql_query("INSERT INTO q_user_scores (question_id,occasion_id,user_score,question_score) VALUES ($q_id[$i],$occ,$Tscore,$Tscore_cor)");	
				}/* end if mcit */
		}// end fo
		$num1=mysql_num_rows(mysql_query("SELECT occasion_id  FROM q_occasions WHERE occasion_id=$occ AND finished =1"));
		 if($num1 ==0){
			$SqlStmt =mysql_query( "SELECT sum(user_score) AS Total  FROM q_user_scores WHERE occasion_id =$occ ;");
			$TotalScore = mysql_result($SqlStmt,0,"Total");
			//Update  finished
			 $d1=date('Y-m-d h:i:s');
			mysql_query("UPDATE q_occasions SET finished=1, finished_datetime='".$d1."',user_sum_score='".$TotalScore."' WHERE occasion_id=$occ;"); 
		 }
	}
}
}

	//Get total score for this quiz and user from db
$get_occasion=mysql_query("SELECT occasion_id as id   FROM q_occasions  WHERE user_id = ".$person["id"]." AND module_id=$modules  ORDER BY occasion_id ASC;");
$num_row=mysql_num_rows($get_occasion);
$occ_arr=array();
$a=0;
while($occ_row=mysql_fetch_array($get_occasion)){
	$occ_arr[$a]=$occ_row["id"];
	$a++;
}	

$SqlStmt = "SELECT finished_datetime as times,total_score,user_sum_score as user_score  FROM q_occasions WHERE occasion_id IN(".implode($occ_arr,",").") ;";
$score = mysql_query($SqlStmt);
	while($top_row=mysql_fetch_array($score)){	
			$dates[] =$top_row['times'];
			$TotalUserScore[] =(($top_row["user_score"] / $top_row["total_score"])*100);
	}

//average
$average_t=0;
$top=0;
for($i=0;$i<=$num_row;$i++){
	$average_t=$average_t+$TotalUserScore[$i];
	if($top < ($TotalUserScore[$i]))
		$top =$TotalUserScore[$i];
}
$average=number_format($average_t / $num_row,2,'.','');
$userCount = mysql_query("SELECT DISTINCT user_id FROM q_occasions WHERE module_id=$modules;");
$uCnt = mysql_num_rows($userCount);	
//}
}else{
//Update  finished (Survey)
$d1=date('Y-m-d h:i:s');
mysql_query("UPDATE q_occasions SET finished=1, finished_datetime='".$d1."' WHERE occasion_id=$occ;"); 
}

$GetUser = mysql_query("SELECT firstname, surname FROM users WHERE id=".$person["id"].";");
$user_row=mysql_fetch_array($GetUser);
$user=mysql_result($GetUser,0,"firstname")."&nbsp;".mysql_result($GetUser,0,"surname");
mysql_close($conn);
//=========================================================
 $template= new Template(C_SKIN);	
$template->set_filenames(array( //'body' => 'main_menu_s.html',
																'body'=>($quiztype==0)?'quiz_score.html':'quiz_survey.html',));
$template->assign_vars(array('TEXT' =>"Welcome to Online Quiz" ,
																	'VIEW'=>"<a name=Top></a><b>Total Score For&nbsp;&nbsp;[".$user."]</b>",
																	'QUESTION'=>$question,
																	 'Q_INFO'=>$info,
																	 'MODULE'=>$modules,
																	 'S_ANV'=>$average,
																	 'TOP'=>number_format($top,2,'.',''),
																	 'UCNT'=>$uCnt,
																	 'CNT'=>$num_row,
																	 'COMMENT'=>$comment,
																	 'TOTAL_SCORE'=>$strQuiz_LabTotalScore,
																	 'FOR'=>$strQuiz_LabFor,
																	 'UserName'=>$user,
																	 'OCC'=>$strQuiz_LabOccasion,
																	 'SCORE'=>$strQuiz_LabScore,
																	 'AVERAGE'=>$strQuiz_LabAverage,
																	 'TOP_SCORE'=>$strQuiz_LabTopScore,
																	 'UniPart'=>$strQuiz_LabUniPart,
																	 'NrRun'=>$strQuiz_LabNrRun,
																	 'Survey'=>$strQuiz_LabQuestion."".$strQuiz_LabFor."".$strQuiz_LabSurvey,
																	 'Taken'=>$strQuiz_LabTaken,
																	));

for($ii=0;$ii<$num_row;$ii++){
	$template->assign_block_vars('scorelist', array(
																	'S_DATE'	=>$dates[$ii],
																	'S_U_TOTAL'=>number_format($TotalUserScore[$ii],2,'.',''),
																	'BG'=>($top==$TotalUserScore[$ii])?"tdbackground":"tdbackground1",
																	'VIEW_ER'=>($quiztype==0 && $endview !=0)?"[View: <a class=mini href=?a=wymw&m=users&occ=". $occ_arr[$ii]."&what=1&modules=".$modules.">errors</a> | <a class=mini href=?a=wymw&m=users&occ=". $occ_arr[$ii]."&what=2&modules=".$modules.">all</a>]":"",
																));

}
//$template->assign_var_from_handle('MAIN', 'main');
$template->assign_vars(array('Q_NAME' =>$name ,
																	));
$template->pparse('body');
?>