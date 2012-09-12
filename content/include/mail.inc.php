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
* Contact us
*/
function sendContactUs() {
	global $config,$lang;
	global $firstname,$subject, $email,$message;

	$recipient=$config['adminmail'];
	$subject=$lang['contactus_subject'].$subject;
	$msg=str_replace("\n","<BR>\r\n",$message);
	
	$message="<font face='ms sans serif' size=2>".$lang['contactus_from']." <B>$firstname ($email)</B><BR><BR>\r\n\r\n".$msg;

	if (mailsock($email,$recipient,null,$subject,$message))
		echo "<CENTER>&nbsp;<P><B>".$lang['contactus_sent']."</B></CENTER>";
	else
		echo "&nbsp;<P><CENTER><B>Mail server is not ready!</B></CENTER>";
}


/**
* Õ’‡¡≈Ï®“°ºŸÈ¥Ÿ·≈√–∫∫
*/
function adminMail() {
	global $config, $lang;

	$sql = "SELECT Nickname,Email ";
	$sql.= "FROM $config[tableuser] ";
	$sql.= "WHERE ";
	$sql.= "News='1' and Email <> '' ORDER BY Nickname";

	$result=db_select($sql);
	for($i=0;list($nickname,$email) = mysql_fetch_row($result);$i++) {
		$nicknames[$i]=$nickname;
		$emails[$i]=$email;
		$nuser=$i+1;
	}

	echo '<DIV ALIGN="LEFT"><img src="theme/'.$config['theme'].'/title/'.$config['language'].'/adminmail.jpg" border=0></DIV><BR>';

?>



<FORM METHOD=POST ACTION="index.php">
<INPUT TYPE="hidden" NAME="action" VALUE="adminmailsend">
<INPUT TYPE="hidden" NAME="email" VALUE="<?=$config['adminmail']?>">
<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=98% class="form">
<TR>
	<TD>
		<TABLE  CELLPADDING="3" CELLSPACING="0" BORDER="0" WIDTH=100%>
		<TR>
			<TD class="head" COLSPAN=2><B><?=$lang['mailtomember']?>: </B></TD>
		</TR>
		</TABLE>
		<TABLE  CELLPADDING="3" CELLSPACING="0" BORDER="0" WIDTH=100%>
		<TR>
			<TD ALIGN="RIGHT" WIDTH=100 ><?=$lang['from']?>:</TD>
			<TD ALIGN="LEFT"><B><?=$config['adminmail']?></B></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" WIDTH=100 ><?=$lang['to']?>:</TD>
			<TD ALIGN="LEFT">
				<SELECT NAME="email1">
					<OPTION VALUE="all"><?=$lang['allmembers']?></OPTION>
				<?
					for($i=0;$i<$nuser;$i++) {
						echo "<OPTION VALUE=".$emails[$i].">".$nicknames[$i]." &lt;".$emails[$i]."&gt;</OPTION>";
					}
				?>
				</SELECT>
				  (<?=$lang['member']?> <?=$nuser?> <?=$lang['member_unit']?>)
			</TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT"><?=$lang['subject']?>: </TD>
			<TD ALIGN="LEFT"><INPUT TYPE="text" NAME="subject" style='width=70%'></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN=TOP><?=$lang['message']?>: </TD>
			<TD ALIGN="LEFT"><TEXTAREA NAME="message" ROWS="15" COLS="50" style='width=90%'></TEXTAREA></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN=TOP></TD>
			<TD ALIGN="LEFT">&nbsp;<INPUT TYPE="submit" VALUE="<?=$lang['button_send']?>" CLASS="button"><BR>&nbsp;</TD>
		</TR>
		</TABLE>
		</TD>
	</TR>
</TABLE>
</FORM>
<?
}


