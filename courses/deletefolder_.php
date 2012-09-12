<?
require("../include/global_login.php");
function deletefolders($folder){
	global $person,$error,$courses;
//error!!
	$m=mysql_query("SELECT mt.url_delete,m.id,m.users FROM modules m,wp,modules_type mt WHERE wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=$folder;");
	while($row=mysql_fetch_array($m)){
		if($row["users"]!=$person["id"]){
			$error=1;
		}
		mysql_query("UPDATE modules SET temp=1 WHERE users=".$person["id"]." AND id=".$row["id"].";");
		mysql_query("UPDATE wp SET temp=1 WHERE modules=".$row["id"]." AND courses=$courses;");
	}//error!
	$folders=mysql_query("SELECT f.id FROM folders f,wp WHERE wp.folders=f.id AND f.refid=$folder AND wp.courses=$courses;");
	while($row=mysql_fetch_array($folders)){
		mysql_query("UPDATE folders SET temp=1 WHERE courses=$courses AND users=".$person["id"]." AND id=".$row["id"].";");
		mysql_query("UPDATE wp SET temp=1 WHERE folders=".$row["id"]." AND courses=$courses;");
		deletefolders($row["id"]);
	}
}

$error=0;
$folder=mysql_query("SELECT DISTINCT f.name FROM folders f,wp WHERE f.id=$folders AND wp.courses=$courses AND wp.folders=f.id;");
if(mysql_num_rows($folder)!=0){
	mysql_query("UPDATE folders set temp=1 WHERE id=$folders;");
	mysql_query("UPDATE wp set temp=1 WHERE folders=$folders AND courses=$courses AND users=0;");
	deletefolders($folders);
	if($error==0 || $person["admin"]==1){
		$checkmodules=mysql_query("SELECT mt.url_delete,m.id FROM modules_type mt, modules m WHERE m.temp=1 AND mt.id=m.modules_type;");
		while($row=mysql_fetch_array($checkmodules)){
			if($row["url_delete"]!=""){
				$modules=$row["id"];
				include("../".$row["url_delete"]);
			}
		}
		mysql_query("DELETE FROM modules WHERE temp=1;");
		mysql_query("DELETE FROM wp WHERE temp=1;");
		mysql_query("DELETE FROM folders WHERE temp=1;");
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
<?
	}else{
	mysql_query("UPDATE wp set temp=0;");
	mysql_query("UPDATE folders set temp=0;");	
	mysql_query("UPDATE modules set temp=0;");
	?>
	
	<html>
	<head>
		<title>Not deleted</title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body bgcolor="#ffffff">
	<p>&nbsp;</p>
	<div align="center" class="h5">Sorry, couldn't delete this folder since it contained modules created by other users.</div>
	</body>
	</html>
	
	
	<?}
}
?>
