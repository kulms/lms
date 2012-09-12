<? require("../include/global_login.php");
function deletefolders($folder){
	global $person;
	$m=mysql_query("SELECT mt.url_delete,m.id FROM modules m,wp,modules_type mt WHERE wp.users=".$person["id"]." AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=$folder;");
	while($row=mysql_fetch_array($m)){
		mysql_query("UPDATE modules SET temp=1 WHERE users=".$person["id"]." AND id=".$row["id"].";");
		mysql_query("UPDATE wp SET temp=1 WHERE modules=".$row["id"].";");
		if(strlen($row["url_delete"])>0){
			$modules=$row["id"];
			include("../".$row["url_delete"]);
		}
	}
	$folders=mysql_query("SELECT f.id FROM folders f,wp WHERE wp.modules=0 AND wp.folders=f.id AND f.refid=$folder AND wp.users=".$person["id"].";");
	while($row=mysql_fetch_array($folders)){
		mysql_query("UPDATE folders SET temp=1 WHERE users=".$person["id"]." AND id=".$row["id"].";");
		mysql_query("UPDATE wp SET temp=1 WHERE folders=".$row["id"].";");
		deletefolders($row["id"]);
	}
}

$folder=mysql_query("SELECT DISTINCT f.name FROM folders f,wp WHERE f.id=$folders AND wp.users=".$person["id"]." AND wp.folders=f.id;");
if(mysql_num_rows($folder)!=0){
	mysql_query("UPDATE folders set temp=1 WHERE id=$folders;");
	mysql_query("UPDATE wp set temp=1 WHERE folders=$folders;");
	deletefolders($folders);
	mysql_query("DELETE FROM modules WHERE temp=1;");
	mysql_query("DELETE FROM wp WHERE temp=1;");
	mysql_query("DELETE FROM folders WHERE temp=1;");
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
<div align="center" class="main">Folder deleted.....</div>
</body>
</html>