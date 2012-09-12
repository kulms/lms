<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
$quiz=new Quiz($qid,$modules,$courses);
$qry=$qry;
$searchtype=$searchtype;

//*****function check score(22/03/05)
$num=$quiz->SelectQuizAll($quiz);
@list($info,$enddate,$name,$users,$active,$q_type,$view,$endview,$time,$multiple,$grading)=$quiz->getQuizInfo($quiz);

if($grading==1){
	if($num !=0){
		// score mtic,tnf.fib
		$sql="SELECT DISTINCT q.score  FROM q_questions q, q_modules_questions mq WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id  AND q.question_type !='mcit' ";
		$data_sql=mysql_query($sql);
		$num_all=mysql_num_rows($data_sql);
		if(mysql_num_rows($data_sql) !=0){
			$score=mysql_result($data_sql,0,'score');	
		}else{
			$score=0;
		}

		// check mcit
		$result=$quiz->GetMcit($quiz);
		$sql="SELECT q.* FROM q_questions q, q_modules_questions mq, modules m,q_module_prefs i WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id AND m.id=".$quiz->getModules()."  AND i.module_id =".$quiz->getModules()." AND q.question_type='mcit' ";
		$data_sql=mysql_query($sql);
		$num_mcit=mysql_num_rows($data_sql);
		if(@$num=mysql_num_rows($data_sql) !=0){
			$mcit_id=mysql_result($data_sql,0,'question_id');
			$score_mcit=mysql_result($data_sql,0,"score");
				// score mcit
			$sql="SELECT mcit_id FROM q_question_mcit WHERE question_id= ".$mcit_id." ";
			$data_sql=mysql_query($sql);
			$num_mcit_a=mysql_num_rows($data_sql);
			$score_mcit=$score_mcit*$num_mcit_a;
			$score_mcit=number_format($score_mcit,2,'.','');
		}else{
			$score_mcit=0;
		}
	}else{
		$num_mcit=0;
		$num_all=0;
		$score_mcit=0;
	}
}else{
	$num_all=0;
	// check mcit
	$result=$quiz->GetMcit($quiz);
		$sql="SELECT q.* FROM q_questions q, q_modules_questions mq, modules m,q_module_prefs i WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id AND m.id=".$quiz->getModules()."  AND i.module_id =".$quiz->getModules()." AND q.question_type='mcit' ";
		$data_sql=mysql_query($sql);
		$num_mcit=mysql_num_rows($data_sql);
		if(@$num=mysql_num_rows($data_sql) !=0){
			$mcit_id=mysql_result($data_sql,0,'question_id');
			$score_mcit=mysql_result($data_sql,0,"score");
				// score mcit
			$sql="SELECT mcit_id FROM q_question_mcit WHERE question_id= ".$mcit_id." ";
			$data_sql=mysql_query($sql);
			$num_mcit_a=mysql_num_rows($data_sql);
			$score_mcit=$score_mcit*$num_mcit_a;
			$score_mcit=number_format($score_mcit,2,'.','');
		}
}

