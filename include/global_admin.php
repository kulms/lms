<?
$db="course";
$path="course";
$realpath="/home/jtn/course";
$conn=mysql_pconnect('localhost','root','jtn');			
mysql_select_db($db);
$check=mysql_query("SELECT * FROM users WHERE login='".$PHP_AUTH_USER."' AND STRCMP(password,'".$PHP_AUTH_PW."')=0 AND active=1 AND admin=1;");
if(mysql_num_rows($check)==0){
	Header("WWW-Authenticate: Basic realm=\"Course\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "Invalid user or password...\n";
	exit;
}else{
	$person=mysql_fetch_array($check);
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
}
?>
