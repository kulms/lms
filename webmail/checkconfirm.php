<?
require("../include/global_login.php");
require("../include/colors.php");
?>
<html>
<head>
	<title>Confirm check</title>
<script language="javascript">
function startup(){
	self.focus();
}
</script>
<link rel="STYLESHEET" type="text/css" href="../css.php">
</head>
<body bgcolor="<?echo $cBGcolor?>" onLoad="startup()">
<div align="center" class="main">
<?
if($update!="true"){
$acc=mysql_query("SELECT * from email WHERE modules=$id AND id=$acc;");
$a=mysql_fetch_array($acc);
if($person["id"]!=$a["userid"]){
	$a["mailpasswd"]="";
	$a["remember"]=0;
}
?>
<form action="checkconfirm.php" method="post">
<input type="hidden" name="id" value="<?echo $id?>">
<input type="hidden" name="acc" value="<?echo $a["id"]?>">
<input type="hidden" name="update" value="true">
<table border="0" cellspacing="0" cellpadding="1">
	<tr>
		<td class="main" align="right"><b>Login:</b></td>
		<td class="main" align="left"><input type="text" class="main" size="12" name="mailid" value="<?echo $a["mailid"]?>"></td>
	</tr>
	<tr>
		<td class="main" align="right"><b>Password:</b></td>
		<td class="main" align="left"><input type="password" class="main" size="12" name="mailpasswd" value="<?echo $a["mailpasswd"]?>"></td>
	</tr>
	<tr>
		<td class="main" align="right"><b>Remember:</b></td>
		<td class="main" align="left"><input type="checkbox" class="main" name="remember" value="true" <?if($a["remember"]==1){echo "checked";}?>></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="main">
			<input type="submit" value="Check email" class="main">
		</td>
	</tr>
</table>

</form>
<?
}else{
	if($remember=="true"){
		mysql_query("UPDATE email set mailid='$mailid',mailpasswd='$mailpasswd',remember=1 WHERE id=$acc AND modules=$id;");
	}else{
		mysql_query("UPDATE email set mailid='$mailid',mailpasswd='',remember=0 WHERE id=$acc AND modules=$id;");
	}
	?><b>Checking Email....</b>
	<script language="javascript">
		location.href="checkmail.php?id=<?echo $id?>&acc=<?echo $acc?>&macc=<?echo $mailid?>&mpas=<?echo $mailpasswd?>";
	</script>
	<?
}
?>
</div></body>
</html>

