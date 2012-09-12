<?  require("../include/global_login.php");

	$getcourse=mysql_query("SELECT name,applyopen FROM courses WHERE id=$courses;");

	if($row = mysql_fetch_array($getcourse))
	{
		switch($rnd){		
			case 1:
				/// ### GRANT DROP ###
				mysql_query("UPDATE drop_courses SET status=0, time=".time()." WHERE users=$users AND courses=$courses;");
				// print("UPDATE drop_courses SET status=0, time=".time()." WHERE users=$users AND courses=$courses; ");
				mysql_query("DELETE FROM wp  WHERE courses=$courses AND users=$users;");
				//print("DELETE FROM wp  WHERE courses=$courses AND users=$users;");
				//print("<script language=\"javascript\">window.location='teachertinfoNEW.php';</script>");
				break;

			case 0:
				///  ### REFUSE DROP  ###
				mysql_query("DELETE FROM drop_courses  WHERE courses=$courses AND users=$users;");
				//print("DELETE FROM drop_courses  WHERE courses=$courses AND users=$users;");
				//print("<script language=\"javascript\">window.location='teachertinfoNEW.php';</script>");
				break;
		}
/*
		$course_type=$row["applyopen"];		

		if ($course_type == 1 )  /// OPEN
		{
			mysql_query("INSERT INTO drop_courses(courses,users,time, status) VALUES($courses,".$person["id"].", ".time().", 0 );");			
				// mysql_query("DELETE * FROM wp  WHERE courses=$courses AND users=".$person["id"].";");
				echo  "DELETE * FROM wp  WHERE courses=$courses AND users=".$person["id"].";";			
				print("<script language=\"javascript\">alert('drop ok');</script>");			
		}
		else 	if ($course_type == 0 )  /// Approve
		{
			mysql_query("INSERT INTO drop_courses(courses,users,time, status) VALUES($courses,".$person["id"].", ".time().", 1 );");
			print("<script language=\"javascript\">alert('Please waiting for teacher ');</script>");			
		}
		else  if ($course_type ==  -1 )  /// Close
		{
			mysql_query("INSERT INTO drop_courses(courses,users,time, status) VALUES($courses,".$person["id"].", ".time().", 1 );");
			print("<script language=\"javascript\">alert('Please waiting for teacher  ok');</script>");			
		}
*/		
	}
	$url = 'info.php';
	print("<script language=\"javascript\">window.location='$url';</script>");
	/// error ให้กลับไปหน้าที่แล้ว 
?>