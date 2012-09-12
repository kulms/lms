<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
//=====================Query===========================
$num=$quiz->SelectQuizAll($quiz);
$pagesize=25;
$result=$quiz->SelectQuiz($quiz,$page,$pagesize);
@list($page,$totalpage)=$quiz->Page($quiz,$num,$page,$pagesize);			//return action page and totalpage
//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
																'main'=>'quiz_viewQuestion.html'
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
																'PAGE' =>($num !=0)?"<b>".$strPage." : </b>":"" ,
																 'Theme'=>$theme,
																 'DEL_'=>($num_quiz !=0)?"1":"0",
																//----view
																'TOTAL'=>$strQuiz_LabTotalQuestion,
																'NO'=>$strQuiz_LabQuizNo,
																'QUES'=>$strQuiz_LabQuiz,
																'TYPE'=>$strQuiz_LabType,
																'PROCESS'=>$strAction,
																'SHOW'=>$strShow,
																'EDIT_T'=>$strEdit,
																'REMOVE'=>$strRemove,
																'DELETE'=>$strDelete,
																'NUM'=>$num,
																'MAXSCORE'=>$strQuiz_LabMaxScore,
															//	'Img_BG'=>
																));	
					$cnt=0;
					if($num !=0){
							$template->assign_block_vars('block',array());
					}else{
						   $template->assign_block_vars('error',array('ERROR'=>"ไม่มีข้อสอบตอนนี้ /There are no questions for this quiz yet..."));
					}
					while($rs =mysql_fetch_array($result)){
						$maxscore_mcit="";
						$maxscore="";
						$cnt++."<br>";
						if ($rs["question_type"]=="mltc"){
							$type=$strQuiz_MenuAddMultipleChoice;
							$maxscore=$rs["score"];
						}else if($rs["question_type"]=="tnf"){
							$type=$strQuiz_MenuAddTrueFalse;
							$maxscore=$rs["score"];
						}else if($rs["question_type"]=="fib"){
							$type=$strQuiz_MenuAddFilling;
							$maxscore=$rs["score"];
						}else if($rs["question_type"]=="mcit"){
							$type=$strQuiz_MenuAddMatching;
							$maxscore_mcit=$rs["score"];
							$sql="SELECT mcit_id FROM q_question_mcit WHERE question_id= ".$rs["question_id"]." ";
							$data_sql=mysql_query($sql);
							$num_mcit=mysql_num_rows($data_sql);
							$maxscore_mcit=$maxscore_mcit*$num_mcit;
							$maxscore_mcit=number_format($maxscore_mcit,2,'.','');
						}
						
							$template->assign_block_vars('block.list', array('QUES'=>$rs['question'],
																												'TYPE'=>$type,
																												'NUM'=>$cnt,
																												'MK'=>($rs['makecopy']==1)?"tdbackground":"tdbackground1",
																												'SCORE'=>$maxscore,
																												'SCORE_MCIT'=>$maxscore_mcit,
																												'SHOW'=>"<a href=JavaScript:view_q(".$rs['question_id'].",".$quiz->getModules().",".$cnt.");  ><img src=\"../images/view.gif\" border=\"0\" align=\"middle\"></a>",
																												'EDIT'=>"<a href=JavaScript:editQuestion(".$rs['question_id'].",".$quiz->getModules().");><img src=\"../images/edit4.gif\" border=\"0\" align=\"middle\"></a>",
																												'REMOVE'=>"<a href=# onClick=remove_question(".$rs['question_id'].",".$quiz->getModules().");>".$strRemove."</a>",
																												'DELETE'=>"<a href=JavaScript:check_delete_question(".$rs['question_id'].",".$quiz->getModules().");><img src=\"../images/_trash_full-16.png\" border=\"0\" align=\"middle\"></a>",
																												));
				}

			if($num !=0){
			//Page
				$prevpage = $page-1;
				$nextpage = $page+1;
				$template->assign_block_vars('page', array(
				'PREV'=>($page>1 && $page<=$totalpage) ?"<a href=\"?a=viewQuestion&m=admin&modules=".$quiz->getModules()."&page=".$prevpage."\"><img src=\"images/back.gif\" border=0></a>":"",
				'NEXT'=>($page!=$totalpage)?"<a href=\"?a=viewQuestion&m=admin&modules=".$quiz->getModules()."&page=".$nextpage."\"><img src=\"images/next.gif\" border=0></a>":"",
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
					 $j= "<a href=\"?a=viewQuestion&m=admin&modules=".$quiz->getModules()."&page=".$i."\">$i</a>&nbsp;";
					 $template->assign_block_vars('pagerows',array(
																						'PAGE'=>$j
																					));
					 }
				}
			}
$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');
?>