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
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme?>/style/main.css">
<!--<link rel="STYLESHEET" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="./style/<?//php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?//php echo $uistyle;?>/faq.css" media="all" />!-->
<meta http-equiv="Content-Type" content="text/html" charset="TIS-620">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<script language="javascript">
        function startup()
                {                document.course.elements["courseusers[]"].options[0]=null;
                document.course.elements["users[]"].options[0]=null;
        }
        function addadmin()
                {   for(a=document.course.elements["users[]"].options.length-1;a>-1;a--)
                                {     if(document.course.elements["users[]"].options[a].selected)
                                                {            document.course.elements["courseusers[]"].options[document.course.elements["courseusers[]"].options.length]=new Option(document.course.elements["users[]"].options[a].text,document.course.elements["users[]"].options[a].value);
                                document.course.elements["users[]"].options[a]=null;
                        }
                }
                mark_all();
        }
        function removeadmin()
                {     for(a=document.course.elements["courseusers[]"].options.length-1;a>-1;a--)
                                {    if(document.course.elements["courseusers[]"].options[a].selected)
                                                {            document.course.elements["users[]"].options[document.course.elements["users[]"].options.length]=new Option(document.course.elements["courseusers[]"].options[a].text,document.course.elements["courseusers[]"].options[a].value);
                                document.course.elements["courseusers[]"].options[a]=null;
                        }
                }
                mark_all();
        }
        function mark_all()
                {                for(a=0;a<document.course.elements["courseusers[]"].options.length;a++)
                                {                document.course.elements["courseusers[]"].options[a].selected=true;
                }
        }
        function sendform()
                {                mark_all();
                if(confirm('Make sure that all the members are selected (highlighted) in the memberslist.\nOK to send?'))
                                {
                                        document.course.update.value = "true";
                                        document.course.submit();
                }
        }
        function Closeform()
        {
                        window.opener.location.reload();
                        window.close();
        }
        </script>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
  <tr>
    <td class="menu" align="center"><b><? echo $strCourses_LabCourseApplyList;?></b></td>
  </tr>
</table>
<br>
<table width="90%" border="0" cellspacing="0" cellpadding="5"  align="center" class="tdborder"> 
  <tr>
    <td align="center" colspan="3">[   <a href="#a" name="top"><b><? echo $strCourses_LabCourseWithdraw;?></b></a>  ] &nbsp;&nbsp;[  <a href="#w"><b><? echo $strCourses_LabCourseWaitWithdraw;?></b></a> ]</td>
</table>

