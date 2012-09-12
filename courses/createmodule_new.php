<? 
require("../include/global_login.php");
require("../include/function.inc.php");

if($cases==""){$cases=0;}
if($groups==""){$groups=0;}
if($modules_type<0){
	if($modules_type==-1){
		//************************** f o l d e r *****************************************
		mysql_query("INSERT INTO folders (name,refid,users,courses) values('".str_replace("'","&#039;",$name)."',$folders,".$person["id"].",1);");
		$folder_id=mysql_insert_id();
		//***********insert modules_history***************
		$action="Create";
		Imodules_h2($modules_type,$action,$person["id"],0,$folder_id,0,$courses);

		mysql_query("INSERT INTO wp (courses,folders,cases,groups,users) values(".$courses.",$folder_id,$cases,$groups,".$person["id"].");");
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
		<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
		<body onLoad="update()" bgcolor="#ffffff">
		<div align="center" class="main">Folder created.....</div>
		</body>
		</html><?
	}
	if($modules_type==-2){
		//************************** c a s e *****************************************
		mysql_query("INSERT INTO cases (name,active,users) values('".str_replace("'","&#039;",$name)."',1,".$person["id"].");");
		mysql_query("INSERT INTO wp (courses,cases,folders) values($courses,".mysql_insert_id().",$folders);");
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
		<div align="center" class="main">Case created.....</div>
		</body>
		</html>
		<?
	}
	if($modules_type==-3){
		//************************** g r o u p s *****************************************
		mysql_query("INSERT INTO groups (name,active,users,courses) values('".str_replace("'","&#039;",$name)."',1,".$person["id"].",$courses);");
		$groups=mysql_insert_id();
		//***********insert modules_history***************
		$action="Create";
		Imodules_h2($modules_type,$action,$person["id"],$groups,0,0,$courses);
		mysql_query("INSERT INTO wp (courses,cases,groups,folders) values($courses,$cases,$groups,$folders);");
		mysql_query("INSERT INTO wp (groups,users,admin) values($groups,".$person["id"].",1);");
		?>
		<html>
		<head>
		<META HTTP-EQUIV="Refresh" CONTENT="1;URL=../groups/admin_users.php?groups=<?echo $groups?>&courses=<?echo $courses?>">
			<title>updated</title>
		<script language="javascript">
		</script>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		</head>
		<body bgcolor="#ffffff">
		<div align="center" class="main">Group created.....</div>
		</body>
		</html>
		<?
	}
}else{
	//************************** m o d u l e s *****************************************
mysql_query("INSERT INTO modules (name,modules_type,users,updated,created,active) values('".str_replace("'","&#039;",$name)."',$modules_type,".$person["id"].",".time().",".time().",1);");
	$modules=mysql_insert_id();

//***********insert modules_history***************
$action="Create";
Imodules_h($modules,$action,$person["id"],$courses);

if($folders==""){
	$folders=0;
	}
	mysql_query("INSERT INTO wp (courses,modules,folders,cases,groups,users,admin) values($courses,".$modules.",$folders,$cases,$groups,".$person["id"].",1);");
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
		?>
		<html>
		<head>
			<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../<?echo mysql_result($mt,0,"url_setup")."?modules=".$modules?>">
			<title>updated</title>
		<script language="javascript">
		</script>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		</head>
		<body bgcolor="#ffffff">
		<div align="center" class="main">Module created...</div>
		</body>
		</html>
		<?
	}
}
?>
