<? require("../include/global_login.php"); ?>
<html>
<form action="manual.php" method="post">
<input type="hidden" name="ok" value="1">
<input type="text" name="id">
<input type="submit" value="submit">
</form>
</html>
<? if ($ok==1){
$result=mysql_query("SELECT * FROM news_page WHERE from_news=$id;");
echo mysql_num_rows($result);
while($row=mysql_fetch_array($result)){
                mysql_query("DELETE FROM news_page WHERE id=".$row["id"].";");
        $file=$row["file"];
   exec("rm -f $realpath/news/imgfiles/$file");
   echo "$file deleted";
                }
              }


?>