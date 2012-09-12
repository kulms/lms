<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
$quiz=new Quiz('',$modules,$courses);
$cnt=$quiz->getCountRun($quiz);                                                  //Total number of runs 

$row=$quiz->getCountUser($quiz); 
$uCnt = $row ->numRows();	                                                  //Unique participants

$num_out=$quiz->CheckOutTime($quiz); //(1=out of time,0=can quiz)
list($info,$end_date, $name,$users,$active,$quiztype,$view,$endview,$timeLimited,$multiple)=$quiz->getQuizInfo($quiz);
$pagesize=30;
@list($page,$totalpage)=$quiz->Page($quiz,$num,$page,$pagesize);			//return action page and totalpage

if($uCnt !=0){
	$anysql=mysql_query("SELECT occasion_id as id from q_occasions WHERE module_id=$modules;");
	$any_select=array();
	$a=0;
	if(mysql_num_rows($anysql)!=0){
		while($any_row=mysql_fetch_array($anysql)){
			$any_select[$a]=$any_row["id"];
			$a++;
		}
		//$Cscore = mysql_query("SELECT sum(user_score) AS TotalUserScore FROM q_user_scores WHERE occasion_id IN(".implode($any_select,",").");");

	//	$avg = mysql_query("SELECT DISTINCT occasion_id FROM q_user_scores WHERE occasion_id IN(".implode($any_select,",").");");
	//	$cnt = mysql_num_rows($avg);
    //    //
   //     if ($cnt==0) $cnt=1;
	//	$average = mysql_result($Cscore,0,"TotalUserScore")/$cnt;
//		$average=number_format($average,2,",",".");

			//Get Top Score for this module
		$top=0;
		$Maximum = mysql_query("SELECT  user_sum_score , total_score FROM q_occasions WHERE occasion_id IN(".implode($any_select,",").") GROUP BY occasion_id;");
		while($max_row=mysql_fetch_array($Maximum)){
		 $max_percent = number_format(($max_row['user_sum_score']/$max_row['total_score'])*100,2,'.','');
			if($top < $max_percent ){
				$top = $max_percent ;
			}
		}
	}else{
	$top =0;
	$Maximum =0;
	}
}


if($desc==1){
	$descend = "DESC";
}else{
	$descend = "ASC";
}

$order="";

if($fsort !=1){
	$result=$quiz->getUserID($quiz,$descend);
	$num=$result->numRows();
	while($rs=$result->fetchRow(DB_FETCHMODE_ASSOC)){
		$user_id[]=$rs['id'];
		list($occasion_id)=$quiz->getOccID($quiz,$rs['id']);
		$any="";
		if(count($occasion_id)  !=0){
			for($i=0;$i<count($occasion_id);$i++){
				if($any !=""){
					$any.=",";
				}
				 $any.=$occasion_id[$i];
			}
			list($datetime,$total_score,$user_score,$Percent,$occ_id)=$quiz->getScore($quiz,$any,$order);
			for($ii=0;$ii<count($datetime);$ii++){
				$time[]=$datetime[$ii];
				$occ[]=$occ_id[$ii];
				$score[]=$user_score[$ii];
				$percent[]=$Percent[$ii];
			}
		}
	}
	$num_occ=count($occ);
}else{
		$sql="SELECT o.finished_datetime AS times, o.total_score AS TotalScore, o.user_sum_score AS UserScore, ua.occasion_id FROM q_user_scores ua, q_occasions o WHERE ua.occasion_id = o.occasion_id AND o.module_id = ".$quiz->getModules()." GROUP BY ua.occasion_id, o.user_id, o.finished_datetime ORDER BY UserScore ".$descend." ";
		$score_sql=mysql_query($sql);
		$num_occ=mysql_num_rows($score_sql);
		while($score_row=mysql_fetch_array($score_sql)){
			$occ[]=$score_row['occasion_id'];
			$time[]=$score_row['times'];
			if($score_row['TotalScore']=="" || $score_row['TotalScore']==0){
					$Percent = 0;
			}else{
					$Percent = number_format(($score_row['UserScore']/$score_row['TotalScore'])*100,2,'.','');
			}
			$score[]=$score_row['UserScore'];
			$percent[]=$Percent;
		}
}

