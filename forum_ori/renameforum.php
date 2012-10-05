<?
require("../include/global_login.php");
$getforum=mysql_query("SELECT * FROM modules WHERE id=$forum AND users=".$person["id"].";");
if(mysql_num_rows($getforum)!=0 || $person["admin"]==1){
	mysql_query("UPDATE modules set name='".str_replace("'","&#039;",$forumname)."', info='$info' WHERE id=$forum;");
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
<div align="center" class="main">Forum updated...</div>
</body>
</html>