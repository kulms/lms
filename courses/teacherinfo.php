<?   require("../include/global_login.php"); ?>

<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<table width="90%" border="0" cellspacing="0" cellpadding="5"  align="center">
  <tr>
    <td colspan="2">
      <div align="center">
	  <? if($ok==1)
	       { 
         $query=("SELECT wp.courses FROM users u,wp 
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
			  $result = mysql_query($sql);
			  $cnt = 0;
			  if($row=mysql_fetch_array($result))
			  {
				  $cnt++;
				  $cname = $row["cname"];  
				  // course id
				  $uid = $row["uid"];
	?>	<!--- header and first line of this header -->
		
    <table width="100%" border=1 cellpadding="2" cellspacing="0">
      <tr bgcolor="#99FFFF"> 
        <td colspan="6"> <div align="center"><font size="2" face="MS Sans Serif, Microsoft Sans Serif"><b> 
            <font color="#000099">These students are waiting for the authorization.</font></b></font></div></td>
      </tr>
      <tr bgcolor="#CC0099"> 
        <td colspan="6"> <div align="left"><font size="1" face="MS Sans Serif, Microsoft Sans Serif" color="#FFFFFF"><b><? echo $cname." : ".$row["cfname"]; ?></b></font></div></td>
      </tr>
      <tr> 
        <td width="31" align="center" valign="top" class="res"><b>No</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Full name</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Email</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Applied Course</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Grant</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Refuse</b></td>
      </tr>
      <tr> 
        <td valign="top"> <span class="info"><? echo $cnt; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["email"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $cname; ?></span></td>
        <td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>">grant</a></span></td>
        <td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>">refuse</a></span></td>
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
        <td valign="top"><span class="info"><? echo $cnt; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["email"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $cname; ?></span></td>
        <td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>">grant</a></span></td>
        <td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>">refuse</a></span></td>
      </tr>
      <?				}
			}else{	
							$cnt = 1;
							$uid = $row["uid"];
							$cname = $row["cname"];
	?>
      <!--- New header and first line of this header -->
      <br>
      <tr bgcolor="#CC0099"> 
        <td colspan="6"> <div align="left"><font size="1" face="MS Sans Serif, Microsoft Sans Serif"><b><font color="#FFFFFF"><? echo $cname." : ".$row["cfname"]; ?></font></b></font></div></td>
      </tr>
      <tr> 
        <td width="31" align="center" valign="top" class="res"><b>No</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Full name</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Email</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Applied Course</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Grant</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Refuse</b></td>
      </tr>
      <tr> 
        <td valign="top"> <span class="info"><? echo $cnt; ?></span></td>
        <td valign="top"> <span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
        <td valign="top"> <span class="info"><? echo $row["email"]?></span></td>
        <td valign="top"> <span class="info"><? echo $cname; ?></span></td>
        <td valign="top"> <span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>">grant</a></span></td>
        <td valign="top"> <span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>">refuse</a></span></td>
      </tr>
      <?				   } // end else
				    }      //end while
			echo "</table>";
			    } //end  if($row=mysql_fetch_array($result))
		   }    // end  if ($course_sql != "")
	   }      // end if($ok==1)
     ?>
</table>

