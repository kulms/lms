<?
	require("include/global_login.php");
	require("personal/msg/message.class.php");
	require("calendar/calfunc.php");

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="themes/<?php echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 00px;
}
-->
</style></head>

<body>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
        <tr>
          <td width="19%" valign="top" class="news"><div align="center"><a href="personal/menu.php?msg=1" target="ws_menu"><img src="images/inboxlogo.gif" width="49" height="50" border="0"></a><br>
                  <a href="personal/menu.php?msg=1" target="ws_menu"><?php echo $strPersonal_MenuMsg;?></a><br>
          </div></td>
          <td width="3%">&nbsp;</td>
          <td width="78%" valign="top" class="news">
            <div align="left"><?php echo $strPersonal_msg_inbox;?><br>
                <br>
                <?
						$message =new Message(4,$person['id']);
						$con= $message->SelectBox($message); //row is condition  for SELECT
						$result=$message->ListMsg($message,$con,$page);
						$num=$result->numRows();
						if($num ==0){
								echo  "$strPersonal_msg_New  $num  $strPersonal_msg_Message";
						}else{
							echo "<a href=\"personal/menu.php?msg=1\"  target=\"ws_menu\">$strPersonal_msg_New  ".$num."  $strPersonal_msg_Message</a>";
					     }
				?>
          </div></td>
        </tr>
    </table>
</body>
</html>
