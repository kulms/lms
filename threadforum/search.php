<?
require("../include/global_login.php");
include('classes/config.inc.php');
//===========Query======================
$webboard=new Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);
$template= new Template(C_SKIN);
	 if($qry != ""){
			$search=$qry;
			require("main.php");
	 }
		//$template->redirect('show_topic.php');
//==========Template====================
$template->set_filenames(array('body' => 'search.html',
													));
	$template->assign_vars(array('MODULE'=>$webboard->getWModules(),
																'COURSES'=>$webboard->getWCourses(),
																'T_SEARCH'=>$strWebboard_LabSearch,
																'NAME'=>$forumname,
																'BACK'=>"<a href=\"?id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."\">".$strBack."</a>",
													));
$template->pparse('body');
?>