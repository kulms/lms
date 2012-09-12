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
* webboard
*/
function showBoard() {
	global $config,$lang,$usersess;
	global $courseid,$scheduleid;

	viewMenu("Board",$courseid,$scheduleid,$lang['boarddesc']);

	if (checkauth($scheduleid) || checkInst($courseid) || $usersess->get_var("admin") || !isScheduleBased($courseid)) { 
		displayMessage();
		postForm();
	}
}


/**
* แสดงหัวข้อคำถาม
*/
function displayMessage() {
	global $config,$lang,$usersess,$color;
	global $courseid,$scheduleid;

	if (empty($courseid)) {
		$courseid = db_getvar($config['tablescheduling'],"SchedulingID='$scheduleid'","CourseID");
	}

	// if not schedule-based course, find schedule id
	if (!isScheduleBased($courseid)) {
		$scheduleid = db_getvar($config['tablescheduling'],"CourseID='$courseid'","SchedulingID");
	}

	$sql = "SELECT m.*, MAX(d.Posttime) pt FROM $config[tablemessage] m, $config[tablemessage] d WHERE m.SchedulingID='$scheduleid' AND d.SchedulingID='$scheduleid' AND d.Threadid=m.Threadid AND m.Threadindex='0' AND m.Options='1' GROUP BY m.Threadid ORDER BY pt DESC";

	$result=db_select($sql);
	$rows=mysql_num_rows($result);
	if ($rows>0) {

		echo "<TABLE width='98%'  border=0 cellpadding=1 cellspacing=0>";
		echo "<TR height=20><TD class=head align=center width=20><B>No</B></TD><TD  class=head width=5>&nbsp;</TD><TD  class=head  align=center><B>$lang[posttitle]</B></TD><TD class=head  width=40><B>$lang[msgs]</B></TD><TD class=head  width=80><B>$lang[poster]</B></TD><TD  class=head width=100><B>$lang[mr]</B></TD>";
		echo "</TR>";
		echo "</TABLE>";
		echo "<script language='JavaScript' type='text/javascript' src='js/popup.js'></script>";
		echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=3 border=0>";
		for($i=0;list($id,$cid,$threadid,$threadindex,$poster,$title,$content,$icon,$ip,$posttime,$options,$ptime) = mysql_fetch_row($result);$i++) {
			$title=stripslashes($title);
			 if ($i % 2)			// สลับสีเพื่อความสวยงาม		
				 $bgcolor = $color['color_b'];
			else
				$bgcolor = $color['color_a'];
			 if ($icon)			//แสดง icon หน้ากระทู้
				$icon = "<img src='$config[msgiconsdir]/$icon'>";
			else
				$icon = "<img src='$config[msgiconsdir]/$config[msgicon]'>";
			$datetext = date($config['dateformat'],sql_to_unix_time($ptime));
			$count=threadcount($cid,$threadid)-1;

			$level = db_getvar($config['tableuser'],"Nickname='$poster'","Level");

			if ($level==$config['admin_level'])
				$usericon=$config['admin_icon'];
			else if ($level==$config['instructor_level'])
				$usericon=$config['instructor_icon'];
			else 
				$usericon=$config['user_icon'];
		

			// List topic
			echo "<TR bgcolor=$bgcolor valign=top>";
			echo "<TD align=center width=20>",sprintf("%06d",$threadid),"</TD>";
			echo "<TD align=right width=5>$icon</TD>";
			echo "<TD align=left>";
			$title = filter($title,1);	
			echo "<a href=\"javascript:popup('index.php?action=displaythread&mid=$id','_blank',450,500)\">$title</a>";
			echo "</TD>";
			echo "<TD width=40 align=center>$count</TD>";
			echo "<TD width=80><img src='images/$usericon' align=absmiddle> $poster</TD>";
			echo "<TD width=100>$datetext</TD>";
			echo "</TR>";
		}
		echo '<TR HEIGHT=1><TD COLSPAN="6"  background="images/line2.gif"></TD></TR>';
		echo "</TABLE>";

	}
}


