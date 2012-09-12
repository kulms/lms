<? require("../include/global_login.php");
if($id==0){
	mysql_query("INSERT INTO resources_center (name,folder,refid,faculty,department,major,users,time) 
				VALUES ('$name',1,$refid,'$fac','$dept','$major',".$person["id"].",".time().");");
}
//mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
header("Status: 302 Moved Temporarily");
//header("Location: index.php");
header("Location: show_res.php?fac=$fac&dept=$dept&major=$major");
?>