<a name="a"></a>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" class="info"><a href="#top">go top</a>&nbsp;</td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="1" cellpadding="2"  align="center" class="tdborder">
  <tr> 
    <td colspan="6" align="center" > <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tdborder">
        <tr bgcolor="#FFFFFF"> 
          <td width="4%"><b><img src="../images/help.gif" width="35" height="35"></b></td>
          <td width="96%" class="news"><b><? echo $strCourses_LabCourseWithdraw;?></b></td>
        </tr>
      </table></td>
  </tr>
  <tr class="boxcolor"> 
    <th width="13%"  class="Bcolor"><? echo $strCourses_LabCourseId;?></th>
    <th class="Bcolor"><? echo $strCourses_LabCourseSection;?></th>
    <th width="33%" class="Bcolor"><? echo $strCourses_LabCourseName;?></th>
    <th width="24%" class="Bcolor"><? echo $strCourses_LabInsName;?></th>
    <th class="Bcolor"><? echo $strCourses_LabStatus;?></th>
    <th class="Bcolor"><? echo $strCourses_LabProcess;?></th>
  </tr>
  <?
		$wcourse=mysql_query("SELECT DISTINCT c.* FROM courses as c, drop_courses as d  WHERE d.users=".$person["id"]." and d.courses=c.id  and d.status=1 ORDER BY c.name;");
		
		$sql="";
		if ($row=mysql_fetch_array($wcourse))
		{
			$sql.= "c.id <> ".$row["id"];
			while($row=mysql_fetch_array($wcourse))			
				$sql.= " and  c.id <> ".$row["id"];
		}	

		$dcourses=mysql_query("SELECT DISTINCT c.* FROM courses as c, drop_courses as d  WHERE d.users=".$person["id"]." and d.courses=c.id  and d.status= 0 ORDER BY c.name;");		
		if ($row=mysql_fetch_array($dcourses))
		{
			if ($sql != "")
				$sql.=" and ";
			$sql.= "c.id <> ".$row["id"];
			while($row=mysql_fetch_array($dcourses))			
				$sql.= " and  c.id <> ".$row["id"];
		}	
		
		if ($sql == "")
		{			
			$acourse=mysql_query("SELECT DISTINCT c.* FROM courses as c, wp WHERE wp.users=".$person["id"]."  and wp.courses=c.id  ORDER BY c.name;");
		}
		else
		{	
			$acourse=mysql_query("SELECT DISTINCT c.* FROM courses as c, wp WHERE wp.users=".$person["id"]."  and wp.courses=c.id  and (".$sql.") and c.users!=wp.users ORDER BY c.name;");	
			
		}
	 while($row=mysql_fetch_array($acourse))
	{
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
  <tr> 
    <td class="hilite" align="center"><? echo $row["name"]; ?></td>
    <td class="hilite" align="center" width="7%"> 
      <? if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?>
    </td>
    <td class="hilite" align="center"> <? echo $row["fullname"]."<br>".$row["fullname_eng"]; ?></td>
    <? $result=mysql_query("SELECT firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
    <td class="hilite" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>"> 
      <? 
		if(   (@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null) && (@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null) ){
					echo @mysql_result($result,0,"firstname")."&nbsp;&nbsp;".@mysql_result($result,0,"surname");
		}else if(@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null){
      	echo @mysql_result($result,0,"firstname");
	   }else if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){   
	   						echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   					}else{   	echo "-"; }  ?>
      </a> </td>
    <td class="hilite" align="center" width="12%"><? echo $td; ?></td>
    <td class="hilite" align="center" width="11%"> 
      <?  //if($open == '-1')
		//{   ?>
      <!--<font color="red">droped</font> -->
      <?
	//	} 
	   $membered=mysql_query("SELECT courses,users FROM wp WHERE courses=".$row["id"]." AND users=".$person["id"].";");
	//	if(mysql_num_rows($membered)==0 && $open!='-1')
		//{   ?>
      <!--   <font color="cccccc">waiting</font>  -->
      <?
		//}
	  if (mysql_num_rows($membered)>=1) 
		{  	?>
      <a href="drop_courses.php?courses=<? echo $row["id"]; ?>"><? echo $strCourses_LabWithdraw;?></a> 
      <?
		}   ?>
    </td>
    <? } // end while loop
  ?>
  <tr> 
    <td colspan="6"><b><? echo $strCourses_LabTotalCourse;?> = 
      <?  echo  @mysql_num_rows($acourse); ?>
      </b></td>
  </tr>
</table>

