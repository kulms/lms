<?require("../include/global_login.php");
    $getresources=mysql_query("SELECT * FROM news WHERE id=$id AND users=".$person["id"].";");
    $file=mysql_result($getresources,0,"file");
    $checkfile=mysql_num_rows($getresources);
        if(mysql_num_rows($getresources)!=0 || $person["id"] == 564){
                mysql_query("DELETE FROM news WHERE id=$id;");
                mysql_query("DELETE FROM news_res WHERE news=$id;");
                if ($checkfile!=""){
                exec("rm -rf $realpath/files/news/$id");
                }
/*$result=mysql_query("SELECT * FROM news_page WHERE from_news=$id;");
while($row=mysql_fetch_array($result)){
                mysql_query("DELETE FROM news_page WHERE id=".$row["id"].";");
        $morefile=$row["file"];
   if (exec("rm -f $realpath/news/imgfiles/$morefile")){
   echo "$morefile ....deleted<br>";
                                      }
                }
                */
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
<div align="center" class="main">News deleted...</div>
</body>
</html>