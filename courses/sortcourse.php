<?php	 
				
				
				require ("../include/global_login.php");
				include ("../include/control_win.js");  				
?>
<html>
<head>
<title>Sort  Availiable Course </title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="STYLESHEET" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="./style/teacher/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/teacher/faq.css" media="all" />!-->
<script type="text/javascript" language="JavaScript" src="../createlogin/AutoSelect.js"></script>
<script language="javascript">
	 //generate array for filling in select box
	var obj1 = new Array();	// fac
	var obj2 = new Array();	// dept
	var obj3 = new Array();	 // major
	<?	
        $users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
	
		$res_Fac = mysql_query("SELECT k.*,c.NAME_THAI as CNAME_THAI FROM ku_faculty k, ku_campus c WHERE k.CAMPUS_ID = c.CAMPUS_ID  ORDER BY  FAC_NAME,k.id");
	/*
		$res_Dept = mysql_query("select d.*,f.id as fid from ku_faculty f, ku_department d where f.id = d.FAC_ID   order by f.FAC_NAME,f.id,d.NAME_THAI");
    	$res_Major = mysql_query("SELECT DISTINCT d.FAC_ID as fid,m.* FROM ku_faculty f, ku_department d, ku_major m where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id ORDER BY f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");
	*/
		while($row=mysql_fetch_array($res_Fac))
		{
			echo("obj1[obj1.length]=new OBJ1st('".$row["FAC_NAME"]." (".$row["CNAME_THAI"].")','".$row["id"]."'); \n");
		}	
	/*		
		while($row1=mysql_fetch_array($res_Dept))
		{
			echo("obj2[obj2.length]=new OBJ2nd('".$row1["fid"]."','".$row1["NAME_THAI"]." (".$row1["DEPT_ID"]." ) ','".$row1["id"]."'); \n");
		}		
		while($row2=mysql_fetch_array($res_Major))
		{
			echo("obj3[obj3.length]=new OBJ3rd('".$row2["fid"]."','".$row2["DEPT_ID"]."','".$row2["NAME_THAI"]." (".$row2["MAJOR_ID"].")','".$row2["id"]."'); \n");
		}  */				
	?>
	
		function selectChange(control, controlToPopulate)
		  {  	// Empty the second drop down box of any choices
			for (var q=controlToPopulate.options.length;q>=0;q--) 
			{		
				controlToPopulate.options.remove(1);
			}
			if (control.name == "fac")
			 {    // Empty the third drop down box of any choices
					for (var q=form4.major.options.length;q>=0;q--) 		
						form4.major.options.remove(1);
			 }
		  }
</script>
</head>

<body onload="selFac();">
<div align="center">
  <table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
    <tr> 
      <td class="menu" align="center"><b><?php echo $strCourses_LabSearchCourse;?></b></td>
    </tr>
  </table>
  <br>
</div>
<table width="100%" border="0" cellpadding="1" cellspacing="1" class="tdborder1">
  <form name="form1" method="post" action="applysort.php">
    <tr class="boxcolor"> 
      <th colspan="3"  class="Bcolor">&nbsp;*** <? echo $strCourses_LabSelectByCourse;?> *** 
        &nbsp;</th>
    </tr>
    <tr> 
      <td colspan="2"><? echo $strCourses_LabCourseId;?></td>
      <td width="78%"  class="hilite"> <input name="courseid" type="text" id="courseid" size="15" maxlength="15" class="text"> 
        <input name="Submit_id" type="submit" id="Submit_cid" value="<? echo $strCourses_BtnShowCourseId;?>" class="button"> 
      </td>
    </tr>    
    <tr> 
      <td colspan="2"><? echo $strCourses_LabCourseName;?></td>
      <td  class="hilite"> <input name="course_name" type="text" id="course_name" size="30" class="text"> 
        <input name="Submit_cname" type="submit" id="Submit_cname" value="<? echo $strCourses_BtnShowCourseName;?>" class="button"></td>
    </tr>
  </form>
  <tr class="boxcolor"> 
    <th colspan="3"  class="Bcolor">&nbsp;*** <? echo $strCourses_LabSelectByInstructor;?> 
      ***</th>
 
  </tr>
  <form name="form5" method="post" action="applysort.php">
    <!--  
	<tr> 
      <td>&nbsp;</td>
      <td bgcolor="#FFFFD5"  class="info">ชื่อ-นามสกุลผู้สอน(Lecturer's name)</td>
      <td bgcolor="#FFFFD5"  class="info"> <input name="name" type="text" id="name" size="30"> 
        <input name="Submit_name" type="submit" id="Submit_name" value="แสดงตามชื่อ-สกุลผู้สอน"> 
        <br> <b><font color="#FF0000">*** กรุณาใส่เครื่องหมาย : เพื่อแยกชื่อกับนามสกุล 
        </font></b></td>
      <td>&nbsp;</td>
    </tr>-->
    <tr> 
      <td colspan="2"><? echo $strCourses_LabInsName;?></td>
      <td  class="hilite"> <input name="firstname" type="text" id="firstname" size="30" class="text"> 
        <input name="Submit_firstname" type="submit" id="Submit_firstname" value="<? echo $strCourses_BtnShowName;?>" class="button"> 
      </td>
    </tr>
    <tr> 
      <td colspan="2"><? echo $strCourses_LabInsSurname;?></td>
      <td class="hilite"> <input name="surname" type="text" id="surname" size="30" class="text"> 
        <input name="Submit_surname" type="submit" id="Submit_surname" value="<? echo $strCourses_BtnShowSurName;?>" class="button"></td>
    </tr>
  </form>
  <form name="form2" method="post" action="applysort.php">
    <tr> 
      <td colspan="2"><? echo $strCourses_LabInsFac;?></td>
      <td  class="hilite"> 
        <!--<select name="fac" onclick="manage_2nd(document.forms('form3').dept,
		document.forms('form2').fac.value);"  onChange="selectChange(this, form3.dept);"> -->
        <select name="fac"  style="font-size:10px">
          <option value="-1"> -------------------------------- เลือกคณะ --------------------------------------- 
          </option>
          <script language = "javascript">
				Add1stSelect(document.forms('form2').fac);
		  </script>
        </select> <input name="Submit_fac" type="submit" id="Submit_fac" value="<? echo $strCourses_BtnShowFac;?>" class="button"> 
      </td>
    </tr>
    <?
        	if($tmpFact !="")					
				echo $tmpFact;
			else
				echo ("<script language= \"javascript\">
						  function selFac()
							{
							}
							</script>");
?>   
    <tr> 
      <td colspan="2" class="txtcolor"> <div align="left"> <strong><? echo $strCourses_LabShowAll;?></strong>
        </div></td>
      <td class="hilite"> <input name="Submit_all" type="submit" id="Submit_all" value="<? echo $strCourses_BtnShowAll;?>" class="button"></td>
    </tr>
  </form>
</table>
</body>
</html>
<?
				if($fac_id!="")
				{
					$resCampus = mysql_query("select CAMPUS_ID from ku_faculty where id = $fac_id");
					if($row=mysql_fetch_array($resCampus))
						$campus = $row["CAMPUS_ID"];
					else
						$campus = '';
				}
				else
					$campus = ''; 
?>