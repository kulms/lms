<!DOCTYPE HTML PUBLIC "-//W3C//DTD W3 HTML//EN">
<script language="JavaScript">
if (parent.hordestatus) {
  parent.hordestatus.location="status.php3?language=en&message=Message+Composition&status=green";
} else if (parent.parent.hordestatus) {
  parent.parent.hordestatus.location="status.php3?language=en&message=Message+Composition&status=green";
} else if (top.opener && top.opener.parent.hordestatus) {
  top.opener.parent.hordestatus.location="status.php3?language=en&message=Message+Composition&status=green";
}
</script>

<!-- IMP: Copyright 2000, The Horde Project. IMP is under the GPL. -->
<!-- Horde Project: http://horde.org/ | IMP: http://horde.org/imp/ -->
<!--    GNU Public License: http://www.fsf.org/copyleft/gpl.html   -->

<html>
<head>
<title>Message Composition</title>
<link href="imp.css" rel="stylesheet" text="text/css">
</head>

<body bgcolor="#e9e9e9" text="#000000" link="#0000ff" vlink="#0000aa" alink="#0000ff">
<script language="JavaScript">
<!--

function confirmCancel () {
  if (window.confirm("Cancelling this message will permanently discard its contents. Are you sure you want to do this?")) {
	    self.close();
	    return true; // this probably is never reached, but you know, IE is stupid
  } else {
    return false;
  }
}

function attachment_check (n) {
    if (n.attachmentAction.value) {
	if (n.attachmentAction.value == 'add') {
	    if (n.file_upload.value == '') {
		alert('You must specify the file to attach.');
		n.file_upload.focus ();
		return false;
	    } else {
		return true;
	    }
	}
	
	if (n.attachmentAction.value == 'delete') {
	    sel = false;
	    
	    var i = 0;
	    
	    for (i = 0; i < n.elements.length; i++) {
		if (n.elements[i].name == 'delattachments[]') {
		    if (n.elements[i].checked) {
			sel = true;
		    }
		}
	    }
	    
	    if (sel == false) {
		alert('You must select the attachment(s) to delete.');
		return false;
	    } else {
		return true;
	    }
	}
    }  
}

function submit_and_sign (n) {
    if (n.file_upload.value.length > 0) {
	alert('Press the Attach button to attach this file');
	n.file_upload.focus();
	return false;
    }
    
    if (n.to.value == '') {
	alert('You must have a recipient.');
	n.to.focus();
	return false;
    }
    
    return true;
}

function bounce_submit_and_sign (n) {
   if (n.to.value == '') {
      alert('You must have a recipient.');
      n.to.focus();
      return false;
   }
   
   return true;
}

function spellcheck (num) {
  document.spelling.message.value = document.compose.message.value;
  if (num == 1)
    document.spelling.spell_lang.value = document.compose.spell_lang1.options[document.compose.spell_lang1.selectedIndex].value;
  else
    document.spelling.spell_lang.value = document.compose.spell_lang2.options[document.compose.spell_lang2.selectedIndex].value;
  document.spelling.submit();
}


var Addresses = new Array (
  );

var Nicknames = new Array (
  );

var Fullnames = new Array (
  );


function append (field) {
  if (field) {
    index = document.compose.to_options.selectedIndex - 1;
    if (Addresses[index]) {
      if (!document.compose.to.value) {
        punctuation = '';
      } else {
        punctuation = ', ';
      }
      document.compose.to.value = document.compose.to.value + punctuation + Fullnames[index] + ' <' + Addresses[index] + '>';
    }
  
  } else {
    index = document.compose.cc_options.selectedIndex - 1;
    if (Addresses[index]) {
      if (!document.compose.cc.value) {
        punctuation = '';
      } else {
        punctuation = ', ';
      }
      document.compose.cc.value = document.compose.cc.value + punctuation + Fullnames[index] + ' <' + Addresses[index] + '>';
    } else {
    index = document.compose.bcc_options.selectedIndex - 1;
    if (Addresses[index]) {
      if (!document.compose.bcc.value) {   
        punctuation = '';
      } else {
        punctuation = ', ';
      }
      document.compose.bcc.value = document.compose.bcc.value + punctuation + Fullnames[index] + ' <' + Addresses[index] + '>';
    }
    }
  }
}


function expand_to () {
  document.compose.to.value = expand(quotedSplit(document.compose.to.value, ',', '"')).join(', ');
}