/**
* send mail to member
*/
function adminMailSend() {
	global $config, $lang;
	global $email,$email1,$subject,$message;

//	$bcc=array();

	$msg.=str_replace("\n","<BR>\r\n",$message);
	
	if ($email1 == "all") {
		$sql = "SELECT Email ";
		$sql.= "FROM $config[tableuser] ";
		$sql.= "WHERE ";
		$sql.= "News='1' and Email <> '' ";

		$result=db_select($sql);
		for($i=0;list($useremail) = mysql_fetch_row($result);$i++) {
				$ret = mailsock($config['adminmail'],$useremail,null,$subject,$msg);
		}		
	}
	else {
		$ret = mailsock($email,$email1,null,$subject,$msg);
	}

	echo '<DIV ALIGN="LEFT"><img src="theme/'.$config['theme'].'/title/'.$config['language'].'/adminmail.jpg" border=0></DIV><BR>';
	if ($ret) {
		echo "<BR><BR><FONT  COLOR=#336633><CENTER><B>$lang[message_sent]</B></CENTER></FONT>";
	}
	else {
		echo "<BR><BR><FONT  COLOR=#FF6600><CENTER><B>$lang[mailserver_error]</B></CENTER></FONT>";
	}
	echo "<BR><BR>&lt;&lt; <A HREF=index.php?action=adminmail>BACK</A>";
}


/**
* ‡¡≈Ï®“°ºŸÈ¥Ÿ·≈À≈—° Ÿµ√À“π—°‡√’¬π
*/
function instructorMail() {
	global $config, $lang;
	global $scheduleid;

	$sql = "SELECT c.CourseName,c.CID,c.Code,s.Instructor,e.Nickname,u.Email,s.Start,e.Options ";
	$sql.= "FROM $config[tablescheduling] s, $config[tablecourse] c, $config[tableenroll] e,$config[tableuser] u ";
	$sql.= "WHERE s.CourseID=c.CID and e.SchedulingID=s.SchedulingID and u.Nickname=e.Nickname ";
	$sql.= "and e.SchedulingID='$scheduleid' and u.Email <> '' ";

	$result=db_select($sql);
	for($i=0;list($coursename,$courseid,$coursecode,$instructor,$nickname,$email,$start,$option) = mysql_fetch_row($result);$i++) {
		if ($option & 2) {
			$students[$i]=$nickname;
			$studentmails[$i]=$email;
			$nstudent=$i+1;
			$cname=$coursename;
			$cid=$courseid;
			$instname=$instructor;
			$startdate=$start;
		}
	}
	$instructormail = db_getvar($config['tableuser'],"Nickname='$instname'","Email");

	if (!empty($instructormail)) {
	echo '<DIV ALIGN="LEFT"><img src="theme/'.$config['theme'].'/title/'.$config['language'].'/adminmail.jpg" border=0></DIV><BR>';

?>


<FORM METHOD=POST ACTION="index.php">
<INPUT TYPE="hidden" NAME="action" VALUE="instructormailsend">
<INPUT TYPE="hidden" NAME="email" VALUE="<?=$instructormail?>">
<INPUT TYPE="hidden" NAME="scheduleid" VALUE="<?=$scheduleid?>">
<CENTER>

<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 class=form WIDTH=98%>
<TR>
	<TD>
		<TABLE  CELLPADDING="3" CELLSPACING="0" BORDER="0" WIDTH=100%>
		<TR>
			<TD class=head COLSPAN=2>&nbsp;<B><?=$lang['mailtostudent']?>: <?=$cname?> (<? echo C2TH($startdate,1); ?>)</B></TD>
		</TR>
		</TABLE>
		<TABLE  CELLPADDING="3" CELLSPACING="0" BORDER="0" WIDTH=100%>
		<TR>
			<TD ALIGN="RIGHT" VALIGN=TOP WIDTH=100 ><?=$lang['from']?>:</TD>
			<TD ALIGN="LEFT"><B><?=$instname?> (<?=$instructormail?>)</B></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN=TOP WIDTH=100 ><?=$lang['to']?>:</TD>
			<TD ALIGN="LEFT">
				<SELECT NAME="email1">
					<OPTION VALUE="all"><?=$lang['allstudents']?></OPTION>
				<?
					for($i=0;$i<$nstudent;$i++) {
						echo "<OPTION VALUE=".$studentmails[$i].">".$students[$i]." (".$studentmails[$i].")</OPTION>";
					}
				?>
				</SELECT>
				 (<?=$lang['student']?> <?=$nstudent?> <?=$lang['student_unit']?>)
			</TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN=TOP><?=$lang['subject']?>: </TD>
			<TD ALIGN="LEFT"><INPUT TYPE="text" NAME="subject" style='width=70%'></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN=TOP><?=$lang['message']?>: </TD>
			<TD ALIGN="LEFT"><TEXTAREA NAME="message" ROWS="15" COLS="50" style='width=90%'></TEXTAREA></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN=TOP></TD>
			<TD ALIGN="LEFT">&nbsp;<INPUT TYPE="submit" VALUE="<?=$lang['button_send']?>" CLASS="button"><BR>&nbsp;</TD>
		</TR>
		</TABLE>
		</TD>
	</TR>
</TABLE>
</FORM>

<?
	}
	else {
		echo "<BR><BR>&nbsp;<P><FONT  COLOR=#FF6600><B>".$lang['nostudent']."</B></FONT>";
	}
}


