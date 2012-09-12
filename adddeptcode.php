<?
require("include/global_login.php");
$sedept=mysql_query("SELECT * FROM department;");
while($show=mysql_fetch_array($sedept)){
echo $show["id"].$show["fullname"]."<br>";
}
$select=mysql_query("SELECT * FROM users;");
while($row=mysql_fetch_array($select)){
if($row["dept"]=="Industrail"){

echo "Yes";}
}
?>