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
* Browse All Course
 */
function browseCourse() { 
	global $lang,$config;

	$sql = " SELECT s.School_name, c.CID,c.Code, c.CourseName, curdate() < date_add(createon,interval 30 DAY) ";
	$sql .= " FROM $config[tablecourse] c,$config[tableschool] s";
	$sql .= " WHERE s.School_code = c.School  and c.Enable='1' ORDER BY School_weight,Code";
	$result=db_select($sql);
//	echo $sql;

	echo "<TABLE WIDTH=615 CELLSPACING=0 CELLPADDING=2>";
	echo '<TR><IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/browse_courses.jpg" BORDER="0"><TD>';
	echo '</TD></TR>';
	
	for ($i=0;list($school,$cid,$code,$coursename,$shownew) = mysql_fetch_row($result);$i++) {
		$coursename=stripslashes($coursename);
		$coursename=htmlspecialchars($coursename);
		if ($schoool != $school) {
			$schoool=$school;
			echo "<TR><TD width=\"100%\"class=\"head2\" valign=\"top\" align=\"left\"> &nbsp;<B>$school</B><A NAME=\"$school\"></TD></TR>";
		}

		if ($shownew == 1) {
			$new = "<img src=images/new.gif border=0>";
		}

		echo "<TR><TD valign=\"middle\" align=\"left\"><IMG SRC=\"images/line.gif\" WIDTH=12 HEIGHT=11 BORDER=0 align=absmiddle> $code&nbsp;-&nbsp;<A HREF=\"index.php?action=viewcourse&courseid=$cid\">$coursename</A> $new</TD>";
		echo "</TR>";
	}

	echo "</TABLE><P>";
}


