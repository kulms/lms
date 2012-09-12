<?
session_start();
require("../include/global_login.php");
$ut = round($utime,2);
$sql =  "INSERT INTO resource_center_using (resource_center_id, users, total_time) VALUES ($id, ".$person["id"].", $ut)";

//echo $sql;
mysql_query($sql);
							

?>
<!--
<script language='javascript'> 								
		window.close();					    		
</script>
-->