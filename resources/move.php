<? require("../include/global_login.php");
mysql_query("UPDATE resources set refid = '$lstFolder' WHERE id=$id;");
mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules");
?>
