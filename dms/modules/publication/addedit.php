<?php 
// load the record data
if ($publication_id != '')
{	
	//$research = Research::lookupResearch($research_id);
	//echo $research->getResearchNameEng();	
	switch ($p) {
				case 1:
					//echo "Add Journal";
					$obj = Journal::lookupJournal($publication_id); 
					break;
				case 2:
					//echo "Add Proceeding";
					$obj = Proceeding::lookupProceeding($publication_id);
					break;
				case 3:
					//echo "Add Presentation";
					$obj = Presentation::lookupPresentation($publication_id);
					break;
			}
} else {
	switch ($p) {
				case 1:
					//echo "Add Journal";
					//Journal($id, $owner_id, $name_th, $name_eng, $type, $category, $volume, $number, $page_from, $page_to, $year, $issn) 
					$obj = new Journal('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), '', '', '', '',
									'', '', '', '', '', '', ''
									);
					break;
				case 2:
					//echo "Add Proceeding";
					//Proceeding($id, $owner_id, $name_th, $name_eng, $type, $category, $topic, $city, $country, $date_from, $date_to)
					$obj = new Proceeding('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), '', '', '', '',
										'', '', '', '', ''
									);
					break;
				case 3:
					//echo "Add Presentation";
					$obj = new Presentation('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), '', '', '', '',
										'', '', '', '', ''
									);					
					break;
	}
					
}

?>
<script language="javascript">
function setColor(color) {
	var f = document.editFrm;
	if (color) {
		f.project_color_identifier.value = color;
	}
	test.style.background = f.project_color_identifier.value;
}

function submitIt() {
	var f = document.editFrm;
	var msg = '';

	if (f.project_name.value.length < 3) {
		msg += "\n<?php echo $user->_('projectsValidName');?>";
		f.project_name.focus();
	}
	if (f.project_color_identifier.value.length < 3) {
		msg += "\n<?php echo $user->_('projectsColor');?>";
		f.project_color_identifier.focus();
	}
	if (f.project_company.options[f.project_company.selectedIndex].value < 1) {
		msg += "\n<?php echo $user->_('projectsBadCompany');?>";
		f.project_name.focus();
	}
	if (f.project_end_date.value > 0 && f.project_end_date.value < f.project_start_date.value) {
		msg += "\n<?php echo $user->_('projectsBadEndDate1');?>";
	}
	if (f.project_actual_end_date.value > 0 && f.project_actual_end_date.value < f.project_start_date.value) {
		msg += "\n<?php echo $user->_('projectsBadEndDate2');?>";
	}
	if (msg.length < 1) {
		f.submit();
	} else {
		alert(msg);
	}
}
</script>
<script language='javascript' src='<? echo "./modules/research";?>/popcalendar.js'></script>
<script language="JavaScript">
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

function requireRadio(radios)
{
	 // require at least one radio in this group to be checked
	  if(!radios.length) return true; // invalid parameter
	  var visible= false;
	  for(var i= 0; i < radios.length; i++)
			   if(radios[i].checked) {
			//status= 'You select one of the '+radios[i].value+' options.';
			//alert(status);
			   return true;
			   }
		    else if(radios[i].offsetWidth == undefined || radios[i].offsetWidth > 0) visible= true;
	  if(!visible) {
	  return true; // no visible options in this group
	  }		
		  alert("Please choose a type of book.");
	  return false;
}

function validateJournalForm(theForm)
{
	// Customize these calls for your form

	// Start ------->	

	if (!validRequired(theForm.journal_name_th,"Journal Name Thai"))
		return false;
			
	if (!validRequired(theForm.journal_name_eng,"Journal Name English"))
		return false;
		
	if (!requireRadio(theForm.journal_category))
		return false;	
	
	if (!validNum(theForm.journal_volume,"Journal Volume",true))
		return false;
	
	if (!validNum(theForm.journal_number,"Journal Number",true))
		return false;	
	/*	
	if (theForm.number.value.length == 4) {	
		if ((theForm.number.value != "")) {
			if (!validNum(theForm.number,"Publication Number",true))
				return false;
		}
	} else {
					alert("Publication Number must input 4 digits.");
					return false;	
			}			
	*/

	if (theForm.journal_year.value.length == 4) {	
		if ((theForm.journal_year.value != "")) {
			if (!validNum(theForm.journal_year,"Journal Year",true))
				return false;
		}
	} else {
					alert("Journal Year must input 4 digits.");
					return false;	
			}
	
	if (theForm.journal_issn.value.length == 8 ) {	
		if ((theForm.journal_issn.value != "")) {
			if (!validNum(theForm.journal_issn,"Journal ISSN",true))
				return false;
		}
	} else {
					alert("Journal ISSN must input number for 8 digits.");
					return false;	
				}			
	// <--------- End

	return true;
}