function expand_cc () {
  document.compose.cc.value = expand(quotedSplit(document.compose.cc.value, ',', '"')).join(', ');
}

function expand_bcc () {
  document.compose.bcc.value = expand(quotedSplit(document.compose.bcc.value, ',', '"')).join(', ');
}

function quotedSplit (string, delim, quotechar) {
    pos = 0;
    strings = new Array();
    lastdelim = -1;
    insidequote = false;
    len = string.length;
    
    while (pos < len) {
		cur = string.charAt(pos);
		if (!insidequote && cur == delim) {
			if (pos != 0) {
				strings[strings.length] = string.substring(lastdelim + 1, pos);
			}
			lastdelim = pos;
		} else if (cur == quotechar) {
			insidequote = !insidequote;
		}
		pos++;
    }
    if (lastdelim != pos) {
		strings[strings.length] = string.substring(lastdelim + 1, pos);
    }
    
    return strings;
}

function expand (addresses) {
    result = new Array(addresses.length);
    var match;
    addresses = stripSpaces(addresses);
    if (Nicknames.length > 0) {
	for (i = 0; i < addresses.length; i++) {
	    address = addresses[i];
	    if (address != '') {
		for (j = 0; j < Nicknames.length; j++) {
		    match = 0;
		    if (Nicknames[j].toLowerCase() == address.toLowerCase()) {
			result[i] = Fullnames[j] + ' <' + Addresses[j] + '>';
			match = 1;
			break;
		    }
		}
		if (match == 0) { result[i] = address; }
	    }
	}
	
    } else {
	result = addresses;
    }
    
     
    
    return(result);
}

function stripSpaces (strArray) {
    ssresult = new Array(); 
    for (i = 0; i < strArray.length; i++) {
        str = strArray[i];
        while (str.charAt(str.length - 1) == ' ')
            str = str.substring(0, str.length - 1);
        while (str.charAt(0) == ' ')
            str = str.substring(1, str.length);
        ssresult[i] = str;
    }
    return(ssresult);
}

//-->
</script>
<script language="JavaScript">
<!--


function open_contacts_win () {
    param = "directories=no,menubar=no,toolbar=no,resizable=yes,width=" + 600 + ",height=" + 330;
    contacts_window = window.open("contacts.php3", "contacts", param);
    if (!contacts_window.opener) contacts_window.opener = self;
}

function open_add_contact_win (args) {
    var base = "addcontact.php3";
    var url = "addcontact.php3";
    if (base != url)
	glue = '&';
    else
	glue = '?';
    if (args != "") url = url + glue + args;
    param = "directories=no,menubar=no,toolbar=no,resizable=yes,width=" + 500 + ",height=" + 
	200;
    add_contact_window = window.open(url, "add_contact", param);
    if (!add_contact_window.opener) add_contact_window.opener=self;
}

//-->
</script>

<script language="JavaScript">
<!--
function open_help_win (win_location) {
   var screen_width, screen_height;
   var win_top, win_left;
   var HelpWin;
   
   screen_height        = 0;     screen_width      = 0;
   win_top              = 0;     win_left          = 0;
   
   var help_win_width   = 315;
   var help_win_height  = 270;
   
   screen_width         = document.body.clientWidth;
   screen_height        = document.body.clientHeight;
   
   win_top  = screen_height - help_win_height - 20;
   win_left = screen_width  - help_win_width  - 20;
   HelpWin  = window.open(
               win_location,
               'HordeHelpWin',
               'width='+help_win_width+',height='+help_win_height+',top='+win_top+',left='+win_left
   );
}

function close_help_win() {
   document.all['HordeHelpWin'].close();
}

