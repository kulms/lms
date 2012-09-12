<?php 
	session_start();
	$session_id = session_id();		

	require ("../include/global_login.php");        
	require("../include/online.php");
//	online($session_id,time(),$session_id,$person["category"],$person["id"]);
//	online_courses($session_id,0,0,time(),0);
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );
	//require_once( "./modules/advisor/advisor.class.php");
											
	$user = UserStorage::lookupById($person["login"]);
	//echo "hello";
	//session_register( 'user' ); 		
	$_SESSION['user'] = $user;
	//require_once( "./modules/advisor/advisor.inc");		
?>
<html>
<head>
<title>Courses - Faculty of Engineering , Kasetsart University</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<!--<body  topmargin="0" leftmargin="0" text="#FFFF00" link="#FFFF00" vlink="#FFFF00" onLoad="top.ws_main.location.href='../courses/info.php';" class="lmnbg">-->
<!--<body  topmargin="0" leftmargin="0" text="#FFFF00" link="#FFFF00" vlink="#FFFF00" onLoad="top.ws_main.location.href='../info.php';" class="lmnbg">-->
<body  topmargin="0" leftmargin="0" text="#FFFF00" link="#FFFF00" vlink="#FFFF00" onLoad="top.ws_main.location.href='https://course.ku.ac.th/maxlife/facebook_wallpost/index.php?user=<? echo $person["login"];?>';" class="lmnbg">

	<table border="0" cellpadding="0" cellspacing="0" align="center">
		 <tr>
			<td  nowrap class="yellow">&nbsp;<img src="../images/courses.gif" width=20 height=16 alt="" border="0" align="top">
			<b><? echo $strCourses_MenuMainCourses;?></b>			   
<?php  		//-------------------------- Admin  Course ---------------------------------------//
			//if($person["admin"]==1)
			//{  
?>
				<!--
				<a href="admin_course.php" target="ws_main">
				<img src="../images/tool.gif" width=18 height=16 alt="Admin courses" border="0" align="top">
				</a>
				-->
<?php   
			//}
			//-------------------------- Admin  Course ---------------------------------------//				