/**
* ตั้งกระทู้/คำถาม
*/
function postForm() {
	global $config,$lang,$usersess;
	global $courseid,$scheduleid;
	global $posttitle,$postcontent,$posticon;

	// for quote problem
	$posttitle=stripslashes($posttitle);
	$posttitle=str_replace("\"","&quot;",$posttitle);
	$postcontent=stripslashes($postcontent);


	?>
		<script language="javaScript">
		function formSubmit(val) {
			document.forms.Post.action.value = val;
			if(checkFields()) document.forms.Post.submit();
		}
		
		function clearFields() {
			document.forms.Post.reset();
		}

		function checkFields() {
			var title = document.forms.Post.posttitle.value;
			var content = document.forms.Post.postcontent.value;
		
			if (title  == "" ) {
				alert("<?=$lang['alertposttitle']?>");
				document.forms.Post.posttitle.focus();
				return false;
			} 
			if (content  == "" ) {
				alert("<?=$lang['alertpostmsg']?>");
				document.forms.Post.postcontent.focus();
				return false;
			} 
		return true; 
		}
	</script>

	<CENTER><P>
		<FORM name=Post action="index.php?" method=post>
		<INPUT TYPE="hidden" name=action>
		<INPUT TYPE="hidden" name=courseid value="<?=$courseid?>">
		<INPUT TYPE="hidden" name=scheduleid value="<?=$scheduleid?>">

		<table border=0 cellpadding=0 cellspacing=0 width='80%' class=form><TR>
			<td>
					<table border=0 cellspacing=0 cellpadding=4 width='100%'>
					<tr>
						<td class=head colspan=2><IMG SRC="images/bul.gif" WIDTH="10" HEIGHT="10" BORDER="0" ALT="" align=middle> <B><?=$lang['postnew']?></B></td>
					</tr>
					<tr>
						<td valign=middle width=80 align=right><?=$lang['posttitle']?>:</td>
						<td><input type="text" name="posttitle" size=30 value="<?=$posttitle?>" style='width:90%'></td>
					</tr>
					<tr>
						<td valign=top align=right><?=$lang['icon']?>:</td>
						<td>
						<? listMsgIcons($posticon); ?>
						</td>
					</tr>
					<tr>
						<td valign=top align=right><?=$lang['message']?>:<BR><BR>
						<a href="javascript: window.popup('html/<?=$config['language']?>/efcode.html','efcode',550,500);">(Code & Smilies)</a></td>
						<td><textarea cols="30" rows="6" name="postcontent" wrap="soft" style="width: 90%;"><?=$postcontent?></textarea></td>
					</tr>	
					<tr>
					<td valign=top align=right><?=$lang['postname']?>:</td>
					<td><B><?=$usersess->get_var('nickname')?></B><? echo ' @'.date(' d-m-y H:i'); ?></td>
					</tr>
					<tr height=40 valign=middle>
					<td>&nbsp;</td>
					<td>
					
					<INPUT CLASS="button" TYPE="button" VALUE="<?=$lang['button_postmsg']?>" Onclick="javascript:formSubmit('messagesave')">
					<INPUT CLASS="button" TYPE="button" VALUE="<?=$lang['button_postpreview']?>" Onclick="javascript:formSubmit('messagepreview')">
					<INPUT CLASS="button" TYPE="button" VALUE="<?=$lang['button_cancel']?>" Onclick="javascript: window.open('index.php?action=showboard&courseid=<?=$courseid?>&scheduleid=<?=$scheduleid?>','_self')">
					</td>
					</tr>
				</table>
	</td>
	</tr>
	</table>
	</form>
	</CENTER>
	<P>
<?
					echo "<CENTER><IMG SRC=$config[msgiconsdir]/student.gif>$lang[student] &nbsp;&nbsp;&nbsp;<IMG SRC=$config[msgiconsdir]/instructor.gif> $lang[coach] &nbsp;&nbsp;&nbsp;<IMG SRC=$config[msgiconsdir]/admin.gif> $lang[admin]</CENTER><BR>&nbsp;";
}


/**
* เก็บตั้งกระทู้คำถาม
*/
function messageSave($preview){
	global $config,$lang,$usersess;
	global $courseid,$scheduleid;
	global $posttitle,$postcontent,$posticon;
	global $HTTP_SERVER_VARS;

	if ($preview) {
		$showposttitle = stripslashes($posttitle);	
		$showposttitle = filter($showposttitle,1);	
		$showpostcontent = stripslashes($postcontent);			
		$showpostcontent = filter($showpostcontent,1);	
		echo "<center><table border=0 cellspacing=5 cellpadding=5 width=80%>";
		echo "<tr bgcolor=#FFFFFF><td align=left><font face='ms sans serif'  color=#000000 size=2><B>Preview.. </B></font></td></tr>";
		echo "<tr bgcolor=#FFCC00><td align=center><font face='ms sans serif'  color=#FFFFFF size=2><B>$showposttitle</B></font></td></tr>";
		echo "<tr bgcolor=#FFFFCC><td><font face='ms sans serif'  color=#006633>$showpostcontent</font><P></td></tr></table></center><P>";
		postForm();
	}
	else {
		$posttitle = addslashes($posttitle);	
		$postcontent = addslashes($postcontent);			
		$threadid = lastthread($scheduleid) + 1;
		$sql = "INSERT INTO $config[tablemessage] (SchedulingID, Threadid, Threadindex, Title, Content, Poster, IP , Icon) ";
		$sql .= " VALUES ('$scheduleid', '$threadid', '0', '$posttitle', '$postcontent', '".$usersess->get_var("nickname")."', '$HTTP_SERVER_VARS[REMOTE_ADDR]', '$posticon')";	
		db_query($sql);

		// mail to instructor
		if ($config['notifyinstructor']) {
			$from=db_getvar($config['tableuser'],"Nickname='".$usersess->get_var("nickname")."'","Email");
			$instructor = db_getvar($config['tablescheduling'],"SchedulingID='$scheduleid'","Instructor");
			$courseid = db_getvar($config['tablescheduling'],"SchedulingID='$scheduleid'","CourseID");
			$to = db_getvar($config['tableuser'],"Nickname='$instructor'","Email");
			$coursename=db_getvar($config['tablecourse'],"CID='$courseid'","CourseName");
			$start=db_getvar($config['tablescheduling'],"SchedulingID='$scheduleid'","Start");
			$mid=db_getvar($config['tablemessage'],"SchedulingID='$scheduleid' and Threadid='$threadid' and Threadindex='0'","ID");
			$subject=$lang['notifymail_subject']." ".$coursename." - ".$usersess->get_var("nickname");
			$msg="<font face='ms sans serif' size='2' ><B>$coursename</B> ($start)<P>";
			$msg.="<B>".$lang['posttitle']."</B>: <A HREF='$config[homeurl]/index.php?action=displaythread&mid=$mid',target='_blank'>".$posttitle."</A><P>";
			$msg.="<B>".$lang['message']."</B><BR>".$postcontent;
			$msg=str_replace("\r\n","<BR>\r\n",$msg);
			mailsock($from,$to,'',$subject,$msg);
		}

		update_event($usersess->get_var("nickname"), "Post message $posttitle to <A HREF=javascript:popup('index.php?action=displaythread&mid=$mid','_blank',450,500)>$courseid-$scheduleid</A>");
		$posttitle="";
		$postcontent="";
		showBoard();
	}
}


