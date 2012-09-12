<?require("../include/global_login.php");?>
<html>
<center>
<form
action="https://webmail.ku.ac.th/horde/imp/mailbox.php3" method="post" name="implogin">
<input type="hidden" notab name="actionID" value="6">
<input type="hidden" notab name="mailbox" value="INBOX">
<input type="hidden" name="new_lang" value="en">
<table border="0" width="300">
<tr>
   <td align="right"><font size="2" face="MS Sans
Serif,Verdana,Geneva,Arial,Helvetica,sans-serif"><b>Username</b></font></td>
   <td><input type="text" tabindex="1" name="imapuser" value="<?echo $person["login"];?>"></td>
</tr>
<tr>
   <td align="right"><font size="2" face="MS Sans
Serif,Verdana,Geneva,Arial,Helvetica,sans-serif"><b>Password</b></font></td>
   <td><input type="password" tabindex="2" name="pass"></td>
</tr>
<tr>
  <td align="right"><font size="2" face="MS Sans Serif,Verdana,Geneva,Arial,Helvetica,sans-serif"><b>Server</b></font></td>
  <td><select name="IMAPServer" tabindex=3>
<option value="Nontri">nontri.ku.ac.th
<option value="Pirun">pirun.ku.ac.th
 </select>
  </td>
</tr>
<tr><td>&nbsp;</td><td align="center">
<input type="submit" name="button" value="login">
<?//<input type="submit" name="button" tabindex="4" value="log
//in" onClick="submit_login();return(false);"></td><td>&nbsp;</td></tr>
?></table>
</form>
</html>