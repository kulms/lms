<?php	
	require ("include/global_login.php");
	if (isset($_SESSION["person_id"]))
	{ ?>
        <HTML><HEAD><TITLE> M@xLearn e-Learning :: <?php echo $person["title"].$person["firstname"]."  
        ".$person["surname"];?></TITLE>
        <META content="text/html; charset=windows-874" http-equiv="content-type">
        <META content="Maxlearn,course,VirtualClassroom,webcourse,การเรียนการสอน" name="Keywords">
        <META content="Course on Web  , Virtual Classroom for supporting all course @ Faculty of Engineering , Kasetsart University " name="description">
        </HEAD>
        <FRAMESET border="0" cols="100%" frameBorder="0" frameSpacing="0" rows="135,*">
        <FRAME frameBorder="0" marginHeight="1" marginWidth="1" name="ws_top" scrolling="no" src="top.php">
        <FRAMESET cols="181,*" frameBorder="0" frameSpacing="0" rows="100%">
        <FRAME frameBorder="No" marginHeight="1" marginWidth="1" name="ws_menu"
        scrolling="auto"
        src="courses/menu_courses.php">
        <FRAME frameBorder="0" marginHeight="1" marginWidth="1" name="ws_main" src="dummy.html">
        </FRAMESET>
        </frameset><noframes></noframes></HTML>
<?php
		}else{
			?>
            
<meta http-equiv="refresh" content="0;url=https://<?php echo $_SERVER["HTTP_HOST"];?>/uat_lms/login1/ilogins.php">
 <?php
      }
?>
