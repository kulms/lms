<?
$db="course";
$path="course";
$realpath="/home/jtn/course";
$conn=mysql_pconnect('localhost','root','jtn');
mysql_select_db($db);
$check=mysql_query("SELECT * FROM users WHERE login='".$slogin."' AND STRCMP(password,'".$spassword."')=0 AND active=1;");
if(mysql_num_rows($check)==0){

header ("Location: ../login/login.html?fail=1");
        exit;
}else{
$person=mysql_fetch_array($check);
mysql_query("UPDATE users set lastlogin=".time()." WHERE id=".$person["id"].";");
session_start();
session_register("slogin");
session_register("spassword");
Header("Location: ../index.html");
}
?>