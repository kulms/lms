<?php require("../include/global_login.php");
?>
<? function ShowType(){?>
<html>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<table border=1 class="info" cellspacing="0" cellpadding="0" width="90%">
<tr>
<td>No</td>
<td align="center">หมวดของข่าว</td>
<td align="center">เพิ่มหมู่ของข่าวในหมวดนี้</td>
<td align="center">ลบออก</td>
</tr>
<?
$n=1;
$newstype=mysql_query("SELECT * FROM news_type where active=1;");
while($row=mysql_fetch_array($newstype)){
?>
<tr>
<td><?php echo $n++; ?></td>
<td>
<?php echo $row["name"]; ?>
</td>
<td> <a href="newsadmin.php?showgroup=yes&news_type_id=<?echo $row["id"] ?>">Add News Category</a> </td>
<td> <a href="newsadmin.php?del_news_type=yes&news_type=<?echo $row["id"] ?>">ลบหมวดข่าวนี้</a> </td>
</tr>
<?}?>
</table>
<form method="post" action="newsadmin.php">
<input type="text" name="news_type"><br>
<input type="submit" name="add_news_type" value="add">
</form>
</html>
<?} if ($add_news_type=="add"){
mysql_query("insert into news_type (name,active,tablename) values ('$news_type',1,'news');");
echo "<meta http-equiv=\"refresh\" content=\"0;url=newsadmin.php?showtype=yes\">";
}
if ($del_news_type=="yes"){
mysql_query("delete from news_type where id=$news_type;");
mysql_query("delete from news_group where news_type=$news_type;");
echo "<meta http-equiv=\"refresh\" content=\"0;url=newsadmin.php?showtype=yes\">";
}
if ($del_news_group=="yes"){
mysql_query("delete from news_group where id=$news_group;");
echo "<meta http-equiv=\"refresh\" content=\"0;url=newsadmin.php?showgroup=yes&news_type_id=$news_type_id\">";
}
if ($add_news_group=="add_group"){
mysql_query("insert into news_group (groupname,news_type,active) values
('$news_group','$news_type','1');");
echo "<meta http-equiv=\"refresh\" content=\"0;url=newsadmin.php?showgroup=yes&news_type_id=$news_type\">";
}


function AddNewsGroup($news_type_id,$groupname){
         mysql_query("insert into news_group (groupname,news_type,active) values ('$groupname','$news_type_id',1);");
         echo "<meta http-equiv=\"refresh\" content=\"0;newsadmin.php\">";
         }
function ShowGroup($news_type_id){
         $n=1;
         $type=mysql_query("select * from news_type where id='$news_type_id';");
         $group=mysql_query("select * from news_group where news_type='$news_type_id' order by id;");
         echo "<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../main.css\">";
         echo "<table border=1 class=info cellspacing=0 cellpadding=0 width=90%>";
         echo "<tr><td colspan=3 align=center>".mysql_result($type,0,"name")."</td></tr>";
         echo "<tr><td>No</td>";
         echo "<td align=center>เพิ่มหมู่ของข่าว</td>";
         echo "<td align=center> ลบหมู่ของข่าว</td></tr>";
               while($row=mysql_fetch_array($group)){
               echo "<tr><td>".$n++."</td>";
               echo "<td>".$row["groupname"]."</td>";
               echo "<td><a href=\"newsadmin.php?del_news_group=yes&news_group=$row[id]&news_type_id=$news_type_id\">ลบหมู่ของข่าว</a></td>";
               echo "</tr>";
               }

               echo "</table><br>";
               echo "<form method=\"post\" action=\"newsadmin.php\">";
               echo "<input type=\"text\" name=\"news_group\"><br>";
               echo "<input type=\"hidden\" name=\"news_type\" value=$news_type_id>";
               echo "<input type=\"submit\" name=\"add_news_group\" value=\"add_group\">";
               echo "</form>";
               }
if ($showgroup=="yes"){
ShowGroup($news_type_id);
}
if ($showtype=="yes"){
ShowType();
}