?>
			</td>
		 </tr>
		 <tr>
			<td class="menu" nowrap>
				<img src="../images/l_down.gif" width=16 height=16 alt="" border="0" align="top">
			</td>
		 </tr>
		 <tr>
			<td class="menu" nowrap>
				<img src="../images/l_out.gif" width=16 height=16 alt="" border="0" align="top">
				<img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><? echo $strCourses_MenuActiveCourses;?></td>
		 </tr>		
		<?php   
		// ---------- Query Course -----------------//
		/*
		if($person["admin"]==1)
			$courses=mysql_query("SELECT DISTINCT c.name,c.id,c.section 
								  FROM courses c 
							  	  ORDER by c.name asc;");	
		else		
		*/
		// add checking for whom create this course
		/*
		$courses=mysql_query("SELECT DISTINCT c.name,c.id,c.section,wp.admin,c.users, c.fullname 
							  FROM courses c,wp 
							  WHERE wp.courses=c.id AND wp.users=".$person["id"]." AND c.active=1 GROUP BY wp.courses 
							  ORDER by c.name asc;");
		*/
		$drop_courses= mysql_query("SELECT courses FROM drop_courses WHERE users =".$person["id"].";");
				$d_c = "(";
				while($r_dc = mysql_fetch_array($drop_courses)){
					$d_c .= $r_dc["courses"].",";
				}
				$d_c = substr($d_c,0,strlen($d_c)-1);
				$d_c .= ")";
				if(strlen($d_c) > 1) {
				$courses=mysql_query("SELECT DISTINCT c.name,c.id,c.section,wp.admin,c.users, c.fullname 
							  FROM courses c,wp , drop_courses dc
							  WHERE wp.courses=c.id AND wp.users=".$person["id"]." AND c.active=1 AND wp.courses not in ".$d_c." AND c.id not in ".$d_c."
							  AND dc.status =0   GROUP BY wp.courses 
							  ORDER by c.name asc;");											  												  
					} else {
						$courses=mysql_query("SELECT DISTINCT c.name,c.id,c.section,wp.admin,c.users, c.fullname 
							  FROM courses c,wp 
							  WHERE wp.courses=c.id AND wp.users=".$person["id"]." AND c.active=1 GROUP BY wp.courses 
							  ORDER by c.name asc;");
					}		  
		// check only admin of this course
	 	/*$courses=mysql_query("SELECT DISTINCT c.name,c.id,c.section,wp.admin FROM courses c,wp 
	 						 WHERE wp.courses=c.id AND wp.users=".$person["id"]." AND c.active=1 GROUP BY wp.courses 
	   						 ORDER by c.name asc;"); */
        while($row=mysql_fetch_array($courses))
		{                
//echo $row["no"];?>
		<tr>
			<td class="menu" nowrap><img src="../images/l_down.gif" width=16 height=16 alt="" border="0" align="top"> 
				  <img src="../images/l_out.gif" width=16 height=16 alt="" border="0" align="top"> 
				  <a href="../courses/menu.php?courses=<? echo $row["id"]; ?>" target="ws_menu" class="a11" title="<? echo $row["fullname"];?>"> 
				  <img src="../images/courses.gif" width=20 height=16 alt="<? echo $row["fullname"];?>" border="0" align="top"><? echo $row["name"]; ?> 
				  </a> 
<? // -------- Section ----//
	if ($row["section"] != "") 
	{ ?>
				  <font color="#FF9999">(</font><font color="#66FF33"><? echo $row["section"]; ?></font><font color="#FF9999">)</font> 
<? }
	// -------- End Section ----//
	?>
			</td>
			 <td width="17" class="menu">
<?	//if($row["admin"]==1 || $person["admin"]==1 )
		// Added check for owner course
		if($row["admin"]==1 || $person["admin"]==1 || $row["users"]==$person["id"])
		{ ?>
                 <!--
				 <a href="../courses/admin_course.php?courses=<? echo $row["id"]; ?>" target="ws_main" class="a11">
			 	 <img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a>
				 -->
<?      
		} 
  $sql="SELECT max(m.updated) AS updated, max(lm.time) AS time,m.id FROM modules m,wp,login_modules lm WHERE wp.courses=".$row["id"]." AND wp.modules=m.id AND wp.modules=lm.modules AND lm.users=".$person["id"]." AND m.updated_users <> ".$person["id"]." GROUP BY m.id HAVING time<updated;";
  $updated=mysql_query($sql);
    if($ud=mysql_fetch_array($updated))
	{
      if($ud["time"]<$ud["updated"])
	  {
?>				</td><td width="588" class=menu><img src="../images/newflag.gif" width=15 height=13 alt="Updated!" border="0">
<?    }
                        }
?>
				   </td>
			</tr>
<? } ?>
			<tr>
					<td class="menu" nowrap><img src="../images/l_down.gif" width=16 height=16 alt="" border="0" align="top">
					</td><td></td>
			</tr>
<tr>
<td>
<?  $check=mysql_query("SELECT * FROM users WHERE category=2 and id=".$person["id"].";");
	if(mysql_num_rows($check)==1)
	{
?>						<tr>
                                <td class="menu" nowrap>
								<img src="../images/l_down.gif" width=16 height=16 alt="" border="0" align="top"></td><td></td>
                        </tr>
                        <tr>
                                
    <td class="menu" nowrap><img src="../images/l_out.gif" width=16 height=16 alt="" border="0" align="top"> 
      <img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"> 
      <a href="create_form1.php" target="ws_main" class="a11"><? echo $strCourses_MenuCreateCourses;?></a></td>
                        </tr>

                                                <tr>
                                <td class="menu" nowrap>
								<img src="../images/l_down.gif" width=16 height=16 alt="" border="0" align="top"></td><td></td>
                        </tr>
                        <tr>
                                <td class="menu" nowrap><img src="../images/l_out.gif" width=16 height=16 alt="" border="0" align="top">
								<img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top">
								<a href="delete_form.php" target="ws_main" class="a11"><? echo $strCourses_MenuDelCourses;?></a></td>
                        </tr>

        <?
        $courses=mysql_query("SELECT DISTINCT c.name,c.id FROM wp,courses c WHERE wp.users=".$person["id"]." AND wp.courses=c.id AND wp.admin=1 
							  AND c.active=0;");
        if($person["admin"]==1 || mysql_num_rows($courses)!=0)
		{
                /*
				if($person["admin"]==1)
				{
                   $courses=mysql_query("SELECT c.name,c.id,c.active from courses c WHERE c.active=0 ORDER by c.name asc;");
                }
				*/
                if(mysql_num_rows($courses)>0)
				{      ?>
                        <tr>
                                <td class="menu" nowrap><img src="../images/l_down.gif" width=16 height=16 alt="" border="0" align="top">
								</td><td></td>
                        </tr>
                        <tr>
                                
    <td class="menu" nowrap><img src="../images/l_out.gif" width=16 height=16 alt="" border="0" align="top"> 
      <img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><? echo $strCourses_MenuInActiveCourses;?></td>
                        </tr>
                        <?
                }
                while($row=mysql_fetch_array($courses))
				{       ?>
                        <tr>                                
							<td class="menu" nowrap><img src="../images/l_down.gif" width=16 height=16 alt="" border="0" align="top">
							<img src="../images/l_out.gif" width=16 height=16 alt="" border="0" align="top">
							<img src="../images/courses.gif" width=20 height=16 alt="" border="0" align="top"> 
							<a href="../courses/menu.php?courses=<? echo $row["id"]; ?>" target="ws_menu" class="a11"><? echo $row["name"]; ?></a> 
							</td>
							<td class="menu">
									<!--
									<a href="../courses/admin_course.php?courses=<? echo $row["id"]; ?>" target="ws_main" class="a11">
									<img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a>
									-->
							</td>
                        </tr>
                        <?
                }
        }

}        ?>
</tr>
</table>
</body>
</html>
<? mysql_close(); ?>