/**
* แสดงรายละเอียดกระทู้ พร้อมแสดงฟอร์มรับคำตอบ
*/
function displayThread() {
	global $config,$lang,$usersess;
	global $mid;
	global $subaction;
	global $replymsg,$titlemsg;
	
	$sql = "SELECT SchedulingID,Threadid,Threadindex  FROM $config[tablemessage] WHERE ID='$mid'";
	$result=db_select($sql);
	list($sid, $tid, $tin) = mysql_fetch_row($result);

	if ($subaction == "delmsg") {
		$sql = "UPDATE  $config[tablemessage]  SET  Options='0' WHERE SchedulingID='$sid' AND Threadid='$tid'";  // only disable set options=0
		$result=db_select($sql);
		echo "<script>window.close();window.opener.history.go(0);</script>";
		return;
	}

	if ($subaction == "delthread") {
		$sql = "UPDATE  $config[tablemessage]  SET  Options='0' WHERE ID='$mid' "; // only disable set options=0
		$result=db_select($sql);
	}

	if ($subaction == "updatemsg") {
		$titlemsg=addslashes($titlemsg);
		$replymsg=addslashes($replymsg);
		$sql = "UPDATE  $config[tablemessage]  SET  Title='$titlemsg', Content='$replymsg' WHERE ID='$mid' ";
		$result=db_select($sql);
		$replymsg="";
	}

	if ($subaction == "updatethread") {
		$replymsg=addslashes($replymsg);	
		$sql = "UPDATE  $config[tablemessage]  SET  Content='$replymsg' WHERE ID='$mid' ";
		$result=db_select($sql);
		$replymsg="";
	}

	$sql = "SELECT * FROM $config[tablemessage] WHERE SchedulingID='$sid' AND Threadid='$tid' AND Options='1' ORDER BY Threadindex";
	$result=db_select($sql);
	$rows=mysql_num_rows($result);
	if ($rows>0) {
		for($i=0;list($mid_t,$sid_t,$threadid,$threadindex,$poster,$title,$content,$icon,$ip,$posttime,$options) = mysql_fetch_row($result);$i++) {
			$datetext = date($config['dateformat'],sql_to_unix_time($posttime));
			$title= stripslashes($title);
			$content = stripslashes($content);
			
			if ($threadindex == 0)
				$head = $title;

			if ($i ==0) {  // แสดงส่วนหัวคำถาม
					echo "<html>";
					echo "<head><title>$title</title>";
					echo "<LINK REL=STYLESHEET HREF='theme/".$config['theme']."/style/default.css' type='text/css'></head>";
					echo "<body bgcolor=#006600><center>";
					echo "<table border=0 cellspacing=0 cellpadding=5 width='95%'>";
					if ($subaction=="editmsg" && $mid==$mid_t) {
						$title=str_replace("\"","&quot;",$title);	
						echo "<FORM METHOD=POST ACTION=index.php>";
						echo "<INPUT TYPE=hidden name=action value=displaythread>";
						echo "<INPUT TYPE=hidden name=subaction value=updatemsg>";
						echo "<INPUT TYPE=hidden name=mid value=$mid_t>";
						echo "<tr bgcolor=#FFCC00>";
						echo "<td><font face='ms sans serif'  color=#FFFFFF size=2><B>$lang[posttitle]:</B></font>";
						echo "<INPUT TYPE=text NAME=titlemsg VALUE=\"$title\" style='width=80%'>";
						echo "</td></tr>";
						echo "<tr bgcolor=#FFFFCC><td  valign=top>";
						echo "<B>$lang[message]:</B> <BR>";
						echo "<TEXTAREA NAME=replymsg ROWS=5 COLS=30 style='width=98%'>$content</TEXTAREA><BR>";
						echo "<CENTER><INPUT class=button TYPE=submit submit VALUE='$lang[button_edit]'> ";
						echo "<INPUT class=button TYPE=button name=submit VALUE='$lang[button_cancel]' onclick=\"javascript:window.open('index.php?action=displaythread&mid=$mid_t','_self')\">";
						echo "</CENTER></FORM>";
					}
					else {
						$title = filter($title,1);	
						$content = filter($content,1);	
						echo "<tr bgcolor=#FFCC00>";
						echo "<td align=center><font face='ms sans serif'  color=#FFFFFF size=2><B>$title</B></font>";
						echo "</td></tr>";
						echo "<tr bgcolor=#FFFFCC><td  valign=top>";
						echo "<font face='ms sans serif'  color=#006633>$content</font>";
					}
					echo "<P><div align=right><font face='ms sans serif'  color=#330000 size=1><B>$lang[poster]</B>  $poster ($datetext) </FONT>&nbsp;";


					if ($usersess->get_var('admin') || $usersess->get_var('instructor') || $usersess->get_var('nickname') == "$poster") {
						echo " <A HREF='$PHP_SELF?action=displaythread&subaction=editmsg&mid=$mid_t'><img src='images/edit.gif' ALT='edit' border=0></A>";
						echo "<A HREF=\"javascript:if(confirm('Are you sure?')) window.open('$PHP_SELF?action=displaythread&subaction=delmsg&mid=$mid_t','_self')\"><img src='images/delete.gif' border=0 alt='delete'></A>";
					}
					echo " <A HREF=\"index.php?action=msg2folder&mid=$mid_t\"><IMG SRC=\"images/save.gif\" ALT='save to notebook' border=0></A>";
					echo "</div>";
					echo "</td></tr>";
					echo "</table><BR>";
			}

			else {  // แสดงคำตอบ
				if ($i==1) {
					echo "<table border=0 cellspacing=0 cellpadding=5 width=95%>";
					echo "<tr><td class=head2><B>$lang[postmsg]... </B></td></tr>";
					echo "</table>";
				}
				echo "<table bgcolor=#FFFFFF border=0 cellspacing=0 cellpadding=5 width=95%>";
				echo "<tr><td>";
				if ($subaction=="edittid" && $mid==$mid_t) {
						echo "<FORM METHOD=POST ACTION=index.php>";
						echo "<INPUT TYPE=hidden name=action value=displaythread>";
						echo "<INPUT TYPE=hidden name=subaction value=updatethread>";
						echo "<INPUT TYPE=hidden name=mid value=$mid_t>";
						echo "<B>$lang[message]:</B> <BR><TEXTAREA NAME=replymsg ROWS=5 COLS=30 style='width=98%'>$content</TEXTAREA><BR>";
						echo "<CENTER><INPUT class=button TYPE=submit submit VALUE='$lang[button_edit]'> ";
						echo "<INPUT class=button TYPE=button name=submit VALUE='$lang[button_cancel]' onclick=\"javascript:window.open('index.php?action=displaythread&mid=$mid_t','_self')\">";
						echo "</CENTER></FORM>";
				}
				else {
					$content = filter($content,1);	
					echo "<font face='ms sans serif'  color=#CCCCCC size=1>[$i]</font>&nbsp;&nbsp;";
					echo "<font face='ms sans serif'  color=#000033>$content</font>";
				}
				echo "<P><div align=right><font face='ms sans serif'  color=#330000 size=1>$poster ($datetext) </FONT>&nbsp;";
	
				if ($usersess->get_var('admin') || $usersess->get_var('instructor') || $usersess->get_var('nickname') == "$poster") {
						echo " <A HREF='$PHP_SELF?action=displaythread&subaction=edittid&mid=$mid_t'><img src='images/edit.gif' ALT='edit' border=0></A>";
						echo " <A HREF=\"javascript:if(confirm('Are you sure?')) window.open('$PHP_SELF?action=displaythread&subaction=delthread&mid=$mid_t','_self')\"><img src='images/delete.gif' border=0 alt='delete'></A>";
				}

				echo "  <A HREF=\"index.php?action=msg2folder&mid=$mid_t\"><IMG SRC=\"images/save.gif\" ALT='save to notebook' border=0></A>";
				echo "</div></td></tr>";
				echo "<tr height=1 bgcolor=#006600><td></td></tr></table>";
			}
		}
		replyForm();
	}
	else {
		echo "<html>";
		echo "<head><title>Error!</title>";
		echo "<LINK REL=STYLESHEET HREF='theme/".$config['theme']."/style/default.css' type='text/css'></head>";
		echo "<body bgcolor=#FFFFFF><center><BR><BR><FONT COLOR=#FF3300><B>Not found!!</B></FONT>";
		echo "<P><INPUT TYPE=button VALUE='Close Window' onclick='javascript:window.close()'>";
	}
}


