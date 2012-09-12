<?php   
	 	//session_start();


	  $table_dept = "ku_department";
	  $field_dep_id = "id";

	  $table_major = "ku_major";
      $field_major_dept_id = "DEPT_ID ";	 	
		
	  mysql_query("DELETE FROM $table_dept where $field_dep_id = $id");
	  mysql_query("DELETE FROM $table_major where $field_major_dept_id = $id");
	
	print("<script language='javascript'> document.write('Completely Delete! ');document.location='./index.php?m=mdata&a=insert_dept&id=$fac_id';</script>"); 
?>