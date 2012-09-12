<?php 
// load the record data
if ($project_id != '')
{	
	$project = Project::lookupProject($project_id);
	//echo $Project->getProjectNameEng();	
} else {
	$project = new Project('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(),'', '', '', '', '', 
						'', '', '', '', '', '', 
						'', '', '', '', '','', '',
						'', '', '', '', ''
						);
}

?>
<script language='javascript' src='<? echo "./modules/project";?>/popcalendar.js'></script>
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

function validateForm(theForm)
{
	// Customize these calls for your form

	// Start ------->
	
	if ((theForm.project_abstract.value != "")) {
		if (!checkFields(theForm.project_abstract))
			return false;
	}
	
	if ((theForm.project_full.value != "")) {
		if (!checkFields(theForm.project_full))
			return false;
	}	
	
	if (!validRequired(theForm.project_name_th,"Project Name Thai"))
		return false;
	
	if (!validRequired(theForm.project_name_eng,"Project Name English"))
		return false;

	if (!validRequired(theForm.project_advisor,"Project Advisor"))
		return false;

	var error_budget = true;
	
	for(var i=0; i<theForm.project_budget.value.length; i++)
	 {
	 	  for(var j=0; j<alphaChars.length; j++)
	 	  {
	 		   if(alphaChars.charAt(j)==theForm.project_budget.value.charAt(i))
	 		   {			   		
	 				break;
	 		   }
	 		   else
	 		   {
	 				if(j==(alphaChars.length-1))
	 				{
	 					error_budget = false;												
	 				}
	 		   }
	 	  }
	 }
	 if (error_budget==false) {
	 	alert("Please enter a number for the \"Project Budget\" field.");
		theForm.project_budget.focus();
		return false;
	 }			
			
	if (theForm.project_year.value.length == 4) {	
		if ((theForm.project_year.value != "")) {
			if (!validNum(theForm.project_year,"Project Year",true))
				return false;
		}
	} else {
					alert("Project Year must input 4 digits.");
					return false;	
			}			
	/*			
	if ((theForm.project_no.value != "")) {
		if (!validNum(theForm.project_no,"Project No",true))
				return false;
		}
	else {
			alert("Project No must input number.");
				return false;	
		 }
	*/
	// <--------- End
	
	return true;
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
    status= 'The ' + fld.name + ' field must contain a dollar amount.';
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

<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<? if ($project_id == ''){?>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form action="./index.php?m=project" method="post" enctype="multipart/form-data" name="editFrm" onSubmit="return validateForm(this)">
    <input type="hidden" name="dosql" value="do_project_aed" />
    <input type="hidden" name="project_id" value="<?php echo $project_id;?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite"><input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('save');?>" />
        <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=project';}" /></td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Name Thai');?></td>
            <td width="100%"><textarea name="project_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$project->getProjectNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Name English');?></td>
            <td width="100%"><textarea name="project_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$project->getProjectNameEng();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Owner');?></td>
            <td> <input type="hidden" name="project_owner_id" value="<?php if(@$project->getProjectOwner()!=0){echo $project->getProjectOwner();}else{echo @$user->getUserId();}?>" /> 
              <input type="text" name="project_owner_name" value="<?php if(@$project->getProjectOwnerName()!=""){echo $project->getProjectOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Advisor');?></td>
            <td width="100%"> <input type="text" name="project_advisor" value="<?php echo @$project->getProjectAdvisor();?>" size="40" maxlength="80" class="text" />
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Year');?></td>
            <td width="100%" nowrap="nowrap">
			<select name="project_year" class="text">
                <option value="-1" selected>-select-</option>
                <?
			for($i=0;$i<100;$i++){ 
			$dateVar = 1950 + $i; 
			?>
                <option value="<? echo $dateVar ?>" <? if (@$project->getProjectYear() == $dateVar){ echo "selected"; } ?>><? echo $dateVar;?></option>
                <?
			} 		
			?>
              </select> <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Encourage');?></td>
            <td><textarea name="project_encourage" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$project->getProjectEncourage();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Budget');?> 
              (THB) </td>
            <td> <input type="Text" name="project_budget" value="<?php echo @$project->getProjectBudget();?>" maxlength="10" class="text" onblur="fixMoney(this)" /> 
            </td>
          </tr>
          <tr> 
            <td colspan="2"><hr noshade="noshade" size="1"></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 1');?></td>
            <td><input type="text" name="project_co1_name" value="<?php echo @$project->getProjectCo1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 2');?></td>
            <td><input type="text" name="project_co2_name" value="<?php echo @$project->getProjectCo2();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 3');?></td>
            <td><input type="text" name="project_co3_name" value="<?php echo @$project->getProjectCo3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 4');?></td>
            <td><input type="text" name="project_co4_name" value="<?php echo @$project->getProjectCo4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 5');?></td>
            <td><input type="text" name="project_co5_name" value="<?php echo @$project->getProjectCo5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Reward 1');?></td>
            <td colspan="3"><textarea name="project_reward1" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$project->getProjectReward1();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Reward 2');?></td>
            <td colspan="3"><textarea name="project_reward2" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$project->getProjectReward2();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project No');?></td>
            <td nowrap="nowrap"><input type="text" name="project_no" value="<?php echo @$project->getProjectNo();?>" size="25" maxlength="50" class="text" />
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Abstarct');?></td>
            <td ><input type="file" class="button" name="project_abstract" style="width:270px"> 
			</td>
          </tr>
		  <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Full');?></td>
            <td ><input type="file" class="button" name="project_full" style="width:270px"> 
			</td>
          </tr>
          <tr> 
            <td colspan="4"><hr noshade="noshade" size="1"> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 1');?></td>
            <td colspan="3"> <input type="text" name="project_keyword1" value="<?php echo @$project->getProjectKeyword1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 2');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword2" value="<?php echo @$project->getProjectKeyword2();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 3');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword3" value="<?php echo @$project->getProjectKeyword3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 4');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword4" value="<?php echo @$project->getProjectKeyword4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 5');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword5" value="<?php echo @$project->getProjectKeyword5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td><font color="#FF0000"><strong>(** Required field)</strong></font> </td>
      <td align="right">&nbsp; </td>
    </tr>
  </form>
</table>
<?
} else {
?>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form name="editFrm" action="./index.php?m=project" method="post" onSubmit="return validateForm(this)">
    <input type="hidden" name="dosql" value="do_project_aed" />
    <input type="hidden" name="project_id" value="<?php echo $project_id;?>" />
	<input type="hidden" name="project_abstract" value="<?php echo @$project->getProjectAbstract();?>" />
	<input type="hidden" name="project_full" value="<?php echo @$project->getProjectFull();?>" />
	<input type="hidden" name="project_owner_name" value="<?php echo @$project->getProjectOwnerName();?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite"><input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('save');?>" />
        <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=project';}" /></td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Name Thai');?></td>
            <td width="100%"><textarea name="project_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$project->getProjectNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Name English');?></td>
            <td width="100%"><textarea name="project_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$project->getProjectNameEng();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Owner');?></td>
            <td> <input type="hidden" name="project_owner_id" value="<?php if(@$project->getProjectOwner()!=0){echo $project->getProjectOwner();}else{echo @$user->getUserId();}?>" /> 
              <input type="text" name="project_owner_name" value="<?php if(@$project->getProjectOwnerName()!=""){echo $project->getProjectOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Advisor');?></td>
            <td width="100%"> <input type="text" name="project_advisor" value="<?php echo @$project->getProjectAdvisor();?>" size="40" maxlength="80" class="text" />
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Year');?></td>
            <td width="100%" nowrap="nowrap">
			<select name="project_year" class="text">
                <option value="-1" selected>-select-</option>
                <?
			for($i=0;$i<100;$i++){ 
			$dateVar = 1950 + $i; 
			?>
                <option value="<? echo $dateVar ?>" <? if (@$project->getProjectYear() == $dateVar){ echo "selected"; } ?>><? echo $dateVar;?></option>
                <?
			} 		
			?>
              </select> <font color="#FF0000">** </font></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Encourage');?></td>
            <td><textarea name="project_encourage" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$project->getProjectEncourage();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Budget');?> 
              (THB) </td>
            <td> <input type="Text" name="project_budget" value="<?php echo @$project->getProjectBudget();?>" maxlength="10" class="text" onblur="fixMoney(this)" /> 
            </td>
          </tr>
          <tr> 
            <td colspan="2"><hr noshade="noshade" size="1"></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 1');?></td>
            <td><input type="text" name="project_co1_name" value="<?php echo @$project->getProjectCo1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 2');?></td>
            <td><input type="text" name="project_co2_name" value="<?php echo @$project->getProjectCo2();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 3');?></td>
            <td><input type="text" name="project_co3_name" value="<?php echo @$project->getProjectCo3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 4');?></td>
            <td><input type="text" name="project_co4_name" value="<?php echo @$project->getProjectCo4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 5');?></td>
            <td><input type="text" name="project_co5_name" value="<?php echo @$project->getProjectCo5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Reward 1');?></td>
            <td colspan="3"><textarea name="project_reward1" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$project->getProjectReward1();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project Reward 2');?></td>
            <td colspan="3"><textarea name="project_reward2" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$project->getProjectReward2();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Project No');?></td>
            <td nowrap="nowrap"><input type="text" name="project_no" value="<?php echo @$project->getProjectNo();?>" size="25" maxlength="50" class="text" />
            </td>
          </tr>
          <tr> </tr>
          <tr> 
            <td colspan="4"><hr noshade="noshade" size="1"> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 1');?></td>
            <td colspan="3"> <input type="text" name="project_keyword1" value="<?php echo @$project->getProjectKeyword1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 2');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword2" value="<?php echo @$project->getProjectKeyword2();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 3');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword3" value="<?php echo @$project->getProjectKeyword3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 4');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword4" value="<?php echo @$project->getProjectKeyword4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 5');?></td>
            <td nowrap="nowrap"><input type="text" name="project_keyword5" value="<?php echo @$project->getProjectKeyword5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td><font color="#FF0000"><strong>(** Required field)</strong></font> </td>
      <td align="right">&nbsp; </td>
    </tr>
  </form>
