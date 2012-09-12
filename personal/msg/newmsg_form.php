<? 
session_start();
require("../../include/global_login.php");
require("../../include/online.php");
require("../../include/function.inc.php");
require("message.class.php");
include('classes/config.inc.php');
require ("msg_menu.php");

$message =new Message('',$person['id']);


if(isset($_SESSION[mPri])){
			if($_SESSION[mPri] ==1){
				$P1="checked";
			}else if($_SESSION[mPri] ==2){
				$P2="checked";
			}else{
				$P3="checked";
			}
}else{ 
		$P3="checked";
 }
 
if($_GET[to_id]){  // Post Reply
		$mTo = $message->GetNameUID($to_id);
		//echo "TO::::".$to_id, $mTo;
		 session_unregister("mSbj");
		 session_unregister("mPri");
		session_unregister("mMsg");
}
 
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'newmsg_form.html',
												));   
				$template->assign_vars(array('HEADER'=>$strPersonal_msg_New,
																	'TO'=>$strPersonal_msg_To,
																	'SUBJECT'=>$strPersonal_msg_Subject,
																	'PRI'=>$strPersonal_Pri_Priority,
																	'HIGH'=>$strPersonal_Pri_High,
																	'NORMAL'=>$strPersonal_Pri_Normal,
																	'LOW'=>$strPersonal_Pri_Low,
																	'MESSAGE'=>$strPersonal_msg_Message,
																	'SEARCH'=>$strPersonal_msg_Search,
																	'SEND'=>$strSend,
																	'SUBJECT_VAL'=>$_SESSION[mSbj],
																	'MESSAGE_VAL'=>$_SESSION[mMsg],
																	'MTO'=>($mTo==null)?"":$mTo,
																	'P1'=>$P1,
																	'P2'=>$P2,
																	'P3'=>$P3,
														));

$template->pparse('body');							


?>