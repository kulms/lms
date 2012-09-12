<? require("../include/global_login.php");
if($id==0){
	if ($courses!=0) {
		mysql_query("INSERT INTO resources (name,folder,courses,modules,refid,users,time) values('$name',1,$courses,$modules,$refid,".$person["id"].",".time().");");
	} else {
		mysql_query("INSERT INTO resources (name,folder,modules,refid,users,time) values('$name',1,$modules,$refid,".$person["id"].",".time().");");
	}
}
mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules&courses=$courses");
?>
