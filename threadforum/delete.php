<?
	mysql_query("DELETE FROM threadforum WHERE modules=$modules;");
	mysql_query("DELETE FROM threadprefs WHERE modules=$modules;");
?>
