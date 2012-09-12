<? require("../include/global_login.php"); ?>
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
		
		
  <form action="create_form_3.php" method="post" name="course">
    <input type="hidden" name="courses" value="0">        
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="5">

    <tr> 
      <td colspan="3" class="main" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="1" align="right" bgcolor="#F4F4F4" class="main">Course created by/ อ.ประจำวิชา:</td>
      <td colspan="2" align="left" bgcolor="#F4F4F4" class="main"><b><?php echo $person["title"].$person["firstname"]." ".$person["surname"]; ?></b> 
      </td>
    </tr>
    <tr> 
      <td class="main" align="right" valign="top">Course ID/รหัสวิชา:</td>
      <td class="main"> <input type="text" name="name" size="10" maxlength="6" class="small" value="<?php echo $course_id; ?>"> 
      </td>
    </tr>
    <tr> 
      <td align="right" valign="top" bgcolor="#F4F4F4" class="main">Course Name (English):</td>
      <td bgcolor="#F4F4F4" class="main"> <input name="fullname_eng" type="text" class="small" id="fullname_eng" value="<?php echo $kurow["COURSE_NAME"]; ?>" size="45" maxlength="80"> 
      </td>
    </tr>
    <tr> 
      <td class="main" align="right" valign="top">ชื่อวิชาเป็นภาษาไทย</td>
      <td class="main"><input name="fullname" type="text" class="small" id="fullname" size="45" maxlength="80"></td>
    </tr>
    <tr> 
      <td align="right" valign="top" bgcolor="#F4F4F4" class="main">Section/หมู่การเรียนที่ :</td>
      <td bgcolor="#F4F4F4" class="main"> <input name="section" type="text" class="small" value="<?php echo $section; ?>" size="15" maxlength="25">
        (ถ้าเปิดใช้สำหรับหลายหมู่การเรียนใช้เครื่องหมาย , คั่น)</td>
    </tr>
    <tr> 
      <td align="right" valign="top" class="main">Registered Student<br>
        จำนวนนิสิตลงทะเบียนเรียน</td>
      <?php
		// explore  section
		 $array = explode(",", $section);
		
		// select  student class list
						$listsql=mysql_query("SELECT  STD_ID FROM ku_classlist where CS_CODE='$course_id';");
		?>
      <td class="main">
				<!  กลุ่มผู้เรียน >
		
				<table border="1" cellpadding="0" cellspacing="0" >
		<tr><td class="main">หมู่</td>
				<td class="main">จำนวน(คน)</td>
		</tr>
		<?php
				    	for($i=0; $i < count($array); $i++)
				   {
							echo "<tr><td class=main align=center>".$array[$i]."</td>";
				   			$gsql=mysql_query("SELECT STD_ID FROM ku_classlist WHERE CS_CODE='$course_id' and  LC_SECTION='$array[$i]';");
				   
							echo "<td class=main align=center>".mysql_num_rows($gsql)."</td></tr>";
							$a=$a+mysql_num_rows($gsql);
						}   ?>
					<tr>
					<td class="main">รวม </td>
					<td align="center" class="res"><b><?php echo $a;?></b></td>
					</tr>

				</table>	  		
<?php		if($a!=0){  ?>
			<input name="add_member" type="radio" value="yes" checked>
			นำผู้ที่ลงทะเบียนวิชานี้ทั้งหมดมาเป็นสมาชิกของวิชานี้ <br> <input name="add_member" type="radio" value="no">
        ไม่ต้องนำนิสิตที่ลงเบียนเรียนมาเป็นสมาชิกของวิชานี้
	<?	} ?>
		</td>
		</tr>
		<tr bgcolor="#F4F4F4"> 
		  <td align="right" valign="top" class="main">Applications/วิธีการให้นิสิตเข้าเรียนเพิ่มเติม</td>
		  <td class="main"> <br> <b> </b> <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr class="main"> 
				<td><input type="Radio" name="applyopen" value="-1" <? if($course["applyopen"]==-1){echo "checked";}?>></td>
				
            <td>ไม่ให้นิสิตเข้าเรียนเพิ่มเติม<br>
              The course is closed except for those that are already members.</td>
			  </tr>
			  <tr class="main"> 
				<td>&nbsp;</td>
				<td>&nbsp;</td>
          </tr>
          <tr class="main"> 
            <td><b> 
              <input name="applyopen" type="Radio" value="0" checked <? if($course["applyopen"]==0){echo "checked";}?>>
              </b></td>
            <td>เปิดให้นิสิตสมัครเข้าเรียนได้แต่ต้องได้รับการอนุญาตก่อน<b><br>
              </b>I want to accept every user and I will receive a mail for <br>
              every application in which I can respond instantantaniously. </td>
          </tr>
          <tr class="main"> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="main"> 
            <td><input type="Radio" name="applyopen" value="1" <? if($course["applyopen"]==1){echo "checked";}?>></td>
            <td>เปิดให้นิสิตเข้าเรียนได้โดยไม่ต้องขออนุญาต<br>
              Everyone is accepted automatically</td>
          </tr>
          <tr class="main"> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td class="main" align="right" valign="top">Active/เปิดใช้งานทันที:</td>
      <td class="main"><input name="active" type="checkbox" class="small" value="true" checked <? if($course["active"]==1){echo "checked";}?>></td>
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
<br>
<?php 

 $getcourse=mysql_query("SELECT  *	 FROM courses WHERE name ='$course_id' ;");
if( mysql_num_rows($getcourse) >0){
?>
<table width="90%" border="1" cellspacing="0" cellpadding="5"  align="center" bordercolor="#CCCCCC">
  <tr> 
    <td colspan="5"> <div align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"> 
        <b>Existing course / ชื่อรหัสวิชาที่เหมือนกันและเปิดใช้งานอยู่แล้ว ณ ขณะนี้</b></font></div></td>
  </tr>
  <tr> 
    <td><div align="center" class="res">Course ID</div></td>
    <td><div align="center" width="5%" class="res">Section (หมู่)</div></td>
    <td><div align="center" class="res">Course Name</div></td>
    <td><div align="center" class="res">Course Administrator</div></td>
     <td><div align="center" width="6%" class="res">Status</div></td>
  </tr>
  <?php  

 while($row=mysql_fetch_array($getcourse))
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
    <td class="info" align="center"><? echo $row["fullname"]; ?></td>
    <? $result=mysql_query("SELECT firstname,surname,email ,title FROM users WHERE id=".$row["users"].";"); ?>
    <td class="info" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>"> 
      <?
      echo @mysql_result($result,0,"title").@mysql_result($result,0,"firstname"); 
	  if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){
      	echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   }else{   	echo @mysql_result($result,0,"surname"); }  ?>
      </a> </td>
    <td class="info" align="center" width="5%">
      <? if($row["active"]==1){echo "Open";}else{ echo "Close";}?>
    </td>
    <? } // end while loop
}
  ?>
</table>
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