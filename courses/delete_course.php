<?php
require("../include/global_login.php")

//kjshakjh as
$check_ok=mysql_query("SELECT * FROM courses WHERE id=$courses AND users=".$person["id"].";");
if(mysql_num_rows($check_ok)!=0){
        mysql_query("DELETE FROM courses WHERE id=$courses;");
        mysql_query("DELETE FROM wp WHERE courses=$courses;");
		mysql_query("DELETE FROM courses_history WHERE courses='$courses';");
}


?>
<html>
<head>
        <title>Delete course</title>
</head>

<body>



</body>
</html>