<?




	//$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
	//$modules=mysql_query("SELECT * from modules WHERE id=".$module);

	//$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$module.";");
	//$courses=mysql_result($courseid,0,"courses");
	?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

<link href="../themes/<?echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript">
			<!-- 		
			function check(){
	
	var form = document.new_forum;
	
	if (form.info.value == "")
	{
		
		
		alert("Please enter message");
		form.info.focus();
		return  false;
	}
	
}

function newWindow(url)
 {
   var LeftPosition = (screen.width) ? (screen.width-300)/2 : 0;
  var TopPosition = (screen.height) ? (screen.height+200)/2 : 0;
		
   var options = "width=250,height=160,";
   options += "resizable=no,scrollbars=no,status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left="+LeftPosition+",top="+TopPosition;
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }
function emoticon(text) {
	text = ' ' + text + ' ';
	
	document.new_forum.info.value  += text;
	document.new_forum.info.focus();
	
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<form action="index.php?a=do_forum_aed"  method="post" name="new_forum" onsubmit=" return check();">
  <table width="100%" cellpadding="1" cellspacing="1">
    <tr class="boxcolor"> 
      <td colspan="3" class="Bcolor"><? echo $strForum_Labwrite_msg;?></td>
    </tr>
    <tr> 
      <td width="27%"> <textarea name="info"  cols="38" rows="4"></textarea></td>
      <td width="10%"> <input type="submit" name="Submit" value="<? echo $strForum_Labsend;?>" class="button" > 
        <input type="hidden" name="module" value="<?echo $module;?>"> <input type="hidden" name="courses" value="<?echo $courses;?>"> 
      </td>
      <td width="63%"></td>
    </tr>
    <tr> 
      <td colspan="3"> <table width="100" border="0" cellspacing="0" cellpadding="2">
          <tr align="center" valign="middle"> 
            <td><a href="javascript:emoticon(':D')"><img src="images/smiles/icon_biggrin.gif" border="0" alt="Very Happy" title="Very Happy" /></a></td>
            <td><a href="javascript:emoticon(':)')"><img src="images/smiles/icon_smile.gif" border="0" alt="Smile" title="Smile" /></a></td>
            <td><a href="javascript:emoticon(':(')"><img src="images/smiles/icon_sad.gif" border="0" alt="Sad" title="Sad" /></a></td>
            <td><a href="javascript:emoticon(':s)')"><img src="images/smiles/icon_surprised.gif" border="0" alt="Surprised" title="Surprised" /></a></td>
            <td><a href="javascript:emoticon(':shock:')"><img src="images/smiles/icon_eek.gif" border="0" alt="Shocked" title="Shocked" /></a></td>
            <td><a href="javascript:emoticon(':?')"><img src="images/smiles/icon_confused.gif" border="0" alt="Confused" title="Confused" /></a></td>
            <td><a href="javascript:emoticon('8)')"><img src="images/smiles/icon_cool.gif" border="0" alt="Cool" title="Cool" /></a></td>
            <td><a href="javascript:emoticon(':lol:')"><img src="images/smiles/icon_lol.gif" border="0" alt="Laughing" title="Laughing" /></a></td>
            <td><a href="javascript:emoticon(':x')"><img src="images/smiles/icon_mad.gif" border="0" alt="Mad" title="Mad" /></a></td>
            <td><a href="javascript:emoticon(':P')"><img src="images/smiles/icon_razz.gif" border="0" alt="Razz" title="Razz" /></a></td>
            <td><a href="javascript:emoticon(':oops:')"><img src="images/smiles/icon_redface.gif" border="0" alt="Embarassed" title="Embarassed" /></a></td>
			
            <td><a href="javascript:emoticon(':cry:')"><img src="images/smiles/icon_cry.gif" border="0" alt="Crying or Very sad" title="Crying or Very sad" /></a></td>
            <td><a href="javascript:emoticon(':evil:')"><img src="images/smiles/icon_evil.gif" border="0" alt="Evil or Very Mad" title="Evil or Very Mad" /></a></td>
            <td><a href="javascript:emoticon(':twisted:')"><img src="images/smiles/icon_twisted.gif" border="0" alt="Twisted Evil" title="Twisted Evil" /></a></td>
            <td><a href="javascript:emoticon(':roll:')"><img src="images/smiles/icon_rolleyes.gif" border="0" alt="Rolling Eyes" title="Rolling Eyes" /></a></td>
            <td><a href="javascript:emoticon(':wink:')"><img src="images/smiles/icon_wink.gif" border="0" alt="Wink" title="Wink" /></a></td>
            <td><a href="javascript:emoticon(':!:')"><img src="images/smiles/icon_exclaim.gif" border="0" alt="Exclamation" title="Exclamation" /></a></td>
            <td><a href="javascript:emoticon(':?:')"><img src="images/smiles/icon_question.gif" border="0" alt="Question" title="Question" /></a></td>
            <td><a href="javascript:emoticon(':idea:')"><img src="images/smiles/icon_idea.gif" border="0" alt="Idea" title="Idea" /></a></td>
            <td><a href="javascript:emoticon(':arrow:')"><img src="images/smiles/icon_arrow.gif" border="0" alt="Arrow" title="Arrow" /></a></td>
            <td><a href="javascript:emoticon(':|')"><img src="images/smiles/icon_neutral.gif" border="0" alt="Neutral" title="Neutral" /></a></td>
            <td><a href="javascript:emoticon(':mrgreen:')"><img src="images/smiles/icon_mrgreen.gif" border="0" alt="Mr. Green" title="Mr. Green" /></a></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>


