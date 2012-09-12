<? 
 session_start();
$session_id = session_id();
require ("../include/global_login.php");
require("../include/online.php");
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
?>
<html>
<head><link rel="STYLESHEET" type="text/css" href="../main.css">
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #000099; text-decoration: none}
a:visited { color: #000099; text-decoration: none}
a:active { color: #000099; text-decoration: underline}
a:hover { color: #000099; text-decoration: underline}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" background="../images/headerbg.gif" height="53">
  <tr><td class="menu" align="center"><b>Course  Area</b></td></tr>
</table>
<br>
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="100%" class="std" cellpadding="2" cellspacing="1">
        <tr> 
          <td align="center" class="news"><a href="create_form_1.php"><img src="../images/_tools.gif" width="48" height="47" border="0"></a><br>
            <a href="create_form_1.php">วิธีที่ 1</a></td>
          <td class="news"><a href="create_form_1.php">Create Course โดยดึงข้อมูลจากสำนักบริการคอมพิวเตอร์</a></td>
        </tr>
        <tr> 
          <td width="19%" class="news"><div align="center"><a href="create_form1.php"><img src="../images/_tools.gif" width="48" height="47" border="0"></a><br>
              <a href="create_form1.php">วิธีที่ 2</a><br>
            </div></td>
          <td width="79%" class="news"> <div align="left"> 
              <p><a href="create_form1.php">Create Course ที่ไม่มีข้อมูลจากสำนักบริการคอมพิวเตอร์</a></p>
            </div></td>
        </tr>
      </table>
	</td>
  </tr>
</table>

<br>
<table width="85%" class="std" cellpadding="5" cellspacing="0" align="center">
  <tr> 
    <td width="19%" align="center" class="hilite"><a href="../document/WS_Manual.pdf" target="_blank"><img src="../images/class_info.gif" width="48" height="47" border="0"></a></td>
    <td width="79%" class="hilite"><a href="../document/WS_Manual.pdf" target="_blank" class="a12">คู่มือการใช้งานการสร้างรายวิชาโดยดึงข้อมูลจากสำนักบริการคอมพิวเตอร์</a> 
      <img src="../images/newblink.gif"> </td>
  </tr>
</table>
</body>
</html>