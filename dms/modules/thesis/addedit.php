<?php 
// load the record data
if ($thesis_id != '')
{	
	$thesis = Thesis::lookupThesis($thesis_id);
	//echo $Thesis->getThesisNameEng();	
} else {
	$thesis = new Thesis('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(),'', '', '', '', '', 
						'', '', '', '', '', '', '',
						'', '', '', '', '', '', '',
						'', '', '', '', ''
						);
}

?>
<script language="javascript">

function setColor(color) {
	var f = document.editFrm;
	if (color) {
		f.thesis_color_identifier.value = color;
	}
	test.style.background = f.thesis_color_identifier.value;
}

function submitIt() {
	var f = document.editFrm;
	var msg = '';

	if (f.thesis_name.value.length < 3) {
		msg += "\n<?php echo $user->_('thesisValidName');?>";
		f.thesis_name.focus();
	}
	if (f.thesis_color_identifier.value.length < 3) {
		msg += "\n<?php echo $user->_('thesisColor');?>";
		f.thesis_color_identifier.focus();
	}
	if (f.thesis_company.options[f.thesis_company.selectedIndex].value < 1) {
		msg += "\n<?php echo $user->_('thesisBadCompany');?>";
		f.thesis_name.focus();
	}
	if (f.thesis_end_date.value > 0 && f.thesis_end_date.value < f.thesis_start_date.value) {
		msg += "\n<?php echo $user->_('thesisBadEndDate1');?>";
	}
	if (f.thesis_actual_end_date.value > 0 && f.thesis_actual_end_date.value < f.thesis_start_date.value) {
		msg += "\n<?php echo $user->_('thesisBadEndDate2');?>";
	}
	if (msg.length < 1) {
		f.submit();
	} else {
		alert(msg);
	}
}
</script>
<script language='javascript' src='<? echo "./modules/thesis";?>/popcalendar.js'></script>
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
	if ((theForm.thesis_abstract.value != "")) {
		if (!checkFields(theForm.thesis_abstract))
			return false;
	}		
	
	if ((theForm.thesis_full.value != "")) {
		if (!checkFields(theForm.thesis_full))
			return false;	
	}		
	
	if (!validRequired(theForm.thesis_name_th,"Thesis Name Thai"))
		return false;
	
	if (!validRequired(theForm.thesis_name_eng,"Thesis Name English"))
		return false;

	if (!validRequired(theForm.thesis_advisor,"Thesis Advisor"))
		return false;

	var error_budget = true;
	
	for(var i=0; i<theForm.thesis_budget.value.length; i++)
	 {
	 	  for(var j=0; j<alphaChars.length; j++)
	 	  {
	 		   if(alphaChars.charAt(j)==theForm.thesis_budget.value.charAt(i))
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
	 	alert("Please enter a number for the \"Thesis Budget\" field.");
		theForm.thesis_budget.focus();
		return false;
	 }			
			
	if (theForm.thesis_year.value.length == 4) {	
		if ((theForm.thesis_year.value != "")) {
			if (!validNum(theForm.thesis_year,"Thesis Year",true))
				return false;
		}
	} else {
					alert("Thesis Year must input 4 digits.");
					return false;	
			}			
	/*		
	if ((theForm.thesis_no.value != "")) {
		if (!validNum(theForm.thesis_no,"Thesis No",true))
				return false;
		}
	else {
			alert("Thesis No must input number.");
				return false;	
		 }
	*/
	/*
	if (theForm.thesis_isbn.value.length >= 10 && theForm.thesis_isbn.value.length <= 13 ) {	
		if ((theForm.thesis_isbn.value != "")) {
			if (!validNum(theForm.thesis_isbn,"Thesis ISBN",true))
				return false;
		}
	} else {
					alert("Thesis ISBN must input number for 10 or 13 digits.");
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
<? if ($thesis_id == ''){?>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form name="editFrm" action="./index.php?m=thesis" method="post" onSubmit="return validateForm(this)" enctype="multipart/form-data">
    <input type="hidden" name="dosql" value="do_thesis_aed" />
    <input type="hidden" name="thesis_id" value="<?php echo $thesis_id;?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite"><input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('save');?>" />
        <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=thesis';}" /></td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Name Thai');?></td>
            <td width="100%"><textarea name="thesis_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Name English');?></td>
            <td width="100%"><textarea name="thesis_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisNameEng();?></textarea>
              <font color="#FF0000">** </font></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Owner');?></td>
            <td> <input type="hidden" name="thesis_owner_id" value="<?php if(@$thesis->getThesisOwner()!=0){echo $thesis->getThesisOwner();}else{echo @$user->getUserId();}?>" /> 
              <input type="text" name="thesis_owner_name" value="<?php if(@$thesis->getThesisOwnerName()!=""){echo $thesis->getThesisOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Advisor');?></td>
            <td width="100%"> <input type="text" name="thesis_advisor" value="<?php echo @$thesis->getThesisAdvisor();?>" size="40" maxlength="80" class="text" />
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Year');?></td>
            <td width="100%" nowrap="nowrap">
			<select name="thesis_year" class="text">
                <option value="-1" selected>-select-</option>
                <?
			for($i=0;$i<100;$i++){ 
			$dateVar = 1950 + $i; 
			?>
                <option value="<? echo $dateVar ?>" <? if (@$thesis->getThesisYear() == $dateVar){ echo "selected"; } ?>><? echo $dateVar;?></option>
                <?
			} 		
			?>
              </select> <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Encourage');?></td>
            <td><textarea name="thesis_encourage" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisEncourage();?></textarea> 
            </td>
          </tr>
		  <tr>
            <td align="right" nowrap="nowrap"><?php echo $user->_('Type');?> </td>
            <td>
			  <input type="radio" name="thesis_type" value="1" checked>
              Thesis
              <input type="radio" name="thesis_type" value="2">
              Independant Study
			</td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Budget');?> 
              (THB) </td>
            <td> <input type="Text" name="thesis_budget" value="<?php echo @$thesis->getThesisBudget();?>" maxlength="10" class="text" onblur="fixMoney(this)" /> 
            </td>
          </tr>
          <tr> 
            <td colspan="2"><hr noshade="noshade" size="1"></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 1');?></td>
            <td><input type="text" name="thesis_co1_name" value="<?php echo @$thesis->getThesisCo1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 2');?></td>
            <td><input type="text" name="thesis_co2_name" value="<?php echo @$thesis->getThesisCo2();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 3');?></td>
            <td><input type="text" name="thesis_co3_name" value="<?php echo @$thesis->getThesisCo3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 4');?></td>
            <td><input type="text" name="thesis_co4_name" value="<?php echo @$thesis->getThesisCo4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 5');?></td>
            <td><input type="text" name="thesis_co5_name" value="<?php echo @$thesis->getThesisCo5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Reward 1');?></td>
            <td colspan="3"><textarea name="thesis_reward1" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisReward1();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Reward 2');?></td>
            <td colspan="3"><textarea name="thesis_reward2" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisReward2();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('No');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_no" value="<?php echo @$thesis->getThesisNo();?>" size="25" maxlength="50" class="text" />
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('ISBN (for Thesis)');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_isbn" value="<?php echo @$thesis->getThesisISBN();?>" size="25" maxlength="50" class="text" />
            </td>
          </tr>
		  <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Abstract File');?></td>
            <td><input type="file" class="button" name="thesis_abstract" style="width:270px">
            </td>
          </tr>
		   <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Full File');?></td>
            <td><input type="file" class="button" name="thesis_full" style="width:270px">
            </td>
          </tr>
          <tr> 
            <td colspan="4"><hr noshade="noshade" size="1"> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 1');?></td>
            <td colspan="3"> <input type="text" name="thesis_keyword1" value="<?php echo @$thesis->getThesisKeyword1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 2');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword2" value="<?php echo @$thesis->getThesisKeyword2();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 3');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword3" value="<?php echo @$thesis->getThesisKeyword3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 4');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword4" value="<?php echo @$thesis->getThesisKeyword4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 5');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword5" value="<?php echo @$thesis->getThesisKeyword5();?>" size="25" maxlength="50" class="text" /></td>
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
  <form name="editFrm" action="./index.php?m=thesis" method="post" onSubmit="return validateForm(this)">
    <input type="hidden" name="dosql" value="do_thesis_aed" />
    <input type="hidden" name="thesis_id" value="<?php echo $thesis_id;?>" />
	<input type="hidden" name="thesis_abstract" value="<?php echo @$thesis->getThesisAbstract();?>" />
	<input type="hidden" name="thesis_full" value="<?php echo @$thesis->getThesisFull();?>" />
	<input type="hidden" name="thesis_owner_name" value="<?php echo @$thesis->getThesisOwnerName();?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite"><input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('save');?>" />
        <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=thesis';}" /></td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Name Thai');?></td>
            <td width="100%"><textarea name="thesis_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Name English');?></td>
            <td width="100%"><textarea name="thesis_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisNameEng();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Owner');?></td>
            <td> <input type="hidden" name="thesis_owner_id" value="<?php if(@$thesis->getThesisOwner()!=0){echo $thesis->getThesisOwner();}else{echo @$user->getUserId();}?>" /> 
              <input type="text" name="thesis_owner_name" value="<?php if(@$thesis->getThesisOwnerName()!=""){echo $thesis->getThesisOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Advisor');?></td>
            <td width="100%"> <input type="text" name="thesis_advisor" value="<?php echo @$thesis->getThesisAdvisor();?>" size="40" maxlength="80" class="text" />
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Year');?></td>
            <td width="100%" nowrap="nowrap">
			<select name="thesis_year" class="text">
                <option value="-1" selected>-select-</option>
                <?
			for($i=0;$i<100;$i++){ 
			$dateVar = 1950 + $i; 
			?>
                <option value="<? echo $dateVar ?>" <? if (@$thesis->getThesisYear() == $dateVar){ echo "selected"; } ?>><? echo $dateVar;?></option>
                <?
			} 		
			?>
              </select> <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Encourage');?></td>
            <td><textarea name="thesis_encourage" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisEncourage();?></textarea> 
            </td>
          </tr>
		  <tr>
            <td align="right" nowrap="nowrap"><?php echo $user->_('Type');?> </td>
            <td>
			  <input type="radio" name="thesis_type" value="1" <? if (@$thesis->getThesisType() == 1) echo "checked";?>>
              Thesis
              <input type="radio" name="thesis_type" value="2" <? if (@$thesis->getThesisType() == 2) echo "checked";?>>
              Independant Study
			</td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Budget');?> 
              (THB) </td>
            <td> <input type="Text" name="thesis_budget" value="<?php echo @$thesis->getThesisBudget();?>" maxlength="10" class="text" onblur="fixMoney(this)" /> 
            </td>
          </tr>
          <tr> 
            <td colspan="2"><hr noshade="noshade" size="1"></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 1');?></td>
            <td><input type="text" name="thesis_co1_name" value="<?php echo @$thesis->getThesisCo1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 2');?></td>
            <td><input type="text" name="thesis_co2_name" value="<?php echo @$thesis->getThesisCo2();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 3');?></td>
            <td><input type="text" name="thesis_co3_name" value="<?php echo @$thesis->getThesisCo3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 4');?></td>
            <td><input type="text" name="thesis_co4_name" value="<?php echo @$thesis->getThesisCo4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 5');?></td>
            <td><input type="text" name="thesis_co5_name" value="<?php echo @$thesis->getThesisCo5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Reward 1');?></td>
            <td colspan="3"><textarea name="thesis_reward1" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisReward1();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Reward 2');?></td>
            <td colspan="3"><textarea name="thesis_reward2" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$thesis->getThesisReward2();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('No');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_no" value="<?php echo @$thesis->getThesisNo();?>" size="25" maxlength="50" class="text" />
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('ISBN (for Thesis)');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_isbn" value="<?php echo @$thesis->getThesisISBN();?>" size="25" maxlength="50" class="text" />
            </td>
          </tr>
          <tr> 
            <td colspan="4"><hr noshade="noshade" size="1"> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 1');?></td>
            <td colspan="3"> <input type="text" name="thesis_keyword1" value="<?php echo @$thesis->getThesisKeyword1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 2');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword2" value="<?php echo @$thesis->getThesisKeyword2();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 3');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword3" value="<?php echo @$thesis->getThesisKeyword3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 4');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword4" value="<?php echo @$thesis->getThesisKeyword4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 5');?></td>
            <td nowrap="nowrap"><input type="text" name="thesis_keyword5" value="<?php echo @$thesis->getThesisKeyword5();?>" size="25" maxlength="50" class="text" /></td>
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
<? if ($thesis_id != ''){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Abstract File</h2></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tdborder1">
<form name="uploadFrm" action="?m=thesis" enctype="multipart/form-data" method="post" onSubmit="return checkFields(this.thesis_abstract);">
	<input type="hidden" name="max_file_size" value="109605000" />
	<input type="hidden" name="dosql" value="do_thesis_aed" />
	<input type="hidden" name="del" value="0" />
	<input type="hidden" name="file_a" value="1" />
	<input type="hidden" name="thesis_id" value="<?php echo $thesis_id;?>" />
	<input type="hidden" name="thesis_owner_id" value="<?php echo @$thesis->getThesisOwner();?>" />
	<input type="hidden" name="thesis_owner_name" value="<?php echo @$thesis->getThesisOwnerName();?>" />
	<input type="hidden" name="thesis_name_eng" value="<?php echo @$thesis->getThesisNameEng();?>" />
	<input type="hidden" name="thesis_name_th"  value="<?php echo @$thesis->getThesisNameTh();?>" />
	<input type="hidden" name="thesis_advisor"  value="<?php echo @$thesis->getThesisAdvisor();?>" />
	<input type="hidden" name="thesis_co1_name" value="<?php echo @$thesis->getThesisCo1();?>" />
	<input type="hidden" name="thesis_co2_name" value="<?php echo @$thesis->getThesisCo2();?>" />
	<input type="hidden" name="thesis_co3_name" value="<?php echo @$thesis->getThesisCo3();?>" />
	<input type="hidden" name="thesis_co4_name" value="<?php echo @$thesis->getThesisCo4();?>" />
	<input type="hidden" name="thesis_co5_name" value="<?php echo @$thesis->getThesisCo5();?>" />
	<input type="hidden" name="thesis_year" value="<?php echo @$thesis->getThesisYear();?>" />
	<input type="hidden" name="thesis_encourage" value="<?php echo @$thesis->getThesisEncourage();?>" />
	<input type="hidden" name="thesis_type" value="<?php echo @$thesis->getThesisType();?>" />
	<input type="hidden" name="thesis_budget" value="<?php echo @$thesis->getThesisBudget();?>" />
	<input type="hidden" name="thesis_reward1" value="<?php echo @$thesis->getThesisReward1();?>" />
	<input type="hidden" name="thesis_reward2" value="<?php echo @$thesis->getThesisReward2();?>" />
	<input type="hidden" name="thesis_no"  value="<?php echo @$thesis->getThesisNo();?>" />
	<input type="hidden" name="thesis_isbn" value="<?php echo @$thesis->getThesisISBN();?>" />
	<input type="hidden" name="thesis_picture" value="<?php echo @$thesis->getThesisPicture();?>" />
	<input type="hidden" name="thesis_full" value="<?php echo @$thesis->getThesisFull();?>" />
	<input type="hidden" name="thesis_keyword1" value="<?php echo @$thesis->getThesisKeyword1();?>" />
	<input type="hidden" name="thesis_keyword2" value="<?php echo @$thesis->getThesisKeyword2();?>" />
	<input type="hidden" name="thesis_keyword3" value="<?php echo @$thesis->getThesisKeyword3();?>" />
	<input type="hidden" name="thesis_keyword4" value="<?php echo @$thesis->getThesisKeyword4();?>" />
	<input type="hidden" name="thesis_keyword5" value="<?php echo @$thesis->getThesisKeyword5();?>" />
	<tr>
		  <td valign="top" class="hilite"><input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'save' );?>" />
			<input class="button" type="button" name="cancel2" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=thesis';}" /></td>
		</tr>	
	<tr>
	<td width="100%" valign="top" align="center">
		<table cellspacing="1" cellpadding="2" width="60%">
		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
			<td align="left" class="hilite"><?php echo @$thesis->getThesisAbstract();?></td>			
		</tr>
		<tr valign="top">
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
			<td align="left" class="hilite">
			<?php //echo $obj->file_type;
				$typeFile=@$thesis->getThesisAbstract();		
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
				$allpath="../files/dms/thesis/".$thesis->getThesisId();
				if (@$thesis->getThesisAbstract() != "") {
				$doc_filesize = filesize($allpath."/".@$thesis->getThesisAbstract());
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
			<td align="left" class="hilite"><?php echo @$thesis->getThesisOwnerName();?></td>
		</tr>						

		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
			<td align="left">
			<input type="file" class="button" name="thesis_abstract" style="width:270px">
            </td>
		</tr>

		</table>
	</td>
</tr>
</form>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Full File</h2></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tdborder1">
<form name="uploadFrm" action="?m=thesis" enctype="multipart/form-data" method="post" onSubmit="return checkFields(this.thesis_full);">
	<input type="hidden" name="max_file_size" value="109605000" />
	<input type="hidden" name="dosql" value="do_thesis_aed" />
	<input type="hidden" name="del" value="0" />
	<input type="hidden" name="file_f" value="1" />
	<input type="hidden" name="thesis_id" value="<?php echo $thesis_id;?>" />
	<input type="hidden" name="thesis_owner_id" value="<?php echo @$thesis->getThesisOwner();?>" />
	<input type="hidden" name="thesis_owner_name" value="<?php echo @$thesis->getThesisOwnerName();?>" />
	<input type="hidden" name="thesis_name_eng" value="<?php echo @$thesis->getThesisNameEng();?>" />
	<input type="hidden" name="thesis_name_th"  value="<?php echo @$thesis->getThesisNameTh();?>" />
	<input type="hidden" name="thesis_advisor"  value="<?php echo @$thesis->getThesisAdvisor();?>" />
	<input type="hidden" name="thesis_co1_name" value="<?php echo @$thesis->getThesisCo1();?>" />
	<input type="hidden" name="thesis_co2_name" value="<?php echo @$thesis->getThesisCo2();?>" />
	<input type="hidden" name="thesis_co3_name" value="<?php echo @$thesis->getThesisCo3();?>" />
	<input type="hidden" name="thesis_co4_name" value="<?php echo @$thesis->getThesisCo4();?>" />
	<input type="hidden" name="thesis_co5_name" value="<?php echo @$thesis->getThesisCo5();?>" />
	<input type="hidden" name="thesis_year" value="<?php echo @$thesis->getThesisYear();?>" />
	<input type="hidden" name="thesis_encourage" value="<?php echo @$thesis->getThesisEncourage();?>" />
	<input type="hidden" name="thesis_type" value="<?php echo @$thesis->getThesisType();?>" />
	<input type="hidden" name="thesis_budget" value="<?php echo @$thesis->getThesisBudget();?>" />
	<input type="hidden" name="thesis_reward1" value="<?php echo @$thesis->getThesisReward1();?>" />
	<input type="hidden" name="thesis_reward2" value="<?php echo @$thesis->getThesisReward2();?>" />
	<input type="hidden" name="thesis_no"  value="<?php echo @$thesis->getThesisNo();?>" />
	<input type="hidden" name="thesis_isbn" value="<?php echo @$thesis->getThesisISBN();?>" />
	<input type="hidden" name="thesis_picture" value="<?php echo @$thesis->getThesisPicture();?>" />
	<input type="hidden" name="thesis_abstract" value="<?php echo @$thesis->getThesisAbstract();?>" />
	<input type="hidden" name="thesis_keyword1" value="<?php echo @$thesis->getThesisKeyword1();?>" />
	<input type="hidden" name="thesis_keyword2" value="<?php echo @$thesis->getThesisKeyword2();?>" />
	<input type="hidden" name="thesis_keyword3" value="<?php echo @$thesis->getThesisKeyword3();?>" />
	<input type="hidden" name="thesis_keyword4" value="<?php echo @$thesis->getThesisKeyword4();?>" />
	<input type="hidden" name="thesis_keyword5" value="<?php echo @$thesis->getThesisKeyword5();?>" />
	<tr>
		  <td valign="top" class="hilite"><input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'save' );?>" />
			<input class="button" type="button" name="cancel2" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=thesis';}" /></td>
		</tr>	
	<tr>
	<td width="100%" valign="top" align="center">
		<table cellspacing="1" cellpadding="2" width="60%">
		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
			<td align="left" class="hilite"><?php echo @$thesis->getThesisFull();?></td>			
		</tr>
		<tr valign="top">
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
			<td align="left" class="hilite">
			<?php //echo $obj->file_type;
				$typeFile=@$thesis->getThesisFull();		
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
				$allpath="../files/dms/full_thesis/".$thesis->getThesisId();
				if (@$thesis->getThesisFull() != "") {
				$doc_filesize = filesize($allpath."/".@$thesis->getThesisFull());
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
			<td align="left" class="hilite"><?php echo @$thesis->getThesisOwnerName();?></td>
		</tr>						

		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
			<td align="left">
			<input type="file" class="button" name="thesis_full" style="width:270px">
            </td>
		</tr>

		</table>
	</td>
</tr>
</form>
</table>

<? }?>