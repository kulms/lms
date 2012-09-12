<script Language="JavaScript">
function validRequired(formField,fieldLabel)
{
	var result = true;
	
	if (formField.value == "")
	{
		alert('Please enter a value for the "' + fieldLabel +'" field.');
		formField.focus();
		result = false;
	}
	
	return result;
}

function validateForm(theForm)
{
	// Customize these calls for your form

	// Start ------->
	
	if (!validRequired(theForm.FileImp,"File name"))
		return false;
	
	if (!validRequired(theForm.Deli,"Delimeter"))
		return false;
	// <--------- End
	return true;
}
function OpenFile(file){
	links = "./index.php?m=users&a=view_error&file_n="+file;
	window.open(links, "qWindow", "ScreenX=200,ScreenY=70,width=650,height=580,status=no,toolbar=no,menubar=no,scrollbars=yes");
}

</script>

<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder2">
  <form name="ImpUser" action="./index.php?m=users&tab=0" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this)">
    <input type="hidden" name="dosql" value="do_users_imp" />
    <input type="hidden" name="users_id" value="<?php echo $users_id;?>" />
    <tr bgcolor="#FFFFFF">
      <td colspan="2" valign="top" class="hilite">
        <input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_($strSave);?>" />
        <input class="button" type="button" name="cancel" value="<?php echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=users';}" />
      </td>
    </tr>
    <tr>
      <td  colspan="2" valign="top"><b><?php echo $user->_($strSystem_LabImpAdd);?></b>      </td>
    </tr>
    <tr>
      <td colspan="2" height="10">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%"><b><?php echo $user->_($strSystem_LabImpFile);?> : </b></td>
      <td width="86%"><input type="file" name="FileImp" size="45" maxlength="255" class="text"><font color="#FF0000">**</font>&nbsp;&nbsp;&nbsp;<a href="#">[<?php echo $user->_($strSystem_LabImpEx);?>]</a></td>
    </tr>
    <tr>
      <td><b><?php echo $user->_($strSystem_LabImpChar);?> :</b></td>
      <td ><input type="text" value="," name="Deli" size="3" class="text"><font color="#FF0000">**</font></td>
    </tr>
  </form>
</table>
<br>
<table width="100%"  border="0" cellspacing="0" cellpadding="0"  class="tdborder2">
  <tr>
    <td class="main">&nbsp;<b><? echo $user->_($strSystem_LabImpEx);?></b>
	</td>
  </tr>
  <tr>
    <td><table width="100%"  border="0">
      <tr>
        <td>Login,Password,Firstname,Category (<font color="#FF0000">**</font><strong>ในส่วนนี้จำเป็นต้องมีทุก ไฟล์</strong><font color="#FF0000">**</font>) </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>test1,tes1,test1,1 (<font color="#FF0000">**</font><strong>ตัวอย่างข้อมูล</strong> <font color="#FF0000">**</font>) </td>
      </tr>
      <tr>
        <td>test2,test2,test2,2</td>
      </tr>
      <tr>
        <td>test3,test3,test3,3</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td> </td>
  </tr>
</table>

<? 
if($ulink != ""){
$filename=$realpath."/system/modules/users/data_noinsert/".$ulink;
unlink($filename);
}

if($error==1){
		$dir=opendir("$realpath/system/modules/users/data_noinsert");
?> 
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder2">
  <tr>
    <td colspan="2"  ><b><?php echo $user->_($strSystem_LabImpError);?></b></td>
  </tr>
 <? while(($data=readdir($dir))){
		if($data == "." || $data == ".." )        continue; {
		$data1=explode("-", $data );
 ?>
  <tr>
    <td width="20%" ><a href="#" onClick="OpenFile('<? echo $data; ?>');"><? echo "$data1[0]/$data1[1]/$data1[2]";?>&nbsp;<? echo "$data1[3]:$data1[4]:$data1[5]";?></a></td>
    <td width="80%" ><a href="#" onClick="javascript:if(confirm('Are you sure you want to delete.')){location.href = './index.php?m=users&a=import&ulink=<? echo $data; ?>&error=1';}" >[<?php echo $user->_($strDelete);?>]</a></td>
  </tr>
  <? }
  }
  closedir($dir);
  ?>
</table>
<? }?>
