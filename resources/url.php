<? require("../include/global_login.php");
if($id==0){
	if ($courses!=0) {
		mysql_query("INSERT INTO resources (name,folder,modules,refid,url,courses,new_window,users,time) values('$name',0,$modules,$refid,'$url','$courses','$file_target',".$person["id"].",".time().");");
	} else {
		mysql_query("INSERT INTO resources (name,folder,modules,refid,url,new_window,users,time) values('$name',0,$modules,$refid,'$url','$file_target',".$person["id"].",".time().");");
	}
}else{		
	mysql_query("UPDATE resources set url='$url', new_window='$file_target' WHERE id=$id;");
	$sql = mysql_query("SELECT * FROM resources WHERE ref_res=$id;");
	if ((mysql_num_rows($sql)) != 0) {
		mysql_query("UPDATE resources set url='$url', new_window='$file_target', time=".time()." WHERE ref_res=$id;");
	}
}
mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules&courses=$courses");
?>