/**
*	Course Outline
*/
function viewCourse() {
	global $config,$lang,$usersess;
	global $courseid,$scheduleid;

// ตรวจสอบว่าเคยลงทะเบียนไปหรือยัง และยังไม่ผ่าน
	if ($courseid) { // ถ้าเรียกจาก เมนูบน
		$sql = "SELECT s.SchedulingID,s.Start FROM $config[tablescheduling] s,$config[tableenroll] e";
		$sql .= " WHERE s.CourseID='$courseid' and e.Nickname='".$usersess->get_var("nickname")."' and s.SchedulingID=e.SchedulingID and e.Status='0' ";
		$result=db_select($sql);
		list($scheduleid, $start) = mysql_fetch_row($result);
	}
	else if ($scheduleid) { // เรียกจากเมนูซ้าย มี schedule id
		$sql = "SELECT s.CourseID,s.Start FROM $config[tablescheduling] s,$config[tableenroll] e";
		$sql .= " WHERE s.SchedulingID='$scheduleid' and e.Nickname='".$usersess->get_var("nickname")."' and s.SchedulingID=e.SchedulingID and e.Status='0' ";
		$result=db_select($sql);
		list($courseid, $start) = mysql_fetch_row($result);
	}

	viewMenu("Overview",$courseid,$scheduleid,$lang['showcourse']);

// รายละเอียดหลักสูตร
	$sql =  " SELECT CourseName,Creator,Description,Prerequisite,Objective,sum(Length), ";
	$sql .= " Reference,Firstname,Lastname,Email,Phone,Note  FROM ";
	$sql .= " $config[tablecourse] c left join $config[tablelesson] l on  c.CID=l.CourseID left join $config[tableuser] u on c.Creator=u.Nickname";
	$sql .= " WHERE c.CID='$courseid' GROUP BY l.CourseID ";

	$result=db_select($sql);	list($coursename,$creator,$description,$prerequisite,$objective,$courselength,$reference,$firstname,$lastname,$email,$phone,$note) = mysql_fetch_row($result);

	$coursename=stripslashes($coursename); $coursename=htmlspecialchars($coursename);
	$description=stripslashes($description); $description=nl2br($description);
	$objective=stripslashes($objective); $objective=nl2br($objective);
	$prerequistie=stripslashes($prerequistie); $prerequistie=nl2br($prerequistie);
	$reference=stripslashes($reference); $reference=nl2br($reference);
	$note=stripslashes($note); $note=nl2br($note);

	// ตรวจสอบว่าหลักสูตรนี้เปิดให้ลงทะเบียนหรือป่าว และแสดงบทเรียน
	$sql = "SELECT s.Start,sum(l.Length) FROM $config[tablescheduling] s, $config[tablelesson] l ";
	$sql .= "WHERE l.CourseID=s.CourseID  and s.CourseID='$courseid' and s.Start > Curdate() Group by s.CourseID,s.Start ORDER BY s.CourseID, s.Start";
	$result=db_select($sql);
	$rows = @mysql_num_rows($result);
	
	echo "<TABLE WIDTH=98% CELLSPACING=1 CELLPADDING=0 BGCOLOR=$config[color2]>";
	// แสดง enroll
	if (!$scheduleid) {  // ถ้ายังไม่เคยลงทะเบียน
		if ($rows) {			// เปิดให้ลงทะเบียน
			for($regok=0,$i=1;list($start,$length) = mysql_fetch_row($result);$i++) {
					$duration=thaiDateDuration($start,$length);
					$list .= "<LI>$duration";
					$regok=1;
			}
		}
	}

	?>
		<TR><TD>
		
			<TABLE WIDTH="100%" CELLSPACING="0" CELLPADDING="3">		
				<TR>
				<TD>
				<?=$lang['course']?>: <B><?=$coursename?></B><BR>
				<?=$lang['instructor']?>: <B><? echo "$firstname $lastname";?></B><BR>
				 <? if ($courselength) echo $lang['length'].": <B>".$courselength." ".$lang['day']."</B>"; ?>
				<?  
						if ($regok && !$usersess->get_var("admin") && !checkInst($courseid)) { 
							echo "&nbsp;<BR><INPUT class=\"button\" TYPE=\"submit\" VALUE=\"$lang[button_enroll]\" onclick=\"javascript:window.open('index.php?action=enrollcourse&courseid=$courseid','_self')\">";	
						}
				?>		
				 </TD></TR>
				<!-- <TR><TD BGCOLOR=<?=$config['color2']?> height=1></TD></TR>  -->
				<TR><TD><img src="images/bl.gif" border=0 ALIGN="absmiddle" HSPACE="3">&nbsp;<B><?=$lang['description']?></B></TD></TR>
				<TR><TD><?=$description?></TD></TR>
				<TR><TD>&nbsp;</TD></TR>
				<TR><TD><img src="images/bl.gif" border=0 ALIGN="absmiddle" HSPACE="3">&nbsp;<B><?=$lang['objective']?></B></TD></TR>
				<TR><TD><?=$objective?></TD></TR>

				<? if (strlen($prerequisite) > 1) {?>
				<TR><TD>&nbsp;</TD></TR>
				<TR><TD><img src="images/bl.gif" border=0 ALIGN="absmiddle" HSPACE="3">&nbsp;<B><?=$lang['prerequisite']?></B></TD></TR>
				<TR><TD><?=$prerequisite?></TD></TR>
				<? } ?>

				<? if (strlen($reference) > 1) {?>
						<TR><TD>&nbsp;</TD></TR>
						<TR><TD><img src="images/bl.gif" border=0 ALIGN="absmiddle" HSPACE="3">&nbsp;<B><?=$lang['reference']?></B></TD></TR>
						<TR><TD><?=$reference?></TD></TR>
				<? } ?>
				
				<? if (!empty($firstname) || !empty($lastname) || !empty($email) || !empty($note)) {?>
				<TR><TD>&nbsp;</TD></TR>
				<TR><TD><img src="images/bl.gif" border=0 ALIGN="absmiddle" HSPACE="3">&nbsp;<B><?=$lang['instructordetail']?></B></TD></TR>
				<TR><TD>
				<B><?=$firstname?> <?=$lastname?></B><BR>
				<?=$lang['email']?>: <A class=c HREF="mailto:<?=$email?>"><?=$email?></A>
				<BR><?=$note?></TD></TR>
				<? } ?>

				<TR><TD>&nbsp;</TD></TR>

				</TABLE>
		</TD></TR>
		<?	
		// แสดง enroll
		if ($regok && !$usersess->get_var("admin") && !checkInst($courseid)) {
			echo "<TR><TD>";
			echo "<A NAME=ENROLL></A>&nbsp;&nbsp;&nbsp;<img src=images/bl.gif> <B>$lang[schulingcourse]</B><UL TYPE=circle>".$list."</UL>";
			echo "&nbsp;&nbsp;<INPUT class=\"button\" TYPE=\"submit\" VALUE=\"$lang[button_enroll]\" onclick=\"javascript:window.open('index.php?action=enrollcourse&courseid=$courseid','_self')\">";
			echo "</TD></TR>";
		}
	?>

		</TABLE>
		<BR>
	<?
}


