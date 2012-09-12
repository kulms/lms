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
<link rel="STYLESHEET" type="text/css" href="../main.css">
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
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

//  SOAP Request
//echo $course_id;
//echo $_POST['course_id'];
$check_course=mysql_query("SELECT * FROM ku_courses WHERE  CS_CODE = '$course_id' AND COURSE_YR='$year';");
  if(mysql_num_rows($check_course)==0){


  if($_POST['course_id'] || $_POST['semester'] || $_POST['year'])
	{
		require_once('../nusoap/nusoap.php');
		$client = new soapclient('https://portal.ku.ac.th/cpestj/nusoap-kaset-oracle-server.php');
		//$client = new soapclient('http://localhost/nusoap/nusoap-kaset-oracle-server.php');

				
		$params = array('cs_code' => $_POST['course_id'],  
               							  'semester' => $_POST['semester'] ,
										  'year' => $_POST['year'] 
             						     ); 	
			
		if($_POST['course_id'])
		{
			$response = $client->call('getKuCourses', $params);
		}
		
		if($client->fault)
		{
			print "ERROR! ".$client->faultstring."\n";
		}
		else
		{
			if($response)
			{
				print "<br><table border='0' class='std' cellpadding=\"2\" cellspacing=\"1\" width=\"60%\" align=\"center\">\n";
				print "<tr>
								<th>COURSE ID</th><th>COURSE NAME</th>
							</tr>\n";
				$i=0;			
				foreach($response[0] as $res_row)							
				{					
					$sql = "INSERT INTO ku_courses (CS_CODE, COURSE_NAME,COURSE_YR, B_CRE_LEC, B_CRE_LAB) VALUES ('".$res_row['cs_code']."', '".$res_row['course_name']."', ".$res_row['sm_yr'].", ".$res_row['b_cre_lec'].", ".$res_row['b_cre_lab'].");"; 
					//echo $sql;
					mysql_query($sql);
					
					print "<tr>\n
									<td class=\"hilite\">".$res_row['cs_code']."</td>\n
									<td class=\"hilite\">".$res_row['course_name']."</td>\n									
								</tr>\n	
							 ";						 
					$i++;		 
				}
				print "</table>\n<br>";
				//echo $i;
				
				//echo '<xmp>' . $client->request . '</xmp>';
				//echo '<xmp>' . $client->response . '</xmp>';
			}
			else
			{
				print "NO MATCHES found !\n";
			}
		}
	}
	// End SOAP

	/*
	 //  SOAP Request
		  if($_POST['course_id'] || $_POST['semester'] || $_POST['year'])
			{
				//require_once('../nusoap/nusoap.php');
				//$client = new soapclient('http://localhost/nusoap/nusoap-kaset-server.php');
						
		//		$params = array('cs_code' => $_POST['course_id'],  
		//										  'semester' => $_POST['semester'] ,
		//										  'year' => $_POST['year'] 
		//										 ); 	
					
				if($_POST['course_id'])
				{
					$response = $client->call('getKuRegisters', $params);
				}
				
				if($client->fault)
				{
					print "ERROR! ".$client->faultstring."\n";
				}
				else
				{
					if($response)
					{
						print "<table border='0' class='std' cellpadding=\"2\" cellspacing=\"1\" width=\"60%\" align=\"center\">\n";
						print "<tr>
										<th>STD_ID</th><th>SM_SEM</th><th>SM_YEAR</th><th>RG_TYPE</th><th>CS_CODE</th><th>LC_SECTION</th>
									</tr>\n";
						$i=0;			
						foreach($response[0] as $res_row)			
						{
							//$sql = "INSERT INTO author_book (title, author, isbn) VALUES ('".$res_row['book_title']."', '".$res_row['author_name']."', '".$res_row['book_isbn']."');";		
							//mysql_connect("localhost", "root", "");
							//mysql_select_db('maxlearn');
							//mysql_query($sql);
							$sql = "INSERT INTO ku_classlist (STD_ID, SM_SEM, SM_YR, RG_TYPE, CS_CODE, LC_SECTION, LC_CREDIT, LB_SECTION, LB_CREDIT, TT_CREDIT) VALUES (".$res_row['std_id'].", ".$res_row['sm_sem'].", ".$res_row['sm_yr'].", '".$res_row['rg_type']."', '".$res_row['cs_code']."', '".$res_row['lc_section']."', ".$res_row['lc_credit'].", '".$res_row['lb_section']."',".$res_row['lb_credit'].", ".$res_row['tt_credit'].");"; 
							mysql_query($sql);
							print "<tr>\n
											<td class=\"hilite\">".$res_row['std_id']."</td>\n
											<td class=\"hilite\">".$res_row['sm_sem']."</td>\n
											<td class=\"hilite\">".$res_row['sm_yr']."</td>\n
											<td class=\"hilite\">".$res_row['rg_type']."</td>\n
											<td class=\"hilite\">".$res_row['cs_code']."</td>\n
											<td class=\"hilite\">".$res_row['lc_section']."</td>\n
										</tr>\n	
									 ";						 
							$i++;		 
						}
						print "</table>\n<br>";
						//echo $i;
						
						//echo '<xmp>' . $client->request . '</xmp>';
						//echo '<xmp>' . $client->response . '</xmp>';
					}
					else
					{
						print "NO MATCHES found !\n";
					}
				}
			}
			// End SOAP
			
			 //  SOAP Request
		  if($_POST['course_id'] || $_POST['semester'] || $_POST['year'])
			{
				//require_once('../nusoap/nusoap.php');
				//$client = new soapclient('http://localhost/nusoap/nusoap-kaset-server.php');
						
			//	$params = array('cs_code' => $_POST['course_id'],  
			//									  'semester' => $_POST['semester'] ,
			//									  'year' => $_POST['year'] 
			//									 ); 	
					
				if($_POST['course_id'])
				{
					$response = $client->call('getKuStudents', $params);
				}
				
				if($client->fault)
				{
					print "ERROR! ".$client->faultstring."\n";
				}
				else
				{
					if($response)
					{
						
											
						print "<table border='0' class='std' cellpadding=\"2\" cellspacing=\"1\" width=\"60%\" align=\"center\">\n";
						print "<tr>
										<th>STD_ID</th><th>STD_TITLE</th><th>STD_NAME</th><th>STD_SURNAME</th><th>MAJOR_ID</th>
									</tr>\n";
						$i=0;
						
						foreach($response[0] as $res_row)			
						{
							//$sql = "INSERT INTO author_book (title, author, isbn) VALUES ('".$res_row['book_title']."', '".$res_row['author_name']."', '".$res_row['book_isbn']."');";		
							//mysql_connect("localhost", "root", "");
							//mysql_select_db('maxlearn');
							//mysql_query($sql);
							
							$check_student=mysql_query("SELECT * FROM ku_student WHERE  STD_ID = ".$res_row['std_id'].";");
							
						  	if(mysql_num_rows($check_student) == 0){
								$idcode = $res_row['idcode'];	
								if ($idcode == '') { $idcode = 0; }											
						  		$sql = "INSERT INTO ku_student (STD_ID, STD_TITLE, STD_NAME, STD_SURNAME, MAJOR_ID, ADVISOR_ID, CAMPUS_ID, STD_SEX, IDCODE) VALUES (".$res_row['std_id'].", '".$res_row['std_title']."', '".$res_row['std_name']."', '".$res_row['std_surname']."', '".$res_row['major_id']."', '".$res_row['advisor_id']."', '".$res_row['campus_id']."', '".$res_row['std_sex']."',".$idcode.");"; 
								//echo $sql."<br>";
								mysql_query($sql);		
						  	}
							else {
							//echo $res_row['std_id']."not insert <br>";
							}
							
							//else
							//{
							//	$sql = "INSERT INTO ku_student (STD_ID, STD_TITLE, STD_NAME, STD_SURNAME, MAJOR_ID, ADVISOR_ID, CAMPUS_ID, STD_SEX, IDCODE) VALUES (".$res_row['std_id'].", '".$res_row['std_title']."', '".$res_row['std_name']."', '".$res_row['std_surname']."', '".$res_row['major_id']."', '".$res_row['advisor_id']."', '".$res_row['campus_id']."', '".$res_row['std_sex']."',".$res_row['idcode'].");"; 
							//	mysql_query($sql);		
							//}
							
							//$sql = "INSERT INTO ku_student (STD_ID, STD_TITLE, STD_NAME, STD_SURNAME, MAJOR_ID, ADVISOR_ID, CAMPUS_ID, STD_SEX, IDCODE) VALUES (".$res_row['std_id'].", '".$res_row['std_title']."', '".$res_row['std_name']."', '".$res_row['std_surname']."', '".$res_row['major_id']."', '".$res_row['advisor_id']."', '".$res_row['campus_id']."', '".$res_row['std_sex']."',".$res_row['idcode'].");"; 
							//mysql_query($sql);		
							
							print "<tr>\n
											<td class=\"hilite\">".$res_row['std_id']."</td>\n
											<td class=\"hilite\">".$res_row['std_title']."</td>\n
											<td class=\"hilite\">".$res_row['std_name']."</td>\n
											<td class=\"hilite\">".$res_row['std_surname']."</td>\n
											<td class=\"hilite\">".$res_row['major_id']."</td>\n											
										</tr>\n	
									 ";						 
							$i++;		 
							
						}
						print "</table>\n<br>";
						//echo $i;
						//echo '<xmp>' . $client->request . '</xmp>';
						//echo '<xmp>' . $client->response . '</xmp>';
						
					}
					else
					{
						print "NO MATCHES found !\n";
					}
				}
			}
			// End SOAP
	*/		
}		
		
  $kusql=mysql_query("SELECT * FROM ku_courses WHERE  CS_CODE = '$course_id' AND COURSE_YR='$year';");
  if(mysql_num_rows($kusql)==1){
  	$kurow=mysql_fetch_array($kusql);
  }
  
        ?>
		
		
  <form action="create_form_3.php" method="post" name="course">
    <input type="hidden" name="courses" value="0">
	<input name="year" type="hidden" value="<? echo $year;?>">
	<input name="semester" type="hidden" value="<? echo $semester;?>"> 
	<input name="stype" type="hidden" value="<? echo $stype;?>">
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="1" class="std">

    <tr> 
      <td colspan="2"  align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td width="28%"  align="right" class="hilite">Course created by/ อ.ประจำวิชา:</td>
      <td width="72%" align="left"  class="hilite"><b><?php echo $person["title"].$person["firstname"]." ".$person["surname"]; ?></b> 
      </td>
    </tr>
    <tr> 
      <td class="hilite" align="right" >Course ID/รหัสวิชา:</td>
      <td class="hilite"> <input type="text" name="name" size="15" maxlength="10" class="text" value="<?php echo $course_id; ?>"> 
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
      <td align="right"> 
        <input type="submit" value="Next &gt;&gt;" class="button"> </td>
    </tr>

