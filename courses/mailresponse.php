<?	require("../include/global.php");	?>
<html>
<head><title>Apply to course</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<p>&nbsp;</p>
<?	//******************* in-parameters *******************
		// $courses =	course to insert into wp
		// $users 	=	user to insert into wp	
		// $rnd=1/0	=	1=grant permisson
		// $cadmin	=	creator of course, check!
	//*****************************************************
$ok=0;
	//Check if $cadmin is a valid courseadministrator
$checkadmin=mysql_query("SELECT id FROM wp WHERE courses=$courses AND users=$cadmin AND admin=1;");
if(mysql_num_rows($checkadmin)!=0)
{
	$ok=1;
}else{
	$checkcreator=mysql_query("SELECT name FROM courses WHERE id=$courses AND users=$cadmin;");
	if(mysql_num_rows($checkcreator)!=0){
		$ok=1;
	}
}

$getinfo=mysql_query("SELECT c.applyopen,u.firstname,u.surname,u.login,c.name,u.email FROM courses c, users u WHERE c.id=$courses AND u.id=$users;");
$row=mysql_fetch_array($getinfo);
$fname=$row["firstname"];
if($fname==""){
	$fname=$row["login"];
}
$fullname=$row["firstname"]."&nbsp;".$row["surname"];
if($fullname==""){
	$fullname=$row["login"];
}
$coursename=$row["name"];

 if(($ok==1 || $person["admin"]==1) && $row["applyopen"]==0){ 	// OK, $admin = creator of course AND applyopen=0 
 																// (if 1 then no mail should have been sent out
 	$check_apply=mysql_query("SELECT id FROM apply_courses WHERE users=$users AND courses=$courses;");
 		if(mysql_num_rows($check_apply)!=0){	//OK, user NOT already in course - still in apply_courses
 	  		if($rnd==1){ // User granted access
				$check_wp=mysql_query("SELECT id FROM wp WHERE users=$users AND courses=$courses;");
				if(mysql_num_rows($check_wp)==0){
	 				mysql_query("INSERT INTO wp(courses,users) VALUES($courses,$users);");
				}
 				mysql_query("DELETE FROM apply_courses WHERE id=".mysql_result($check_apply,0,"id").";"); //Clear record in apply_courses
 				$mailbody=$fname.",";
 				$mailbody.="\nYou have been accepted to join
".$coursename.".\n\n Further information can be found when you visit the course
pages.\n\nWelcome to Course On Web , Faculty of Engineering , KU";
 				//mail($row["email"],"Your request to join".$coursename,$mailbody,"From:courseadmin@$SERVER_NAME");
 ?>
 				<table cellpadding="3" cellspacing="3" align="center">
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="h3" align="center" colspan="2">Mailresponse for <?echo $coursename?></td>
 					</tr>
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="main" align="left" valign="top" colspan="2">OK, <b><?echo $fullname ?></b> has been accepted to join <b><?echo $coursename?></b></td>
 					</tr>
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="main" align="left" valign="top" colspan="2">Thank you.</td>
 					</tr>
 				</table>
 <?
 			} // $rnd=0 -> no access
 			else{
 				$mailbody=$fname.",";
				if(mysql_query("DELETE FROM apply_courses WHERE id=".mysql_result($check_apply,0,"id").";")){ //Clear record in apply_courses
 					$mailbody.="\nWe are sorry to inform you that you
were not accepted to join ".$coursename.".\n\nYou are nevertheless welcome to apply for
other courses in Course on Web at Faculty of Engineering , KU";
 					mail($row["email"],"Your request to join
".$coursename,$mailbody,"From:courseadmin$SERVER_NAME");
				}
 			?>
 				<table cellpadding="3" cellspacing="3" align="center">
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="h3" align="center" colspan="2">Mailresponse for <?echo $coursename?></td>
 					</tr>
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="main" align="left" valign="top" colspan="2">OK, <b><?echo $fullname ?></b> was NOT accepted to join <b><?echo $coursename?></b></td>
 					</tr>
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="main" align="left" valign="top" colspan="2">Thank you.</td>
 					</tr>
 				</table>
 			<?} // end else
 		}else{// end if - users application already processed...
			$check_user_wp=mysql_query("SELECT id FROM wp WHERE users=$users AND courses=$courses;");
			if(mysql_num_rows($check_user_wp)!=0){
				$grant_state="(granted)";
			}else{
				$grant_state="(not granted)";
			}
 ?>	
 				<table cellpadding="3" cellspacing="3" align="center">
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="h3" align="center" colspan="2">Mailresponse for <?echo $coursename?></td>
 					</tr>
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="main" align="left" valign="top" colspan="2">Sorry, <b><?echo $fullname ?>'s</b> application to join <b><?echo $coursename?></b> has already been processed <?echo $grant_state?>.</td>
 					</tr>
 					<tr>
 						<td width="15%">&nbsp;</td>
 						<td class="main" align="left" valign="top" colspan="2">No harm done - didn't make any changes.</td>
 					</tr>
 				</table>
 	<?
 		} // end else - user in course
 }else{  //Not correct parameters!
?>	
 			<table cellpadding="3" cellspacing="3" align="center">
 				<tr>
 					<td width="15%">&nbsp;</td>
 					<td class="h3" align="left" valign="top" colspan="2">STOP!</td>
 				</tr>
 				<tr>
 					<td width="15%">&nbsp;</td>
 					<td class="main" align="left" valign="top" colspan="2">You seem to be trying to tamper with this course or maybe you did something wrong.
 					<br>Don't worry - nothing happened...</td>
 				</tr>
 				<tr>
 					<td width="15%">&nbsp;</td>
 					<td class="main" align="left" valign="top" colspan="2">If you didn't click on the link in the mail but tried to write or copy the 
 						URL into your browser - please try again and type it in EXACTLY as it says in the mail.
 					</td>
 				</tr>
 				<tr>
 					<td width="15%">&nbsp;</td>
 					<td class="main" align="left" valign="top"
colspan="2">If the problem persists - please contact <a href="mailto:courseadmin@<?echo
$SERVER_NAME?>">courseadmin@<?echo $SERVER_NAME?></a></td>
 				</tr>
 			</table>
 <?
}
?>
</body>
</html>
