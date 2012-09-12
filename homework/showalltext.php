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

require "./style/$uistyle/header.php";
require "./style/$uistyle/footer.php";	
// $hw_id=@mysql_result($next,$num,"id");
$assginfo=mysql_query("SELECT * FROM homework WHERE id=$hw_id;");
$i=0;
?><html>
    <head>
    <title>Show answer</title>
    <link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
	<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />-->
	<script LANGUAGE="JavaScript">
		parent.aktiv=1;
		function edit(id)
		{	
		    window.open("showtext.php?id=" + id + "", "edit", "width=550,height=300,scrollbars=yes,resizable=yes ");
		}
	</script>
    </head>
    <body bgcolor="#ffffff" topmargin="0" leftmargin="0">
	<br><center>
	<table class="tdborder2" border=0 cellspacing="0"   align="center" width="100%">
		<tr>
			<td>
			<table border=0 cellspacing="0"   align="center"  width="85%">
		    <tr><td  align="center" width="25%" valign="top"><h1><? echo $user->_($strResult.$strHome_LabQuestion);?></h1></td><tr>
			<tr><td  align="left" valign="top" class="hilite"><b><? echo "  ".@mysql_result($assginfo,0,"name"); ?></b></td>
			</tr></table>
			 </td>
		  </tr>
	</table></center><br><?
$hwans=mysql_query("SELECT * FROM homework_ans WHERE refid=$hw_id AND modules=$modules ORDER BY time;");
while($row=mysql_fetch_array($hwans))
{	$showtext=mysql_query("SELECT * FROM homework_ans WHERE id=".$row["id"].";");   
    $scores=mysql_query("SELECT * FROM homework WHERE modules=".$row["modules"]." AND id=".$row["refid"].";");
	$users=@mysql_result($showtext,0,"users");
    $userinfo=mysql_query("SELECT login,firstname,surname,email FROM users WHERE id=".$users.";");  	
?><center><table border=0 cellpadding="10" cellspacing="1" width=100% class="tdborder2">
    <tr>
		<? echo "<td class=\"news\" bgcolor=#ffffff>".nl2br(@mysql_result($showtext,0,"name")); ?><br>
		<?
		//echo @mysql_result($showtext,0,"file");
		$pos = strrpos(@mysql_result($showtext,0,"file"), ".");
		$rest = substr(@mysql_result($showtext,0,"file"), $pos+1);
		if($rest == "gif" || $rest == "jpg" || $rest == "jpeg" || $rest == "png") {
		?>
		<img src="../files/homework/ansfiles/<? echo @mysql_result($showtext,0,"refid")."/".@mysql_result($showtext,0,"file"); ?>" border="0">
		<?
		}
		?>
		</td>
	</tr>
    <tr><? echo"<td class=\"hilite\" >"; ?>
			<? echo $user->_($strPersonal_LabUserName);?>: <? echo @mysql_result($userinfo,0,"login"); ?><br>
			<? echo $user->_($strCourses_LabStdName);?>: <? echo @mysql_result($userinfo,0,"firstname")." ".@mysql_result($userinfo,0,"surname"); ?><br>
			<? echo $user->_($strPersonal_LabEmail);?>:<a href="mailto:<? echo @mysql_result($userinfo,0,"email"); ?>"><? echo @mysql_result($userinfo,0,"email"); ?></a><br>
<?    if( @mysql_result($showtext,0,"marks")!="" && @mysql_result($showtext,0,"marks")!=none)
		{  ?><a href="JavaScript:edit(<? echo $row["id"]; ?>)"><? echo $user->_($strHome_LabScore);?> :<? echo @mysql_result($showtext,0,"marks");   
		   ?></a><?	   if( @mysql_result($scores,0,"points")!="" && @mysql_result($scores,0,"points")!=none )
			                   {   echo " ( Max.=".@mysql_result($scores,0,"points").")"; 
							   }
		}else{  ?><a href="JavaScript:edit(<? echo $row["id"]; ?>)"><b><? echo $user->_($strHome_LabNoScore); ?></b></a><? 			
                 }  ?></td>
	</tr>
    </table></center><br><?		$i++;   
}    ?><center><form><input type="button" value="<? echo $user->_($strBack); ?>" onClick="history.back()" class="button"><!--<input type="button" value="Back" onClick="{location='showdetail.php?modules=<? //echo $modules; ?>'; }">--></form></center>
    </body>
    </html>