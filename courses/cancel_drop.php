<?  require("../include/global_login.php");
	require("../include/online.php");
	require("../include/function.inc.php");
/*
if($submit && $reason!="" && $reason!=null){
		//***********insert modules_history***************
		$action="Drop courses";
		Imodules_h2(0,$action,$person["id"],0,0,$courses,$courses);	
	$getcourse=mysql_query("SELECT name,applyopen FROM courses WHERE id=$courses;");
	if($row = mysql_fetch_array($getcourse))
	{
		$course_type=$row["applyopen"];		 /// 1=open, 0=approve, -1=close
		switch($course_type){
			case 1:
				//echo "open";
			   mysql_query("INSERT INTO drop_courses(courses,users,time,status, reason) VALUES($courses,".$person["id"].", ".time().", 0,'".$reason."' );");
			   mysql_query("DELETE * FROM wp  WHERE courses=$courses AND users=".$person["id"].";");
			    print("<script language=\"javascript\">alert('ถอนรายชื่อออกจากรายวิชาแล้ว');</script>");
				break;
			case 0: 
				//echo "approve";
				mysql_query("INSERT INTO drop_courses(courses,users,time, status, reason) VALUES($courses,".$person["id"].", ".time().", 1,'".$reason."');");
				print("<script language=\"javascript\">alert('กรุณารอผลการถอนจากผู้สอน ');</script>");
				break;
			case -1:
				//echo "close";
				mysql_query("INSERT INTO drop_courses(courses,users,time, status, reason) VALUES($courses,".$person["id"].", ".time().", 1,'".$reason."');");
				print("<script language=\"javascript\">alert('กรุณารอผลการถอนจากผู้สอน ');</script>");
			break;
		} /// END switch
	} /// end fetch_array

	

} /// END  IF  submit
*/
	//echo $user_id;
	$sql = "DELETE FROM drop_courses  WHERE courses=$courses AND users=".$user_id.";";
	mysql_query($sql);
	//echo $sql;
	$sql_ins = "INSERT INTO wp (courses, users) VALUE (".$courses.",".$user_id.");";
	mysql_query($sql_ins);
	print("<script language=\"javascript\">alert('ยกเลิกการถอนรายชื่อออกจากระบบแล้ว');</script>");
	$url = 'users.php?courses='.$courses;
	//echo $url."<br>";	
	
	print("<script language=\"javascript\">window.location='$url';</script>");
	
	
	/// error ให้กลับไปหน้าที่แล้ว 
?>
