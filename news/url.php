<?require("../include/global_login.php");
if($news_id==""){$news_id=0;}
if($id==0){
mysql_query("INSERT INTO news (name,text,news_type,news_group,news_in,url,news_id,users,time,forstd,forlect,forstaff,forge,firstpage)
values('$name',0,$news_type,$news_group,'$news_in','$url','$news_id',".$person["id"].",".time().",'$forstd','$forlect','$forstaff','$forge','$firstpage');");
}else{
mysql_query("UPDATE news set url='$url', time=".time()." WHERE id=$id;");
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
<div align="center" class="main">News + URL  Updated...</div>
</body>
</html>