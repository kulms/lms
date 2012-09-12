<?
/*
#===========================================================================
#= Script : EGAT e-Learning
#= Author : S.Kongdej
#= Web Designer: somboonph@egat.or.th
#= Email  : skongdej@hotmail.com
#= Support: http://www.learningnuke.com
#===========================================================================
#= Copyright (c) 2004 Electricity Generating Authority of Thailand,Jongdee Group
#= You are free to use and modify this script as long as this header
#=
#= This program is free software; you can redistribute it and/or modify
#= it under the terms of the GNU General Public License as published by
#= the Free Software Foundation; either version 2 of the License, or
#= (at your option) any later version.
#=
#= This program is distributed in the hope that it will be useful,
#= but WITHOUT ANY WARRANTY; without even the implied warranty of
#= MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#= GNU General Public License for more details.
#=
#= You should have received a copy of the GNU General Public License
#= along with this program; if not, write to the Free Software
#= Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#===========================================================================
*/
/**
*  User Login 
*/
function login() {
	global $config,$lang,$usersess;
	global $userlogin,$password,$errorlogin;

	$getnickname = db_getvar($config['tableuser'],"Nickname='$userlogin'","Nickname");
	$getpass = db_getvar($config['tableuser'],"Nickname='$userlogin'","Password");

	if ($getnickname != $userlogin) {
		$errorlogin = $lang['invalidnickname']."<BR>";
	}
	else if ($getpass != $password) {
		$errorlogin = $lang['invalidmismatch']."<BR>";
	}
	else {
		// Set session information
		// save user nickname
		$usersess->set_var("nickname", "$getnickname");

		// save user  level
		$user_level =  db_getvar($config['tableuser'],"Nickname='$userlogin'","Level");
		if ($user_level == $config['admin_level']) {
		    $usersess->set_var("admin", "TRUE");
		}
		else if ($user_level  == $config['instructor_level']) {
		    $usersess->set_var("instructor", "TRUE");
		}
		else if ($user_level  == $config['student_level']) {
		    $usersess->set_var("student", "TRUE");
		}
		
		// Set cookie to show login box before register button
		//if (!$idcookie) {
		//	setcookie("idcookie",$getnickname,time()+31536000,"","",0);
		//}
			
		update_event($getnickname,"Login");	
	}
}


/**
* User Logout 
*/
function logout() {
	global $usersess;

	update_event($usersess->get_var("nickname"),"Logout");	
    $usersess->set_var("admin", "");
	$usersess->set_var("nickname", "");
	$usersess->set_var("instructor", "");
    $usersess->destroy();
	//  setcookie("idcookie","","","","",0);
}


/**
* Record event and history 
*/
function update_event($user,$event) {
	global $config;

	if (!empty($user)) {
		$event=addslashes($event);
		$userIP = getenv("REMOTE_ADDR");
		$sql = "INSERT INTO $config[tablelog] (Nickname, Eventtime, Event, UserIP) VALUES ('$user', NULL, '$event', '$userIP')";
		db_query($sql);
	}
}


