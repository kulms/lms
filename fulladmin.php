<?require("include/global_login.php");
	function setBg($bg){
	//****************************************
	//	Change bgcolor for every row
	//*****************************************
		if($bg=="#D3D3D3"){
			return "#C0C0C0";
		}else{
			return "#D3D3D3";
		}
	}//end function
?>
<html>
<head>
	<title>Full admin</title>
	<link rel="STYLESHEET" type="text/css" href="main.css">
</head>

<body bgcolor="#ffffff">
<?if(($person["id"]==1 || $person["id"]==2 ||$person["id"]==6) && $person["admin"]==1){?>
	<?if($u_id==""){
	$get_users=mysql_query("SELECT * FROM users ORDER BY firstname, surname;");
	$bg="#D3D3D3";
	?>
	<table align="center" cellpadding="6" cellspacing="1" bgcolor="#808080">
		<tr bgcolor="#808080">
			<td class="menu"><b>Name</b></td>
			<td class="menu"><b>email</b></td>
			<td class="menu"><b>Edit</b></td>
		</tr><?while($row=mysql_fetch_array($get_users)){
		$bg=setBg($bg);
		?>
		<tr bgcolor="<?echo $bg?>">
			<td class="menu"><?echo $row["firstname"]?>&nbsp;<?echo $row["surname"]?></td>
			<td class="menu"><?echo $row["email"]?></td>
			<td class="menu"><a href="fulladmin.php?u_id=<?echo $row["id"]?>">Edit</a></td>
		</tr>
			<?}?>	
	</table>
	<?}else{
	$get_values=mysql_query("SELECT * FROM users WHERE id=$u_id;");?>
	<form action="edit_users.php" method="post">
	<table bgcolor="#C0C0C0" align="center" cellpadding="4" cellspacing="1">
		<tr>
			<td colspan="2" class="h5" align="center"><b>Edit user</b></td>
		</tr>
		<?
	while($row=mysql_fetch_array($get_values)){?>
		<tr>
			<td class="menu"><b>Firstname:</b></td>
			<td><input type="text" name="firstname" class="menu" value="<?echo $row["firstname"]?>"></td>
		</tr>
		<tr>
			<td class="menu"><b>Surname:</b></td>
			<td><input type="text" name="surname" class="menu" value="<?echo $row["surname"]?>"></td>
		</tr>
		<tr>
			<td class="menu"><b>email:</b></td>
			<td><input type="text" name="email" class="menu" value="<?echo $row["email"]?>"></td>
		</tr>
		<tr>
			<td class="menu"><b>login:</b></td>
			<td><input type="text" name="login" class="menu" value="<?echo $row["login"]?>"></td>
		</tr>
		<tr>
			<td class="menu"><b>password:</b></td>
			<td><input type="Password" name="password" value="<?echo $row["password"]?>" class="menu"></td>
		</tr>
		<tr>
			<td class="menu"><b>Homepage:</b></td>
			<td><input type="text" name="homepage" class="menu" value="<?echo $row["homepage"]?>"></td>
		</tr>
		<tr>
			<td class="menu"><b>picture:</b></td>
			<td><input type="text" name="picture" class="menu" value="<?echo $row["picture"]?>"></td>
		</tr>
		<tr>
			<td class="menu"><b>Admin:</b></td>
			<td><input type="checkbox" name="admin" value="1"<?if($row["admin"]==1){?> checked<?}?>></td>
		</tr>
		<tr>
			<td class="menu"><b>Address:</b></td>
			<td><textarea name="address" cols="55" rows="8" wrap="PHYSICAL"><?echo $row["address"]?></textarea></td>
		</tr>
		<tr>
			<td class="menu"><b>Info:</b></td>
			<td><textarea name="info" cols="55" rows="8" wrap="PHYSICAL"><?echo $row["info"]?></textarea></td>
		</tr>
		<tr>
			<td class="menu"><b>Active:</b></td>
			<td><input type="checkbox" name="active" value="1"<?if($row["active"]==1){?> checked<?}?>></td>
		</tr>
	<?}?>
	<tr>
		<td align="center" colspan="2"><input type="submit" value="Submit changes"><input type="reset"></td>
	</tr>
	</table>
	<input type="hidden" name="u_id" value="<?echo $u_id?>">
	</form>
	<?}?>
<?}else{?>
	
	<p class="h5" align="center"><b>You don't have access to this script!</b></p>
<?}?>

</body>
</html>
