<?php 
// load the record data

if ($users_id != '')
{	
	$users = Users::lookupUsers($users_id);
	//echo $research->getResearchNameEng();	
} else {
	$users = new Users('', '', '', '', '',  
				   '', '', '', '', '', 
				   '', '', ''
				   );
}

?>
<script language='javascript' src='<? echo "./modules/users";?>/popcalendar.js'></script>
<script Language="JavaScript">
var alphaChars="1234567890.";
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

function allDigits(str)
{
	return inValidCharSet(str,"0123456789");
}

function inValidCharSet(str,charset)
{
	var result = true;

	// Note: doesn't use regular expressions to avoid early Mac browser bugs	
	for (var i=0;i<str.length;i++)
		if (charset.indexOf(str.substr(i,1))<0)
		{
			result = false;
			break;
		}
	
	return result;
}

function validNum(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		if (!allDigits(formField.value))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}


function validInt(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		var num = parseInt(formField.value,10);
 		if (isNaN(num))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}

var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=¡¢¤¦§¨©ª«¬­®¯°³±²´µ¶·¸º¼»¾¿ËÃ¹ÂÅÊÈÇÉÌÍÎÄÆ]/;

function checkFields(val) {

	missinginfo = "";
	if (val.value == "") {
		missinginfo += "\n     -  File Upload";
	}
	
	if (missinginfo != "") {
		missinginfo ="_____________________________\n" +
		"You failed to correctly fill in your:\n" +
		missinginfo + "\n_____________________________" +
		"\nPlease re-enter and submit again!";
		alert(missinginfo);
		return false;
	}
	else {
		//return true;
		if(val.value.search(mikExp) == -1) {
			//alert("Correct Input");
			return true;
		}
		else {
			alert("Sorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ·ÕèÁÕÍÑ¡ÉÃÀÒÉÒä·Â\n\r\n\rare not allowed!\n");
			return false;
		}
	}
}

function validSelect(formField,fieldLabel) {
	var strError;				
 	if(formField.selectedIndex == null) 
	{ 
	  alert("BUG: dontselect command for non-select Item"); 
	  return false; 
	} 
	if(formField.selectedIndex==0) 
	{ 
		strError = fieldLabel+" : Please Select one option ";
		alert(strError);
		return false;
	}
	return true;	
}		 

function validateForm(theForm)
{
	// Customize these calls for your form

	// Start ------->
		
	
	if (!validRequired(theForm.users_login,"User Login"))
		return false;
	
	if (!validRequired(theForm.users_password,"User Password"))
		return false;
	
	if (!validRequired(theForm.users_firstname,"User Firstname"))
		return false;	
		
	if (!validSelect(theForm.users_category,"User Category"))
		return false;								
	
	// <--------- End
	
	return true;
}
function checknum(){
	input = document.editFrm.users_id_number.value;
			if (isNaN(input)) 
			{
				alert("<?php echo $user->_($strPersonal_LabIDCodeError);?>");
				document.editFrm.users_id_number.value="";
				document.editFrm.users_id_number.focus()
				return false;
			}
}

function fixMoney(fld,sep)
{ // monetary field check
  if(!fld.value.length) return true; // blank fields are the domain of requireValue 
  var val= fld.value;
  if(typeof(sep)!='undefined') val= val.replace(sep,'');
  if(val.indexOf('$') == 0)
    val= parseFloat(val.substring(1,40));
  else
    val= parseFloat(val);
  if(isNaN(val))
  { // parse error 
    //status= 'The ' + fld.name + ' field must contain a dollar amount.';
    return false;
  }
  var sign= ( val < 0 ? '-': '' );
  val= Number(Math.round(Math.abs(val)*100)).toString();
  while(val.length < 2) val= '0'+val;
  var len= val.length;
  val= sign + ( len == 2 ? '0' : val.substring(0,len-2) ) + '.' + val.substring(len-2,len+1);
  fld.value= val;
  return true;
}

