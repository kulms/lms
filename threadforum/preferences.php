<? 
require("../include/global_login.php");
include('classes/config.inc.php');
//===========Query======================
$webboard=new Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);
list($detail,$sort,$date,$thread,$mail)=$webboard->SelectPrefs($webboard);
	if(count($detail)==0){
		$webboard->InsertPrefs($webboard);
		list($detail,$sort,$date)=$webboard->SelectPrefs($webboard);
	}

 if($update==1){
			if($showcontrib=="true"){
				$showcontrib=1;
			}else{
				$showcontrib=0;
			}
			if($showthread=="true"){
				$showthread=1;
			}else{
				$showthread=0;
			}
			if(!settype($showdays,"integer")){
				$showdays=7;
			}
			if($sortdesc=="true"){
				$sortdesc=1;
			}else{
				$sortdesc=0;
			}
			if($mailstate=="on"){
				$mailstate=1;
			}else{
				$mailstate=0;
			}
			$webboard->UpdatePrefs($webboard,$showcontrib,$showthread,$showdays,$sortdesc,$mailstate);
			list($detail,$sort,$date,$thread,$mail)=$webboard->SelectPrefs($webboard);
	}
	$menu=1;
//==========Template====================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'preferences.html',
													));
	$template->assign_vars(array('HD' =>$strWebboard_LabHPre ,
																'DETAIL_H'=>$strWebboard_LabHDatail,
																'DETAIL_S'=>$strWebboard_LabSDatail,
																'THREAD_H'=>$strWebboard_LabHThread,
																'DESC_H'=>$strWebboard_LabHDESC,
																'DESC_S'=>$strWebboard_LabSDESC,
																'MAIL_H'=>$strWebboard_LabHMail,
																'MAIL_S'=>$strWebboard_LabSMail,
																'DATE_H'=>$strWebboard_LabHDate,
																'T_DATE'=>$strWebboard_LabDate,
																'IS_CHECK1'=>($detail==1)?"checked":"",
																'IS_CHECK2'=>($sort==1)?"checked":"",
																'IS_CHECK3'=>($thread==1)?"checked":"",
																'IS_CHECK4'=>($mail==1)?"checked":"",
																'D_DATE'=>$date,
																'UPDATE'=>$strUpdate,
																'NAME'=>$forumname,
																'MODULE'=>$webboard->getWModules(),
																'COURSES'=>$webboard->getWCourses(),
																'BACK'=>"<a href=\"?id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."\">".$strBack."</a>",
														));
	
$template->pparse('body');
?>