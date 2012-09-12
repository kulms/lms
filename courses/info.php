<? 
	//require("../include/global_login.php"); 
	session_start();
	$session_id = session_id();		
    
	require ("../include/global_login.php");

	require("../include/online.php");
	online_courses($session_id,$person["id"],$courses,time(),1); 
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );

		
	$user = UserStorage::lookupById($person["login"]);
	
	//session_register( 'user' ); 
	$_SESSION['user'] = $user;
	
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
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?//php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?//php echo $uistyle;?>/faq.css" media="all" />
<link rel="STYLESHEET" type="text/css" href="../style.css">!-->
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #000099; text-decoration: none}
a:visited { color: #000099; text-decoration: none}
a:active { color: #000099; text-decoration: underline}
a:hover { color: #000099; text-decoration: underline}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script language="JavaScript" type="text/JavaScript">

function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
  <tr>
    <td class="menu" align="center"><b><?php echo $strCourses_Header ;?></b></td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="5"  align="center">
  <tr>
    <td colspan="2">
      <div align="center">
	  <? /// if($ok==1)
	      /// { 
         $query=("SELECT distinct wp.courses FROM users u,wp 
		 		  WHERE u.id=".$person["id"]." AND u.id=wp.users AND wp.admin=1;");
         $yr_course=mysql_query($query);
		 $course_sql="";
		 while($row=mysql_fetch_array($yr_course))
   	      {	$course_sql.="w.courses = ".$row["courses"]." or ";   }
		
//		 print($course_sql."  ".$person["id"]." asfd asfd<br>");	 
		  if ($course_sql != "")
		   {		// cut "or" condition	
			  $course_sql = substr($course_sql,0,strlen($course_sql)-3);
			  $sql = "SELECT  u.id as uid,u.firstname,u.surname,u.email,c.name as cname,
			  				  c.fullname as cfname,c.id  as cid, w.id as wid 
					  FROM courses c, users u, apply_courses w 
					  WHERE c.id = w.courses and u.id = w.users and (".$course_sql.") and c.applyopen=0 and c.active=1
					  ORDER BY c.name,w.id,u.id";
			  // Adding and c.applyopen=0 and c.active=1 On 29 Jan 2003
			  //echo $sql;
			  $result = mysql_query($sql);
			  //echo mysql_num_rows($result);
			  $cnt = 0;
			  if($row=mysql_fetch_array($result))
			  {
				  $cnt++;
				  $cname = $row["cname"];  
				  // course id
				  $uid = $row["uid"];
				  //echo $row["uid"];
	?>	<!--- header and first line of this header -->
		
    <table width="95%" border=0 cellpadding="2" cellspacing="0" align="center" background="../images/bg.gif" class="tdborder">
      <tr > 
        <td colspan="6"> <font size="2" face="MS Sans Serif, Microsoft Sans Serif"><b> 
          </b></font> <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tdborder">
            <tr bgcolor="#FFFFFF"> 
              <td width="6%"><img src="../images/apply_users.gif" width="48" height="49" border="0"></td>
              <td width="94%" class="news"><?php echo $strCourses_LabStdListApply;?></td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td colspan="6" class="hilite"> <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tdborder">
            <tr bgcolor="#FFFFFF"> 
              <td width="10%" align="right" class="news"><?php echo $strCourses_LabCourseId;?>:</td>
              <td width="20%" class="news"><?php echo $cname;?></td>
              <td width="15%" class="news"><?php echo $strCourses_LabCourseName;?>: </td>
              <td width="55%"><?php echo $row["cfname"]; ?></td>
            </tr>
          </table></td>
      </tr>
      <tr  class="boxcolor"> 
        <th width="44" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdNo;?></b></font></th>
        <th width="297" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdName;?></b></font></th>
        <th width="296" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdEmail;?></b></font></th>
        <th width="125" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdApply;?></b></font></th>
        <th width="73" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdGrant;?></b></font></th>
        <th width="74" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdRefuse;?></b></font></th>
      </tr>
      <tr> 
        <td valign="top" align="center" class="tdBotred"> <? echo $cnt; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["firstname"]."  ".$row["surname"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["email"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $cname; ?></td>
        <td valign="top" align="center" class="tdBotred"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>"><img src="../images/correct_sign.gif" width="14" height="14" border="0"> 
          <?php echo $strCourses_LabStdGrant;?></a></td>
        <td valign="top" align="center" class="tdBotred"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>"><img src="../images/stop_sign.gif" width="14" height="14" border="0"> 
          <?php echo $strCourses_LabStdRefuse;?></a></td>
      </tr>
      <?	  while($row = mysql_fetch_array($result))
		  {	 
			if($cname == $row["cname"])
			{
			  if($uid != $row["uid"])
			  {
				$cnt++;
				$uid = $row["uid"];				
	?>
      <!--- Next line of the current header -->
      <tr> 
        <td valign="top" align="center" class="tdBotred"><? echo $cnt; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["firstname"]."  ".$row["surname"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["email"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $cname; ?></td>
        <td valign="top" align="center"class="tdBotred"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>"><img src="../images/correct_sign.gif" width="14" height="14" border="0"> 
          <?php echo $strCourses_LabStdGrant;?></a></td>
        <td valign="top" align="center" class="tdBotred"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>"><img src="../images/stop_sign.gif" width="14" height="14" border="0"> 
          <?php echo $strCourses_LabStdRefuse;?></a></td>
      </tr>
      <?				}
			}else{	
							$cnt = 1;
							$uid = $row["uid"];
							$cname = $row["cname"];
	?>
      <!--- New header and first line of this header -->
      <br>
      <tr > 
        <td colspan="6" class="hilite"> <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tdborder">
            <tr bgcolor="#FFFFFF"> 
              <td width="10%" align="right" class="news"><?php echo $strCourses_LabCourseId;?>:</td>
              <td width="20%"><?php echo $cname;?></td>
              <td width="15%" class="news"><?php echo $strCourses_LabCourseName;?>: </td>
              <td width="55%"><?php echo $row["cfname"]; ?></td>
            </tr>
          </table></td>
      </tr>
      <tr class="boxcolor"> 
        <th width="44" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdNo;?></b></font></th>
        <th width="297" align="center" valign="top"><font color="#FFFFFF"><b><?php echo $strCourses_LabStdName;?></b></font></th>
        <th width="296" align="center" valign="top"><font color="#FFFFFF"><b><?php echo $strCourses_LabStdEmail;?></b></font></th>
        <th width="125" align="center" valign="top"><font color="#FFFFFF"><b><?php echo $strCourses_LabStdApply;?></b></font></th>
        <th width="73" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdGrant;?></b></font></th>
        <th width="74" align="center" valign="top"><font color="#FFFFFF"><b><?php echo $strCourses_LabStdRefuse;?></b></font></th>
      </tr>
      <tr> 
        <td valign="top" align="center" class="tdBotred"><? echo $cnt; ?></td>
        <td valign="top" class="tdBotred"> <? echo $row["firstname"]."  ".$row["surname"]; ?></td>
        <td valign="top" class="tdBotred"> <? echo $row["email"]?></td>
        <td valign="top" class="tdBotred"> <? echo $cname; ?></td>
        <td valign="top" align="center" class="tdBotred"> <a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>"><img src="../images/correct_sign.gif" width="14" height="14" border="0"> 
          <?php echo $strCourses_LabStdGrant;?> </a></td>
        <td valign="top" align="center" class="tdBotred"> <a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>"><img src="../images/stop_sign.gif" width="14" height="14" border="0"> 
          <?php echo $strCourses_LabStdRefuse;?></a></td>
      </tr>
      <?				   } // end else
				    }      //end while
			echo "</table>";
			    } //end  if($row=mysql_fetch_array($result))
		   }    // end  if ($course_sql != "")
	  /// }      // end if($ok==1)
     ?>
    </table>
    <?
		//$checkdrop=mysql_query("SELECT d.* FROM drop_courses as d WHERE d.users=".$person["id"]." AND status=1;");
		$query=("SELECT wp.courses FROM users u,wp   WHERE u.id=".$person["id"]." AND u.id=wp.users AND wp.admin=1;");
  	    $yr_course=mysql_query($query);
		 $course_sql="";
		 while($row=mysql_fetch_array($yr_course))
   	      {	$course_sql.="w.courses = ".$row["courses"]." or ";   }
		
		 //print($course_sql."  ".$person["id"]." asfd asfd<br>");	 
		if ($course_sql != "")
		   {		// cut "or" condition	
			  $course_sql = substr($course_sql,0,strlen($course_sql)-3);
			  $sql = "SELECT  u.id as uid,u.firstname,u.surname,u.email,c.name as cname, w.reason,
			  				  c.fullname as cfname,c.id  as cid, w.id as wid 
					  FROM courses c, users u, drop_courses w 
					  WHERE c.id = w.courses and u.id = w.users and (".$course_sql.") and w.status=1
					  ORDER BY c.name,w.id,u.id";
					/* $sql = "SELECT  u.id as uid,u.firstname,u.surname,u.email,c.name as cname,
			  				  c.fullname as cfname,c.id  as cid, w.id as wid 
					  FROM courses c, users u, drop_courses w 
					  WHERE c.id = w.courses and u.id = w.users and w.status=1 
					  ORDER BY c.name,w.id,u.id";
					*/
			  // Adding and c.applyopen=0 and c.active=1 On 29 Jan 2003
			  $checkdrop = mysql_query($sql);
			  $cnt = 0;
			  if($row=mysql_fetch_array($checkdrop))
			  {
				  $cnt++;
				  $cname = $row["cname"];  
				  // course id
				  $uid = $row["uid"];	

?>
    <br>
    <table width="85%" border=0 cellpadding="2" cellspacing="0" class="tdborder" align="center" background="../images/bg.gif">
      <tr> 
        <td colspan="6"><font size="2" face="MS Sans Serif, Microsoft Sans Serif"><b> 
          </b></font> <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" class="tdborder">
            <tr> 
              <td width="1%"><a href="admin_drop.php"><img src="../images/drop_users.gif" width="48" height="49" border="0"></a></td>
              <td width="99%" class="news"><b><?php echo $strCourses_LabStdListWithdraw;?></b></td>
            </tr>
          </table></td>
      </tr>
      <tr > 
        <td colspan="6" align="left" class="hilite"> <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tdborder">
            <tr bgcolor="#FFFFFF"> 
              <td width="10%" align="right" class="news"><strong><?php echo $strCourses_LabCourseId;?>:</strong></td>
              <td width="20%"><?php echo $cname;?></td>
              <td width="15%" class="news"><strong><?php echo $strCourses_LabCourseName;?>: 
                </strong></td>
              <td width="55%"><?php echo $row["cfname"]; ?></td>
            </tr>
          </table></td>
      </tr>
      <tr  class="boxcolor"> 
        <th width="39" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdNo;?></b></font></th>
        <th width="258" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdName;?></b></font></th>
        <th width="275" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdEmail;?></b></font></th>
        <th width="107" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdWithdraw;?></b></font></th>
        <th width="56" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdGrant;?></b></font></th>
        <th width="70" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdRefuse;?></b></font></th>
      </tr>
      <tr> 
        <td valign="top" class="tdBotred" align="center"><? echo $cnt; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["firstname"]."  ".$row["surname"]."<br><font color=\"blue\"><b>Reason : ".$row["reason"]."</b></font>"; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["email"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $cname; ?></td>
        <td valign="top" class="tdBotred" align="center"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>"><img src="../images/correct_sign.gif" width="14" height="14" border="0"></a> 
          <a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1"><?php echo $strCourses_LabStdGrant;?></a></td>
        <td valign="top" class="tdBotred" align="center"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>"><img src="../images/stop_sign.gif" width="14" height="14" border="0"></a> 
          <a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0"><?php echo $strCourses_LabStdRefuse;?></a></td>
      </tr>
      <?	 
			if($cname == $row["cname"])
			{
			  if($uid != $row["uid"])
			  {
				$cnt++;
				$uid = $row["uid"];				
	?>
      <!--- Next line of the current header -->
      <tr> 
        <td valign="top" class="tdBotred" align="center"><? echo $cnt; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["firstname"]."  ".$row["surname"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["email"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $cname; ?></td>
        <td valign="top" class="tdBotred" align="center"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>"><img src="../images/correct_sign.gif" width="14" height="14" border="0"></a> 
          <a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>"><?php echo $strCourses_LabStdGrant;?></a></td>
        <td valign="top" class="tdBotred" align="center"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>"><img src="../images/stop_sign.gif" width="14" height="14" border="0"></a> 
          <a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>"><?php echo $strCourses_LabStdRefuse;?></a></td>
      </tr>
      <?				}
			}else{	
							$cnt = 1;
							$uid = $row["uid"];
							$cname = $row["cname"];
	?>
      <!--- New header and first line of this header -->
      <br>
      <tr > 
        <td colspan="6"> <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tdborder">
            <tr bgcolor="#FFFFFF"> 
              <td width="10%" align="right" class="news"><strong><?php echo $strCourses_LabCourseId;?>:</strong></td>
              <td width="20%"><?php echo $cname;?></td>
              <td width="15%" class="news"><strong><?php echo $strCourses_LabCourseName;?>: 
                </strong></td>
              <td width="55%"><?php echo $row["cfname"]; ?></td>
            </tr>
          </table></td>
      </tr>
      <tr  class="boxcolor"> 
        <th width="39" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdNo;?></b></font></th>
        <th width="258" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdName;?></b></font></th>
        <th width="275" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdEmail;?></b></font></th>
        <th width="107" align="center" valign="top"><font color="#FFFFFF"><b><?php echo $strCourses_LabStdWithdraw;?></b></font></th>
        <th width="56" align="center" valign="top" ><font color="#FFFFFF"><b><?php echo $strCourses_LabStdGrant;?></b></font></th>
        <th width="70" align="center" valign="top"><font color="#FFFFFF"><b><?php echo $strCourses_LabStdRefuse;?></b></font></th>
      </tr>
      <tr> 
        <td valign="top" class="tdBotred" align="center"><? echo $cnt; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["firstname"]."  ".$row["surname"]; ?></td>
        <td valign="top" class="tdBotred"><? echo $row["email"]?></td>
        <td valign="top" class="tdBotred"><? echo $cname; ?></td>
        <td valign="top" class="tdBotred" align="center"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>"><img src="../images/correct_sign.gif" width="14" height="14" border="0"></a> 
          <a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1"><?php echo $strCourses_LabStdGrant;?></a></td>
        <td valign="top" class="tdBotred" align="center"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>"><img src="../images/stop_sign.gif" width="14" height="14" border="0"></a> 
          <a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0"><?php echo $strCourses_LabStdRefuse;?></a></td>
      </tr>
      <?				   } // end else
				    }      //end while
			echo "</table><br>";
			    } //end  if($row=mysql_fetch_array($result))
		 //  }    // end  if ($course_sql != "")
	  // }      // end if($ok==1)
     ?>
    </table>		
    
    <?
	$cname="";
	$news=mysql_query("SELECT  distinct c.name, c.section, c.year, c.semester, c.fullname, nc.courses ,nc.subject,nc.title,nc.picture,nc.id , nc.expired_date, nc.post_date 
												FROM news_courses nc, wp, courses as c  
												WHERE  wp.users=".$person["id"]." and nc.courses=wp.courses AND 
												nc.expired_date>=now() AND c.id=nc.courses 
												ORDER BY nc.id DESC;");
  if(mysql_num_rows($news)!=0)
			{  ?><br>
			<table width="85%" border="0" cellspacing="1" cellpadding="1" align="center" class="tdborder" >
			  <tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center" class="tdborder">
            <tr bgcolor="#FFFFFF"> 
              <td width="6%"><img src="../images/annouce.gif" ></td>
						
              <td width="94%"><font color="#000099"><strong><?php echo $strCourses_LabCourseNews;?></strong></font></td>
					  </tr>
					</table> 
			  <?php 
						  while($row=mysql_fetch_array($news))
							{  	   	
			?>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
				<tr><td>	  	
			  			<table width="100%" border="0" align="right" cellpadding="2" cellspacing="0" class="tdBotred">
                  <tr  class="boxcolor"> 
                    <th width="11%" class="Bcolor"><?php echo $strCourses_LabCourseId;?></th>
                    <th width="2%" class="Bcolor"><?php echo $strCourses_LabCourseSection;?></th>
                    <th width="14%" class="Bcolor"><?php echo $strCourses_LabCourseSemester;?></th>
                    <th width="13%" class="Bcolor"><?php echo $strCourses_LabCourseYear;?></th>
                    <th width="60%" class="Bcolor"><?php echo $strCourses_LabCourseNewsDetail;?></th>
                  </tr>
                  <tr > 
                    <td class="hilite"  align="center" > 
                      <?php  
								
								echo $row["name"]; 															 
							?>
                    </td>
                    <td  class="hilite"  align="center" ><?php echo $row["section"]; ?></td>
                    <td class="hilite"  align="center"><?php echo $row["semester"];?></td>
                    <td  class="hilite" align="center" ><?php echo $row["year"];?></td>
                    <td class="hilite"   align="left" valign="top">
                      <table width="100%" border="0"  cellpadding="2" cellspacing="1" class="tdborder2">
	  
	
	
	
	  <tr > 
		<td width="19%" align="left" class="tdLine">
			 <? if($row["picture"]!="") {
			
			
			echo "<img src=\"../files/news_courses/".$row["courses"]."/thumbnail/".$row["picture"]."\" width=\"60\" height=\"60\" border=\"0\">";
			}else {
			
			echo "<img src=\"images/nopic.gif\" width=\"60\" height=\"60\" border=\"0\">";
			}
			?>
		</td>
	   <td width="81%" align="left" valign="top">
			<a   class="AS" href="#" onClick="NewWindow('news_detail.php?id=<? echo $row["id"] ;?>&courses=<? echo $row["courses"];?>','name','650','500','yes');return false" > 
                                  		<? echo $row["subject"];?>
										</a><br>
			
			<? 
		
				//echo "<a class=\"AS\"  href=\"?a=view&id=".$row["id"]."&courses=$courses\">".$row["subject"]."</a><br>"; 
                               
						  if(strlen($row["title"])>100) {
						  	echo substr($row["title"],0,100)."...";
						  }  else {
						  	echo $row["title"];
						  }
						echo "&nbsp;&nbsp;<span class=\"hilite\">(".$row["post_date"].")</span>";
				
			?>
		</td>
		
	  </tr>
	
	</table>
					  
					   </td>
                  </tr>
                </table>		
				  </td>	
				</tr>
			  </table> 
				<?php 		} // end while   ?>
		</table><br>
				<?  } // end if
			?>							
						
    <table align="center" width="85%">
  <?php if($unseen!=0){ ?>
  <tr bgcolor="#FFFFFF"> 
    <?php } ?>
    <td bgcolor="#FFFFFF" class="main"> <div align="center"> 
        <?  
		if ($person["category"] == 2) 
		{			?>
		<!--
        <table width="100%"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
          <tr> 
            <td width="19%" class="news"><div align="center"><a href="upload_form_1.php"><img src="../images/_course_pref.gif" width="48" height="47" border="0"></a><br>
                <a href="upload_form_1.php">Upload 
                Course<br>
                Syllabus Only!!</a></div></td>
            <td width="79%"  class="news"><p>สำหรับอาจารย์ที่ยังไม่พร้อมที่จะสร้างรายวิชาสนับสนุนการเรียนการสอน<br>
                ให้กับนิสิตด้วย <strong>M<font color="#990000">@</font>xLearn</strong> 
                <br>
                เพียงแต่ต้องการ upload syllabus file (pdf, doc) ให้กับทางมหาวิทยาลัยเท่านั้น 
                <br>
                </p></td>
          </tr>
        </table>
		-->
       
        <br>
        <table width="100%"   class = "tdborder2" >
          <tr>
            <td width="19%" class="news"><div align="center"><a href="create_form1.php"><img src="../images/_tools.gif" width="48" height="47" border="0"><br>
                      <?php echo  $strCourses_MenuCreateCourses;?></a><br>
            </div></td>
            <td width="79%" class="news">
              <div align="left">
                <p><?php echo $strCourses_DetailCreateCourses;?></p>
            </div></td>
          </tr>
        </table>
        <br>

        <? }
		 if ($person["category"] == 3 || $person["category"] == 2)
		      {  ?>        
        <table width="100%"   class="tdborder2">
          <tr> 
            <td width="18%" class="news"><div align="center"><a href="sortcourse.php"><img src="../images/apply_users.gif" width="48" height="49" border="0"></a> 
              </div>
              <div align="center"><a href="sortcourse.php"><?php echo  $strCourses_LabCourseApply;?></a><br>
              </div></td>
            <td width="82%" height="17" valign="middle" class="news"><div align="left">
				<?php echo $strCourses_DetailApplyCourses;?>
              </div></td>
          </tr>
          <tr> 
            <td class="news"><div align="center"><a href="admin_drop.php"><img src="../images/drop_users.gif" width="48" height="49" border="0"></a> 
              </div>
              <div align="center"><a href="admin_drop.php"><?php echo $strCourses_LabCourseWithdraw;?></a><br>
              </div></td>
            <td height="17" valign="middle" class="news"><div align="left">
					<?php echo $strCourses_DetailWithdrawCourses;?> 
                  </div></td>
          </tr>
        </table>
        <? } ?>
      </div></td>
    <?/*
<tr>
    <td width="1%">&nbsp;</td>
    <td class="main" width="3%"><font face="MS Sans Serif, Microsoft Sans Serif" size="1"
color="#0033CC"><b><img src="images/arrow.gif" width="20" height="20"></b></font></td>
    <td class="main" width="18%"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#0033CC"><b>New
      Module </b></font></td>
    <td class="main" width="64%"><font color="#000099">เพิ่มความสะดวกกับให้อาจารย์และนิสิต
      รองรับการสั่งงาน การบ้าน และส่งงานผ่านเว็บเพจ ใน module ใหม่ <b><font color="#CC0099">E-HOMEWORK</font></b></font></td>
    <td width="14%">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td class="main"><font face="MS Sans Serif, Microsoft Sans Serif" size="1"
color="#0033CC"><b><img src="images/arrow.gif" width="20" height="20"></b></font></td>
    <td class="main">
      <div align="left"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#0033CC"><b>Feed
        Back Course :</b></font></div>
    </td>
    <td class="main">
      <p><font color="#CC00CC">Course 000000</font><font color="#000099"> เป็น
        Course พิเศษสำหรับให้อาจารย์และนิสิตได้เสนอความคิดเห็นเกี่ยวกับระบบที่ได้พัฒนาขึ้น
        รวมทั้งรายงานผล ข้อผิดพลาดของ โปรแกรมและข้อแนะนำอื่น ๆ</font></p>
    </td>
    <td>&nbsp;</td>
  </tr>
*/ ?>
</table>
<br>
<? if($person['id']==24268){?>
<table width="100%"  border="0">
  <tr>
    <td><a href="update_courses.php">Update Active courses</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<? }?>
</body>
</html>