//-->
</script>
<table border="0" align="center" cellpadding="1" cellspacing="2">
  <tr bgcolor="#002266"> 
    <td colspan="3"> 
      <div align="center"><font color="#ffffff" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif" size="3"><b>Compose 
        a message</b> </font></div>
    </td>
  </tr>
  <form method="post" name="compose" enctype="multipart/form-data" action="https://webmail.ku.ac.th/horde/imp/compose.php3">
    <!-- Buttons Row -->
    <tr bgcolor="#dcdcdc"> 
      <td></td>
      <td nowrap align="left" colspan="2"><font size="2" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif"> 
        <a href="" onClick="spellcheck(1); return false;">Spell Check in</a> 
        <select name="spell_lang1">
          <option value="ca">Catal?</option>
          <option value="cs">?esky</option>
          <option value="da">Dansk</option>
          <option value="de">Deutsch</option>
          <option value="en" SELECTED>English - Thai</option>
          <option value="es">Espa?ol</option>
          <option value="fr">Fran&ccedil;ais</option>
          <option value="it">Italiano</option>
          <option value="nl">Nederlands</option>
          <option value="no-nyn">Norsk-nynorsk</option>
          <option value="pl">Polish</option>
          <option value="se">Svenska</option>
          <option value="sl">Sloven&scaron;?ina</option>
          <option value="ru">Russian</option>
        </select>
        <input type="submit" name="actionID" value="Cancel Message" onClick="return confirmCancel();">
        <input notab type="submit" name="actionID" value="Save Draft">
        <input notab type="submit" name="actionID" value="Send Message" onClick="return submit_and_sign(document.compose);">
        </font> </td>
    </tr>
    <!-- End Buttons Row -->
    <tr> 
      <td align="right" bgcolor="#e9e9e9"><font color="#000000" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif" size="3">From</font></td>
      <td bgcolor="#ffffcc"> 
        <input type="text" size="70" tabindex="1" name="from" value="ojini@ku.ac.th">
      </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right" bgcolor="#e9e9e9"><font color="#000000" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif" size="3">To</font></td>
      <td bgcolor="#ffffcc"> 
        <input type="text" size="70" tabindex="2" name="to" onBlur="expand_to()" value="">
      </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right" bgcolor="#e9e9e9"><font color="#000000" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif" size="3">Cc</font></td>
      <td bgcolor="#ffffcc"> 
        <input type="text" size="70" tabindex="3" name="cc" onBlur="expand_cc()" value="">
      </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right" bgcolor="#e9e9e9"><font color="#000000" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif" size="3">Bcc</font></td>
      <td bgcolor="#ffffcc"> 
        <input type="text" size="70" tabindex="3" name="bcc" onBlur="expand_bcc()" value="">
      </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right" bgcolor="#e9e9e9"><font color="#000000" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif" size="3">Subject</font></td>
      <td bgcolor="#ffffcc"> 
        <input type="text" tabindex="4" name="subject" value="" size="70">
      </td>
      <td align="right">&nbsp;</td>
    </tr>
    <input type="hidden" name="attachmentAction" value="">
    <tr> 
      <td align="right" bgcolor="#e9e9e9"><font color="#000000" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif" size="3">Attachment</font></td>
      <td valign="middle" bgcolor="#ffffcc"><font size="2" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif"> 
        <input name="file_upload" type="file" size="48">
        &nbsp;&nbsp; 
        <input notab type="submit" name="actionID" value="Attach" onClick="attachmentAction.value = 'add';return attachment_check(document.compose);">
        </font></td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" align="center"> 
        <textarea tabindex="5" name="message" rows="20" cols="80" wrap="hard"></textarea>
      </td>
    </tr>
    <!-- Buttons Row -->
    <tr bgcolor="#dcdcdc"> 
      <td></td>
      <td nowrap align="left" colspan="2"><font size="2" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif"> 
        <a href="" onClick="spellcheck(2); return false;">Spell Check in</a> 
        <select name="spell_lang2">
          <option value="ca">Catal?</option>
          <option value="cs">?esky</option>
          <option value="da">Dansk</option>
          <option value="de">Deutsch</option>
          <option value="en" SELECTED>English - Thai</option>
          <option value="es">Espa?ol</option>
          <option value="fr">Fran&ccedil;ais</option>
          <option value="it">Italiano</option>
          <option value="nl">Nederlands</option>
          <option value="no-nyn">Norsk-nynorsk</option>
          <option value="pl">Polish</option>
          <option value="se">Svenska</option>
          <option value="sl">Sloven&scaron;?ina</option>
          <option value="ru">Russian</option>
        </select>
        <input type="submit" name="actionID" value="Cancel Message" onClick="return confirmCancel();">
        <input notab type="submit" name="actionID" value="Save Draft">
        <input notab type="submit" name="actionID" value="Send Message" onClick="return submit_and_sign(document.compose);">
        </font> </td>
    </tr>
    <!-- End Buttons Row -->
  </form>
  <form action="/horde/imp/spelling.php3" method="post" name="spelling" target="impspelling">
    <input type="hidden" name="message" value="">
    <input type="hidden" name="spell_lang" value="">
  </form>
</table>
<script language="JavaScript">
<!--
function attach_delete () {
  document.compose.attachmentAction.value = 'delete';
  return attachment_check(document.compose);
}
// -->
</script>
</body>
</html>
