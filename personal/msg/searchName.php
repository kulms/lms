<? 
session_start();

require("../../include/global_login.php");
require("../../include/online.php");
require("../../include/function.inc.php");
require("message.class.php");
include('classes/config.inc.php');
?>

<link rel="STYLESHEET" type="text/css" href="../../themes/<?php echo $theme;?>/style/main.css">
<?

$message =new Message('',$person['id']);
@list($id,$login,$firstname,$surname) =  $message->getListUser($_POST[keyWord],$_POST[userCat]);

//==========Template====================
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'searchName.html',
												));   
		$template->assign_vars(array('PLS'=>$strPersonal_msg_PleaseSelect,
																'KEY'=>$strPersonal_msg_KeyWord,
																'ALLUSER'=>$strPersonal_msg_All,
																'ADMIN'=>$strPersonal_msg_Admin,
																'TEACHER'=>$strPersonal_msg_Teacher,
																'STUDENT'=>$strPersonal_msg_Student,
																'SEARCH'=>$strPersonal_msg_Search,
																'TITLE'=>$strSearch,
														));

if(isset($id)){ 
			if(count($id)==0){
					$listName=$strPersonal_msg_NotFound;
			}else{
					$listName .="<select name=\"userName\" size=\"10\" >";
							for($i=0;$i<sizeof($id);$i++){
									 $listName .="<option value=\"$login[$i]\">$login[$i] [$firstname[$i]   $surname[$i]]</option>";
							}
					 $listName .="</select>";
					 $listName .= "<br><br><input class = \"button\" type=\"button\" name=\"select\" value=\"$strPersonal_msg_SelectName\" onClick=\"sendValue(this.form.userName);\">";
			}
}
	
$template->assign_vars(array('SHOWLIST'=>$listName,
												));



$template->pparse('body');							
 mysql_close();
				

?>