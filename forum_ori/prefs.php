<?
require ("../include/global_login.php");

if($update!=1){
	$names=mysql_query("SELECT u.firstname,u.surname, m.name FROM users u, modules m WHERE u.id=".$person["id"]." AND m.id=$modules;");
	if($row=mysql_fetch_array($names)){
		$prefs=mysql_query("SELECT id,mail FROM forum_ori_prefs WHERE users=".$person["id"]." AND modules=$modules;");
		if(mysql_num_rows($prefs)!=0){
			$mailstate=mysql_result($prefs,0,"mail");
			$prefsid=mysql_result($prefs,0,"id");
		}
		$username=$row["firstname"]."&nbsp;".$row["surname"];
		$forumname=$row["name"];
	}
?>
	<html>
	<head>
	<title></title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body bgcolor="#ffffff">
	<table cellpadding="0" cellspacing="0" width="70%">
		<tr>
			<td width="15%">&nbsp;</td>
			<td colspan="3" align="center" class="h3">Preferences for <?echo $username?> in <?echo $forumname?></td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td class="main" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td><form action="prefs.php" method="post">
			<td class="main">If you check this box and click Update, you will receive an email for every new or edited message in this forum. Uncheck to unsubscribe.</td>
			<td colspan="2" align="left"><input type="checkbox" name="sendmail"<?if($mailstate==1){?> checked<?}?>></td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td class="main" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td colspan="3">
			<input type="hidden" name="update" value="1">
			<input type="hidden" name="modules" value="<?echo $modules?>">
			<input type="hidden" name="id" value="<?echo $prefsid?>">
			<input type="submit" value="Update"></td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td class="main" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td class="main" colspan="3"><a href="show.php?module=<?echo $modules?>">Back to <?echo $forumname?></a></td>
		</tr>
	</table></form>

	</body>
	</html>
<?
}else{
	if($sendmail=="on"){
		$sendmail=1;
	}else{
		$sendmail=0;
	}
	if($id==0 || $id==""){
		mysql_query("INSERT INTO forum_ori_prefs(users,modules,mail) VALUES(".$person["id"].",$modules,$sendmail);");
	}else{
		mysql_query("UPDATE forum_ori_prefs SET mail=$sendmail WHERE id=$id;");
	}

	header("Status: 302 Moved Temporarily");
	header("Location: show.php?module=".$modules);
}?>
