<?
	$msg=mysql_query("SELECT id FROM emailmsg WHERE modules=$modules;");
	while($rmsg=mysql_fetch_array($msg)){
		mysql_query("DELETE from emailattach WHERE emailmsg=".$rmsg["id"].";");
	}
	mysql_query("DELETE from emailmsg WHERE modules=$modules;");
	mysql_query("DELETE from email WHERE modules=$modules;");
?>
