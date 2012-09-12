<? 
error_reporting(0);
require("../include/global_login.php");
include('classes/config.inc.php');
  ?>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}

function DeleteTopic(tid,rit,mid,cid,del){
	if(confirm("Are you sure that you want to completely delete this topic?")){
		window.location="index.php?a=del&topicid="+tid+"&refid="+rit+"&id="+mid+"&courses="+cid+"&del=1&reply="+del+" ";		
	}
}
</script>
<? 
//===========Query======================
$webboard=new Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);
if($r==1){
	$webboard->UpdateRead($webboard);                             //count read topic
//***********insert modules_history***************
		$action="Read webborad";
		Imodules_h($id,$action,$person["id"],$courses);
}
//show topic by id 
list($topic_id,$ref_id,$users,$modules,$subject,$contrib,$posttime,$lesttime,$a,$b,$icon,$pic,$read_topic,$firstname,$login,$surname,$email)=$webboard->ShowTopic($webboard);	
$icon=$icon.".gif";
$posttime="".date("d/m/Y H:i",$posttime)."";
$user=$webboard->getWUser();
$admin=$webboard->CheckAdmin($webboard);
$allpath="./images/upload";
$topic_img=getimagesize($allpath."/".$pic);
$size_img=$webboard->imageResize($topic_img[0], $topic_img[1], 200);


//show reply
$row=$webboard->SelectReportAll($webboard,'','');
$result=$webboard->ShowReply($webboard,$row,$page);
$num=$result->numRows();

@list($a,$page,$totalpage)=$webboard->ShowSeqTable ($webboard,$row,$page,1);			//return action page and totalpage


//==========Template====================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'show_topic.html',
													));
					//Text
			$template->assign_vars(array('PAGE' =>($num !=0)?"<b>Page : </b>":"" ,
														));
			$template->assign_block_vars('topic', array('SUBJECT'=>$subject,
																									'ICON'=>($icon==null)?"":"<img src=./images/icons/".$icon.">" ,	
																									'DETAIL'=>$webboard->filter($contrib,1),
																									'POSTTIME'=>$posttime,
																									'LOGIN'=>$login,
																									'IMG'=>($pic=="")?"":"<div align=center><img src=./images/upload/".$pic." ".$size_img."></div>",
																									'PROFILE'=>"<a  href= Javascript:NewWindow('../personal/info.php?userid=".$users."&view=1','name','650','500','no');><img src=\"./images/profile.gif\" border=0></a>",
																									'EDIT'=>($user==$users || $admin==$user)?"<a href=\"?a=etopic&topicid=".$topic_id."&refid=".$ref_id."&id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&edit=1&topic=1\"><img src=\"./images/edit_b.gif\" border=0></a>":"",
																									'DELETE'=>($user==$users || $admin==$user)?"<a  href=Javascript:DeleteTopic('".$topic_id."','".$ref_id."','".$webboard->getWModules()."','".$webboard->getWCourses()."','0')><img src=\"./images/delete_b.gif\" border=0></a>":"",
																			));
		while($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)){
			$replytime="".date("d/m/Y H:i",$rs["time"])."";
			$reply_img=getimagesize($allpath."/".$rs['img']);
			$size_img=$webboard->imageResize($reply_img[0], $reply_img[1], 200);
			$template->assign_block_vars('replylist', array('DETAIL'=>$webboard->filter($rs["contrib"],1),
																									'IMG'=>($rs['img']=="")?"":"<div align=center><img src=./images/upload/".$rs['img']."  ".$size_img."></div>",
																									'REPLYNAME'=>$rs['login'],
																									'REPLYTIME'=>$replytime,
																									'PROFILE'=>"<a  href= Javascript:NewWindow('../personal/info.php?userid=".$rs["users"]."&view=1','name','650','500','no');><img src=\"./images/profile.gif\" border=0></a> ",
																									'EDIT'=>($user==$rs["users"] || $admin==$user)?"<a href=\"?a=etopic&topicid=".$rs["id"]."&refid=".$rs["refid"]."&id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&edit=1&reply=1\"><img src=\"./images/edit_b.gif\" border=0></a>":"",
																									'DELETE'=>($user==$rs["users"] || $admin==$user)?"<a  href=Javascript:DeleteTopic('".$rs["refid"]."','".$rs["id"]."','".$webboard->getWModules()."','".$webboard->getWCourses()."','1')><img src=\"./images/delete_b.gif\" border=0></a>":"",

																		));
		}

			if($num !=0){
			//Page
				$prevpage = $page-1;
				$nextpage = $page+1;
				$template->assign_block_vars('page', array(
				'PREV'=>($page>1 && $page<=$totalpage) ?"<a href=\" ?".$a."id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&page=".$prevpage."\"><img src=\"./images/back.gif\" border=0></a>":"",
				'NEXT'=>($page!=$totalpage)?"<a href=\"?".$a."id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&page=".$nextpage."\"><img src=\"./images/next.gif\" border=0></a>":"",
				'PAGE'=>"[$page/$totalpage]",
																			));
				
				//pagerows
				for ($i=1; $i<=$totalpage; $i++) {
					 if ($i == $page) {
						$template->assign_block_vars('pagerows',array(
																						'PAGE'=>$i
																					));
					 }
					 else {
					 $j= "<a href=\"?".$a."id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&page=".$i."\">$i</a>&nbsp;";
					 $template->assign_block_vars('pagerows',array(
																						'PAGE'=>$j
																					));
					 }
				}
			}

$template->pparse('body');
 require("posttopic.php");
?>