/**
* HTML Form for posting a new message
*/
function replyForm() {
	global $config,$lang,$usersess;
	global $mid,$replymsg;

	$replymsg = stripslashes($replymsg);	
	?>
	<script language="javaScript">
		function formSubmit(val) {
			document.forms.Reply.action.value = val;
			if(checkFields()) document.forms.Reply.submit();
		}
		
		function clearFields() {
			document.forms.Reply.reset();
		}

		function checkFields() {
			var content = document.forms.Reply.replymsg.value;
		
			if (content  == "" ) {
				alert("<?=$lang['alertpostmsg']?>");
				document.forms.Reply.replymsg.focus();
				return false;
			} 
		return true; 
		}
	</script>

	<hr width=50% size=1>
	<form name=Reply action="index.php" method=post>
		<INPUT TYPE="hidden" name=action>
		<INPUT TYPE="hidden" name=mid value="<?=$mid?>">

		<table border=0 cellpadding=0 cellspacing=1 bgcolor=#003300 width='95%'>
			<tr><td>
				<table border=0 cellspacing=0 cellpadding=4 width=100% class=form>
				<tr>
					<td class=head colspan=2> <b><? echo "$lang[replyto]";?></b> </td>
				</tr>
			<tr>
				<td valign=top align=right width=60><b><?=$lang['postname']?> : </b></td>
				<td><?=$usersess->get_var('nickname')?></td>
			</tr>	
			<tr>
				<td valign=top align=right width=60><b><?=$lang['message']?> : </b></td>
				<td><textarea cols="30" rows="6" name="replymsg" wrap="soft" style="width: 90%;"><?=$replymsg?></textarea></td>
			</tr>		
			<tr>
				<td>&nbsp;</td>
				<td>
					
				<INPUT CLASS="button" TYPE="button" VALUE="<?=$lang['button_postreply']?>" Onclick="javascript:formSubmit('replysave')">
				<INPUT CLASS="button" TYPE="button" VALUE="<?=$lang['button_postpreview']?>" Onclick="javascript:formSubmit('replypreview')">

				<BR>&nbsp;
				
				</td>
			</tr>
			</table>
	</td></tr>
	</table>
	</form>
	

	<table cellspacing=0 cellpadding=0 width=98% border=0>
	<tr><td align=left>
	<font face='ms sans serif' size=1 color="#FFFFFF"><BR>
	<img align="absmiddle" src='images/edit.gif' ALT='' border=0> <?=$lang['button_edit']?>&nbsp;
	<IMG align="absmiddle" SRC="images/delete.gif"  BORDER=0  ALT="Delete"></A> <?=$lang['button_delete']?>&nbsp;
	<IMG align="absmiddle" SRC="images/save.gif" ALT='' border=0> <?=$lang['button_savetonote']?>
	</td>
	<td align=right>
	
	<A HREF="index.php?action=displaythread&forum=<?=$forum?>&mid=<?=$mid?>" target="_self"><IMG align="absmiddle" SRC="images/refresh.gif" BORDER=0 ALT="Refresh"><font face='ms sans serif'  size=2 color="#FFFFFF">Refresh</A>&nbsp;&nbsp;</td></tr></table>

<?	
}

