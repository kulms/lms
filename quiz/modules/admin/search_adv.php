<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
//==================query========================//
$quiz=new Quiz($qid,$modules,$courses);
$result_courses=$quiz->SelectCourses($person['id']);



//==================template=====================//
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
															'main'=>'quiz_search_adv.html',
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

//list courses
while($rs_courses=mysql_fetch_array($result_courses)){
	$template->assign_block_vars('courses',array('courses_id'=>$rs_courses['id'],
																	'courses_name'=>$rs_courses['name'],
																	'courses_section'=>$rs_courses['section'],
	));
}
$template->assign_var_from_handle('MAIN', 'main');
$template->pparse('body');
?>