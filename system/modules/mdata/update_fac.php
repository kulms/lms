<?   
	 //require("../include/global_login.php");
	 //session_start();
	 $fac_thai=trim($fac_thai);
	 $fac_eng=trim($fac_eng);
	 $url=trim($url);

	if($old_thai!=$fac_thai || $old_eng!=$fac_eng || $old_campus!=$campus_id  || $old_url!=$url)
	{		
	  $result1=mysql_query("SELECT * FROM ku_faculty kf WHERE kf.FAC_NAME='$fac_thai' AND kf.NAME_ENG='$fac_eng' and kf.CAMPUS_ID='$campus_id' and URL='$url';");
	
	if(mysql_num_rows($result1)==0)
	{
	   mysql_query("UPDATE ku_faculty SET FAC_NAME=\"$fac_thai\", NAME_ENG=\"$fac_eng\", CAMPUS_ID='$campus_id', URL=\"".trim($url)."\", edit_by='".$person["id"]."',post_datetime=now()  WHERE id=$id;");
	  // print("UPDATE ku_faculty SET FAC_NAME=\"$fac_thai\", NAME_ENG=\"$fac_eng\", CAMPUS_ID='$campus_id', URL=\"".trim($url)."\"  WHERE id=$id;");
	 
	}else{	print("<script language='javascript'> document.write('There is same Faculty name in database ! Try again');  history.go(-2);</script>");
		 }
   }
	print("<script language='javascript'>document.location='./index.php?m=mdata&a=insert_fac';</script>"); 
?>		