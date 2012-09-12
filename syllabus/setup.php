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

function gen_date_int($string)
{
	$stringArray = explode("-", $string);		
	$date = mktime(0,0,0,$stringArray[1],$stringArray[2],$stringArray[0]); 		
	return $date;
}

function insert_syllabus_activity($courses,$date,$time,$topics)
{
	if (trim($courses)!="")
   {
		mysql_query("INSERT INTO syllabus_activity (courses,date,time,topic) VALUES($courses,$date,'".$time."','".$topics."');");
   }	
}

function dayOfWeek($timestamp) { 
		return intval(strftime("%w",$timestamp))+1; 
}

function compareDay($day1,$day2)
{	
	if(($day1==1 and $day2==1) or ($day1==2 and $day2==2) or ($day1==3 and $day2==3) or ($day1==4 and $day2==4) or 
	   ($day1==5 and $day2==5) or ($day1==6 and $day2==6) or ($day1==7 and $day2==7)){
		return 0;
	} else {
		if(($day1==1 and $day2==2) or ($day1==2 and $day2==3) or ($day1==3 and $day2==4) or ($day1==4 and $day2==5) or 
	   		($day1==5 and $day2==6) or ($day1==6 and $day2==7) or ($day1==7 and $day2==1)){
			return 1;
		} else {		
			if(($day1==1 and $day2==3) or ($day1==2 and $day2==4) or ($day1==3 and $day2==5) or ($day1==4 and $day2==6) or 
			   ($day1==5 and $day2==7) or ($day1==6 and $day2==1) or ($day1==7 and $day2==2)){
				return 2;
			} else {
				if(($day1==1 and $day2==4) or ($day1==2 and $day2==5) or ($day1==3 and $day2==6) or ($day1==4 and $day2==7) or 
				   ($day1==5 and $day2==1) or ($day1==6 and $day2==2) or ($day1==7 and $day2==3)){
					return 3;
				} else {
					if(($day1==1 and $day2==5) or ($day1==2 and $day2==6) or ($day1==3 and $day2==7) or ($day1==4 and $day2==1) or 
					   ($day1==5 and $day2==2) or ($day1==6 and $day2==3) or ($day1==7 and $day2==4)){
						return 4;
					} else {
						if(($day1==1 and $day2==6) or ($day1==2 and $day2==7) or ($day1==3 and $day2==1) or ($day1==4 and $day2==2) or 
						   ($day1==5 and $day2==3) or ($day1==6 and $day2==4) or ($day1==7 and $day2==5)){
							return 5;
						} else {
							if(($day1==1 and $day2==7) or ($day1==2 and $day2==1) or ($day1==3 and $day2==2) or ($day1==4 and $day2==3) or 
							   ($day1==5 and $day2==4) or ($day1==6 and $day2==5) or ($day1==7 and $day2==6)){
								return 6;
							}
						}
					}
				}
			}
		}
	}					
}
/*	$userdef = mysql_query("select su.* from syllabus_userdef su where courses = $courses order by id"); 
		if (@mysql_num_rows($userdef)==0)
		{
			$sel_syllabus=mysql_query("SELECT * FROM syllabus WHERE courses=$courses;");
			$row_syllabus=@mysql_fetch_array($sel_syllabus);			
		}*/
		$sel_syllabus=mysql_query("SELECT * FROM syllabus WHERE courses=$courses;");
		$row_syllabus=@mysql_fetch_array($sel_syllabus);			

$checkuser=mysql_query("SELECT c.users,c.name,c.section,u.firstname,u.surname FROM courses c, users u WHERE c.id=$courses AND u.id=c.users;");

