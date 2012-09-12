<?
	    include("../include/global_login.php");
		include("./include/var.inc.php");
		
	if($Submit)
		{
		echo $modules."ID===";
			$end_date=$_POST["end_date"]." 23:59:59";
			$start_date=$_POST["start_date"]." 00:00:01";
			$semester=$_POST["semester"];
			$year=$_POST["year"];
			$show_std =$_POST["show_std"];
			
			if($show_std=="" || $show_std==null){ $show_std=0; }else{ $show_std=1; }
			$sqlm="SELECT courses FROM modules WHERE id ='$modules'";
			$rs = mysql_query($sqlm);				
			echo  "RS==".$rs [0];
			$co = mysql_fetch_array($rs);
			$sqlA="SELECT * FROM eval_q_set WHERE courses_id=$courses and current=1;";
			$num=mysql_num_rows(mysql_query($sqlA));
			
			if($num==0)
			{	
			   $sqlB="INSERT INTO eval_usrd(creator,current,name,eval_info,start_date,end_date,semester,year,comment) VALUES(".$person["id"].",1,'','','$start_date','$end_date','$semester','$year','');";
				mysql_query($sqlB);				
				$usrdID=mysql_insert_id();
		       $stdID=mysql_result(mysql_query("SELECT std_eval_id FROM eval_std WHERE current=1;"),0,"std_eval_id");
				$sqlC="INSERT INTO eval_q_set (usrd_eval_id,lecturer_id,courses_id,semester,year,current,created,start_date,end_date,max_std_scr,max_usrd_scr,sum_std_scr,sum_usrd_scr,std_eval_id,no_eval_std, show_std,modules_id)  VALUES ($usrdID, '".$person["id"]."', '$courses','$semester','$year', '1', '".date('Y-m-d G:i:s')."', '$start_date', '$end_date', '65', '0', '0', '0','$stdID', '','$show_std','');";
				mysql_query($sqlC);				
				//print("mysql_affected_rows=".mysql_affected_rows()."<br>".mysql_error()."<br>  usrdID=$usrdID<br> stdID=$stdID<br><br> sqlB=$sqlB <br><br> sqlC=$sqlC<br>"); 
				//echo '<meta http-equiv="refresh" content="cindex.php?courses=$courses">'; //Header("Refresh: 0;url=cindex.php?courses=$courses");
				echo '<script language="JavaScript">window.location="cindex.php?courses='.$courses.'";</script>';
			}
			else
			{
				//print("UPDATE eval_q_set  SET end_date='$end_date', start_date='$start_date',semester=$semester, year=$year, show_std=$show_std    WHERE q_set_id=$qset; <br><br>");
				mysql_query("UPDATE eval_q_set  SET end_date='$end_date', start_date='$start_date',semester=$semester, year=$year, show_std=$show_std    WHERE q_set_id=$qset;");
			}
		}
?><html>
<head>
<title>Create  evaluation</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta name="Author" CONTENT="นางสาวชิดชนก วรรณกูล(MissChitchanok Wannakul)">
<meta name="keywords" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ]">
<meta name="description" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ]
 เป็นระบบประเมินการเรียนการสอนออนไลน์(ผ่านเครือข่ายคอมพิวเตอร์) มหาวิทยาลัยเกษตรศาสตร์ เน้นผู้เรียนเป็นศูนย์กลาง ผู้เรียนสามารถศึกษาและทบทวนบทเรียนได้ด้วยตนเอง">
<link href="./include/main.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="./js/mmopenwindow.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal.js"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal_conf.js"></script>
<script language="JavaScript" type="text/javascript" src="./js/admin_sel_course.js"></script>
</head>
<body>


<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="24" bgcolor="#004080" class="bwhite">&nbsp; ระบบประเมินการสอนของอาจารย์โดยนิสิต ( Teaching 
      Evaluate System :TES )</td>
  </tr>
  <tr> 
    <td height="24" bgcolor="#E9E9F3">&nbsp;</td>
  </tr>
</table>
<br>
<?

$courses =503;

 $sql="SELECT  courses_id,semester,year,start_date , end_date, show_std
				FROM eval_q_set 
				WHERE courses_id=$courses and current=1;";
