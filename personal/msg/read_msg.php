<? 
require("../../include/global_login.php");
require("../../include/online.php");
require("../../include/function.inc.php");
require("message.class.php");
include('classes/config.inc.php');
require ("msg_menu.php");


$message =new Message($_GET[action],$person['id']);
$header = $message->getActionName($message,$strPersonal_msg_Sentbox,$strPersonal_msg_Outbox,$strPersonal_msg_Savebox,$strPersonal_msg_inbox);
//@list($msg_id,$msg_type,$msg_priority,$msg_subject,$msg_message,$msg_from_uid,$msg_to_uid,$msg_date,$msg_enable)= $message->GetDetailMsg($id);
$new_id = $message->createNewMsg($message,$id);
@list($msg_id,$msg_type,$msg_priority,$msg_subject,$msg_message,$msg_from_uid,$msg_to_uid,$msg_date,$msg_enable)= $message->GetDetailMsg($new_id);
//echo "NEWID==".$new_id;

//==========Template====================
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'read_msg.html',
												));   
												
												
		$template->assign_vars(array('FROM'=>$strPersonal_msg_From,
																'TO'=>$strPersonal_msg_To,
																'DATE'=>$strPersonal_msg_Date,
																'SUBJECT'=>$strPersonal_msg_Subject,
																'HEADER'=>$header,
																'FROM_VAL'=>$message->GetNameUID($msg_from_uid),
																'TO_VAL'=>$message->GetNameUID($msg_to_uid),
																'DATE_VAL'=>$message->FormatDate($msg_date),
																'SUBJECT_VAL'=>$msg_subject,
																'SHOW_MSG'=>$msg_message,
																'POSTREPLY'=>$strPersonal_msg_Answer,
																'MESSAGE'=>$strPersonal_msg_Message,
																'MSG_ID'=>$msg_id,
																'REPLY_ID'=>$msg_from_uid,
														));
														
if($message->getAction()== 0){
	$template->assign_vars(array('SAV'=>"<input class = \"button\" name=\"save\"  type=\"submit\"  value=\"$strSave\">",   ));
}else{  
	$template->assign_vars(array('SAV'=>"&nbsp;", ));
 }
 
 if($message->getAction() != 2){
	$template->assign_vars(array('DEL'=>"<input class = \"button\"  name=\"del\"  type=\"submit\"  value=\"  $strDelete  \">",   ));
}else{  
	$template->assign_vars(array('DEL'=>"", ));
 }
 
 
$template->pparse('body');							
 mysql_close();

?>