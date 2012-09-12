<?
require("../include/global_login.php");
require("../include/function.inc.php");
$folder=mysql_query("SELECT DISTINCT f.name FROM folders f,wp WHERE f.id=$folders AND wp.courses=$courses AND wp.folders=f.id;");
if(mysql_num_rows($folder)!=0){
	mysql_query("UPDATE folders set name='".str_replace("'","&#039;",$foldername)."' WHERE id=$folders;");		

	//***********insert modules_history***************
		$action="Update";
		Imodules_h2(-1,$action,$person["id"],0,$folders,0,$courses);
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