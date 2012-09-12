<?require("../include/global_login.php");
$select=mysql_query("select * from news_type where active=1 order by seq;");
while($row=mysql_fetch_array($select)){
$select_group=mysql_query("select * from news_group where news_type='".$row["id"]."' and
active=1;");
echo "<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">";
echo "<table class=res>";
echo "<tr><td>";
echo $row["name"]."<br>";
       while($row1=mysql_fetch_array($select_group)){
       echo "<li><a href=\"add_form.php?id=0&news_type=";
       echo $row["id"];
       echo "&news_group=";
       echo $row1["id"];
       echo "&news_type_name=";
       echo $row["name"];
       echo "&news_group_name=";
       echo $row1["groupname"];
       echo "\">";
       echo $row1["groupname"];
       echo "</a></li><br>";
       }
       echo "</td></tr></table>";
       }

     ?>
