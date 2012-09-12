<?
require("../include/global_login.php");

if($person["admin"]==1){
	$getcourse=mysql_query("SELECT * FROM courses WHERE id=$courses;");
}else{
	$getcourse=mysql_query("SELECT * FROM courses WHERE id=$courses AND users=".$person["id"].";");
}

if(mysql_num_rows($getcourse)!=0){
	mysql_query("UPDATE courses set name='".str_replace("'","&#039;",$coursename)."', info='$info',applyopen=$applyopen WHERE id=$courses;");

		//set access in wp_access
		//First - delete everything from wp_access for this course
	mysql_query("DELETE FROM wp_access WHERE courses=$courses;");
		//Next - insert new access parameters
	while(list($key,$var)=each($modules_type)){
			mysql_query("INSERT INTO wp_access(courses,modules_type) VALUES ($courses,".$var.")");
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
<div align="center" class="main">Course updated...</div>
</body>
</html>