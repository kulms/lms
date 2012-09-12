<? require("../include/global_login.php"); ?>
<html>
<head>
        <title>Course On Web - Courses</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script type="text/javascript" language="JavaScript" src="../createlogin/AutoSelect.js"></script>
<script language="JavaScript">
function BrowserInfo()
{	  this.screenWidth = screen.availWidth;
	  this.screenHeight = screen.availHeight;
}
</script>
<script language="javascript">
	 //generate array for filling in select box
	var obj1 = new Array();	// fac
	var obj2 = new Array();	// dept
	var obj3 = new Array();	 // major
	<?	
		$res_Fac = mysql_query("select k.*,c.NAME_THAI as CNAME_THAI from ku_faculty k, ku_campus c where k.CAMPUS_ID = c.CAMPUS_ID order by FAC_NAME,k.id");
		$res_Dept = mysql_query("select d.*,f.id as fid from ku_faculty f, ku_department d where f.id = d.FAC_ID   order by f.FAC_NAME,f.id,d.NAME_THAI");
		//$res_Major = mysql_query("select distinct d.FAC_id as fid,m.* from  ku_faculty f, ku_department d, ku_major m  where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id and m.MAJOR_ID = '' order by f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");
    	$res_Major = mysql_query("SELECT DISTINCT d.FAC_ID as fid,m.* FROM ku_faculty f, ku_department d, ku_major m where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id ORDER BY f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");
		//		$res_Major = mysql_query("select d.FAC_id as fid,m.* from  ku_department d, ku_major m  where  m.DEPT_ID = d.id and m.FAC_ID = d.FAC_ID order by d.NAME_THAI,m.NAME_THAI");
		while($row=mysql_fetch_array($res_Fac))
		{
			echo("obj1[obj1.length]=new OBJ1st('".$row["FAC_NAME"]." (".$row["CNAME_THAI"].")','".$row["id"]."'); \n");
		}		
		while($row1=mysql_fetch_array($res_Dept))
		{
			echo("obj2[obj2.length]=new OBJ2nd('".$row1["fid"]."','".$row1["NAME_THAI"]." (".$row1["DEPT_ID"]." ) ','".$row1["id"]."'); \n");
		}		
		while($row2=mysql_fetch_array($res_Major))
		{
			echo("obj3[obj3.length]=new OBJ3rd('".$row2["fid"]."','".$row2["DEPT_ID"]."','".$row2["NAME_THAI"]." (".$row2["MAJOR_ID"].")','".$row2["id"]."'); \n");
		} 				
	?>
	
		function selectChange(control, controlToPopulate)
		  {  
			// Empty the second drop down box of any choices
			for (var q=controlToPopulate.options.length;q>=0;q--) 
			{		
				controlToPopulate.options.remove(1);
			}
			if (control.name == "fac")
			 {    // Empty the third drop down box of any choices
					for (var q=user.major.options.length;q>=0;q--) 		
						user.major.options.remove(1);
			 }
		  }
</script>
<script language='javascript'> 
		function iconfirm(in_url)
		{
				if( confirm("Do you really want to delete this Department and its major ?") )
					{   
						document.location =in_url; 
					 }
		}
</script>
</script>
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin

var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=\ก\ข\ค\ฆ\ง\จ\ฉ\ช\ซ\ฌ\ญ\ฎ\ฏ\ฐ\ณ\ฑ\ฒ\ด\ต\ถ\ท\ธ\บ\ผ\ป\พ\ฟ\ห\ร\น\ย\ล\ส\ศ\ว\ษ\ฬ\อ\ฮ\ฤ\ฦ|]/;

function checkFields(val) {

	missinginfo = "";
	if (user.file.value == "") {
		missinginfo += "\n     -  File Upload";
	}
	
	if (missinginfo != "") {
		missinginfo ="_____________________________\n" +
		"You failed to correctly fill in your:\n" +
		missinginfo + "\n_____________________________" +
		"\nPlease re-enter and submit again!";
		alert(missinginfo);
		return false;
	}
	else {
		//return true;
		if(user.file.value.search(mikExp) == -1) {
			//alert("Correct Input");
			return true;
		}
		else {
			alert("Sorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ที่มีอักษรภาษาไทย\n\r\n\rare not allowed!\n");
			return false;
		}
	}
}

//  End -->
</script>
</head>
<body bgcolor="#ffffff">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
background="../images/headerbg.gif" height="53">
  <tr>
    <td class="menu" align="center"> <b>Upload Course Syllabus</b><br>
      Step 2</td>
  </tr>
</table>