/*- - - Save Reply message- - -*/
function replySave($preview) {
	global $config,$lang,$usersess;
	global $HTTP_SERVER_VARS;
	global $mid,$replymsg;

	$sql = "SELECT SchedulingID,Threadid,Threadindex  FROM $config[tablemessage] WHERE ID='$mid'";
	$result=db_select($sql);
	list($sid, $tid, $tin) = mysql_fetch_row($result);
		
	if ($preview) {
		$showreplymsg = stripslashes($replymsg);
		$showreplymsg = filter($showreplymsg,1);
		echo "<html>";
		echo "<head><title>Preview..</title>";
		echo "<LINK REL=STYLESHEET HREF='theme/".$config['theme']."/style/default.css' type='text/css'></head>";
		echo "<body bgcolor=#006600>";		
		echo "<center><table bgcolor=#FFFFFF border=0 cellspacing=1 cellpadding=5 width=95%>";
		echo "<tr><td align=left class=head2><B>Preview.. </B></td></tr>";
		echo "<tr bgcolor=#FFFFCC><td>$showreplymsg<P></td></tr></table><P>";
		replyForm();
	}
	else {
		$replymsg=addslashes($replymsg);
		$threadindex = lastthreadindex($sid,$tid) + 1;
		$sql = "INSERT INTO $config[tablemessage] (SchedulingID, Threadid, Threadindex, Title, Content, Poster, IP , Icon) ";
		$sql .= " VALUES ('$sid', '$tid', '$threadindex', '', '$replymsg', '".$usersess->get_var("nickname")."', '$HTTP_SERVER_VARS[REMOTE_ADDR]', '')";	

		db_query($sql);

		// mail to instructor
		if ($config['notifyinstructor']) {
			$from=db_getvar($config['tableuser'],"Nickname='".$usersess->get_var("nickname")."'","Email");
			$instructor = db_getvar($config['tablescheduling'],"SchedulingID='$sid'","Instructor");
			$courseid = db_getvar($config['tablescheduling'],"SchedulingID='$sid'","CourseID");
			$to = db_getvar($config['tableuser'],"Nickname='$instructor'","Email");
			$coursename=db_getvar($config['tablecourse'],"CID='$courseid'","CourseName");
			$start=db_getvar($config['tablescheduling'],"SchedulingID='$sid'","Start");
			$posttitle=threadtitle ($sid, $tid);
			$subject=$lang['notifymail_subject']."$coursename - ".$usersess->get_var("nickname");
			$msg="<font face='ms sans serif' size='2' ><B>$coursename</B> ($start)<P>";
			$msg.="<B>".$lang['posttitle']."</B>: <A HREF='$config[homeurl]/index.php?action=displaythread&mid=$mid',target='_blank'>".$posttitle."</A><P>";
			$msg.="<B>".$lang['postmsg']."</B><BR>".$replymsg;
			$msg=str_replace("\r\n","<BR>\r\n",$msg);
			mailsock($from,$to,'',$subject,$msg);
		}


		update_event($usersess->get_var("nickname"),"Reply message to <A HREF=javascript:popup('index.php?action=displaythread&mid=$mid','_blank',450,500)>$subject</A>");
		$replymsg="";
		displayThread();
	}
}


//= WEBBOAD UTILITIES====================================================
function threadcount($forumname,$threadid) {
/* count number of messages in a thread */
	global $config;

	$sql = "SELECT * FROM $config[tablemessage] WHERE SchedulingID='$forumname' AND Threadid='$threadid' AND Options='1' ";
	$result=db_select($sql);
	$rows=mysql_num_rows($result);
	
	return $rows;
}


//=========================================================================
function threadtitle ($forum,$id) {
	global $config;

	$sql = "SELECT Title FROM $config[tablemessage] WHERE SchedulingID='$forum' AND Threadid='$id' AND Threadindex='0' AND Options='1' ";
	$result=db_select($sql);
	list($head)=mysql_fetch_row($result);
	
	return $head;
}

//=========================================================================
function lastthread($forum) {
/* Return the last used thread id for a given $forum */
/* Will return -1 for no available threadids */
	global $config;
	

	$sql = "SELECT Threadid FROM $config[tablemessage] WHERE SchedulingID='$forum' ORDER BY Threadid DESC LIMIT 0,1";
	$result=db_select($sql);
//	$rows=mysql_num_rows($result);
	list($lastid) = mysql_fetch_row($result);
	
	return $lastid;
}

//=========================================================================
function lastthreadindex($forum,$id){
/* Return the last used thread id for a given $forum */
	global $config;
	
	$sql = "SELECT Threadindex FROM $config[tablemessage] WHERE SchedulingID='$forum' and Threadid='$id' ORDER BY Threadindex DESC LIMIT 0,1";
	$result=db_select($sql);
	list($lastid) = mysql_fetch_row($result);
	
	return $lastid;
}

