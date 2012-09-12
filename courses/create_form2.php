<? 
session_start();
$session_id = session_id();
require ("../include/global_login.php");
require("../include/online.php");
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
        <title>Course On Web - Courses</title>
<!--<link rel="STYLESHEET" type="text/css" href="../main.css">-->
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?//php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?//php echo $uistyle;?>/faq.css" media="all" />!-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
 height="53" class="bg1">
  <tr>
    <td class="menu" align="center"> <b><font color="#FFFF00">CREATE COURSE</font></b> 
      <br>
</td></tr>
</table>
<?
$check=mysql_query("SELECT * FROM users WHERE category=2 and id=".$person["id"].";");
if(mysql_num_rows($check)==1){
        if($courses==0){				
                $course["id"]=0;
                $course["name"]="";
                $course["active"]=1;
                $course["applyopen"]=0;
                $course["info"]="";
                $course["users"]=$person["id"];
                $course["fullname"]="";
                $course["section"]="";
        }else{
                $check=mysql_query("SELECT * from courses where id=$courses;");
                $course=mysql_fetch_array($check);
        }
        ?>
		<form action="create_course.php" method="post" name="course" <? if($courses !=0) echo "onSubmit=\"mark_all()\"";?>>
    	<input type="hidden" name="courses" value="0">
		<input name="year" type="hidden" value="<? echo $year;?>">
		<input name="semester" type="hidden" value="<? echo $semester;?>">
		<input name="stype" type="hidden" value="<? echo $stype;?>">
		
  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="1" class="tdborder2" >
    <tr> 
      <td colspan="2"  align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td width="30%"  align="right" class="hilite">Course created by/ อ.ประจำวิชา:</td>
      <td width="70%" align="left"  class="hilite"><b><?php echo $person["title"].$person["firstname"]." ".$person["surname"]; ?></b> 
      </td>
    </tr>
    <tr> 
      <td class="hilite" align="right" >Course ID/รหัสวิชา:</td>
      <td class="hilite"> <input type="text" name="name" size="15" maxlength="15" class="text" value="<?php echo $course_id; ?>"> 
      </td>
    </tr>
    <tr> 
      <td align="right"  class="hilite">Course Name (English):</td>
      <td class="hilite"> <input name="fullname_eng" type="text" class="text" id="fullname_eng" value="<?php echo $kurow["COURSE_NAME"]; ?>" size="45" maxlength="80"> 
      </td>
    </tr>
    <tr> 
      <td class="hilite" align="right" >ชื่อวิชาเป็นภาษาไทย</td>
      <td class="hilite"><input name="fullname" type="text" class="text" id="fullname" size="45" maxlength="80"></td>
    </tr>
    <tr> 
      <td align="right"  class="hilite">Section/หมู่การเรียนที่ :</td>
      <td  class="hilite"> <input name="section" type="text" class="text" value="<?php echo $section; ?>" size="15" maxlength="25">
        (ถ้าเปิดใช้สำหรับหลายหมู่การเรียนใช้เครื่องหมาย , คั่น)</td>
    </tr>
    <tr > 
		  <td align="right" valign="top" class="hilite">Applications/วิธีการให้นิสิตเข้าเรียนเพิ่มเติม</td>
		  <td class="hilite"> <br> <b> </b> <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr class="main"> 
				<td><input type="Radio" name="applyopen" value="-1" <? if($course["applyopen"]==-1){echo "checked";}?> class="r-button"></td>
				
            <td>ไม่ให้นิสิตเข้าเรียนเพิ่มเติม<br>
              The course is closed except for those that are already members.</td>
			  </tr>
			  <tr class="main"> 
				<td>&nbsp;</td>
				<td>&nbsp;</td>
          </tr>
          <tr class="main"> 
            <td><b> 
              <input name="applyopen" type="Radio" value="0" checked <? if($course["applyopen"]==0){echo "checked";}?> class="r-button">
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
            <td><input type="Radio" name="applyopen" value="1" <? if($course["applyopen"]==1){echo "checked";}?> class="r-button"></td>
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
      <td class="hilite" align="right" valign="top">Active/เปิดใช้งานทันที:</td>
      <td class="hilite"><input name="active" type="checkbox"  class="r-button" value="true" checked <? if($course["active"]==1){echo "checked";}?>></td>
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
      <td><input name="Button" type="button" value="&lt;&lt; Back" onClick="history.back()" class="button"></td>
      <td align="right"> <input type="submit" value="Next &gt;&gt;" class="button"> 
      </td>
    </tr>
  </table>
		</form>
<?php 

 $getcourse=mysql_query("SELECT  *	 FROM courses WHERE name ='$course_id' ;");
if( mysql_num_rows($getcourse) >0){
?>
<table width="90%" border="0" cellspacing="0" cellpadding="4"  align="center" class="tdborder" background="../images/bg.gif">
  <tr> 
    <td colspan="5"> <div align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"> 
        <b><font color="#FF0000"><img src="../images/warning.gif" width="14" height="14"> 
        Existing course / ชื่อรหัสวิชาที่เหมือนกันและเปิดใช้งานอยู่แล้ว ณ ขณะนี้ 
        </font><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"><b><font color="#FF0000"><img src="../images/warning.gif" width="14" height="14"></font></b></font><font color="#FF0000"> 
        </font></b></font></div></td>
  </tr>
  <tr  class="boxcolor"> 
    <th width="17%" class="Bcolor"> <div align="center" >Course ID</div></th>
    <th class="Bcolor"> <div align="center" width="5%" >Section</div></th>
    <th width="24%" class="Bcolor"> <div align="center" >Course Name</div></th>
    <th width="37%" class="Bcolor"> <div align="center" >Course Administrator</div></th>
    <th  class="Bcolor"> <div align="center" width="6%" >Status</div></th>
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
    <td class="tdBotRed" align="center"><? echo $row["name"]; ?></td>
    <td class="tdBotRed" align="center" width="15%"> 
      <? if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?>
    </td>
    <td class="tdBotRed" align="center"><? echo $row["fullname"]; ?></td>
    <? $result=mysql_query("SELECT firstname,surname,email ,title FROM users WHERE id=".$row["users"].";"); ?>
    <td class="tdBotRed" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>"> 
      <?
      echo @mysql_result($result,0,"title").@mysql_result($result,0,"firstname"); 
	  if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){
      	echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   }else{   	echo @mysql_result($result,0,"surname"); }  ?>
      </a> </td>
    <td class="tdBotRed" align="center" width="7%"> 
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
?></body>
</html>