/**
* Log Menu
*/
function logMenu() {
	global $config, $e, $p;

	echo '<DIV ALIGN="LEFT">&nbsp;&nbsp;<IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/logging.jpg" BORDER=0></DIV><BR>';
?>
	<TABLE WIDTH=98% cellspacing=0 cellpadding=0>
	<TR>
	<TD ALIGN="LEFT">

	USER EVENTS:: <A HREF="index.php?action=logging&e=all" class=active>ALL</A> | <A HREF="index.php?action=logging&e=message" class=active>Messages</A> | <A HREF="index.php?action=logging&e=Register" class=active>Register</A> | <A HREF="index.php?action=logging&e=Login" class=active>LogIn</A> | <A HREF="index.php?action=logging&e=Logout" class=active>LogOut</A> | <A HREF="index.php?action=logging&e=Modify user preferences" class=active>Preferences</A> <BR>

<?


// Show pagelist //
	$sql = "SELECT count(*),date_add(now(),interval -7 DAY) FROM ".$config['tablelog']." WHERE Eventtime >= date_add(now(),interval -7 DAY)" ;
	if ($e !="all")
		$sql.= " and Event like '%". $e ."%' "; 
	$result=db_select($sql);
	$data=mysql_fetch_row($result);
	$total=$data[0];
	$totalpages=ceil($total/$config['display_per_page']);
	
	if (!$p) 
			$p=1;

		if ($totalpages > 1 && $p != 1) {
			$back=$p-1;
			$pages .= "[<a href='$PHP_SELF?action=logging&order=$order&p=$back'><<</a>] ";
		}
		for($i=1;$i<=$totalpages;$i++) {
			if ($i==$p)
				$pages .= "<b>$i</b> ";
			else
				$pages .= "<a href='$PHP_SELF?action=logging&order=$order&p=$i'><u>$i</u></a> ";
		}

		if ($totalpages > 1 && $totalpages != $p) {
			$next=$p+1;
			$pages .= " [<a href='$PHP_SELF?action=logging&order=$order&p=$next'>>></a>]";
		}

	$start=($p-1)*$config['display_per_page'];
	$pages="Pages: ".$pages;
	$total="Total : <B>".$total."</B> event(s)";
	$note="<UL><B>Note:</B>";

	$note.="<li type=circle>Display ".$config['eventlimit']." events per page";
	$note.="</UL>";
// End Show pagelist //


	if (!$e) $e="all";

	if ($e == "all")
		$sql = "SELECT * FROM $config[tablelog] ORDER BY Eventtime DESC LIMIT $start,$config[eventlimit]";
	else if ($e == "delete")
		$sql = "DELETE FROM $config[tablelog]";
	else
		$sql = "SELECT * FROM $config[tablelog] WHERE Event like '%". $e ."%' ORDER BY Eventtime DESC LIMIT $start,$config[eventlimit]";


	echo "Display : $e";
	echo "<HR SIZE=1>";
	$result=db_select($sql);
	for ($i=0;list($nickname,$time,$revent,$ip) = mysql_fetch_row($result);$i++) {
		if ($time) {
			$timestr=date($config['dateformat'],sql_to_unix_time($time))	;
		}
		$revent=stripslashes($revent);
		echo "<font face='ms sans serif'  COLOR=#858585>$timestr :[$ip]</FONT> <B>$nickname</B> $revent<BR>";
	}

	?>
	<HR SIZE=1>
	<?=$pages?><BR><BR><?=$total?><?=$note?>
	</TD>
	</TR>
	</TABLE>
	<?
	


}


/**
* Forget pasword windown form
*/
function forgetPass() {
	global $lang;

?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
	<HTML>
	<HEAD>
	<TITLE> Forget Password:: </TITLE>
	<LINK REL="STYLESHEET" HREF="style/default.css" type="text/css">
	<STYLE>
	table { font-family: "ms sans serif"; font-size: 11px; color: "#000000"; }
	body { font-family: "ms sans serif"; font-size: 14px;} 
	</STYLE>
	</HEAD>
	<BODY BGCOLOR="#E3E1C6" >
<?
//	echo "<BR><IMG SRC=images/forgetpass.jpg WIDTH=140 HEIGHT=39 BORDER=0>";
	echo $lang['forgetpassword'];
?>
	<CENTER>
	<FORM METHOD=POST ACTION="index.php">
	<INPUT TYPE="hidden" NAME="action" VALUE="sendpass">
	<TABLE CELLPADDING=20 BGCOLOR=#3C3C3C BORDER=0 CELLSPACING=2>
	<TR BGCOLOR=#669966 VALIGN=MIDDLE>
		<TD>
			<B><?=$lang['id']?></B> <INPUT TYPE="text" NAME="empn" size=15>&nbsp;<INPUT TYPE="submit" value="Send!">
		</TD>
	</TR>
	</TABLE>
	</FORM>
	</CENTER>
<?
	exit;
}


