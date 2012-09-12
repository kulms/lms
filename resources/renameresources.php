<?require("../include/global_login.php");
$getresources=mysql_query("SELECT * FROM modules WHERE id=$modules AND users=".$person["id"].";");
if(mysql_num_rows($getresources)!=0){
        mysql_query("UPDATE modules set name='".str_replace("'","&#039;",$resourcesname)."', info='$info', stdlock='$stdlock' WHERE id=$modules;");
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
<div align="center" class="main">Resources updated...</div>
</body>
</html>