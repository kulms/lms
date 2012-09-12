<?require("../include/global_login.php");
mysql_query("DELETE FROM news_res WHERE id=$reply_id and users=".$person["id"].";");

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