/**
* Forget Password
*/
function sendPass() {
	global $config,$lang,$empn;
	
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
	<HTML>
	<HEAD>
	<TITLE> Forget Password:: </TITLE>
	<LINK REL="STYLESHEET" HREF="style/default.css" type="text/css">
	<STYLE>
	table { font-family: "ms sans serif"; font-size: 11px; color: "#000000"; }
	body { font-family: "ms sans serif"; font-size: 14px;} 
	</STYLE>
	</HEAD>
	<BODY BGCOLOR="#E3E1C6" >
<?
	
	$nickname=db_getvar($config['tableuser'],"ID='$empn'","Nickname");
	$password=db_getvar($config['tableuser'],"ID='$empn'","Password");
	$recipient=db_getvar($config['tableuser'],"ID='$empn'","Email");
	$fname=db_getvar($config['tableuser'],"ID='$empn'","Firstname");
	$lname=db_getvar($config['tableuser'],"ID='$empn'","Lastname");

	$from = $config['adminmail'];
	$subject = $lang['forget_pass_subject'];
	$msg.="<font face='ms sans serif' size=2>เรียนคุณ $fname $lname<P>\r\n";
	$msg.= $lang['forget_pass_mail'];
	$msg.= $lang['nickname']. ': '. $nickname." <BR>\r\n";
	$msg.=$lang['password']. ': '. $password." <P>\r\n";
	$msg.=$lang['thanksign'] . "\r\n";

	if ($recipient) {
		if (mailsock($from,$recipient,null,$subject,$msg)) {
			echo $lang['sent_password'];
//			echo $subject."<P>".$msg;
		}
		else {
			echo "&nbsp;<P><CENTER><B>Mail server is not ready!</B></CENTER>";
		}
	}
	else {
		echo $lang['error_pass_notfound'];
	}

	echo "<P><CENTER><INPUT TYPE=\"button\" VALUE=\"Close Window\" Onclick=\"javascript:window.close()\"></CENTER>";

	exit;
}


/**
* List User
*/
function userList() {
	global $config,$lang,$color;
	global $order,$p;
	
	$sql = "SELECT count(*) FROM ".$config['tableuser'];
	$result=db_select($sql);
	$data=mysql_fetch_row($result);
	$total=$data[0];
	$totalpages=ceil($total/$config['display_per_page']);
	
	if (!$p) 
			$p=1;

		if ($totalpages > 1 && $p != 1) {
			$back=$p-1;
			$pages .= "[<a href='$PHP_SELF?action=userlist&order=$order&p=$back'><<</a>] ";
		}
		for($i=1;$i<=$totalpages;$i++) {
			if ($i==$p)
				$pages .= "<b>$i</b> ";
			else
				$pages .= "<a href='$PHP_SELF?action=userlist&order=$order&p=$i'><u>$i</u></a> ";
		}

		if ($totalpages > 1 && $totalpages != $p) {
			$next=$p+1;
			$pages .= " [<a href='$PHP_SELF?action=userlist&order=$order&p=$next'>>></a>]";
		}

	$start=($p-1)*$config['display_per_page'];
	$pages="Pages: ".$pages;
	$total="Total users: <B>".$total."</B>";
	$note="<UL><B>Note:</B>";
	$note.="<li type=circle>Display ".$config['display_per_page']." users per page";
	$note.="<li type=circle><img src='images/admin.gif' border=0> Admin&nbsp;<img src='images/user.gif' border=0> Student&nbsp;<img src='images/instructor.gif' border=0> Instructor </center>";
	$note.="<li type=circle><img src='images/edit.gif' border=0 alt='Edit user'> - Show Users &nbsp;&nbsp;<img src='images/delete.gif' border=0 alt='Delete user'> -  Delete Users";
	$note.="</UL>";


	$orders="RegDate DESC";
	if ($order)
		$orders=$order.",".$orders;
	$sql = "SELECT ID, Nickname, Firstname, Lastname, Password, Email, Phone, RegDate, Level FROM ".$config['tableuser']." Order by ".$orders;
	$sql .= " Limit $start,$config[display_per_page] ";
	$result=db_select($sql);

	echo '<DIV ALIGN=LEFT>&nbsp;&nbsp;<IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/userlist.jpg"  BORDER=0><BR>';
	echo "<CENTER><FORM METHOD=POST ACTION='index.php'>";
	echo "<INPUT TYPE=hidden NAME='action' VALUE='edituser'>";
	echo "<INPUT TYPE=text NAME=nick WIDTH=20 > ";
	echo " <SELECT NAME='what' >";
	echo "<OPTION value='empn'>$lang[id]</OPTION>";
	echo "<OPTION value='firstname'>$lang[firstname]</OPTION> ";
	echo "<OPTION value='nick'>$lang[nickname]</OPTION>";
	echo "<OPTION value='email'>$lang[email]</OPTION>";
	echo "</SELECT>";
	echo " &nbsp;<INPUT class=button TYPE=submit VALUE='$lang[button_search]'></DIV>";
	echo "</FORM><BR></CENTER>";
	
	echo "<table width=98% cellpadding=2 cellspacing=0>";
	echo "<tr align=center height=18><td class=head><B>No.</B></td><td class=head width=20></td>";
	echo "<td class=head width=80><A HREF='index.php?action=userlist&order=ID' class=invert><B>$lang[id]</B></A></td><td class=head width=80><A HREF='index.php?action=userlist&order=Nickname' class=invert><B>$lang[nickname]</B></A></td><td class=head><A HREF='index.php?action=userlist&order=Firstname' class=invert><B>$lang[firstname]</B></A> <A HREF='index.php?action=userlist&order=Lastname'  class=invert><B>$lang[lastname]</B></A></td><td class=head><A HREF='index.php?action=userlist&order=RegDate' class=invert><B>$lang[regdate]</B></A></td><td class=head>&nbsp;</td></tr>";
	for($i=1;list($id,$nickname,$firstname,$lastname,$password,$email,$phone,$time,$level) = mysql_fetch_row($result);$i++) {
		$colors= $i%2 ? $color['color_a'] : $color['color_b'];
//		$timestr=date($config['dateformat'],sql_to_unix_time($time));
		if ($level ==$config['admin_level']) $usericon=$config['admin_icon'];
		else if ($level < $config['admin_level'] && $level >= $config['instructor_level'])
			$usericon=$config['instructor_icon'];
		else
			$usericon=$config['user_icon'];
		$n=$i+$start;
		echo "<tr bgcolor=$colors><td align=center>$n</td><td align=center width=20><img src='images/$usericon' border=0></td><td width=80 align=center>$id</td><td>$nickname</td><td> $firstname $lastname</td>";
		echo "<td align=center>$time</td>";
		echo "<td width=45 align=center><A HREF='index.php?action=edituser&nick=$nickname'><img src='images/edit.gif' border=0 alt='edit'></A>&nbsp;";
		echo "<A HREF=\"javascript:if(confirm('Delete user $nickname?')) window.open('index.php?action=deleteuser&nick=$nickname','_self')\" onmouseover='self.status=\"\"; return true;'><img src='images/delete.gif' border=0 alt='delete'></A></td></tr>";
	}
	$i--;

	echo "<tr  height=1 ><td colspan=8 background='images/line1.gif' bgcolor=#CCCCCC></td></tr>";

	echo "<tr><td colspan=8 align=right>";
	echo "$pages<BR>$total</td></tr>";
	
	echo "<tr><td colspan=8 align=left>";
	echo "$note</td></tr>";
	echo "</table><P>";
}


