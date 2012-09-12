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
			echo $user->_('chgpwUpdated');
		} else {
			echo $user->_('chgpwWrongPW');
		}
	} else {
?>
		<script language="javascript">
		function submitIt() {
			var f = document.frmEdit;
			var msg = '';
		
			if (f.old_pwd.value.length < 3) {
				msg += "\n<?php echo $user->_('chgpwValidOld');?>";
				f.old_pwd.focus();
			}
			if (f.new_pwd1.value.length < 3) {
				msg += "\n<?php echo $user->_('chgpwValidNew');?>";
				f.new_pwd1.focus();
			}
			if (f.new_pwd1.value != f.new_pwd2.value) {
				msg += "\n<?php echo $user->_('chgpwNoMatch');?>";
				f.new_pwd2.focus();
			}
			if (msg.length < 1) {
				f.submit();
			} else {
				alert(msg);
			}
		}
		</script>
		<h1><?php echo $user->_('Change User Password');?></h1>
		
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="std"><form name="frmEdit" method="post" onsubmit="return false">
  <input type="hidden" name="users_id" value="<?php echo $users_id;?>" />
  <input type="hidden" name="update" value="1" />
  <tr> 
    <td colspan="2" class="hilite"><input type="button" value="<?php echo $user->_('save');?>" onclick="submitIt()" class="button"></td>
  </tr>
  <tr> 
    <td align="right" nowrap="nowrap"><?php echo $user->_('Current Password');?></td>
    <td><input type="password" name="old_pwd" class="text"></td>
  </tr>
  <tr> 
    <td align="right" nowrap="nowrap"><?php echo $user->_('New Password');?></td>
    <td><input type="password" name="new_pwd1" class="text"></td>
  </tr>
  <tr> 
    <td align="right" nowrap="nowrap"><?php echo $user->_('Repeat New Password');?></td>
    <td><input type="password" name="new_pwd2" class="text"></td>
  </tr><form>
</table>
<?php
	}
} else {
	echo $user->_('chgpwLogin');
}
?>