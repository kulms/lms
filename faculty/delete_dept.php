<?php   require("../include/global_login.php");
	 	session_start();
	 //print("<script language='javascript'> alert('Do you really want to delete Department and its details !',yes,no,cancel); <!/script>");	 

	  $table_dept = "ku_department";
	  $field_dep_id = "id";

	  $table_major = "ku_major";
      $field_major_dept_id = "DEPT_ID ";	 	
		
	  mysql_query("DELETE FROM $table_dept where $field_dep_id = $id");
	  mysql_query("DELETE FROM $table_major where $field_major_dept_id = $id");
	
	print("<script language='javascript'> document.write('Completely Delete! ');document.location='insert_dept.php?id=$fac_id';</script>"); 
?>