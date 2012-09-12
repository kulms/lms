<?php   
	    //session_start();

	$table_major = "ku_major";
    $field_major_id = "id ";	
	 
	mysql_query("DELETE FROM $table_major where $field_major_id = $id");
	
	print("<script language='javascript'> document.write('Completely Delete!');document.location='./index.php?m=mdata&a=insert_major&id=$dept_id';</script>"); 
?>