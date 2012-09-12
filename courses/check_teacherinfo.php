<?  require("../faculty/include/iconnectdb.inc");  ?>
<link href="../main.css" rel="stylesheet" type="text/css">
<table width="90%" border="0" cellspacing="0" cellpadding="5"  align="center">
  <tr>
    <td colspan="2">
      <div align="center">
 <? $ok=1;
	if($ok==1)
	 {   $query=("SELECT wp.courses FROM users u,wp WHERE u.id=111 AND u.id=wp.users AND wp.admin=1;");
         $yr_course=mysql_query($query);
		 $course_sql="";
		 while($row=mysql_fetch_array($yr_course))
				$course_sql.="w.courses = ".$row["courses"]." or ";
		  
		  if ($course_sql != "")
		  {   // cut "or" condition	
			  $course_sql = substr($course_sql,0,strlen($course_sql)-3);
			  $sql = "SELECT  u.id as uid,u.firstname,u.surname,u.email,c.name as cname,c.fullname as cfname,
			  		 c.id  as cid,w.id as wid FROM courses c, users u, wait_for_grant w WHERE c.id = w.courses and 
					 u.id = w.users and (".$course_sql.") ORDER BY c.name,u.id";
			  print($sql); // check			  
			  $result = mysql_query($sql);
			  $cnt = 0;
			  if($row=mysql_fetch_array($result))
			  {
				  $cnt++;
				  $cname = $row["cname"];  // course id
				  $uid = $row["uid"];
				  
	?>	<!--- header and first line of this header -->
	
		<table border=1 cellpadding="2" cellspacing="0">         
          <tr bgcolor="#99FFFF">
            <td colspan="6">
              <div align="center"><font size="2" face="MS Sans Serif, Microsoft Sans Serif"><b>
			  <font color="#000099">These students are waiting for the authorization.</font></b></font></div>
            </td>
          </tr>
		  <tr bgcolor="#CC0099">
			<td colspan="6">
			  <div align="left"><font size="1" face="MS Sans Serif, Microsoft Sans Serif" color="#FFFFFF">
			  <b><? echo $cname." : ".$row["cfname"]; ?></b></font></div>
			</td>
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
	?>		<!--- Next line of the current header -->
			  <tr>
				<td valign="top"><span class="info"><? echo $cnt; ?></span></td>
				<td valign="top"><span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
				<td valign="top"><span class="info"><? echo $row["email"]?></span></td>
				<td valign="top"><span class="info"><? echo $cname; ?></span></td>
				<td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>">grant</a></span></td>
				<td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>">refuse</a></span></td>      
			  </tr>	
<?		   	  }
			}else{	$cnt = 1;
					$uid = $row["uid"];
					$cname = $row["cname"];
	?>			<!--- New header and first line of this header -->
			<br>
			<tr bgcolor="#CC0099">
			<td colspan="6">
			  <div align="left"><font size="1" face="MS Sans Serif, Microsoft Sans Serif" color="#FFFFFF"><b><? echo $cname." : ".$row["cfname"]; ?></b></font></div>
			</td>
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
			<td valign="top"><span class="info"><? echo $cnt; ?></span></td>
		    <td valign="top"><span class="info"><? echo $row["firstname"]."  ".$row["surname"]; ?></span></td>
		    <td valign="top"><span class="info"><? echo $row["email"]?></span></td>
			<td valign="top"><span class="info"><? echo $cname; ?></span></td>
			<td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=1&waitid=<? echo $row["wid"]; ?>">grant</a></span></td>
			<td valign="top"><span class="info"><a href="grantresponse.php?courses=<? echo $row["cid"]; ?>&users=<? echo $row["uid"]; ?>&rnd=0&waitid=<? echo $row["wid"]; ?>">refuse</a></span></td>        
		  </tr>	
	<?				   }
				  }
			echo "</table>";
			  }
		  }
	  }			     ?>
  <tr>
    <td colspan="2">
      <div align="center"><font size="1" face="MS Sans Serif, Microsoft Sans Serif"><b></b></font></div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div align="center"><font size="1" face="MS Sans Serif, Microsoft Sans Serif" color="#000099"><b>News/Events</b></font></div>
    </td>
  </tr>
  <tr>
    <td width="22%"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"><i><b>Brand
      New Modules</b></i></font></td>
    <td width="78%"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#990033"><b>E-Homework</b>
      module is supporting tool for giving and receiving all assignment via webpages..Try
      it..!!</font></td>
  </tr>
  <tr>
    <td width="22%"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1">
	<i><b>Avialable Courses </b></i></font></td>
    <td width="78%"><font color="#0000CC">
	<a href="course_list.php">List of all created course Now!!</a></font></td>
  </tr>
  <tr>
    <td width="22%"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1">
      <i>Administrator Hint<br>
      <b>Student Testing User</b></i></font></td>
    <td width="78%"><font color="#0000CC" face="MS Sans Serif, Microsoft Sans Serif" size="1">If
      you want to test something as student user with your created course. Please
      use this accout for testing <br><font color="#990099"> User : student <br>
      passwd: fortest </font></font></td>
  </tr>
  <tr>
    <td width="22%"><font color="#009999" face="MS Sans Serif, Microsoft Sans Serif" size="1"><i><b>Bug
      Fixed :</b></i></font></td>
    <td width="78%">
      <p><font color="#009999" size="1" face="MS Sans Serif, Microsoft Sans Serif">Course
        name 'unreg' is an error because the course creator leaves blank in the
        'section field' . Now that bug was fixed. Course name without section
        is OK. </font></p>
    </td>
  </tr>
</table>