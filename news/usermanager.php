<?require("../include/global_login.php");
$check=mysql_query("SELECT * FROM users WHERE id=515;");
?>

<html>
<head>
        <title>User manager for News @ Faculty of Engineering, KU</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body>
<table align="center" boder="0">
<?if(mysql_num_rows($check)==1){
$a=mysql_query("SELECT * FROM users WHERE category=1 and login=' ';");
while($b=mysql_fetch_array($a)){  ?>
<tr><form action="usermanager.php" method="POST">
<input type="hidden" name="id" value="<?echo $b["id"] ?>">
<input type="hidden" name="add" value="1">
<td class="info"><? echo $b["firstname"] ?></td>
<td class="info" colspan="3">‚∑√»—æ∑Ï :<? echo $b["telephone"] ?></td>
</tr>
<tr>
<td class="info">Login name:<input type="text" name="login"></td>
<td class="info">Password:<input type="text" name="password"></td>
<td class="info">email:<input type="text" name="email">@nontri.ku.ac.th</td>
<td class="info"><input type="submit" value="submit"></td>
</form>
</tr>
<tr><td colspan="4"><hr width="100%" noshade></td>
</tr>
<?}
}?>
</table>
<? if ($add==1){
$host="@nontri.ku.ac.th";
$mail="$email$host";
mysql_query("UPDATE users set login='$login',password='$password',email='$mail' WHERE id=$id;");

?>
<META HTTP-EQUIV="Refresh" CONTENT="1;URL=usermanager.php">
<?}
?>
</body>
</html>
<?mysql_close();?>
