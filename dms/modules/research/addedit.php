<?php 
// load the record data
if ($research_id != '')
{	
	$research = Research::lookupResearch($research_id);
	//echo $research->getResearchNameEng();	
} else {
	$research = new Research('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), '', '', '', '', '', 
						'', '', '', '', '', '', '', 
						'', '', '', '', '', '',
						'', '', '', '', ''
						);
}

?>
<script language='javascript' src='<? echo "./modules/research";?>/popcalendar.js'></script>
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

var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=°¢§¶ß®©™´¨≠ÆØ∞≥±≤¥µ∂∑∏∫ºªæøÀ√π¬≈ »«…ÃÕŒƒ∆]/;

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
			alert("Sorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ∑’Ë¡’Õ—°…√¿“…“‰∑¬\n\r\n\rare not allowed!\n");
			return false;
		}
	}
}

function validateForm(theForm)
{
	// Customize these calls for your form

	// Start ------->
	
	if ((theForm.research_abstract.value != "")) {
		if (!checkFields(theForm.research_abstract))
			return false;
	}	
	
	if ((theForm.research_picture.value != "")) {
		if (!checkFields(theForm.research_picture))
			return false;
	}	
	
	if ((theForm.research_full.value != "")) {
		if (!checkFields(theForm.research_full))
			return false;	
	}		
	
	if (!validRequired(theForm.research_name_th,"Research Name Thai"))
		return false;
	
	if (!validRequired(theForm.research_name_eng,"Research Name English"))
		return false;
	
	var error_budget = true;
	
	for(var i=0; i<theForm.research_budget.value.length; i++)
	 {
	 	  for(var j=0; j<alphaChars.length; j++)
	 	  {
	 		   if(alphaChars.charAt(j)==theForm.research_budget.value.charAt(i))
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
	 	alert("Please enter a number for the \"Research Budget\" field.");
		theForm.research_budget.focus();
		return false;
	 }			
			
	if (theForm.research_year.value.length == 4) {	
		if ((theForm.research_year.value != "")) {
			if (!validNum(theForm.research_year,"Research Year",true))
				return false;
		}
	} else {
					alert("Research Year must input 4 digits.");
					return false;	
			}			
				
	if (theForm.research_isbn.value.length >= 10 && theForm.research_isbn.value.length <= 13 ) {	
		if ((theForm.research_isbn.value != "")) {
			if (!validNum(theForm.research_isbn,"Research ISBN",true))
				return false;
		}
	} else {
					alert("Research ISBN must input number for 10 or 13 digits.");
					return false;	
				}			
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

<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<? if ($research_id == ''){?>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form name="editFrm" action="./index.php?m=research" method="post" onSubmit="return validateForm(this)" enctype="multipart/form-data">
    <input type="hidden" name="dosql" value="do_research_aed" />
    <input type="hidden" name="research_id" value="<?php echo $research_id;?>" />
    <input type="hidden" name="research_abstract" value="<?php echo @$research->getResearchAbstract();?>" />
    <input type="hidden" name="research_picture" value="<?php echo @$research->getResearchPicture();?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite">
	  <input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('save');?>" />	
	  <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=research';}" />         
	  </td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Name Thai');?></td>
            <td width="100%"><textarea name="research_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$research->getResearchNameTh();?></textarea>	
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Name English');?></td>
            <td width="100%"><textarea name="research_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$research->getResearchNameEng();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Owner');?></td>
            <td> <input type="hidden" name="research_owner_id" value="<?php if(@$research->getResearchOwner()!=0){echo $research->getResearchOwner();}else{echo @$user->getUserId();}?>" />	
              <input type="text" name="research_owner_name" value="<?php if(@$research->getResearchOwnerName()!=""){echo $research->getResearchOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Year');?></td>
            <td width="100%" nowrap="nowrap"> <select name="research_year" class="text">
                <option value="-1" selected>-select-</option>
                <?
			for($i=0;$i<100;$i++){ 
			$dateVar = 1950 + $i; 
			?>
                <option value="<? echo $dateVar ?>" <? if (@$research->getResearchYear() == $dateVar){ echo "selected"; } ?>><? echo $dateVar;?></option>
                <?
			} 		
			?>
              </select> <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Supporting Fund');?></td>
            <td><textarea name="research_encourage" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$research->getResearchEncourage();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Start Date');?></td>
            <td> <input type="text" name="research_start_date" value="<?php echo @$research->getResearchStartDate();?>" class="text" onFocus="this.blur();"/> 
              <script language='javascript'>
				<!--
				  if (!document.layers) {
					document.write("<input type=button onclick='popUpCalendar(this, editFrm.research_start_date, \"yyyy-mm-dd\")' value=' Date ' style='font-size:11px'>")
				}
				//-->
			  </script> </td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Status');?> </td>
            <td>
			  <input type="radio" name="research_status" value="1" checked>
              ¬—ß‰¡Ë‡ √Á® 
              <input type="radio" name="research_status" value="2">
              ‡ √Á®·≈È«
			</td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Budget');?> 
              (THB) </td>
            <td> <input type="Text" name="research_budget" value="<?php echo @$research->getResearchBudget();?>" maxlength="10" class="text" onblur="fixMoney(this)" /> 
            </td>
          </tr>         
          <tr> 
            <td colspan="2"><hr noshade="noshade" size="1"></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 1');?></td>
            <td><input type="text" name="research_co1_name" value="<?php echo @$research->getResearchCo1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 2');?></td>
            <td><input type="text" name="research_co2_name" value="<?php echo @$research->getResearchCo2();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 3');?></td>
            <td><input type="text" name="research_co3_name" value="<?php echo @$research->getResearchCo3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 4');?></td>
            <td><input type="text" name="research_co4_name" value="<?php echo @$research->getResearchCo4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 5');?></td>
            <td><input type="text" name="research_co5_name" value="<?php echo @$research->getResearchCo5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Reward 1');?></td>
            <td colspan="3"><textarea name="research_reward1" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$research->getResearchReward1();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Reward 2');?></td>
            <td colspan="3"><textarea name="research_reward2" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$research->getResearchReward2();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research ISBN');?></td>
            <td nowrap="nowrap"><input type="text" name="research_isbn" value="<?php echo @$research->getResearchISBN();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">**</font></td>
          </tr>
		  <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Full Document');?></td>
            <td nowrap="nowrap"><input type="file" class="button" name="research_full" style="width:270px">
            </td>
          </tr>
		  <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Abstract');?></td>
            <td nowrap="nowrap"><input type="file" class="button" name="research_abstract" style="width:270px">
            </td>
          </tr>
		  <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Picture');?></td>
            <td nowrap="nowrap"><input type="file" class="button" name="research_picture" style="width:270px">
            </td>
          </tr>         
          <tr> 
            <td colspan="4"><hr noshade="noshade" size="1"> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 1');?></td>
            <td colspan="3"> <input type="text" name="research_keyword1" value="<?php echo @$research->getResearchKeyword1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 2');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword2" value="<?php echo @$research->getResearchKeyword2();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 3');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword3" value="<?php echo @$research->getResearchKeyword3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 4');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword4" value="<?php echo @$research->getResearchKeyword4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 5');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword5" value="<?php echo @$research->getResearchKeyword5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> 
	<font color="#FF0000"><strong>(** Required 
      field)</strong></font>
  
	  </td>
      <td align="right">&nbsp; </td>
    </tr>
  </form>
</table>
<?
} else {
?>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form name="editFrm" action="./index.php?m=research" method="post" onSubmit="return validateForm(this)">
    <input type="hidden" name="dosql" value="do_research_aed" />
    <input type="hidden" name="research_id" value="<?php echo $research_id;?>" />
    <input type="hidden" name="research_abstract" value="<?php echo @$research->getResearchAbstract();?>" />
    <input type="hidden" name="research_picture" value="<?php echo @$research->getResearchPicture();?>" />
	<input type="hidden" name="research_full" value="<?php echo @$research->getResearchFull();?>" />
	<input type="hidden" name="research_owner_name" value="<?php echo @$research->getResearchOwnerName();?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite">
	  <input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('save');?>" />	
	  <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=research';}" />         
	  </td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Name Thai');?></td>
            <td width="100%"><textarea name="research_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$research->getResearchNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Name English');?></td>
            <td width="100%"><textarea name="research_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$research->getResearchNameEng();?></textarea>
			  <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Owner');?></td>
            <td> <input type="hidden" name="research_owner_id" value="<?php if(@$research->getResearchOwner()!=0){echo $research->getResearchOwner();}else{echo @$user->getUserId();}?>" />	
              <input type="text" name="research_owner_name" value="<?php if(@$research->getResearchOwnerName()!=""){echo $research->getResearchOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Year');?></td>
            <td width="100%" nowrap="nowrap"> <select name="research_year" class="text">
                <option value="-1" selected>-select-</option>
                <?
			for($i=0;$i<100;$i++){ 
			$dateVar = 1950 + $i; 
			?>
                <option value="<? echo $dateVar ?>" <? if (@$research->getResearchYear() == $dateVar){ echo "selected"; } ?>><? echo $dateVar;?></option>
                <?
			} 		
			?>
              </select> <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Supporting Fund');?></td>
            <td><textarea name="research_encourage" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$research->getResearchEncourage();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Start Date');?></td>
            <td> <input type="text" name="research_start_date" value="<?php echo @$research->getResearchStartDate();?>" class="text" onFocus="this.blur();"/> 
              <script language='javascript'>
				<!--
				  if (!document.layers) {
					document.write("<input type=button onclick='popUpCalendar(this, editFrm.research_start_date, \"yyyy-mm-dd\")' value=' Date ' style='font-size:11px'>")
				}
				//-->
			  </script> </td>
          </tr>
		  <tr>
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Status');?> </td>
            <td>
			  <input type="radio" name="research_status" value="1" <? if (@$research->getResearchStatus() == 1) echo "checked";?>>
              ¬—ß‰¡Ë‡ √Á® 
              <input type="radio" name="research_status" value="2" <? if (@$research->getResearchStatus() == 2) echo "checked";?>>
              ‡ √Á®·≈È«
			</td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Budget');?> 
              (THB) </td>
            <td> <input type="Text" name="research_budget" value="<?php echo @$research->getResearchBudget();?>" maxlength="10" class="text" onblur="fixMoney(this)" /> 
            </td>
          </tr>
          <tr> 
            <td colspan="2"><hr noshade="noshade" size="1"></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 1');?></td>
            <td><input type="text" name="research_co1_name" value="<?php echo @$research->getResearchCo1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 2');?></td>
            <td><input type="text" name="research_co2_name" value="<?php echo @$research->getResearchCo2();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 3');?></td>
            <td><input type="text" name="research_co3_name" value="<?php echo @$research->getResearchCo3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 4');?></td>
            <td><input type="text" name="research_co4_name" value="<?php echo @$research->getResearchCo4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('CoWorker 5');?></td>
            <td><input type="text" name="research_co5_name" value="<?php echo @$research->getResearchCo5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Reward 1');?></td>
            <td colspan="3"><textarea name="research_reward1" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$research->getResearchReward1();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research Reward 2');?></td>
            <td colspan="3"><textarea name="research_reward2" cols="40" rows="5" wrap="virtual" class="textarea"><?php echo @$research->getResearchReward2();?></textarea> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Research ISBN');?></td>
            <td nowrap="nowrap"><input type="text" name="research_isbn" value="<?php echo @$research->getResearchISBN();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">**</font></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp; </td>
          </tr>
          <tr> 
            <td colspan="4"><hr noshade="noshade" size="1"> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 1');?></td>
            <td colspan="3"> <input type="text" name="research_keyword1" value="<?php echo @$research->getResearchKeyword1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 2');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword2" value="<?php echo @$research->getResearchKeyword2();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 3');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword3" value="<?php echo @$research->getResearchKeyword3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 4');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword4" value="<?php echo @$research->getResearchKeyword4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 5');?></td>
            <td nowrap="nowrap"><input type="text" name="research_keyword5" value="<?php echo @$research->getResearchKeyword5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> 
	<font color="#FF0000"><strong>(** Required 
      field)</strong></font>
  
	  </td>
      <td align="right">&nbsp; </td>
    </tr>
  </form>
</table>
<?
}
?>
<? if ($research_id != ''){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Abstract File</h2></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tdborder1">
  <form name="uploadFrm" action="?m=research" enctype="multipart/form-data" method="post" onSubmit="return checkFields(this.research_abstract);">
    <input type="hidden" name="max_file_size" value="109605000" />
    <input type="hidden" name="dosql" value="do_research_aed" />
    <input type="hidden" name="del" value="0" />
    <input type="hidden" name="file_a" value="1" />    
	<input type="hidden" name="research_id" value="<?php echo $research_id;?>" />
	<input type="hidden" name="research_owner_id" value="<?php echo @$research->getResearchOwner();?>" />
	<input type="hidden" name="research_owner_name" value="<?php echo @$research->getResearchOwnerName();?>" />
    <input type="hidden" name="research_name_eng" value="<?php echo @$research->getResearchNameEng();?>" />
    <input type="hidden" name="research_name_th"  value="<?php echo @$research->getResearchNameTh();?>" />
    <input type="hidden" name="research_co1_name" value="<?php echo @$research->getResearchCo1();?>" />
    <input type="hidden" name="research_co2_name" value="<?php echo @$research->getResearchCo2();?>" />
    <input type="hidden" name="research_co3_name" value="<?php echo @$research->getResearchCo3();?>" />
    <input type="hidden" name="research_co4_name" value="<?php echo @$research->getResearchCo4();?>" />
    <input type="hidden" name="research_co5_name" value="<?php echo @$research->getResearchCo5();?>" />
    <input type="hidden" name="research_year" value="<?php echo @$research->getResearchYear();?>" />
    <input type="hidden" name="research_encourage" value="<?php echo @$research->getResearchEncourage();?>" />
    <input type="hidden" name="research_start_date" value="<?php echo @$research->getResearchStartDate();?>" />
	<input type="hidden" name="research_status" value="<?php echo @$research->getResearchStatus();?>" />
    <input type="hidden" name="research_budget" value="<?php echo @$research->getResearchBudget();?>" />
    <input type="hidden" name="research_reward1" value="<?php echo @$research->getResearchReward1();?>" />
    <input type="hidden" name="research_reward2" value="<?php echo @$research->getResearchReward2();?>" />
    <input type="hidden" name="research_isbn" value="<?php echo @$research->getResearchISBN();?>" />
    <input type="hidden" name="research_picture" value="<?php echo @$research->getResearchPicture();?>" />
	<input type="hidden" name="research_full" value="<?php echo @$research->getResearchFull();?>" />
    <input type="hidden" name="research_keyword1" value="<?php echo @$research->getResearchKeyword1();?>" />
    <input type="hidden" name="research_keyword2" value="<?php echo @$research->getResearchKeyword2();?>" />
    <input type="hidden" name="research_keyword3" value="<?php echo @$research->getResearchKeyword3();?>" />
    <input type="hidden" name="research_keyword4" value="<?php echo @$research->getResearchKeyword4();?>" />
    <input type="hidden" name="research_keyword5" value="<?php echo @$research->getResearchKeyword5();?>" />
    <tr>
      <td valign="top" class="hilite">
	  <input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'save' );?>" />
	  <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=research';}" />         
	  </td>
    </tr>
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
            <td align="left" class="hilite"><?php echo @$research->getResearchAbstract();?></td>
          </tr>
          <tr valign="top"> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
            <td align="left" class="hilite"> 
              <?php //echo $obj->file_type;
				$typeFile=@$research->getResearchAbstract();		
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
			$allpath="../files/dms/research/".$research->getResearchId();
			if (@$research->getResearchAbstract() != "") {
			$doc_filesize = filesize($allpath."/".@$research->getResearchAbstract());
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
            <td align="left" class="hilite"><?php echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();?></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
            <td align="left"> <input type="file" class="button" name="research_abstract" style="width:270px"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="left">  
      </td>
    </tr>
  </form>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Picture File</h2></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tdborder1">
  <form name="uploadFrm" action="?m=research" enctype="multipart/form-data" method="post" onSubmit="return checkFields(this.research_picture);">
    <input type="hidden" name="max_file_size" value="109605000" />
    <input type="hidden" name="dosql" value="do_research_aed" />
    <input type="hidden" name="del" value="0" />
    <input type="hidden" name="file_p" value="1" />
    <input type="hidden" name="research_id" value="<?php echo $research_id;?>" />
	<input type="hidden" name="research_owner_id" value="<?php echo @$research->getResearchOwner();?>" />
	<input type="hidden" name="research_owner_name" value="<?php echo @$research->getResearchOwnerName();?>" />
    <input type="hidden" name="research_name_eng" value="<?php echo @$research->getResearchNameEng();?>" />
    <input type="hidden" name="research_name_th"  value="<?php echo @$research->getResearchNameTh();?>" />
    <input type="hidden" name="research_co1_name" value="<?php echo @$research->getResearchCo1();?>" />
    <input type="hidden" name="research_co2_name" value="<?php echo @$research->getResearchCo2();?>" />
    <input type="hidden" name="research_co3_name" value="<?php echo @$research->getResearchCo3();?>" />
    <input type="hidden" name="research_co4_name" value="<?php echo @$research->getResearchCo4();?>" />
    <input type="hidden" name="research_co5_name" value="<?php echo @$research->getResearchCo5();?>" />
    <input type="hidden" name="research_year" value="<?php echo @$research->getResearchYear();?>" />
    <input type="hidden" name="research_encourage" value="<?php echo @$research->getResearchEncourage();?>" />
    <input type="hidden" name="research_start_date" value="<?php echo @$research->getResearchStartDate();?>" />
	<input type="hidden" name="research_status" value="<?php echo @$research->getResearchStatus();?>" />
    <input type="hidden" name="research_budget" value="<?php echo @$research->getResearchBudget();?>" />
    <input type="hidden" name="research_reward1" value="<?php echo @$research->getResearchReward1();?>" />
    <input type="hidden" name="research_reward2" value="<?php echo @$research->getResearchReward2();?>" />
    <input type="hidden" name="research_isbn" value="<?php echo @$research->getResearchISBN();?>" />
    <input type="hidden" name="research_abstract" value="<?php echo @$research->getResearchAbstract();?>" />
	<input type="hidden" name="research_full" value="<?php echo @$research->getResearchFull();?>" />
    <input type="hidden" name="research_keyword1" value="<?php echo @$research->getResearchKeyword1();?>" />
    <input type="hidden" name="research_keyword2" value="<?php echo @$research->getResearchKeyword2();?>" />
    <input type="hidden" name="research_keyword3" value="<?php echo @$research->getResearchKeyword3();?>" />
    <input type="hidden" name="research_keyword4" value="<?php echo @$research->getResearchKeyword4();?>" />
    <input type="hidden" name="research_keyword5" value="<?php echo @$research->getResearchKeyword5();?>" />
    <tr>
      <td valign="top" class="hilite">
	  	<input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'save' );?>" />
	  	<input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=research';}" /> 
        
	  </td>
    </tr>
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
            <td align="left" class="hilite"><?php echo @$research->getResearchPicture();?></td>
          </tr>
          <tr valign="top"> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
            <td align="left" class="hilite"> 
              <?php //echo $obj->file_type;
					$typeFile=@$research->getResearchPicture();		
					$pos = strrpos($typeFile, ".");
					$rest = substr($typeFile, $pos+1);
					//echo $rest;
					if ($rest == "gif") echo "image/gif";
					if ($rest == "jpg") echo "image/jpg";
					if ($rest == "jpeg") echo "image/jpeg";
					if ($rest == "png") echo "image/png";
					
			?>
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
            <td align="left" class="hilite"> 
              <?php //echo $obj->file_size;
			$allpath="../files/dms/picture/".$research->getResearchId();
			if (@$research->getResearchPicture() != "") {
			$doc_filesize = filesize($allpath."/".@$research->getResearchPicture());
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
            <td align="left" class="hilite"><?php echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();?></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
            <td align="left"> <input type="file" class="button" name="research_picture" style="width:270px"> 
            </td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap">&nbsp;</td>
            <td align="left" class="hilite">
			 <?php			
			if (@$research->getResearchPicture() != "") {				
				$mysock = getimagesize($allpath."/".@$research->getResearchPicture());								
			?>
			<a href="javascript:NewWindow('<? echo $allpath."/".@$research->getResearchPicture();?>','myname','screen.availWidth','screen.availHeight','yes')">			
			<img src="<? echo $allpath."/".@$research->getResearchPicture()?>" <?php echo imageResize($mysock[0], $mysock[1], 350); ?> alt="Click to enlarge." border="0">
			</a>
			<?php	
			}
			?>
			</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="left">  
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
  <form name="uploadFrm" action="?m=research" enctype="multipart/form-data" method="post" onSubmit="return checkFields(this.research_full);">
    <input type="hidden" name="max_file_size" value="109605000" />
    <input type="hidden" name="dosql" value="do_research_aed" />
    <input type="hidden" name="del" value="0" />
    <input type="hidden" name="file_f" value="1" />
    <input type="hidden" name="research_id" value="<?php echo $research_id;?>" />
	<input type="hidden" name="research_owner_id" value="<?php echo @$research->getResearchOwner();?>" />
	<input type="hidden" name="research_owner_name" value="<?php echo @$research->getResearchOwnerName();?>" />
    <input type="hidden" name="research_name_eng" value="<?php echo @$research->getResearchNameEng();?>" />
    <input type="hidden" name="research_name_th"  value="<?php echo @$research->getResearchNameTh();?>" />
    <input type="hidden" name="research_co1_name" value="<?php echo @$research->getResearchCo1();?>" />
    <input type="hidden" name="research_co2_name" value="<?php echo @$research->getResearchCo2();?>" />
    <input type="hidden" name="research_co3_name" value="<?php echo @$research->getResearchCo3();?>" />
    <input type="hidden" name="research_co4_name" value="<?php echo @$research->getResearchCo4();?>" />
    <input type="hidden" name="research_co5_name" value="<?php echo @$research->getResearchCo5();?>" />
    <input type="hidden" name="research_year" value="<?php echo @$research->getResearchYear();?>" />
    <input type="hidden" name="research_encourage" value="<?php echo @$research->getResearchEncourage();?>" />
    <input type="hidden" name="research_start_date" value="<?php echo @$research->getResearchStartDate();?>" />
	<input type="hidden" name="research_status" value="<?php echo @$research->getResearchStatus();?>" />
    <input type="hidden" name="research_budget" value="<?php echo @$research->getResearchBudget();?>" />
    <input type="hidden" name="research_reward1" value="<?php echo @$research->getResearchReward1();?>" />
    <input type="hidden" name="research_reward2" value="<?php echo @$research->getResearchReward2();?>" />
    <input type="hidden" name="research_isbn" value="<?php echo @$research->getResearchISBN();?>" />
    <input type="hidden" name="research_picture" value="<?php echo @$research->getResearchPicture();?>" />
	<input type="hidden" name="research_abstract" value="<?php echo @$research->getResearchAbstract();?>" />
    <input type="hidden" name="research_keyword1" value="<?php echo @$research->getResearchKeyword1();?>" />
    <input type="hidden" name="research_keyword2" value="<?php echo @$research->getResearchKeyword2();?>" />
    <input type="hidden" name="research_keyword3" value="<?php echo @$research->getResearchKeyword3();?>" />
    <input type="hidden" name="research_keyword4" value="<?php echo @$research->getResearchKeyword4();?>" />
    <input type="hidden" name="research_keyword5" value="<?php echo @$research->getResearchKeyword5();?>" />
    <tr>
      <td valign="top" class="hilite">
	  <input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'save' );?>" />
	  <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=research';}" />         
	  </td>
    </tr>
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
            <td align="left" class="hilite"><?php echo @$research->getResearchFull();?></td>
          </tr>
          <tr valign="top"> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
            <td align="left" class="hilite"> 
              <?php //echo $obj->file_type;
				$typeFile=@$research->getResearchFull();		
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
			$allpath="../files/dms/full_research/".$research->getResearchId();
			if (@$research->getResearchFull() != "") {
			$doc_filesize = filesize($allpath."/".@$research->getResearchFull());
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
            <td align="left" class="hilite"><?php echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();?></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
            <td align="left"> <input type="file" class="button" name="research_full" style="width:270px"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="left">  
      </td>
    </tr>
  </form>
</table>

<? }?>