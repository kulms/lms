<?require ("../include/global_login.php");
$admincheck=mysql_query("SELECT id FROM wp WHERE courses=$courses AND users=".$person["id"]." AND admin=1;");
if(mysql_num_rows($admincheck)==0){
	$c_admin=0;
}else{
	$c_admin=1;
}

if($update!="true"){
?>
<html>
<head>
	<title>Users</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<div align="center">
<h3 class="h3">Add existing group</h3>
<table border="0" cellpadding="2" cellspacing="0">
<form action="addexisting.php" method="post">
<input type="hidden" name="courses" value="<?echo $courses?>">
<input type="hidden" name="cases" value="<?echo $cases?>">
<input type="hidden" name="folders" value="<?echo $folders?>">
<input type="hidden" name="update" value="true">
<?
$groups=mysql_query("SELECT * from groups WHERE courses=$courses;");
$ag=0;
while($row=mysql_fetch_array($groups)){
	$check=mysql_query("SELECT * from wp where courses=$courses AND cases=$cases AND folders=$folders AND groups=".$row["id"].";");
	if(mysql_num_rows($check)==0){
		?>
		<tr>
			<td class="main">
				<input name="groups[]" type="checkbox" value="<?echo $row["id"]?>">
			</td>
			<td class="main">
				<?echo $row["name"]?>
			</td>
		</tr>
		<?
		$ag++;
	}
}
if($ag==0){
	?>
		<tr>
			<td colspan="2" align="center" class="main">
			There are no available groups.
			</td>
		</tr>
	<?
}else{
	?>
		<tr>
			<td colspan="2" align="center" class="main">
				<input type="submit" value="Add groups">
			</td>
		</tr>
	<?
}
?>
</form>
</table>
</div>
</body>
</html>
<?
}else{
	if($person["admin"]==1 || $c_admin==1){
		if(is_array($groups)){
			while(list($key,$val)=each($groups)){
				mysql_query("INSERT INTO wp (courses,cases,folders,groups) values($courses,$cases,$folders,$val);");
			}
		}
	}
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
	<div align="center" class="main">Groups added...</div>
	</body>
	</html>
	<?
}
?>