function validate_money(fld)
{
 if(fld.value=="")
  {
   //errormsg+='Please enter your Email.\n';
   //error_e=true;
   fld.focus();
  }
  else
  {
	// Validate Email Address !!!
	 if((fld.value.indexOf('.') == -1))
	  {
	   //errormsg+='Please enter Correct Email.\n';
	   //errormsg+='Ex: msit6@ku.ac.th.\n';	
	   //error_e=true;
	   //document.form.email.focus();
	   return false;
	  }
	 return true; 
  }
}
</script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />!-->

<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder2">
  <form name="editFrm" action="./index.php?m=users" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this)">
    <input type="hidden" name="dosql" value="do_users_aed" />
    <input type="hidden" name="users_id" value="<?php echo $users_id;?>" />
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" valign="top" class="hilite">
	  <input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_($strSave);?>" />
	  <input class="button" type="button" name="cancel" value="<?php echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=users';}" />         
	  </td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabUserName);?></td>
            <td width="100%"><input type="Text" name="users_login" value="<?php echo @$users->getUsersLogin();?>"  class="text"  size="35" /> 
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabPassword);?></td>
            <td width="100%"><input type="Text" name="users_password" value="<?php echo @$users->getUsersPassword();?>"  class="text"  size="35" /> 
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strSystem_LabUserStatus);?></td>
            <td> <input type="checkbox" name="users_active" value="1" <?php if(@$users->getUsersActive() == 0) { echo "";} else { echo "checked";} ?> >
              <?php echo $user->_($strSystem_LabActiveUser);?></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabNameTh);?></td>
            <td><input type="Text" name="users_firstname" value="<?php echo @$users->getUsersFirstName();?>"  class="text"  size="35" />
				<font color="#FF0000">**</font></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabSurNameTh);?></td>
            <td><input type="Text" name="users_surname" value="<?php echo @$users->getUsersSurName();?>"  class="text" size="35" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabEmail);?> 
            </td>
            <td><input type="Text" name="users_email" value="<?php echo @$users->getUsersEmail();?>"  class="text" size="35" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabHomepage);?> 
            </td>
            <td> <input type="Text" name="users_homepage" value="<?php echo @$users->getUsersHomepage();?>"  class="text" size="35" /></td>
          </tr>         
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strSystem_LabUserType);?></td>
            <td colspan="3"> <select name="users_category" style="font-size:10px">
                <option value="0">-Select-</option>
                <option value="1" <?php if(@$users->getUsersCategory() == 1) { echo "selected";}?>>admin</option>
                <option value="2" <?php if(@$users->getUsersCategory() == 2) { echo "selected";}?>>instructor</option>
                <option value="3" <?php if(@$users->getUsersCategory() == 3) { echo "selected";}?>>student</option>
              </select> 
			  <font color="#FF0000">**</font>
			  </td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strSystem_LabUserAdmin);?></td>
            <td colspan="3"> <input type="checkbox" name="users_admin" value="1" <?php if(@$users->getUsersAdmin() == 0) { echo "";} else { echo "checked";} ?> >
              admin </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabTitleTh);?></td>
            <td colspan="3"><input type="Text" name="users_title" value="<?php echo @$users->getUsersTitle();?>"  class="text" size="35" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabOtherEmail);?></td>
            <td nowrap="nowrap"><input type="Text" name="users_email2" value="<?php echo @$users->getUsersEmail2();?>"  class="text" size="35" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap" class="hilite"><?php echo $user->_($strPersonal_LabIDCode);?></td>
            <td nowrap="nowrap"><input type="Text" name="users_id_number" value="<?php echo @$users->getUsersIdNumber();?>"  class="text" size="35"onKeyUp="javascript: return checknum();" maxlength="20"/> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <font color="#FF0000"><strong>(** <?php echo $user->_($strSystem_LabRequired);?>)</strong></font> 
      </td>
      <td align="right">&nbsp; </td>
    </tr>
  </form>
</table>
