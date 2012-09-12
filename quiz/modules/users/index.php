<? 
require("../include/global_login.php");
require("header.php");

//echo $quiz->getModules();
$num_out=$quiz->CheckOutTime($quiz); //(1=out of time,0=can quiz)
$num_occ= $quiz->CheckOcc($quiz,$person['id']);  //(0=no,1=yes)
$num_finis= $quiz->CheckFinished($quiz,$person['id']);  //(0=no,1=yes)
$num_quiz_=$quiz->CheckQuizNum_($quiz);       //num quiz all
list($num_quiz)=$quiz->CheckQuizNum($quiz);	// num quiz for use
@list($info,$enddate,$name,$users,$active,$q_type)=$quiz->getQuizInfo($quiz);

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

if($num_occ ==0){
	if($num_out==0)
		if($num_quiz==0)
			$start=-1;   //No num quiz
		else{
			if($num_quiz_<$num_quiz)
				$start=-2;    //num quiz not equal limit
			else{
				if($mcit ==1){
					if($num_mcit==0)
						$start=-3;  // no num mcit
					else
						$start=1;	//start
				}else
					$start=1;	//start	
			}
		}
	else
		$start=2;     //Out of time
}else{
	if($num_out==0){
		if($num_finis==1){
			$start=0;    //continue
			list($occ_id)=$quiz->getOcc($quiz,$person['id']);
		}
	}else{
		$start=2;     //Out of time
	}
}

list($info,$end_date,$name,$users,$active,$quiztype,$view,$endview,$timeLimited,$multiple)=$quiz->getQuizInfo($quiz);
//====================Template=========================
$template= new Template(C_SKIN);	
//if($num_occ ==0){
		$template->assign_vars(array('StartText' =>($start==1)?"<input type=submit name=submit class=button value=".$strQuiz_LabDoStart.">":"" ,
																	'ContinueText'=>($start==0)?"<input type=submit name=submit class=button value=".$strQuiz_LabDoContinue.">":"",
																	'OutOfTime'=>($start==2)?"$strQuiz_LabOutofTime":"",
																	'NoNumQuiz'=>($start==-1)?"$strQuiz_LabNoNumQuiz":"",
																	'NumQuizEqual'=>($start==-2)?"$strQuiz_LabNumQuizEqual":"",
																	'NoNumMcit'=>($start==-3)?"$strQuiz_LabNoNumMcit":"",
																	'Q_NAME'=>$name,
																	'Q_ID'=>$quiz->getModules(),
																	'View'=>$view,
																	'EndView'=>$endview,
																	'TimeLimit'=>$timeLimited,
																	'Multi'=>$multiple,
																	'OccID'=>$occ_id,
																	'Info'=>($info=="")?"-":$info,
																));
//}else{
	
//}
if($num_occ==0){
	$template->set_filenames(array('body' => 'button.html',));$template->pparse('body');
}else{
	if($num_out==0){
		if($num_finis==1){
			$template->set_filenames(array('body' => 'button.html',));$template->pparse('body');
		}else{
			include("stat.php");
		}
	}else{
		$template->set_filenames(array('body' => 'button.html',));$template->pparse('body');
	}
}

?>