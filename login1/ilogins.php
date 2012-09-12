<?php
session_start();
$session_id = session_id();
session_destroy();
require("../include/global.php");
require("../include/online.php");
online($session_id,time(),$session_id,0,0);
$list_page = 20;
 if (empty($page)){
                $page=1;
}
?>
<!--
<script>
var reloaded = false;
var loc=""+document.location;
loc = loc.indexOf("?reloaded=")!=-1?loc.substring(loc.indexOf("?reloaded=")+10,loc.length):"";
loc = loc.indexOf("&")!=-1?loc.substring(0,loc.indexOf("&")):loc;
reloaded = loc!=""?(loc=="true"):reloaded;

function reloadOnceOnly() {
	if (!reloaded)
	window.location.replace(window.location+"?reloaded=true");
}
reloadOnceOnly();
</script> 
-->
<html>
<head>
<title>M@xLearn - :: Kasetsart University's Powerful eLearning Suite  :: -</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<LINK href="style.css" type=text/css rel=stylesheet>
<LINK href="main.css" type=text/css rel=stylesheet>
<style>
BODY {
	SCROLLBAR-FACE-COLOR: #FFFFFF; 
	SCROLLBAR-HIGHLIGHT-COLOR: #00B33A; 
	SCROLLBAR-SHADOW-COLOR: #000000; 
	SCROLLBAR-3DLIGHT-COLOR: #E1FDE9; 
	SCROLLBAR-ARROW-COLOR:  #000000; 
	SCROLLBAR-TRACK-COLOR: #CCFFDD; 
	SCROLLBAR-DARKSHADOW-COLOR: #00B33A; 
}
</style>
</head>
<SCRIPT TYPE="text/JavaScript" SRC="menu.js"></SCRIPT>	
<SCRIPT TYPE="text/JavaScript">
	function mnuOn1(Object)
	{
		Object.style.color = 'blue';
	}			
	function mnuOff(Object)
	{
		Object.style.color = Object.DEFCOL;
	}
/*

	AddMenu("mnu1",190,115,120,"black","white","mnuOn1(this);","mnuOff(this);","&nbsp;&nbsp;|&nbsp;&nbsp;");
		

	
		AddMainMenu(Menu.mnu1,"Available Courses","https://<?php echo $_SERVER["HTTP_HOST"];?>/lms/login/ilogins.php?availableCourses=Yes");
		AddMainMenu(Menu.mnu1,"News Courses","https://<?php echo $_SERVER["HTTP_HOST"];?>/lms/login/ilogins.php?newCourses=Yes");
		AddMainMenu(Menu.mnu1,"Statistics","https://<?php echo $_SERVER["HTTP_HOST"];?>/lms/login/ilogins.php?statistics=Yes");
		AddMainMenu(Menu.mnu1,"Contact us","mailto:fengjini@ku.ac.th;suthee386@hotmail.com;fengstj@ku.ac.th");			
		
		AddMainMenu(Menu.mnu1,"Help","#");

		AddSubMenu(Menu.mnu1,0);					
		CloseMenu();

		AddSubMenu(Menu.mnu1,0);				
		CloseMenu();
		
		AddSubMenu(Menu.mnu1,0);				
		CloseMenu();
		
		AddSubMenu(Menu.mnu1,0);				
		CloseMenu();
				
		AddSubMenu(Menu.mnu1);
			AddMenuItem("-",null,"#339900");
			AddMenuItem("VDO Help","https://course.ku.ac.th/help2/learn_help3.wmv","orange");
			AddMenuItem("Presentation Help","https://course.ku.ac.th/help2/kuclassroom.ppt","orange");
			AddMenuItem("-",null,"#339900");					
		CloseMenu();
		
	CloseMenu();
*/
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">


function newImage(arg) {
        if (document.images) {
                rslt = new Image();
                rslt.src = arg;
                return rslt;
        }
}

function changeImages() {
        if (document.images && (preloadFlag == true)) {
                for (var i=0; i<changeImages.arguments.length; i+=2) {
                        document[changeImages.arguments[i]].src = changeImages.arguments[i+1];
                }
        }
}

var preloadFlag = false;
function preloadImages() {
        if (document.images) {
                loginnew_17_over = newImage("images/loginnew_17-over.gif");
                loginnew_18_over = newImage("images/loginnew_18-over.gif");
                loginnew_20_over = newImage("images/loginnew_20-over.gif");
                preloadFlag = true;
        }
}

function placeFocus() {
if (document.forms.length > 0) {
var field = document.forms[0];
for (i = 0; i < field.length; i++) {
if ((field.elements[i].type == "text") || (field.elements[i].type == "textarea") || (field.elements[i].type.toString().charAt(0) == "s")) {
document.forms[0].elements[i].focus();
break;
         }
      }
   }
}

function MM_popupMsg(msg) { //v1.0
  alert(msg);
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}
</SCRIPT>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" NMOUSEMOVE="mnuMove();"  ONLOAD="placeFocus();">

