<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");

if($update ==1){
	mysql_query("UPDATE modules SET active=$set WHERE id=".$quiz->getModules().";");
}

@list($info,$enddate,$name,$users,$active)=$quiz->getQuizInfo($quiz);
//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
																'main'=>'quiz_setactive.html'
																));
	$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																'Q_ID'=>$modules,
																'Q_NAME'=>$name,
																'VIEW'=>$strQuiz_MenuSetActive ,
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
																'DEL_'=>($num_quiz !=0)?"1":"0",
																//----active
																'SEL_ACTIVE'=>($active==1)?"selected":"",
																'SEL_INACTIVE'=>($active==0)?"selected":"",
																'USE'=>$strQuiz_LabActive,
																'ToBe'=>$strQuiz_Labtobe,
																'UPDATE'=>$strUpdate,
																'COMPLETE'=>($update==1)?"Update complete !!!":"",
																'BUTTON'=>$strSet." ".$strQuiz_LabActive."/".$strQuiz_LabInActive,
																'ACTIVE'=>$strQuiz_LabActive,
																'INACTIVE'=>$strQuiz_LabInActive,
																));	
$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');
?>