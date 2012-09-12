<?
require("../include/global_login.php");
require("../include/function.inc.php");
			//***********insert modules_history***************
		$action="Update";
		Imodules_h2(-3,$action,$person["id"],$groups,0,0,$courses);

mysql_query("UPDATE groups set name='".str_replace("'","&#039;",$groupname)."' WHERE id=$groups;");
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
<div align="center" class="main">Group updated.....</div>
</body>
</html>