/**
*  Menu Tab
*/
function viewMenu($select,$code,$schedulem,$desc) {
	global $config, $lang, $usersess;

	if ($code) {
		$sql = "SELECT CID,Code,CourseName FROM $config[tablecourse] WHERE CID='$code'";
	}
	else if ($schedulem) {
		$sql = "SELECT CID,Code,CourseName FROM $config[tablecourse] c, $config[tablescheduling]  s WHERE c.CID=s.CourseID and s.SchedulingID='$schedulem'";
	}
	$result=db_select($sql);
	list($courseid,$coursecode,$coursename) = mysql_fetch_row($result);
	$coursename=stripslashes($coursename);
	$coursename=htmlspecialchars($coursename);

	echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=0>";	
	echo "<TR HEIGHT=30>";
	echo "<TD ALIGN=LEFT><font size=2 color=#669900><B>&quot;$coursecode: $coursename&quot;</B></font></TD></TR></TABLE>";

	echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=0>";	
	echo "<TR align=center>";

	if ($select == "Overview") 
		echo "<TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=70><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=viewcourse&courseid=$courseid&scheduleid=$schedulem\" class=select><B>$lang[menu_course_info]</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
	else
		echo "<TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'><TD class=tab1 width=70><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=viewcourse&courseid=$courseid&scheduleid=$schedulem\"><B>$lang[menu_course_info]</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";
	if ($select == "Lesson") 
		echo "<TD width=2></TD><TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=70><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=viewlesson&courseid=$courseid&scheduleid=$schedulem\" class=select><B>$lang[menu_course_lesson]</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
	else
		echo "<TD width=2></TD><TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=70><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=viewlesson&courseid=$courseid&scheduleid=$schedulem\" ><B>$lang[menu_course_lesson]</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";

	if ((checkauth($schedulem) || !isScheduleBased($courseid) || checkInst($courseid)) && $usersess->get_var("nickname")) {
		if ($select == "Board") 
			echo "<TD width=2></TD><TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD  class=tab2 width=80><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=showboard&courseid=$courseid&scheduleid=$schedulem\" class=select><B>$lang[menu_course_board]</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
		else
			echo "<TD width=2></TD><TD  class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=80><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=showboard&courseid=$courseid&scheduleid=$schedulem\"><B>$lang[menu_course_board]</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";
		
		if ($select == "Chat") 
			echo "<TD width=2></TD><TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=100><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=chat&courseid=$courseid&scheduleid=$schedulem\" class=select><B>$lang[menu_course_chat]</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
		else
			echo "<TD width=2></TD><TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=100><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=chat&courseid=$courseid&scheduleid=$schedulem\"><B>$lang[menu_course_chat]</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";

		if (isScheduleBased($courseid)) {
			if ($select == "Roster") 
					echo "<TD width=2></TD><TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=100><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=showroster&courseid=$courseid&scheduleid=$schedulem\" class=select><B>$lang[menu_course_roster]</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
			else
					echo "<TD width=2></TD><TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=100><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=showroster&courseid=$courseid&scheduleid=$schedulem\"><B>$lang[menu_course_roster]</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";	
		}
	}

	echo "<TD align=right>&nbsp;</TD>";
	echo "</TR></TABLE>";

	echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=5  class=form>";
	echo "<TR><TD valign=top>$desc</TD></TR></TABLE>";

}


/**
* Show Content 
*/
function viewLesson() {
	global $config,$lang,$usersess;
	global $courseid,$scheduleid,$printversion,$start;

	viewMenu("Lesson",$courseid,$scheduleid,$lang['showlesson']);

	if (empty($courseid)) {
		$courseid = db_getvar($config['tablescheduling'],"SchedulingID='$scheduleid'","CourseID");
	}

	if (checkInst($courseid)) {
		$scheduleid = db_getvar($config['tablescheduling'],"CourseID='$courseid' AND Instructor='".$usersess->get_var("nickname")."'","SchedulingID");
		$start = db_getvar($config['tablescheduling'],"CourseID='$courseid' AND Instructor='".$usersess->get_var("nickname")."'","Start");
	}
	else {
	// ตรวจสอบว่าเคยลงทะเบียนไปหรือยัง และยังไม่ผ่าน
		if ($courseid) { // ถ้าเรียกจาก เมนูบน
			$sql = "SELECT s.SchedulingID,s.Start FROM $config[tablescheduling] s,$config[tableenroll] e";
			$sql .= " WHERE s.CourseID='$courseid' and e.Nickname='".$usersess->get_var("nickname")."' and s.SchedulingID=e.SchedulingID and e.Status='0' ";
			$result=db_select($sql);
			list($scheduleid,$start) = mysql_fetch_row($result);
		}
		else if ($scheduleid){ // เรียกจากเมนูซ้าย มี schedule id
			$sql = "SELECT s.Start FROM $config[tablescheduling] s,$config[tableenroll] e";
			$sql .= " WHERE s.SchedulingID='$scheduleid' and s.SchedulingID=e.SchedulingID  and (e.Nickname='".$usersess->get_var("nickname")."'  or Instructor='".$usersess->get_var("nickname")."')  and (e.Status='0' or Instructor='".$usersess->get_var("nickname")."') LIMIT 0,1";
			$result=db_select($sql);
			list($start) = mysql_fetch_row($result);
		}
	}

// List lesson header	
	echo "<TABLE  width=98% cellpadding=3 cellspacing=1 border=0>";
	echo "<TR height=415 valign=top><TD>";	

	if ($scheduleid && !$usersess->get_var("admin")) {
			echo "<DIV align=right><B>$lang[coursestart]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></DIV>";
	}
	echo '<BR>';
	printLesson2($courseid,0,array());
	
	echo "</TD></TR>";
	echo "</TABLE>";

	echo '<BR>&nbsp;';

}


