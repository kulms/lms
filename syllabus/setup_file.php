<?    
session_start();
$session_id = session_id();
require ("../include/global_login.php");
require("../include/online.php");
require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );
	
$user = UserStorage::lookupById($person["login"]);

$filepath = "/data/httpd_course/files";

//session_register( 'user' ); 
$_SESSION['user'] = $user;

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
                        <LINK REL=STYLESHEET TYPE="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
						
						<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />
						<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
                <meta http-equiv="Content-Type" content="text/html; charset=tis-620">				
				</head>
				<script language="javascript">
				function delIt(id) {
					if (confirm( "doDelete this Syllabus File ?" )) {
						document.location="deletesyllabus.php?courses="+id;	}
				}
				</script>

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
<div align="center" class="main">
<form name="form1" method="post" action="setup_file.php" enctype="multipart/form-data" onSubmit="return checkFields(this.uploadedFile)">
    <table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr align="center"> 
        <td colspan="2" class="tdtopbot-color"  ><strong>Syllabus 
          Upload File for <? echo $CourseName; ?></strong><br>
		  นำเข้าแฟ้มข้อมูลแผนการสอน
		  </td>
      </tr>
      <tr> 
        <td width="48%" class="main" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="22%"><b>Course ID </b>: <br>
                รหัสวิชา </td>
              <td width="23%" valign="top"><? echo $CourseName; ?></td>
              <td width="22%"><b>Section</b>:<br>
                หมูการเรียน </td>
              <td width="33%" valign="top"><? echo $Section; ?></td>
            </tr>
          </table>          
        </td>
        <td width="52%" align="left" class="main">&nbsp;</td>
      </tr>
      <tr > 
        <td class="tdtopbot-color" ><b>Syllabus 
          file: </b><br>
		  แฟ้มข้อมูลแผนการเรียน
		</td>
        <td height="46"  class="tdtopbot-color" > 
          <input name="uploadedFile" type="file" id="uploadedFile" value="" class="button" style="width:270px"> <br>
          <b><font color="#69012E">***File 
          type <span class="hilite"><img src="msword.gif" width="20" height="20" border="0">(Microsoft Word)</span>/<span class="hilite"><img src="pdf.gif" width="18" height="18" border="0"></span>(pdf)***</font></b> <br>
          <?php   
				if(($row_syllabus["syllabus_upload"]!="")&&($row_syllabus["syllabus_upload"]!=none))
				{	echo " Current File : "; ?>
          <a href="<? echo 	"../files/syllabus/$courses/".$row_syllabus["newuploadfilename"];?>" target="<? echo "_blank"; ?>"> 
          <? 		//	echo $row["syllabus_upload"]."</a>";
					echo $row_syllabus["syllabus_upload"]; ?>
          </a> 
          <?		echo "  [ "; ?>
          <a href="javascript:delIt(<? echo $courses;?>)">  <? echo "Delete syllabus file</a> ] ";
				}
	 	?> </a><br>
          <font color="#990000"><strong>ชื่อ File ต้องเป็นภาษาอังกฤษ</strong></font></td>
      </tr>
      <tr> 
        <td class="main" ><strong>Show 
          Type in:</strong><br>
		  ชนิดการแสดงผล
		</td>
        <td class="main" > <table width="200">
            <tr> 
              <td class="main" ><label> 
                <input type="radio" name="file_target" value="0" <? if($row_syllabus["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                Show file in same window<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;แสดงในหน้าต่างเดียวกัน 
                </label></td>
            </tr>
            <tr> 
              <td class="main" ><label> 
                <input name="file_target" type="radio" value="1" <? if($row_syllabus["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                Show file in new window<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;แสดงในหน้าต่างใหม่</label></td>
            </tr>
          </table></td>
      </tr>
      <tr class="boxcolor1"> 
        <td  > 
		   <input type="submit" name="submit_file" value="<?php echo $strSave;?>" class="button">
          <input type="Hidden" name="courses" value="<? echo $c_id; ?>">
		 </td>		 
        <td   align="right"> 
          <input class="button" type="button" name="cancel" value="<?php echo $strCancel;?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?courses=<? echo $courses;?>';}" />
        </td>
      </tr>
    </table>
	</form>
  <br>
</div>				
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
				//$path="../files/syllabus/$courses";
				$path=$filepath."/syllabus/".$courses;
				//echo $path;
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
							 if(strtolower($uploadedFile_type)=="application/pdf" || strtolower($uploadedFile_type)=="application/msword" || strtolower($uploadedFile_type)=="application/vnd.openxmlformats-officedocument.wordprocessingml.document")
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
									if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
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
											if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
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