function validateProceedingForm(theForm)
{
	// Customize these calls for your form

	// Start ------->	

	if (!validRequired(theForm.proceeding_name_th,"Proceeding Name Thai"))
		return false;
			
	if (!validRequired(theForm.proceeding_name_eng,"Proceeding Name English"))
		return false;
		
	if (!requireRadio(theForm.proceeding_category))
		return false;	

	if (!validRequired(theForm.proceeding_topic,"Proceeding Topic"))
		return false;
	
	if (!validRequired(theForm.proceeding_country,"Proceeding Country"))
		return false;

	// <--------- End

	return true;
}

function validatePresentationForm(theForm)
{
	// Customize these calls for your form

	// Start ------->	

	if (!validRequired(theForm.presentation_name_th,"Presentation Name Thai"))
		return false;
			
	if (!validRequired(theForm.presentation_name_eng,"Presentation Name English"))
		return false;
		
	if (!requireRadio(theForm.presentation_category))
		return false;	

	if (!validRequired(theForm.presentation_topic,"Presentation Topic"))
		return false;
	
	if (!validRequired(theForm.presentation_country,"Presentation Country"))
		return false;

	// <--------- End

	return true;
}

</script>

<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<?
 if ($p == ''){ ?>
 
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="tdborder1">
  <tr> 
    <td colspan="3" background="../themes/<? echo $theme;?>/images/titlegrad.jpg".$uistyle."/images/titlegrad.jpg"><strong> 
      <font color="#FFFFFF" size="4">Publication Type</font> </strong></td>
  </tr>
  <tr align="center" valign="middle"> 
    <td width="33%" class="hilite"><img src="./images/Newspaper.gif"><a href="./index.php?m=publication&a=addedit&p=1"> 
      Journal</a></td>
    <td width="33%" class="hilite"><img src="./images/Newspaper.gif"><a href="./index.php?m=publication&a=addedit&p=2"> 
      Proceeding</a></td>
    <td width="34%" class="hilite"><img src="./images/Newspaper.gif"><a href="./index.php?m=publication&a=addedit&p=3"> 
      Presentation</a></td>
  </tr>
</table>
<?
 } else {
 //echo $p;
?>
<?
		switch ($p) {
			case 1:
				//echo "Edit Journal";
				?>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form name="editFrm" action="./index.php?m=publication" method="post" onSubmit="return validateJournalForm(this)">
    <input type="hidden" name="dosql" value="do_publication_aed" />
    <input type="hidden" name="p" value="1" />
    <input type="hidden" name="publication_id" value="<?php echo $publication_id;?>" />
	<input type="hidden" name="journal_owner_name" value="<?php echo @$obj->getPublicationOwnerName();?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite">
	  	<input class="button" type="submit" name="btnFuseAction2" value="<?php echo $user->_('save');?>" />
        <input class="button" type="button" name="cancel2" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=publication';}" /></td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Name Thai');?></td>
            <td width="100%"><textarea name="journal_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$obj->getPublicationNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Name English');?></td>
            <td width="100%"><textarea name="journal_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$obj->getPublicationNameEng();?></textarea>
              <font color="#FF0000"> **</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Owner');?></td>
            <td> <input type="hidden" name="journal_owner_id" value="<?php if(@$obj->getPublicationOwner()!=0){echo $obj->getPublicationOwner();}else{echo @$user->getUserId();}?>" /> 
              <input type="text" name="journal_owner_name" value="<?php if(@$obj->getPublicationOwnerName()!=""){echo $obj->getPublicationOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Category');?></td>
            <td width="100%" nowrap="nowrap"> <input type="radio" name="journal_category" value="1" <? if (@$obj->getPublicationCategory() == 1) echo "checked";?>>
              International 
              <input type="radio" name="journal_category" value="2" <? if (@$obj->getPublicationCategory() == 2) echo "checked";?>>
              National 
              <input type="radio" name="journal_category" value="3" <? if (@$obj->getPublicationCategory() == 3) echo "checked";?>>
              Other <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Press');?></td>
            <td width="100%" nowrap="nowrap"><input type="text" name="journal_press" value="<?php echo @$obj->getJournalPress();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Volume');?></td>
            <td width="100%" nowrap="nowrap"><input type="text" name="journal_volume" value="<?php echo @$obj->getJournalVolume();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">**</font> </td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Number');?></td>
            <td colspan="3"><input type="text" name="journal_number" value="<?php echo @$obj->getJournalNumber();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">** </font></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Page From');?></td>
            <td colspan="3"> <input type="text" name="journal_page_from" value="<?php echo @$obj->getJournalPageFrom();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Page To');?></td>
            <td nowrap="nowrap"><input type="text" name="journal_page_to" value="<?php echo @$obj->getJournalPageTo();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Year');?></td>
            <td nowrap="nowrap">
			<select name="journal_year" class="text">
                <option value="-1" selected>-select-</option>
                <?
				for($i=0;$i<100;$i++){ 
				$dateVar = 1950 + $i; 
				?>
                <option value="<? echo $dateVar ?>" <? if (@$obj->getJournalYear() == $dateVar){ echo "selected"; } ?>><? echo $dateVar;?></option>
                <?
				} 		
				?>
              </select> <font color="#FF0000">**</font></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('ISSN');?></td>
            <td nowrap="nowrap"><input type="text" name="journal_issn" value="<?php echo @$obj->getJournalISSN();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">**</font></td>
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
				break;
			case 2:
				//echo "Edit PProceeding";
				?>
				
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form name="editFrm" action="./index.php?m=publication" method="post" onSubmit="return validateProceedingForm(this)">
    <input type="hidden" name="dosql" value="do_publication_aed" />
    <input type="hidden" name="p" value="2" />
    <input type="hidden" name="publication_id" value="<?php echo $publication_id;?>" />
	<input type="hidden" name="proceeding_owner_name" value="<?php echo @$obj->getPublicationOwnerName();?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite">
	  	<input class="button" type="submit" name="btnFuseAction3" value="<?php echo $user->_('save');?>" />
        <input class="button" type="button" name="cancel3" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=publication';}" /></td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Name Thai');?></td>
            <td width="100%"><textarea name="proceeding_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$obj->getPublicationNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Name English');?></td>
            <td width="100%"><textarea name="proceeding_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$obj->getPublicationNameEng();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Owner');?></td>
            <td> <input type="hidden" name="proceeding_owner_id" value="<?php if(@$obj->getPublicationOwner()!=0){echo $obj->getPublicationOwner();}else{echo @$user->getUserId();}?>" /> 
              <input type="text" name="proceeding_owner_name" value="<?php if(@$obj->getPublicationOwnerName()!=""){echo $obj->getPublicationOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Category');?></td>
            <td width="100%" nowrap="nowrap"> <input type="radio" name="proceeding_category" value="1" <? if (@$obj->getPublicationCategory() == 1) echo "checked";?>>
              International 
              <input type="radio" name="proceeding_category" value="2" <? if (@$obj->getPublicationCategory() == 2) echo "checked";?>>
              National 
              <input type="radio" name="proceeding_category" value="3" <? if (@$obj->getPublicationCategory() == 3) echo "checked";?>>
              Other <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Date From');?></td>
            <td> <input type="text" name="proceeding_date_from" value="<?php echo @$obj->getProceedingDateFrom();?>" class="text" onFocus="this.blur();"/> 
              <script language='javascript'>
								<!--
								  if (!document.layers) {
									document.write("<input type=button onclick='popUpCalendar(this, editFrm.proceeding_date_from, \"yyyy-mm-dd\")' value=' Date ' style='font-size:11px'>")
								}
								//-->
			  </script> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Date To');?></td>
            <td> <input type="text" name="proceeding_date_to" value="<?php echo @$obj->getProceedingDateTo();?>" class="text" onFocus="this.blur();"/> 
              <script language='javascript'>
								<!--
								  if (!document.layers) {
									document.write("<input type=button onclick='popUpCalendar(this, editFrm.proceeding_date_to, \"yyyy-mm-dd\")' value=' Date ' style='font-size:11px'>")
								}
								//-->
							  </script> </td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Topic');?></td>
            <td colspan="3"> <input type="text" name="proceeding_topic" value="<?php echo @$obj->getProceedingTopic();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">** </font></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding City');?></td>
            <td nowrap="nowrap"><input type="text" name="proceeding_city" value="<?php echo @$obj->getProceedingCity();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Country');?></td>
            <td nowrap="nowrap"><input type="text" name="proceeding_country" value="<?php echo @$obj->getProceedingCountry();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">**</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td>&nbsp; </td>
      <td align="right">&nbsp; </td>
    </tr>
  </form>
