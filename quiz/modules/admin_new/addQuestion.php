<? 
require("../include/global_login.php");
include('classes/config.inc.php');
//include('htmltool/config.php');
//include("htmltool/header.php"); 
require("header.php");
define( "_VALID_MOS", 1 );
//define( "MODULES",$quiz->getModules());
$modules_id=$quiz->getModules();

require_once ("configuration.php");
require_once ("classes/mambo.php");
require_once ("includes/sef.php");
require_once ("includes/frontend.php");
require_once( "editor/editor.htmlarea2.php" );
//echo "$mosConfig_absolute_path/quiz/editor/editor.htmlarea2.php<br>";
//echo "modules_id=".$MID."<br>";
session_register("modules_id");
ob_start();
//====================Template=========================
?>
<script language="JavaScript1.2" type="text/JavaScript1.2">
<!--
	_editor_url = 'http://localhost/htmlarea/quiz/editor/htmlarea2/';          // URL to htmlarea files
	var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
	if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
	if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
	if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }

	if (win_ie_ver >= 5.5) {
		document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
		document.write(' language="Javascript1.2"></scr' + 'ipt>');
	} else {
		document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>');
	}
//-->
</script>
<?
@list($info,$enddate,$name,$users,$active,$q_type,$view,$endview,$time,$multiple,$grading)=$quiz->getQuizInfo($quiz);
if($grading==1){
	// score mtic,tnf.fib
		$sql="SELECT DISTINCT q.score  FROM q_questions q, q_modules_questions mq, modules m,q_module_prefs i WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id AND m.id=".$quiz->getModules()."  AND i.module_id =".$quiz->getModules()." AND q.question_type !='mcit' ";
		$data_sql=mysql_query($sql);
		@$score=mysql_result($data_sql,0,'score');
}

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
																'DEL_'=>($num_quiz !=0)?"1":"0",
																//add
																'EDIT_B'=>$strUpdate,
																'RESET_B'=>$strReset,
																'QUES_TEXT'=>$strQuiz_LabQuiz,
																'FILE_TEXT'=>$strQuiz_LabFile,
																'CAT_TEXT'=>$strQuiz_LabCategory,
																'CAT_TEXT1'=>$strQuiz_LabForSearch,
																'ADD_CAT'=>$strAdd." ".$strQuiz_LabCategory,
																'SCORE_T'=>$strQuiz_LabScore,
																'SCORE_T1'=>$strQuiz_LabRecieveScore,
																'CHOICE'=>$strQuiz_LabAlternate,
																'CORRECT'=>$strQuiz_LabCorrectAns,
																'CORRECT_ANS'=>$strQuiz_LabCorrectAnswer,
																'SOL_T'=>$strQuiz_LabSolution,
																'SOL_T1'=>$strQuiz_LabSolutionDisplay,
																'COMMENT_T'=>$strQuiz_LabComment,
																'LINE'=>'<hr class=colorLine>',
																'Q_TYPE'=>$question_type,
																'QUIZ_TYPE'=>$q_type,
																'QUIZ_ID'=>$qid,
																'Makecopy'=>$makecopy,
																'QT'=>$question_type,
																'ANS_TEXT'=>$strQuiz_LabAnswer,
																'TRUE_TEXT'=>$strQuiz_LabAnswerTrue,
																'FALSE_TEXT'=>$strQuiz_LabAnswerFalse,
																'Action'=>'AddQuestions',
																'NUM_ONRY'=>$strQuiz_LabNumericOnly,
																'NUM_QUIZ'=>$strQuiz_LabTotalQuestion,
																'NUM_ANS'=>$strQuiz_LabTotalAnswer,
																'Active'=>$strQuiz_LabActive,
																'InActive'=>$strQuiz_LabInActive,
																'Desc'=>$strQuiz_LabDesc,
																'CScore'=>($score=="")?"0":$score,
																'FileUpload'=>$strWebboard_LabUpload,
															//	'QUES'=>"ddd",
																));
				if($result==1){
					$template->assign_block_vars('result',array('RESULT'=>$strQuiz_LabAddQuestionSuccess,
																										));
				}
				//SelectCategory
				$cat_list = mysql_query("SELECT distinct(category_desc) as categories,category_id FROM q_categories ;");
				while($row_cat=mysql_fetch_array($cat_list)){
					$cat_id=$row_cat['category_id'];
					$cat_name=$row_cat['categories'];
					$template->assign_block_vars('cat_list',array('CAT_ID'=>$cat_id,
																											  'CAT_NAME'=>$cat_name,
																											  'IS_SELECT'=>($cat==$cat_id)?"selected":"",
																				));
				}

				if($question_type=='mltc'){
						$template->set_filenames(array('main'=>'quiz_editQuestionMltc.html',
																						//'toolbar'=>'toolbar.html',
																					//	'textarea'=>'textarea.html',
																			));
						$template->assign_vars(array('BY' =>"(".$strQuiz_MenuAddMultipleChoice.")" ,
																					//'AREA'=>editorArea( 'editor1', '', 'fulltext', '400', '100', '45', '10' ),
																			));

						for($a=1;$a<7;$a++){
								$template->assign_block_vars('addAns',array('COUNT'=>$a,
																															'JAVA'=>"<script language=\"JavaScript1.2\" defer=\"defer\">editor_generate('Alternative$a');</script>",
																															));
						}
					//$template->assign_var_from_handle('TOOLBAR','toolbar');
					//$template->assign_var_from_handle('TEXTAREA','textarea');
				}else if($question_type=='tnf'){
						$template->set_filenames(array('main'=>'quiz_editQuestionTF.html',));
						$template->assign_vars(array('BY' =>"(".$strQuiz_MenuAddTrueFalse.")" ,));
				}else if($question_type=='fib'){
						$template->set_filenames(array('main'=>'quiz_editQuestionFib.html',	));
						$template->assign_vars(array('BY' =>"(".$strQuiz_MenuAddFilling.")" ,));
																		
				}else if($question_type=='mcit'){
						$template->assign_vars(array('BY' =>"(".$strQuiz_MenuAddMatching.")" ,));
																				
						$cat_list = mysql_query("SELECT distinct(category_desc) as categories FROM q_categories ;");
						$list_score=mysql_query("SELECT q.question_id,q.score FROM  q_modules_questions mq,q_questions q WHERE mq.module_id=".$quiz->getModules()." AND q.question_type='mcit' AND mq.question_id=q.question_id ORDER BY q.question_id");
						if(@mysql_num_rows($list_score) != 0){
							$q_id= mysql_result($list_score,0,"question_id");
							$score= mysql_result($list_score,0,"score");
							$list_num=mysql_query("SELECT mcit_id  FROM q_question_mcit WHERE question_id=".$q_id."");
							$score= mysql_result($list_score,0,"score");
							$num=mysql_num_rows($list_num);
							$Totalscore=$score*$num;
						}
					/*	$template->assign_block_vars('mcit',array('ACTIVE'=>$active,
																									 'IS_CHECK_AT'=>($active==1)?"checked":"",
																									 'IS_CHECK_IAT'=>($active==0)?"checked":"",
																								));
																							*/
						if($add !=1){
							$template->set_filenames(array('main'=>'quiz_editQuestionMcit.htm',));
							$template->assign_vars(array('TOTAL_SCORE'=>$Totalscore,));
						}else{
							//echo $value_active;
							$template->set_filenames(array('main'=>'quiz_editQuestionMcit_q.htm',));
							$sql=mysql_query("SELECT category_desc FROM q_categories WHERE category_id=$categories");
							@$category_desc=mysql_result($sql,0,"category_desc");
							$template->assign_vars(array('CAT_NAME' =>($category_desc == "")?"-":"$category_desc",
																						'TOTAL_QUIZ'=>$totquestion,
																						'TOTAL_ANS'=>$totanswer,
																						'SCORE'=>$score_T,
																						'MCIT_ACTIVE'=>$active,
																						'TOTAL_SCORE'=>$Totalscore,
																						'DESC'=>$Comment,
																						'CAT_ID'=>$categories,
																						'IS_CHECK_AT'=>($value_active==1)?"checked":"",
																					   'IS_CHECK_IAT'=>($value_active==0)?"checked":"",
																			));
							for($a=1;$a<=$totquestion;$a++){
								$template->assign_block_vars('quiz_list',array('COUNT'=>$a,
																															'JAVA'=>"<script language=\"JavaScript1.2\" defer=\"defer\">editor_generate('question$a');</script>",
																											 // 'CAT_NAME'=>$cat_name,
																											  //'IS_SELECT'=>($cat==$cat_id)?"selected":"",
																				));
							}
							$choice="a"; 
							for ($b=1;$b<=$totanswer;$b++){ 
								$template->assign_block_vars('ans_list',array('CHOICE'=>$choice,
																															 'COUNT'=>$b,
																															'JAVA'=>"<script language=\"JavaScript1.2\" defer=\"defer\">editor_generate('answer$b');</script>",
																											  //'IS_SELECT'=>($cat==$cat_id)?"selected":"",
																				));
								$ascii_choice = ord($choice);
							   $ascii_choice++;
							   $choice = chr($ascii_choice);
							}
						}
				}


$template->assign_var_from_handle('MAIN','main');

$template->pparse('body');
ob_end_flush();
?>