/**
* Edit user
*/
function editUser() {
	global $config,$lang,$usersess;
	global $what,$nick;
	
	if (!$usersess->get_var("admin")) {
		echo "<P><CENTER><B>You are not authorized!!</B></CENTER>";
		return;
	}

	$sql ="SELECT * FROM $config[tableuser] ";
	if ($what=="empn") {
		$sql.= " WHERE ID like '$nick%' ";
	}
	else if ($what=="firstname") {
		$sql .=" WHERE Firstname like '$nick%' ";
	}
	else if ($what=="email") {
		$sql .=" WHERE Email like '$nick%' ";
	}
	else {
		$sql .=" WHERE Nickname like '$nick%' ";
	}

	$result=db_select($sql);

	list($id,$level,$nickname,$firstname,$lastname,$password,$email,$phone,$news,$show,$regdate,$note,$enable,$lastmod) = mysql_fetch_row($result);

	$note=stripslashes($note);
	if ($id == "") {
			echo "<BR><BR><CENTER><FONT  COLOR=#FF6600><B>$lang[search_notfound]:</FONT> $nick</B></CENTER>";
	}
	else {
			echo '<DIV ALIGN=LEFT>&nbsp;&nbsp;<A HREF=index.php?action=userlist><IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/userlist.jpg"  BORDER=0></A><BR>';

			echo "<CENTER><FORM METHOD=POST ACTION='index.php'>";
			echo "<INPUT TYPE=hidden NAME='action' VALUE='edituser'>";
			echo "<INPUT TYPE=text NAME=nick WIDTH=20> ";
			echo " <SELECT class=select NAME='what' >";
			echo "<OPTION value='empn'>$lang[id]</OPTION>";
			echo "<OPTION value='firstname'>$lang[firstname]</OPTION> ";
			echo "<OPTION value='nick'>$lang[nickname]</OPTION>";
			echo "<OPTION value='email'>$lang[email]</OPTION>";
			echo "</SELECT>";
			echo " &nbsp;<INPUT class=button TYPE=submit VALUE='$lang[button_search]'></DIV>";
			echo "</FORM><BR></CENTER>";

?>
    <script language="javaScript">
		
		function formSubmit(val) {
			if(val == "Clear") document.forms.Userprofile.submit();
			else if(checkFields()) {
				document.forms.Userprofile.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
		function clearFields() {
			document.forms.Userprofile.reset();
		}

    	function checkFields() {
			var nickname = document.forms.Userprofile.nick.value;
			var password = document.forms.Userprofile.password.value;
			var userFirstName = document.forms.Userprofile.firstname.value;
			var userLastName = document.forms.Userprofile.lastname.value;
			var emailAddress = document.forms.Userprofile.email.value;
			var phone = document.forms.Userprofile.phone.value;
		
			if (nickname  == "" ) {
				alert("<?=$lang['alertnickname']?>");
				document.forms.Userprofile.nick.focus();
				return false;
			} else if (nickname.length  < 4) {
				alert("<?=$lang['alertnicknamel']?>");
				document.forms.Userprofile.nick.focus();
				return false;
			} else if (nickname.length  >= 20) {
				alert("<?=$lang['alertnicknamem']?>");
				document.forms.Userprofile.nick.focus();
				return false;
			}
			
			if (password  == "") {
				alert("<?=$lang['alertpassword']?>");
				document.forms.Userprofile.password.focus();
				return false;
			}

			if (password.length  < 6) {
				alert("<?=$lang['alertpassword6']?>");
				document.forms.Userprofile.password.focus();
				return false;
			} 
			else if (password.length  >= 32) {
				alert("<?=$lang['alertpassword32']?>");
				document.forms.Userprofile.password.focus();
				return false;
			}

			if (userFirstName  == "") {
				alert("<?=$lang['alertfirstname']?>");
				document.forms.Userprofile.firstname.focus();
				return false;
			}

			if (userLastName  == "") {
				alert("<?=$lang['alertlastname']?>");
				document.forms.Userprofile.lastname.focus();
				return false;
			}

			if (emailAddress  == "" && phone == "") {
				alert("<?=$lang['alertemail']?>");
				document.forms.Userprofile.email.focus();
				return false;
			}

			if (emailAddress != "" && (emailAddress.indexOf(" ") > -1 || emailAddress.indexOf("@") == -1 || emailAddress.indexOf(",") > -1 )) {
				alert("<?=$lang['alertemailformat']?>");
				document.forms.Userprofile.email.focus();
				return false;
			}

			if (isComposedOfChars("_ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",password)){
				alert("<?=$lang['password']?> <?=$lang['alertnotalpha']?>");
				document.forms.Userprofile.password.focus();
				return false;
			}

			if (isComposedOfChars("_ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",nickname)){
				alert("<?=$lang['nickname']?> <?=$lang['alertnotalpha']?>");
				document.forms.Userprofile.nickname.focus();
				return false;
			}

			if (isComposedOfChars("0123456789-",phone)){
				alert("<?=$lang['phone']?> <?=$lang['alertnotnum']?>");
				document.forms.Userprofile.phone.focus();
				return false;
			}

		return true; 
	}

	function isComposedOfChars(testSet, input) {
		for (var j=0; j<input.length; j++) {
			if (testSet.indexOf(input.charAt(j), 0) == -1) {
				return true;
			}
		}
		return false;
	}

</script>

<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="98%" class="form">
 <FORM name="Userprofile" method="post" action="index.php" onSubmit="return  formSubmit('updateuser');">
<INPUT TYPE="hidden" NAME="action">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<TR>
	<TD><TABLE CELLPADDING="3" CELLSPACING="0" WIDTH="100%">

<FORM METHOD=POST ACTION="index.php">
<TR height="18">
<TD colspan="2" class="head"><B><?=$lang['userinfo']?></B></TD></TR>
<TR>
<TR>
<TD align=right width=100><?=$lang['id']?>:</TD><TD><B><?=$id?></B></TD></TR>
<TR>
<TD align=right><?=$lang['level']?>:</TD>
<TD>
<SELECT NAME="level">
	<OPTION VALUE=<?=$config['student_level']?> <? if ($level==$config['student_level']) echo "selected"; ?>><?=$lang['student']?></OPTION>
	<OPTION VALUE=<?=$config['instructor_level']?> <? if ($level==$config['instructor_level']) echo "selected"; ?>><?=$lang['coach']?></OPTION>
	<OPTION VALUE=<?=$config['admin_level']?> <? if ($level==$config['admin_level']) echo "selected"; ?>><?=$lang['admin']?></OPTION>
</SELECT>
</TD></TR>
<TR>
<TD align=right><?=$lang['nickname']?>:</TD><TD><INPUT TYPE="text" NAME="nick" VALUE="<?=$nickname?>" SIZE=10></TD></TR>
<TR>
<TD align=right><?=$lang['password']?>:</TD><TD><INPUT TYPE="text" NAME="password" VALUE="<?=$password?>" SIZE=10></TD></TR>
<TR>
<TD align=right><?=$lang['firstname']?>:</TD><TD><INPUT TYPE="text" NAME="firstname" VALUE="<?=$firstname?>" SIZE=20></TD></TR>
<TR>
<TD align=right><?=$lang['lastname']?>:</TD><TD><INPUT TYPE="text" NAME="lastname" VALUE="<?=$lastname?>" SIZE=20></TD></TR>
<TR>
<TD align=right><?=$lang['email']?>:</TD><TD><INPUT TYPE="text" NAME="email" VALUE="<?=$email?>" SIZE=20></TD></TR>
<TR>
<TD align=right><?=$lang['phone']?>:</TD><TD><INPUT TYPE="text" NAME="phone" VALUE="<?=$phone?>" SIZE=20></TD></TR>
<TR valign=top>
<TD align=right><?=$lang['userprofile']?>:</TD><TD><TEXTAREA NAME="note" ROWS="5" COLS="50" style='width:90%'><?=$note?></TEXTAREA></TD></TR>
<TR>
<TD align=right>&nbsp;</TD><TD><FONT COLOR="#408080">Create On: <?=$regdate?>, Last updated:<? echo @date($config['dateformat2'],sql_to_unix_time($lastmod)); ?></FONT>

<BR><BR>

<INPUT class="button" TYPE="submit" VALUE="<?=$lang['button_edituser']?>">&nbsp;
<INPUT class="button" TYPE="button" VALUE="<?=$lang['button_cancel']?>" onclick="javacript:window.open('index.php?action=userlist','_self')">

<BR>&nbsp;
</TD></TR>
</TABLE></TD>
</TR>
</TABLE>
</FORM>
<P>
<?
	
		}

}


/**
* UpdateUser
*/ 
function updateUser() {
	global $config,$usersess;
	global $id,$level,$nick,$password,$firstname,$lastname,$email,$phone,$note;

	if (!$usersess->get_var("admin")) {
		echo "<P><CENTER><B>You are not authorized!!</B></CENTER>";
		return;
	}

	$dupid = db_getvar($config['tableuser'],"Nickname='$nick'","ID");

	if (empty($dupid) || $id == $dupid) {
		$note=addslashes($note);
		$sql = "UPDATE $config[tableuser] SET ";
		$sql .="Level='$level', Nickname='$nick', Password='$password', Firstname='$firstname', Lastname='$lastname',  ";
		$sql .="Email='$email', Phone='$phone' , Note='$note' ";
		$sql .="WHERE ID='$id' ";
		db_query($sql);
		update_event($usersess->get_var("nickname"),"Modify user preference '$nick' ");	
	}

	userList();
}


/**
* Delete User 
*/
function deleteUser() {
	global $config,$usersess;
	global $nick;
	
	if (!$usersess->get_var("admin")) {
		echo "<P><CENTER><B>You are not authorized!!</B></CENTER>";
		return;
	}

	$sql ="DELETE FROM $config[tableuser] WHERE Nickname='$nick' ";
	db_query($sql);

	update_event($usersess->get_var("nickname"),"Delete user '$nick' ");	

	userlist();
}


?>