/**
* print tree
*/
function printLesson2($courseid,$parent,$orderings=array()) {
	global $config,$lang, $usersess;
	global $start,$scheduleid;
	static $cnt=0;

// List lessons	
	$sql = "SELECT LessonID,LessonTitle,Abstract,Length,LessonParentID,Ordering FROM $config[tablelesson]";
	$sql .= " WHERE CourseID='$courseid' AND LessonParentID='$parent' ORDER BY LessonParentID,Ordering";
	$result=db_select($sql);

	for($i=1;list($lessonid,$title,$abstract,$length,$parent,$ordering) = mysql_fetch_row($result);$i++) {
		$title=stripslashes($title); $title=htmlspecialchars($title);
		$abstract=stripslashes($abstract); $abstract=nl2br($abstract);
		array_push($orderings,$ordering);
		$show_item=join('.',$orderings);
		for($blank='',$j=0;$j<strlen($show_item);$j++) $blank .= '&nbsp;&nbsp;';

		if ($parent==0) {
			$cnt++;
			$color = $cnt%2 ? '#F2F2F2':'#FFFFFF';
		}
		else {
			$color = $cnt%2 ? '#F2F2F2':'#FFFFFF';
		}

		$color="#FFFFFF";
		echo "<TABLE  width=100% cellpadding=0 cellspacing=0 border=0 bgcolor=$color>";

		echo "<TR>";
		if (($scheduleid && CheckStarted($start))  || $usersess->get_var("admin") || checkInst($courseid)  || (!isScheduleBased($courseid) && $usersess->get_var("nickname"))) { 
			echo "<TD valign=top width=30 align=left>$blank<B>$show_item.</B></TD>";
			echo "<TD align=left><B><A HREF=\"index.php?action=lessonshow&scheduleid=$scheduleid&lessonid=$lessonid\" class=active>$title</B></A>";
			if ($abstract) {
				echo "<BR>$abstract<BR>&nbsp;";
			}
			echo "</TD>";
		}
		else { 
			echo "<TD valign=top width=30 align=left>$blank<B>$show_item.</B></TD>";
			echo "<TD align=left><B>$title</B></A>";
			if ($abstract) {
				echo "<BR>$abstract<BR>&nbsp;";
			}
			echo "</TD>";
		}

		// Print date to post
		if ($scheduleid && $length != 0) {
			echo "<TD width=120 valign=top align=center>";
			$thenddate=thaiDateStart($start,1);
			echo " $thenddate";
			echo "</TD>";
		}		
		echo '</TR>';

		// Print Assignment
		$asstitle = db_getvar($config['tableassignment'],"LessonID=$lessonid","Title");
		if (!empty($asstitle)&&(($scheduleid && CheckStarted($start))  || $usersess->get_var("admin") || checkInst($courseid))) {
			$asstitle = stripslashes($asstitle);
			echo "<TR>";
			echo "<TD valign=top width=30 align=left>$blank</TD>";
			echo "<TD valign=top>";
			echo "$blank $lang[assignment]: <A HREF=\"index.php?action=assignmentshow&courseid=$courseid&scheduleid=$scheduleid&lessonid=$lessonid\">$asstitle</A>";
			echo "</TD>";
			if ($scheduleid || checkInst($courseid)) {
				echo "<TD width=120 valign=top>&nbsp;</TD>";
			}
			echo "</TR>";
		}

		// Print Quiz
		$has_quiz = db_getvar($config['tablequiz'],"LessonID=$lessonid","QuizID");
		if (!empty($has_quiz)&&(($scheduleid && CheckStarted($start))  || $usersess->get_var("admin") || checkInst($courseid))) {
			$title = stripslashes($title);
			echo "<TR height=20>";
			echo "<TD valign=top width=30 align=left>$blank</TD>";
			echo "<TD valign=top>";
			echo "$blank $lang[quiz]: <A HREF=\"index.php?action=quizshow&courseid=$courseid&scheduleid=$scheduleid&lessonid=$lessonid\">$title</A>";
			echo "</TD>";
			// Print score list
			if ($scheduleid || checkInst($courseid)) {
				echo "<TD width=120 valign=top align=left>";
				$sql2 = "SELECT Score FROM $config[tablescore] ";
				$sql2.= " WHERE Nickname='".$usersess->get_var("nickname")."' and LessonID='$lessonid' and SchedulingID='$scheduleid' ORDER BY QuizDate DESC";
				$result2=db_select($sql2);
				for($passed=0,$s=1;list($score) = mysql_fetch_row($result2);$s++) {
					if ($score >= $config['highscore']) 
						$passed=1;
					echo "$lang[score]: $score %<BR>";
				}
				if ($passed) {
					echo "<img src='images/passed.gif' border=0> <font face='ms sans serif'   COLOR=#FF0000>$lang[pass]</FONT>";
				}
				echo "</TD>";
			}
			echo "</TR>";
		}
	

		echo "</TABLE>";

		// shift start date with lesson length
		$start=dateAdd($start,$length+1);

		printLesson2($courseid,$lessonid,$orderings);
		
		array_pop($orderings);

	}

}