<table id="Table_01"  width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  rowspan="2" background="../images/hearder_03.gif"><img src="../images/hearder_01.gif" width="127" height="107" alt="Kasetsart University"></td>
		<td><img src="../images/hearder_02.gif" width="341" height="51" alt="">
         </td><td  rowspan="2" width="100%" background="../images/hearder_03.gif"></td>
		<td rowspan="2">
			<img src="../images/hearder_04.gif" width="266" height="107" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/hearder_05.gif" width="341" height="56" alt=""></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="180" valign="top" background="../images/bg_lines.gif">
	  <br>
	  <br>
          <table width="170" border="0" cellpadding="0" cellspacing="0"  align="center" bgcolor="#99CC00" class="tdGreen">
                <tr> 
                  <td width="168" height="16">
					<div class="BWhite"  ><img src="../images/lock.gif" width="16" height="16"> 
                  Log In </div></td>
                </tr>                
                <tr> 
                  <td> 
				  <table width="170" border="0" cellpadding="5" cellspacing="0" align="center" >
                      <tr> 
                        <td height="80" bgcolor="#99CC00">
						<form name="iloginForm" action="LoginAction.php"  method="post">
						<TABLE width="100%" border=0 cellPadding=5 cellSpacing=0>
                            <TBODY>
                              <TR bgColor=#ffffff> 
                                <TD vAlign=top>username :: 
                                  <INPUT maxLength="20" size="15" name="ilogin" class="textLogin"></TD>
                              </TR>
                              <TR bgColor=#ffffff> 
                                <TD vAlign=top>password :: 
                                  <INPUT id="ipassword" type="password"  maxLength="40" size="15" name="ipassword" class="textLogin"></TD>
                              </TR>
                              <TR bgColor=#ffffff> 
                                <TD vAlign=top>
                                </TD>
                              </TR>
                              
                          <TD vAlign=top> 
                                  <input type="submit" name="Submit" value="Submit" width="70" class="button"> 
                                            <input type="reset" name="Submit2" value="Clear" width="70" class="button">
                            </TD>
                              </TR>
                              <TR bgColor=#ffffff> 
                                <TD vAlign=top>
                                  | <A href="#"
                                onclick="MM_popupMsg('ท่านสามารถติดต่อไปยัง\rสำนักบริการคอมพิวเตอร์ มหาวิทยาลัยเกษตรศาสตร์\rโทรศัพท์ : +66 2 562-0951-7 \rโทรสาร : +66 2 562-0950\rอีเมล : webmaster-cpc@ku.ac.th\rURL : http://www.cpc.ku.ac.th\r')">Forgot 
                                  Password</A> | <A class=abox1 
                                href="https://course.ku.ac.th/course/help2/index.html" 
                                target=_blank>help</A></TD>
                              </TR>
                            </TBODY>
                          </TABLE>
						  </form>
						</td>
                      </tr>
                </table>
                </td>
				</tr>
              </table>
	      <br>
	  	 <?php
				  $student=mysql_query("SELECT COUNT(user_session) AS sum FROM session WHERE status=3;");
				  $teacher=mysql_query("SELECT COUNT(user_session) AS sum FROM session WHERE status=2;");
				  $guest=mysql_query("SELECT COUNT(user_session) AS sum FROM session WHERE status=0;");	
				  $row_s = mysql_fetch_array($student);
				  $row_t = mysql_fetch_array($teacher);
				  $row_g = mysql_fetch_array($guest);
			  ?>
	  <table width="168" border="0" align="center" cellpadding="2" cellspacing="0" >
          <tr> 
            <td> <table width="168" border="0" cellpadding="2" cellspacing="0" class="tdGreen">
                <tr> 
                      
                    <td bgcolor="#99CC00"><font color="#FFFFFF"><img src="../images/icon_member.gif"> 
                      ขณะนี้มีผู้ Online </font></td>
                </tr>
                <tr> 
                      
                    <td bgcolor="#FFFFFF">
					<TABLE cellSpacing=0 cellPadding=5 width=168 border=0>
                            <TBODY>
                              <TR bgColor=#ffffff> 
                                <TD width=87><IMG src="../images/person_user.gif" > นักเรียน </TD>
                                <TD width=91>: <?php echo $row_s["sum"];?> คน</TD>
                              </TR>
                              <TR bgColor=#ffffff> 
                                    <TD width=87><IMG src="../images/person_user.gif" > 
                                      อาจารย์ </TD>
                                <TD>: <?php echo $row_t["sum"];?> คน</TD>
                              </TR>
							  <!--
                              <TR bgColor=#ffffff> 
                                    <TD width=87><IMG src="../images/person_user.gif" > 
                                      บุคลภายนอก </TD>
                                <TD>: <?php echo $row_g["sum"];?> คน</TD>
                              </TR>
							  -->
                            </TBODY>
                          </TABLE>
					</td>
                </tr>
              </table></td>
          </tr>
        </table>
		<br>
