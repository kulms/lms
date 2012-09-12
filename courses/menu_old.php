<?php
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
//  - - - - Add admin. can come inside courses - -  - -		
	/*	if($person["admin"]==1)
		{		$check=mysql_query("SELECT c.name,c.section,wp.admin, c.users FROM wp,courses c WHERE wp.courses=$courses 
										AND c.id=wp.courses AND wp.users=c.users;");
				$person["id"]=@mysql_result($check,0,"users");
		}else{		
				$check=mysql_query("SELECT c.name,c.section,wp.admin FROM wp,courses c WHERE wp.courses=$courses 
										AND c.id=wp.courses AND wp.users=".$person["id"].";");
					} 
	//   - - - - - - - - - -  END  Add admin. - - - - - - - - - - - - - - -
	 */
	
		if($person["admin"]==1){		
			$perm = mysql_query("SELECT * FROM sys_admin_per WHERE sys_admin_users=".$person["id"].";");

			if(@mysql_result($perm,0,"sys_padmin_courses")==1 || @mysql_result($perm,0,"sys_padmin_super")==1 || $person["admin"]==1){
			/*				
				$check=mysql_query("SELECT c.name,c.section,wp.admin 
															 FROM wp,courses c 
															 WHERE wp.courses=$courses AND c.id=wp.courses AND wp.users=".$person["id"].";");										
			*/
				$check=mysql_query("SELECT c.name,c.section
															 FROM courses c 
															 WHERE c.id=$courses ;");
				
				$courses_name=@mysql_result($check,0,"name");
			    $section=@mysql_result($check,0,"section");
			    $cadmin=1;
			}
		} else {	 	
			$check=mysql_query("SELECT c.name,c.fullname,c.section,wp.admin FROM wp,courses c WHERE wp.courses=$courses 
														 AND c.id=wp.courses AND wp.users=".$person["id"].";");					
			if(@mysql_num_rows($check)==0)
			{
				echo "YOU DO NOT HAVE ACCESS TO THIS COURSE!!!!!";
				exit();
			}else{			
			   $courses_name=@mysql_result($check,0,"name");
			   $courses_fullname=@mysql_result($check,0,"fullname");
			   $section=@mysql_result($check,0,"section");
			   $cadmin=@mysql_result($check,0,"admin");
			}
		}
		
		//log activity to login_course
		mysql_query("INSERT INTO login_course(users,courses,time) VALUES(".$person["id"].",$courses,".time().");");
		$addsql="AND m.active=1 ";
		if($showall=="true"){
		   $addsql="AND (m.active=1 or m.users=".$person["id"].") "; 
		}
		if(($cadmin==1 || $person["admin"]==1) && $showall=="true"){
		   $addsql="";
		   }
		//$doc_syllabus=mysql_query("SELECT s.syllabus_upload FROM syllabus s WHERE s.courses=$courses");
?>
<html>
<head>
<title>Course On Web - Courses</title>
<script language="javascript">function mmLoadMenus() {
  if (window.mm_menu_0919192756_0) return;
  window.mm_menu_0919192756_0 = new Menu("root",80,18,"",12,"#000000","#FFFFFF","#CCCCCC","#000084","left","middle",3,0,10,-5,7,true,true,true,0,true,true);
  mm_menu_0919192756_0.addMenuItem("แผนการเรียน");
   mm_menu_0919192756_0.hideOnMouseOut=true;
   mm_menu_0919192756_0.bgColor='#555555';
   mm_menu_0919192756_0.menuBorder=0;
   mm_menu_0919192756_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0919192756_0.menuBorderBgColor='#777777';

  window.mm_menu_0919192946_0 = new Menu("root",80,18,"",12,"#000000","#FFFFFF","#CCCCCC","#000084","left","middle",3,0,10,-5,7,true,true,true,0,true,true);
  mm_menu_0919192946_0.addMenuItem("สมาชิกรายวิชา");
   mm_menu_0919192946_0.hideOnMouseOut=true;
   mm_menu_0919192946_0.bgColor='#555555';
   mm_menu_0919192946_0.menuBorder=0;
   mm_menu_0919192946_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0919192946_0.menuBorderBgColor='#777777';

  window.mm_menu_0919194324_0 = new Menu("root",80,18,"",12,"#000000","#FFFFFF","#CCCCCC","#0000FF","left","middle",3,0,10,-5,7,true,true,true,0,true,true);
  mm_menu_0919194324_0.addMenuItem("ปฎิทินรายวิชา");
   mm_menu_0919194324_0.hideOnMouseOut=true;
   mm_menu_0919194324_0.bgColor='#555555';
   mm_menu_0919194324_0.menuBorder=0;
   mm_menu_0919194324_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0919194324_0.menuBorderBgColor='#777777';

  window.mm_menu_0919194432_0 = new Menu("root",100,18,"",12,"#000000","#FFFFFF","#CCCCCC","#0000FF","left","middle",3,0,10,-5,7,true,true,true,0,true,true);
  mm_menu_0919194432_0.addMenuItem("<? echo $courses_fullname;?>");
   mm_menu_0919194432_0.hideOnMouseOut=true;
   mm_menu_0919194432_0.bgColor='#555555';
   mm_menu_0919194432_0.menuBorder=0;
   mm_menu_0919194432_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0919194432_0.menuBorderBgColor='#777777';

mm_menu_0919194432_0.writeMenus();
} // mmLoadMenus()
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
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
<link rel="STYLESHEET" type="text/css" href="../main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />-->
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script language="JavaScript" src="mm_menu.js"></script>
</head>
<body bgcolor="#CC0033" topmargin="0" leftmargin="0"
text="#FFFF00" link="#FFFF00" vlink="#FFFF00" alink="#FFFF00"
onLoad="top.ws_main.location.href='activity.php?courses=<? echo $courses?>';">
<script language="JavaScript1.2">mmLoadMenus();</script>
<table  border="0" cellspacing="2" cellpadding="1" align="center">
  <tr> 
    <td width="2%">&nbsp;</td>
    <td width="98%"><table border="0" cellpadding="0" cellspacing="0" >
        <tr> 
          <td class="yellow" nowrap> &nbsp; <img src="../images/courses.gif" width=20 height=16 alt="" border="0" align="top"> 
            <a href="activity.php?courses=<? echo $courses?>" name="link4" target="ws_main" class="a11"  title="<? echo $courses_fullname;?>"> 
            <? echo $courses_name?></a> 
            <? if ($section != "") { ?>
            <font color="#FF9999">(</font><font color="#66FF33"> <? echo $section; ?> 
            </font><font color="#FF9999">)</font> 
            <? }?>
          </td>
          <td class="menu" nowrap> 
            <!--<a href="../courses/editfolders.php?folders=0&courses=<? echo $courses?>" target="ws_main"> 
		<img src="../images/tool.gif" width=18 height=16 alt="Add" border="0" align="top"> 
		</a>-->
          </td>
        </tr>
        <tr> 
          <td class="menu" nowrap><img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"> 
          </td>
        </tr>
        <tr> 
          <td height="16" colspan="2" nowrap class="menu"> <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
            &nbsp; <img src="../images/file.gif" alt="" width="20" height="16" border="0" align="top"> 
            <a href="../syllabus/index.php?courses=<? echo $courses?>" target="ws_main" class="a11" ><? echo $strCourses_LabCourseSyllabus;?></a></td>
        </tr>
        <!--
  <tr> 
    <td nowrap class="menu"> <img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"> 
      <img src="../images/l_out.gif" width=18 height=16 alt="" border="0" align="top"> 
      <img src="../images/syllabuspiz.gif" alt="" width="20" height="15" border="0" align="top"> 
      <?php  
	$check_syl=mysql_query("SELECT syl.syllabus_upload FROM syllabus syl WHERE syl.courses=$courses;");
	if($check_syl!=""){ 
		?>
      <a href="../files/syllabus/10-1.pdf" target="ws_main">SyllabusDoc</a> 
      <?php }else{
        echo"SyllabusDoc"; 
           } 
?>
    </td>
  </tr>
  <tr> 
<?php 
//$news=mysql_query("SELECT u.category FROM users u, courses c WHERE u.category=c.users");
	   if(($person["category"]==2)||($person["category"]==0))
	   {    ?>
	   <td nowrap class="menu">
		  <img src="../images/l_out.gif" width=20 height=17 alt="" border="0" align="top"> 
		  <img src="../images/new.gif" width="20" height="15">
			<a href="../courses/news.php?&courses=<? echo $courses; ?>" target="ws_main">News</a>
	   </td>
<?PHP } ?>
  </tr>  -->
        <tr> 
          <td class="menu" nowrap colspan="2"> <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
            &nbsp;<img src="../images/users_many.gif" width=20 height=16 alt="" border="0" align="top"> 
            &nbsp;<a href="users.php?courses=<? echo $courses; ?>"  target="ws_main" class="a11"><? echo $strCourses_LabCourseMember;?></a> </td>
        </tr>
        <tr> 
          <td class="menu" nowrap colspan="2"> <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp; 
            <img src="../images/calendar.gif" width=20 height=16 alt="Course calendar (<? echo $courses_name; ?>)" border="0" align="top"> 
            &nbsp;<a href="../calendar/index.php?courses=<? echo $courses; ?>"  target="ws_main" class="a11"><? echo $strCourses_LabCourseCalendar;?></a> 
          </td>
        </tr>
		  <tr> 
          <td class="menu" nowrap colspan="2"> <img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top">&nbsp;   
		  <img src="../images/grade.gif" width=20 height=20 align="top">     
		  <?php 
		  $grade_sql = "SELECT * FROM g_grade WHERE g_courses = $courses;";
		  $grade_query = mysql_query($grade_sql);
		  $grade_result = mysql_fetch_array($grade_query);
		   ?>     
            &nbsp;<a href="../grade/index.php?courses=<? echo $courses; ?>&id=<?php echo $grade_result["g_grade_id"];?>"  target="ws_main" class="a11"><? echo "Grading";?></a> 
          </td>
        </tr>
		<!--
		<tr> 
          <td class="menu" nowrap colspan="2"> <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp; 
            &nbsp;<a href="../grade/index_grade.php?courses=<? echo $courses; ?>"  target="ws_main" class="a11"><? echo "Grading";?></a> 
          </td>
        </tr>
		-->
        <?
        //****************************************folder_function*************************
        function showfolder($space,$folder){
                global $person,$courses,$showall,$cadmin,$addsql;
                $modules=mysql_query("SELECT Distinct mt.picture,m.id,m.users,m.active,m.name,mt.url,mt.url_admin,m.updated,m.updated_users,m.created , mt.id AS mt_type 
									  FROM modules m,wp,modules_type mt 
									  WHERE (wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=$folder AND wp.cases=0 AND wp.groups=0 $addsql) order by m.name;");
                while($row=mysql_fetch_array($modules)){
  ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../<? echo $row["picture"]?>" align="top" border=0 width=20 height=16> 
            &nbsp; <a href="../<? echo $row["url"]?>?id=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11"><? echo $row["name"]?></a> 
          </td>
          <td class="menu" nowrap> 
            <?						if ($row["mt_type"] != 3) {
	  							  
                                  $checkcreater=mysql_query("SELECT users FROM modules WHERE id=".$row["id"].";");
                                  if(($cadmin==1 || $person["admin"]==1 || @mysql_result($checkcreater,0,"users")==$person["id"] )){


                                   // if (mysql_result($checkcreater,0,"users")==$person["id"]){
      ?>
            <a href="../<? echo $row["url_admin"]?>?id=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11"> 
            <? //if ($row["mt_type"] != 7) {?>
            <img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"> 
            <? //}?>
            </a> 
            <? }
	  }
                                $sql="SELECT max(time) as time FROM login_modules WHERE users=".$person["id"]." AND modules=".$row["id"].";";
                                $check=mysql_query($sql);
                                if(mysql_num_rows($check)!=0){
                                        if((@mysql_result($check,0,"time")<$row["updated"])&&($row["updated_users"]!=$person["id"])){?>
            <img src="../images/newflag.gif" width=15 height=13 alt="Updated!" border="0" align="top"> 
            <? }
                                }else{
                                        if($row["updated"]!=$row["created"]){?>
            <img src="../images/newflag.gif" width=15 height=13 alt="Updated!" border="0"> 
            <? }
                                }
                                ?>
          </td>
        </tr>
        <?
                }//end while
                $folders=mysql_query("SELECT distinct f.name,f.id FROM folders f,wp WHERE wp.modules=0 AND wp.folders=f.id AND f.refid=$folder AND wp.courses=$courses AND f.courses=1 AND wp.cases=0 AND wp.groups=0 order by f.name;");
                while($row=mysql_fetch_array($folders)){
  ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><? echo $row["name"]?> 
          </td>
          <td class="menu"> <a href="../courses/editfolders.php?folders=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
          </td>
        </tr>
        <?
                        showfolder($space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$row["id"]);
                }
                $cases=mysql_query("SELECT c.name,c.id,c.active FROM cases c,wp WHERE wp.modules=0 AND wp.folders=$folder AND wp.courses=$courses AND wp.cases=c.id AND wp.groups=0 order by c.name;");
                while($row=mysql_fetch_array($cases)){
                        ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/cases.gif" width=20 height=15 alt="" border="0" align="top"><? echo $row["name"]?> 
          </td>
          <td class="menu"> <a href="../cases/editcases.php?folders=<? echo $folder?>&courses=<? echo $courses?>&cases=<? echo $row["id"]?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
          </td>
        </tr>
        <?
                        if($row["active"]==1 || $showall=="true"){
                                showcases($space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$folder,$row["id"]);
                        }
                }
                $groups=mysql_query("SELECT g.name,g.id,g.active FROM groups g,wp WHERE wp.modules=0 AND wp.folders=$folder AND wp.courses=$courses AND wp.cases=0 AND wp.groups=g.id order by g.name;");
                while($row=mysql_fetch_array($groups)){
                        $check=mysql_query("SELECT * from wp WHERE users=".$person["id"]." AND groups=".$row["id"].";");
                        if(mysql_num_rows($check)!=0 || $showall=="true"){
   ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/groups.gif" width=20 height=16 alt="" border="0" align="top"><?echo $row["name"]?> 
          </td>
          <td class="menu"> <a href="../groups/editgroups.php?folders=<? echo $folder?>&courses=<? echo $courses?>&cases=0&groups=<? echo $row["id"]?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
          </td>
        </tr>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/users_many.gif" width=20 height=16 alt="" border="0" align="top"><a href="../courses/users.php?groups=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11">Members</a> 
          </td>
          <td class="menu"> </td>
        </tr>
        <?
                                if(($row["active"]==1 && mysql_num_rows($check)!=0) || $person["admin"]==1 || $cadmin==1){
                                        showgroups($space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$folder,0,$row["id"]);
                                }
                        }
                }
        }
        //****************************************cases_function*************************
        function showcases($space,$folder,$case){
                global $person,$courses,$showall,$cadmin,$addsql;
                $modules=mysql_query("SELECT mt.picture,m.id,m.name,mt.url,mt.url_admin,m.updated,m.created,m.updated_users FROM modules m,wp,modules_type mt WHERE wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=$folder AND wp.cases=$case AND wp.groups=0 $addsql order by m.name;");
                while($row=mysql_fetch_array($modules)){
    ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space ?> <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="../<? echo $row["url"]?>?id=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11">&nbsp;<img src="../<? echo $row["picture"]?>" align="top" border=0><? echo $row["name"]?></a> 
          </td>
          <td class="menu" nowrap> <a href="../<? echo $row["url_admin"]?>?id=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
            <?
                                        $sql="SELECT max(time) as time FROM login_modules WHERE users=".$person["id"]." AND modules=".$row["id"].";";
                                        $check=mysql_query($sql);
                                        if(mysql_num_rows($check)!=0){
                                                if((@mysql_result($check,0,"time")<$row["updated"])&&($row["updated_users"]!=$person["id"])){
	   ?>
            <img src="../images/newflag.gif" width=15 height=13 alt="Updated!" border="0" align="top"> 
            <? }
                                        }else{
                                                if($row["updated"]!=$row["created"]){?>
            <img src="../images/newflag.gif" width=15 height=13 alt="Updated!" border="0"> 
            <? }
                                        }
                                        ?>
          </td>
        </tr>
        <?
                }
                $folders=mysql_query("SELECT f.name,f.id FROM folders f,wp WHERE wp.modules=0 AND wp.folders=f.id AND f.refid=$folder AND wp.courses=$courses AND wp.cases=$case AND wp.groups=0 order by f.name;");
                while($row=mysql_fetch_array($folders)){
                        ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><? echo $row["name"]?> 
          </td>
          <td class="menu"> <a href="../courses/editfolders.php?folders=<? echo $row["id"]?>&courses=<? echo $courses?>&cases=<? echo $case?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
          </td>
        </tr>
        <?
                        showcases($space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$row["id"],$case);
                }
                $groups=mysql_query("SELECT g.name,g.id,g.active FROM groups g,wp WHERE wp.modules=0 AND wp.folders=$folder AND wp.courses=$courses AND wp.cases=$case AND wp.groups=g.id order by g.name;");
                while($row=mysql_fetch_array($groups)){
                        $check=mysql_query("SELECT * from wp WHERE users=".$person["id"]." AND groups=".$row["id"].";");
                        if(mysql_num_rows($check)!=0 || $showall=="true"){
   ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/groups.gif" width=20 height=16 alt="" border="0" align="top"><? echo $row["name"]?> 
          </td>
          <td class="menu"> <a href="../groups/editgroups.php?folders=<? echo $folder?>&courses=<? echo $courses?>&cases=<? echo $case?>&groups=<? echo $row["id"]?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
          </td>
        </tr>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/users_many.gif" width=20 height=16 alt="" border="0" align="top"><a href="../courses/users.php?groups=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11">Members</a> 
          </td>
          <td class="menu"> </td>
        </tr>
        <?
                                if(($row["active"]==1 && mysql_num_rows($check)!=0) || $person["admin"]==1 || $cadmin==1){
                                        showgroups($space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$folder,$case,$row["id"]);
                                }
                        }
                }
        }
        //****************************************groups_function*************************
        function showgroups($space,$folder,$case,$group){
                global $person,$courses,$showall,$cadmin,$addsql;
                $modules=mysql_query("SELECT mt.picture,m.id,m.name,mt.url,mt.url_admin,m.updated,m.created,m.updated_users FROM modules m,wp,modules_type mt WHERE wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=$folder AND wp.cases=$case AND wp.groups=$group $addsql order by m.name;");
                while($row=mysql_fetch_array($modules)){
 ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="../<? echo $row["url"]?>?id=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11">&nbsp;<img src="../<? echo $row["picture"]?>" align="top" border=0><? echo $row["name"]?></a> 
          </td>
          <td class="menu" nowrap> <a href="../<? echo $row["url_admin"]?>?id=<? echo $row["id"]?>&courses=<? echo $courses?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
            <?
                                        $sql="SELECT max(time) as time FROM login_modules WHERE users=".$person["id"]." AND modules=".$row["id"].";";
                                        $check=mysql_query($sql);
                                        if(mysql_num_rows($check)!=0){
                                                if((@mysql_result($check,0,"time")<$row["updated"])&&($row["updated_users"]!=$person["id"])){   ?>
            <img src="../images/newflag.gif" width=15 height=13 alt="Updated!" border="0" align="top"> 
            <? }
                                        }else{
                                                if($row["updated"]!=$row["created"]){   ?>
            <img src="../images/newflag.gif" width=15 height=13 alt="Updated!" border="0"> 
            <? }
                                        }   ?>
          </td>
        </tr>
        <?    }
                $folders=mysql_query("SELECT f.name,f.id FROM folders f,wp WHERE wp.modules=0 AND wp.folders=f.id AND f.refid=$folder AND wp.courses=$courses AND wp.cases=$case AND wp.groups=$group order by f.name;");
                while($row=mysql_fetch_array($folders)){  ?>
        <tr> 
          <td class="menu" nowrap> <? echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><? echo $row["name"]?> 
          </td>
          <td class="menu"> <a href="../courses/editfolders.php?folders=<? echo $row["id"]?>&courses=<? echo $courses?>&cases=<? echo $case?>&groups=<? echo $group?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> 
          </td>
        </tr>
        <?
                        showgroups($space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$row["id"],$case,$group);
                }
        }
        showfolder('',0);

        if(($cadmin==1 || $person["admin"]==1)){?>
        <tr> 
          <!--<td class="menu" nowrap> <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
      <a href="head_admin.php?courses=<? echo $courses?>" target="ws_main"> <i>Administration</i></a> 
    </td>-->
          <td class="menu">&nbsp;</td>
        </tr>
        <? }  ?>
      </table></td>
  </tr>
</table>
<?
						  $student=mysql_query("SELECT COUNT(users) AS sum FROM login_courses WHERE courses=$courses;");
						  $row_s = @mysql_fetch_array($student);
?>
<br>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center"> 
    <td colspan="2" nowrap  class="menu">&nbsp; <img src="../images/groups.gif" width=20 height=16 alt="" border="0" align="top">Using 
      this Course &nbsp;</td>
  </tr>
  <tr> 
    <td class="menu" nowrap>&nbsp;</td>
    <td class="menu" nowrap>&nbsp;</td>
  </tr>
  <tr> 
    <td align="center" nowrap class="menu">&nbsp;Members : </td>
    <td class="yellow" nowrap>&nbsp;<B  onClick="NewWindow('member.php?courses=<? echo $courses;?>','name','400','400','yes');return false" style="cursor:hand"><U><? echo $row_s["sum"];?></U></B> 
      member(s)</td>
  </tr>
</table>
<br>
<div class="small" align="center"> 
  <? if($showall=="true"){?>
  <a href="menu.php?courses=<? echo $courses?>" class="a11"><img src="../images/showactive.gif" width=54 height=15 alt="Show only active modules" border="0"></a> 
  <? }else{ ?>
  <a href="menu.php?courses=<? echo $courses?>&showall=true" class="a11"><img src="../images/showall.gif" width=37 height=14 alt="Expand all inactive cases, groups and folders." border="0"></a> 
  <? }?>
</div>
</body>
</html>
<? mysql_close();?>