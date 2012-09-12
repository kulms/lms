<?
//require("../include/global_login.php");
session_start();
$session_id = session_id();		

require ("../include/global_login.php");

require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );

	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 		

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
function sec2hms ($sec, $padHours = false) 
  {

    // holds formatted string
    $hms = "";
    
    // there are 3600 seconds in an hour, so if we
    // divide total seconds by 3600 and throw away
    // the remainder, we've got the number of hours
    $hours = intval(intval($sec) / 3600); 

    // add to $hms, with a leading 0 if asked for
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
          : $hours. ':';
     
    // dividing the total seconds by 60 will give us
    // the number of minutes, but we're interested in 
    // minutes past the hour: to get that, we need to 
    // divide by 60 again and keep the remainder
    $minutes = intval(($sec / 60) % 60); 

    // then add to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';

    // seconds are simple - just divide the total
    // seconds by 60 and keep the remainder
    $seconds = intval($sec % 60); 

    // add to $hms, again with a leading 0 if needed
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    // done!
    return $hms;
    
  }
?>	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<title>Untitled Document</title>
</head>

<body bgcolor="#ffffff">
<div align="center">
  <table width="482" border="0" cellspacing="0" cellpadding="0" align="center" height="53" class="bg1">
    <tr> 
      <td class="menu" align="center"> <b>E-Courseware Center</b> </td>
    </tr>
  </table>
  <?
	$sql = "SELECT * FROM resources_center WHERE id = $id;";
	$q_res = mysql_query($sql);	
	$sql_catch = "	SELECT sum( r.total_time) AS t_time , u.firstname, u.surname FROM resource_center_using r, users u WHERE resource_center_id =$id AND u.id = r.users GROUP BY r.users;";
	$q_catch = mysql_query($sql_catch);	
	?>
	<br>
	<br>
	<table width="80%" border="0" cellspacing="1" cellpadding="1" align="center" class="tdborder2">
  	  <tr class="boxcolor1"> 
		<td width="9%"  class="Bwhite">Module:</td>
		<td colspan="2"  class="Bwhite"><? echo @mysql_result($q_res,0,"name");?></td>
	  </tr>
	</table><br>

  <table width="80%" border="0" cellspacing="1" cellpadding="1" align="center" class="tdborder2">  	  
	  <tr class="boxcolor1"> 
		<td class="Bwhite">No.</td>
		<td width="48%"  class="Bwhite">Name</td>
		<td width="43%"  class="Bwhite">Total Time (hh:mm:ss)</td>
	  </tr>
	    <? 
		$no = 0;
		$bg = "#FFFFFF";
		while($rs_catch=mysql_fetch_array($q_catch)){
		$no++;
		?>
	   <tr bgcolor="<? if(($no%2)==0) echo $bg;?>">
		<td><? echo $no;?></td>
		<td><? echo $rs_catch["firstname"]." ".$rs_catch["surname"];?></td>	
		<td><? echo sec2hms($rs_catch["t_time"], true);?></td>
	  </tr>
	 <? }?>
	</table>

</div>
</body>
</html>
		


