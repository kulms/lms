<?  require("../include/global_login.php");
	require("../include/online.php");
	require("../include/function.inc.php");
	$reason=trim($reason);
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

	$url = 'admin_drop.php';
	print("<script language=\"javascript\">window.location='$url';</script>");
	/// error ให้กลับไปหน้าที่แล้ว 

} /// END  IF  submit
?>
<html>
<head><link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body>
<form name="form1" method="post" action="">
  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td class="info"><br><b>
        เหตุผลที่ขอถอนชื่อออกจากรายวิชา : </b><br> <textarea name="reason" cols="50"  class="small" rows="7" wrap="VIRTUAL"  id="textarea"></textarea> 
        <br> <input type="submit" name="submit" value="S u b m i t"> &nbsp; <input type="reset" name="cancel" value="C a n c e l"> 
      </td>
    </tr>
  </table>
  </form>
</body>
</html>