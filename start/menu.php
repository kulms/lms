<?php 
session_start();
$session_id = session_id();

require("../include/global_login.php");
require("../include/online.php");
online($session_id,time(),$session_id,$person["category"],$person["id"]);
online_courses($session_id,0,0,time(),0);
?>
<html>
<head>
        <title>Startmenu</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body class="lmnbg"    topmargin="0"  leftmargin="0" marginheight="0"  marginwidth="0"
 onLoad="top.ws_main.location.href='../info.php';">
<font color="#E62B5E"></font> <br>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
  <tr>
    <td class="menu" nowrap>
      <!img src="../images/wsmini.gif" width=20 height=16 alt="" border="0" align="top">
      <div align="center">
        <table width="93%" border="0" cellpadding="2" cellspacing="2">
          <tr> 
            <td class="menu" nowrap> <div align="left"> 
                <p><img src="../images/sel.gif" border=0 align="top"> 
                  <!--<a href="../resources_center/index.php" target="ws_main"> -->
                  <a href="../resources_center/index.php" target="ws_main" class="a11"> 
                  <?php echo $strStart_MenuECourse;?></a> </p>
              </div></td>
          </tr>
          <tr> 
            <td class="menu" nowrap> <div align="left"> 
                <p><img src="../images/sel.gif" border=0 align="top"> <a href="../courses/statistic.php" target="ws_main" class="a11"> 
                  <?php echo $strStart_MenuStat;?></a></p>
              </div></td>
          </tr>
	<!--
	<tr><td class="menu" nowrap><div align="left">
		<p><img src="../images/sel.gif" border=0 align="top"><a href="../files/mm_fl_sw_installer.msi" target="_blank" class="a11">&nbsp;Macromedia Flash Plug-in</a></p>
	</div></td></tr>
	<tr><td class="menu" nowrap><div aligh="left">
		<p><img src="../images/sel.gif" border=0 align="top"><a href="../files/msjavx86.exe" target="_blank" class="a11">&nbsp;Java Plug-in</a></p>
	</div></td></tr>
	-->
	<tr><td class="menu" nowrap><div aligh="left"> 
                <p><img src="../images/sel.gif" border=0 align="top"> <a href="../manual/index.php"  target="ws_main" class="a11">คู่มือการใช้งาน (Manual)
                  </a></p>
	</div></td></tr>
        </table>     
      </div>
    </td>
  </tr>

</table>
</body>
</html>
<?php  mysql_close();  ?>
