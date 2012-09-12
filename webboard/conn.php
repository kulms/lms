<?
$host = 'localhost';
$dbname = 'thaicool';
$uid = 'thaicool';
$pwd = 'sunote';

mysql_connect($host, $uid, $pwd) or die ("Can not connect to host");
@mysql_select_db($dbname) or die("Unable to connect to  thaicool");
?>