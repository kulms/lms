<link rel="STYLESHEET" type="text/css" href="../../themes/<?php echo $theme;?>/style/main.css">
<? 
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'msg_menu.html',
							));   

		$template->assign_vars(array(
																'MINBOX'=>$strPersonal_msg_inbox,
																'MOUTBOX'=>$strPersonal_msg_Outbox,
																'MSENTBOX'=>$strPersonal_msg_Sentbox,
																'MSAVEBOX'=>$strPersonal_msg_Savebox,
																'MMSG'=>$strPersonal_MenuMsg,
														));

$template->pparse('body');							
 mysql_close();