//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>'main_menu.html',
																'main'=>'quiz_result_user.html'
																));
	$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																'Q_ID'=>$quiz->getModules(),
																'Q_NAME'=>$name,
																'VIEW'=>$strQuiz_MenuResult ,
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
																'RESULTBY'=>$strQuiz_MenuResultByUser,
																'BY'=>"(".$strQuiz_MenuResultByUser.")",
																//user
																'ResultAll'=>($quiztype==0)?$strQuiz_LabResultAll:$strQuiz_LabResultSurveyAll ,
																'UniPart_T'=>$strQuiz_LabUniPart,
																'UniCount'=>$uCnt,
																'NrRun_T'=>$strQuiz_LabNrRun,
																'NrRun'=>$cnt,
																'Part'=>$strQuiz_LabPart,
																'Occ'=>$strQuiz_LabOccasion,
																'Score'=>$strQuiz_LabScore,
																'Percent'=>$strQuiz_LabPercent,
																'Answer'=>$strQuiz_LabAnswer,
																'OutOfTime'=>($num_out==1)?$strQuiz_LabOutofTime:"",
																'NumOcc'=>$num_occ,
																'NrSend'=>$strQuiz_LabNrSend,
																));
				if($uCnt !=0){
						if($quiztype==0){
							$template->assign_block_vars('block',array('img_u'=>($desc!= 1)?"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."&desc=1><img src=./images/dn.gif width=10 height=9 border=0 alt=\"Sort descending\"</a> ":"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."><img src=./images/up.gif width=10 height=9 alt=\"Sort ascending\" border=0></a>",
							'img_s'=>($desc!= 1)?"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."&desc=1&fsort=1><img src=./images/dn.gif width=10 height=9 border=0 alt=\"Sort descending\"</a> ":"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."&fsort=1><img src=./images/up.gif width=10 height=9 alt=\"Sort ascending\" border=0></a>",
																													));
						}else{
							$template->assign_block_vars('survey',array('img_u'=>($desc!= 1)?"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."&desc=1><img src=./images/dn.gif width=10 height=9 border=0 alt=\"Sort descending\"</a> ":"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."><img src=./images/up.gif width=10 height=9 alt=\"Sort ascending\" border=0></a>",
							'img_s'=>($desc!= 1)?"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."&desc=1&fsort=1><img src=./images/dn.gif width=10 height=9 border=0 alt=\"Sort descending\"</a> ":"<a href=?a=useranswersByuser&m=admin&modules=".$quiz->getModules()."&fsort=1><img src=./images/up.gif width=10 height=9 alt=\"Sort ascending\" border=0></a>",
																													));
						}
						for($a=0;$a<$num_occ;$a++){
							//if()
							$sql=mysql_query("SELECT u.firstname ,u.surname,u.email,u.email2,u.id  FROM users u, q_occasions o WHERE u.id=o.user_id AND o.occasion_id=".$occ[$a]."");
							$firstname=mysql_result($sql,0,"firstname");
							$surname=mysql_result($sql,0,"surname");
							$email=mysql_result($sql,0,"email");
							$email2=mysql_result($sql,0,"email2");
							$id=mysql_result($sql,0,"id");
							if($email !="")
								$usermail =$email;
							else
								$usermail =$email2;

							if($firstname == ""){
								$sql1=mysql_query("SELECT firstname_eng,surname_eng FROM users_info WHERE  id=".$id." ");
								$firstnameE=mysql_result($sql1,0,"firstname_eng");
								$surnameE=mysql_result($sql1,0,"surname_eng");
								$name=$firstnameE."&nbsp;".$surnameE;
							}else{
								$name=$firstname."&nbsp;".$surname;
							}

							if($quiztype==0){
							$template->assign_block_vars('block.data',array('BG'=>($top==$percent[$a])?"tdbackground":"tdbackground1",
																															'UserName'=>($previousUser!=$id)?"<a href=mailto:".$usermail.">".$name."</a>":"&quot;",
																															'DateTime'=>$time[$a],
																															'score'=>$score[$a],
																															'percent'=>$percent[$a]."%",
																															'occid'=>$occ[$a],
																															));
							}else{
								//echo $occ[$a];
							$template->assign_block_vars('survey.sdata',array('UserName'=>($previousUser!=$id)?"<a href=mailto:".$usermail.">".$name."</a>":"&quot;",
																															'DateTime'=>$time[$a],
																															'score'=>$score[$a],
																															'percent'=>$percent[$a]."%",
																															'occid'=>$occ[$a],
																															));
							}
							$previousUser = $id;
						}

																												
				}else{
						$template->assign_block_vars('error',array('ERROR'=>$strQuiz_LabNoRecord));
				}
$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');
?>
