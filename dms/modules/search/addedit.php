<?php 
// load the record data
if ($book_id != '')
{	
	$book = Book::lookupBook($book_id);
	//echo $book->getBookNameEng();	
} else {
	$book = new Book('', $user->getUserId(), '', '', '', '', 
				 	 '', '', '', '', '', 
				 	 '', '', '', '', ''
				 	 );
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
<script language='javascript' src='<? echo "./modules/book";?>/popcalendar.js'></script>

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

function validateForm(theForm)
{
	// Customize these calls for your form

	// Start ------->
	
	if (!validRequired(theForm.book_name_th,"Book Name Thai"))
		return false;
	
	if (!validRequired(theForm.book_name_eng,"Book Name English"))
		return false;
		
	if (!requireRadio(theForm.book_type))
		return false;	
				
	if (theForm.book_volume.value.length == 4) {	
		if ((theForm.book_volume.value != "")) {
			if (!validNum(theForm.book_volume,"Book Volumn",true))
				return false;
		}
	} else {
					alert("Book Volumn must input 4 digits.");
					return false;	
			}			
	
	if (theForm.book_year.value.length == 4) {	
		if ((theForm.book_year.value != "")) {
			if (!validNum(theForm.book_year,"Book Year",true))
				return false;
		}
	} else {
					alert("Book Year must input 4 digits.");
					return false;	
			}
	
	if (theForm.book_isbn.value.length >= 10 && theForm.book_isbn.value.length <= 13 ) {	
		if ((theForm.book_isbn.value != "")) {
			if (!validNum(theForm.book_isbn,"Book ISBN",true))
				return false;
		}
	} else {
					alert("Book ISBN must input number for 10 or 13 digits.");
					return false;	
				}			
	// <--------- End
	
	return true;
}
</script>



<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? if($book_id == '') { echo "Add Book";} else { echo "Edit Book";}?></h1></td>
    <td width="50%">&nbsp;</td>
  </tr>
</table>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="std">
<form name="editFrm" action="./index.php?m=book" method="post" onSubmit="return validateForm(this)">
	<input type="hidden" name="dosql" value="do_book_aed" />
	<input type="hidden" name="book_id" value="<?php echo $book_id;?>" />
	<input type="hidden" name="book_abstract" value="<?php echo @$book->getBookAbstract();?>" />

<tr>
	<td width="50%" valign="top">
		<table cellspacing="0" cellpadding="2" border="0">
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Name Thai');?></td>
            <td width="100%"><input type="text" name="book_name_th" value="<?php echo @$book->getBookNameTh();?>" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Name English');?></td>
            <td width="100%"> <input type="text" name="book_name_eng" value="<?php echo @$book->getBookNameEng();?>" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Owner');?></td>
            <td> <input type="hidden" name="book_owner_id" value="<?php echo @$user->getUserId();?>" /> 
              <input type="text" name="book_owner" value="<?php echo @$user->getFirstName()." ".@$user->getLastName();?>" size="25" maxlength="50" class="text" disabled="disabled"/>	
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="right" nowrap="nowrap"><hr noshade="noshade" size="1"></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Type');?></td>
            <td width="100%" nowrap="nowrap"> 
			  <input type="radio" name="book_type" value="1" <? if (@$book->getBookType() == 1) echo "checked";?>>
              Text Book 
              <input type="radio" name="book_type" value="2" <? if (@$book->getBookType() == 2) echo "checked";?>>
              Hand Book 
              <input type="radio" name="book_type" value="3" <? if (@$book->getBookType() == 3) echo "checked";?>>
              Others </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Volume');?></td>
            <td><input type="text" name="book_volume" value="<?php echo @$book->getBookVolume();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Press');?></td>
            <td><input type="text" name="book_press" value="<?php echo @$book->getBookPress();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Press Country');?></td>
            <td><input type="text" name="book_press_country" value="<?php echo @$book->getBookPressCountry();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book Year');?></td>
            <td><input type="text" name="book_year" value="<?php echo @$book->getBookYear();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap"><?php echo $user->_('Book ISBN');?></td>
            <td><input type="text" name="book_isbn" value="<?php echo @$book->getBookISBN();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table>
	</td>
	<td width="50%" valign="top">
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="3">&nbsp; </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp; </td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp; </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 1');?></td>
            <td colspan="3"> <input type="text" name="book_keyword1" value="<?php echo @$book->getBookKeyword1();?>" size="25" maxlength="50" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 2');?></td>
            <td nowrap="nowrap"><input type="text" name="book_keyword2" value="<?php echo @$book->getBookKeyword2();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 3');?></td>
            <td nowrap="nowrap"><input type="text" name="book_keyword3" value="<?php echo @$book->getBookKeyword3();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 4');?></td>
            <td nowrap="nowrap"><input type="text" name="book_keyword4" value="<?php echo @$book->getBookKeyword4();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap"><?php echo $user->_('Keyword 5');?></td>
            <td nowrap="nowrap"><input type="text" name="book_keyword5" value="<?php echo @$book->getBookKeyword5();?>" size="25" maxlength="50" class="text" /></td>
          </tr>
        </table>
	</td>
</tr>
<tr>
	<td>
		<input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=book';}" />
        <input class="button" type="submit" name="btnFuseAction" value="<?php echo $user->_('submit');?>" />	
      </td>  <td align="right">&nbsp; </td>
</tr>
</form>
</table>
<? if ($book_id != ''){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Abstract File</td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="3" class="std">

<form name="uploadFrm" action="?m=book" enctype="multipart/form-data" method="post">
	<input type="hidden" name="max_file_size" value="109605000" />
	<input type="hidden" name="dosql" value="do_book_aed" />
	<input type="hidden" name="del" value="0" />
	<input type="hidden" name="file_a" value="1" />
	<input type="hidden" name="book_id" value="<?php echo $book_id;?>" />
	<input type="hidden" name="book_name_eng" value="<?php echo @$book->getBookNameEng();?>" />
	<input type="hidden" name="book_name_th"  value="<?php echo @$book->getBookNameTh();?>" />
	<input type="hidden" name="book_type" value="<?php echo @$book->getBookType();?>" />
	<input type="hidden" name="book_volume" value="<?php echo @$book->getBookVolume();?>" />
	<input type="hidden" name="book_press" value="<?php echo @$book->getBookPress();?>" />
	<input type="hidden" name="book_press_country" value="<?php echo @$book->getBookPressCountry();?>" />
	<input type="hidden" name="book_year" value="<?php echo @$book->getBookYear();?>" />
	<input type="hidden" name="book_isbn" value="<?php echo @$book->getBookISBN();?>" />
	<input type="hidden" name="book_keyword1" value="<?php echo @$book->getBookKeyword1();?>" />
	<input type="hidden" name="book_keyword2" value="<?php echo @$book->getBookKeyword2();?>" />
	<input type="hidden" name="book_keyword3" value="<?php echo @$book->getBookKeyword3();?>" />
	<input type="hidden" name="book_keyword4" value="<?php echo @$book->getBookKeyword4();?>" />
	<input type="hidden" name="book_keyword5" value="<?php echo @$book->getBookKeyword5();?>" />
	
<tr>
	<td width="100%" valign="top" align="center">
		<table cellspacing="1" cellpadding="2" width="60%">
		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
			<td align="left" class="hilite"><?php echo @$book->getBookAbstract();?></td>			
		</tr>
		<tr valign="top">
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
			<td align="left" class="hilite"><?php //echo $obj->file_type;?></td>
		</tr>
		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
			<td align="left" class="hilite"><?php //echo $obj->file_size;?></td>
		</tr>
		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Uploaded By' );?>:</td>
			<td align="left" class="hilite"><?php echo @$user->getFirstName()." ".@$user->getLastName();?></td>
		</tr>						

		<tr>
			<td align="right" nowrap="nowrap"><?php echo $user->_( 'Upload File' );?>:</td>
			<td align="left">
			<input type="file" class="button" name="book_abstract" style="width:270px">
            </td>
		</tr>

		</table>
	</td>
</tr>
<tr>
	<td align="left">
		<input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=book';}" />
		<input name="Submit" type="submit" class="button" value="<?php echo $user->_( 'submit' );?>" />
	</td>
</tr>
</form>
</table>
<? }?>