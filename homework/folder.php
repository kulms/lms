<?require("../include/global_login.php");
mysql_query("INSERT INTO homework (name,modules,users,time)
values('$name',$modules,".$person["id"].",".time().");");
mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules");
?>