<br>
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
			  $sql = "SELECT  u.id as uid,u.firstname,u.surname,u.email,c.name as cname,
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
<table width="100%" border=1 cellpadding="2" cellspacing="0">
      <tr bgcolor="#D2FFFF"> 
        <td colspan="6" align="center"><font size="2" face="MS Sans Serif, Microsoft Sans Serif"><b> 
            <font color="#000099">These students are waiting for the authorization.[Drop Courses]</font></b></font></td>
      </tr>
      <tr bgcolor="#5E92FF"> 
        <td colspan="6" align="left"><font size="1" face="MS Sans Serif, Microsoft Sans Serif" color="#FFFFFF"><b><? echo $rowcname." : ".$row["cfname"]; ?></b></font></td>
      </tr>
      <tr> 
        <td width="31" align="center" valign="top" class="res"><b>No</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Full name</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Email</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Drop Course</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Grant</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Refuse</b></td>
      </tr>
      <tr> 
        <td valign="top"><span class="info"><? echo $cnt; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["email"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $cname; ?></span></td>
        <td valign="top"><span class="info"><a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1">grant</a></span></td>
        <td valign="top"><span class="info"><a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0">refuse</a></span></td>
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
        <td valign="top"><span class="info"><? echo $cnt; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $row["email"]; ?></span></td>
        <td valign="top"><span class="info"><? echo $cname; ?></span></td>
        <td valign="top"><span class="info"><a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>">grant</a></span></td>
        <td valign="top"><span class="info"><a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>">refuse</a></span></td>
      </tr>
      <?				}
			}else{	
							$cnt = 1;
							$uid = $row["uid"];
							$cname = $row["cname"];
	?>
      <!--- New header and first line of this header -->
      <br>
      <tr bgcolor="#5E92FF"> 
        <td colspan="6"> <div align="left"><font size="1" face="MS Sans Serif, Microsoft Sans Serif"><b><font color="#FFFFFF"><? echo $cname." : ".$row["cfname"]; ?></font></b></font></div></td>
      </tr>
      <tr> 
        <td width="31" align="center" valign="top" class="res"><b>No</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Full name</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Email</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Drop Course</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Grant</b></td>
        <td width="31" align="center" valign="top" class="res"><b>Refuse</b></td>
      </tr>
      <tr> 
        <td valign="top"> <span class="info"><? echo $cnt; ?></span></td>
        <td valign="top"> <span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
        <td valign="top"> <span class="info"><? echo $row["email"]?></span></td>
        <td valign="top"> <span class="info"><? echo $cname; ?></span></td>
        <td valign="top"> <span class="info"><a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1">grant</a></span></td>
        <td valign="top"> <span class="info"><a href="dropresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0">refuse</a></span></td>
      </tr>
      <?				   } // end else
				    }      //end while
			echo "</table>";
			    } //end  if($row=mysql_fetch_array($result))
		 //  }    // end  if ($course_sql != "")
	  // }      // end if($ok==1)
     ?>
    </table>

    <table width="90%" border="0" cellspacing="0" cellpadding="5"  align="center">
      <tr> 
        <td colspan="2" align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"><b>การสมัครเป็นสมาชิกรายวิชา</b></font></td>
      </tr>
      <tr> 
        <td width="6%"><img src="../images/arrow.gif" width="15" height="15"></td>
        <td width="94%"><font color="#330099" face="MS Sans Serif, Microsoft Sans Serif" size="1">1. 
          ดูรายวิชาที่ต้องจะสมัครเป็นสมาชิกทั้งหมด<a href="apply.php">ที่นี่ (click)</a> 
          พร้อมกับรายละเอียดรายวิชา เช่น รหัสวิชา ชื่อ หมู่</font></td>
      </tr>
      <!--
  <tr> 
    <td width="6%">&nbsp;</td>
    <td width="94%">&nbsp;&nbsp;&nbsp;<font color="#330099" face="MS Sans Serif, Microsoft Sans Serif" size="1">1.1 
      ดูรายวิชาที่ปิดสอน<a href="sortcourse.php"><b>ตามรหัสวิชา</b></a></font></td>
  </tr>
  <tr> 
    <td width="6%">&nbsp;</td>
    <td width="94%">&nbsp;&nbsp;&nbsp;<font color="#330099" face="MS Sans Serif, Microsoft Sans Serif" size="1">1.2 
      ดูรายวิชาที่เปิดสอน<a href="sortcourse.php"><b>ตามคณะ</b></a> </font></td>
  </tr>
  <tr> 
    <td width="6%">&nbsp;</td>
    <td width="94%">&nbsp;&nbsp;&nbsp;<font color="#330099" face="MS Sans Serif, Microsoft Sans Serif" size="1">1.3 
      ดูรายวิชาที่เปิดสอน<a href="sortcourse.php"> <b>ตามภาควิชา</b></a> </font></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td width="94%">&nbsp;&nbsp;&nbsp;<font color="#330099" face="MS Sans Serif, Microsoft Sans Serif" size="1">1.3 
      ดูรายวิชาที่เปิดสอน<a href="sortcourse.php"><b>ตามอาจารย์ผู้สอน</b></a> 
      </font></td>
  </tr>-->
      <tr> 
        <td width="6%">&nbsp;</td>
        <td width="94%">&nbsp;&nbsp;&nbsp;<font color="#330099" face="MS Sans Serif, Microsoft Sans Serif" size="1"> 
          ดูรายวิชาที่เปิดสอนโดย<a href="sortcourse.php"> <b>กำหนดเงื่อนไขการแสดง</b></a> 
          ตามรหัสวิชา ตามคณะ ตามภาควิชา ตามอาจารย์ผู้สอน</font></td>
      </tr>
      <tr> 
        <td width="6%"><img src="../images/arrow.gif" width="15" height="15"></td>
        <td width="94%"> <p><font color="#330099" face="MS Sans Serif, Microsoft Sans Serif" size="1">2. 
            ดูรายละเอียดการรับสมัคร ว่าเป็นแบบใด ซึ่งมีอยู่ 3 แบบคือ</font></p></td>
      </tr>
      <tr> 
        <td width="6%">&nbsp;</td>
        <td width="94%"> <blockquote><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#330099">2.1 
            <font color="#660000">Open</font> (สมัครแล้วเป็นสมาชิกของวิชานั้นทันที 
            )</font></blockquote></td>
      </tr>
      <tr> 
        <td width="6%">&nbsp;</td>
        <td width="94%"> <blockquote><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#330099">2.2 
            <font color="#660000">Approve</font> (หลังจากสมัครไปแล้ว ต้องได้รอการอนุมัติจากอาจารย์อีกครั้งหนึ่ง)</font></blockquote></td>
      </tr>
      <tr> 
        <td width="6%">&nbsp;</td>
        <td width="94%"> <blockquote><font color="#330099" size="1" face="MS Sans Serif, Microsoft Sans Serif">2.3 
            Close (ปิดไม่ให้นิสิตสมัคร อาจารย์จะเป็นผู้เลือกสมาชิกเอง)</font></blockquote></td>
      </tr>
      <tr> 
        <td width="6%"><img src="../images/arrow.gif" width="15" height="15"></td>
        <td width="94%"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#330099">3. 
          Click ที่ปุ่ม Apply </font></td>
      </tr>
      <tr> 
        <td width="6%">&nbsp;</td>
        <td width="94%"><font face="MS Sans Serif, Microsoft Sans Serif" size="+2" color="red">โปรดระวัง!!! 
          ห้ามสมัครวิชาอื่นที่ไม่เกี่ยวข้อง เนื่องจากท่านไม่สามารถ ถอนชื่อออกจากวิชาได้เอง 
          ท่านต้องติดต่อกับอาจารย์ประจำวิชานั้น ๆ</font></td>
      </tr>
    </table>
    <br>