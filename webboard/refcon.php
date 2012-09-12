<?
include("conn.php");
if ( $reply=="yes") {
mysql_query("update apply set replied=1 where id=$id;");
} 
if ( $reply=="no") {
mysql_query("update apply set replied=0 where id=$id;");
}
if ( $confirm=="yes") {
mysql_query("update apply set confirm=1 where id=$id;");
}
if ( $confirm=="no") {
mysql_query("update apply set confirm=0 where id=$id;");
} 
       header("Status: 302 Moved Temporarily");
       header("Location:http://cool.eng.ku.ac.th/webboard/webboard.php?showresult=yes"); 
?>

