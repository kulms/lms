<?  		 		
	//require("../include/global_login.php"); 
	session_start();
	$session_id = session_id();		

	require("../include/global_login.php");  
	include("../include/page_update.js");

	require("../include/online.php");
	online_courses($session_id,$person["id"],$courses,time(),1); 
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );

		
	$user = UserStorage::lookupById($person["login"]);
	
	session_register( 'user' ); 
	
	//online_courses($session_id,$person["id"],$courses,time(),1);
	
	switch ($user->getCategory()) {
		case 0:
			$uistyle = "admin";
			break;
		case 1:
			$uistyle = "admin";
			break;
		case 2:
			$uistyle = "teacher";
			break;
		case 3:
			$uistyle = "student";
			break;
		default:
			$uistyle = "guest";
		}
			 
?>
<html>
<head>
<title>Apply to course</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="STYLESHEET" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />!-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<script language="JavaScript">
function mouseOverRow(gId, onOver){	
	if(document.getElementById){
		if(onOver==1)
			eval("document.getElementById('trE" + gId + "')").bgColor="#FFF5E8";
			//eval("document.getElementById('trE" + gId + "')").bgColor="#B3F2EF";
			//eval("document.getElementById('trE" + gId + "')").bgColor="#FFCCFF";					
		else
			eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";		
	}//end if
}//end function
</script>
<body bgcolor="#ffffff">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" height="53" class="bg1">
  <tr>
    <td class="menu" align="center"><b><? echo $strCourses_LabCourseApplyList;?></b></td>
  </tr>
</table>
<br>
 
<table width="90%" border="0"  align="center" cellpadding="2" cellspacing="0"  class="tdborder">
  <tr> 
    <td colspan="6"> <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tdborder">
        <tr bgcolor="#FFFFFF"> 
          <td width="6%"><img src="../images/_course_pref.gif" width="48" height="47"></td>
          <td width="94%" class="news"><b><? echo $strCourses_MenuActiveCourses;?></b></td>
        </tr>
      </table></td>
  </tr>
  <tr  class="boxcolor"> 
    <th width="11%" class="Bcolor"><? echo $strCourses_LabCourseId;?></th>
    <th class="Bcolor"><? echo $strCourses_LabCourseSection;?></th>
    <th width="31%" class="Bcolor"><? echo $strCourses_LabCourseName;?></th>
    <th width="17%" class="Bcolor"><? echo $strCourses_LabInsName;?></th>
    <th class="Bcolor"><? echo $strCourses_LabStatus;?></th>
    <th class="Bcolor"><? echo $strCourses_LabProcess;?></th>
  </tr>
  <?
	$courseid=trim($courseid);
	$fac=trim($fac);	// $dept=trim($dept); 	$major=trim($major);
	$name=trim($name);
	$firstname=trim($firstname);
	$surname=trim($surname);
	$course_name=trim($course_name);

