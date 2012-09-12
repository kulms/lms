<?   
	 //require("../include/global_login.php");
	 //session_start();
	 $name_thai=trim($cam_thai);
	 $name_eng=trim($cam_eng);
	 $url=trim($url);

	
	 mysql_query("UPDATE ku_campus SET NAME_THAI=\"$name_thai\", NAME_ENG=\"$name_eng\", URL=\"".trim($url)."\", edit_by='".$person["id"]."',post_datetime=now()  WHERE id=$id;");
 
	 print("<script language='javascript'>document.location='./index.php?m=mdata&a=insert_cam';</script>"); 
?>		