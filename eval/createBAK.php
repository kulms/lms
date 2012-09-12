<?
	    include("../include/global_login.php");
		include("./include/var.inc.php");

		if($Submit)
		{
			$end_date=$_POST["end_date"]." 23:59:59";
			$start_date=$_POST["start_date"]." 00:00:01";
			$semester=$_POST["semester"];
			$year=$_POST["year"];
			$show_std =$_POST["show_std"];
			// print($show_std."<br><br>");
			if($show_std=="" || $show_std==null){ $show_std=0; }else{ $show_std=1; }
			// print("UPDATE eval_q_set  SET end_date='$end_date', start_date='$start_date',semester=$semester, year=$year, show_std=$show_std    WHERE q_set_id=$qset; <br><br>");
			mysql_query("UPDATE eval_q_set  SET end_date='$end_date', start_date='$start_date',semester=$semester, year=$year, show_std=$show_std    WHERE q_set_id=$qset;");
		}
?>
<html>
<head>
<title>Create  evaluation</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta name="Author" CONTENT="นางสาวชิดชนก วรรณกูล(MissChitchanok Wannakul)">
<meta name="keywords" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ]">
<meta name="description" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ]
 เป็นระบบประเมินการเรียนการสอนออนไลน์(ผ่านเครือข่ายคอมพิวเตอร์) มหาวิทยาลัยเกษตรศาสตร์ เน้นผู้เรียนเป็นศูนย์กลาง ผู้เรียนสามารถศึกษาและทบทวนบทเรียนได้ด้วยตนเอง">
<link href="./include/main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="./js/trackstd.js"></script>
<script language="Javascript" src="./js/mmopenwindow.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal.js"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal_conf.js"></script>
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
<br>&nbsp;
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" background="./images/left_bg.gif" style="<? echo $bottom.$top.$left.$right; ?>">
  <form name="createFrm" method="post" action="create.php">
    <input type="hidden" name="courses" value="<? echo $courses; ?>">
    <input type="hidden" name="qset" value="<? echo $qset; ?>">
    <input type="hidden" name="ref_url" value="create.php">
    <input type="hidden" name="mailto" value="">
    <input type="hidden" name="sendmail" value="1">
    <?
				$sel_eval=mysql_query("SELECT * FROM eval_q_set  as qset WHERE qset.q_set_id=$qset;");
				$semester=@mysql_result($sel_eval,0,"semester");
				$year=@mysql_result($sel_eval,0,"year");
				$start_date=@mysql_result($sel_eval,0,"start_date");
				$end_date=@mysql_result($sel_eval,0,"end_date");
				$show_std=@mysql_result($sel_eval,0,"show_std");
	   ?>
    <tr bgcolor="#E9E9F3"> 
      <td width="280" height="30" align="right" style="<? echo $bottom; ?>">&nbsp;</td>
      <td class="bblack" style="<? echo $bottom; ?>">&nbsp; สร้างแบบประเมินรายวิชา</td>
    </tr>
    <tr align="center"> 
      <td align="right" style="<? echo $bottom; ?>">ภาคการศึกษา : 
        &nbsp; </td>
      <td align="left" style="<? echo $bottom; ?>"> &nbsp; <select name="semester" id="semester">
		  <option value=" "></option>
          <option value="1"<? if($semester==1) { echo " selected";  } ?>>1</option>
          <option value="2"<? if($semester==2) { echo " selected";  } ?>>2</option>
          <option value="3"<? if($semester==3) { echo " selected";  } ?>>3</option>
        </select></td>
    </tr>
    <tr align="center"> 
      <td align="right" style="<? echo $bottom; ?>">ปีการศึกษา : &nbsp; 
      </td>
      <td align="left" style="<? echo $bottom; ?>"> &nbsp; <input name="year" type="text" id="year" size="4" maxlength="4" value="<? echo $year; ?>"></td>
    </tr>
