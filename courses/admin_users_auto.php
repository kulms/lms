<?php  	
		session_start();
		$session_id = session_id();		

		require ("../include/global_login.php");        
        include ("../include/control_win.js");
		require("../include/online.php");
		online_courses($session_id,$person["id"],$courses,time(),1); 
		require_once ("./classes/User.php");
		require_once ("./classes/UserStorage.php");
		require_once( "./includes/main_functions.php" );
			
		$user = UserStorage::lookupById($person["login"]);
		
		session_register( 'user' ); 		
		
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
		if($userid=="" || $userid==none)
		{                        
			$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
			$users_info=mysql_query("SELECT * from users_info WHERE id=".$person["id"]);
		}else{         
			$users=mysql_query("SELECT * from users WHERE id=$userid");
			$users_info=mysql_query("SELECT * from users_info WHERE id=$userid");
		}    
?>
<html><head><title>:-: Users :-:</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<script language="JavaScript">
function BrowserInfo()
{          this.screenWidth = screen.availWidth;
          this.screenHeight = screen.availHeight;
              // toolbar_height=toolbar.height;
             //  toolbar_width=toolbar.width;
}
</script>
<script language="javascript"> 
function display_picture(id) { 
	switch (id) { 
	case 1: 
		  document.all.area.innerHTML ="<img src=\"../images/loading.gif\">";
		  
		break; 
	case 2: 
		document.all.area.innerHTML ="<img src=\"../images/complete.gif\">";	  							  
		break; 
		} 
} 
</script> 
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
var checkflag = "false";
//var formObj = GetFormObj();

