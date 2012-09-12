<? 
session_start();
require("../../include/global_login.php");
require("../../include/online.php");
require("../../include/function.inc.php");
require("message.class.php");
include('classes/config.inc.php');
require ("msg_menu.php");

$message =new Message('',$person['id']);

$list ="<option>Please select name - - - ";

if($to_id !="" && $allperson==''){  // reply
@list($id,$firstname,$surname,$email,$category,$admin) =$message->GetDetailPerson($message,$to_id);
				 $list .= "<option > $firstname $surname &nbsp; ";
}

//       ======echo  $allperson;
		for($i=0;$i<$allperson;$i++){
				@list($id,$firstname,$surname,$email,$category,$admin) =$message->GetDetailPerson($message,$sendperson[$i]);
				 $list .= "<option > $firstname $surname &nbsp; ";
				//echo  "+++++".$sendperson[$i];
				$to_id ="";
				//echo  "+++++".$sendperson[0]; echo  "+++++".$sendperson[1]; echo  "+++++".$sendperson[2];
		}



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
																	'MTO'=>($to_id !='')?$to_id:"",
																	'Theme'=>$theme,
																	'P1'=>$P1,
																	'P2'=>$P2,
																	'P3'=>$P3,
																	'LIST'=>$list,
																	'SIZEL'=>($allperson !=0 || $to_id !='')?"5":"1",
														));

$template->pparse('body');							


?>