if(mysql_result($checkuser,0,"users")==$person["id"] || $person["admin"]==1 || $person["category"]==2)
{       
		if($u_check!=1)
        {  
				$c_id=$courses;          
?>
                <html>
                <head>
                        <title>Syllabus Setup</title>
                        <LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
						<link rel="STYLESHEET" type="text/css" href="../themes/blue/style/style.css">
						<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
                <meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>
                <body bgcolor="#ffffff">
<?            
				include("header.php");
				$CourseName = mysql_result($checkuser,0,"name");
				$Section = mysql_result($checkuser,0,"section");
				
                $bgcolor = "#d4e2ed";
                $GetAll = mysql_query("SELECT * FROM syllabus_prefs WHERE courses=$c_id;");
                if(mysql_num_rows($GetAll)!=0)
                 {       $row=mysql_fetch_array($GetAll);
				 				$s_id = $row["id"];
                                $weeks = $row["weeks"];
								$occasion = $row["occasion"];
								$start_date = $row["start_date"];                                
                                $day = $row["day"];
								$start_hour = $row["start_hour"];
								$start_min = $row["start_min"];
								$end_hour = $row["end_hour"];
								$end_min = $row["end_min"];
								$length = $row["length"];
								$cal = $row["calendar"];
								$resources = $row["resources"];								
                                $exists=1;
                }
?>
<script language="javascript" src="calendar/cal.js"></script>
<script language="javascript" src="calendar/cal_conf.js"></script>
<SCRIPT language="JavaScript">
<!-- 
function validate(_frm) { 

	var _f="Here is the form data you entered:";
	var _l="Do you want to submit this data?";
	var errormsg='Following Errors Occured ::\n_____________________________\n\n';
	var _n="\n";
    var _fd="";
	var error_weeks=false;
	var error_occasion=false;
	var error_start_date=false;
	var error;
		
		if (_frm.weeks.value == "" )
			{		
					errormsg+='Please enter Amount per course.\n';
					error_weeks=true;						
			}
		if (_frm.occasion.value == "" )
			{		
					errormsg+='Please enter Amount per week.\n';
					error_occasion=true;				
			}	
		if (_frm.start_date.value == "" )
			{		
					errormsg+='Please enter Start Date.\n';
					error_start_date=true;		
			}
			
		if(error_weeks||error_occasion||error_start_date)
			{
				error=true;
			}
				else
			{
				error=false;
			}
			
	if (error)
	{
		alert(errormsg);
		return false;
	}
} 
//--> 
</SCRIPT> 
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin

//var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=\ก\ข\ค\ฆ\ง\จ\ฉ\ช\ซ\ฌ\ญ\ฎ\ฏ\ฐ\ณ\ฑ\ฒ\ด\ต\ถ\ท\ธ\บ\ผ\ป\พ\ฟ\ห\ร\น\ย\ล\ส\ศ\ว\ษ\ฬ\อ\ฮ\ฤ\ฦ|]/;

function checkFields(val) {

	missinginfo = "";
	if (form1.uploadedFile.value == "") {
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
		if(form1.uploadedFile.value.search(mikExp) == -1) {
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

                <br>
<div class="h3" align="center">Preferences Syllabus for <? echo $CourseName; ?></div>
                
				
<div align="center" class="main">Use this page to customize your Course Syllabus.<br>
  <br>
  <table width="60%" border="0" align="center" cellpadding="2" cellspacing="1" class="tborder">
    <tr> 
      <td class="bluenav"><div align="center"><b>:-: You can add your syllabus 
          by 2ways</b> <b> :-:</b></div></td>
    </tr>
    <tr> 
      <td><font color="#0066FF">1. Choose one way for syllabus text filling:</font></td>
    </tr>
    <tr> 
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#0066FF">Typing in the below 
        preference<b> then</b> define your form.</font></td>
    </tr>
    <tr> 
      <td><font color="#0066FF">2. Upload your syllabus file<b> *.doc or *.pdf 
        </b>(prefer .pdf) <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;in the uploadfile section.</font></td>
    </tr>
  </table>
  <form name="form1" method="post" action="setup.php" enctype="multipart/form-data" onSubmit="return checkFields(this.uploadedFile)">
    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr align="center" bgcolor="#CCCCCC"> 
        <td colspan="2" class="main" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px; "><strong>Syllabus 
          Upload File</strong> </td>
      </tr>
      <tr> 
        <td width="61%" class="main" style="border-bottom: solid #2D649B 2px;"><b>Course 
          Name</b>: &nbsp; <? echo $CourseName; ?>&nbsp;&nbsp;&nbsp;<b>Section</b>: 
          &nbsp; <? echo $Section; ?> </td>
        <td width="39%" align="left" class="main" style="border-bottom: solid #2D649B 2px;">&nbsp;</td>
      </tr>
      <tr> 
        <td bgcolor="<? echo $bgcolor; ?>" class="main" style="border-bottom: solid #2D649B 1px;"><b>Syllabus 
          file: </b></td>
        <td height="46" bgcolor="<? echo $bgcolor; ?>" class="main" style="border-bottom: solid #2D649B 1px;"> 
          <input name="uploadedFile" type="file" id="uploadedFile" value=""> <b><font color="#69012E">***File 
          type .doc/.pdf ***</font></b> <br>
          <?php   
				if(($row_syllabus["syllabus_upload"]!="")&&($row_syllabus["syllabus_upload"]!=none))
				{	echo " Current File : "; ?>
          <a href="<? echo 	"../files/syllabus/$courses/".$row_syllabus["newuploadfilename"];?>" target="<? echo "_blank"; ?>"> 
          <? 		//	echo $row["syllabus_upload"]."</a>";
					echo $row_syllabus["syllabus_upload"]; ?>
          </a> 
          <?		echo "  [ "; ?>
          <a href="<? echo "deletesyllabus.php?courses=$courses";?>"> <? echo "Delete syllabus file</a> ] ";
				}
	 	?> </a><br>
          <font color="#990000"><strong>ชื่อ File ต้องเป็นภาษาอังกฤษ</strong></font></td>
      </tr>
      <tr> 
        <td class="main" style="border-bottom: solid #2D649B 1px;"><strong>Show 
          Type in:</strong></td>
        <td class="main" style="border-bottom: solid #2D649B 1px;"> <table width="200">
            <tr> 
              <td class="main" ><label> 
                <input type="radio" name="file_target" value="0" <? if($row_syllabus["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                Show file in same window</label></td>
            </tr>
            <tr> 
              <td class="main" ><label> 
                <input name="file_target" type="radio" value="1" <? if($row_syllabus["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                Show file in new window</label></td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td colspan="3" bgcolor="#739FC4" class="main"> <input type="submit" name="submit_file" value="Save File"> 
          <input type="reset" name="Submit3" value="Reset">
          <input type="Hidden" name="courses" value="<? echo $c_id; ?>"></td>
      </tr>
    </table>
	</form>
  <br>
</div>
				
<table width="100%" align="center" cellpadding="3" cellspacing="0">
  <form action="setup.php" name="setup" method="POST" onSubmit="return validate(document.setup)">
    <tr align="center" bgcolor="#CCCCCC"> 
      <td colspan="2" class="main" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><strong>Syllabus 
        Text Filling</strong></td>
    </tr>
    <tr> 
      <td width="61%" class="main" style="border-bottom: solid #2D649B 2px;"><b>Course 
        Name</b>: &nbsp; <? echo $CourseName; ?>&nbsp;&nbsp;&nbsp;<b>Section</b>: 
        &nbsp; <? echo $Section; ?> </td>
      <td width="39%" align="left" class="main" style="border-bottom: solid #2D649B 2px;">&nbsp;</td>
    </tr>
    <tr bgcolor="<? echo $bgcolor; ?>"> 
      <td bgcolor="<? echo $bgcolor; ?>" class="main" style="border-bottom: solid #2D649B 1px;"><b>Amount 
        per course :</b><br>
        จำนวนครั้งที่สอนต่อ 1 รายวิชา</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 1px; "><input type="Text" name="weeks" size="2"  maxlength="2" value="<? if($weeks!=0){ echo $weeks; } ?>" style="border: 1px black solid; font-size: 8pt; height: 20px;"> 
      </td>
    </tr>
    <tr> 
      <td class="main" style="border-bottom: solid #2D649B 1px;"><b>Amount per 
        week :</b><br>
        จำนวนครั้งที่สอนต่อ 1 สัปดาห์</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 1px; "><input type="Text" name="occasion" size="2"  maxlength="2" value="<? if($occasion!=0){ echo $occasion; } ?>" style="border: 1px black solid; font-size: 8pt; height: 20px;"></td>
    </tr>
    <tr tr bgcolor="<? echo $bgcolor; ?>"> 
      <td class="main" style="border-bottom: solid #2D649B 1px;"><b>Day in week 
        :</b><br>
        วันที่สอนใน 1 สัปดาห์</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 1px; "> 
        <input type="checkbox" name="day[ ]" value="1" <? if (strstr($day, '1') != "") echo checked;?> class="r-button">
        Sun 
        <input type="checkbox" name="day[ ]" value="2" <? if (strstr($day, '2') != "") echo checked;?> class="r-button">
        Mon 
        <input type="checkbox" name="day[ ]" value="3" <? if (strstr($day, '3') != "") echo checked;?> class="r-button">
        Tue 
        <input type="checkbox" name="day[ ]" value="4" <? if (strstr($day, '4') != "") echo checked;?> class="r-button">
        Wed 
        <input type="checkbox" name="day[ ]" value="5" <? if (strstr($day, '5') != "") echo checked;?> class="r-button">
        Thu 
        <input type="checkbox" name="day[ ]" value="6" <? if (strstr($day, '6') != "") echo checked;?> class="r-button">
        Fri 
        <input type="checkbox" name="day[ ]" value="7" <? if (strstr($day, '7') != "") echo checked;?> class="r-button">
        Sat </td>
    </tr>
    <tr> 
      <td class="main" style="border-bottom: solid #2D649B 1px;"><b>Start Time 
        : <br>
        </b>เวลาเริ่มต้นการสอน</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 1px; "> 
        &nbsp; <select  class="pn-text" name="s_hr">
          <option value="00" <? if ($start_hour == '00') { echo "selected";}?>>00</option>
          <option value="01" <? if ($start_hour == '01') { echo "selected";}?>>01</option>
          <option value="02" <? if ($start_hour == '02') { echo "selected";}?>>02</option>
          <option value="03" <? if ($start_hour == '03') { echo "selected";}?>>03</option>
          <option value="04" <? if ($start_hour == '04') { echo "selected";}?>>04</option>
          <option value="05" <? if ($start_hour == '05') { echo "selected";}?>>05</option>
          <option value="06" <? if ($start_hour == '06') { echo "selected";}?>>06</option>
          <option value="07" <? if ($start_hour == '07') { echo "selected";}?>>07</option>
          <option value="08" <? if ($start_hour == '08') { echo "selected";}?>>08</option>
          <option value="09" <? if ($start_hour == '09') { echo "selected";}?>>09</option>
          <option value="10" <? if ($start_hour == '10') { echo "selected";}?>>10</option>
          <option value="11" <? if ($start_hour == '11') { echo "selected";}?>>11</option>
          <option value="12" <? if ($start_hour == '12') { echo "selected";}?>>12</option>
          <option value="13" <? if ($start_hour == '13') { echo "selected";}?>>13</option>
          <option value="14" <? if ($start_hour == '14') { echo "selected";}?>>14</option>
          <option value="15" <? if ($start_hour == '15') { echo "selected";}?>>15</option>
          <option value="16" <? if ($start_hour == '16') { echo "selected";}?>>16</option>
          <option value="17" <? if ($start_hour == '17') { echo "selected";}?>>17</option>
          <option value="18" <? if ($start_hour == '18') { echo "selected";}?>>18</option>
          <option value="19" <? if ($start_hour == '19') { echo "selected";}?>>19</option>
          <option value="20" <? if ($start_hour == '20') { echo "selected";}?>>20</option>
          <option value="21" <? if ($start_hour == '21') { echo "selected";}?>>21</option>
          <option value="22" <? if ($start_hour == '22') { echo "selected";}?>>22</option>
          <option value="23" <? if ($start_hour == '23') { echo "selected";}?>>23</option>
        </select> <select name="s_mnt" class="pn-text">
          <option value="00" <? if ($start_min == '00') { echo "selected";}?>>00</option>
          <option value="10" <? if ($start_min == '10') { echo "selected";}?>>10</option>
          <option value="20" <? if ($start_min == '20') { echo "selected";}?>>20</option>
          <option value="30" <? if ($start_min == '30') { echo "selected";}?>>30</option>
          <option value="40" <? if ($start_min == '40') { echo "selected";}?>>40</option>
          <option value="50" <? if ($start_min == '50') { echo "selected";}?>>50</option>
        </select></td>
    </tr>
    <tr bgcolor="<? echo $bgcolor; ?>"> 
      <td class="main" style="border-bottom: solid #2D649B 1px;"><b>End Time : 
        <br>
        </b>เวลาสิ้นสุดการสอน</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 1px; "><select class="pn-text" name="e_hr">
          <option value="00" <? if ($end_hour == '00') { echo "selected";}?>>00</option>
          <option value="01" <? if ($end_hour == '01') { echo "selected";}?>>01</option>
          <option value="02" <? if ($end_hour == '02') { echo "selected";}?>>02</option>
          <option value="03" <? if ($end_hour == '03') { echo "selected";}?>>03</option>
          <option value="04" <? if ($end_hour == '04') { echo "selected";}?>>04</option>
          <option value="05" <? if ($end_hour == '05') { echo "selected";}?>>05</option>
          <option value="06" <? if ($end_hour == '06') { echo "selected";}?>>06</option>
          <option value="07" <? if ($end_hour == '07') { echo "selected";}?>>07</option>
          <option value="08" <? if ($end_hour == '08') { echo "selected";}?>>08</option>
          <option value="09" <? if ($end_hour == '09') { echo "selected";}?>>09</option>
          <option value="10" <? if ($end_hour == '10') { echo "selected";}?>>10</option>
          <option value="11" <? if ($end_hour == '11') { echo "selected";}?>>11</option>
          <option value="12" <? if ($end_hour == '12') { echo "selected";}?>>12</option>
          <option value="13" <? if ($end_hour == '13') { echo "selected";}?>>13</option>
          <option value="14" <? if ($end_hour == '14') { echo "selected";}?>>14</option>
          <option value="15" <? if ($end_hour == '15') { echo "selected";}?>>15</option>
          <option value="16" <? if ($end_hour == '16') { echo "selected";}?>>16</option>
          <option value="17" <? if ($end_hour == '17') { echo "selected";}?>>17</option>
          <option value="18" <? if ($end_hour == '18') { echo "selected";}?>>18</option>
          <option value="19" <? if ($end_hour == '19') { echo "selected";}?>>19</option>
          <option value="20" <? if ($end_hour == '20') { echo "selected";}?>>20</option>
          <option value="21" <? if ($end_hour == '21') { echo "selected";}?>>21</option>
          <option value="22" <? if ($end_hour == '22') { echo "selected";}?>>22</option>
          <option value="23" <? if ($end_hour == '23') { echo "selected";}?>>23</option>
        </select> <select name="e_mnt" class="pn-text">
          <option value="00" <? if ($end_min == '00') { echo "selected";}?>>00</option>
          <option value="10" <? if ($end_min == '10') { echo "selected";}?>>10</option>
          <option value="20" <? if ($end_min == '20') { echo "selected";}?>>20</option>
          <option value="30" <? if ($end_min == '30') { echo "selected";}?>>30</option>
          <option value="40" <? if ($end_min == '40') { echo "selected";}?>>40</option>
          <option value="50" <? if ($end_min == '50') { echo "selected";}?>>50</option>
        </select></td>
    </tr>
    <tr> 
      <td class="main" style="border-bottom: solid #2D649B 1px;"><b>Length of 
        Time : <br>
        </b>ระยะเวลาที่ใช้สอน</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 1px; "><select name="length" class="pn-text">
          <option value="0.25" class="small" <? if ($length == 0.25) { echo "selected";}?>>15min</option>
          <option value="0.50" class="small" <? if ($length == 0.50) { echo "selected";}?>>30min</option>
          <option value="0.75" class="small" <? if ($length == 0.75) { echo "selected";}?>>45min</option>
          <option value="1.00" class="small" <? if ($length == 1.00) { echo "selected";}?>>1hr</option>
          <option value="1.25" class="small" <? if ($length == 1.25) { echo "selected";}?>>1hr 
          15min</option>
          <option value="1.50" class="small" <? if ($length == 1.50) { echo "selected";}?>>1hr 
          30min</option>
          <option value="1.75" class="small" <? if ($length == 1.75) { echo "selected";}?>>1hr 
          45min</option>
          <option value="2.00" class="small" <? if ($length == 2.00) { echo "selected";}?>>2hr</option>
          <option value="2.25" class="small" <? if ($length == 2.25) { echo "selected";}?>>2hr 
          15min</option>
          <option value="2.50" class="small" <? if ($length == 2.50) { echo "selected";}?>>2hr 
          30min</option>
          <option value="2.75" class="small" <? if ($length == 2.75) { echo "selected";}?>>2hr 
          45min</option>
          <option value="3.00" class="small" <? if ($length == 3.00) { echo "selected";}?>>3hr</option>
          <option value="3.25" class="small" <? if ($length == 3.25) { echo "selected";}?>>3hr 
          15min</option>
          <option value="3.50" class="small" <? if ($length == 3.50) { echo "selected";}?>>3hr 
          30min</option>
          <option value="3.75" class="small" <? if ($length == 3.75) { echo "selected";}?>>3hr 
          45min</option>
          <option value="4.00" class="small" <? if ($length == 4.00) { echo "selected";}?>>4hr</option>
          <option value="4.25" class="small" <? if ($length == 4.25) { echo "selected";}?>>4hr 
          15min</option>
          <option value="4.50" class="small" <? if ($length == 4.50) { echo "selected";}?>>4 
          hr 30min</option>
          <option value="4.75" class="small" <? if ($length == 4.75) { echo "selected";}?>>4hr 
          45min</option>
          <option value="5.00" class="small" <? if ($length == 5.00) { echo "selected";}?>>5hr</option>
          <option value="5.25" class="small" <? if ($length == 5.25) { echo "selected";}?>>5hr 
          15min</option>
          <option value="5.50" class="small" <? if ($length == 5.50) { echo "selected";}?>>5hr 
          30min</option>
          <option value="5.75" class="small" <? if ($length == 5.75) { echo "selected";}?>>5hr 
          45min</option>
          <option value="6.00" class="small" <? if ($length == 6.00) { echo "selected";}?>>6hr</option>
          <option value="6.25" class="small" <? if ($length == 6.25) { echo "selected";}?>>6hr 
          15min</option>
          <option value="6.50" class="small" <? if ($length == 6.50) { echo "selected";}?>>6hr 
          30min</option>
          <option value="6.75" class="small" <? if ($length == 6.75) { echo "selected";}?>>6hr 
          45min</option>
          <option value="7.00" class="small" <? if ($length == 7.00) { echo "selected";}?>>7hr</option>
          <option value="7.25" class="small" <? if ($length == 7.25) { echo "selected";}?>>7hr 
          15min</option>
          <option value="7.50" class="small" <? if ($length == 7.50) { echo "selected";}?>>7hr 
          30min</option>
          <option value="7.75" class="small" <? if ($length == 7.75) { echo "selected";}?>>7hr 
          45min</option>
          <option value="8.00" class="small" <? if ($length == 8.00) { echo "selected";}?>>8hr</option>
          <option value="9.00" class="small" <? if ($length == 9.00) { echo "selected";}?>>All 
          day</option>
        </select></td>
    </tr>
    <tr bgcolor="<? echo $bgcolor; ?>"> 
      <td class="main" style="border-bottom: solid #2D649B 1px;"><b>Start Date 
        :<br>
        </b>วันที่เริ่มสอน</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 1px; "> 
        <input type="text" name="start_date" size="10" value="<? if($start_date!=0){ echo date("Y-m-d",$start_date); } ?>" onFocus="this.blur(); showCal('Date1')" style="border: 1px black solid; font-size: 8pt; height: 20px;"> 
        <a href="javascript:showCal('Date1')"><img src="calendar/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onMouseOut="window.status='';return true"  width="19" height="17" border="0"> 
        </a><span id="cal1" style="position:relative;"></td>
    </tr>
    <tr> 
      <td class="main" style="border-bottom: solid #2D649B 2px;"><b>Generate Data 
        : <br>
        </b>สร้างข้อมูลอัตโนมัติ</td>
      <td align="right" class="small" style="border-bottom: solid #2D649B 2px;"> 
        <input type="checkbox" name="calendar" value="1" <? if ($cal==1) { echo "checked"; }?> class="r-button">
        Calendar 
        <input type="checkbox" name="resources" value="1" <? if ($resources==1) { echo "checked"; }?> class="r-button">
        Resuorces&nbsp; </td>
    </tr>
    <tr bgcolor="#739FC4"> 
      <td colspan="2" class="main"><input type="Submit" name="s1" value="Save Preferences"> 
        <input name="Reset" type="Reset"></td>
    </tr>
    <input type="Hidden" name="u_check" value="1">
    <input type="Hidden" name="courses" value="<? echo $c_id; ?>">
    <? if($s_id!="")
					{           ?>
    <input type="Hidden" name="update" value="<? echo $s_id ?>">
    <? }else{  ?>
    <input type="Hidden" name="update" value="0">
    <?
											  }  ?>
  </form>
</table>
				</body>
				</html>
<?  }else{  
			if ($s1) {
				if (count($day) != 0) {
					while (list($key,$value) = each($day)) { 									
						$day_add = $value;
						$day_sum .= $value;
						if ($key == 0)
						{							
							$date_s = $start_date;
							$_stringArray = explode("-", $date_s);
							$_date = mktime(0,0,0,$_stringArray[1],$_stringArray[2],$_stringArray[0]);											
							$add = compareDay(dayOfWeek($_date),$day_add);
							$_date = mktime(0,0,0,$_stringArray[1],$_stringArray[2]+$add,$_stringArray[0]);																												
							$date_each_day[ ] = date("Y-m-d", $_date);
						} else {						
							$date_s = $start_date;
							$_stringArray = explode("-", $date_s);
							$_date = mktime(0,0,0,$_stringArray[1],$_stringArray[2],$_stringArray[0]);						
							$add = compareDay(dayOfWeek($_date),$day_add);
							$_date = mktime(0,0,0,$_stringArray[1],$_stringArray[2]+$add,$_stringArray[0]);							
							$date_each_day[ ] = date("Y-m-d", $_date);												
						}
					}
				}			
				$total = strlen($day_sum);
				//echo "loop : ".ceil($weeks/$total)."<br>";
                if($start_date=="")
                {           
					$in_date=0;
                }else{
                            $date_parts = explode("-",$start_date);
                            if($date_parts[0]<1990)
                             {   $years=1900+$date_parts[0];
                             }else{
                                 $years=$date_parts[0];
			                 }
							$in_date=mktime(0,0,0,$date_parts[1],$date_parts[2],$years);
                }
				$s_prefs = mysql_query("SELECT * FROM syllabus_prefs WHERE courses=$courses;");
                if(mysql_num_rows($s_prefs)!=0)
                 {       $row_p=mysql_fetch_array($s_prefs);
				 				$s_id = $row_p["id"];
                                $r_weeks = $row_p["weeks"];
								$start_date = $row_p["start_date"];  
								$start_hour = $row_p["start_hour"];
								$start_min = $row_p["start_min"];
								$end_hour = $row_p["end_hour"];
								$end_min = $rowP["end_min"];              
								$hour = $row_p["start_hour"];
								$hour .= ".".$row_p["start_min"]."-";
								$hour .= $row_p["end_hour"].".".$row_p["end_min"];;
                                $exist=1;
                }
				
				//if ($weeks != $r_weeks){
					$syllabus = mysql_query("SELECT topic FROM syllabus_activity where courses = $courses order by id");
					$k=0;
					
					while ($row_syllabus = mysql_fetch_array($syllabus)){
					     $topics[$k] = $row_syllabus["topic"];
						 $k++;
					}									
					
					mysql_query("DELETE FROM syllabus_activity where courses = $courses");
					$i=0;
					$j=0;
					$l=0;
					$hour = $s_hr.":".$s_mnt."-".$e_hr.":".$e_mnt;
					while($i<$weeks) 
					{
						if ($j >= $total) {
							$j=0;
						}
						
						//echo $topics["$l"]."<br>";
						
						/*
						//$start_date = date("Y-m-d", $start_date);
						//$new_date = $start_date;
						//$new_date = gen_date_int($new_date);	
						*/
						
						//$date_each_day[$j] = date("Y-m-d", $date_each_day[$j]);
						
						//$new_date = $date_each_day[$j];
						//$new_date = gen_date_int($new_date);
						
						//echo "Day of Week :".dayOfWeek($new_date)."<br>";	
						
						insert_syllabus_activity($courses,gen_date_int($date_each_day[$j]),$hour,$topics["$l"]);  
						
						//echo "Date each day : ".$date_each_day[$j]."<br>";
						//$new_date = gen_date_int($date_each_day[$j]);
						//echo $new_date."<br>";
						//echo date("Y-m-d", $new_date)."<br>";						

						/*
						$stringArray = explode("-", $start_date);		
						$start_date = mktime(0,0,0,$stringArray[1],$stringArray[2]+7,$stringArray[0]);						
						*/
						$stringArray = explode("-", $date_each_day[$j]);		
						$_date2 = mktime(0,0,0,$stringArray[1],$stringArray[2]+7,$stringArray[0]);
						$date_each_day[$j] = date("Y-m-d", $_date2);
						
						$j++;						
						$i++;
						$l++;						
					}
				//}		
				if ($calendar == "")
				{
					$calendar =0;
				}
				if ($resources == "")
				{
					$resources =0;
				}		
                if($update!=0)
                {   					  
                     $sql = "UPDATE syllabus_prefs SET weeks=$weeks, occasion=$occasion, day='".$day_sum."',start_date='".$in_date."', start_hour='".$s_hr."' , start_min='".$s_mnt."' , end_hour='".$e_hr."' , end_min='".$e_mnt."',length=$length,calendar=$calendar,resources=$resources WHERE id=$update;";
                }else{      					  
					 $sql = "INSERT INTO syllabus_prefs (courses,weeks,occasion,day,start_date,start_hour,start_min,end_hour,end_min,length,calendar,resources) VALUES ($courses,$weeks,$occasion,'".$day_sum."','".$in_date."','".$s_hr."','".$s_mnt."','".$e_hr."','".$e_mnt."',$length,$calendar,$resources);";
				}   
				mysql_query($sql);
				
				
				
				header("Status: 302 Moved Temporarily");
				header("Location:  edit.php?courses=".$courses);				
				exit;				
				
				
				
        	 }
		 } // $s1
		  if($submit_file)
              {
			 	mysql_query("INSERT INTO syllabus(id, courses, new_window) VALUES('', $courses, $file_target);"); 
				$path="../files/syllabus/$courses";
				if(!(@opendir($path)))
					mkdir ("$path", 0777);
								  
				   $res=mysql_query("SELECT syllabus_upload FROM syllabus where courses=$courses;");				   
				   $checkfile=@mysql_fetch_array($res);
					 if(trim($uploadedFile)=="" ||  $uploadedFile == none)
					 {
							if(mysql_num_rows($res)>=1)
								{	
										mysql_query("UPDATE syllabus SET new_window=$file_target  WHERE courses=$courses;"); 								
										print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
										print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
								}
							else
							{	// no syllabus info in database
								mysql_query("INSERT INTO syllabus(id, courses, new_window) VALUES('', $courses, $file_target);"); 
								print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");								
							}
					 }
					 else
						{ // User input uploadedFile
							 if(strtolower($uploadedFile_type)=="application/pdf" || strtolower($uploadedFile_type)=="application/msword")
							 {
							 	// rename uploadedFile
								$sql="select now()+0 as current";
								$result=mysql_query($sql);
								$row1=mysql_fetch_array($result);

								$typeFile=$uploadedFile_name;		//return filename as Sample.gif
								$pos = strrpos($typeFile, ".");
								$rest = substr($typeFile, $pos+1);
								
								$new_uploadedFile=$row1["current"].".".$rest;
								
								if(mysql_num_rows($res)==0)
								{   
									if(move_uploaded_file($HTTP_POST_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
										{
											mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
											print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
											print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
										}
									else
										print( "<script language=javascript> alert(\"Can not upload syllabus file. Try again.\"); </script>");
								}			   			
								else
								{	if($checkfile["newuploadfilename"]!="" && $checkfile["newuploadfilename"]!=none)
									{	
										if(file_exists($path."/".$checkfile["newuploadfilename"]))
										{	
											print($path."/".$checkfile["newuploadfilename"]);
											unlink($path."/".$checkfile["newuploadfilename"]);
										 }
									}
											if(move_uploaded_file($HTTP_POST_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
											{
												//mysql_query("UPDATE syllabus SET syllabus_upload=\"$path/$uploadedFile_name\"  WHERE courses=$courses;"); 
												mysql_query("UPDATE syllabus SET syllabus_upload=\"$uploadedFile_name\", new_window=\"$file_target\", 
															newuploadfilename=\"$new_uploadedFile\" WHERE courses=$courses;"); 
											} // end if copy
									
								} // end else
								print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
							} // check type file
							else
							{ 
								print( "<script language=javascript> alert(\"Wrong type of  syllabus.\"); </script>");	  
							}
						}  //end if upload..
				  } // end if else
}else{      
$creator = mysql_result($checkuser,0,"firstname")."&nbsp;".mysql_result($checkuser,0,"surname");  
?>
<html>
<head>
<LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
<title></title>
</head>
<body bgcolor="#ffffff">
        <p>&nbsp;</p>
        <div class="h5" align="center">Sorry, you can't edit this quiz. It can only be edited by it's creator (<i><? echo $creator; ?></i>)</div>
</body>
</html>
<?    }     ?>