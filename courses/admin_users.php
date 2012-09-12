<?php   		
	session_start();
	$session_id = session_id();		

	require ("../include/global_login.php");

	require("../include/online.php");
	online_courses($session_id,$person["id"],$courses,time(),1); 
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

    $check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=".$courses." AND admin=1;");
if($person["admin"]==1 || (mysql_num_rows($check)!=0 && $courses!=0))
{
 if($update!="true")
   {        if($courses==0)
            {                       
				$course["id"]=0;
				$course["name"]="";
				$course["active"]=1;
				$course["applyopen"]=1;
				$course["info"]="";
				$course["users"]=$person["id"];
        	}else{        
				$check=mysql_query("SELECT * FROM courses WHERE id=$courses;");
                $course=mysql_fetch_array($check);
            }
?>
	<html>
        <head>
                <title>Course On Web  - Courses</title>
        <script language="javascript">
        function startup()
        {                
			document.course.elements["courseusers[]"].options[0]=null;
			document.course.elements["users[]"].options[0]=null;
        }
		
        function addadmin()
        {   
			for(a=document.course.elements["users[]"].options.length-1;a>-1;a--)
			{     
				if(document.course.elements["users[]"].options[a].selected)
				{            
					document.course.elements["courseusers[]"].options[document.course.elements["courseusers[]"].options.length]=new Option(document.course.elements["users[]"].options[a].text,document.course.elements["users[]"].options[a].value);
					document.course.elements["users[]"].options[a]=null;
                }
            }
            mark_all();
        }
		
        function removeadmin()
		{     
			for(a=document.course.elements["courseusers[]"].options.length-1;a>-1;a--)
			{    
				if(document.course.elements["courseusers[]"].options[a].selected)
				{            
					document.course.elements["users[]"].options[document.course.elements["users[]"].options.length]=new Option(document.course.elements["courseusers[]"].options[a].text,document.course.elements["courseusers[]"].options[a].value);
					document.course.elements["courseusers[]"].options[a]=null;
				}
			}
			mark_all();
		}
		
        function mark_all()
        {                
			for(a=0;a<document.course.elements["courseusers[]"].options.length;a++)
            {                
				document.course.elements["courseusers[]"].options[a].selected=true;
            }
        }
		
        function sendform()
        {                
			mark_all();
            if(confirm('Make sure that all the members are selected (highlighted) in the memberslist.\nOK to send?'))
			{
				document.course.update.value = "true";
				document.course.submit();
            }
        }
		
        function Closeform()
        {
			window.opener.location.reload();
			window.close();
        }
        </script>
       <!-- <link rel="STYLESHEET" type="text/css" href="../main.css">
		<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />
		<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
		<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
        <meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
        <body bgcolor="#ffffff"<?php   if($search_member)  echo "onLoad=\"startup()\"";  ?>>
		<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
		  <tr>					
			<td class="menu" align="center"><b><?php echo $strCourses_LabEditCourseMembers;?></b></td>
		  </tr>
	   </table>
		<br>
		<table border="0" cellpadding="5" cellspacing="0" align="center" class="tdborder2" width="60%">
		  <form action="admin_users.php" method="post" name="course">
			<input type="hidden" name="courses" value="<? echo $courses; ?>">
			<!--<input type="hidden" name="update" value="true"> -->
			<input type="hidden" name="update" value="false">
			<tr> 
			  
      <td  align="center" style="border-bottom: dotted  1px;" class="bordercolor" bgcolor="#FFFFFF"> 
        <?php  
					$check=mysql_query("SELECT * FROM users WHERE id=".$course["users"].";");
			  	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="47%" align="right" class="hilite"><strong>Course created by</strong> : 
              <br> ผู้สร้างรายวิชา
            </td>
            <td width="4%">&nbsp;</td>
            <td width="49%" valign="top"><b><? echo @mysql_result($check,0,"firstname")." ".@mysql_result($check,0,"surname");   ?></b></td>
          </tr>
        </table>
      </td>
			</tr>
			<tr> 
			  <td  align="center" style="border-bottom: dotted 1px;" class="bordercolor">&nbsp;
				<table border="0" width="80%">
				  <tr> 
					<td align="right" valign="middle" class="hilite"><b><?php echo $strCourses_LabSearch;?> :</b></td>
					<td align="left" valign="bottom" class="hilite"> 
					  <select name="searchCond" style="font-size:10px">
						<option value="all">----- All -----</option>
						<option value="login">Login</option>
						<option value="firstname">Firstname</option>
						<option value="surname">Surname</option>
					  </select></td>
				  </tr>
				  <tr> 
					<td width="45%" align="right" valign="middle" class="main"><b><?php echo $strCourses_LabSearchText;?> :</b></td>
					<td width="55%" align="left" valign="bottom"><input name="members" type="text" id="members" class="text"></td>
				  </tr>
				  <tr> 
					<td>&nbsp;</td>
					<td align="left" valign="top"><input name="search_member" type="submit" id="search_member" value="<?php echo $strSearch;?>" class="button"></td>
				  </tr>
				</table>
				&nbsp;</td>
			</tr>
			<tr> 
			  <td align="center" style="border-bottom: dotted 1px;" class="bordercolor"><table border="0" cellpadding="2" cellspacing="0">
				  <tr> 
					<td align="center" valign="top"> <b><?php echo $strCourses_LabCourseMember;?></b><br> 
					  <select multiple name="courseusers[]" size="15" class="pn-text" style="font-size:10px">
						<option value="0">---------------------------- 
						<?php   
							$users=mysql_query("SELECT id,login,firstname,surname 
												FROM users 
												WHERE active=1 
												ORDER BY firstname ASC,surname ASC;");						
							$c_member=mysql_query("SELECT DISTINCT u.id,u.login,u.firstname,u.surname 
												   FROM users u,wp 
												   WHERE u.active=1 and wp.courses=$courses and wp.users=u.id  and wp.admin=0
												   ORDER BY firstname ASC,surname ASC;");                
							$MemberID="";
							while($row=mysql_fetch_array($c_member))
							{
							?>
								<option value="<?php echo $row["id"]; ?>"><?php echo $row["firstname"]."_".$row["surname"]."_(".$row["login"].")";
								$MemberID.= " id != ".$row["id"]." AND ";
							}         
							?>
						</select> 
					</td>
					<td align="center"  valign="top"> 
					  <br> <br> <input type="button" value=" << " onClick="addadmin()" class="button"> 
					  <br> <br> <input type="button" value=" >> " onClick="removeadmin()" class="button"> 
					</td>
					<td align="center"  valign="top"> <b><?php echo $strCourses_LabOtherCourseMember;?></b><br> 
					  <select multiple name="users[]" size="15" class="pn-text" style="font-size:10px">
						<option value="0">---------------------------- 
						<?php        
						if(mysql_num_rows($c_member)!=0)
						{
							mysql_data_seek($c_member,0);
						}
						$mypos=0;
						if($search_member)
						{         
							$members = trim($members);
							$sql = "SELECT id,login,firstname,surname FROM users WHERE active=1 ";
							if($MemberID!="")
								$sql = $sql." AND ".substr($MemberID,0,strlen($MemberID)-4);
							if($searchCond!="all")
							{   
								$users=mysql_query($sql." AND ".$searchCond." LIKE '%$members%' ORDER BY firstname ASC,surname ASC;");
							}else{        
								$users=mysql_query($sql." AND  ( login LIKE '%$members%' OR firstname LIKE '%$members%' OR surname LIKE '%$members%' ) 
													ORDER BY firstname ASC,surname ASC;");
							}
									while($row=mysql_fetch_array($users))
									{                       
									  	$show=1;
										if($mypos<mysql_num_rows($c_member))
										{                
											if(mysql_result($c_member,$mypos,"id")==$row["id"])
											{
												$show=0;
												$mypos++;
											}
										}
										if($show==1)
										{      
							?>
							<option value="<?php echo $row["id"]; ?>">
							<?php
											echo $row["firstname"]."_".$row["surname"]."_(".$row["login"].")";
										}
									}
						}        // end  Search MEMBERS
						?>
					  </select> </td>
				  </tr>
				</table></td>
			</tr>
			<tr> 
			  <td align="left" class="hilite" valign="top"> 
			  <input type="button" value="<?php echo $strSave;?>" onClick="sendform()" class="button">
			  <input type="button"  value="<?php echo $strCancel;?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './users.php?courses=<? echo $courses;?>';}" class="button"> 
			  </td>
			</tr>
		  </form>
		</table>
        </body>
        </html>
<?php    
	// /*****Update is true *****/
     }else{          
	 	mysql_query("UPDATE wp SET temp=1 WHERE courses=$courses AND not users=0 AND users!= ".$person["id"].";");
		
		$checkc=mysql_query("SELECT * FROM courses WHERE id=$courses;");
        $row_c=mysql_fetch_array($checkc);
			
		$section_type = $row_c["section_type"];
		$section = $row_c["section"];
		$section= str_replace(" ", "", $section);
		$array = explode(",", $section);		
		
		if(count($array) > 1)
		{
			$str = "(";
			for($i=0; $i < count($array); $i++) 
			{
				if ($i !=0 ) {
					if($section_type == 1){
						$str .=  " OR LC_SECTION = ".$array[$i];
					} else {
						$str .=  " OR LB_SECTION = ".$array[$i];
					}
				} else {
					if($section_type == 1){
						$str .=  " LC_SECTION = ".$array[$i];
					} else {
						$str .=  " LB_SECTION = ".$array[$i];
					}
				}
			}
			$str .= ")";			
		} else {
			if($section_type == 1){
				$str = "LC_SECTION = ".$array[0];
			} else {
				$str = "LB_SECTION = ".$array[0];
			}	
		}
				
		$sql = "UPDATE ku_classlist SET temp=1 
				WHERE CS_CODE = '".$row_c["name"]."' 
					  AND SM_SEM = ".$row_c["semester"]." 
					  AND SM_YR  = ".$row_c["year"]."					  
					  AND ".$str."
					  ;";
		//echo $sql."<br>";
		mysql_query($sql);
		
        if(is_array($courseusers))
        {            
			while(list($key,$val)=each($courseusers))
			{            
				$check  = mysql_query("SELECT * FROM wp WHERE users=$val AND courses=$courses;");
				$checku = mysql_query("SELECT login FROM users WHERE id=$val;");
				$row_u = mysql_fetch_array($checku);
				$user_id = substr($row_u["login"],1,7);
				//echo $user_id."<br>";
				$std_list = mysql_query("SELECT STD_ID FROM ku_classlist WHERE CS_CODE='".$row_c["name"]."';");
				
								
				
				if(mysql_num_rows($check)!=0)
				{                        
					mysql_query("UPDATE wp SET temp=0 WHERE users=$val AND courses=$courses;");
					while($r_std = mysql_fetch_array($std_list)) {	
						if(substr($r_std["STD_ID"],0,7) == $user_id )
						{
							$sql = "UPDATE ku_classlist SET temp=0 
									WHERE CS_CODE = '".$row_c["name"]."' 
										  AND STD_ID = ".$r_std["STD_ID"]."	 
										  AND SM_SEM = ".$row_c["semester"]." 
										  AND SM_YR  = ".$row_c["year"]."					  
										  AND ".$str."
										  ;";
							//echo $sql."<br>";
							mysql_query($sql);
						}
					}
				}else{
					mysql_query("INSERT INTO wp (users,courses) VALUES($val,$courses);");					
					while($r_std = mysql_fetch_array($std_list)) {	
						if(substr($r_std["STD_ID"],0,7) == $user_id )
						{
							$sql = "UPDATE ku_classlist SET temp=0 
									WHERE CS_CODE = '".$row_c["name"]."' 
										  AND STD_ID = ".$r_std["STD_ID"]."	 
										  AND SM_SEM = ".$row_c["semester"]." 
										  AND SM_YR  = ".$row_c["year"]."					  
										  AND ".$str."
										  ;";
							//echo $sql."<br>";
							mysql_query($sql);
						}
					}
				}
			}			
        }       
		mysql_query("DELETE FROM wp WHERE courses=$courses AND temp=1 AND not users=0 AND users!= ".$person["id"].";");
		
		$sql = "DELETE FROM ku_classlist 
				WHERE CS_CODE = '".$row_c["name"]."' 
					  AND SM_SEM = ".$row_c["semester"]." 
					  AND SM_YR  = ".$row_c["year"]."					  
					  AND ".$str."
					  AND temp  = 1
					  ;";
		//echo $sql."<br>";
		mysql_query($sql);
		
        header("Status: 302 Moved Temporarily");      
        header("Location:  users.php?courses=".$courses);
     }   
	//  -------- End else update --------
//  /***** User don't have access to this script *****/
}else{  
?>
		<html>
        <head>
        <title></title>
        <link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
        </head>
        <body bgcolor="#ffffff">
        <p>&nbsp;</p>
        <div align="center" class="h3">Sorry, you are not permitted to create or edit a course!</div>
        </body>
        </html>
<?php              
}                     
?>