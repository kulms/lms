<?
require("../include/global_login.php");
include("../include/function.inc.php");

$getforum=mysql_query("SELECT * FROM modules WHERE id=".$modules." AND users=".$person["id"].";");
if(mysql_num_rows($getforum)!=0 || $person["admin"]==1){
	mysql_query("UPDATE modules set name='".str_replace("'","&#039;",$modulename)."', info='".$info."' WHERE id=".$modules.";");
	//***********insert modules_history***************
	$action="Update";
	Imodules_h($modules,$action,$person["id"],$courses);
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
<link rel="STYLESHEET" type="text/css" href="../css.php">
</head>
<body onLoad="update()" bgcolor="#ffffff">
<div align="center" class="main">updated...</div>
</body>
</html>