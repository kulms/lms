<? 
session_start();
require("../../include/global_login.php");
require("../../include/online.php");
require("../../include/function.inc.php");
require("message.class.php");
include('classes/config.inc.php');
require ("msg_menu.php");

		 session_unregister("mSbj");
		 session_unregister("mPri");
		session_unregister("mMsg");


$message =new Message($_GET[action],$person['id']);
$con= $message->SelectBox($message); //row is condition  for SELECT
$result=$message->ListMsg($message,$con,$page);
$num=$result->numRows();

@list($page,$totalpage) =$message->ShowPage($message,$con,$page);
$color = array(COLOR1,COLOR2);
$page_col =array(COLPAGE1,COLPAGE2);

$header = $message->getActionName($message,$strPersonal_msg_Sentbox,$strPersonal_msg_Outbox,$strPersonal_msg_Savebox,$strPersonal_msg_inbox);
 if(($message->getAction() ==1) || ($message->getAction() ==2)){  // if OUTBOX  OR  SENTBOX
 		$toperson =1;
}

//==========Template====================
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'main.html',
												));   
		$template->assign_vars(array('PAGE' =>($num !=0)?"<b>Page : </b>":"" ,  //====================PAGE
																'ERROR'=>($num ==0)?"No Messages":"",
																'SUBJECT'=>$strPersonal_msg_Subject,
																'FROM'=>($toperson==1)?"$strPersonal_msg_To":"$strPersonal_msg_From",
																'DATE'=>$strPersonal_msg_Date,
																'HEADER'=>$header,
																'NEW'=>$strPersonal_msg_New,
																'NUM'=>$num,
														));
		$i=0;
		if($num !=0){
			$template->assign_block_vars('list', array());
		}else
			$template->assign_block_vars('error', array('ERROR'=>$strPersonal_msg_ErrorNoMsg));
		while($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)){
				if($message->getAction()==0){
							   if($rs[msg_type] == 2){
												$icon = "open2.gif";
								  }else if($rs[msg_type] == 5){
												  if($rs[msg_priority] == 3){
														  $icon = "high2.gif";
												  }else{
														$icon =  "develop.gif";
												  }
								}else {  
									 $icon="";   
								 }
				}
				
				//**************GET  NAME of  UID*******************
				$to_id =$message->GetNameUID($rs[msg_to_uid]);
				$from_id = $message->GetNameUID($rs[msg_from_uid]);
			
				$template->assign_block_vars('list.topiclist', array(
																'ICON'=>($icon==null)?"":"<img src=images/".$icon.">" ,
																'SUBJECT'=>"<A HREF=\"read_msg.php?id={$rs[msg_id]}&action=".$message->getAction()."\">".$rs[msg_subject]."</a>",
																'BG_C'=>$color[$i%2] ,
																'FROM'=>($toperson==1)?"$to_id":"$from_id",
																'DAY'=>$message->FormatDate($rs[msg_date]),
																'MSG_ID'=>$rs[msg_id],
																'MSG_N'=>"msg_id[".$i."]",
											));
				$i++;
		}	
		
		if($num !=0){  //=====PAGE
			$prevpage = $page-1;
			$nextpage = $page+1;
			$template->assign_block_vars('page', array(
			'PREV'=>($page>1 && $page<=$totalpage) ?"<a href=\"index.php?page=".$prevpage."&action=".$message->getAction()."\"><img src=\"images/prev.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"></a>":"",
			'NEXT'=>($page!=$totalpage)?"<a href=\"index.php?page=".$nextpage."&action=".$message->getAction()."\"><img src=\"images/next.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"></a>":"",
			'PAGE'=>"[$page/$totalpage]",
																		));
			
			//pagerows
			for ($i=1; $i<=$totalpage; $i++) {
				 if ($i == $page) {
					$template->assign_block_vars('pagerows',array(
																					'PAGE'=>$i,
																					'COLPAGE'=>$page_col[1],
																				));
				 }
				 else {
						 $j= "<a href=\"?page=".$i."&action=".$message->getAction()."\">$i</a>&nbsp;";
						 $template->assign_block_vars('pagerows',array(
																					'PAGE'=>$j,
																					'COLPAGE'=>$page_col[2],
																				));
				 }
			}
		}
if($message->getAction() == 0){
	$template->assign_vars(array('SAV'=>"<input class = \"button\" name=\"save\"  type=\"submit\"  value=\"$strSave\">",   ));
}else{  
	$template->assign_vars(array('SAV'=>"&nbsp;", ));
 }
 
 if($message->getAction() != 2){
	$template->assign_vars(array('DEL'=>"<input class = \"button\" name=\"del\"  type=\"submit\"  value=\"  $strDelete  \">",   ));
}else{  
	$template->assign_vars(array('DEL'=>"", ));
 }

$template->pparse('body');							
 mysql_close();
?>






