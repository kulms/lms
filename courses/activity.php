<?php   
			
			require("../include/global_login.php");
			if($person["admin"]==1){
				$perm = mysql_query("SELECT * FROM sys_admin_per WHERE sys_admin_users=".$person["id"].";");
				if(@mysql_result($perm,0,"sys_padmin_courses")==1 || @mysql_result($perm,0,"sys_padmin_super")==1 || $person["admin"]==1){
					$check=mysql_query("SELECT c.name,c.section,wp.admin, c.fullname, c.fullname_eng 
																 FROM wp,courses c 
																 WHERE wp.courses=$courses AND c.id=wp.courses;");						
					$courses_name=@mysql_result($check,0,"name");
					$section=@mysql_result($check,0,"section");
					$fullname=@mysql_result($check,0,"fullname");
					$fullname_eng=@mysql_result($check,0,"fullname_eng");
					$cadmin=1;
				}
			} else {	 	
				$check=mysql_query("SELECT c.* FROM wp,courses c
					 									     WHERE wp.courses=$courses AND wp.users=".$person["id"]." AND c.id=wp.courses;");
			}										 

//$check=mysql_query("SELECT c.name,c.info,c.fullname,c.section FROM wp,courses c  WHERE wp.courses=$courses AND (wp.users=".$person["id"]." OR wp.admin=".$person["admin"].") AND c.id=wp.courses;");													  
 // $checkowner = mysql_query("SELECT * FROM wp WHERE courses=$courses AND users=".$person["id"]." AND admin=1 AND modules=1;");
 
		  //$checkowner=mysql_query("SELECT * FROM courses c WHERE c.id=$courses AND c.users=".$person["id"]."  ;");
		  
		  $checkowner=mysql_query("SELECT c.* FROM courses c, wp WHERE c.id=$courses AND c.id=wp.courses AND wp.users=".$person["id"]." AND wp.admin=1;");
		  
/*  at 15 nov 02->  $news=mysql_query("SELECT  nc.txt_news, nc.id , nc.expired_date, nc.post_date FROM news_courses nc, courses c  
												      WHERE  c.id=nc.courses  AND  nc.courses=$courses AND nc.expired_date>now()											
													 ORDER BY nc.id DESC;"); */ 
	/*
	$news=mysql_query("SELECT  nc.txt_news, nc.id , nc.expired_date, nc.post_date FROM news_courses nc 
														  WHERE  nc.courses=$courses AND nc.expired_date>now()											
														 ORDER BY nc.id DESC;");
		*/
		$news=mysql_query("SELECT  nc.subject,nc.title,nc.picture,nc.htmlfile, nc.id , nc.expired_date, nc.post_date FROM news_courses nc 
														  WHERE  nc.courses=$courses AND nc.expired_date>=now()											
														 ORDER BY nc.id DESC;");												 													 
		
		if(mysql_num_rows($check)==0)
		{		echo "YOU DO NOT HAVE ACCESS TO THIS COURSE!!!!!";
				exit();
			}else{
							$course=mysql_fetch_array($check);
						}
?>
<html>
<head>
        <title>Course On Web - Courses</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="STYLESHEET" type="text/css" href="../style.css">!-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language="JavaScript" type="text/JavaScript">
function iconfirm(in_url,msg)
		{
				if( confirm(msg) )
					{   
						document.location =in_url; 
					 }
		}
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}

function addresource(val,i,id)
{
 	var resource = val.options[val.selectedIndex].value;
	var url="edit_resource"+resource;
	var courses=document.all.courses.value;
	win = window.open("resource/"+url+".php?courses="+courses+"&secid="+id+"&i="+i+"&Add=1", "_self")
}

function popupresource(popup,c,r,s,t,u){
	if(t=="file"){
		var url=u;
	}else{
		var url="resource/view_resource.php?courses="+c+"&reid="+r+"&secid="+s;
	}
		if(popup !=""){
			 window.open(url,"qWindow", popup);
		}else
			 window.open(url, "_self");
}

function jumpto(val,c){
var week = val.options[val.selectedIndex].value;
var url="resource/set_saw.php?saw=0&courses="+c+"&jump=1&w="+week;
 window.open(url, "_self");
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<?php if($person["admin"]==1){?>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
	  <tr><td class="menu" align="center">
	  
			<b><? echo $courses_name;
			 if ($section !="") 
			 {  ?>
			<font color="#ff33ff">[ </font>
			<font color="#99ff99"> หมู่ <? echo $section; ?> </font><font color="#ff33ff">]</font>
	<?   }   ?><br><? echo $fullname."<br>(".$fullname_eng.")"; ?></b>
			
	</td></tr>
</table>
<?php } else {?>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
	  <tr><td class="menu" align="center">
	  
			<b><? echo "&nbsp;".$course["name"].$course[""]; 
			 if ($course["section"] !="") 
			 {  ?>
			<font color="#ff33ff">[ </font>
			<font color="#99ff99"> หมู่ <? echo $course["section"]; ?> </font><font color="#ff33ff">]</font>
	<?   }   ?><br><? echo $course["fullname"]."<br>(".$course["fullname_eng"].")"; ?></b>
			
	</td></tr>
</table>
<?php }?>

<hr width="50%" align="center">
<!--
<?php    
			/*
			if (mysql_num_rows($checkowner)==1)
					{	 //  if (mysql_num_rows($checkowner)!=0){      ?>
<table width="70%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td align="right" class="mini">| 
	<a href="admin_course.php?courses=<? echo $courses; ?>">Course Preference</a> | 
	<a href="admin_users.php?courses=<? echo $courses; ?>">Edit course members</a> | 
	<a href="../visualization.php?courses=<? echo $courses; ?>">View course activity</a> |</td>
  </tr>
</table>
<table width="70%" border="0" align="center">
  <tr> 
    <td align="right" class="mini">[ <a href="news.php?courses=<? echo $courses; ?>" target="_self">add news</a> ]
	</td>
  </tr>
</table>
<?php 
} */
 ?>
 -->
<?php    if (mysql_num_rows($checkowner)!=0)
					{	 //  if (mysql_num_rows($checkowner)!=0){      ?>
<!--
<table width="70%" border="0" align="center" class="tdborder2" >
  <tr align="center" class="boxcolor"> 
    <td colspan="5"  class="Bwhite"><strong><? echo $strCourses_LabMenuInstructor;?></strong></td>
  </tr>
  <tr align="center"> 
    <td class="mini"  width="25%"><a href="admin_course.php?courses=<? echo $courses; ?>"><img src="../images/_course_pref.gif" border="0"></a><br>
      <? echo $strCourses_LabCoursePreference;?></td>
    <td class="mini"  width="25%"><a href="users.php?courses=<? echo $courses; ?>"><img src="../images/_users.gif"  border="0"></a><br>
      <? echo $strCourses_LabCourseMember;?></td>
    <td class="mini"  width="25%"><a href="../visualization.php?courses=<? echo $courses; ?>"><img src="../images/_course_act.gif"  border="0"></a><br>
      <? echo $strCourses_LabCourseActivity;?></td>
    <td class="mini"  width="25%"><a href="manage.php?courses=<? echo $courses?>"> <img src="../images/_resources.gif"  border="0"></a><br>
      <? echo $strCourses_LabCourseResource;?></td>
    
  </tr>
  <tr align="center"> 
    <td width="25%" class="mini"><a href="news/?courses=<? echo $courses; ?>"><img src="../images/annouce.gif" border="0" ></a><br>
      <? echo $strCourses_LabCourseAnnouncement;?></td>
    <td width="25%" class="mini"><a href="editfolders.php?folders=0&courses=<? echo $courses?>"> 
      <img src="../images/_tools.gif"  border="0"></a><br>
      <? echo $strCourses_LabCourseTools;?></td>
    <td width="25%" class="mini"><a href="../system/index.php?m=report&a=all&courses=<? echo $courses?>"><img src="../images/report.gif" width="47" height="47"  border="0"></a><br>
    <? echo $strSystem_LabReport;?></td>
    <td width="25%" class="mini">&nbsp;</td>    
  </tr>
</table>
-->
<?php } ?>
<br />

<iframe src="https://course.ku.ac.th/maxlife/facebook_wallpost/index.php?user=<? echo $person["login"];?>&course=<? echo $courses;?>" width="100%" height="440" frameborder="0">
                  <p>Your browser does not support iframes.</p>
</iframe>

<?   if(mysql_num_rows($news)!=0)
			{		 ?>
<br>
<tr>
  <div class="mini" align="center"><img src="../images/annouce.gif" ><b><u><br>
    Announcement</u></b></div>
</tr><br>
<table width="70%" border="0" align="center" cellpadding="2" cellspacing="1" class="tdborder2">
	  <tr align="center" class="boxcolor"> 
		<td width="14%"  class="main_white"><?=$strCourses_NewsPicture;?></td>
		<td width="69%"  class="main_white"><?=$strCourses_NewsSubject;?></td>
		<? if (mysql_num_rows($checkowner)!=0) {?>
		<td width="17%"   class="main_white">Action</td>
	  <? }?>
	  </tr>
	<?
														
	
	
	
	while ($row = mysql_fetch_array($news)) { 
	$color = $color=="bgcolor=\"#FFFFFF\""?"class=\"tdbackground1\"":"bgcolor=\"#FFFFFF\"";	
	?>
	
	
	  <tr <?=$color;?>> 
		<td align="center">
			 <? if($row["picture"]!="") {?>
			<a   class="AS" href="#" onClick="NewWindow('../courses/news_detail.php?id=<? echo $row["id"] ;?>&courses=<? echo $courses;?>','name','650','500','yes');return false" > 
                   <? echo "<img src=\"../files/news_courses/$courses/thumbnail/".$row["picture"]."\" width=\"60\" height=\"60\" border=\"0\">";?>
			             		
										</a>
			<?
			//echo "<a  href=\"?a=view&id=".$row["id"]."&courses=$courses\"><img src=\"../files/news_courses/$courses/thumbnail/".$row["picture"]."\" width=\"60\" height=\"60\" border=\"0\"></a>";
			}else {
			
			echo "<img src=\"images/nopic.gif\" width=\"60\" height=\"60\" border=\"0\">";
			}
			?>
		</td>
	   <td align="left" valign="top">
			<a   class="AS" href="#" onClick="NewWindow('news_detail.php?id=<? echo $row["id"] ;?>&courses=<? echo $courses;?>','name','650','500','yes');return false" > 
                                  		<? echo $row["subject"];?>
										</a><br>
			<? 
		
				                   
						  if(strlen($row["title"])>100) {
						  	echo substr($row["title"],0,100)."...";
						  }  else {
						  	echo $row["title"];
						  }
						echo "&nbsp;&nbsp;<span class=\"hilite\">(".$row["post_date"].")</span>";
				
			?>
		</td>
		<? if (mysql_num_rows($checkowner)!=0) {?>
		<td align="center">
			<a href="news/?a=news_addedit&id=<? echo $row["id"]; ?>&courses=<? echo $courses;?>" target="_self">
				<img src="images/icon/_edit-16.png" border="0" alt="edit">
			</a> 
			<a href="#" onclick = "iconfirm('news/?a=del&id=<? echo $row["id"]; ?>&courses=<? echo $courses?>','Do you want delete news?')">
			<img src="images/icon/_cancel-16.png" border="0" alt="delete">
		</a>
				
		</td>
	  <?  }?>
	  </tr>
	<? 
	
	}
	?>
</table>
<hr width="50%" align="center">

<? } // end if
		 if(trim($course["info"])!="")
		 { 		?>
			<tr>
  <div align="center" class="mini"><img src="../images/class_info.gif" ><b><u><br>
    Class Information</u></b></div>
</tr><br>
<!--
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td width="650" class="mini">
		<table width="485" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
 		   <tr>
          <td class="mini"><img src="../images/icon_circle(1).gif" > <? echo trim($course["info"]); ?></td>
        </tr> 				  
		</table></td>
  <td width="70">&nbsp;</td></tr>
</table>
-->
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td width="641">	  
	
  <table width="490" border="0" align="right" cellpadding="0" cellspacing="0"  bordercolor="#999999" >
	  <tr  class="tdbackground1"> 
          <td width="485" class="tdbottom-color"><img src="../images/_class.gif" > 
            <? echo trim($course["info"]); ?>
          </td>
	  </tr>
	</table>
		
	  </td>	
<?php  if (mysql_num_rows($checkowner)==1)
				   {     //if (mysql_num_rows($checkowner)!=0){	?>
		
    <td width="188" class="mini">&nbsp;</td>
	
 <?php
		 			 } else{  ?><td width="188">&nbsp;</td><?php   }   ?>
    </tr>
  </table>
  
   <?php }  ?>
  <?
  if ($courses == 560) {
  ?>
  <br>
<div align="center" class="mini"><img src="../images/_score.gif" ><b><u><br>
  Exam Evaluation<br>
  </u></b></div>
   <table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
	<td width="641">	  
	
  	<table width="490" border="0" align="right" cellpadding="0" cellspacing="0"  bordercolor="#999999" >
	  <tr  class="tdbackground1"> 
          <td width="485" class="tdbottom-color"><img src="../images/prefs.gif" > 
            <a href="../score/index.php?courses=<? echo $courses;?>">สามารถเข้ามาเพื่อให้คะแนนได้ที่นี่</a></td>
	  </tr>
	</table>
		
	  </td>	

    	<td width="188" class="mini">&nbsp;</td>
		<td width="188">&nbsp;</td>
    </tr>
  </table>
  <?
  }
  ?>
</body>
</html>
<? mysql_close();?>