function check(field) {
	if (checkflag == "false") 
	{
		for (i = 0; i < field.length; i++) 
		{
			//field[i].checked = true;
			document.append.elements['students[]'][i].checked = true;
		}
	checkflag = "true";
	} else {
		for (i = 0; i < field.length; i++) 
		{
			//field[i].checked = false; 
			document.append.elements['students[]'][i].checked = false;
		}
		checkflag = "false";	
	}
}
//  End -->
</script>
<script>
var checkflag = "false";
function doNow()
{
  void(d=document.append);
  void(el=d.getElementsByTagName('INPUT'));
  if (checkflag == "false")  {
	  for(i=0;i<el.length;i++)
		void(el[i].checked=1) 
		checkflag = "true";
	} else {
		for(i=0;i<el.length;i++)
		 void(el[i].checked=0) 
		checkflag = "false";	
	}		
}
</script>
<script>
var checkdrop = "false";
function doDrop()
{
  void(d=document.drop);
  void(el=d.getElementsByTagName('INPUT'));
  if (checkdrop == "false")  {
	  for(i=0;i<el.length;i++)
		void(el[i].checked=1) 
		checkdrop = "true";
	} else {
		for(i=0;i<el.length;i++)
		 void(el[i].checked=0) 
		checkdrop = "false";	
	}		
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<div align="center">
<table cellpadding="1" cellspacing="0" bgcolor="#ffffff" width="90%">
        <tr>
              <td align="center">
			  <?php
	if( $groups=="" || $groups==none )
	{
			$Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.title,u.firstname,u.surname,u.email,uf.address,u.picture, u.lastlogin                                                                                                  
																									 FROM wp,users u , users_info uf
																									 WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.cases=0 AND wp.modules=0 AND wp.groups=0
																									 AND u.active=1 AND uf.id=u.id AND wp.admin = 0 ORDER BY u.login, wp.admin desc, u.category ");
	
			$course=mysql_query("SELECT * from courses where id=".$courses);
	
			// debug here
			if($person["id"] == @mysql_result($course,0,"users"))
					$course_admin = true;
			else
					$course_admin = false;
?>                
				<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" class="bg1" height="53">
				  <tr>
					
            <td class="menu" align="center"><b>Course Member<br>
              รายวิชา 
              <?php   echo @mysql_result($course,0,"name");
							 if (@mysql_result($course,0,"section") != "")
							   {    
				?>
              						(หมู่ <?php echo @mysql_result($course,0,"section"); ?>) 
              <?php  
			  					}   
			  ?>
              </b></td>
				  </tr>
			   </table>
<?   }else{
                $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.title,u.firstname,u.surname,u.email,uf.address,u.picture, u.lastlogin                                                                                                          
                                                                                                         FROM  wp,users u, users_info uf
                                                                                                         WHERE wp.users=u.id AND wp.groups=".$groups." AND wp.cases=0 AND wp.modules=0 AND wp.courses=0
                                                                                                         AND u.active=1 AND u.id=uf.id AND wp.admin = 0 ORDER BY u.login, wp.admin desc, u.category,u.login");
        		$group=mysql_query("SELECT * from groups where id=".$groups);
				$course=mysql_query("SELECT * from courses where id=".$courses);
?>
        <h1>
        <?php echo @mysql_result($group,0,"name"); ?>
        </h1>
<?
	}  
?>

<br>

        <table  cellpadding="2" cellspacing="1" class="tdborder2" width="100%">
          <tr bgcolor="#006600"> 
            <th width="22%" align="center" valign="top" class="Bcolor">Login</th>
            <th width="52%" align="center" valign="top" class="Bcolor">Name</th>            
            <th width="26%" align="center" valign="top" class="Bcolor">Last login</th>
          </tr>
          <?php 
		  	//echo mysql_num_rows($course);		  
while($row=mysql_fetch_array($Getlist))
{      $email=$row["email"];

        if($email_list!="")
                $email_list.=",";

        $email_list.=$email;
        $userlogin=$row["login"];
		$title=$row["title"];
        $firstname=$row["firstname"];
        $surname=$row["surname"];
        $address=$row["address"];        
		$lastlogin=$row["lastlogin"];		
		$userid=$row["id"];    
		?>
          <tr> 
            <td valign="top" class="hilite"><span class="hilite"><img src="../images/user2.gif"  border="0"> 
              <?php echo $userlogin; ?></span></td>
            <td valign="top" class="hilite"> <span class="hilite"> 
  		<?php          // debug here
							if($person["admin"]==1 || $course_admin)
							{          
		?>
								<a href="../personal/menu.php?userid=<? echo $userid; ?>"><? echo $title.$firstname." ".$surname; ?></a> 
  		<?php 
							}else{         
								echo  "&nbsp;".$firstname." ".$surname; 
							}			  							
   		?>
              <br>
              </span> 
			  </td>
            <td class="hilite" valign="top"> 
              <?php   
			  			  if($lastlogin==0)
                          {
							echo "Never logged in";
                          }else{
							echo date("d-m-Y H:i",$lastlogin);
						  }                
				?>
            </td>
          </tr>
          <? 		  
		  } // end while  Getlist
		  ?>
        </table>
        <br>
        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="tdborder2">
          <tr>
            <td width="12%" class="hilite"><b>Total</b></td>
            <td width="88%" class="hilite"><? echo mysql_num_rows($Getlist); ?> คน</td>
          </tr>
        </table>
	</td>
  </tr>
</table>
</div>
<div id="area" align="center"> 
</div>
<?php
		//=================================================================
		// Check Add New Member
		if($checks)
		{
			$name = @mysql_result($course,0,"name");
			//echo "Name :".$name."<br>";
			$year = @mysql_result($course,0,"year");
			//echo "Year :".$year."<br>";
			$semester = @mysql_result($course,0,"semester");
			//echo "Semester :".$semester."<br>";
			$section_type = @mysql_result($course,0,"section_type");
			//echo "Section Type :".$section_type."<br>";
			$section = @mysql_result($course,0,"section");
			$section= str_replace(" ", "", $section);
			$array = explode(",", $section);
			//echo "Array :".$array."<br>";
			//for($i=0; $i < count($array); $i++)
			//{
			
			//================================================================
			// Check Parameter before send to Web Services
			if($name == "" || $year == 0 || $semester == 0 || $section_type == 0 || !is_array($array)){
				print( "<script language=javascript> alert(\"Please check Course Detail such as \\n Course ID, Course Year, Course Semester, Section Type, Section .\"); </script>");
				print( "<meta http-equiv=\"refresh\" content=\"0;url=users.php?courses=$courses\">");
				exit();
			}
			//================================================================
				if(count($array) > 1)
				{
					$str = "(";
					for($i=0; $i < count($array); $i++) 
					{
						if ($i !=0 ) {
							if($section_type == 1)	{
								$str .=  " OR LC_SECTION = ".$array[$i];
								//$str .=  " OR LC_SECTION = ".$array[$i]." OR LB_SECTION = ".$array[$i];
							} else {
								$str .=  " OR LB_SECTION = ".$array[$i];
							}									
						} else {
							if($section_type == 1)	{
								$str .=  "LC_SECTION = ".$array[$i];
								//$str .=  "LC_SECTION = ".$array[$i]." OR LB_SECTION = ".$array[$i];
							} else {
								$str .=  "LB_SECTION = ".$array[$i];
							}	
						}
					}
					$str .= ")";			
				} else {
					if($section_type == 1)	{					
						$str = "LC_SECTION = ".$array[0];
						//$str = "LC_SECTION = ".$array[0]." OR LB_SECTION = ".$array[0];
					} else {
						$str = "LB_SECTION = ".$array[0];
					}	
				}
				//echo "Section :".$str."<br>";
				//$sql = "SELECT STD_ID FROM ku_classlist WHERE CS_CODE='$name' and  ".$str." ORDER BY STD_ID asc;";
				//echo $sql;
				$gsql=mysql_query("SELECT DISTINCT STD_ID FROM ku_classlist WHERE CS_CODE='$name' and SM_YR = $year AND SM_SEM =$semester and  ".$str." ORDER BY STD_ID asc;");
				//echo $array[$i];
				
				if(@mysql_num_rows($gsql) == 0)
				{
					print( "<script language=javascript> display_picture(1); </script>");
					require_once('../nusoap/nusoap.php');
					$client = new soapclient('https://portal.ku.ac.th/cpestj/nusoap-kaset-oracle-server.php');
					//$client = new soapclient('http://localhost/nusoap/nusoap-kaset-server.php');
										
					$params = array('cs_code' => $name,  
												  'section_type' => $section_type ,
												  'semester' => $semester ,
												  'year' => $year ,
												  'section' => $array
												 ); 	
							
						if($courses != "" || $courses == 0)
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
								
								//print "<table border='0' class='std' cellpadding=\"2\" cellspacing=\"1\" width=\"60%\" align=\"center\">\n";
								//print "<tr>
								//				<th>STD_ID</th><th>SM_SEM</th><th>SM_YEAR</th><th>RG_TYPE</th><th>CS_CODE</th><th>LC_SECTION</th>
								//			</tr>\n";
								$i=0;			
								foreach($response[0] as $res_row)			
								{		
									if(strlen($res_row['cs_code']) == 1){
										$cs_code = "00000".$res_row['cs_code'];
									}
									if(strlen($res_row['cs_code']) == 2){
										$cs_code = "0000".$res_row['cs_code'];
									}
									if(strlen($res_row['cs_code']) == 3){
										$cs_code = "000".$res_row['cs_code'];
									}
									if(strlen($res_row['cs_code']) == 4){
										$cs_code = "00".$res_row['cs_code'];
									}
									if(strlen($res_row['cs_code']) == 5){
										$cs_code = "0".$res_row['cs_code'];
									}
									if(strlen($res_row['cs_code']) == 6){
										$cs_code = $res_row['cs_code'];
									}	
														
									$sql = "INSERT INTO ku_classlist (STD_ID, SM_SEM, SM_YR, RG_TYPE, CS_CODE, LC_SECTION, LC_CREDIT, LB_SECTION, LB_CREDIT, TT_CREDIT) VALUES (".$res_row['std_id'].", ".$res_row['sm_sem'].", ".$res_row['sm_yr'].", '".$res_row['rg_type']."', '".$cs_code."', '".$res_row['lc_section']."', ".$res_row['lc_credit'].", '".$res_row['lb_section']."',".$res_row['lb_credit'].", ".$res_row['tt_credit'].");"; 
									mysql_query($sql);
									//print "<tr>\n
									//				<td class=\"hilite\">".$res_row['std_id']."</td>\n
									//				<td class=\"hilite\">".$res_row['sm_sem']."</td>\n
									//				<td class=\"hilite\">".$res_row['sm_yr']."</td>\n
									//				<td class=\"hilite\">".$res_row['rg_type']."</td>\n
									//			    <td class=\"hilite\">".$res_row['cs_code']."</td>\n
									//				<td class=\"hilite\">".$res_row['lc_section']."</td>\n
									//			</tr>\n
									//		 ";	
									$i++;
								}
								//print "</table>\n<br>";
								
								//echo '<xmp>' . $client->request . '</xmp>';
								//echo '<xmp>' . $client->response . '</xmp>';
							}
							else
							{
								print "NO MATCHES found !\n";
							}
						}
						//
						
						if($courses != "" || $courses == 0)
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
												<th>รหัสนิสิต</th><th>คำนำหน้าชื่อ</th><th>ชื่อ</th><th>นามสกุล</th><th>รหัสสาขาวิชา</th>
											</tr>\n";
								$i=0;
								
								foreach($response[0] as $res_row)			
								{
									
									$check_student=mysql_query("SELECT * FROM ku_student WHERE  STD_ID = ".$res_row['std_id'].";");
									
									if(mysql_num_rows($check_student) == 0){
										$idcode = $res_row['idcode'];	
										if ($idcode == '') { $idcode = 0; }											
										$sql = "INSERT INTO ku_student (STD_ID, STD_TITLE, STD_NAME, STD_SURNAME, MAJOR_ID, ADVISOR_ID, CAMPUS_ID, STD_SEX, IDCODE) VALUES (".$res_row['std_id'].", '".$res_row['std_title']."', '".$res_row['std_name']."', '".$res_row['std_surname']."', '".$res_row['major_id']."', '".$res_row['advisor_id']."', '".$res_row['campus_id']."', '".$res_row['std_sex']."',".$idcode.");"; 
										mysql_query($sql);		
									}
									else {
									//echo $res_row['std_id']."not insert <br>";
									}
									
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
								//echo '<xmp>' . $client->request . '</xmp>';
								//echo '<xmp>' . $client->response . '</xmp>';
								
							}
							else
							{
								print "NO MATCHES found !\n";
							}
						}
						print( "<script language=javascript> display_picture(2); </script>");						
						// Add Member to course
						for($i=0; $i < count($array); $i++)
						{
							$gsql=mysql_query("SELECT STD_ID FROM ku_classlist WHERE CS_CODE='$name'  and SM_YR = $year AND SM_SEM =$semester AND  ".$str." ORDER BY STD_ID asc;");
							while($row3=mysql_fetch_array($gsql))
							{
								$gsql2=mysql_query("SELECT distinct  * FROM ku_student	where STD_ID =".$row3["STD_ID"].";");
									if(mysql_num_rows($gsql2)==1)
									{
										$row4=mysql_fetch_array($gsql2);
										$major= substr($row4["MAJOR_ID"], 0,1);
										if($major=="X"){$std_title="g";}else{$std_title="b";}
										$s=substr($row4["STD_ID"],0,7);
										$login=$std_title.$s;
										$email=$login."@ku.ac.th";
										$check_ex=mysql_query("SELECT id FROM users WHERE login like '$login';");
										if(mysql_num_rows($check_ex)==0){
											if(
												mysql_query("INSERT INTO users (active,login,title,firstname,surname,password,category,email) values (1,'$login','".$row4["STD_TITLE"]."','".$row4["STD_NAME"]."','".$row4["STD_SURNAME"]."','asd323',3,'$email');"))
												{
													$got_id=mysql_insert_id();
													mysql_query("INSERT INTO users_info(id) values ($got_id);");
													//echo $got_id;
													// Must be check Exist in course but not be member user 
													mysql_query("INSERT INTO wp (courses,users) values($courses,$got_id);");
													//mysql_query("INSERT INTO wp (courses,users) values ('$courses','$got_id');");
													//echo ("INSERT INTO users (active,login,title,firstname,surname,password,category,email) values (1,'$login','".$row4["STD_TITLE"]."','".$row4["STD_NAME"]."','".$row4["STD_SURNAME"]."','asd323',3,'$email');");																	
												}
										} else {
											$row_user = mysql_fetch_array($check_ex);
											mysql_query("INSERT INTO wp (courses,users) values($courses,".$row_user["id"].");");
										}														
									}								
							}
						}						
						// End for Add member to course						
						print( "<meta http-equiv=\"refresh\" content=\"1;url=users.php?courses=$courses\">");						
												
					} else {
								//print "Data have been added !\n";
								print( "<script language=javascript> alert(\"::INFORMATION::\\n\\nCourse Members have been added ! \\n_____________________________\\n\\nYou choose Synchronize to check Data\"); </script>");
					}
					
					
				//}  // end for 				
		}// end if checks
		//=================================================================
		// Sync Member
		if($sync)
		{
			//echo "Synchronize Student"."<br>";						
									
			$name = @mysql_result($course,0,"name");
			//echo "Name :".$name."<br>";
			$year = @mysql_result($course,0,"year");
			//echo "Year :".$year."<br>";
			$semester = @mysql_result($course,0,"semester");
			//echo "Semester :".$semester."<br>";
			$section_type = @mysql_result($course,0,"section_type");
			//echo "Section Type :".$section_type."<br>";
			$section = @mysql_result($course,0,"section");									
			$section= str_replace(" ", "", $section);
			$array = explode(",", $section);
			//echo "Array :".$array."<br>";
			
			//================================================================
			// Check Parameter before send to Web Services
			if($name == "" || $year == 0 || $semester == 0 || $section_type == 0 || !is_array($array)){
				print( "<script language=javascript> alert(\"Please input Course Detail  : \\n Course ID, Course Year, Course Semester, Section Type, Section .\"); </script>");
				print( "<meta http-equiv=\"refresh\" content=\"0;url=users.php?courses=$courses\">");
				exit();
			}
			//================================================================
			
			if(count($array) > 1)
			{
				$str = "(";
				for($i=0; $i < count($array); $i++) 
				{
					if ($i !=0 ) {
						if($section_type == 1){
							$str .=  " OR LC_SECTION = ".$array[$i];
							//$str .=  " OR LC_SECTION = ".$array[$i]." OR LB_SECTION = ".$array[$i];
						} else {
							$str .=  " OR LB_SECTION = ".$array[$i];
						}	
					} else {
						if($section_type == 1){
							$str .=  "LC_SECTION = ".$array[$i];
							//$str .=  "LC_SECTION = ".$array[$i]." OR LB_SECTION = ".$array[$i];
						} else {
							$str .=  "LB_SECTION = ".$array[$i];
						}	
					}
				}
				$str .= ")";			
			} else {
				if($section_type == 1){
					$str = "LC_SECTION = ".$array[0];
					//$str = "LC_SECTION = ".$array[0]." OR LB_SECTION = ".$array[0];
				} else {
					$str = "LB_SECTION = ".$array[0];
				}
			}
			//echo "Section :".$str."<br>";
					
			$maxlist=mysql_query("SELECT DISTINCT STD_ID FROM ku_classlist WHERE CS_CODE='$name' AND  ".$str." AND SM_SEM =$semester AND SM_YR = $year ORDER BY STD_ID asc;");							
			if(@mysql_num_rows($maxlist) != 0)
			{
				print( "<script language=javascript> display_picture(1); </script>");
				require_once('../nusoap/nusoap.php');
				$client = new soapclient('https://portal.ku.ac.th/cpestj/nusoap-kaset-oracle-server.php');
				//$client = new soapclient('http://localhost/nusoap/nusoap-kaset-server.php');
									
				$params = array('cs_code' => $name,  
											  'section_type' => $section_type ,
											  'semester' => $semester ,
											  'year' => $year ,
											  'section' => $array
											 ); 	
						
					if($courses != "" || $courses == 0)
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
							$i=0;
							$count = 0;
							//=====================================
							//Check New Member			
							foreach($response[0] as $res_row)			
							{								
								//$sql = "INSERT INTO ku_classlist (STD_ID, SM_SEM, SM_YR, RG_TYPE, CS_CODE, LC_SECTION, LC_CREDIT, LB_SECTION, LB_CREDIT, TT_CREDIT) VALUES (".$res_row['std_id'].", ".$res_row['sm_sem'].", ".$res_row['sm_yr'].", '".$res_row['rg_type']."', '".$res_row['cs_code']."', '".$res_row['lc_section']."', ".$res_row['lc_credit'].", '".$res_row['lb_section']."',".$res_row['lb_credit'].", ".$res_row['tt_credit'].");"; 
								//mysql_query($sql);
								$count++;									
								$flag = 0;
								
								$maxlist2=mysql_query("SELECT DISTINCT STD_ID FROM ku_classlist WHERE CS_CODE='$name' AND  ".$str." AND SM_SEM =$semester AND SM_YR = $year ORDER BY STD_ID asc;");
																								
								while($exist=mysql_fetch_array($maxlist2))
								{
									if($res_row['std_id'] == $exist["STD_ID"])
										{								
											$flag = 1;											
											//mysql_data_seek($maxlist,0);
											break;
										} 										
								}
																
								if($flag == 0)
								{
									//echo "New Member: ".$res_row['std_id']."<br>";																		
									$student[ ] = $res_row['std_id'];
									$rg_type[ ] = $res_row['rg_type'];
									$lc_section[ ] = $res_row['lc_section'];
									$lc_credit[ ] = $res_row['lc_credit'];
									$lb_section[ ] = $res_row['lb_section'];
									$lb_credit[ ] = $res_row['lb_credit'];
									$tt_credit[ ] = $res_row['tt_credit'];																																	

									$i++;
								} else {
									//echo "No Add New Member."."<br>";
								}
								//$i++;
							} // end foreach($response[0] as $res_row)
							//echo "Total Add Member : ".$i--."<br>";
							
							
							?>
							
						<table width="90%" border="0" cellspacing="1" cellpadding="2"  class="tdborder2" align="center">
						  <tr> 
							<td>&nbsp;</td>
							
    						<td align="center" class="hilite"><strong>จำนวน (คน)</strong></td>
						  </tr>
						  <tr> 
							<td class="hilite">ข้อมูลจำนวนนิสิตที่ลงทะเบียนจริงขณะนี้</td>
							<td class="hilite" align="center"><strong><font color="#FF0000"><? echo $count--;?></font></strong></td>
						  </tr>
						  <tr> 
							<td class="hilite">ข้อมูลจำนวนนิสิตที่ลงทะเบียนอยู่ในระบบ M@xLearn</td>
							<td class="hilite" align="center"><strong><font color="#FF0000"><? echo @mysql_num_rows($Getlist);?></font></strong></td>
						  </tr>
						</table>
							
						<form action="append.php" method="post" name="append">
					  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr> 
						  <td><strong>Add New Member:</strong></td>
						</tr>
					  </table>
				  <table width="90%" border="0" cellspacing="0" cellpadding="2"  class="tdborder2" align="center">										  
						  <tr> 
							<td> 
							<INPUT TYPE="checkbox" NAME="checkbox" VALUE="checkbox" class="r-button" onClick="javascript: doNow();">Check All / Uncheck All
							</td>
						  </tr>
						  <tr>
							<td class="hilite"> 
							  <?php
							  			if($student != "") {
										/*
										for($i=0; $i < count($students); $i++) 
										{		
											echo $students[$i]."<br>";		
										}
										*/									
										for($i=0; $i < count($student); $i++)  {
											?>									
											  <input name="students[ ]" type="checkbox" value="<? echo $student[$i];?>" class="r-button">
											  <input type="hidden" name="rg_type[ ]" value="<? echo $rg_type[$i];?>">
											  <input type="hidden" name="lc_section[ ]" value="<? echo $lc_section[$i];?>">
											  <input type="hidden" name="lc_credit[ ]" value="<? echo $lc_credit[$i];?>">
											  <input type="hidden" name="lb_section[ ]" value="<? echo $lb_section[$i];?>">
											  <input type="hidden" name="lb_credit[ ]" value="<? echo $lb_credit[$i];?>">
											  <input type="hidden" name="tt_credit[ ]" value="<? echo $tt_credit[$i];?>">
											  <?php 
											 //echo $value."<br>";
											//echo $lc_section."<br>";
											//echo $lc_credit."<br>";
											//echo $lb_section."<br>";
											//echo $lb_credit."<br>";
											//echo $tt_credit."<br>";
											  require_once('../nusoap/nusoap.php');
											  $client_new = new soapclient('https://portal.ku.ac.th/cpestj/nusoap-kaset-oracle-server.php');
											  											  		
											  $params = array('std_id' => $student[$i]); 	
													
											  if($student[$i] != 0 || $student[$i] != "")
											  {
												 $response_new = $client_new->call('getKuEachStudent', $params);
											  }																					
												  if($client_new->fault)
												  {
													  print "ERROR! ".$client->faultstring."\n";
												  }
												  else
												  {
													  if($response_new)
													  {												
															foreach($response_new[0] as $res_row_new)							
															{																		
																//echo $res_row['std_id'];
																
																$major= substr($res_row_new['major_id'], 0,1);
																if($major=="X"){$std_title="g";}else{$std_title="b";}
																$s=substr($res_row_new['std_id'],0,7);
																$login=$std_title.$s;
																echo $login." : ";
																$email=$login."@ku.ac.th";
																echo $res_row_new['std_title'];
																echo $res_row_new['std_name'];
																echo " ".$res_row_new['std_surname']."<br>";
																?>
																<input type="hidden" name="login[ ]" value="<? echo $login;?>">
																<input type="hidden" name="email[ ]" value="<? echo $email;?>">
																<input type="hidden" name="std_title[ ]" value="<? echo $res_row_new['std_title'];?>">
																<input type="hidden" name="std_name[ ]" value="<? echo $res_row_new['std_name'];?>">
																<input type="hidden" name="std_surname[ ]" value="<? echo $res_row_new['std_surname'];?>">
																<input type="hidden" name="major_id[ ]" value="<? echo $res_row_new['major_id'];?>">
																<input type="hidden" name="advisor_id[ ]" value="<? echo $res_row_new['advisor_id'];?>">
																<input type="hidden" name="campus_id[ ]" value="<? echo $res_row_new['campus_id'];?>">
																<input type="hidden" name="std_sex[ ]" value="<? echo $res_row_new['std_sex'];?>">
																<input type="hidden" name="idcode[ ]" value="<? echo $res_row_new['idcode'];?>">
																<?php
															}											
														}
														else
														{
															print "NO MATCHES found !\n";
														} // end if response
												  ?> 
											  <?php	
												} // end if client fault
												
											} // end while
										}
									?>
							</td>
						  </tr>
						  <tr> 
							<td class="hilite"> 
								<input type="submit" name="add_member" value="Add Member" class="button">
								<input type="hidden" name="courses" value="<? echo $courses;?>">
								<input type="hidden" name="name" value="<? echo $name;?>">
								<input type="hidden" name="year" value="<? echo $year;?>">
								<input type="hidden" name="semester" value="<? echo $semester;?>">
								<input type="hidden" name="sec" value="<? echo @mysql_result($course,0,"section");?>">								
							  </td>
						  </tr>
						</table>
						</form>
						
						<table width="90%" border="0" cellspacing="2" cellpadding="1" align="center"  class="tdborder2">
						  <tr> 
							<td width="20%"><b><? echo "มีนิสิตลงทะเบียนเพิ่มเติม : ";?></b></td>
							<td width="80%" class="hilite"><font color="#FF0000"><? echo $i--." คน";?></font></td>
						  </tr>
						</table>
							
							<?php
							//echo $i--."<br>";							
							// End Check New Member
							//=====================================
							// Check Drop Member
							$j = 0;
							mysql_data_seek($maxlist,0);
							while($exist=mysql_fetch_array($maxlist))
							{
								$flag = 0;
								foreach($response[0] as $res_row)			
								{
									if($res_row['std_id'] == $exist["STD_ID"])
										{
											$flag = 1;																						
											break;
										} 											
								}
								if($flag == 0)
								{
									//echo "Drop Member: ".$exist['STD_ID']."<br>";
									$drop_st[ ] = $exist["STD_ID"];
									$j++;
								} else {
									//echo "No Drop Member"."<br>";
								}
								//$j++;
							} // end while($exist=mysql_fetch_array($maxlist))
							//echo "Total drop member: ".$j--."<br>";
							?>
							<form action="append.php" method="post" name="drop">
					  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr> 
						  <td><strong>Drop Member:</strong></td>
						</tr>
					  </table>
				  <table width="90%" border="0" cellspacing="0" cellpadding="2"  class="tdborder2" align="center">										  
							<tr> 
							<td> 
							<INPUT TYPE="checkbox" NAME="checkbox" VALUE="checkbox" class="r-button" onClick="javascript: doDrop();">Check All / Uncheck All
							</td>
						  </tr>
						  <tr>
							<td class="hilite"> 
							  <?php		
							  			if ($drop_st != "") { 					  
											while (list($key,$value) = each($drop_st)) {
										?>
										  <input name="drops[ ]" type="checkbox" value="<? echo $value;?>" class="r-button">									   
										  <?php
										   //echo $value."<br>";
										   $gsql2=mysql_query("SELECT distinct  * FROM ku_student  where STD_ID =".$value.";");
												if(mysql_num_rows($gsql2)==1)
												{
														$row4=mysql_fetch_array($gsql2);
														$major= substr($row4["MAJOR_ID"], 0,1);
														if($major=="X"){$std_title="g";}else{$std_title="b";}
														$s=substr($row4["STD_ID"],0,7);
														$login=$std_title.$s;
														$email=$login."@ku.ac.th";
														echo $login." : ".$row4["STD_TITLE"].$row4["STD_NAME"]." ".$row4["STD_SURNAME"]."<br>";
												}
										  ?> 
										  <?php	
											}
										}
									?>
							</td>
						  </tr>
						  <tr> 
							<td class="hilite"> 
								<input type="submit" name="drop_member" value="Drop Member" class="button">
								<input type="hidden" name="courses" value="<? echo $courses;?>">
								<input type="hidden" name="name" value="<? echo $name;?>">
								<input type="hidden" name="year" value="<? echo $year;?>">
								<input type="hidden" name="semester" value="<? echo $semester;?>">
								<input type="hidden" name="sec" value="<? echo @mysql_result($course,0,"section");?>">
								<input type="hidden" name="stype" value="<? echo @mysql_result($course,0,"section_type");?>">
							  </td>
						  </tr>
						</table>
						</form>
						<table width="90%" border="0" cellspacing="2" cellpadding="1" align="center" class="std">
					  <tr>
						<td width="20%"><b><? echo "มีนิสิตถอนรายวิชานี้ : ";?></b></td>				
						<td width="80%" class="hilite"><font color="#FF0000"><? echo $j--." คน";?></font></td>
					  </tr>
					</table>
						
<?
							//echo $j--;
							//End Check Drop Member
							//======================================							
						}
						else
						{
							print "NO MATCHES found !\n";
						}
					}
				print( "<script language=javascript> display_picture(2); </script>");
			} else {
				print( "<script language=javascript> alert(\"::INFORMATION::\\n\\nCourse Members have not add ! \\n_____________________________\\n\\nYou choose Add Students Register.\"); </script>");
			} //end if(@mysql_num_rows($gsql) != 0)
			
			
			/*
			mysql_data_seek($Getlist,0);			
			while($row=mysql_fetch_array($Getlist)){
    			echo "<center>".$row["login"]."<br>"."</center>";
			}
			*/
			
		}