if($Submit_all){
			$getcourse=mysql_query("SELECT * FROM courses WHERE active=1 AND advisor=0 ORDER BY name;");
			
}else	 if( $courseid!="" && $courseid!=null ){
			$getcourse=mysql_query("SELECT * FROM courses WHERE name LIKE  '%".$courseid."%'  AND  active=1 AND advisor=0 ORDER BY name;");

	}else if( $course_name!="" && $course_name!=null ){
					$getcourse=mysql_query("SELECT * FROM courses WHERE fullname LIKE '%".$course_name."%'  or  fullname_eng LIKE '%".$course_name."%'  AND  active=1 AND advisor=0 ORDER BY name;");
				//	echo "name= ".$course_name;
					
	    }else if($fac!="" && $fac!=null){
							  //$criteria=$fac; 
							//$getcourse=mysql_query("SELECT c.*  FROM courses  as c, users as u, syllabus_userdef  as s, ku_faculty as ku_f  WHERE ( (u.fac_id=".$fac."  and c.users=u.id ) or (    s.courses=c.id  and  ku_f.FAC_NAME LIKE s.topic_name   ) ) ORDER BY c.name;");
							$getcourse=mysql_query("SELECT c.*  FROM courses  as c, users as u WHERE u.fac_id=".$fac."  and c.users=u.id   AND  c.active=1 AND c.advisor=0 ORDER BY c.name;");

		 			}else if($dept!="" && $dept!=null){
								    	//echo $dept;	$criteria=$dept;
									    $getcourse=mysql_query("SELECT c.*  FROM courses  as c, users as u WHERE u.dept_id=".$dept."  and c.users=u.id  AND  c.active=1 AND c.advisor=0  ORDER BY c.name;");

								}else if( $major!="" && $major!=null ){
													//echo $major;	$criteria=$major;
													$getcourse=mysql_query("SELECT c.*  FROM courses  as c, users as u WHERE u.major_id=".$major."  and c.users=u.id  AND  c.active=1 AND c.advisor=0 ORDER BY c.name;");
										    }else if( $name!="" && $name!=null ){
														$a=array();
														$a=@explode(" ",$name);
														$a[0]=trim($a[0]);
														$a[1]=trim($a[1]);
														//$a[0] ->$firstname; 	//$a[1] ->$surname;
														//print("firstname= ".$firstname." lastname=", $surname);
														echo "firstname=".$a[0];
														echo "lastname=".$a[1];
														$getcourse=mysql_query("SELECT c.* FROM courses as c, users as u WHERE  u.firstname LIKE '%".$a[0]."%' and u.surname LIKE '%".$a[1]."%' and c.users=u.id  AND  c.active=1 AND c.advisor=0 ORDER BY c.name;");														

											}else if($firstname!="" && $firstname!=null){
															$getcourse=mysql_query("SELECT c.* FROM courses as c, users as u WHERE  u.firstname LIKE '%".$firstname."%' and c.users=u.id    AND  c.active=1 AND c.advisor=0 ORDER BY c.name;");
															
														}else if( $surname!="" && $surname!=null ){
																		$getcourse=mysql_query("SELECT c.* FROM courses as c, users as u WHERE  u.surname LIKE '%".$surname."%' and c.users=u.id   AND  c.active=1 AND c.advisor=0 ORDER BY c.name;");

																		}else{
																							echo "<br><b>".$strCourses_LabNotFound."</b><br>";
																					}
$number=0;																				
 while($row=@mysql_fetch_array($getcourse))
  {
  		$number++;
        $open=$row["applyopen"];

        switch($open)
		{
			case 1:
					$td=$strCourses_LabOpen;
					break;
			case 0:
					$td="<font color=\"#0000cc\">".$strCourses_LabApprove."</font>";
					break;
			case -1:
					$td="<font color=\"#660000\">".$strCourses_LabClose."</font>";
					break;
			default:
					$td=$strCourses_LabOpen;
					break;
        }    //end switch
?>
  <tr bgcolor="#FFFFFF" id="trE<? echo $number;?>" onMouseOver="mouseOverRow('<? echo $number;?>', 1);" onMouseOut="mouseOverRow('<? echo $number;?>', 0);"> 
    <td  align="center"><? echo $row["name"]; ?>&nbsp;</td>
    <td width="12%"  align="center">
      <?
 if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?>
      &nbsp;</td>
    <td  align="center"> <? echo $row["fullname"]."<br>".$row["fullname_eng"]; ?>&nbsp;</td>
    <? $result=mysql_query("SELECT firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
    <td  align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>">
      <?
      echo @mysql_result($result,0,"firstname"); 
	  if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){
      	echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   }else{   	echo @mysql_result($result,0,"surname"); }  ?>
      </a>&nbsp;</td>
    <td width="19%"  align="center"><? echo $td; ?>&nbsp;</td>
    <td width="10%"  align="center">
      <?
	   if ($open == '-1')
		 {  
			?>
      <font color="red"><? echo $strCourses_LabClose;?></font>
      <?
		 } 
	    $membered=mysql_query("SELECT courses,users FROM wp WHERE courses=".$row["id"]." AND users=".$person["id"].";");
		if (mysql_num_rows($membered)>=1 && $open!='-1') 
		{ 
		   ?>
      <font color="cccccc"><? echo $strCourses_LabApplied;?></font>
      <?
		}
		if(mysql_num_rows($membered)==0 && $open!='-1') 
		 {  
			?>
      <a href="application.php?courses=<? echo $row["id"]; ?>"><img src="../images/correct_sign.gif" border="0"><? echo $strCourses_LabApply;?></a>
      <?
		 } ?>
      &nbsp;</td>
    <? } // end while loop
  ?>
</table>
<form action="sortcourse.php">
<div align="center">
  <input type="submit" name="Submit" value="<? echo $strBack;?>" class="button">
</div></form>
</body>
</html>