<?php
$section= str_replace(" ", "", $section);
$check=mysql_query("SELECT * FROM users WHERE category=2 and id=".$person["id"].";");
if(mysql_num_rows($check)==1){
  ///  select course from ku_course
  $kusql=mysql_query("SELECT * FROM ku_courses WHERE  CS_CODE = '$course_id';");
  if(mysql_num_rows($kusql)==1){
  									$kurow=mysql_fetch_array($kusql);
									}
  
        ?>
		
		
  <form action="upload_form_3.php" method="post" enctype="multipart/form-data" name="user" id="user" onSubmit="return checkFields(this.file)">
    <input type="hidden" name="courses" value="0">        
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr> 
      <td colspan="3" class="main" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="1" align="right" bgcolor="#F4F4F4" class="main">Course created 
        by/ อ.ประจำวิชา:</td>
      <td colspan="2" align="left" bgcolor="#F4F4F4" class="main"><b><?php echo $person["title"].$person["firstname"]." ".$person["surname"]; ?></b> 
      </td>
    </tr>
    <tr> 
      <td class="main" align="right" valign="top">Course ID/รหัสวิชา:</td>
      <td class="main"> <input type="text" name="name" size="10" maxlength="6" class="small" value="<?php echo $course_id; ?>"> 
      </td>
    </tr>
    <tr> 
      <td align="right" valign="top" bgcolor="#F4F4F4" class="main">Course Name 
        (English):</td>
      <td bgcolor="#F4F4F4" class="main"> <input name="fullname_eng" type="text" class="small" id="fullname_eng" value="<?php echo $kurow["COURSE_NAME"]; ?>" size="45" maxlength="80"> 
      </td>
    </tr>
    <tr> 
      <td class="main" align="right" valign="top">ชื่อวิชาเป็นภาษาไทย</td>
      <td class="main"><input name="fullname" type="text" class="small" id="fullname" size="45" maxlength="80"></td>
    </tr>
    <tr> 
      <td align="right" valign="top" bgcolor="#F4F4F4" class="main">Section/หมู่การเรียนที่ 
        :</td>
      <td bgcolor="#F4F4F4" class="main"> <input name="section" type="text" class="small" value="<?php echo $section; ?>" size="15" maxlength="25">
        (หากใช้สำหรับหลายหมู่การเรียนใช้เครื่องหมาย , คั่น)</td>
    </tr>
    <tr> 
      <td align="right" class="main">คณะ : </td>
      <td align="left" class="main"> <select name="fac" onclick="manage_2nd(document.forms('user').dept,
		document.forms('user').fac.value);"  onChange="selectChange(this, user.dept);">
          <option value="-1"> -------------------------------- เลือกคณะ --------------------------------------- 
          </option>
          <script language = "javascript">
				Add1stSelect(document.forms('user').fac);
		  </script>
        </select> 
        <? 
				if (@mysql_result($users,0,"fac_id")!=none && @mysql_result($users,0,"fac_id")!="") 
				{	$fac = @mysql_result($users,0,"fac_id");
					if($fac)
					{
						$res1 = mysql_query("select FAC_NAME from ku_faculty where id = $fac");
						echo "<br> คณะปัจจุบัน : ".@mysql_result($res1,0,"FAC_NAME");
						$tmpFact =" <script language= \"javascript\">
						  function selFac()
							{
								document.forms('user').fac.value=\"".$fac."\";
								manage_2nd(document.forms('user').dept,\"".$fac."\");
							}
							</script>";
					}
				}   ?>
      </td>
    </tr>
    <tr> 
      <td align="right" class="main">ภาควิชา : </td>
      <td align="left" class="main"> 
        <!--  <select name="select3">
            <option>------------- เลือกภาควิชา -------------- </option>
          </select><br> -->
        <select name="dept" onclick="manage_3rd(document.forms('user').major,
			document.forms('user').dept.value,
			document.forms('user').fac.value);" onChange="selectChange(this, user.major);">
          <option value="-1"> -------------------------------- เลือกภาควิชา ----------------------------------- 
          </option>
        </select> 
        <?
				if(@mysql_result($users,0,"dept_id")!=none && @mysql_result($users,0,"dept_id")!="")
				{	$dept = @mysql_result($users,0,"dept_id");
					if($dept)
					{
						$res1 = mysql_query("select NAME_THAI from ku_department where id = $dept");
						echo "<br> ภาควิชาปัจจุบัน : ". @mysql_result($res1,0,"NAME_THAI");
						$tmpDept =" <script language= \"javascript\">
						  function selDept()
							{
								document.forms('user').dept.value=\"".$dept."\";
								manage_3rd(document.forms('user').major,\"".$dept."\",\"".$fac."\");
							}
							</script>";
					}
				}   ?>
      </td>
    </tr>
    <tr> 
      <td align="right" class="main">&nbsp;</td>
      <td align="left" class="main">หากชื่อคณะ หรือ ภาควิชาไม่มี หรือ ไม่ถูกต้อง 
        <a href="../faculty/insert_fac.php">Click ที่นี่</a> </td>
    </tr>
    <tr> 
      <td align="right" class="main">Syllabus File (<font color="#990000"><strong>PDF,DOC</strong></font>) 
        เท่านั้น</td>
      <td align="left" class="main"><input name="file" type="file" size="50"> 
        <br> <font color="#990000"><strong>ชื่อ File ต้องเป็นภาษาอังกฤษ</strong></font></td>
    </tr>
    <tr>
      <td class="main" align="right" valign="top">คำสำคัญ / Keyword </td>
      <td class="main"><textarea name="keyword" cols="60" class="small" id="keyword"></textarea></td>
    </tr>
    <? /*
                <tr>
                        <td class="main" align="right" valign="top">Applications</td>
                        <td class="main">The course is closed except for those that are already members.</td>
                        <td valign="top"><input type="Radio" name="applyopen" value="-1" <? if($course["applyopen"]==-1){echo "checked";}?>
    > */ ?> 
    <? 
                $mt=mysql_query("SELECT name,id,picture,info FROM modules_type;");
                ?>
    <tr> 
      <td colspan="3" align="center" valign="top" bgcolor="#F4F4F4" class="small"><input name="Button" type="button" value="&lt;&lt; B a c k" onClick="history.back()"> 
        <input type="submit" value="N e x t &gt;&gt;"> </td>
    </tr>
  </table>
  </form>        

        <?
}
?>
</body>
</html>