//===END WEBBOARD UTILITIES======================================================================


/*- - - แสดง icon นำหน้ากระทู้ - - - -*/
function listMsgIcons($iconold)
{
	global $config;
	
	$icons = dir_list($config['msgiconsdir']);

	for ($i=0;$i<sizeof($icons);$i++) {
		if (!($icons[$i] == "instructor.gif" || $icons[$i] == "admin.gif" || $icons[$i] == "student.gif") && ereg(".gif",$icons[$i])) {
			if ($iconold == $icons[$i])
				echo "<input type=radio name='posticon' value='$icons[$i]' checked><img src='$config[msgiconsdir]/$icons[$i]'>";
			else
				echo "<input type=radio name='posticon' value='$icons[$i]'><img src='$config[msgiconsdir]/$icons[$i]'>";
			$c = $i+3; //3 = จำนวน icon ที่ไม่แสดง
			$d =sizeof($icons)/2;
			if ($c%$d==0) 
				echo "<br>";
		}
	}	
}


/*- - - รายชื่อไฟล์ใน dirname - - - -*/
function dir_list($dirname) {
	$handle=opendir($dirname);
	while ($file = readdir($handle)) {
   		if($file=='.'||$file=='..'||is_dir($dirname.$file)) continue;
   		$result_array[]=$file;
 	}
 	closedir($handle);
 	return $result_array;
}


/*- - - Filter  message and emotion code - - -*/
function filter($data,$efcode)
{
	global $config,$lang;

	$data = str_replace("<","&lt;",$data);
	$data = str_replace(">","&gt;",$data);
	$data = nl2br($data);
	
	if ($efcode) {
		$data = " ".$data;
		$data = preg_replace("#([\n ])([a-z]+?)://([^, \n\r]+)#i", "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>", $data);
		$data = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^, \n\r]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $data);
		$data = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([^, \n\r]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $data);

		/* Remove space */
		$data = substr($data, 1);
		$data = str_replace("\n","",$data);
		$data = str_replace("\r","",$data);
		
		$data = str_replace(":)","<IMG src=\"$config[smileysdir]/smile.gif\" border=0>",$data);
		$data = str_replace(":D","<IMG src=\"$config[smileysdir]/biggrin.gif\" border=0>",$data);
		$data = str_replace(":P","<IMG src=\"$config[smileysdir]/tongue.gif\" border=0>",$data);
		$data = str_replace(":?:","<IMG src=\"$config[smileysdir]/confused.gif\" border=0>",$data);
		$data = str_replace(":wink:","<IMG src=\"$config[smileysdir]/wink.gif\" border=0>",$data);
		$data = str_replace(":angry:","<IMG src=\"$config[smileysdir]/angry.gif\" border=0>",$data);
		$data = str_replace(":rolleyes:","<IMG src=\"$config[smileysdir]/rolleyes.gif\" border=0>",$data);
		$data = str_replace(":(","<IMG src=\"$config[smileysdir]/sad.gif\" border=0>",$data);
		$data = str_replace(":laugh:","<IMG src=\"$config[smileysdir]/laugh.gif\" border=0>",$data);
		$data = str_replace(":grrr:","<IMG src=\"$config[smileysdir]/grrr.gif\" border=0>",$data);
		$data = str_replace(":eek:","<IMG src=\"$config[smileysdir]/eek.gif\" border=0>",$data);
		$data = str_replace(":uhoh:","<IMG src=\"$config[smileysdir]/uhoh.gif\" border=0>",$data);
		$data = preg_replace("/\[b\](.*?)\[\/b\]/si", "<B>\\1</B>", $data);
		$data = preg_replace("/\[i\](.*?)\[\/i\]/si", "<I>\\1</I>", $data);
		$data = preg_replace("/\[u\](.*?)\[\/u\]/si", "<U>\\1</U>", $data);
		$data = preg_replace("/\[url\](http:\/\/)?(.*?)\[\/url\]/si", "<A HREF=\"http://\\2\" TARGET=\"_blank\">\\2</A>", $data);
		$data = preg_replace("/\[url=(http:\/\/)?(.*?)\](.*?)\[\/url\]/si", "<A HREF=\"http://\\2\" TARGET=\"_blank\">\\3</A>", $data);
		$data = preg_replace("/\[email\](.*?)\[\/email\]/si", "<A HREF=\"mailto:\\1\">\\1</A>", $data);
		$data = preg_replace("/\[img\](.*?)\[\/img\]/si", "<IMG SRC=\"\\1\">", $data);
		$data = preg_replace("/\[code\](.*?)\[\/code\]/si", "<p><blockquote><font face='ms sans serif'  size=1>code:</font><HR noshade size=1><pre>\\1<br></pre><HR noshade size=1></blockquote><p>", $data);	
	}

	// Bad word filter
	$repchar = '.';
	
	for($i=0;$i<sizeof($lang['badwords']);$i++){
		$rep = '';
		$ltrs = strlen($lang['badwords'][$i])-1;
		for ($n=0;$n<$ltrs;$n++){
			$rep .= $repchar;
		}
		$replacement = substr($lang['badwords'][$i],0,1).$rep;
		$data = eregi_replace($lang['badwords'][$i],$replacement,$data);
	}
	
	return $data;
}


