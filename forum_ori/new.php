<?
require ("../include/global_login.php");

if($update!="true"){

	$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
	$modules=mysql_query("SELECT * from modules WHERE id=".$module);
	?>
	<html>
	<head>
		<title>New contribution to <?echo mysql_result($modules,0,"name");?></title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body BGCOLOR="#FFFFFF">
	<center>
	<form ACTION="new.php" METHOD="POST" name="newcontrib">
		<textarea name="info" ROWS="6" COLS="49" wrap="virtualy" class="small"></textarea><br>
		<input TYPE="Submit" VALUE="Send" class="main"><input TYPE="Reset" VALUE="Clear" class="main">
		<input type="hidden" name="module" value="<?echo $module;?>">
		<input type="hidden" name="update" value="true">
	</form>
	</center>
	<script LANGUAGE="JavaScript">
	<!--
		document.newcontrib.info.select();
		document.newcontrib.info.focus();
	// - End of JavaScript - -->
	</script>

	</body>
	</html>
	<?
}else{
	if(strlen($info)!=0){
		$info_in=$info;
		$info=str_replace("'","&#039;",str_replace("\n","<br>",$info));
		mysql_query("INSERT INTO forum_ori (users,modules,info,time) VALUES(".$person["id"].",".$module.",'".$info."',".time().");");
		mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$module;");
		$getprefs=mysql_query("SELECT u.email,m.name FROM users u, forum_ori_prefs fp, modules m WHERE fp.mail=1 AND fp.modules=$module AND u.id=fp.users AND m.id=$module;");
		while($mailrow=mysql_fetch_array($getprefs)){
			mail($mailrow["email"],"New contribution to ".$mailrow["name"]." in
LearnLoop","Posted ".date("H:i, d-m-Y",time())." by ".$person["firstname"]."
".$person["surname"]."\n\nContribution:\n".$info_in,"From:LearnLoop@$SERVER_NAME");
		}
	}
	?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	self.close()
	//-->
	</SCRIPT>
	<?
}
mysql_close();?>
