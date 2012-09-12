<?php require("../include/global_login.php"); ?>
<html>
<head>
        <title>Course On Web - Courses</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>

<body bgcolor="#ffffff">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
background="../images/headerbg.gif" height="53">
  <tr><td class="menu" align="center">
        <b>CREATE  COURSE</b>
		<br>
      Step 1</td>
  </tr>
</table>


<?
$check=mysql_query("SELECT * FROM users WHERE category=2 and id=".$person["id"].";");
if(mysql_num_rows($check)==1){
         ?>
<form name="form1" method="post" action="create_form_2.php">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="5">
    <input type="hidden" name="courses" value="<? echo $courses; ?>">
    <tr> 
      <td height="31" colspan="3" align="center" class="main">&nbsp;</td>
    </tr>
    <tr> 
      <td width="35%" colspan="1" align="right" class="main"> Course created by/ 
        อ.ประจำวิชา:</td>
      <td width="65%" colspan="2" align="left" class="main"> <b><?php echo $person["title"].$person["firstname"]." ".$person["surname"]; ?></b> 
      </td>
    </tr>
    <tr> 
      <td height="29" align="right" valign="top" class="main">Course ID/รหัสวิชา:</td>
      <td class="main"> <input name="course_id" type="text" class="small" id="course_id" size="10" maxlength="6"> 
      </td>
    </tr>
    <tr>
      <td class="main" align="right" valign="top">Section/หมู่การเรียนที่ :</td>
      <td class="main"> <input type="text" name="section" size="15" maxlength="25" class="small">
        ( ถ้าเปิดใช้สำหรับหลายหมู่การเรียนให้ใช้เครื่องหมาย , คั่น)</td>
    </tr>
    <tr> 
      <td class="main" align="right" valign="top">&nbsp;</td>
      <td class="main"><input type="submit" name="Submit" value="Next &gt;&gt;"></td>
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
  </table>
</form>
<?
}else{
        //User don't have access to this script
        ?>
        <p>&nbsp;</p>
        <div align="center" class="h3">Sorry, you are not permitted to create or edit a course!</div>
        <?
}
?>
</body>
</html>