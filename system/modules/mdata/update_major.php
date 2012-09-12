<?php     
		  //session_start();	
		  $table_major = "ku_major";
		  $field_thai = "NAME_THAI";
		  $field_eng = "NAME_ENG";
		  $field_maj_dep_id = "DEPT_ID";
	      $field_url	= "URL";
		  $field_maj_id = "id";

		  $table_dept = "ku_department";
		  $field_dept_thai = "NAME_THAI";
		  $field_dept_eng = "NAME_ENG";
		  $field_dept_fac_id = "FAC_ID";
		  $field_dep_id = "id";

		  $table_fac = "ku_faculty";
		  $field_fac_thai = "FAC_NAME";
		  $field_fac_eng = "NAME_ENG";	
		  $field_fac_id = "id";		  
				  
		 $major_thai=trim($major_thai);
		 $major_eng=trim($major_eng);
		 $url=trim($url);
	if($old_thai!=$major_thai || $old_eng!=$major_eng  || $old_url!=$url)
	{
	
	  $result1=mysql_query("SELECT * FROM $table_major  WHERE $field_thai='$major_thai' AND $field_eng='$major_eng' and $field_maj_dep_id=$dept_id ;");
	 if(mysql_num_rows($result1)<=1)
		{			
		   mysql_query("UPDATE $table_major SET $field_thai=\"$major_thai\", $field_eng=\"$major_eng\",$field_url=\"$url\",edit_by='".$person["id"]."',post_datetime=now()  WHERE $field_maj_id=$id;");

		}else{
				print("<script language='javascript'> document.write('There is same Major name in this DepartMent! Try again '); history.go(-2);</script>");
			  }
	} 
	 print("<script language='javascript'>document.location='./index.php?m=mdata&a=insert_major&id=$dept_id';</script>"); 	
?>		