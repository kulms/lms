<? 
require("../include/global_login.php");
require("header.php");

//===================Query Datbase===================================//

$template= new Template(C_SKIN);	
$template->set_filenames(array('body' => 'main_menu.html',
																//'main'=>$strQuiz_LabStart
																));
	$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																'Q_ID'=>$modules,
																'VIEW'=>$strQuiz_LabMQ ,
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
																'MAIN'=>$strQuiz_LabStart,
																));	
//$template->assign_var_from_handle('MAIN', 'main');
$template->pparse('body');
?>