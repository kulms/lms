<?
$db="course";
$path="course";
$realpath="/home/jtn/course";
$conn=mysql_pconnect('localhost','root','jtn');					//öppna databasen
mysql_select_db($db);
?>
<html>
<?
$check=mysql_query("SELECT * FROM users WHERE login='".$userid."' AND
STRCMP(password,'".$password."')=0 AND active=1;");
if(mysql_num_rows($check)==0){
	echo "<font size=+2 color=\"#cc0099\">Invalid Username: $userid...</font>\n";
	exit;
}else{
	$person=mysql_fetch_array($check);
	mysql_query("UPDATE users set lastlogin=".time()." WHERE id=".$person["id"].";");
	header("Expires: Mon, 28 Jul 2000 05:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
}
?>
<body>
<form method=POST action="testlogin.php">
<input type=text name="userid" length=20><br>
<input type=text name="password" length=20><br>
<input type=submit value=submit>
</form>
</body>
</html>
