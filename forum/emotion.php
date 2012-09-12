<?
session_start();
require ("../include/global_login.php");
?>
<HTML>
<HEAD>
<TITLE> emotion</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<script language="javascript" type="text/javascript">
<!--
function emoticon(text) {
	text = ' ' + text + ' ';
	
	opener.document.new_forum.info.value  += text;
	opener.document.new_forum.info.focus();
	window.close();
}
//-->
</script>
</HEAD>

<BODY leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td><table width="100%" border="0" cellspacing="1" cellpadding="4" class="tdborder2" >
			<tr class="boxcolor">
				<td align="center" class="Bcolor">Emotions</td>
			</tr>
			<tr>
				<td><table width="100" border="0" cellspacing="0" cellpadding="5">
					<tr align="center" valign="middle">
						<td><a href="javascript:emoticon(':D')"><img src="images/smiles/icon_biggrin.gif" border="0" alt="Very Happy" title="Very Happy" /></a></td>
						<td><a href="javascript:emoticon(':)')"><img src="images/smiles/icon_smile.gif" border="0" alt="Smile" title="Smile" /></a></td>
						<td><a href="javascript:emoticon(':(')"><img src="images/smiles/icon_sad.gif" border="0" alt="Sad" title="Sad" /></a></td>
						<td><a href="javascript:emoticon(':s)')"><img src="images/smiles/icon_surprised.gif" border="0" alt="Surprised" title="Surprised" /></a></td>
						<td><a href="javascript:emoticon(':shock:')"><img src="images/smiles/icon_eek.gif" border="0" alt="Shocked" title="Shocked" /></a></td>
						<td><a href="javascript:emoticon(':?')"><img src="images/smiles/icon_confused.gif" border="0" alt="Confused" title="Confused" /></a></td>
						<td><a href="javascript:emoticon('8)')"><img src="images/smiles/icon_cool.gif" border="0" alt="Cool" title="Cool" /></a></td>
						<td><a href="javascript:emoticon(':lol:')"><img src="images/smiles/icon_lol.gif" border="0" alt="Laughing" title="Laughing" /></a></td>
					</tr>
					<tr align="center" valign="middle">
						<td><a href="javascript:emoticon(':x')"><img src="images/smiles/icon_mad.gif" border="0" alt="Mad" title="Mad" /></a></td>
						<td><a href="javascript:emoticon(':P')"><img src="images/smiles/icon_razz.gif" border="0" alt="Razz" title="Razz" /></a></td>
						<td><a href="javascript:emoticon(':oops:')"><img src="images/smiles/icon_redface.gif" border="0" alt="Embarassed" title="Embarassed" /></a></td>
						<td><a href="javascript:emoticon(':cry:')"><img src="images/smiles/icon_cry.gif" border="0" alt="Crying or Very sad" title="Crying or Very sad" /></a></td>
						<td><a href="javascript:emoticon(':evil:')"><img src="images/smiles/icon_evil.gif" border="0" alt="Evil or Very Mad" title="Evil or Very Mad" /></a></td>
						<td><a href="javascript:emoticon(':twisted:')"><img src="images/smiles/icon_twisted.gif" border="0" alt="Twisted Evil" title="Twisted Evil" /></a></td>
						<td><a href="javascript:emoticon(':roll:')"><img src="images/smiles/icon_rolleyes.gif" border="0" alt="Rolling Eyes" title="Rolling Eyes" /></a></td>
						<td><a href="javascript:emoticon(':wink:')"><img src="images/smiles/icon_wink.gif" border="0" alt="Wink" title="Wink" /></a></td>
					</tr>
					<tr align="center" valign="middle">
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
				<td align="center"><br /><a href="javascript:window.close();" >Close Window</a></td>
			</tr>
		</table></td>
	</tr>
</table>



		</td>
	</tr>
</table>

</body>
</html>

