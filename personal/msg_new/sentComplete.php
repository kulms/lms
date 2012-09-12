<? 
session_start();
require("../../include/global_login.php");
require("../../include/online.php");
require("../../include/function.inc.php");
require("message.class.php");
include('classes/config.inc.php');
require ("msg_menu.php");

$message =new Message('',$person['id']);
$template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'sentComplete.html',
														));   

if(isset($_POST[send])){   // ----- sending
		//echo $mto;
		if($mto !="") $message->sentMsg($_POST[mPri],$_POST[mSbj],$_POST[mMsg],$person[id],$mto); 
				//  ======echo  $allperson;
				for($i=0;$i<$allperson;$i++){
						//echo  "+++++".$sendperson[$i];
						$message->sentMsg($_POST[mPri],$_POST[mSbj],$_POST[mMsg],$person[id],$sendperson[$i]); // Send Message
				}


session_unregister("sendperson");
session_unregister("allperson");
		/* session_unregister("mSbj");
		 session_unregister("mPri");
		session_unregister("mMsg");  */
					

					$template->assign_vars(array(
														'NEW'=>$strPersonal_msg_New,
														'BODY_BOX'=>$strPersonal_msg_SentComplete,
														'LINK'=>"<a href=\"index.php\">$strPersonal_msg_inbox</a>",
														
								));

}  //  check send


//============= IF  click  SAVE   OR  DELETE ==========
if((isset($_POST[save])) || (isset($_POST[del]))){

			$template->assign_vars(array('NEW'=>$strPersonal_msg_New,
																	));
			if($_POST[msg_id]==""){
				$template->assign_vars(array(
		  															'BODY_BOX'=>"<img src=\"images/warn5.gif\"  align=\"absmiddle\"> ".$strPersonal_msg_ChooseMsg,
																	'LINK'=>"<img src=\"images/back1.gif\"  align=\"absmiddle\">&nbsp;<a href=\"javascript:history.back()\">$strBack</a>",
																	)); 
		}else{
         //==== IF  click  Check BOX====
			if(isset($_POST[save])){
						if($_POST[num_i] !=""){
								for($i=0;$i<$_POST[num_i];$i++){
											if($msg_id[$i] != ""){
																//echo $msg_id[$i]."<br>";
																$message->updateType(3,$msg_id[$i]); 
													}
									}				
							}else{
									$message->updateType(3,$_POST[msg_id]);  //  1 message FROM  read_msg.php
							}
							$template->assign_vars(array('BODY_BOX'=>$strPersonal_msg_AlreadySave,
																					'LINK'=>"<a href=\"index.php\">$strPersonal_msg_inbox</a>",
																						));
		
			}else if(isset($_POST[del])){  //============DELETE MESSAGE===========
					if($_POST[num_i] !=""){
							for($i=0;$i<$_POST[num_i];$i++){
										if($msg_id[$i] != ""){
												//echo $msg_id[$i]."<br>";
												$message->updateType(4,$msg_id[$i]); 
										}
							}				
					}else{
						  	$message->updateType(4,$_POST[msg_id]); 
					}
			  $template->assign_vars(array('BODY_BOX'=>$strPersonal_msg_AlreadyDel,
																	'LINK'=>"<a href=\"index.php\">$strPersonal_msg_inbox</a>",
																	));
			}
	}
}

$template->pparse('body');							


?>