</table>
<?
}
?>
<? if ($project_id != ''){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Abstract File</h2></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tdborder1">
  <form name="uploadFrm" action="?m=project" enctype="multipart/form-data" method="post" onSubmit="return checkFields(this.project_abstract);">
    <input type="hidden" name="max_file_size" value="109605000" />
    <input type="hidden" name="dosql" value="do_project_aed" />
    <input type="hidden" name="del" value="0" />
    <input type="hidden" name="file_a" value="1" />
    <input type="hidden" name="project_id" value="<?php echo $project_id;?>" />
	<input type="hidden" name="project_owner_id" value="<?php echo @$project->getProjectOwner();?>" />
	<input type="hidden" name="project_owner_name" value="<?php echo @$project->getProjectOwnerName();?>" />
    <input type="hidden" name="project_name_eng" value="<?php echo @$project->getProjectNameEng();?>" />
    <input type="hidden" name="project_name_th"  value="<?php echo @$project->getProjectNameTh();?>" />
    <input type="hidden" name="project_advisor"  value="<?php echo @$project->getProjectAdvisor();?>" />
    <input type="hidden" name="project_co1_name" value="<?php echo @$project->getProjectCo1();?>" />
    <input type="hidden" name="project_co2_name" value="<?php echo @$project->getProjectCo2();?>" />
    <input type="hidden" name="project_co3_name" value="<?php echo @$project->getProjectCo3();?>" />
    <input type="hidden" name="project_co4_name" value="<?php echo @$project->getProjectCo4();?>" />
    <input type="hidden" name="project_co5_name" value="<?php echo @$project->getProjectCo5();?>" />
    <input type="hidden" name="project_year" value="<?php echo @$project->getProjectYear();?>" />
    <input type="hidden" name="project_encourage" value="<?php echo @$project->getProjectEncourage();?>" />
    <input type="hidden" name="project_budget" value="<?php echo @$project->getProjectBudget();?>" />
    <input type="hidden" name="project_reward1" value="<?php echo @$project->getProjectReward1();?>" />
    <input type="hidden" name="project_reward2" value="<?php echo @$project->getProjectReward2();?>" />
    <input type="hidden" name="project_no"  value="<?php echo @$project->getProjectNo();?>" />
    <input type="hidden" name="project_isbn" value="<?php echo @$project->getProjectISBN();?>" />
    <input type="hidden" name="project_picture" value="<?php echo @$project->getProjectPicture();?>" />
	<input type="hidden" name="project_full" value="<?php echo @$project->getProjectFull();?>" />
    <input type="hidden" name="project_keyword1" value="<?php echo @$project->getProjectKeyword1();?>" />
    <input type="hidden" name="project_keyword2" value="<?php echo @$project->getProjectKeyword2();?>" />
    <input type="hidden" name="project_keyword3" value="<?php echo @$project->getProjectKeyword3();?>" />
    <input type="hidden" name="project_keyword4" value="<?php echo @$project->getProjectKeyword4();?>" />
    <input type="hidden" name="project_keyword5" value="<?php echo @$project->getProjectKeyword5();?>" />
    <tr>
      <td valign="top" class="hilite"><input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'save' );?>" />
        <input class="button" type="button" name="cancel2" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=project';}" /></td>
    </tr>
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
            <td align="left" class="hilite"><?php echo @$project->getProjectAbstract();?></td>
          </tr>
          <tr valign="top"> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
            <td align="left" class="hilite"> 
              <?php //echo $obj->file_type;
				$typeFile=@$project->getProjectAbstract();		
					$pos = strrpos($typeFile, ".");
					$rest = substr($typeFile, $pos+1);
					//echo $rest;
					if ($rest == "doc") echo "application/msword";
					if ($rest == "pdf") echo "application/pdf";
			?>
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
            <td align="left" class="hilite"> 
              <?php
				$allpath="../files/dms/project/".$project->getProjectId();
				if (@$project->getProjectAbstract() != "") {
				$doc_filesize = filesize($allpath."/".@$project->getProjectAbstract());
				if ($doc_filesize != 0) {
					echo GetSize ($doc_filesize);
					} 
				else echo "0 B";
				}
			?>
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Uploaded By' );?>:</td>
            <td align="left" class="hilite"><?php echo @$project->getProjectOwnerName();?></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
            <td align="left"> <input type="file" class="button" name="project_abstract" style="width:270px"> 
            </td>
          </tr>
        </table></td>
    </tr>    
  </form>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Full File</h2></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tdborder1">
  <form name="uploadFrm" action="?m=project" enctype="multipart/form-data" method="post" onSubmit="return checkFields(this.project_full);">
    <input type="hidden" name="max_file_size" value="109605000" />
    <input type="hidden" name="dosql" value="do_project_aed" />
    <input type="hidden" name="del" value="0" />
    <input type="hidden" name="file_f" value="1" />
    <input type="hidden" name="project_id" value="<?php echo $project_id;?>" />
	<input type="hidden" name="project_owner_id" value="<?php echo @$project->getProjectOwner();?>" />
	<input type="hidden" name="project_owner_name" value="<?php echo @$project->getProjectOwnerName();?>" />
    <input type="hidden" name="project_name_eng" value="<?php echo @$project->getProjectNameEng();?>" />
    <input type="hidden" name="project_name_th"  value="<?php echo @$project->getProjectNameTh();?>" />
    <input type="hidden" name="project_advisor"  value="<?php echo @$project->getProjectAdvisor();?>" />
    <input type="hidden" name="project_co1_name" value="<?php echo @$project->getProjectCo1();?>" />
    <input type="hidden" name="project_co2_name" value="<?php echo @$project->getProjectCo2();?>" />
    <input type="hidden" name="project_co3_name" value="<?php echo @$project->getProjectCo3();?>" />
    <input type="hidden" name="project_co4_name" value="<?php echo @$project->getProjectCo4();?>" />
    <input type="hidden" name="project_co5_name" value="<?php echo @$project->getProjectCo5();?>" />
    <input type="hidden" name="project_year" value="<?php echo @$project->getProjectYear();?>" />
    <input type="hidden" name="project_encourage" value="<?php echo @$project->getProjectEncourage();?>" />
    <input type="hidden" name="project_budget" value="<?php echo @$project->getProjectBudget();?>" />
    <input type="hidden" name="project_reward1" value="<?php echo @$project->getProjectReward1();?>" />
    <input type="hidden" name="project_reward2" value="<?php echo @$project->getProjectReward2();?>" />
    <input type="hidden" name="project_no"  value="<?php echo @$project->getProjectNo();?>" />
    <input type="hidden" name="project_isbn" value="<?php echo @$project->getProjectISBN();?>" />
    <input type="hidden" name="project_picture" value="<?php echo @$project->getProjectPicture();?>" />
	<input type="hidden" name="project_abstract" value="<?php echo @$project->getProjectAbstract();?>" />
    <input type="hidden" name="project_keyword1" value="<?php echo @$project->getProjectKeyword1();?>" />
    <input type="hidden" name="project_keyword2" value="<?php echo @$project->getProjectKeyword2();?>" />
    <input type="hidden" name="project_keyword3" value="<?php echo @$project->getProjectKeyword3();?>" />
    <input type="hidden" name="project_keyword4" value="<?php echo @$project->getProjectKeyword4();?>" />
    <input type="hidden" name="project_keyword5" value="<?php echo @$project->getProjectKeyword5();?>" />
    <tr>
      <td valign="top" class="hilite"><input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'save' );?>" />
        <input class="button" type="button" name="cancel2" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=project';}" /></td>
    </tr>
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
            <td align="left" class="hilite"><?php echo @$project->getProjectFull();?></td>
          </tr>
          <tr valign="top"> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
            <td align="left" class="hilite"> 
              <?php //echo $obj->file_type;
				$typeFile=@$project->getProjectFull();		
					$pos = strrpos($typeFile, ".");
					$rest = substr($typeFile, $pos+1);
					//echo $rest;
					if ($rest == "doc") echo "application/msword";
					if ($rest == "pdf") echo "application/pdf";
			?>
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
            <td align="left" class="hilite"> 
              <?php
				$allpath="../files/dms/full_project/".$project->getProjectId();
				if (@$project->getProjectFull() != "") {
				$doc_filesize = filesize($allpath."/".@$project->getProjectFull());
				if ($doc_filesize != 0) {
					echo GetSize ($doc_filesize);
					} 
				else echo "0 B";
				}
			?>
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Uploaded By' );?>:</td>
            <td align="left" class="hilite"><?php echo @$project->getProjectOwnerName();?></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
            <td align="left"> <input type="file" class="button" name="project_full" style="width:270px"> 
            </td>
          </tr>
        </table></td>
    </tr>    
  </form>
</table>

<? }?>