//******
//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
															//'main'=>'quiz_search.html',
																));
	$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																'Q_ID'=>$quiz->getModules(),
																'Q_NAME'=>$name,
																'VIEW'=>$strQuiz_MenuSearchQuestion ,
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
																
																//search
																'TEXT1'=>$strQuiz_LabSearch,	
																'TEXT2'=>$strQuiz_LabSearchIn,
																'NUM'=>$strQuiz_LabQuizNo,
																'Q_TYPE'=>$strQuiz_LabType,
																'QUES'=>$strQuiz_LabQuiz,
																'USE'=>$strQuiz_LabUse,
																'SUBMIT_USE'=>$strQuiz_LabUseSelect,
																'QRY'=>$qry,
																'SEARCH_T'=>$searchtype,
																'NEW_SERACH'=>$strQuiz_LabNewSearch,
																'RESULT_SERACH'=>$strQuiz_LabResultSearch,
																'TOTAL_SEARCH'=>$strQuiz_LabTotal,
																'SCORE'=>$strQuiz_LabMaxScore,
																'Score'=>$score,
																'Grade'=>$grading,
																'MaxMcit'=>($grading==0)?number_format($score_mcit1,2,'.',''):"0",
																'Java'=>($grading==0)?"onSubmit=return CheckMaxscore(this);":"",
																));
												
								if($search !=1){
									$template->set_filenames(array('main'=>'quiz_search.html',));
								}else{
									$template->set_filenames(array('main'=>'quiz_search_result.html',));
									@list($num,$result)=$quiz->SearchAll($searchtype,$qry,$person["id"]);
									$template->assign_vars(array('PAGE' =>($num !=0)?"<b>".$strPage." : </b>":"" ,));

								if($num ==0){
									 $template->assign_block_vars('error',array('ERROR'=>"ไม่พบคำที่ต้องการค้นกา/Sorry, Could not find  !!! "));
								}else{
									$template->assign_block_vars('block',array('TOTAL_NUM'=>$num,));
								}
									$pagesize=35;
									if($num>0){
											$totalpage =(int) ($num/$pagesize);
											if (($num % $pagesize) != 0)
											{
												$totalpage += 1;
											}

											if (isset($pageid))
											{
												$start = $pagesize * ($pageid -1);
											}else{
												$pageid =1;
												$start=0;
											}
											if(($pageid==$totalpage) && ($num % $pagesize!= 0)){
												$stop=$start+($num % $pagesize);
											}else{
												$stop=$start+$pagesize;
											}
									}else{
										$start=0;	$stop=0;
									}
									$disabled=array();
									 for($a=$start;$a<$stop;$a++){
										 $maxscore_mcit="";
										 $maxscore="";
										 $get_q=mysql_query("SELECT q.question,q.question_type,m.module_id,q.score FROM q_questions q ,q_modules_questions m WHERE q.question_id=".$result[$a]." AND q.question_id=m.question_id AND m.makecopy <> 1");
									 if(mysql_num_rows($get_q) !=0){
										 if (mysql_result($get_q,0,"question_type")=="mltc"){
											$maxscore=mysql_result($get_q,0,"score");
											$type=$strQuiz_MenuAddMultipleChoice;
											//disabled
											if(mysql_result($get_q,0,"module_id") !=$quiz->getModules() ){
												if($num_all !=0){
													if($score != $maxscore)
														$disabled[$a]="disabled";
												}
											}else
												$disabled[$a]="disabled";

										}else if(mysql_result($get_q,0,"question_type")=="tnf"){
											$maxscore=mysql_result($get_q,0,"score");
											$type=$strQuiz_MenuAddTrueFalse;
											//disabled
											if(mysql_result($get_q,0,"module_id") !=$quiz->getModules() ){
												if($num_all !=0){
													if($score != $maxscore)
														$disabled[$a]="disabled";
												}
											}else
												$disabled[$a]="disabled";

										}else if(mysql_result($get_q,0,"question_type")=="fib"){
											$maxscore=mysql_result($get_q,0,"score");
											$type=$strQuiz_MenuAddFilling;
											//disabled
											if(mysql_result($get_q,0,"module_id") !=$quiz->getModules() ){
												if($num_all !=0){
													if($score != $maxscore)
														$disabled[$a]="disabled";
												}
											}else
												$disabled[$a]="disabled";

										}else if(mysql_result($get_q,0,"question_type")=="mcit"){
											$maxscore_mcit=mysql_result($get_q,0,"score");
											$sql="SELECT mcit_id FROM q_question_mcit WHERE question_id= ".$result[$a]." ";
											$data_sql=mysql_query($sql);
											$num_mcit_a=mysql_num_rows($data_sql);
											$maxscore_mcit=$maxscore_mcit*$num_mcit_a;
											$maxscore_mcit=number_format($maxscore_mcit,2,'.','');
											$type=$strQuiz_MenuAddMatching;
											//disabled
											if(mysql_result($get_q,0,"module_id") !=$quiz->getModules() ){
												if($num_mcit !=0){
													if($score_mcit != $maxscore_mcit)
														$disabled[$a]="disabled";
												}
											}else
												$disabled[$a]="disabled";
										}
										  $template->assign_block_vars('block.search',array('NUM'=>$a+1,
																							'RESULT'=>$result[$a],
																							'DISABLED'=>$disabled[$a],
																							//'DISABLED'
																							'TYPE'=>$type,
																							'SCORE'=>$maxscore,
																							'SCORE_MCIT'=>$maxscore_mcit,
																							'QUES'=>mysql_result($get_q,0,"question"),
																							'Q_TYPE'=>mysql_result($get_q,0,"question_type"),
																										));
									 }
									 }
									 //page
									 if($num !=0){
										 for ($i=1; $i<=$totalpage; $i++) {
											 if ($i == $pageid) {
												$template->assign_block_vars('pagerows',array(
																												'PAGE'=>$i
																											));
											 }
											 else {
											 $j= "<a href=\"?a=search&m=admin&modules=".$quiz->getModules()."&pageid=".$i."&search=1&qry=".$qry."&searchtype=".$searchtype."\">$i</a>&nbsp;";
											 $template->assign_block_vars('pagerows',array(
																												'PAGE'=>$j
																											));
											 }
										}
									 }
								}
$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');
?>