<!--	
    <tr align="center"> 
      <td width="280" align="right" style="<? echo $bottom; ?>"><b>ช่วงการประเมิน</b> 
        &nbsp; &nbsp; </td>
      <td style="<? echo $bottom; ?>">&nbsp;</td>
    </tr>
-->
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
      <td align="left" style="<? echo $bottom; ?>">&nbsp;
        <input name="show_std" type="checkbox" id="show_std" value="1" <? if($show_std==1){ echo " checked"; } ?>></td>
    </tr>
    <!--		
    <tr align="center"> 
      <td width="280" height="20" align="right" style="<? echo $bottom; ?>"> <b>สังกัดรายวิชา</b> 
        &nbsp; &nbsp; </td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td width="280" align="right" style="<? echo $bottom; ?>">วิทยาเขต : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp; <input name="CourseCampus" type="text" id="CourseCampus" maxlength="30"></td>
    </tr>
    <tr align="center"> 
      <td width="280" align="right" style="<? echo $bottom; ?>">คณะ : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp; <input name="CourseFac" type="text" id="CourseFac" maxlength="50"></td>
    </tr>
    <tr align="center"> 
      <td width="280" align="right" style="<? echo $bottom; ?>">ภาควิชา : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp; <input name="CourseDept" type="text" id="CourseDept" maxlength="255"></td>
    </tr>
    <tr align="center"> 
      <td width="280" height="20" align="right" style="<? echo $bottom; ?>"><b>สังกัดอาจารย์</b> 
        &nbsp; &nbsp; </td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td width="280" align="right" style="<? echo $bottom; ?>">วิทยาเขต : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp; <input name="LecturerCampus" type="text" id="LecturerCampus" maxlength="30"></td>
    </tr>
    <tr align="center"> 
      <td width="280" align="right" style="<? echo $bottom; ?>">คณะ : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp; <input name="LecturerFac" type="text" id="LecturerFac" maxlength="50"></td>
    </tr>
    <tr align="center"> 
      <td width="280" align="right" style="<? echo $bottom; ?>">ภาควิชา : &nbsp;</td>
      <td align="left" style="<? echo $bottom; ?>">&nbsp; <input name="LecturerDept" type="text" id="LecturerDept" maxlength="255"></td>
    </tr>
-->
    <tr valign="middle" bgcolor="#E9E9F3"> 
      <td height="30" align="center" bgcolor="#E9E9F3">&nbsp;</td>
      <td height="30" align="left"><input type="submit" name="Submit" value="<? if($_POST["qset"]!=null){ echo "U p d a t e"; }else{ echo "C r e a t e"; } ?>"> 
        &nbsp; &nbsp; <input type="button" value="C a n c e l" name="cancel" onClick="javascript: window.location='cindex.php';"></td>
    </tr>
  </form>
</table>	
<?  // }   	// END IF   ?>
<br>
&nbsp; 
<table width="95%" align="center" cellpadding="0" cellspacing="0" style="<? echo $top.$left.$right; ?>">
  <tr bgcolor="#E9E9F3" class="bblack"> 
    <td style="<? echo $bottom.$right; ?>">วิทยาเขต</td>
    <td style="<? echo $bottom.$right; ?>">คณะ</td>
    <td style="<? echo $bottom.$right; ?>">ภาควิชา</td>
    <td style="<? echo $bottom.$right; ?>">หลักสูตร / โครงการ</td>
    <td style="<? echo $bottom.$right; ?>">รายวิชา</td>
    <td style="<? echo $bottom; ?>">ผู้สอน</td>
  </tr>
  <tr> 
    <td style="<? echo $bottom.$right; ?>">sda</td>
    <td style="<? echo $bottom.$right; ?>">asd</td>
    <td style="<? echo $bottom.$right; ?>">asd</td>
    <td style="<? echo $bottom.$right; ?>">asd</td>
    <td style="<? echo $bottom.$right; ?>">ads</td>
    <td style="<? echo $bottom; ?>">asd</td>
  </tr>
</table>
</body>
</html>