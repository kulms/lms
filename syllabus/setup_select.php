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
<head><link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
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
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
  <tr>
    <td class="menu" align="center"><b>Coures Syllabus</b></td>
  </tr>
</table>
<br>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="100%"  cellpadding="2" cellspacing="0">
        <tr class="boxcolor1"> 
          <td  class="tdtop-color"><span class="Bcolor">Select
            Type Syllabus </span> </td>
          <td class="tdtop-color">&nbsp;</td>
        </tr>
        <tr> 
          <td width="50%" class="tdbottom-color"><a href="setup_file.php?courses=<? echo $courses;?>"><img src="../images/attach.png" width="16" height="16" border="0"> 
            Basic Syllabus (e-Syllabus) - upload File Syllabus</a></td>
          <td width="50%" class="tdbottom-color"><a href="setup_html.php?courses=<? echo $courses;?>"><img src="../images/html.gif" width="16" height="16" border="0"> 
            Advance Syllabus (HTML-Template Syllabus)</a></td>
        </tr>
      </table>
	</td>
  </tr>
</table>
</body>
</html>