<?
require("../include/global_login.php");
if($modules_type==0){
	//************************** f o l d e r *****************************************
	mysql_query("INSERT INTO folders (name,refid,users) values('$name',$folders,".$person["id"].");");
	mysql_query("INSERT INTO wp (users,folders) values(".$person["id"].",".mysql_insert_id().");");
	?>
	<html>
	<head>
		<title>updated</title>
	<script language="javascript">
		function update(){
			top.ws_menu.location.reload();
		}
	</script>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body onLoad="update()" bgcolor="#ffffff">
	<div align="center" class="main">Folder created.....</div>
	</body>
	</html>
	<?
}else{
	//************************** m o d u l e s *****************************************
	mysql_query("INSERT INTO modules (name,modules_type,users) values('$name',$modules_type,".$person["id"].");");
	$modules=mysql_insert_id();
	mysql_query("INSERT INTO wp (users,modules,folders) values(".$person["id"].",".$modules.",$folders);");
	$mt=mysql_query("SELECT mt.url_setup FROM modules_type mt WHERE id=$modules_type;");
	if(mysql_result($mt,0,"url_setup")==""){
		?>
		<html>
		<head>
			<title>updated</title>
		<script language="javascript">
			function update(){
				top.ws_menu.location.reload();
			}
		</script>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		</head>
		<body onLoad="update()" bgcolor="#ffffff">
		<div align="center" class="main">Module created...</div>
		</body>
		</html>
		<?
	}else{
		header("Status: 302 Moved Temporarily");
		header("Location: ../".mysql_result($mt,0,"url_setup")."?modules=".$modules);
	}
}
?>
