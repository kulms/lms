<?php
require("../include/global_login.php");
?>
<html lang="en-US"><head>

<Script Language="JavaScript">
<!--
function SendOne()
{
document.implogin.submit();
}
-->
</Script>

</head>
<body onload="SendOne()"

<center>
<form action="https://webmail2.ku.ac.th/horde/imp/redirect2.php" method="post" name="implogin">
<input type="hidden" name="actionID" value="105" />
<input type="hidden" name="redirect_url" value="" />
<input type="hidden" name="mailbox" value="INBOX" />
<input type="hidden" name="imapuser" value="<?php echo $person["login"]; ?>" />
<input type="hidden" name="pass" value="<?php echo $spassword;?>"/>
<input type="hidden" name="new_lang" value="en_US"/>
<input type="hidden" name="server" value="nontri.ku.ac.th" />
<input type="hidden" name="folders" value="mail/" />
</form>
</body>
</html>