<?  require("../include/global_login.php");
		require("../include/online.php");
		require("../include/function.inc.php");
?>
<html>
<head><title>Insert into course</title>
<script language="javascript">
	function update()
	{
			top.ws_menu.location.reload();
	}
</script>		
<link rel="STYLESHEET" type="text/css" href="../main.css"></head>
<?
		//***********insert modules_history***************
		$action="Apply courses";
		Imodules_h2(0,$action,$person["id"],0,0,$courses,$courses);
$getcourse=mysql_query("SELECT name,applyopen FROM courses WHERE id=$courses;");
$applycheck=mysql_query("SELECT DISTINCT id FROM wp WHERE courses=$courses AND users=".$person["id"]." ;");		// AND cases=0 AND groups=0 AND modules=0
if(mysql_num_rows($getcourse)!=0)
{	$coursename=@mysql_result($getcourse,0,"name");

	if( (@mysql_result($getcourse,0,"applyopen")==1) &&  (mysql_num_rows($applycheck)== 0)  )
	 {   
		mysql_query("INSERT INTO wp(courses,users) VALUES($courses,".$person["id"].");");
		mysql_query("INSERT INTO apply_courses(users,courses,time,status) VALUES(".$person["id"].",$courses,".time().",0)");

?>
		<body bgcolor="#ffffff" onLoad="update();">
		<p>&nbsp;</p>
		<div align="center" class="h3">OK, you have been accepted to <? echo $coursename; ?>.</div>
<?  }else{	// make sure that this user never apply for this course be4
                 // old one if(@mysql_result($getcourse,0,"applyopen")==1)
				 if(@mysql_result($getcourse,0,"applyopen")==0)
			 	 {
					$applyCourse = mysql_query("SELECT * FROM apply_courses WHERE users = ".$person["id"]." and courses = $courses");
					if($rowapplyC = mysql_fetch_array($applyCourse))
						// if applied be4, update the time to now
						mysql_query("UPDATE apply_courses SET time = time() WHERE id =".$rowapplyC["id"]);
					else
						// if not applied be4, insert into apply_courses table
						mysql_query("INSERT INTO apply_courses(users,courses,time,status) VALUES(".$person["id"].",$courses,".time().",1);"); // insert 
                 }

			$getadmin=mysql_query("SELECT u.email,u.id AS users FROM users u, wp 
									WHERE wp.courses=$courses AND u.id=wp.users AND wp.admin=1;");
// debug here mysql_query("INSERT INTO wait_for_grant(users,courses) VALUES (".$person["id"].",$courses);");
			 
			if(mysql_num_rows($getadmin)==0)
			{
				$getadmin=mysql_query("SELECT u.email,u.id AS users FROM users u, courses c 
										WHERE c.id=$courses AND u.id=c.users;");
			}
			while($adminrow=mysql_fetch_array($getadmin))
			{   
				$cadmin=$adminrow["users"];
					// Message to be sent to course administrator
				$username=$person["firstname"]." ".$person["surname"];
				if($username=="")
				{
					$username=$person["login"];
				}
				$mailbody="A user has applied to join your course ($coursename)\n\nUsername: ".$username."\n";
				$mailbody.="eMail: mailto:".$person["email"]."\n\n";
				$mailbody.="Just click on the appropriate link below to respond to this request.\n\n";
				$mailbody.="To Grant Permission: \nhttp://".$SERVER_NAME."/$path/courses/mailresponse.php?courses=".$courses."&users=".$person["id"]."&rnd=1&cadmin=$cadmin\n\n";
				$mailbody.="To Refuse Permission: \nhttp://".$SERVER_NAME."/$path/courses/mailresponse.php?courses=".$courses."&users=".$person["id"]."&rnd=0&cadmin=$cadmin\n\n";
		//		mail($adminrow["email"],"Request to join $coursename",$mailbody,"From:courseadmin@$SERVER_NAME");
			}//end while
				$head_admin=mysql_query("SELECT u.email from users u,courses c WHERE c.id=$courses AND u.id=c.users;");
				$adminmail=@mysql_result($head_admin,0,"email");
?>
				<body bgcolor="#ffffff"><p>&nbsp;</p>
				<table>
					<tr>
						<td width="15%">&nbsp;</td>
						<!--<td class="h5">The course administrator has been informed about your interest in <br>
										participating in the course <b><? echo $coursename; ?></b>.
						<p>You will receive an email as soon as your application has been processed.</td> -->
						<td class="h5"><? print("<script language=\"javascript\">alert('The course administrator has been informed about your interest in participating in the course $coursename. You will receive an email as soon as your application has been processed.');</script>");
 ?></td>
					</tr>
				</table>
<?		}//end else
}//end if
$url = 'apply.php';
  print("<script language=\"javascript\">top.ws_menu.location.reload(); </script>");						 
print("<script language=\"javascript\">window.location='$url';</script>");
?>
</body>
</html>