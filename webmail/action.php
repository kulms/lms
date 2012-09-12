<?require("../include/global_login.php");
if($task=="del"){
	while(list($key,$val)=each($msg)){
		$att=mysql_query("SELECT id from emailattach WHERE emailmsg=$val;");
		while($row=mysql_fetch_array($att)){
			mysql_query("DELETE from emailattach where id=".$row["id"].";");
		}
		mysql_query("DELETE FROM emailmsg WHERE id=$val;");
	}
}
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=".$modules);			


?>

