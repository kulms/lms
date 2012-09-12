<?
$server="localhost";
$sql_username="research";
$sql_password="res";
$link = mysql_connect($server,$sql_username,$sql_password);
$select = mysql_select_db("stdproject",$link);
?>