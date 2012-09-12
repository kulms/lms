<? require ("../include/global_login.php");?>

<html>
<head>
	<title>Forum admin</title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	<script language="javascript">
	<!-- 	
	function rename_check(){
		if(document.renameform.tforumname.value==""){
			alert("You can't have an empty name field!");
			return false;
		}else{
			return true;
		}
	}
	function delete_check(){
		if(confirm("Do you really want to delete "+document.renameform.tforumname.value+" and all it's content?")){
			if(confirm("Are you really...REALLY sure?\nThis action can't be undone.")){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	} 
	//-->
	</script>
	
</head>
<body>
<?
if($modules!=0){
	$id=$modules;
}
$getforum=mysql_query("SELECT * FROM modules WHERE id=$id AND users=".$person["id"].";");
if(mysql_num_rows($getforum)!=0){

?>
<h1 class="h1" align="center">Edit forum</h1>
<br>
	<table border="0" cellpadding="2" cellspacing="0" align="center">
			<tr>
				<td class="main" align="left" valign="top">
					Name:
				</td>
				<form action="renameforum.php" method="post" onSubmit="return rename_check();" name="renameform">
					<td class="main" align="left" valign="top">
						<input type="text" name="tforumname" maxlength="10" size="15" value="<?echo mysql_result($getforum,0,"name")?>" class="small">
						<input type="hidden" name="forum" value="<?echo $id?>">
					</td>
			</tr>
			<tr>
				<td class="main" align="left" valign="top">
					Info:
				</td>			
					<td class="main" align="left" valign="top">
							<textarea name="info" cols="25" rows="5" class="small" wrap="PHYSICAL"><?echo mysql_result($getforum,0,"info")?></textarea>
							<br><input type="submit" value="Update" class="small">				
					</td>
				</form>
			</tr>
			<tr>
				<td class="main" align="left" valign="top">
					Delete:
				</td>
				<form action="deleteforum.php" method="post" onSubmit="return delete_check();" name="deleteform">
					<td class="main" align="left" valign="top">
						<input type="hidden" name="forum" value="<?echo $id?>">
						<input type="submit" value="Delete" class="small">
					</td>
				</form>
			</tr>		  
	</table>
<?

}else{
	$getuser=mysql_query("SELECT u.firstname,u.surname FROM users u, modules m WHERE m.users=u.id AND m.id=$id;");
	if(mysql_num_rows($getuser)!=0){
		$creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
?>
	<p>&nbsp;</p>
	<div class="h5" align="center">Sorry, you can't edit this discussion. It can only be edited by it's creator (<i><?echo $creator ?></i>)</div>
	<?}
}?>
</body>
</html>
