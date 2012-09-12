<?
$db="course";
$path="course";
$conn=mysql_pconnect('localhost','root','jtn');			
mysql_select_db($db);
$check=mysql_query("SELECT * FROM users WHERE login='admin' AND
STRCMP(password,'".$PHP_AUTH_PW."')=0 AND active=1;");
if(mysql_num_rows($check)==0){
	Header("WWW-Authenticate: Basic realm=\"database\"");
	Header("HTTP/1.0 401 Unauthorized");
echo "Invalid User Name or Password";
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