<!--          <table width="168" border="0" cellpadding="2" cellspacing="0" align="center" class="tdGreen">
                      <tr> 
                        
                    
              <td bgcolor="#99CC00" class="Bwhite"><img src="../images/edu_icon.gif" width="19" height="18"> 
                หลักสูตรเรียนแบบ Online </td>
                      </tr>
                      <tr> 
                        <td height="50" ><div align="center"><A 
                              href="http://maxlearn.eng.ku.ac.th/online_training/"><IMG 
                              src="../images/temp/mechatronics_online.gif" 
                              width=168 height="60" border=0></A></div></td>
                      </tr>
                    </table>
          <br>
          <table width="168" border="0" cellpadding="2" cellspacing="0" align="center" class="tdGreen">
                      <tr> 
                        
                    
              <td bgcolor="#99CC00" class="Bwhite"><img src="../images/edu_icon.gif" width="19" height="18"> 
                หลักสูตรฝึกอบรม</td>
                      </tr>
                      <tr> 
                        <td height="50" ><div align="center"><A 
                              href="http://maxlearn.eng.ku.ac.th/online_training/java/"><IMG 
                              src="../images/temp/javaprofessionaldeveloper_b.gif" 
                              width=168 height="60" border=0></A></div></td>
                      </tr>
                    </table>
          <br>-->
          <table width="170" border="0" align="center" cellpadding="2" cellspacing="0" >
          <tr> 
            <td> <table width="170" border="0" cellpadding="2" cellspacing="0" class="tdGreen">
                <tr> 
                      <td bgcolor="#99CC00"><font color="#FFFFFF"><span class="Bwhite"><img src="../images/icon_www.gif" width="16" height="16"> 
                        Interested Links</span></font></td>
                </tr>
                <tr> 
                  <td bgcolor="#FFFFFF"> <TABLE width="100%" 
                        align=center cellPadding=0 cellSpacing=0>
                          <TBODY>
                            <TR borderColor=#99ccff bgColor=#ffffff> 
                              <TD align=middle 
                              width="16%"></TD>
                              <TD align=middle 
                              width="84%"></TD>
                            </TR>
                            <TR vAlign=top bgColor=#eeeeee> 
                              <TD>&nbsp;<IMG height=16 alt="" 
                              src="../images/link.gif" width=20 
                              border=0></TD>
                              <TD><a href="http://www.correct.go.th/hrd/journal.htm">วารสารบทความ 
                                Online</a></TD>
                            </TR>
                            <TR vAlign=top bgColor=#fdfdfd> 
                              <TD>&nbsp;<IMG height=16 alt="" 
                              src="../images/link.gif" width=20 
                              border=0></TD>
                              <TD><a href="http://www.learn.in.th">LearnOnline</a></TD>
                            </TR>
                            <TR vAlign=top bgColor=#eeeeee> 
                              <TD>&nbsp;<IMG height=16 alt="" 
                              src="../images/link.gif" width=20 
                              border=0></TD>
                              <TD><a href="http://www.edtechno.com">Thai Educational 
                                Technology Resource Center</a></TD>
                            </TR>
                            <TR vAlign=top bgColor=#fdfdfd> 
                              <TD>&nbsp;<IMG height=16 alt="" 
                              src="../images/link.gif" width=20 
                              border=0></TD>
                              <TD><a href="http://www.thaicai.com">thaiCAI</a></TD>
                            </TR>
                          </TBODY>
                        </TABLE> </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </td>
      <td valign="top" bgcolor="#FFFFFF"> <table border="0" cellspacing="0" cellpadding="0" width="100%">
          <tr> 
            <td valign="top" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td valign="top"><div align="center"> <br>
                        <br>
                      </div>
                      <?php 
					  // if($type == "")   //this needs to be changed  as it will return syntax error
					  
					  if (!isset($_REQUEST["type"])) {
					
					?>
                      <!-- News-->
					  <?php
					  $color=0;
									       $news_s=mysql_query("SELECT ns.id,ns.subject,ns.title,ns.post_date FROM news_system as ns WHERE ns.news_area=1 and ns.expired_date>=now()  ORDER BY ns.id desc;");
										if (mysql_num_rows($news_s) != 0) {
					  ?>
					  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="tdBotgreen">
                            <tr class="boxcolor1"> 
                              
                          <td width="182" bgcolor="#99CC00" class="tdGreen"><img src="../images/icon/news.gif" width="11" height="14">&nbsp;<strong><font color="#FFFFFF">News 
                            : ข่าวสารจากผู้ดูแลระบบ</font></strong></td>
                            </tr>
                            <tr> 
                              <td height="50">
							  <table width="100%" cellpadding="5" cellspacing="0" align="center" class="tdGreen"> 
                                      <tr bordercolor="#99CCFF" bgcolor="#FFFFFF"> 
                                        <td></td><td width="72%" align="left"><b><u>ข่าวประกาศ</u></b></td>
										<td width="22%" align="center"><b><u>วันที่ประกาศ</u></b></td>
                                      </tr>
                                      <?php
							       
											while($row_news=mysql_fetch_array($news_s)){
											if ($color == 0) {									
					       ?>
                                      <tr  bgcolor="#C8FF91" VALIGN="top"> 
                                        <td class="tdG"><img src="../images/right_green.gif"  alt="" border="0" width="10" height="10"></td>
                                        <td>
										<a   class="tdG" href="#" onClick="NewWindow('../system/news_system.php?id=<?php echo $row_news["id"] ;?>','name','650','500','yes');return false" > 
                                  		<?php echo $row_news["subject"];?>
										</a><br>
										
										<?php 	
											
											 if(strlen($row_news["title"])>100) {
						  						echo nl2br(substr($row_news["title"],0,100))."...";
						 					 }  else {
						  						echo nl2br($row_news["title"]);
						  						}
						  					?>
										
										</TD>
                                      <td align="center" class="tdG"><?php echo $row_news["post_date"];?></td>
									  </tr>
                                      <?php	    $color = 1;
											} else {									
									?>
                                      <tr  VALIGN="top"> 
                                        <td class="tdG"><img src="../images/right_green.gif"  alt="" border="0" width="10" height="10"></td><td>
										<a  class="tdG" href="#" onClick="NewWindow('../system/news_system.php?id=<?php echo $row_news["id"] ;?>','name','650','500','yes');return false" > 
                                  		<?php echo $row_news["subject"];?>
										</a><br>
										
										
										<?php  if(strlen($row_news["title"])>100) {
						  						echo nl2br(substr($row_news["title"],0,100))."...";
						 					 }  else {
						  						echo nl2br($row_news["title"]);
						  						}
						  					?>
										</TD>
                                    <td align="center" class="tdG"><?php echo $row_news["post_date"];?></td>
									  </tr>
                                      <?php  
										     $color = 0;
										                }										
									          }
									
								   ?>
                                    </table>
							  </td>
                            </tr>
                          </table>
						  <?php
						  }
						  ?>
                      <table width="100%" border="0" cellpadding="0" align="center">
                        <tr> 
                          <td> <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="tdBotgreen">
                              <tr> 
                                <td width="182" bgcolor="#99CC00" class="tdGreen"><font color="#FFFFFF"><img src="../images/icon_pin.gif"><b>&nbsp;News 
                                  : ข่าวสารประชาสัมพันธ์</b></font></td>
                              </tr>
                              <tr> 
                                <td height="50"> 
                                  <table width="100%" cellpadding="5" cellspacing="0" align="center" class="tdGreen">
                                    <tr bgcolor="#FFFFFF"> 
                                      <td width="15%" align="center" bordercolor="#99CCFF"><b><u>รายวิชา</u></b></td>
                                      <td width="52%" align="center" bordercolor="#99CCFF"><b><u>ข่าวประกาศ</u></b></td>
                                      <td width="20%" align="center" bordercolor="#99CCFF"><b><u>ผู้ประกาศ</u></b></td>
                                      <td width="13%" align="center" bordercolor="#99CCFF"><b><u>วันที่ประกาศ</u></b></td>
                                    </tr>
                                    <?php
							       $color=0;								   
									   // $news_c=mysql_query("SELECT nc.txt_news,nc.courses, c.name FROM news_courses as nc, courses as c WHERE nc.courses=c.id AND nc.news_area=1 and nc.expired_date>=now() AND c.active=1 ORDER BY nc.id desc LIMIT 0, 5;");
									   /*  nc.id,nc.subject,nc.title,nc.courses
									    $news_c=mysql_query("SELECT nc.id, nc.txt_news,nc.courses, nc.post_date, c.name, c.section, kf.id AS faculty, kf.FAC_NAME, kf.NAME_ENG, u.id AS uid, u.title, u.firstname, u.surname  
																						FROM news_courses as nc, courses as c , users u , ku_faculty kf
																						WHERE nc.courses=c.id AND nc.news_area=1 and nc.expired_date>=now() AND c.active=1 AND u.id=c.users AND kf.id=u.fac_id 
																						ORDER BY u.fac_id, nc.id DESC;");
										*/			
										$news_c=mysql_query("SELECT  nc.id,nc.subject ,nc.title AS title_news ,nc.courses, nc.post_date, c.name, c.section, kf.id AS faculty, kf.FAC_NAME, kf.NAME_ENG, u.id AS uid, u.title, u.firstname, u.surname  
																						FROM news_courses as nc, courses as c , users u , ku_faculty kf
																						WHERE nc.courses=c.id AND nc.news_area=1 and nc.expired_date>=now() AND c.active=1 AND u.id=c.users AND kf.id=u.fac_id 
																						ORDER BY u.fac_id, nc.id DESC;");									
										if (mysql_num_rows($news_c) != 0) {
										
											if($row_news=mysql_fetch_array($news_c))
											{										  
												 $faculty = $row_news["faculty"];
												 $news_id = $row_news["id"];
											?>
                                    <tr  bgcolor="#99CC33" > 
                                      <td colspan="5"  class="tdGreen"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                          <tr> 
                                            <td width="11%" align="center"><font color="#FFFFFF"><b><u>คณะ</u></b></font><b><font color="#FFFFFF"></font></b></td>
                                            <td width="89%"><b><font color="#FFFFFF"><?php echo $row_news["FAC_NAME"]; ?></font></b></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <tr bgcolor="#C8FF91" VALIGN="top"> 
                                      <td class="tdG"><img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $row_news["name"]; ?> 
                                        <?php if($row_news["section"] != "") echo " (".$row_news["section"].")";?>
                                      </TD>
                                      <td class="tdG">
									  <?php //echo $row_news["txt_news"];  ?>
									  <a   class="AS" href="#" onClick="NewWindow('../courses/news_detail.php?id=<?php echo $row_news["id"] ;?>&courses=<?php echo $row_news["courses"] ;?>','name','650','500','yes');return false" > 
                                  		<?php echo $row_news["subject"];?>
										</a><br>
										
										<?php 	
											
											 if(strlen($row_news["title_news"])>100) {
						  						echo nl2br(substr($row_news["title_news"],0,100))."...";
						 					 }  else {
						  						echo nl2br($row_news["title_news"]);
						  						}
						  					?>
									  </td>
                                      <td align="center" class="tdG"> <a  href="#" onClick="NewWindow('../personal/info_fpage.php?userid=<?php echo  $row_news["uid"];?>&page=1','name','650','500','yes');return false" > 
                                        <?php echo $row_news["title"].$row_news["firstname"]."  ".$row_news["surname"];  ?> 
                                        </a> </td>
                                      <td align="center"><?php echo $row_news["post_date"];  ?></td>
                                    </tr>
                                    <?php
												$color = 1; 
											 }
											 
											while($row_news=mysql_fetch_array($news_c)){												
												if ($faculty == $row_news["faculty"]) {
													if ($news_id != $row_news["id"]) {
														if ($color == 0) {									
									   					?>
                                    <tr bgcolor="#C8FF91" VALIGN="top"> 
                                      <td class="tdG"><img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $row_news["name"]; ?> 
                                        <?php if($row_news["section"] != "") echo " (".$row_news["section"].")";?>
                                      </TD>
                                      <td class="tdG">
									  <?php //echo $row_news["txt_news"];  ?>
									  <a   class="AS" href="#" onClick="NewWindow('../courses/news_detail.php?id=<?php echo $row_news["id"] ;?>&courses=<?php echo $row_news["courses"] ;?>','name','650','500','yes');return false" > 
                                  		<?php echo $row_news["subject"];?>
										</a><br>
										
										<?php 	
											
											  if(strlen($row_news["title_news"])>100) {
						  						echo nl2br(substr($row_news["title_news"],0,100))."...";
						 					 }  else {
						  						echo nl2br($row_news["title_news"]);
						  						}
						  					?>
									  </TD>
                                      <td align="center" class="tdG"> <a  href="#" onClick="NewWindow('../personal/info_fpage.php?userid=<?php echo  $row_news["uid"];?>&page=1','name','650','500','yes');return false" > 
                                        <?php echo $row_news["title"].$row_news["firstname"]."  ".$row_news["surname"];  ?> 
                                        </a> </TD>
                                      <td align="center"><?php echo $row_news["post_date"];  ?></TD>
                                    </tr>
                                    <?php	    
															$color = 1;
														} else {									
														?>
                                    <tr  VALIGN="top"> 
                                      <td class="tdG"><img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $row_news["name"]; ?> 
                                        <?php if($row_news["section"] != "") echo " (".$row_news["section"].")";?>
                                      </TD>
                                      <td class="tdG">
									  <?php //echo $row_news["txt_news"]; ?>
									  <a   class="AS" href="#" onClick="NewWindow('../courses/news_detail.php?id=<?php echo $row_news["id"] ;?>&courses=<?php echo $row_news["courses"] ;?>','name','650','500','yes');return false" > 
                                  		<?php echo $row_news["subject"];?>
										</a><br>
										
										<?php 	
											
											 if(strlen($row_news["title_news"])>100) {
						  						echo nl2br(substr($row_news["title_news"],0,100))."...";
						 					 }  else {
						  						echo nl2br($row_news["title_news"]);
						  						}
						  					?>
									  </TD>
                                      <td align="center" class="tdG"> <a  href="#" onClick="NewWindow('../personal/info_fpage.php?userid=<?php echo  $row_news["uid"];?>&page=1','name','650','500','yes');return false" > 
                                        <?php echo $row_news["title"].$row_news["firstname"]."  ".$row_news["surname"];  ?> 
                                        </a> </TD>
                                      <td align="center"><?php echo $row_news["post_date"];  ?></TD>
                                    </tr>
                                    <?php  
															$color = 0;
														}
													}
												} else {
													 	$faculty = $row_news["faculty"];
												 		$news_id = $row_news["id"];
														$color = 0;												
												?>
                                    <tr  bgcolor="#99CC00" > 
                                      <td colspan="5" class="tdGreen"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                          <tr> 
                                            <td width="11%" align="center"><font color="#FFFFFF"><b><u>คณะ</u></b></font><b><font color="#FFFFFF"></font></b></td>
                                            <td width="89%"><b><font color="#FFFFFF"><?php echo $row_news["FAC_NAME"]; ?></font></b></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <?php		
														if ($color == 0) {									
																?>
                                    <tr bgcolor="#C8FF91" VALIGN="top"> 
                                      <td class="tdG"><img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $row_news["name"]; ?> 
                                        <?php if($row_news["section"] != "") echo " (".$row_news["section"].")";?>
                                      </TD>
                                      <td bgcolor="#C8FF91" class="tdG">
									  <?php //echo $row_news["txt_news"];  ?>
									  <a   class="AS" href="#" onClick="NewWindow('../courses/news_detail.php?id=<?php echo $row_news["id"] ;?>&courses=<?php echo $row_news["courses"] ;?>','name','650','500','yes');return false" > 
                                  		<?php echo $row_news["subject"];?>
										</a><br>
										
										<?php 	
											
											  if(strlen($row_news["title_news"])>100) {
						  						echo nl2br(substr($row_news["title_news"],0,100))."...";
						 					 }  else {
						  						echo nl2br($row_news["title_news"]);
						  						}						  					?>
									  </TD>
                                      <td align="center" class="tdG"> <a  href="#" onClick="NewWindow('../personal/info_fpage.php?userid=<?php echo  $row_news["uid"];?>&page=1','name','650','500','yes');return false" > 
                                        <?php echo $row_news["title"].$row_news["firstname"]."  ".$row_news["surname"];  ?> 
                                        </a> </TD>
                                      <td align="center"><?php echo $row_news["post_date"];  ?></TD>
                                    </tr>
                                    <?php	    
																	$color = 1;
																} else {									
																?>
                                    <tr  VALIGN="top"> 
                                      <td class="tdG"><img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $row_news["name"]; ?> 
                                        <?php if($row_news["section"] != "") echo " (".$row_news["section"].")";?>
                                      </TD>
                                      <td class="tdG">
									  <?php //echo $row_news["txt_news"]; ?>
									  <a   class="AS" href="#" onClick="NewWindow('../courses/news_detail.php?id=<?php echo $row_news["id"] ;?>&courses=<?php echo $row_news["courses"] ;?>','name','650','500','yes');return false" > 
                                  		<?php echo $row_news["subject"];?>
										</a><br>
										
										<?php 	
											
											  if(strlen($row_news["title_news"])>100) {
						  						echo nl2br(substr($row_news["title_news"],0,100))."...";
						 					 }  else {
						  						echo nl2br($row_news["title_news"]);
						  						}
						  					?>
									  </TD>
                                      <td align="center" class="tdG"> <a  href="#" onClick="NewWindow('../personal/info_fpage.php?userid=<?php echo  $row_news["uid"];?>&page=1','name','650','500','yes');return false" > 
                                        <?php echo $row_news["title"].$row_news["firstname"]."  ".$row_news["surname"];  ?> 
                                        </a> </TD>
                                      <td align="center"><?php echo $row_news["post_date"];  ?></TD>
                                    </tr>
                                    <?php  
																	$color = 0;
																}
												}																								
												
									       } // end while
									}
								   ?>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>
                      <br> 
                      <?php } ?>
                      <!-- Course Statistics All -->
                      <?php 
					  //if ($type == 2)  // this has to be changed as it will return syntax error
					  if (isset($_REQUEST["statistics"])){?>
                      <table width="100%" border="0" cellpadding="0" align="center">
                        <tr> 
                          <td> <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="tdBotgreen">
                              <tr> 
                                <td width="182" bgcolor="#99CC00" class="tdGreen"><font color="#FFFFFF"><span class="Bwhite"><img src="../images/graph.gif"></span> 
                                  <b>&nbsp;</b><span class="Bwhite">สถิติการใช้งานรายวิชา</span></font></td>
                              </tr>
                              <tr> 
                                <td height="50"> <table width="100%" align="center" cellpadding="5" cellspacing="0" class="tdGreen">
                                    <tr bordercolor="#99CCFF"> 
                                      <td width="8%" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;"><strong><u>ลำดับที่</u></strong></td>
                                      <td width="14%" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;"><strong><u>รายวิชา</u></strong></td>
                                      <td width="48%" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;"><strong><u>ชื่อวิชา</u></strong></td>
                                      <td width="19%" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;"><strong><u>อาจารย์ผู้สอน</u></strong></td>
                                      <td width="11%" align="center" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;"><strong><u>จำนวนครั้ง</u></strong></td>
                                    </tr>
                                    <?php
										$n=0;
										$number=1;
										$color = 0;
										$qcourses=mysql_query("SELECT id, users from courses WHERE active =1 and advisor=0;");
										while($row=mysql_fetch_array($qcourses)){
											$qnumcourse=mysql_query("SELECT id from login_course WHERE courses=".$row["id"]." AND users <>".$row["users"].";" );
											$i=mysql_num_rows($qnumcourse);											
											$eachcourse[$n]=array($i,$row["id"]);
											$n++;
										}
										if ($sort=="up")
											 {
											 sort($eachcourse);
											 }
										else
											{
											 rsort($eachcourse);
											}
										$nume=count($eachcourse);
										$NRow = mysql_num_rows($qcourses);										
										//$nume=10;
										//echo $nume;
										//$NRow = count($eachcourse);
        								$rt = $NRow%$list_page;
										if($rt!=0) {
												$totalpage = floor($NRow/$list_page)+1;
										}
										else {
												$totalpage = floor($NRow/$list_page);
										}
										$goto = ($page-1)*$list_page;										
										if ($page != 1) {
										$s = $page*10;
										} else {
										$s=0;
										}
										for($idx=$s; $idx<($s+$list_page); ++$idx)
											 {
											 $courseid=$eachcourse[$idx][1];
											 $course=mysql_query("SELECT id,name,fullname,users,section from courses where id='$courseid' and advisor = 0;");
											 $user=mysql_query("SELECT id,title,firstname,surname,email from users where id='".@mysql_result($course,0,"users")."';");
											 $rowuser=mysql_fetch_array($user);
											 if ($eachcourse[$idx][0]!=0) {
											 if ($color == 0) {
									?>
                                    <tr bgcolor="#C8FF91"> 
                                      <td>&nbsp;<img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $idx+1;?></td>
                                      <td><a  href="#" onClick="NewWindow('../syllabus/show.php?courses=<?php echo  mysql_result($course,0,"id");?>','name','650','500','yes');return false" ><?php echo mysql_result($course,0,"name");?></a> 
                                        <?php echo "(".mysql_result($course,0,"section").")";?></td>
                                      <td><?php echo htmlspecialchars(mysql_result($course,0,"fullname"));?></td>
                                      <td> 
									  <a  href="#" onClick="NewWindow('../personal/info.php?userid=<?php echo  $rowuser["id"];?>&page=1','name','650','500','yes');return false" >
									  <?php echo $rowuser["title"].$rowuser["firstname"]." ".$rowuser["surname"];?>
									  </a>
									  </td>
                                      <td align="center"><?php echo $eachcourse[$idx][0];?></td>
                                    </tr>
                                    <?php
													$color = 1;
												} else {
												?>
                                    <tr> 
                                      <td>&nbsp;<img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $idx+1;?></td>
                                      <td><a  href="#" onClick="NewWindow('../syllabus/show.php?courses=<?php echo  mysql_result($course,0,"id");?>','name','650','500','yes');return false" ><?php echo mysql_result($course,0,"name");?> 
                                        </a><?php echo "(".mysql_result($course,0,"section").")";?></td>
                                      <td><?php echo mysql_result($course,0,"fullname");?></td>
                                      <td>
									  <a  href="#" onClick="NewWindow('../personal/info.php?userid=<?php echo  $rowuser["id"];?>&page=1','name','650','500','yes');return false" >
									  <?php echo $rowuser["title"].$rowuser["firstname"]." ".$rowuser["surname"];?>
									  </a>
									  </td>
                                      <td align="center"><?php echo $eachcourse[$idx][0];?></td>
                                    </tr>
                                    <?php
														$color = 0;
												}
												$number++;   
												}
									}	
								   ?>
                                  </table>
                                  <?php
								  // table แสดงเลขหน้า
									echo "<table width=100% border=0 bordercolor=black cellspacing=0 cellpadding=2>\n";
									echo "<tr><td align=left>\n";
									echo "\t<font size=2 >\n";
					
									// สร้าง link เพื่อไปหน้าก่อน-หน้าถัดไป
									if($page>1 && $page<=$totalpage) {
											$prevpage = $page-1;
											echo "\t<a href='ilogins.php?type=2&page=$prevpage' class=a11>[Prev]</a>\n";
									}
					
									echo "\t [$page/$totalpage] \n";
					
									if($page!=$totalpage) {
											$nextpage = $page+1;
											echo "\t<a href='ilogins.php?type=2&page=$nextpage' class=a11>[Next]</a>\n";
									}
					
									echo "\t</font>\n";
									echo "</td></tr>\n";
									echo "<tr><td>\n";
					
									// วนลูปแสดงเลขหน้าทั้งหมด
									for($i=1 ; $i<$page ; $i++) {
											echo "\t<a href='ilogins.php?type=2&page=$i'>$i</a> \n";
									}
									echo "\t<font size=2 color=red><b>$page</b></font> \n";
									for($i=$page+1 ; $i<=$totalpage ; $i++) {
											echo "\t<a href='ilogins.php?type=2&page=$i' class=a11>$i</a> \n";
									}
					
									echo "</td></tr>\n";
									echo "</table>\n";
								?>
                                </td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>
                      <?php } ?>
                      <!-- End Course Statistic All -->
                      <!-- Avaliable Course -->
                      <?php 
					  //if ($type == 1)  //  this  has to be changed as it will return syntax error : Jitti
					  if (isset($_REQUEST["availableCourses"])){?>
                      <table width="100%" border="0" cellpadding="0" align="center">
                        <tr> 
                          <td> <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="tdBotgreen">
                              <tr> 
                                <td width="182" bgcolor="#99CC00" class="tdGreen"><font color="#FFFFFF"><span class="Bwhite"><img src="../images/icon_syllabus.gif" width="11" height="15"> 
                                  </span> <span class="Bwhite">รายวิชาที่เปิดสอน</span></font></td>
                              </tr>
                              <tr> 
                                <td> 
								<form action="ilogins.php" method="post">
								    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td width="25%" align="right">&nbsp;</td>                                        
                                        <td width="75%" align="right">Search By 
                                          : 
                                          <select name="stype" style="font-size:9px">
                                            <option value="-1" selected>-select-</option>
                                            <option value="1" >รหัสวิชา</option>
                                            <option value="2" >ชื่อวิชา</option>
                                            <option value="3" >อาจารย์ผู้สอน</option>
                                          </select>
                                          <input name="search" type="text" size="20" class="text"> 
                                          <input type="submit"  value="Search" class="button"> 
                                          <input name="type" type="hidden" value="1"> 
                                        </td>
                                      </tr>
                                    </table>
								    </form>
									<?php if($search != "") { ?>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="20%">Search By : 
										<?php
										switch ($stype) {													
											case 1:
												echo "รหัสวิชา";
												break;
											case 2:
												echo "ชื่อวิชา";
												break;
											case 3:
												echo "อาจารย์ผู้สอน";
												break;
											default:
												echo "-";												
												}
										?>	
										</td>                                     
                                        <td width="80%">Search String : <?php if($search == "") { echo "-";} else { echo $search;} ?></td>
                                      </tr>
                                    </table>
									<br>
									<?php }?>									
                                  <table width="100%" align="center" cellpadding="5" cellspacing="0" class="tdGreen">
                                    <tr bordercolor="#99CCFF"> 
                                      <td width="18%" bgcolor="#FFFFFF"  align="center" style="border-bottom: solid #339900 1px;"><strong><u>รหัสวิชา</u></strong></td>
                                      <td width="48%" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;"><strong><u>ชื่อวิชา</u></strong></td>
                                      <td width="22%" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;"><strong><u>อาจารย์ผู้สอน</u></strong></td>
                                      <td width="12%" bgcolor="#FFFFFF" style="border-bottom: solid #339900 1px;" align="center"><b><u>รายละเอียด</u></b></td>
                                    </tr>
                                    <?php
								  /*	
								  		 $sql = "select No from webboard_data where Category='$Category' and webboard_name='$webboard_name';";
										$result = mysql_db_query($dbname,$sql);
										$NRow = mysql_num_rows($result);
										$rt = $NRow%$list_page;
										if($rt!=0) {
												$totalpage = floor($NRow/$list_page)+1;
										}
										else {
												$totalpage = floor($NRow/$list_page);
										}
										$goto = ($page-1)*$list_page;
										// Query ข้อมูลตามจำนวนที่กำหนด
										$sql = "select * from webboard_data where Category='$Category' and webboard_name='$webboard_name' order by No DESC limit $goto,$list_page";
										$result = mysql_db_query($dbname,$sql);
										$NRow = mysql_num_rows($result);
								*/								  								  								  									
										$color = 0;
										if ($search == "") {
											$course_open_=mysql_query("SELECT id, name, fullname 
																										  FROM courses 
																										  WHERE active = 1 AND advisor =0 ORDER BY id;");
										} else {
																				
												switch ($stype) {													
													case 1:
														$course_open_=mysql_query("SELECT id, name, fullname 
																										  FROM courses 
																										  WHERE active = 1 AND advisor =0 AND name LIKE '".$search."%' ORDER BY id;");
														break;
													case 2:
														$course_open_=mysql_query("SELECT id, name, fullname 
																										  FROM courses 
																										  WHERE active = 1 AND advisor =0 AND fullname LIKE '%".$search."%' ORDER BY id;");
														break;
													case 3:
														$course_open_=mysql_query("SELECT c.id, c.name, c.fullname 
																										  FROM courses c, users u 
																										  WHERE c.active = 1 AND c.advisor =0 AND c.users = u.id AND u.firstname LIKE '%".$search."%' ORDER BY c.id;");
														break;
													default:
														$course_open_=mysql_query("SELECT id, name, fullname 
																										  FROM courses 
																										  WHERE active = 1 AND advisor =0 AND fullname LIKE '%".$search."%' ORDER BY id;");
												}																						
										}
										 $NRow = mysql_num_rows($course_open_);
        								$rt = $NRow%$list_page;
										if($rt!=0) {
												$totalpage = floor($NRow/$list_page)+1;
										}
										else {
												$totalpage = floor($NRow/$list_page);
										}
										$goto = ($page-1)*$list_page;
																				
										if($search == "") {
											$course_open=mysql_query("SELECT id, name, fullname,users,section 
																										FROM courses 
																										WHERE active = 1 AND advisor = 0 ORDER BY id DESC limit $goto,$list_page;");
										} else {
											switch ($stype) {													
													case 1:
														$course_open=mysql_query("SELECT id, name, fullname,users,section 
																										FROM courses 
																										WHERE active = 1 AND advisor = 0 AND name LIKE '".$search."%' ORDER BY id DESC;");
														break;
													case 2:
														$course_open=mysql_query("SELECT id, name, fullname,users,section 
																										FROM courses 
																										WHERE active = 1 AND advisor = 0 AND fullname LIKE '%".$search."%' ORDER BY id DESC;");
														break;
													case 3:
														$course_open=mysql_query("SELECT c.id, c.name, c.fullname, c.users, c.section 
																										FROM courses c, users u
																										WHERE c.active = 1 AND c.advisor = 0 AND c.users = u.id AND u.firstname LIKE '%".$search."%' ORDER BY c.id DESC;");
														break;
													default:
														$course_open=mysql_query("SELECT id, name, fullname,users,section 
																										FROM courses 
																										WHERE active = 1 AND advisor = 0 AND fullname LIKE '%".$search."%' ORDER BY id DESC;");
												}																					
										}
										
										while($row_course=mysql_fetch_array($course_open)){
										$user=mysql_query("SELECT id,firstname,surname,email,title from users where id='".$row_course["users"]."';");
										$rowuser=mysql_fetch_array($user);
																													
										if ($color == 0) {
									?>
                                    <tr valign="top" bgcolor="#C8FF91"> 
                                      <td>&nbsp;<img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $row_course["name"];?>
                                        <?php echo "(".$row_course["section"].")";?></td>
                                      <td><?php echo $row_course["fullname"];?></td>
                                      <td>
									  <a  href="#" onClick="NewWindow('../personal/info.php?userid=<?php echo  $rowuser["id"];?>&page=1','name','650','500','yes');return false" >
									  <?php echo $rowuser["title"].$rowuser["firstname"]."  ".$rowuser["surname"];?>
									  </a>
									  </td>
                                      <td align="center"> <a  href="#" onClick="NewWindow('../syllabus/show.php?courses=<?php echo $row_course["id"];?>','name','650','500','yes');return false" > 
                                        <img src="../images/icon_syllabus.gif" width="11" height="15" border="0"> view
                                        </a> </td>
                                    </tr>
                                    <?php
 										$color = 1;
										} else {									
									?>
                                    <tr valign="top"> 
                                      <td>&nbsp;<img src="../images/right_green.gif"  alt="" border="0" width="10" height="10">&nbsp;<?php echo $row_course["name"];?>
                                        <?php echo "(".$row_course["section"].")";?></td>
                                      <td><?php echo $row_course["fullname"];?></td>
                                      <td>
									  <a  href="#" onClick="NewWindow('../personal/info.php?userid=<?php echo  $rowuser["id"];?>&page=1','name','650','500','yes');return false" >
									  <?php echo $rowuser["title"].$rowuser["firstname"]."  ".$rowuser["surname"];?>
									  </a>
									  </td>
                                      <td align="center"><a  href="#" onClick="NewWindow('../syllabus/show.php?courses=<?php echo $row_course["id"];?>','name','650','500','yes');return false" > 
                                        <img src="../images/icon_syllabus.gif" width="11" height="15" border="0"> view
                                        </a> </td>
                                    </tr>
                                    <?php  
										$color = 0;
										}										
									}
								   ?>
                                  </table>
                                  <?php
								  // table แสดงเลขหน้า
									echo "<table width=100% border=0 bordercolor=black cellspacing=0 cellpadding=2>\n";
									echo "<tr><td align=left>\n";
									echo "\t<font size=2 >\n";
					
									// สร้าง link เพื่อไปหน้าก่อน-หน้าถัดไป
									if($page>1 && $page<=$totalpage) {
											$prevpage = $page-1;
											if($search == "") {
												echo "\t<a href='ilogins.php?type=1&page=$prevpage' class=a11>[Prev]</a>\n";
											} else {
												echo "\t<a href='ilogins.php?type=1&page=$prevpage&search=$search&stype=$stype' class=a11>[Prev]</a>\n";
											}
									}
					
									echo "\t [$page/$totalpage]\n";
					
									if($page!=$totalpage) {
											$nextpage = $page+1;
											if($search == "") {
												echo "\t<a href='ilogins.php?type=1&page=$nextpage' class=a11>[Next]</a>\n";
											} else {
												echo "\t<a href='ilogins.php?type=1&page=$nextpage&search=$search&stype=$stype' class=a11>[Next]</a>\n";
											}
									}
					
									echo "\t</font>\n";
									echo "</td></tr>\n";
									echo "<tr><td>\n";
					
									// วนลูปแสดงเลขหน้าทั้งหมด
									for($i=1 ; $i<$page ; $i++) {
											if($search == "") {
												echo "\t<a href='ilogins.php?type=1&page=$i'>$i</a> \n";
											} else {
												echo "\t<a href='ilogins.php?type=1&page=$i&search=$search&stype=$stype'>$i</a> \n";
											}
									}
									echo "\t<font size=2 color=red><b>$page</b></font> \n";
									for($i=$page+1 ; $i<=$totalpage ; $i++) {
											if($search == "") {
												echo "\t<a href='ilogins.php?type=1&page=$i' class=a11>$i</a> \n";
											} else {
												echo "\t<a href='ilogins.php?type=1&page=$i&search=$search&stype=$stype' class=a11>$i</a> \n";
											}
									}
					
									echo "</td></tr>\n";
									echo "</table>\n";
								?>
                                </td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>
                      <?php }?>
                      <!-- End Avaliable Course -->
                      <br> <br> </td>
                  </tr>
                </table></td>
    </tr>
    <tr> 
          <td colspan="2" valign="top" >&nbsp;</td>
    </tr>
    <tr> 
              <td colspan="2">&nbsp;</td>
    </tr>
  </table>
	</td>
  </tr>
</table>
<!-- Footer -->
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td background="../images/bg_lines.gif">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#666666">
		<div align="center" class="footer">Copyright &copy;2004 Faculty of Engineering 
                    Kasetsart University. All rights reserved.<br>
                Best viewed with Microsoft Internet Explorer 4 or Higher on 800x600 
                pixel
		</div>
	</td>
  </tr>
</table>


</body>
</html>