</table>
				
<?
				break;
			case 3:
				//echo "Edit Presentation";
				?>
				
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="tdborder1">
  <form name="editFrm" action="./index.php?m=publication" method="post" onSubmit="return validatePresentationForm(this)">
    <input type="hidden" name="dosql" value="do_publication_aed" />
    <input type="hidden" name="p" value="3" />
    <input type="hidden" name="publication_id" value="<?php echo $publication_id;?>" />
	<input type="hidden" name="presentation_owner_name" value="<?php echo @$obj->getPublicationOwnerName();?>" />
    <tr> 
      <td colspan="2" valign="top" class="hilite"><input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('save');?>" />
        <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=publication';}" /></td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Name Thai');?></td>
            <td width="100%"><textarea name="presentation_name_th" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$obj->getPublicationNameTh();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Name English');?></td>
            <td width="100%"><textarea name="presentation_name_eng" cols="39" rows="2" wrap="virtual" class="textarea"><?php echo @$obj->getPublicationNameEng();?></textarea>
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Owner');?></td>
            <td> <input type="hidden" name="presentation_owner_id" value="<?php if(@$obj->getPublicationOwner()!=0){echo $obj->getPublicationOwner();}else{echo @$user->getUserId();}?>" /> 
              <input type="text" name="presentation_owner_name" value="<?php if(@$obj->getPublicationOwnerName()!=""){echo $obj->getPublicationOwnerName();}else{echo @$user->getTitle().@$user->getFirstName()." ".@$user->getLastName();}?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Category');?></td>
            <td width="100%" nowrap="nowrap"> <input type="radio" name="presentation_category" value="1" <? if (@$obj->getPublicationCategory() == 1) echo "checked";?>>
              International 
              <input type="radio" name="presentation_category" value="2" <? if (@$obj->getPublicationCategory() == 2) echo "checked";?>>
              National 
              <input type="radio" name="presentation_category" value="3" <? if (@$obj->getPublicationCategory() == 3) echo "checked";?>>
              Other <font color="#FF0000">**</font></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Date From');?></td>
            <td> <input type="text" name="presentation_date_from" value="<?php echo @$obj->getPresentationDateFrom();?>" class="text" onFocus="this.blur();"/> 
              <script language='javascript'>
												<!--
												  if (!document.layers) {
													document.write("<input type=button onclick='popUpCalendar(this, editFrm.presentation_date_from, \"yyyy-mm-dd\")' value=' Date ' style='font-size:11px'>")
												}
												//-->
											  </script> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Date To');?></td>
            <td> <input type="text" name="presentation_date_to" value="<?php echo @$obj->getPresentationDateTo();?>" class="text" onFocus="this.blur();"/> 
              <script language='javascript'>
												<!--
												  if (!document.layers) {
													document.write("<input type=button onclick='popUpCalendar(this, editFrm.presentation_date_to, \"yyyy-mm-dd\")' value=' Date ' style='font-size:11px'>")
												}
												//-->
											  </script> </td>
          </tr>
        </table></td>
      <td width="50%" valign="top"> <table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Topic');?></td>
            <td colspan="3"> <input type="text" name="presentation_topic" value="<?php echo @$obj->getPresentationTopic();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">**</font> </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation City');?></td>
            <td nowrap="nowrap"><input type="text" name="presentation_city" value="<?php echo @$obj->getPresentationCity();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Country');?></td>
            <td nowrap="nowrap"><input type="text" name="presentation_country" value="<?php echo @$obj->getPresentationCountry();?>" size="25" maxlength="50" class="text" />
              <font color="#FF0000">**</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td>&nbsp; </td>
      <td align="right">&nbsp; </td>
    </tr>
  </form>
</table>
<?
				break;
		}
?>
<?
}
?>