</table>

  </form>        
<br>
<?php 

 $getcourse=mysql_query("SELECT  *	 FROM courses WHERE name ='$course_id' AND year='$year' ;");
if( mysql_num_rows($getcourse) >0){
?>
<table width="90%" border="0" cellspacing="1" cellpadding="4"  align="center" class="std">
  <tr> 
    <td colspan="5"> <div align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"> 
        <b><font color="#FF0000"><img src="../images/warning.gif" width="14" height="14"> 
        Existing course / ชื่อรหัสวิชาที่เหมือนกันและเปิดใช้งานอยู่แล้ว ณ ขณะนี้</font> 
        <font color="#FF0000"><img src="../images/warning.gif" width="14" height="14"></font> 
        </b></font></div></td>
  </tr>
  <tr> 
    <th><div align="center" >Course ID</div></th>
    <th><div align="center" width="5%" >Section</div></th>
    <th><div align="center" >Course Name</div></th>
    <th><div align="center">Course Administrator</div></th>
     <th><div align="center" width="6%" >Status</div></th>
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
    <td class="hilite" align="center"><? echo $row["name"]; ?></td>
    <td class="hilite" align="center" width="5%"> 
      <? if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?>
    </td>
    <td class="hilite" align="center"><? echo $row["fullname"]; ?></td>
    <? $result=mysql_query("SELECT firstname,surname,email ,title FROM users WHERE id=".$row["users"].";"); ?>
    <td class="hilite" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>"> 
      <?
      echo @mysql_result($result,0,"title").@mysql_result($result,0,"firstname"); 
	  if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){
      	echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   }else{   	echo @mysql_result($result,0,"surname"); }  ?>
      </a> </td>
    <td class="hilite" align="center" width="5%">
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