$rs = mysql_query($sql);
     while($row=mysql_fetch_array($rs)){
	echo "courses==". $row[courses_id];
	 echo  "semes==". $row[semester] ;
	echo  "year==". $row[year];
			$courses_id = $row[courses_id];
			$semester = $row[semester] ;
			$year= $row[year];
			$start_date =$row[start_date];
			$end_date =$row[end_date];
			$show_std = $row[show_std];
	 
	 }
	 
	 				mysql_query("UPDATE eval_q_set  SET end_date='$end_date', start_date='$start_date',semester=$semester, year=$year, show_std=$show_std    WHERE q_set_id=$qset;");

	 				$sqlC="INSERT INTO eval_q_set (usrd_eval_id,lecturer_id,courses_id,semester,year,current,created,start_date,end_date,max_std_scr,max_usrd_scr,sum_std_scr,sum_usrd_scr,std_eval_id,no_eval_std, show_std,modules_id)  VALUES ($usrdID, '".$person["id"]."', '$courses','$semester','$year', '1', '".date('Y-m-d G:i:s')."', '$start_date', '$end_date', '65', '0', '0', '0','$stdID', '','$show_std','');";
				mysql_query($sqlC);				

?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" background="./images/left_bg.gif" style="<? echo $bottom.$top.$left.$right; ?>">
  <form name="createFrm" method="post" action="cindex.php?courses=<? echo $courses ?>">
    <tr bgcolor="#E9E9F3"> 
      <td width="280" height="30" align="right" style="<? echo $bottom; ?>">&nbsp;</td>
      <td class="bblack" style="<? echo $bottom; ?>">&nbsp; สร้างแบบประเมินรายวิชา</td>
    </tr>
    <tr align="center"> 
      <td colspan="2" align="right">&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td align="right" style="<? echo $bottom; ?>">ภาคการศึกษา : &nbsp; </td>
      <td align="left" style="<? echo $bottom; ?>"> &nbsp; <select name="semester" id="semester">
          <option value=" "></option>
          <option value="1"<? if($semester==1) { echo " selected";  } ?>>1</option>
          <option value="2"<? if($semester==2) { echo " selected";  } ?>>2</option>
          <option value="3"<? if($semester==3) { echo " selected";  } ?>>3</option>
        </select></td>
    </tr>
    <tr align="center"> 
      <td align="right" style="<? echo $bottom; ?>">ปีการศึกษา : &nbsp; </td>
      <td align="left" style="<? echo $bottom; ?>"> &nbsp; <input name="year" type="text" id="year" size="4" maxlength="4" value="<? echo $year; ?>"></td>
    </tr>
    <tr align="center"  valign="baseline"> 
      <td align="right" style="<? echo $bottom; ?>">เริ่มต้น : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>"><div id="cal1"> &nbsp; 
          <input name="start_date" type="text" id="start_date" value="<? echo strtok($start_date," "); ?>" size="10" maxlength="10"  onFocus="this.blur(); showCal('Date1')">
          &nbsp; <a href="javascript:showCal('Date1')"><img src="calendar/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onmouseout="window.status='';return true"  width="19" height="17" border="0"></a></div></td>
    </tr>
    <tr align="center"  valign="baseline"> 
      <td align="right" style="<? echo $bottom; ?>">สิ้นสุด : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>"><div id="cal2">&nbsp; 
          <input name="end_date" type="text" id="end_date" value="<? echo  strtok($end_date," "); ?>"  size="10" maxlength="10"  onFocus="this.blur(); showCal('Date2')">
          &nbsp; <a href="javascript:showCal('Date2')"><img src="calendar/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onmouseout="window.status='';return true"  width="19" height="17" border="0"></a></div></td>
    </tr>
    <tr align="center"> 
      <td align="right" style="<? echo $bottom; ?>">แสดงผลประเมินให้ผู้เรียนเห็นเมื่อสิ้นสุดช่วงประเมิน 
        : &nbsp; </td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp; <input name="show_std" type="checkbox" id="show_std" value="1" checked <? if($show_std==1){ echo " checked"; } ?>></td>
    </tr>
    <tr valign="middle" bgcolor="#E9E9F3"> 
      <td height="30" align="center" bgcolor="#E9E9F3">&nbsp;</td>
      <td height="30" align="left"><input type="submit" name="Submit" value="Update">   
	      &nbsp; &nbsp; <input type="button" value="C a n c e l" name="cancel" onClick="javascript: window.location='cindex.php';"></td></tr>
	<input name="courses" type="hidden" value="<? echo $_REQUEST["courses"]; ?>">
</form>
</table>	
<br>&nbsp;
</body>
</html>