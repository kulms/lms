<?php  	 //require("../include/global_login.php");
		//session_start();
		  $table_dept = "ku_department";
		  $field_thai = "NAME_THAI";
		  $field_eng = "NAME_ENG";
		  $field_dept_fac_id = "FAC_ID";
		  $field_url	= "URL";
		  $field_edit_by= "edit_by";
		  $field_post_datetime= "post_datetime";		  
		  $field_dep_id = "id";
	
		  $table_fac = "ku_faculty";
		  $field_fac_thai = "FAC_NAME";
		  $field_fac_eng = "NAME_ENG";	
		  $field_fac_id = "id";
		  
		 $dept_thai=trim($dept_thai);
		 $dept_eng=trim($dept_eng);
		 $url=trim($url);

		if($old_thai!=$dept_thai || $old_eng!=$dept_eng || $old_url!=$url)
		{
		  $result1=mysql_query("SELECT * FROM $table_dept  WHERE $field_thai='$dept_thai' AND $field_eng='$dept_eng' and $field_fac_id = $fac_id ;");
		if(mysql_num_rows($result1)==0)
		{
		   mysql_query("UPDATE $table_dept SET $field_thai=\"$dept_thai\", $field_eng=\"$dept_eng\",$field_url=\"$url\",$field_edit_by='".$person["id"]."',$field_post_datetime=now() WHERE $field_dep_id=$id;");
		   
		}else{
				print("<script language='javascript'> document.write('There is same department name in this Faculty! ');  history.go(-2);</script>");
			  }
	   }
		print("<script language='javascript'>document.location='./index.php?m=mdata&a=insert_dept&id=$fac_id';</script>"); 	
?>		