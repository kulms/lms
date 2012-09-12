<?php
require("../include/global_login.php");

while(list($key,$val)=each($students)){
	$sql = "INSERT INTO wp (users,groups) values($val,$groups);";
	mysql_query($sql);
	//echo $sql."<br>";	
}
//header("Status: 302 Moved Temporarily");
//header("Location:  ../courses/users.php?courses=$courses&groups=$groups");
?>
<html>
<head>
	<title>updated</title>
<script language="javascript">
	function update(){
		top.ws_menu.location.reload();
	}
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body onLoad="update()" bgcolor="#ffffff">
<div align="center" class="main">Group Members saved...</div>
</body>
</html>