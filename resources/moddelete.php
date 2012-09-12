<?
	$rs=mysql_query("SELECT * from resources WHERE modules=$modules;");
	while($r=mysql_fetch_array($rs)){
		exec("rm -R -f $realpath/resources/files/".$r["id"]);
	}
	mysql_query("DELETE FROM resources WHERE modules=$modules;");
?>
