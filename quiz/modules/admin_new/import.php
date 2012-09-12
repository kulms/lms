<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
																'main'=>'quiz_importform.html'
																));
$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																'Q_ID'=>$quiz->getModules(),
																'Q_NAME'=>$name,
																'DEL_'=>($num_quiz !=0)?"1":"0",
																'VIEW'=>$strQuiz_LabImport ,
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
																'IMPORT'=>$strQuiz_LabImport,
																'SELIMPORT'=>$strQuiz_LabSelectImport,
																));

$template->assign_var_from_handle('MAIN', 'main');
$template->pparse('body');

?>