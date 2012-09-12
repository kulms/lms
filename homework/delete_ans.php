<?require("../include/global_login.php");
mysql_query("DELETE FROM homework_ans WHERE refid=$id AND modules=$modules AND users=".$person["id"].";");
$allpath =$realpath."/files/homework/ansfiles/$id/$file";
exec("rm -f $realpath/files/homework/ansfiles/$id/$file");
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules");
?>