/**
* send instructor mail
*/
function instructorMailSend() {
	global $config, $lang;
	global $scheduleid;
	global $email,$email1,$subject,$message;

//	$bcc=array();
	$msg.=str_replace("\n","<BR>\r\n",$message);

	if ($email1 == "all") {
		$sql = "SELECT u.Email ";
		$sql.= "FROM $config[tablescheduling] s,$config[tableenroll] e,$config[tableuser] u ";
		$sql.= "WHERE  e.SchedulingID=s.SchedulingID and u.Nickname=e.Nickname ";
		$sql.= "and e.SchedulingID='$scheduleid' and (e.Options & 1) and u.Email <> '' ";

		$result=db_select($sql);
		
		for($i=0; list($useremail) = mysql_fetch_row($result); $i++) {
				$ret = mailsock($config['adminmail'],$useremail,null,$subject,$msg);
		}
	}
	else {
		$ret = mailsock($email,$email1,null,$subject,$msg);
	}
	
	if ($ret) {
		echo "&nbsp;<P><FONT  COLOR=#FF6600><CENTER><B>$lang[message_sent]</B></CENTER></FONT>";
	}
//	else {
//		echo "<BR><BR><FONT  COLOR=#FF6600><CENTER><B>$lang[mailserver_error]</B></CENTER></FONT>";
//	}
}


/**
* send mail function
*/
function mailsock($from,$recipient,$bcc,$subject,$msg) {
	global $config;

	if (!$config['email_enabled']) {
		return false;
	}

	$msg=stripslashes($msg);
	$server=$config['mailserver'];

	if ($config['email_type'] == 0) {
		//1//mail by socket

		$header="To:$recipient\r\n";
		$header.="From: $from\r\n";
		$header.="Subject: $subject\r\n";
		$header.="Content-Type: text/html; \r\n";
		$header.="X-Priority: 3\r\n";
		$header.="cc: ";
		for ($i=0; $i < sizeof ($bcc) ; $i++) {
			$header .= $bcc[$i];
			if ($i < sizeof($bcc)-1)
					$header .= ",";
		}

		$header.="\r\n";

		$body=$msg."\r\n";

		$socks=@fsockopen($server,25);

		if (!$socks) return 0; // mail server is not ready
																							// for debuging			
		fputs($socks, "HELO\r\n");								$reply=fgets($socks,1024); echo "."; //	$reply=fgets($socks,1024); echo "$reply.";
		fputs($socks, "MAIL FROM: $from\r\n");		//	$reply=fgets($socks,1024); echo "$reply.";
		fputs($socks, "RCPT TO: $recipient\r\n");	//	$reply=fgets($socks,1024); echo "$reply.";
		fputs($socks, "DATA \r\n$header\r\n");		//	$reply=fgets($socks,1024); echo "$reply.";
		fputs($socks, "$body \r\n.\r\n");						//	$reply=fgets($socks,1024); echo "$reply.";
		fputs($socks, "QUIT\r\n");									//	$reply=fgets($socks,1024); echo "$reply.";

		return 1;

	}
	else if ($config['email_type']==1) {
		//2// mail by php mail function 

		$header.="From: $from\r\n";
		if ($bcc) 
			$header.="Bcc: ".$bcc."\r\n";
		$header.="X-Priority: 3\r\n";
		$header.="Return-Path: <".$config['adminmail'].">\r\n";
		$header.="Content-Type: text/html; charset=window-874\r\n";
		$header.="\r\n";
		if (@mail($recipient,$subject,$msg,$header)) {
			return 1;
		}
		else {
			return 0;
		}
	}
}
?>