/**
* ตรวจว่าผ่านหลักสูตร 
*/
function checkCoursePassed($courseid,$courseexist,$endcourse) {
	global $config,$usersess;

		$sql1 = "SELECT COUNT(LessonID) FROM $config[tablelesson] ";
		$sql1 .= " WHERE CourseID='$courseid'";
//		echo $sql1;
		$result1=db_select($sql1);
		list($nolesson) = mysql_fetch_row($result1);

		$sql2 = "SELECT MAX(Score) FROM $config[tablescore] ";
		$sql2 .= " WHERE Nickname='$usersess[nickname]' and SchedulingID='$courseexist' GROUP BY LessonID";
//		echo $sql2;
		$result2=db_select($sql2);
		for($passed=1,$s=0;list($score) = mysql_fetch_row($result2);$s++) {
			if ($score < $config['highscore']) {
				$passed=0;
				break;
			}
		}

		if ($s==$nolesson && $passed && CheckStarted($endcourse)) {
// auto update passed course
//			$sql = "UPDATE $config[tableenroll] SET Status='1' ";
//			$sql .= " WHERE SchedulingID='$courseexist' and Nickname='$usersess[nickname]' ";
//			update_event($usersess['nickname'],"Complete course: $courseid");
//			db_query($sql);

			return 1;
		}
		else
			return 0;
	}


/**
* Enroll Course
*/
function enrollCourse() {
	global $config,$lang,$usersess;
	global $courseid;
	global $sid,$nonick,$nomail;  // for Edit

	?>

	<TABLE WIDTH="98%" CELLPADDING=0 CELLSPACING=0>
	<TR>
	<TD>
	<?
	echo '<img src="theme/'.$config['theme'].'/title/'.$config['language'].'/enroll.jpg" border=0><BR>';
	
	if (!$usersess->get_var("nickname")) {
		echo $lang['registerbefore'];
	}
	else {
		$sql = "SELECT s.SchedulingID, s.Start,sum(l.Length),s.Instructor,c.CourseName FROM $config[tablecourse] c, $config[tablescheduling] s, $config[tablelesson] l ";
		$sql.=" WHERE l.CourseID=s.CourseID and c.CID=s.CourseID ";
		$sql.=" and s.CourseID='$courseid' and s.Start > Curdate() Group by s.CourseID,s.Start ORDER BY s.CourseID, s.Start";
		$result=db_select($sql);
		$rows = @mysql_num_rows($result);
		list($schdid,$start,$length,$instructor,$coursename) = mysql_fetch_row($result);

		echo "<BR><FONT SIZE=2 COLOR=#669900><B>&quot;$coursename&quot;</B></FONT><BR><BR>";
		
		if ($rows) {
		?>
	  <script language="javaScript">
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.Confirmenroll.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
    	function checkFields() {
			var sid = document.forms.Confirmenroll.sid.value;
			if (sid  == "" ) {
				alert("<?=$lang['alertschd']?>");
				document.forms.Confirmenroll.sid.focus();
				return false;
			}
			return true;
		}
		</script>
		<?
		echo "<FORM NAME=\"Confirmenroll\" METHOD=POST ACTION=\"index.php\" onSubmit=\"return formSubmit('enrollsave');\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"action\">";
		echo $lang['enrollok1'];
		echo '<BR>&nbsp;<TABLE WIDTH="615"   BORDER="0" CELLSPACING="0" CELLPADDING="0">'
		.'<TR HEIGHT="18">'
		.'<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">'
		.'<IMG SRC="images/bul.gif" BORDER="0" ALT="" align=absmiddle> <B>'.$lang['coursedate'].'</B>' 
		.'</TD></TR>'		
		.'</TABLE>';

		echo $lang['enrollok2'];	

		echo "<BR>&nbsp;<TABLE width =400>";
		echo "<TR><TD><B>$lang[enroll]</B></TD><TD><B>$lang[startend]</B></TD><TD><B>$lang[instructor]</B></TD></TR>";


		$result=db_select($sql);
		for($i=1;list($schedid,$start,$length,$instructor,$coursename) = mysql_fetch_row($result);$i++) {
				$enddate=dateAdd($start,$length);
				$thstartdate=C2TH($start,0);
				$thenddate=C2TH($enddate,1);
				if ($sid) {
					$schedcheck = ($schedid == $sid) ? "checked" : "";
				}
				else {
					$schedcheck= ($i==1) ? "checked" : "";
				}
				echo "<TR><TD><INPUT TYPE='radio' NAME='sid' value=\"$schedid\" $schedcheck></TD>";
				echo "<TD>$thstartdate - $thenddate</TD><TD>$instructor</TD></TR>";
		}
		echo '</TABLE>';

		echo '<BR>&nbsp;<TABLE WIDTH="615"   BORDER="0" CELLSPACING="0" CELLPADDING="0">'
		.'<TR HEIGHT="18">'
		.'<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">'
		.'<IMG SRC="images/bul.gif" BORDER="0" ALT="" align=absmiddle> <B>'.$lang['nameinroster'].'</B>' 
		.'</TD></TR>'		
		.'</TABLE>';

		echo "$lang[enrollok3]";
		if (isset($nonick))
			$nonickcheck = ($nonick==1) ? "checked" : "";
		else 
			$nonickcheck = "checked";
		echo "<P><INPUT TYPE=\"checkbox\" NAME=\"nonick\"  value=\"1\" $nonickcheck> $lang[displaynickname]";

		echo '<BR>&nbsp;<TABLE WIDTH="615"   BORDER="0" CELLSPACING="0" CELLPADDING="0">'
		.'<TR HEIGHT="18">'
		.'<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">'
		.'<IMG SRC="images/bul.gif" BORDER="0" ALT="" align=absmiddle> <B>'.$lang['notifyme'].'</B>' 
		.'</TD></TR>'		
		.'</TABLE>';

		echo "$lang[enrollok4]";

		if (isset($nomail))
			$nomailcheck = ($nomail==2) ? "checked" : "";
		else 
			$nomailcheck = "checked";
		echo "<P><INPUT TYPE=\"checkbox\" NAME=\"nomail\" value=\"2\" $nomailcheck> $lang[viaemail]<P>";
		
		echo "<HR size=1 noshade>";
?>
		
		<INPUT class="button" TYPE="submit" VALUE=" <?=$lang['button_ok']?> ">
		</FORM>
<?
	}
	else {
			echo "$lang[coursenotschd]";
	}
}
	
	?>
	</TD>
	</TR>
	</TABLE>
	<?
}

