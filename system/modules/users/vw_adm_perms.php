<script language="javascript">
function editPerm( id, gon, vl) {
/*
	id = Permission_id
	gon =permission_grant_on
	vl =permission_value
*/
	//alert( 'id='+id+'\ngon='+gon+'\nvalue='+vl);
	
	var f = document.frmPerms;

	f.sqlaction2.value="edit";
	
	f.permission_id.value = id;
	
	for(var i=0, n=f.permission_grant_on.options.length; i < n; i++) {
		if (f.permission_grant_on.options[i].value == gon) {
			f.permission_grant_on.selectedIndex = i;
			break;
		}
	}
	//f.permission_value.value = 1;
	//f.permission_value.checked = 1;
	
}

function clearIt(id){
	var f = document.frmPerms;
	f.sqlaction2.value = "add";
	f.permission_id.value = id;
	f.permission_grant_on.selectedIndex = 0;
}

function delPerm(id,gon) {
	if (confirm( 'Are you sure you want to delete this permission?' )) {
		var f = document.frmPerms;
		f.del.value = 1;
		f.permission_id.value = id;
		f.permission_grant_on.value = gon;
		f.submit();
	}
}
</script>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="tdbackground">
<tr><td width="50%" valign="top">

	<table width="100%" border="0" cellpadding="2" cellspacing="1" >
	<tr class="boxcolor">
		<td>&nbsp;</td>
		<td width="60%" align="center" nowrap="nowrap" class="main_white "><?php echo $user->_($strSystem_LabLevel);?></td>	
		<td align="center" nowrap class="main_white"><?php echo $user->_($strSystem_LabGrant);?></td>
		<td>&nbsp;</td>
	</tr>
	<?php
		$permission = new Permission('', '', '', '', '', '', '', '',''); 
		$row = $permission->SelectAdminPerm($users->getUsersId());
		$permission->ShowTableAdminPerm($row,$tab);
		if(count($row)!=0){
			$perm2 = Permission::lookupPermission($users->getUsersId());
		}
	?>
	</table>

	<table>
	<tr>
		<td class="hilite"><?php echo $user->_('Key');?>:</td>
		<td>&nbsp; &nbsp;</td>
		<td bgcolor="#ffc235">&nbsp; &nbsp;</td>
		<td class="hilite">= <?php echo $user->_('Super Admin');?></td>
		<td>&nbsp; &nbsp;</td>
		<td bgcolor="#ffff99">&nbsp; &nbsp;</td>
		<td class="hilite">= <?php echo $user->_('Other Admin');?></td>
	</tr>
	</table>

</td>
<td width="50%" valign="top">
	<table cellspacing="0" cellpadding="2" border="0" class="tdborder2" width="100%">
        <form name="frmPerms" method="post" action="./index.php?m=users&a=view&users_id=<?php echo $users->getUsersId();?>">
          <input type="hidden" name="del" value="0" />
          <input type="hidden" name="dosql" value="do_perms_adm_aed" />
          <input type="hidden" name="users_id" value="<?php echo $users->getUsersId();?>" />
          <input type="hidden" name="permission_users" value="<?php echo $users->getUsersId();?>" />
          <input type="hidden" name="permission_id" value="<?php if($perm2->getSysAdminId()!=0) { echo $perm2->getSysAdminId(); } else { echo "0";}?>" />
          <tr class="Boxcolor"> 
            <td colspan="2" align="center" class="Bcolor"><?php echo $user->_($strSystem_LabAddEditPer);?></td>
          </tr>
          <tr> 
            <td width="15%" align="right" nowrap ><?php echo $user->_($strSystem_LabLevel);?>:</td>
            <td width="85%"> 
              <?php //echo arraySelect($modules, 'permission_grant_on', 'size="1" class="text"', 'all');?>
			  <select name="permission_grant_on" style="font-size:10px">
                <option value="0">--select--</option>
                <option value="1">&#8226;Super Administrator</option>				
                <option value="2">&nbsp;&nbsp;&#8226;Course Administrator</option>
                <option value="3">&nbsp;&nbsp;&#8226;DMS Administrator</option>
				<option value="4">&nbsp;&nbsp;&#8226;Master Data Administrator</option>
				<option value="5">&nbsp;&nbsp;&#8226;System Administrator</option>
				<option value="6">&nbsp;&nbsp;&#8226;Users Administrator</option>
				<option value="7">&nbsp;&nbsp;&#8226;Report Administrator</option>
              </select>
            </td>
          </tr>		 
          <tr> 
            <td nowrap align="right" >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite"> <input type="submit" value="<?php echo $user->_($strAdd);?>" class="button" name="sqlaction2">
            </td>
            <td class="hilite" align="right"><input type="reset" value="<?php echo $user->_($strReset);?>" class="button" name="sqlaction" onClick="clearIt('<?php if(count($row!=0)) {echo $row["sys_admin_id"];} else { echo "0";}?>');"></td>
          </tr>
        </form>
      </table>



</td>
</tr>

</table>