/**
* แสดงรายชื่อเพื่อนร่วมห้องที่เปิดเผย
*/
function showRoster() {
	global $config,$lang,$usersess;
	global $courseid,$scheduleid;

	viewMenu("Roster",$courseid,$scheduleid,$lang['rosterdesc']);

	if (checkauth($scheduleid) || checkInst($courseid)) {	

		$sql = "SELECT e.Nickname,u.Firstname,u.Lastname,u.Email,u.Phone,u.Shows FROM $config[tableenroll] e, $config[tableuser] u WHERE e.Nickname=u.Nickname and e.SchedulingID='$scheduleid'";
		$result=db_select($sql);
		$total=mysql_num_rows($result);

		if ($usersess->get_var('admin')) 
			$sql = "SELECT e.Nickname,u.Firstname,u.Lastname,u.Email,u.Phone,u.Shows FROM $config[tableenroll] e, $config[tableuser] u WHERE e.Nickname=u.Nickname and e.SchedulingID='$scheduleid'";
		else 
			$sql = "SELECT e.Nickname,u.Firstname,u.Lastname,u.Email,u.Phone,u.Shows FROM $config[tableenroll] e, $config[tableuser] u WHERE e.Nickname=u.Nickname and e.SchedulingID='$scheduleid' and (e.Options&1)";

		$result=db_select($sql);
		$rows=mysql_num_rows($result);

		if ($rows > 0) {
			echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=3>";
			echo "<TR HEIGHT=20 align=center><TD class=head><B>$lang[nickname]</B></TD><TD class=head><B>$lang[firstname] $lang[lastname]</B></TD><TD class=head><B>$lang[email]</B></TD><TD class=head><B>$lang[phone]</B></TD></TR>";
			for($i=1;list($nickname,$firstname,$lastname,$email,$phone,$shows) = mysql_fetch_row($result);$i++) {
				if (!($shows & 1))
					$firstname="";
				if (!($shows & 2))
					$lastname="";
				if (!($shows & 4))
					$email="";
				else 
					$email="<a href='mailto:$email'>$email</a>";
				if (!($shows & 8))
					$phone="";
				
				echo "<TR bgcolor=".$config['colorn'][$i%2]."><TD>$i. $nickname</TD><TD>$firstname $lastname</TD><TD>$email</TD><TD>$phone</TD></TR>";
			}
			echo "<TR height=1 bgcolor=#CCCCCC><TD colspan=4></TD></TR>";
			echo "</TABLE>";
			echo "<DIV ALIGN=right>&nbsp;&nbsp;<IMG SRC='images/user.gif' align=middle>$lang[totalenrollstudent] <B>$total</B>&nbsp;&nbsp;</DIV><BR>";
		}

	}
}


/*- - - เก็บข้อความจาก webboard ลง สมุดบันทึก - - -*/
function msgFolder() {
	global $config,$lang,$usersess;
	global $mid;

	$sql = "SELECT SchedulingID, Threadid, Poster, Posttime, Content FROM $config[tablemessage] WHERE ID='$mid'";
	$result=db_select($sql);
	list($sid, $tid, $poster, $posttime, $content) = mysql_fetch_row($result);
	$courseid=db_getvar($config['tablescheduling'],"SchedulingID='$sid'","CourseID");
	$coursename=db_getvar($config['tablecourse'],"CID='$courseid'","CourseName");
	$title = threadtitle($sid,$tid);
	$title =stripslashes($title);
	$title = filter($title,1);
	$content=stripslashes($content);
	$content=filter($content,1);
	$datetext = date($config['dateformat'],sql_to_unix_time($posttime));

	// Type=0, folder name
	//			=1, from message webboard
	//			=2, from note
	$sql = "SELECT * FROM $config[tablefolder] WHERE Nickname='".$usersess->get_var("nickname")."' and Type='0' ORDER BY Subject";
	$result=db_select($sql);
	$rows=mysql_num_rows($result);
	if ($rows>0) {
		echo "<html>";
		echo "<head><title>$lang[button_add_note]</title>";
		echo "<LINK REL=STYLESHEET HREF='theme/".$config['theme']."/style/default.css' type='text/css'></head>";
		echo "<body bgcolor=#006600><center>";
		echo "<table width=98% bgcolor=#FFFFCC border=0 cellpadding=3 cellspacing=1>";
		echo "<tr valign=top><td colspan=2 bgcolor=#003399><font face='ms sans serif'  COLOR=#FFFFFF><B>$lang[button_add_note]</B></FONT></td></tr>";
		echo "<tr valign=top><td align=right>$lang[postname]:</td><td><B>$poster</B></td></tr>";
		echo "<tr valign=top><td align=right>$lang[date]:</td><td><B>$datetext</B></td></tr>";
		echo "<tr valign=top><td align=right>$lang[posttitle]:</td><td><B>$title</B></td></tr>";
		echo "<tr valign=top><td align=right height=50>$lang[message]:</td><td>$content</td></tr>";
		echo "<tr valign=top bgcolor=#FFFFC4><td align=right>&nbsp;</td><td>";
		echo "<FORM METHOD=POST ACTION='index.php'>";
		echo "<INPUT TYPE=hidden name='action' value='msg2foldersave'>";
		echo "<INPUT TYPE=hidden name='mid' value='$mid'>";
		echo "$lang[savemessage]:<BR>";
		echo "<SELECT NAME=fid>";
		while(	list($fid,$nickname,$subject,$type,$note,$notetime,$parent) = mysql_fetch_row($result)) {
			$chk=($subject==$coursename) ? "selected" : "";
			echo "<OPTION value=$fid $chk>$subject</OPTION>";
		}
		echo "</SELECT>";
		echo "<P><INPUT CLASS=\"button\" TYPE=\"submit\" VALUE=\"$lang[button_add_note]\">&nbsp;";
		echo "<INPUT CLASS=\"button\" TYPE=\"button\" VALUE=\"$lang[button_cancel]\" Onclick=\"javascript:window.open('index.php?action=displaythread&mid=$mid','_self')\">";
		echo "</FORM>";
		echo "</td></tr>";
		echo "</table>";
	}
}


