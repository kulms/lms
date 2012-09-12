<?php 
	session_start();
	$session_id = session_id();		
    require ("../include/global.php");   
	require ("../include/global_login.php");        
	require("../include/online.php");
	online($session_id,time(),$session_id,$person["category"],$person["id"]);
	online_courses($session_id,0,0,time(),0);
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );
											
	$user = UserStorage::lookupById($person["login"]);
	
	session_register( 'user' ); 
			
?>
<html>
<head>
<title>Courses - Faculty of Engineering , Kasetsart University</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
</head>
<!--
<body background="../top-images/bgmenu.gif" topmargin="0" leftmargin="0"
text="#FFFF00" link="#FFFF00" vlink="#FFFF00" onLoad="top.ws_main.location.href='../system/info.php';">
-->	
<body  topmargin="0" leftmargin="0"
 onLoad="top.ws_main.location.href='../system/index.php';" class="lmnbg">
<br>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr> 
    <td class="yellow" nowrap><img src="../images/icon_homepage.gif" width=15 height=15 alt="" border="0" align="top"><b> 
      <?php echo $user->_($strSystem_LeftMenu);?></b> </td>
  </tr>
  <?php
  	if ($person["category"] == 1) {
  ?>
   <!--
  <tr> 
    <td class="menu" nowrap> <img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"> 
    </td> 
  </tr>	
 
  <tr> 
    <td class="menu" nowrap><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
      <img src="../images/icon_user.gif" width=15 height=15 alt="" border="0" align="top"> 
      <a href="index.php?m=users" target="ws_main" class="a11"> Users</a></td>
  </tr>
  
  <tr> 
    <td class="menu" nowrap> <img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"></td>
  </tr>
  
  <tr> 
    <td class="menu" nowrap><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
      <img src="../images/icon_go_up.gif" width=15 height=15 alt="" border="0" align="top"> 
      <a href="index.php?m=system" target="ws_main" class="a11"> System</a></td>
  </tr> 
  -->
  <?php
  }
  ?>
</table>
</body>
</html>