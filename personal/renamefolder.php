<?
require("../include/global_login.php");
$folder=mysql_query("SELECT DISTINCT f.name FROM folders f,wp WHERE f.id=$folders AND wp.users=".$person["id"]." AND wp.folders=f.id;");
if(mysql_num_rows($folder)!=0){
	mysql_query("UPDATE folders set name='$foldername' WHERE id=$folders;");
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
<div align="center" class="main">Folder updated.....</div>
</body>
</html>