?>
<br>
<table width="90%" class="tdborder2" align="center">
  <tr> 
    <td width="18%" class="news" valign="top"><div align="center"><img src="../images/dangerous.gif" width="48" height="47" border="0"> 
        <br>
        <font color="#FF0000"><strong><img src="../images/warning.gif" width="14" height="14"> 
        Warning</strong></font> <img src="../images/warning.gif" width="14" height="14"></div>
      </td>
    <td width="82%" height="17" valign="middle" class="news"><div align="left"><u> 
        <strong>ขั้นตอนการใช้งานการดึงข้อมูลสมาชิกด้วย Web Services</strong></u><br>
        1.ตรวจสอบข้อมูลรายละเอียดของรายวิชาว่าครบถ้วนหรือไม่ ประกอบด้วย<br>
        &nbsp;&nbsp;&nbsp;&nbsp;- Course ID / รหัสวิชา<br>
        &nbsp;&nbsp;&nbsp;&nbsp;- Course Section / หมู่การเรียน<br>
        &nbsp;&nbsp;&nbsp;&nbsp;- Course Section Type / ประเภทของหมู่การเรียน<br>
        &nbsp;&nbsp;&nbsp;&nbsp;- Year / ปีการศึกษา<br>
        &nbsp;&nbsp;&nbsp;&nbsp;- Semester / ภาคการศึกษา<br>
        โดยข้อมูลเหล่านี้ต้องถูกต้องตรงกับทางหน่วยทะเบียน<br>
        <br>
        2.การดึงข้อมูลนิสิตที่ลงทะเบียนเข้าสู่รายวิชา<br>
        &nbsp;&nbsp;&nbsp; 2.1 กรณีที่อาจารย์ให้นิสิตเข้ามาสมัครเองโดยที่ยังไม่ได้ใช้ 
        Web Services มาก่อน<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <font color="#FF0000"><strong>อาจารย์ต้องทำการลบรายชื่อของสมาชิกออกจากรายวิชาให้หมดก่อน</strong></font> 
        แล้วจึงใช้งาน Web Services ตรงนี้สำคัญมาก &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากไม่ลบรายชื่อนิสิตออกให้หมดก่อนจะทำให้การทำงาน 
        Web Services Error ได้<br>
        &nbsp;&nbsp;&nbsp;&nbsp;2.2 กรณีที่อาจารย์สร้างรายวิชาและยังไม่มีนิสิตเข้ามาสมัครเป็นสมาชิกของรายวิชา<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- อาจารย์สามารถใช้งาน 
        Web Services ได้เลย โดย <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- เลือก <strong><font color="#FF0000">Add 
        Students Register</font></strong> กรณีเป็นการดึงข้อมูลในครั้งแรก<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- เลือก <strong><font color="#FF0000">Synchronize 
        Students Register</font></strong> กรณีเป็นการดึงข้อมูลเปรียบเทียบระหว่างภาคการศึกษา<br>
        <br>
      </div></td>
  </tr>
</table>		
<form action="admin_users_auto.php" method="post">
<input name="courses" type="hidden" value="<? echo $courses;?>">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><strong>SELECT SERVICES </strong></td>
    </tr>
  </table>
  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0"  class="tdborder2">
    <tr align="center"> 
      <td width="22%" align="right" class="hilite">Add Students Register:</td>
      <td width="1%" align="left" class="hilite">&nbsp;</td>
      <td width="77%" align="left" class="hilite"> 
	  <input type="submit" name="checks" value="Process" class="button"> 
	  <input type="button"  value="Cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './users.php?courses=<? echo $courses;?>';}" class="button">
      </td>
    </tr>
    <tr align="center"> 
      <td align="right" class="hilite">Synchronize Students Register:</td>
      <td align="left" class="hilite">&nbsp;</td>
      <td align="left" class="hilite"> 
	  <input type="submit" name="sync" value="Process" class="button">
	  <input type="button"  value="Cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './users.php?courses=<? echo $courses;?>';}" class="button">
	  </td>
    </tr>
  </table>  
</form>
</body>
</html>