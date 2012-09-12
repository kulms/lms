<?php   require("../include/global_login.php");
	    session_start();

	$table_major = "ku_major";
    $field_major_id = "id ";	
	 
	mysql_query("DELETE FROM $table_major where $field_major_id = $id");
	
	print("<script language='javascript'> document.write('Completely Delete!');document.location='insert_major.php?id=$dept_id';</script>"); 
?>