/**
* Insert enroll
*/
function enrollSave() {
	global $config,$lang,$usersess;
	global $sid,$nonick,$nomail,$courseid;
	global $scheduleid;

	$scheduleid=$sid;
	
	$dupnickname = db_getvar($config['tableenroll'],"Nickname='".$usersess->get_var("nickname")."' and SchedulingID='$sid' ","Nickname");
	$to = db_getvar($config['tableuser'],"Nickname='".$usersess->get_var("nickname")."' ","Email");
	if (!$dupnickname) {
		$options=$nonick+$nomail;
		$sql = "INSERT INTO $config[tableenroll] (SchedulingID, Nickname, Options, Status) ";
		$sql .= "VALUES ('$sid','".$usersess->get_var("nickname")."','$options','$config[status_study]')";
		update_event($usersess->get_var("nickname"),"Enroll course: $coursenamesave");
		db_query($sql);

		// find coursename and start-stop date
		$sql = "SELECT s.Start,sum(l.Length),s.Instructor,c.CourseName FROM $config[tablecourse] c, $config[tablescheduling] s, $config[tablelesson] l ";
		$sql.=" WHERE l.CourseID=s.CourseID and c.CID=s.CourseID ";
		$sql.=" and s.SchedulingID='$sid' Group by s.CourseID,s.Start ORDER BY s.CourseID, s.Start";
		$result=db_select($sql);
		if ($result) {
			list($start,$length,$instructor,$coursename) = mysql_fetch_row($result);
			$enddate=dateAdd($start,$length);
			$thstartdate=C2TH($start,0);
			$thenddate=C2TH($enddate,1);
			$startend=$thstartdate." - ".$thenddate;
			
			// Create folder see: folder.inc.php
			folderNewSave($coursename,0,0,0);
			
			//Mail to student
			if ($to) {		
				$from=$config['adminmail'];
				$subject=$lang['enrollsubject'] . $coursename;
				$msg="<font face='ms sans serif' size=2><B>$lang[course] ".$coursename." $lang[coursestart] ".$startend." </B></font><P>\r\n";
				$msg.=$lang['enrollmail'];
				 mailsock($from,$to,'',$subject,$msg);
			}
		}
		viewLesson();
	}
	else {
		echo '&nbsp;<BR><BR><CENTER><B>Abnormal Operation@@</B></CENTER>';
	}
}


