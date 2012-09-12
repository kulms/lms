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
<title>Course on Web - Personal</title>
<script language="javascript">
function closeIt()
{
      self.window.close();
}
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">

</head>
<body class = "lmnbg" topmargin="0" leftmargin="0"
text="#FFFFFF" link="#FFFF00" vlink="#FFFF00" alink="#FFFF00"
onLoad="top.ws_main.location.href='<?php if($no_info){
                        echo "../personal/prefs.php?";
				}else if($msg==1){
                        echo "../personal/msg/index.php"; 
				}else if($calendar==1){
						 echo "../calendar/index.php?courses=-1";
				}else{
                
                        echo "../personal/info.php?userid=$userid"; 
						
				}?>'; ">
<?php        if($no_info)
                        print( "<script language=javascript> alert(\"The system has nothing about your info. Please fill your info in the form below. \"); </script>");
?>
<br>
<table width="125" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="yellow" nowrap><img src="../images/icon_user.gif" width=15 height=15 alt="" border="0" align="top"> 
      <b> 
      <?php   echo $person["firstname"];
                echo "(";
                echo $person["login"];
                echo ")";
        ?>
      </b></td>    
  </tr>
  <tr>
    <td class="menu" nowrap colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"></td>
  </tr>
    <tr>
	<!--
    <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/mail.jpg" width="15" height="11"> 
       &nbsp;&nbsp;<a href="check_mail.php" target="ws_main" class="a11">KU Mail </div> 
      </a> </td>
	-->  
  </tr>
  <tr>
    <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/calendar.gif" width=20 height=16 alt="" border="0" align="top"> 
      <a href="../calendar/index.php?courses=-1" target="ws_main" class="a11"><?php echo $strPersonal_MenuCalendar;?></a></td>
  </tr>
  <!--
    <tr>
    <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/develop.gif" align="top"> 
      <a href="msg/index.php" target="ws_main" class="a11"><?php echo $strPersonal_MenuMsg;?></a></td>
  </tr>
  -->
  <?php if ($person["category"] == 1 || $person["category"] == 2 || $person["category"] == 4)
        {        ?>
  		
  <tr>   
	<td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<a href="../dms/index.php" target="ws_main" class="a11">Research</a></td>
  </tr>
  
  <?php }
//if ($person["category"] == 3 && $person["login"] =="g4165265")
if ($person["category"] == 3)
   {        
   $s=substr($person["login"],0,1);
   //echo $s;
	   if ($s == "g") {
	   ?>
	   
	  <tr>
		
    <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<a href="../dms/index.php" target="ws_main" class="a11">Thesis/IS</a></td>
	  </tr>
	  
	  <?php } else {?>
	  
	  <tr>
		
    <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top">&nbsp;<a href="../dms/index.php" target="ws_main" class="a11">Project</a></td>
	  </tr>
	  
	  <?php
	  	 }
	  ?>
  <?php } ?>
  
  <?php
   //if ($person["login"] =="suthee")
   //{        
  ?>
  <!-- 
  <tr>
    <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/cases.gif" width=20 height=16 alt="" border="0" align="top"><a href="../cases/index.php" target="ws_main" class="a11">&nbsp;Briefcase</a></td>
  </tr>
  -->
  <?php //} ?>
  
  <?php
  /*
        function showfolder($space,$folder)
                {       global $person;
                $modules=mysql_query("SELECT mt.picture,m.id,m.name,mt.url,mt.url_admin FROM modules m,wp,modules_type mt WHERE wp.users=".$person["id"]." AND wp.modules=m.id AND wp.courses = 0 AND m.modules_type=mt.id AND wp.folders=$folder;");
                while($row=mysql_fetch_array($modules))
                                {         ?>
                                  <tr>
                                        <td class="menu" nowrap> <?php echo $space?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="../<?php echo $row["url"] ?>?id=<?php echo $row["id"]?>" target="ws_main" class="a11"><img src="../<?php echo $row["picture"]; ?>" align="top" border=0><?php echo $row["name"]; ?></a>
                                        </td>
                                        <td class="menu" nowrap> <a href="../<?php echo $row["url_admin"]; ?>?id=<?php echo $row["id"]; ?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a>
                                        </td>
                                  </tr>
                                  <?php
                                }
                $folders=mysql_query("SELECT f.name,f.id FROM folders f,wp WHERE wp.modules=0 AND wp.folders=f.id AND f.refid=$folder AND wp.users=".$person["id"].";");
                while($row=mysql_fetch_array($folders))
                                {  ?>
                                  <tr>
                                        <td class="menu" nowrap><?php echo $space; ?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><?php echo $row["name"]; ?>
                                        </td>
                                        <td class="menu"><a href="../personal/admin.php?folders=<?php echo $row["id"]; ?>" target="ws_main" class="a11"><img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a></td>
                                  </tr>
                                  <?php
                                  showfolder($space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$row["id"]);
                }
        }
        showfolder('',0);
		*/
                ?>
        </tr>
        <tr>
    <!--                
    <td colspan="2" nowrap class="menu"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="../personal/manage.php?courses=0" target="ws_main" class="a11">&nbsp;Usage 
      Quota </a></td>
	-->  
  </tr>
</table>
</body>
</html>
<?php mysql_close(); ?>