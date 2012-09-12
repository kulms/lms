<?require("../include/global_login.php");
$check=mysql_query("SELECT * from email WHERE id=$acc;");
if($person["admin"]==1 || $person["id"]=mysql_result($check,0,"userid")){
	mysql_query("DELETE FROM email WHERE id=$acc;");
}

header("Status: 302 Moved Temporarily");
header("Location: index.php?id=".$id);			

?>