/**
* Student Report
*/
function courseList() {
	global $config,$lang,$usersess;

	if (!$usersess->get_var("nickname")) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}
	
	echo '<DIV ALIGN=LEFT>&nbsp;&nbsp;<img src=theme/'.$config['theme'].'/title/'.$config['language'].'/report.jpg border=0></DIV>';

	?>
	<TABLE WIDTH="98%" CELLPADDING=0 CELLSPACING=0>
	<TR height="1"><TD valign="middle" align="center" background="images/line2.gif"></TD></TR>
	<TR>
	<TD>

	<?

	echo $lang['courselist'];

// แสดงหลักสูตรที่กำลังเรียน

	$sql = "select c.Code, c.CourseName, s.SchedulingID, s.Start,sum(l.Length),s.Instructor FROM $config[tablecourse] c,$config[tablescheduling] s, $config[tablelesson] l, $config[tableenroll] e";
	$sql .=" WHERE c.CID=s.CourseID and l.CourseID=s.CourseID and e.SchedulingID=s.SchedulingID";
	$sql .= " and e.Nickname='".$usersess->get_var("nickname")."' and e.Status='0' AND c.CourseType='0'";
	$sql .= " Group BY s.CourseID,s.Start ORDER BY s.CourseID, s.Start";
	$result=db_select($sql);
	$row=@mysql_num_rows($result);
	if ($row) {
		echo "<BR>&nbsp;<TABLE width=100% cellpadding=2 cellspacing=0 border=0><TR height=18><TD class=head2>&nbsp;<B>$lang[currentcourse]</B></TD><TD align=center class=head2><B>$lang[startend]</B></TD><TD align=center class=head2>&nbsp;</TD></TR>";
		for($i=1;list($courseid,$coursename,$schdid,$start,$length,$instructor) = mysql_fetch_row($result);$i++) {
			$duration=thaiDateDuration($start,$length);
			echo '<TR valign=top>';
			echo "<TD>$i. <A HREF=\"index.php?action=viewcourse&scheduleid=$schdid\">$coursename</A></TD>";
			echo "<TD align=center  width=120>$duration</TD>";
			echo "<TD align=right  width=150>";
			echo "<INPUT class=button TYPE=\"button\" VALUE=\"$lang[lesson]\" Onclick=\"javascript:window.open('index.php?action=viewlesson&scheduleid=$schdid','_self')\"> ";
			echo "<INPUT class=button TYPE=\"button\" VALUE=\"$lang[button_edit]\" Onclick=\"javascript:window.open('index.php?action=coursechange&scheduleid=$schdid','_self')\">";
			echo '</TD></TR>';
		}
		echo "</TABLE>";
		echo "<P>";
	}

// หลักสูตรที่สำเร็จแล้ว
	$sql = "SELECT c.Code, c.CourseName, s.SchedulingID, s.Start,sum(l.Length),s.Instructor,u.ID";
	$sql .= " FROM $config[tablecourse] c,$config[tablescheduling] s, $config[tablelesson] l, $config[tableenroll] e, $config[tableuser] u";
	$sql .= " WHERE c.CID=s.CourseID and l.CourseID=s.CourseID and e.SchedulingID=s.SchedulingID and u.Nickname=e.Nickname";
	$sql .= " and e.Nickname='".$usersess->get_var("nickname")."' and e.Status='1'";
	$sql .= " Group BY s.CourseID,s.Start ORDER BY s.CourseID, s.Start";
	$result=db_select($sql);
	$row=@mysql_num_rows($result);
	if ($row) {
		echo "<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><TR height=18><TD class=head2>&nbsp;<B>$lang[completecourse]</B></TD><TD align=right width=200 class=head2><B>$lang[startend]&nbsp;</B></TD></TR>";
		for($i=1;list($courseid,$coursename,$schdid,$start,$length,$instructor,$empn) = mysql_fetch_row($result);$i++) {
			$date=thaiDateDuration($start,$length);
			echo "<TR valign=bottom><TD><A HREF=\"javascript:popup('index.php?action=showcer&user=".$usersess->get_var("nickname")."&scheduleid=$schdid','_blank',700,650)\">$i. $coursename&nbsp;<IMG SRC='images/cer.gif' border=0 vspace=0></A></TD><TD align=right>$date&nbsp;</TD></TR>";
		}
		echo "</TABLE>";
		echo "<P>";
	}

// หลักสูตรที่ยังไม่ผ่าน
	$sql = "select c.CID, c.CourseName, s.SchedulingID, s.Start,sum(l.Length),s.Instructor FROM $config[tablecourse] c,$config[tablescheduling] s, $config[tablelesson] l, $config[tableenroll] e";
	$sql .=" WHERE c.CID=s.CourseID and l.CourseID=s.CourseID and e.SchedulingID=s.SchedulingID";
	$sql .= " and e.Nickname='".$usersess->get_var("nickname")."' and e.Status='2'";
	$sql .= " Group BY s.CourseID,s.Start ORDER BY s.CourseID, s.Start";
	$result=db_select($sql);
	$row=@mysql_num_rows($result);
	if ($row) {
		echo "<TABLE cellpadding=2 cellspacing=0 width=100% border=0><TR height=18><TD width=200 class=head2>&nbsp;<B>$lang[dropcourse]</B></TD><TD align=right class=head2><B>$lang[startend]</B>&nbsp;</TD></TR>";
		for($i=1;list($courseid,$coursename,$schdid,$start,$length,$instructor) = mysql_fetch_row($result);$i++) {
			$duration=thaiDateDuration($start,$length);
			echo "<TR valign=top><TD>$i. <A HREF=\"index.php?action=viewcourse&select=Lesson&courseid=$courseid\">$coursename</A></TD><TD align=right>$duration</TD></TR>";
		}
	echo "</TABLE>";
	}

