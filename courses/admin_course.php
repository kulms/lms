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

online_courses($session_id,$person["id"],$courses,time(),1);

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
	   include ("../include/control_win.js");  
	//OLD :-: only admin of this course not include the one who created this course
	//$check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=$courses AND admin=1;");		
	//NEW :-: admin + the one who create this course
	$check=mysql_query("SELECT wp.*, c.users as cusers FROM wp, courses c WHERE wp.courses = c.id and wp.users=".$person["id"]." AND wp.courses=$courses");
	if($person["admin"]==1 || (mysql_num_rows($check)!=0 && $courses!=0))
	{	  if($courses==0)
		  {		      $course["id"]=0;
					  $course["name"]="";
					  $course["active"]=1;
					  $course["applyopen"]=1;
					  $course["info"]="";
					  $course["users"]=$person["id"];
					  $course["fullname"]="";
					  $course["section"]="";
			}else{
					  $check=mysql_query("SELECT * from courses where id=$courses;");
					  $course=mysql_fetch_array($check);
				     }
?>
<html>
<head>
<title>Course On Web - Courses</title>
<script language="javascript">
function startup()
{
        document.course.elements["courseadmins[]"].options[0]=null; 
      // document.course.elements["users[]"].options[0]=null;
}
 function addadmin()
{
        for(a=document.course.elements["users[]"].options.length-1;a>-1;a--)
		{
                if(document.course.elements["users[]"].options[a].selected)
				{
                        document.course.elements["courseadmins[]"].options[document.course.elements["courseadmins[]"].options.length]=new Option(document.course.elements["users[]"].options[a].text,document.course.elements["users[]"].options[a].value);
                        document.course.elements["users[]"].options[a]=null;
                }
        }
}
function removeadmin()
{
        for(a=document.course.elements["courseadmins[]"].options.length-1;a>-1;a--)
		{
                if(document.course.elements["courseadmins[]"].options[a].selected)
				{
                       document.course.elements["users[]"].options[document.course.elements["users[]"].options.length]=new Option(document.course.elements["courseadmins[]"].options[a].text,document.course.elements["courseadmins[]"].options[a].value);
                        document.course.elements["courseadmins[]"].options[a]=null;
                }
        }
}
function mark_all()
{
        for(a=document.course.elements["courseadmins[]"].options.length-1;a>-1;a--)
		{
                document.course.elements["courseadmins[]"].options[a].selected=true;
        }
}
</script> 
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php// echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php// echo $uistyle;?>/faq.css" media="all" />!-->
</head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<body bgcolor="#ffffff" onLoad="startup()">

<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
	<tr>					
            
    <td class="menu" align="center"><b>Edit Course / แก้ไขข้อมูลรายวิชา<br>
              รายวิชา 
			<?   							
			echo $course["name"];
			 if ($course["section"] != "")
			 {    
			?>
					(หมู่ <? echo $course["section"]; ?>) 
			<?  
			}   
			?>
              </b>
			  </td>
	</tr>
</table>
<br>
<table  width="80%" border="0" align="center" cellpadding="4" cellspacing="1" class="tborder1">
  <form action="create_course.php" method="post" name="course" onSubmit="mark_all()">
    <!---<input type="hidden" name="flag" value="">-->
    <input type="hidden" name="courses" value="<? echo $courses; ?>">
    <tr > 
      <td colspan="2"  align="left" class="main"> <b>Course 
        Details / รายละเอียดรายวิชา</b> 
        <table width="100%" border="0" cellspacing="1" cellpadding="2" class="tdborder2">
          <tr bgcolor="#FFFFFF"> 
            <td width="40%" colspan="1" align="right" class="hilite"> 
              <? $check=mysql_query("SELECT * from users WHERE id=".$course["users"].";"); ?>
              <strong>Course created by/ อ.ประจำวิชา :</strong></td>
            <td width="60%" align="left" class="hilite"> <b><? echo mysql_result($check,0,"firstname")." ".mysql_result($check,0,"surname"); ?></b> 
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>Course ID/รหัสวิชา 
              :</strong></td>
            <td valign="top" class="hilite"> 
              <input type="text" name="name" size="12" maxlength="12" class="text" value="<? echo $course["name"]; ?>"> 
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>Course Name 
              (English) :</strong></td>
            <td valign="top" class="hilite"> 
              <input type="text" name="fullname_eng" size="45" maxlength="80" class="text" value="<? echo $course["fullname_eng"]; ?>"> 
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>ชื่อวิชาเป็นภาษาไทย 
              :</strong></td>
            <td valign="top" class="hilite">
<input type="text" name="fullname" size="45" maxlength="80" class="text" value="<? echo $course["fullname"]; ?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>Section/หมู่การเรียนที่ 
              :</strong></td>
            <td valign="top" class="hilite"> 
              <input type="text" name="section" size="6" maxlength="6" class="text" value="<? echo $course["section"]; ?>"> 
            </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td class="hilite" align="right" valign="top"><strong>Section Type/ประเภทหมู่การเรียน 
              :</strong></td>
            <td valign="top" class="hilite"> 
              <select name="stype" style="font-size:10px">
					<option value="-1" >-select-</option>
					<option value="1" <? if($course["section_type"]==1) echo "selected"; ?>>หมู่บรรยาย</option>
					<option value="2" <? if($course["section_type"]==2) echo "selected"; ?>>หมู่ปฎิบัติ</option>
        		</select></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>Year/ปีการศึกษา 
              :</strong></td>
            <td valign="top" class="hilite">25 
              <input type="text" name="year" size="2" maxlength="2" class="text" value="<? echo $course["year"]; ?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>Semester/ภาคการศึกษา 
              :</strong></td>
            <td valign="top" class="hilite">
<input type="text" name="semester" size="2" maxlength="2" class="text" value="<? echo $course["semester"]; ?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>Active/เปิดใช้งานทันที 
              :</strong></td>
            <td valign="top" class="hilite"> 
              <input type="checkbox" name="active" class="r-button" value="true" <? if($course["active"]==1){echo "checked"; }?>></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td class="hilite" align="right" valign="top"><strong>Info/รายละเอียดเพิ่มเติม 
              :</strong></td>
            <td valign="top" class="hilite"><font face="MS Sans Serif" size=1> 
              <textarea name="info" cols="60" rows="10" class="textarea" wrap="PHYSICAL"><?
						 	$course["info"]=trim($course["info"]);
							echo trim($course["info"]);								
					?></textarea>
              </font> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="35" align="right" valign="top" class="hilite"><strong>Applications/วิธีการให้นิสิตเข้าเรียนเพิ่มเติม 
              :</strong> </td>
            <td class="hilite"><input type="Radio" name="applyopen" value="-1" <? if($course["applyopen"]==-1){echo "checked"; }?> class="r-button">
              ไม่ให้นิสิตเข้าเรียนเพิ่มเติม<br>
              The course is closed except for those that are already members.</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td valign="top" align="right" class="hilite">&nbsp;</td>
            <td class="hilite">
              <input type="Radio" name="applyopen" value="0" <? if($course["applyopen"]==0){echo "checked"; }?> class="r-button">
              เปิดให้นิสิตสมัครเข้าเรียนได้แต่ต้องได้รับการอนุญาตก่อน<br>
              I want to accept every user and I will receive a mail for <br>
              every application in which I can respond instantantaniously.</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td valign="top" align="right" class="hilite" >&nbsp; </td>
            <td class="hilite"><input type="Radio" name="applyopen" value="1" <? if($course["applyopen"]==1){ echo "checked"; } ?> class="r-button">
              เปิดให้นิสิตเข้าเรียนได้โดยไม่ต้องขออนุญาต<br>
              Everyone is accepted automatically</td>
          </tr>
        </table></td>
    </tr>    
    <? /* $users=mysql_query("SELECT * FROM users WHERE active=1 AND
									category=2 or category=5 ORDER BY firstname ASC,surname ASC;"); 
				if($flag == "-1")
					$CurCond= "AND wp.temp!=-1";
				else
					$CurCond = ""; 			
                $admins=mysql_query("SELECT u.id,u.firstname,u.surname,u.login FROM users 
									u,wp wp,courses c WHERE c.id=".$course["id"]." AND c.id=wp.courses AND wp.users=u.id AND 
									(wp.admin=1 )$CurCond AND u.active=1 AND wp.courses=".$course["id"]." AND wp.modules=0 
									ORDER BY u.firstname ASC, u.surname ASC;");   */
	$admins=mysql_query("SELECT u.id,u.firstname,u.surname,u.login 
						 FROM  users u,wp,courses c 
						 WHERE c.id=".$course["id"]." AND c.id=wp.courses AND wp.users=u.id AND (wp.admin=1) AND 
						       u.active=1 AND wp.courses=".$course["id"]." AND wp.modules=0 AND wp.folders=0 AND 
						 	   wp.groups=0 AND wp.cases=0 
					     ORDER BY c.users desc");				
				// increase or wp.temp=1  not  temp=-1
             ?>
    <tr> 
      <td colspan="2" class="main" > <div > 
          <hr>
          <b> Course Administrators / ผู้ดูแลรายวิชา</b><br>
        </div>
        <table border="0" cellpadding="2" cellspacing="1" class="tdborder2" width="100%">
          <tr bgcolor="#FFFFFF"> 
            <td align="right" class="hilite" valign="top"><b>Administrators / 
              ผู้ดูแล:</b> <br> </td>
            <td class="hilite"> <select multiple name="courseadmins[]" size="7">
                <option value="0">---------------------------- 
                <? while($row=mysql_fetch_array($admins))
					{ 
						?>
                <option value="<? echo $row["id"]; ?>"> <? echo $row["firstname"]."_".$row["surname"]."(".$row["login"].")"; ?> 
                <?  }   ?>
              </select>
              <br>
              <input name="addCoAdmin" id="addCoAdmin" type="button" value="Add Co-administrators" onClick="NewWindow('add_admin_course.php?courses=<? echo $courses; ?>','add_admin_course','600','600','yes');return false" class="button"> 
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td align="center" class="hilite" valign="top">&nbsp;</td>
            <td align="left" class="hilite" valign="top">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td align="right" class="hilite" valign="top"><b>Co-Administrators 
              Permission / กำหนดสิทธิผู้ดูแล:</b></td>
            <td align="left" class="hilite" valign="top">
			<input name="addCoAdminPer" id="addCoAdminPer" type="button" value="Add Co-administrators Permission" onClick="NewWindow('add_admin_permission.php?courses=<? echo $courses; ?>','add_admin_permission','600','550','yes');return false" class="button"></td>
          </tr>
        </table>
        <hr></td>
    </tr>
    <tr align="left"> 
      <td colspan="2"  valign="top"> 
        <? if($courses==0)
							{	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><input type="submit" value="  <? echo $strCreate;?> " class="button"></td>
            <td><input type="reset" value="   <? echo $strReset;?> " class="button"></td>
            <td align="right"><input type="button"  value="<? echo $strBack;?>" onClick="history.back();" class="button"></td>
          </tr>
        </table>
        <? }else{	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td> <input type="submit" value="  <? echo $strUpdate;?>  " class="button"></td>
            <td><input type="reset" value="   <? echo $strReset;?>  " class="button"></td>
            <td align="right"> <input type="button"  value="<? echo $strBack;?>" onClick="history.back();" class="button"></td>
          </tr>
        </table>
        <? 	}   ?>
      </td>
    </tr>
  </form>
</table>
        <?
		}else{  //User don't have access to this script
        ?>
        <p>&nbsp;</p>
        <div align="center" class="h3">Sorry, you are not permitted to create or edit a course!</div>
		<?	 }	 ?>
</body>
</html>