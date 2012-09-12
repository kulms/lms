<?require("../include/global_login.php")?>
<html>
<head>
	<title></title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<?
//del = request.querystring("del")
//del_id = request.querystring("del_id")

if($del==1){
	$delIt = mysql_query("DELETE FROM peer_comments WHERE id = $del_id;");
?>
	<div class="h1" align="center">Your comment has been deleted</div>
<?
}else{
?>
	nope...
<?}?>
</body>
</html>
