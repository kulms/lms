<?php
require("../include/global_login.php");
?>
<html>
<head>
	<title>Personal administration</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="javascript">
function rename_check(){
	if(document.renameform.foldername.value==""){
		alert("You can't have an empty foldername");
		return false;
	}else{
		return true;
	}
}
function delete_check(){
	if(confirm("Do you really want to delete "+document.renameform.foldername.value+" and all it´s content?")){
		if(confirm("Are you really...REALLY sure?\nThis action can't be undone.")){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
</script>
</head>
<body bgcolor="#ffffff">
<div align="center">
<h1 class="h1">Edit/Add</h1>
<table border="0" cellpadding="2" cellspacing="0">
<?php
if($folders!=0){
	$folder=mysql_query("SELECT DISTINCT f.name FROM folders f,wp WHERE f.id=$folders AND wp.users=".$person["id"]." AND wp.folders=f.id;");
	if(mysql_num_rows($folder)!=0){
		$foldername=mysql_result($folder,0,"name");
		?>
		<tr>
			<td class="main" align="left" valign="top">
				Rename folder:
			</td>
			<form action="renamefolder.php" method="post" onSubmit="return rename_check();" name="renameform">
				<td colspan="2" class="main" align="right" valign="top">
					<input type="text" name="foldername" maxlength="10" size="15" value="<?phpecho mysql_result($folder,0,"name")?>" class="small">
					<input type="hidden" name="folders" value="<?phpecho $folders?>">
					<input type="submit" value="Update" class="small"></form>
				</td>
		</tr>
		<tr>
			<td class="main" align="left" valign="top">
				Delete folder:
			</td>
			<form action="deletefolder.php" method="post" onSubmit="return delete_check();" name="deleteform">
				<td class="main" align="right" valign="top">
					<input type="hidden" name="folders" value="<?phpecho $folders?>">
					<input type="submit" value="Delete" class="small">
				</td>
			</form>
		</tr>		  
		<?php
	}
}
$mt=mysql_query("SELECT DISTINCT mt.name,mt.id,mt.picture,mt.info FROM modules_type mt, wp_access wa WHERE wa.modules_type=mt.id AND wa.courses=0 AND wa.cases=0 AND wa.groups=0 AND (wa.users=0 OR wa.users=".$person["id"].");");
//$mt=mysql_query("SELECT mt.id,mt.name,mt.picture FROM wp_access wa,modules_type mt WHERE wa.modules_type=mt.id AND mt.active=1;");
//echo mysql_num_rows($mt);
?>
<tr>
	<td colspan="2">
		<hr noshade size="2" width="300">
	</td>
</tr>
<form action="createmodule.php" method="post">
<input type="hidden" name="folders" value="<?php echo $folders?>">
<tr>
	<td rowspan="<?phpecho (mysql_num_rows($mt)+2)?>" class="main" align="left" valign="top">
		Create new:
	</td>
	<td class="main">
		<b><?php echo $foldername?>/</b><input type="text" name="name" class="small" maxlength="10">
	</td>
</tr>
<tr>
	<td class="main">
		<input type="radio" name="modules_type" value="0" checked>
		<img src="../images/folder.gif" alt="">
		<b>Folder</b>
	</td>

</tr>

<?php
while($row=mysql_fetch_array($mt)){
	?>
	<tr>
		<td class="main">
			<input type="radio" name="modules_type" value="<?phpecho $row["id"]?>">
			<img src="../<?phpecho $row["picture"]?>">
			<b><?phpecho $row["name"]?></b>
			<span class="small"><?phpecho $row["info"]?></span>
		</td>
	</tr>
	<?php
}
?>
<tr>
	<td colspan="2" align="right" class="small" valign="top">
		<input type="submit" value="Create">
	</td>
</tr>
</form>
</table>
</div>
</body>
</html>