<?
$wcourse=mysql_query("SELECT DISTINCT c.* FROM courses as c, drop_courses as d  WHERE d.users=".$person["id"]." and d.courses=c.id  and d.status=1 ORDER BY c.name;");
if(mysql_num_rows($wcourse)!=0){         // มีรายวิชาที่กำลังรอผลการถอนจากผู้สอน
?>
<a name="w"></a>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" class="info"><a href="#top">go top</a>&nbsp;</td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="1" cellpadding="2"  align="center" class="tdborder" background="../images/bg.gif">
  <tr> 
    <td colspan="6"align="center"> <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF" class="tdborder">
        <tr> 
          <td width="4%"><img src="../images/help.gif" width="35" height="35"></td>
          <td width="96%" class="news"><b><? echo $strCourses_LabCourseWaitWithdraw;?></b></td>
        </tr>
      </table></td>
  </tr>
  <tr class="boxcolor"> 
    <th width="13%"  class="Bcolor"><? echo $strCourses_LabCourseId;?></th>
    <th class="Bcolor"><? echo $strCourses_LabCourseSection;?></th>
    <th width="33%" class="Bcolor"><? echo $strCourses_LabCourseName;?></th>
    <th width="24%" class="Bcolor"><? echo $strCourses_LabInsName;?></th>
    <th class="Bcolor"><? echo $strCourses_LabStatus;?></th>
    <th class="Bcolor"><? echo $strCourses_LabProcess;?></th>
  </tr>
  <? 
 while($row=mysql_fetch_array($wcourse))
  {
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
  <tr> 
    <td class="hilite" align="center"><? echo $row["name"]; ?></td>
    <td class="hilite" align="center" width="7%"> 
      <? if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?>
    </td>
    <td class="hilite" align="center"> <? echo $row["fullname"]."<br>".$row["fullname_eng"]; ?></td>
    <? $result=mysql_query("SELECT firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
    <td class="hilite" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>"> 
      <? 
		if(   (@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null) && (@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null) ){
					echo @mysql_result($result,0,"firstname")."&nbsp;&nbsp;".@mysql_result($result,0,"surname");
		}else if(@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null){
      	echo @mysql_result($result,0,"firstname");
	   }else if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){   
	   						echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   					}else{   	echo "-"; }  ?>
      </a> </td>
    <td class="hilite" align="center" width="12%"><? echo $td; ?></td>
    <td class="hilite" align="center" width="11%"><? echo $strCourses_LabWait;?></td>
    <? } // end while loop
  ?>
  <tr> 
    <td colspan="6"><b><? echo $strCourses_LabTotalCourse;?> = 
      <?  echo  @mysql_num_rows($wcourse); ?>
      </b></td>
  </tr>
</table>

<?   
	  }  // END     if(mysql_num_rows($wcourse)!=0)

 /*
$dcourses=mysql_query("SELECT DISTINCT c.* FROM courses as c, drop_courses as d  WHERE d.users=".$person["id"]." and d.courses=c.id  and d.status= 0 ORDER BY c.name;");
if(mysql_num_rows($dcourses)!=0){
?>
<!--
<a name="c"><br></a>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" class="info"><a href="#top">Menu</a>&nbsp;</td>
  </tr>
</table>
<table width="90%" border="1" cellspacing="0" cellpadding="5"  align="center" bordercolor="#CCCCCC">
  <tr> 
    <td colspan="6" align="center" class="red"><font color="#993300"><b>รายวิชาที่ถอนชื่อออกแล้ว</b></font></td>
  </tr>
  <tr> 
    <td><div align="center" class="res">Course ID</div></td>
    <td><div align="center" width="5%" class="res">Section (หมู่)</div></td>
    <td><div align="center" class="res">Course Name</div></td>
    <td><div align="center" class="res">Course Admin</div></td>
    <td><div align="center" width="6%" class="res">Apply Status</div></td>
    <td><div align="center" class="res" width="10%">Drop Status&nbsp;</div></td>
  </tr>
  <?  
 while($row=mysql_fetch_array($dcourses))
  {
        $open=$row["applyopen"];

        switch($open)
		{
			case 1:
					$td="Open";
					break;
			case 0:
					$td="<font color=\"#0000cc\"> Approve </font>";
					break;
			case -1:
					$td="<font color=\"#660000\"> Close </font>";
					break;
			default:
					$td="Open";
					break;
        }    //end switch
?>
  <tr> 
    <td class="info" align="center"><? echo $row["name"]; ?></td>
    <td class="info" align="center" width="5%"> 
      <? if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?>
    </td>
    <td class="info" align="center"> <? echo $row["fullname"]."<br>".$row["fullname_eng"]; ?></td>
    <? $result=mysql_query("SELECT firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
    <td class="info" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>">
      <? 
		if(   (@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null) && (@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null) ){
					echo @mysql_result($result,0,"firstname")."&nbsp;&nbsp;".@mysql_result($result,0,"surname");
		}else if(@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null){
      	echo @mysql_result($result,0,"firstname");
	   }else if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){   
	   						echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   					}else{   	echo "-"; }  ?>
      </a> </td>
    <td class="info" align="center" width="6%"><? echo $td; ?></td>
    <td class="info" align="center" width="10%"><font color="cccccc">ถอนแล้ว</font></td>
    <? } // end while loop
  ?>
  <tr> 
    <td colspan="6" class="res"><b>Total course = 
      <?  echo  @mysql_num_rows($dcourses); ?>
      </b></td>
  </tr>
</table> -->
<? 
		} */     // END    if(mysql_num_rows($dcourses)!=0)
  ?>
<br><br><br>
</body>
</html>
<? // UPDATE
/*
  if($update=="true")
   {  	   mysql_query("UPDATE wp SET temp=1 WHERE courses=$courses AND not users=0 AND users!= ".$person["id"].";");
					if(is_array($courseusers))
					{            while(list($key,$val)=each($courseusers))
									{      $check=mysql_query("SELECT * FROM wp WHERE users=$val AND courses=$courses;");
											if(mysql_num_rows($check)!=0)
											{                        mysql_query("UPDATE wp SET temp=0 WHERE users=$val AND courses=$courses;");
											}else{
																	mysql_query("INSERT INTO wp (users,courses) VALUES($val,$courses);");
													   }
									  }
					 }     
			mysql_query("DELETE FROM wp WHERE courses=$courses AND temp=1 AND not users=0 AND users!= ".$person["id"].";");
			 header("Status: 302 Moved Temporarily");
		     header("Location:  users.php?courses=".$courses);
				}   //  -------- End else update --------
*/
?>