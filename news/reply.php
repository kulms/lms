<?require("../include/global_login.php");
$sql=mysql_query("SELECT * FROM news WHERE id=$id;");
$to_users=mysql_result($sql,0,"users");
$sql=mysql_query("SELECT * FROM news_res WHERE news=$id and users=".$person["id"].";");
if (mysql_num_rows($sql)==0) {
mysql_query("INSERT INTO news_res (news,text,users,to_users,date) values ($id,'$text',".$person["id"].",$to_users,".time().");");
}
else {
mysql_query("UPDATE news_res SET text='$text',date=".time()." WHERE news=$id and users=".$person["id"].";");
}

?>

<html>
<head>
        <title>update</title>
<script language="javascript">
        function update(){
                top.ws_menu.location.reload();
        }
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body onLoad="update()" bgcolor="#ffffff">
<div align="center" class="main">Reply Updated...</div>
</body>
</html>