<?
require("../include/global_login.php");
if($person["admin"]==1){
	$getforum=mysql_query("SELECT * FROM modules WHERE id=$forum;");
	if(mysql_num_rows($getforum)!=0){
		mysql_query("DELETE FROM forum_ori WHERE modules=$forum;");
		mysql_query("DELETE FROM modules WHERE id=$forum;");
		mysql_query("DELETE FROM wp WHERE modules=$forum;");
		mysql_query("DELETE FROM login_modules WHERE modules=$forum;");
	}
}else{
	$getforum=mysql_query("SELECT * FROM modules WHERE id=$forum AND users=".$person["id"].";");
	if(mysql_num_rows($getforum)!=0){
		mysql_query("DELETE FROM forum_ori WHERE modules=$forum;");
		mysql_query("DELETE FROM modules WHERE id=$forum AND users=".$person["id"].";");
		mysql_query("DELETE FROM wp WHERE modules=$forum;");
		mysql_query("DELETE FROM login_modules WHERE modules=$forum;");
	}
}
?>
<html>
<head>
	<title>update</title>
<script language="javascript">
	function update(){
		top.ws_menu.location.reload();
	}
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body onLoad="update()" bgcolor="#ffffff">
<div align="center" class="main">Forum deleted...</div>
</body>
</html>