<?
require("../include/global_login.php");
$webboard=new Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);
$webboard->DeleteTopic($webboard,$reply);
if($reply==1)
{
	//***********insert modules_history***************
		$action="Delete Posting";
		Imodules_h($id,$action,$person["id"],$courses);		
}else{
	//***********insert modules_history***************
		$action="Delete Subject";
		Imodules_h($id,$action,$person["id"],$courses);		
	}

if($refid==0)
	require("main.php");
else
	require("show_topic.php");
?>