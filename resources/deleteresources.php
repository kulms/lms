<?require("../include/global_login.php");
if($person["admin"]==1){
	$getresources=mysql_query("SELECT * FROM modules WHERE id=$modules;");
	if(mysql_num_rows($getresources)!=0){
		mysql_query("DELETE FROM resources WHERE modules=$modules;");
		mysql_query("DELETE FROM modules WHERE id=$modules;");
		mysql_query("DELETE FROM wp WHERE modules=$modules;");
		mysql_query("DELETE FROM login_modules WHERE modules=$forum;");
	}
}else{
	$getresources=mysql_query("SELECT * FROM modules WHERE id=$modules AND users=".$person["id"].";");
	if(mysql_num_rows($getresources)!=0){
		mysql_query("DELETE FROM resources WHERE modules=$modules;");
		mysql_query("DELETE FROM modules WHERE id=$modules AND users=".$person["id"].";");
		mysql_query("DELETE FROM wp WHERE modules=$modules;");
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
<div align="center" class="main">Resource deleted...</div>
</body>
</html>