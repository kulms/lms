<? 
require("../include/global_login.php");
//require("classes/quiz.class.php");
//$modules=$id;
//$quiz=new Quiz('','','');
//===================Query Datbase===================================//
@list($info,$enddate,$name,$users,$active,$q_type)=$quiz->getQuizInfo($quiz);
//=================================================================//

$template= new Template(C_SKIN);	
$template->set_filenames(array('body' => 'header.html'));
			$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																	     'Q_ID'=>$modules,
																		 'Q_NAME' =>$name,
																		// 'Q_INFO'=>$info,
																		 'Theme'=>$theme,
															));
$template->pparse('body');
?>