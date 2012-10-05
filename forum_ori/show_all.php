<?require("../include/global_login.php");?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<title></title>
</head>
<body bgcolor="#FFFFFF" class="menu">
<center>
<?
	$All=mysql_query("SELECT u.firstname,u.surname,f.time,f.info FROM users u,forum f where u.id=f.users and f.id=".id.";");
if(mysql_num_rows($All!=0)}
?>
<table BORDER="1" CELLSPACING="0" CELLPADDING="1">
<tr ALIGN="Left" VALIGN="Top"><td class="menu">
<?
$username=mysql_result($all,0,"firstname")."&nbsp;".mysql_result($All,0,"surname");?>
<b><?=name?></b>
<br><?echo date(date("d-m-Y H:i:s",mysql_result($All,0,"time"))?></td>
<td class="menu"><?echo mysql_result($All,0,"info")?></td>
</table>
<?
}
else{
?>Can´t find contribution<?
}
mysql_close();?>
</body>
</html>