/*- - - เก็บข้อความลงสมุกบันทึก - - -*/
function msgFolderSave() {
	global $config,$usersess;
	global $mid,$fid;
		
	$sql = "SELECT SchedulingID, Threadid, Poster, Posttime, Content FROM $config[tablemessage] WHERE ID='$mid'";
	$result=db_select($sql);
	list($sid, $tid, $poster, $posttime, $content) = mysql_fetch_row($result);
	$title = threadtitle($sid,$tid);
	$datetext = date($config['dateformat'],sql_to_unix_time($posttime));
	$content .= " \r\n\r\nby ".$poster." : ".$datetext;

	$sql = "INSERT INTO $config[tablefolder] (Nickname, Subject, Type, Note, Parent) ";
	$sql .= " VALUES ('".$usersess->get_var("nickname")."', '$title', '1', '$content', '$fid')";	

	db_query($sql);
	update_event($usersess->get_var("nickname"),"Save message to $folder");
	displayThread();
}



/**
* chat room 
*/
function chat() {
	global $lang,$config,$usersess;
	global $courseid,$scheduleid;

	viewMenu("Chat",$courseid,$scheduleid,$lang['chatdesc']);
	
	$nick=$usersess->get_var("nickname");
	$coursecode = db_getvar($config['tablecourse'],"CID='$courseid'","Code");

	if (empty($scheduleid)) {
		$room=$coursecode;
	}
	else {
		$room=$coursecode.'-'.$scheduleid;
	}

	if ($nick) {

?>
<BR><BR>
<center>
<applet name="applet" code="IRCApplet.class" archive="irc.jar,pixx.jar" codebase="include/chat/" width=550 height=290>
	<param name="CABINETS" value="irc.cab,securedirc.cab,pixx.cab">

	<param name="nick" value="<?=$nick?>">
	<param name="alternatenick" value="Anon???">
	<param name="name" value="<?=$nick?>">
	<param name="host" value="<?=$config['chatserver']?>">
	<param name="gui" value="pixx">
	<param name="command1" value="/join <?=$room?>"> 
	<param name="useinfo" value="true">
	<param name="quitmessage" value="Goodbye see you later!">
	<param name="asl" value="true">
	 <param name="style:sourcefontrule1" value="none+Channel all Tahoma 12">

	<param name="style:bitmapsmileys" value="true">
	<param name="style:smiley1" value=":) img/sourire.gif">
	<param name="style:smiley2" value=":-) img/sourire.gif">
	<param name="style:smiley3" value=":-D img/smile.gif">
	<param name="style:smiley4" value=":d img/smile.gif">
	<param name="style:smiley5" value=":-O img/OH-2.gif">
	<param name="style:smiley6" value=":o img/OH-1.gif">
	<param name="style:smiley7" value=":-P img/langue.gif">
	<param name="style:smiley8" value=":p img/langue.gif">
	<param name="style:smiley9" value=";-) img/clin-oeuil.gif">
	<param name="style:smiley10" value=";) img/clin-oeuil.gif">
	<param name="style:smiley11" value=":-( img/triste.gif">
	<param name="style:smiley12" value=":( img/triste.gif">
	<param name="style:smiley13" value=":-| img/OH-3.gif">
	<param name="style:smiley14" value=":| img/OH-3.gif">
	<param name="style:smiley15" value=":'( img/pleure.gif">
	<param name="style:smiley16" value=":$ img/rouge.gif">
	<param name="style:smiley17" value=":-$ img/rouge.gif">
	<param name="style:smiley18" value="(H) img/cool.gif">
	<param name="style:smiley19" value="(h) img/cool.gif">
	<param name="style:smiley20" value=":-@ img/enerve1.gif">
	<param name="style:smiley21" value=":@ img/enerve2.gif">
	<param name="style:smiley22" value=":-S img/roll-eyes.gif">
	<param name="style:smiley23" value=":s img/roll-eyes.gif">
	<param name="style:smiley24" value=":-V img/love.gif">
	<param name="style:smiley25" value=":-Z img/sleep.gif">
	<param name="style:smiley26" value=":-i img/argh.gif">

	<param name="style:backgroundimage" value="false">
	<param name="style:backgroundimage1" value="all all 0 background.gif">
	<param name="style:sourcefontrule1" value="all all Serif 12">
	<param name="style:floatingasl" value="true">

	<param name="pixx:timestamp" value="true">
	<param name="pixx:highlight" value="true">
	<param name="pixx:highlightnick" value="true">
	<param name="pixx:styleselector" value="true">
	<param name="pixx:setfontonstyle" value="true">
</applet>
<BR>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':)');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/sourire.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-D');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/smile.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-O');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/OH-2.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-P');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/langue.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+';-)');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/clin-oeuil.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':(');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/triste.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-|');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/OH-3.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':\'(');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/pleure.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-$');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/rouge.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+'(h)');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/cool.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-@');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/enerve1.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':@');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/enerve2.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-S');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/roll-eyes.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-V');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/love.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-Z');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/sleep.gif" WIDTH="23" HEIGHT="15" BORDER="0" ALT=""></A>
<A HREF="javascript:document.applet.setFieldText(document.applet.getFieldText()+':-i');document.applet.requestSourceFocus()"><IMG SRC="include/chat/img/argh.gif" WIDTH="20" HEIGHT="15" BORDER="0" ALT=""></A>

</center>
	<?
	}
}
?>