?>
	</TD>
	</TR>
	</TABLE>
<?
}


/**
* ตั้งค่าหลักสูตร
*/
function courseChange() {
	global $config,$lang,$usersess;
	global $scheduleid;

	if (!$usersess->get_var("nickname")) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}
	
	echo '<DIV ALIGN=LEFT>&nbsp;&nbsp;<img src=theme/'.$config['theme'].'/title/'.$config['language'].'/report.jpg border=0><BR>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$lang['coursesetting'].'<BR>&nbsp;</DIV>';	
	

	$sql = "select e.Options,e.Status,c.CourseName FROM $config[tableenroll] e, $config[tablecourse] c, $config[tablescheduling] s" ;
	$sql .=" WHERE c.CID=s.CourseID and s.SchedulingID=e.SchedulingID and e.SchedulingID='$scheduleid' and e.Nickname='".$usersess->get_var("nickname")."' ";
	$result=db_select($sql);
	list($options,$status,$coursename) = mysql_fetch_row($result);
	
	
	echo "<FORM NAME=\"Confirmenroll\" METHOD=POST ACTION=\"index.php\">";
	echo "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"coursechangesubmit\">";
	echo "<INPUT TYPE=\"hidden\" NAME=\"sid\" VALUE=\"$scheduleid\">";

	echo '<TABLE WIDTH="615"   BORDER="0" CELLSPACING="0" CELLPADDING="0">'
		.'<TR HEIGHT="18">'
		.'<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">'
		.'<IMG SRC="images/bul.gif" BORDER="0" ALT="" align=absmiddle> <B>'.$lang['enrolloption'].'</B></TD></TR>';

	echo '<TR><TD>'.$lang['enrolloption1'];	
		
	$dcheck = ($status == 2) ? "checked":"";  // drop course
	echo "<P><INPUT TYPE=\"checkbox\" NAME=\"drop\"  value=\"2\" $dcheck > $lang[dropcourseans]<BR>&nbsp;</TD></TR>";
	
	echo '<TR HEIGHT="18">'
		.'<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">'
		.'<IMG SRC="images/bul.gif" BORDER="0" ALT="" align=absmiddle> <B>'.$lang['nameinroster'].'</B></TD></TR>';
	
	echo '<TR><TD>'.$lang['enrollok3'];

	$ncheck = ($options & 1) ? "checked" : "";  // แสดงชื่อเล่นในห้อง
	echo "<P><INPUT TYPE=\"checkbox\" NAME=\"nonick\"  value=\"1\" $ncheck> $lang[displaynickname]<BR>&nbsp;</TD></TR>";

	echo '<TR HEIGHT="18">'
		.'<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">'
		.'<IMG SRC="images/bul.gif" BORDER="0" ALT="" align=absmiddle> <B>'.$lang['notifyme'].'</B></TD></TR>';
	
	$ncheck = ($options & 2) ? "checked" : "";  //รับข้อมูลข่าวสารหรือประกาศเพิ่มเติมจากผู้สอน
	echo "<TR><TD>$lang[enrollok4]";
	echo "<P><INPUT TYPE=\"checkbox\" NAME=\"nomail\" value=\"2\" $ncheck> $lang[notifyme] $lang[viaemail]<BR><BR>&nbsp;</TD></TR>";

	echo "<TR><TD><INPUT class=button TYPE=\"submit\" value=\"  $lang[button_ok]  \"></FORM></TD></TR>";
	
	echo '</TABLE>';

}


/**
* แก้ไขค่าหลักสูตร
 */
function courseChangeSubmit() {
	global $config,$lang,$usersess;
	global $sid,$drop,$nonick,$nomail;

	if (!$usersess->get_var("nickname")) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}

	$options=$nonick+$nomail;
	if (!$drop) $drop=0;
	if (!$options) $options=0;

	$sql = "UPDATE $config[tableenroll] SET  Options='$options', Status='$drop' ";
	$sql .= " WHERE SchedulingID='$sid' and Nickname='".$usersess->get_var("nickname")."' ";
	update_event($usersess->get_var("nickname"),"Modify course settings: $coursename option=$options");
	db_query($sql);
	courseList();
}
?>