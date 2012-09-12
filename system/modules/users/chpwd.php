<?php 
// check for change password
if ($update == '' || $update == 1) {

	$old_pwd = trim($_POST["old_pwd"]);
	$new_pwd1 = trim($_POST["new_pwd1"]);
	$new_pwd2 = trim($_POST["new_pwd2"]);
	
	// has the change form been posted
	
	if ($old_pwd && $new_pwd1 && $new_pwd2 && $new_pwd1 == $new_pwd2 ) {
		// check that the old password matches
				
		$users = Users::lookupUsers($users_id);
		
		if($users->checkPassword($users_id, $old_pwd)) {	
			$users->users_password = $new_pwd1;
			$users->update($users);
			if($edit==1){
				if($users_id ==$person['id']){
		?>
				<html>
				<head>
				<meta http-equiv="refresh" content="0;url=http://<? echo getenv("SERVER_NAME");?>/vec/include/logout.php">
				</head>
				</html>
				<? }else{?>
				<html>
<head>
	<title></title>
	<LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
	<META HTTP-EQUIV="Refresh" CONTENT="1;URL=index.php?m=users&a=list">	
</head>
</html>
<? }?>
			<? }else{
				echo $user->_($strSystem_LabChangePWUpdate);
			?>
				<script language="javascript">
					window.close();
				</script>
			<?}?>
<?} else {
			echo $user->_($strSystem_LabChangePWWrong);
		}
	} else {
?>
		<script language="javascript">
		function submitIt() {
			var f = document.frmEdit;
			var msg = '';
		
			if (f.old_pwd.value == "") {
				msg += "\n<?php echo $user->_($strSystem_LabChangePWValidOld);?>";
				f.old_pwd.focus();
			}
			if (f.new_pwd1.value.length < 3) {
				msg += "\n<?php echo $user->_($strSystem_LabChangePWValidNew);?>";
				f.new_pwd1.focus();
			}
			if (f.new_pwd1.value != f.new_pwd2.value) {
				msg += "\n<?php echo $user->_($strSystem_LabChangePWNoMatch);?>";
				f.new_pwd2.focus();
			}
			
			if (f.new_pwd1.value == "") {
				msg += "\n<?php echo $user->_($strSystem_LabChangePWValidNewEmpty);?>";
				f.new_pwd1.focus();
			}

			if (f.new_pwd2.value == "") {
				msg += "\n<?php echo $user->_($strSystem_LabChangePWValidNewEmpty);?>";
				f.new_pwd2.focus();
			}


			if (msg.length < 1) {
				f.submit();
			} else {
				alert(msg);
			}
		}
		</script>
		<h1><?php echo $user->_($strPersonal_LabChangePassword);?></h1>
<title><?php echo $user->_($strPersonal_LabChangePassword);?></title>
<link rel="stylesheet" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css" >		
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tdborder2">
<? if($users_id==$person['id']){?>
	<form name="frmEdit" method="post" onsubmit="return false" target="_top" >
	<? }else{?>
	<form name="frmEdit" method="post" onsubmit="return false" >
	<? }?>
  <input type="hidden" name="users_id" value="<?php echo $users_id;?>" />
  <input type="hidden" name="update" value="1" />
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2" class="hilite"><input type="button" value="<?php echo $user->_($strSave);?>" onclick="submitIt()" class="button">
		<? if($edit==1){?>
			<input type="reset" value="<?php echo $user->_($strBack);?>" onclick="history.back();" class="button">
		<? }?>
	</td>
  </tr>
  <tr> 
    <td align="right" nowrap="nowrap"><?php echo $user->_($strSystem_LabCurrentPass);?></td>
    <td><input type="password" name="old_pwd" class="text"></td>
  </tr>
  <tr> 
    <td align="right" nowrap="nowrap"><?php echo $user->_($strSystem_LabNewPass);?></td>
    <td><input type="password" name="new_pwd1" class="text"></td>
  </tr>
  <tr> 
    <td align="right" nowrap="nowrap"><?php echo $user->_($strSystem_LabRepeatPass);?></td>
    <td><input type="password" name="new_pwd2" class="text"></td>
  </tr><form>
</table>
<?php
	}
} else {
	echo $user->_('chgpwLogin');
}
?>