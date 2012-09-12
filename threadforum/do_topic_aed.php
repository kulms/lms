<?
	
	$webboard=new Webboard($topicid,$refid,stripslashes($txt_sub),$icon,str_replace("'","&#039;",nl2br($message)),$filename,$person["id"],$id,$courses);


//check size img
if($webboard->getWImg() !="" && $webboard->getWImg()!="none"){
	if($_FILES['filename']['size'] > 51200){
		print( "<script language=javascript> alert(\"Can not upload file more 50 KB.\"); </script>");
		print( "<script language=javascript> javascript:history.back(1) </script>");
		exit;
	}
}

//edit
if($edit ==""){
		$webboard->InsertTopic($webboard,$reply);

		//list threadprefs
		list($detail,$sort,$date,$thread,$mail)=$webboard->SelectPrefs($webboard);
			if(count($detail)==0){
				$webboard->InsertPrefs($webboard);
			}
		if($topic==1){
			//***********insert modules_history***************
			$action="New webborad";
			Imodules_h($id,$action,$person["id"],$courses);
			require("main.php");
		}
		if($reply==1){
			//***********insert modules_history***************
			$action="Reply webborad";
			Imodules_h($id,$action,$person["id"],$courses);	
			require("show_topic.php");
		}
	//$webboard->Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);

		
}else{
	$edit="";
	if($delpic==1){
		$pic=$webboard->UnlinkPic($webboard);
		unlink("./images/upload/$pic");
	}
	if($reply==1){
//***********insert modules_history***************
		$action="Edit Posting";
		Imodules_h($id,$action,$person["id"],$courses);		
	$topicid=$refid;
	}	
	
if($topic==1){
		//***********insert modules_history***************
		$topic=0;
		$reply=1;
		$action="Edit Subject";
		Imodules_h($id,$action,$person["id"],$courses);
	}
	
$webboard->UpdateTopic($webboard);
//$webboard->Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);

require("show_topic.php");
}

@mysql_close();
?>
