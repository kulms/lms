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
* Create Course
*/
function course() {
	global $lang, $config,$usersess;
	
	if (!($usersess->get_var("admin") || $usersess->get_var("instructor"))) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}
	?>
    <script language="javaScript">
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.Course.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
    	function checkFields() {
			var school = document.forms.Course.school.value;
			var code = document.forms.Course.coursecode.value;
			var course_name = document.forms.Course.cname.value;
		
			if (school  == "" ) {
				alert("<?=$lang['alertcode']?>");
				document.forms.Course.school.focus();
				return false;
			}
			if (code  == "" ) {
				alert("<?=$lang['alertcode']?>");
				document.forms.Course.coursecode.focus();
				return false;
			}
			if (code.length != <?=$config['course_code_limit']?> ) {
				alert("<?=$lang['alertcodelimit']?>");
				document.forms.Course.coursecode.focus();
				return false;
			}
			if (course_name  == "" ) {
				alert("<?=$lang['alertname']?>");
				document.forms.Course.cname.focus();
				return false;
			}
			return true;
		}
	</script>	
<?
	echo '<DIV ALIGN="LEFT"><IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/course_admin.jpg" BORDER=0></DIV><BR>';

	echo "<FORM NAME=\"Course\" METHOD=POST ACTION=\"index.php\" Onsubmit=\"return formSubmit('addcourse')\">";
	echo "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"addcourse\">";
	echo "<TABLE WIDTH=98% CELLSPACING=1 CELLPADDING=0 class=form>";
	echo "<TR valign=middle HEIGHT=18><TD class=head> <B>&nbsp;$lang[addcourse]</B></TD></TR>";
	echo "<TR><TD>";
	echo "<TABLE WIDTH=100% CELLSPACING=0 CELLPADDING=3 BORDER=0>";
	echo "<TR><TD ALIGN=RIGHT>$lang[school]:</TD><TD>";
	echo "<SELECT NAME=\"school\" onchange=\"document.forms.Course.coursecode.value=document.forms.Course.school.options[this.selectedIndex].value;\">";
	echo "<OPTION VALUE=\"\">$lang[select_school]</OPTION>";

	$sql = "SELECT * FROM $config[tableschool]  ORDER BY School_codename";
	$result=db_select($sql);
	for ($i=0;list($schoolcode,$schoolcodename,$schoolname,$schooldesc,$schoolimage) = mysql_fetch_row($result);$i++) {
		echo "<OPTION VALUE=".$schoolcodename."> $schoolname </OPTION>";
	}
	echo "</SELECT></TD></TR>";
	echo "<TR><TD ALIGN=RIGHT>$lang[coursecode]:</TD>";
	echo "<TD><INPUT TYPE=\"text\" NAME=\"coursecode\" size=10 VALUE=\"\"></TD></TR>";
	echo "<TR><TD ALIGN=RIGHT>$lang[coursename]:</TD><TD><INPUT TYPE=\"text\" NAME=\"cname\" size=50></TD></TR>";
	echo "<TR><TD></TD><TD><INPUT  class=button TYPE=\"submit\" VALUE=\"$lang[button_addcourse]\"></TD></TR>";
	echo "</TABLE><BR>";
	echo "</TD></TR></TABLE>";
	echo "</FORM><BR>";

	// Browse all courses ====>>>>>>
//	echo $lang['browsecourse'];

	$sql = "SELECT School_name, CID,Code, CourseName, Creator";
	$sql.= " FROM $config[tablecourse] c,$config[tableschool] sc ";
	$sql.= " WHERE sc.School_code = c.School";
	if (!$usersess->get_var('admin')) {
		$sql .= " AND Creator='".$usersess->get_var('nickname')."' ";
	}
	$sql.= " ORDER BY School,Code";
	$result=db_select($sql);

	echo "<TABLE WIDTH=98% CELLSPACING=1 CELLPADDING=2 BORDER=0>";

	for ($i=0;list($school,$cid,$code,$coursename,$creator) = mysql_fetch_row($result);$i++) {
		$coursename=stripslashes($coursename);
		$coursename=htmlspecialchars($coursename);
		if ($schoool != $school) {
			$schoool=$school;
			echo "<TR height=20><TD colspan=\"4\" width=\"100%\" class=\"head2\" valign=\"middle\" align=\"left\"> &nbsp;<B>$school</B></TD></TR>";
		}
		$sql = "SELECT count(*)";
		$sql.= " FROM $config[tablescheduling] s, $config[tableenroll] e ";
		$sql.= " WHERE e.SchedulingID=s.SchedulingID and s.CourseID='$code' and e.Status=1";
		$result1=db_select($sql);
		list($sum) = mysql_fetch_row($result1);
		if ($sum==0) $sum="-";

		echo "<TR>";
		echo "<TD width=\"10%\" valign=\"middle\" align=\"center\">$code</TD>";
		echo "<TD> <A HREF=\"index.php?action=editcourse&courseid=$cid\">$coursename</A></TD><TD align=center WIDTH=5>$sum</TD>";
		echo "<TD valign=\"middle\" align=\"right\">";
		echo "<INPUT TYPE=\"button\" class=button value=\"$lang[button_edit]\" onclick=\"window.open('index.php?action=editcourse&courseid=$cid','_self')\"> ";
		echo "<INPUT TYPE=\"button\" class=button value=\"$lang[button_delete]\"  onclick=\"if(confirm('Delete course $code?\\nWARNING: you will lose all data in course $code ')) window.open('index.php?action=deletecourse&courseid=$cid','_self')\"></TD></TR>";
	}

	echo "</TABLE><P>";

}


/**
* Insert Course
*/
function addCourse() { 
	global $config,$usersess;
	global $school, $coursecode, $cname;
	
	$creator = $usersess->get_var('nickname');
	$createon=date('Y-m-d H:i');

	$schoolid = 	db_getvar($config['tableschool'],"School_codename='$school'","School_code");
	$courseid = db_getvar($config['tablecourse'],"1","MAX(CID)")+1;

	$sql = "INSERT INTO $config[tablecourse] (CID,Code, School, CourseName,Creator,CreateOn) ";
	$sql .= "VALUES ('$courseid','$coursecode','$schoolid','$cname','$creator','$createon')";

	$ret = db_query($sql);
	if (empty($ret)) {
		echo "<BR><BR><B><FONT COLOR=#FF0000>Error: Cannot Create &quot;$courseid $coursename&quot;</FONT></B><BR><BR>&lt;&lt;<A HREF='index.php?action=course'>Back</A>";
		return;
	}
	
	update_event($usersess->get_var("nickname"),"Add course $courseid:$coursename to $schoolid");
	@mkdir("$config[coursedir]/$courseid",0777);
	@mkdir("$config[coursedir]/$courseid/images",0777);


	course();
}


/**
*	Delete Course
*/
function deleteCourse() { 
	global $config,$usersess;
	global $courseid;

	// delete course table
	$sql = "DELETE FROM $config[tablecourse] WHERE CID='$courseid'";
	db_query($sql);

	// delete assignment and quiz table
	$sql = "SELECT LessonID FROM $config[tablelesson]  WHERE CourseID='$courseid'";
	$result=db_select($sql);
	for ($i=0;list($lesson_id) = mysql_fetch_row($result);$i++) {
		$sql1 = "DELETE FROM $config[tableassignment] WHERE LessonID='$lesson_id'";
		db_query($sql1);

		$sql2 = "DELETE FROM $config[tablequiz] WHERE LessonID='$lesson_id'";
		db_query($sql2);
	}
	
	// delete lesson table
	$sql = "DELETE FROM $config[tablelesson] WHERE CourseID='$courseid'";
	db_query($sql);

	// remove all constrian tables and subdirectory
	clr_dir($config['coursedir'].'/'.$courseid);

	update_event($usersess->get_var("nickname"),"Delete course $courseid");
	course();
}

/*
* delete dir
*/
function clr_dir($dir) {
	if(!$opendir = @opendir($dir)) {
		return false;
	}
	
	while(($readdir=readdir($opendir)) !== false) {
		if (($readdir !== '..') && ($readdir !== '.')) {
			$readdir = trim($readdir);

			clearstatcache(); /* especially needed for Windows machines: */

			if (is_file($dir.'/'.$readdir)) {
				if(!@unlink($dir.'/'.$readdir)) {
					return false;
				}
			} else if (is_dir($dir.'/'.$readdir)) {
				/* calls itself to clear subdirectories */
				if(!clr_dir($dir.'/'.$readdir)) {
					return false;
				}
			}
		}
	} /* end while */

	closedir($opendir);
	
	if(!@rmdir($dir)) {
		return false;
	}
	return true;
}


/**
* Edit Course
*/
function editCourse() { 
	global $select,$courseid;
	
	courseMenu("Overview",$courseid);	
	overviewCourseForm($courseid);  //+ see: forms.inc.php
}


/**
* Course Menu
*/
function courseMenu($select,$code) {
	global $config, $lang;

	echo '<DIV ALIGN="LEFT"><A HREF="index.php?action=course"><IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/course_admin.jpg" BORDER=0></A></DIV><BR>';

	echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=0 BORDER=0><TR align=center>";

	if ($select == "Overview") 
		echo "<TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=70><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A class=select HREF=\"index.php?action=editcourse&courseid=$code\"><B>".$lang['menu_course_info']."</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
	else
		echo "<TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=70><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=editcourse&courseid=$code\"><B>".$lang['menu_course_info']."</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";

	if ($select == "Lesson") 
		echo "<TD width=2></TD><TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=70><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=editlesson&courseid=$code\" class=select><B>".$lang['menu_course_lesson']."</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
	else
		echo "<TD width=2></TD><TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=70><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=editlesson&courseid=$code\"><B>".$lang['menu_course_lesson']."</B></A></TD><TD  class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";

	if ($select == "Directory") 
		echo "<TD width=2></TD><TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=70><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=fileman&courseid=$code\"  class=select><B>".$lang['menu_course_upload']."</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
	else
		echo "<TD width=2></TD><TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=70><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=fileman&courseid=$code\"><B>".$lang['menu_course_upload']."</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";

	if ($select == "Package") 
		echo "<TD width=2></TD><TD class=tab2 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab2 width=100><IMG SRC=\"images/tab_arrow_down.gif\">&nbsp;<A HREF=\"index.php?action=package&courseid=$code\" class=select><B>".$lang['menu_course_import_export']."</B></A></TD><TD class=tab2 width=8><IMG SRC='images/tabbit.gif'></TD>";
	else
		echo "<TD width=2></TD><TD class=tab1 width=8><IMG SRC='images/tabbit_left.gif'></TD><TD class=tab1 width=100><IMG SRC=\"images/arrow.gif\">&nbsp;<A HREF=\"index.php?action=package&courseid=$code\"><B>".$lang['menu_course_import_export']."</B></A></TD><TD class=tab1 width=8><IMG SRC='images/tabbit.gif'></TD>";

	echo "<TD align=right>&nbsp;</TD>";

	echo "</TR></TABLE>";
}


/**
* Submit course overview
*/
function submitCourse() {
	global $config,$usersess;
	global $schoolid,$schoolcode,$coursecode,$cname;
	global $courseid,$creator,$manday,$description,$objective,$prerequisite,$reference,$enable,$course_type;
	
	$coursecode=addslashes($coursecode);
	$cname=addslashes($cname);
	$description=addslashes($description);
	$objective=addslashes($objective);
	$prerequisite=addslashes($prerequisite);
	$reference=addslashes($reference);

	if (!isset($course_type)) $course_type=0;

	$schoolid = 	db_getvar($config['tableschool'],"School_codename='$schoolid'","School_code");

	$sql = "UPDATE $config[tablecourse] SET Code='$coursecode', School='$schoolid', CourseName='$cname', Creator='$creator', CourseType='$course_type' ";
	$sql .= " , Description='$description', Objective='$objective', Prerequisite='$prerequisite', Manday='$manday', Reference='$reference', Enable='$enable' ";
	$sql .= " WHERE CID='$courseid' ";

	db_query($sql);
	
	// add schedule for variety course
	$id = 	db_getvar($config['tablescheduling'],"CourseID=$courseid","SchedulingID");
	if ($course_type==1) {
		if (empty($id)) {
			$maxid = 	db_getvar($config['tablescheduling'],"1","MAX(SchedulingID)+1");
			$sql = "INSERT INTO $config[tablescheduling] (SchedulingID,CourseID,Start,Instructor) ";
			$sql .= " VALUES ('$maxid','$courseid','0000-00-00','$creator')";
			db_query($sql);
		}
	}
	else {
		$sql = "DELETE FROM $config[tablescheduling] WHERE SchedulingID='$id' AND Start='0000-00-00'";
		db_query($sql);
	}
	
	
	update_event($usersess->get_var("nickname"),"Edit  course overview $courseid: $cname");

	editCourse();
}


/**
* Add Lesson
*/
function submitLesson() {
	global $config,$usersess;
	global $courseid,$lessonid,$title,$abstract,$length,$lessonfile,$lessonno;

	$lessonnos=array();
	$lessonnos=explode('.',$lessonno);
	$ordering=$lessonnos[count($lessonnos)-1];
	
	
	if (count($lessonnos) == 1) {
		$parent = 0;
	}
	else {
		$parent=getParent($courseid,$lessonnos);
	}
	
	$title=addslashes($title);
	$abstract=addslashes($abstract);
	if (empty($lessonid)) {
		$lessonid = db_getvar($config['tablelesson'],"1","MAX(LessonID)")+1;
		$sql = "INSERT INTO $config[tablelesson] (LessonID,CourseID, LessonTitle, Abstract, Length,LessonFile,LessonParentID,Ordering) ";
		$sql .= "VALUES ('$lessonid','$courseid','$title','$abstract','$length','$lessonfile','$parent','$ordering')";
		update_event($usersess->get_var("nickname"),"Add lesson  $title to $courseid:");
	}
	else {
		$sql = "UPDATE $config[tablelesson] SET LessonTitle='$title', Abstract='$abstract', Length='$length', LessonFile='$lessonfile', LessonParentID='$parent', Ordering='$ordering' ";
		$sql .= "WHERE LessonID='$lessonid'";
		update_event($usersess->get_var("nickname"),"Update lesson  $lessonid of $courseid: $title");
	}
	
	db_query($sql);
	courseMenu("Lesson",$courseid);	
	lessonCourseForm($courseid,null);
}


function getParent($courseid, $lessons) {
		global $config,$usersess;

		for ($parent=0,$i=0; $i<count($lessons)-1;$i++) {
			$parent = db_getvar($config['tablelesson'],"CourseID=$courseid AND LessonParentID='$parent' AND Ordering=$lessons[$i]","LessonID");
		}
		
		return $parent;
}

/**
* Edit Lesson
*/
function editLesson() { 
	global $config,$usersess;
	global $courseid, $lessonid;

	courseMenu("Lesson",$courseid);	
	lessonCourseForm($courseid,$lessonid); //+ see: forms.inc.php
}


/**
* Delete Lesson
*/
function deleteLesson() { 
	global $config,$usersess;
	global $courseid, $lessonid;

	deleteLessonLoop($courseid,$lessonid);
//	$lessonfile = db_getvar($config['tablelesson'],"LessonID='$lessonid'","LessonFile");
//	$sql = "DELETE FROM $config[tablelesson] WHERE CourseID='$courseid' and LessonID='$lessonid' ";
//	db_query($sql);
	
//	if (file_exists("$config[coursedir]/$courseid/$lessonfile")) { // remove lesson file
//		@unlink("$config[coursedir]/$courseid/$lessonfile");	
//	}

	update_event($usersess->get_var("nickname"),"Delete lesson #$lessonid from $courseid: ");
	courseMenu("Lesson",$courseid);	
	lessonCourseForm($courseid,null);
}


function deleteLessonLoop($cid,$lid) {
	global $config;

	$sql = "SELECT LessonID,LessonFile FROM $config[tablelesson] WHERE CourseID='$cid' AND LessonParentID='$lid'";
	$result=db_select($sql);

	while (list($child_lid) = mysql_fetch_row($result)) {
		deleteLessonLoop($cid,$child_lid);
	}
	$sql = "DELETE FROM $config[tablelesson]  WHERE LessonID='$lid'";	
//	echo "$sql<BR>";
	db_query($sql);
}


/**
* Quiz 
*/
function quiz() {
	global $config,$lang,$usersess;
	global $lessonid,$quizid;

	$courseid = db_getvar($config['tablelesson'],"LessonID='$lessonid'","CourseID");
	$lessontitle = db_getvar($config['tablelesson'],"LessonID='$lessonid'","LessonTitle");
	$coursecode = db_getvar($config['tablecourse'],"CID='$courseid'","Code");
	$coursename = db_getvar($config['tablecourse'],"CID='$courseid'","CourseName");
	$quiztitle = db_getvar($config['tablelesson'],"LessonID='$lessonid'","QuizTitle");
	$quiztitle = stripslashes($quiztitle);
	if (empty($quiztitle)) {
		$quiztitle=$lang['quiztitle_default'];
	}
	if ($quizid) {
		$sql = "SELECT * FROM $config[tablequiz] where QuizID='$quizid'";
		$result=db_select($sql);
		$data = mysql_fetch_row($result);
	}
?>
<HTML>
<HEAD>
<TITLE><?=$coursecode?>:<?=$coursename?> </TITLE>
<LINK REL="STYLESHEET" HREF="theme/<?=$config['theme']?>/style/default.css" type="text/css">
<script language="javaScript">
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.quiz.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
    	function checkFields() {
			var title = document.forms.quiz.quiztitle.value;
			var question = document.forms.quiz.question.value;
		
			if (title  == "" ) {
				alert("<?=$lang['alertquiztitle']?>");
				document.forms.quiz.quiztitle.focus();
				return false;
			}
			if (question  == "" ) {
				alert("<?=$lang['alertquizquestion']?>");
				document.forms.quiz.question.focus();
				return false;
			}
			return true;
		}
</script>	
<BODY BGCOLOR="#FFFFFF">
<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=0 class=form align=center>
<TR><TD>

<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=3>
<FORM  METHOD=POST NAME="quiz" ACTION="index.php" Onsubmit="return formSubmit('addquiz')">
<INPUT TYPE="hidden" NAME="action">
<INPUT TYPE="hidden" NAME="lessonid" VALUE="<?=$lessonid?>">
<INPUT TYPE="hidden" NAME="quizid" VALUE="<?=$quizid?>">
<TR valign=middle HEIGHT=18><TD class=head valign="middle" align="left" colspan=2> <B>&nbsp;<?=$lang['quiz']?> : <?=$lessontitle?></B></TD></TR>

<TR  HEIGHT=18 VALIGN="MIDDLE">
	<TD ALIGN="RIGHT" WIDTH="10%" VALIGN=TOP><B><?=$lang['quiztitle']?>:</TD>
	<TD><TEXTAREA NAME="quiztitle" ROWS="4" COLS="80" wrap="soft" style="width: 90%;"><?=$quiztitle?></TEXTAREA><BR>
	</TD></TR>
</TR>
<TR>

<TR HEIGHT=1 BGCOLOR=#E1E1FF><TD COLSPAN=2></TD></TR>


<TR  HEIGHT=18 VALIGN="MIDDLE">
	<TD ALIGN="RIGHT" WIDTH=10% VALIGN=TOP><B><?=$lang['question']?>:</TD>
	<TD>
	<TEXTAREA NAME="question" ROWS="4" COLS="80" wrap="soft" style="width: 90%;"><? echo stripslashes($data[2]); ?></TEXTAREA></TD></TR>
</TR>

<TR>
	<TD VALIGN=TOP ALIGN=RIGHT><B><?=$lang['answer']?>:</B></TD>
	<TD>
			<TABLE CELLPADDING=0 CELLSPACING=0>
			<TR ALIGN=CENTER>
			<TD><?=$lang['choice_right']?></TD><TD>&nbsp;</TD><TD><?=$lang['choices']?></TD><TD><?=$lang['choice_desc']?></TD></TR>
<?

	for($j=4;$j<=$config['choice']*2;$j++) {
			if ($j%2 == 0) {
				$check =  ($data[3] & pow(2,(($j/2)-1)-1)) ? "checked" :"";
				$showans=stripslashes($data[$j]); 
				$showdesc=stripslashes($data[$j+1]); 
				$i=$j/2-1;
				echo "<TR>";
				echo "<TD ALIGN=RIGHT>";
				echo "<INPUT TYPE=checkbox NAME=answer[$i] value=".pow(2,($i-1))." $check> ";
				echo "<TD><B>".$lang['choice'][$i].".</B></TD> ";
				echo "<TD><INPUT TYPE=text NAME=choice[$i] value=\"$showans\" size=40></TD>";
				echo "<TD>&nbsp;<INPUT TYPE=text NAME=choicedesc[$i] value=\"$showdesc\" size=27></TD>";
				echo "</TR>";
			}
	}

?>	
				</TABLE>

</TD>
</TR>


<TR VALIGN="TOP">
	<TD>&nbsp;</TD>
	<TD><BR>&nbsp;
	<? if ($quizid) {?>
		<INPUT class="button" TYPE="submit" VALUE="<?=$lang['button_editquiz']?>">
	<? } else { ?>
		<INPUT class="button" TYPE="submit" VALUE="<?=$lang['button_addquiz']?>">
	<? } ?>
		<INPUT class="button" TYPE="button" VALUE="<?=$lang['button_cancel']?>" onclick="javascript:window.open('index.php?action=quiz&lessonid=<?=$lessonid?>','_self')">
		<BR>&nbsp;
	</TD>
</TR>
</TABLE>

</TD></TR>
</TABLE>
</FORM>

<?
// LIST Question
	if (!empty($quiztitle)) {
		$quiztitle=nl2br($quiztitle);
		echo "<B>$lang[quiztitle] : $quiztitle</B><BR>";
	}

	$sql = "SELECT * FROM $config[tablequiz] where LessonID='$lessonid' ORDER BY  QuizID";
	$result=db_select($sql);

	// Quiz table  0..16
	// $quizid, $lessonid, $question, $answer, $text[1], $desc[1], $text[2], $desc[2], $text[3], $desc[3],$text[4], $desc[4], $text[5], $desc[5], $text[6], $desc[6], $type

	echo "<TABLE WIDTH=100% cellspacing=0 celpadding=2 border=0 align=center>";

	for($i=1; $data = mysql_fetch_row($result);$i++) {
		$showquestion=stripslashes($data[2]); //question
		$showquestion=nl2br($showquestion);
		$showquestion=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$showquestion);
		$showquestion=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$showquestion);

		echo "<TR height=20><TD COLSPAN=2></TD></TR>";
		echo "<TR VALIGN=MIDDLE>";
		echo "<TD><B>$showquestion</B></TD>";
		echo "<TD align=right width=20%>";
		echo "<input class=button type=button value='$lang[button_edit]' onclick=\"javascript:window.open('index.php?action=quiz&quizid=".$data[0]."&lessonid=".$data[1]."','_self')\"> ";
		echo "<input class=button type=button value='$lang[button_delete]' onclick=\"javascript:if(confirm('Are you sure?')) window.open('index.php?action=deletequiz&quizid=".$data[0]."&lessonid=".$data[1]."','_self')\"> ";
		echo "</TD></TR>";
		echo "<TR>";
		echo "<TD colspan=2>";
		for($j=4;$j<=$config['choice']*2;$j++) {
			if ($data[$j]) {
					if ($j%2 == 0) {
						$check =  ($data[3] & pow(2,(($j/2)-1)-1)) ? "checked" :"";
						$showans=stripslashes($data[$j]);	
						$showdesc=stripslashes($data[$j+1]);
						echo "<INPUT TYPE=".$data[16]." NAME=choice[$i] $check> ";
						echo $lang['choice'][$j/2-1];
						$showans=nl2br($showans);
						$showdesc=nl2br($showdesc);
						$showans=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$showans);
						$showdesc=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$showdesc);
						$showans=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$showans);
						$showdesc=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$showdesc);

						echo ". ". $showans;
						if ($showdesc) echo " - " . $showdesc;
						echo "<BR>";
					}
			}
		}
		echo "</TD>";
		echo "</TR>";
	}
	echo "</TABLE>";
}


/**
* Add Quiz
*/
function addQuiz() {
	global $config,$usersess;
	global $quizid,$lessonid;
	global $quiztitle,$question,$answer,$choice,$choicedesc,$type;

	if (count($answer) > 1) {
		$type = 'checkbox';
	}
	else {
		$type = 'radio';
	}
	$question=addslashes($question);
	$quiztitle=addslashes($quiztitle);
	for($i=1,$choiceans=0;$i<=$config['choice'];$i++) {
		$choiceans += $answer[$i];
		$choice[$i]=addslashes($choice[$i]);
		$choicedesc[$i]=addslashes($choicedesc[$i]);
	}

	if (!empty($question)) {
		if ($quizid) {
			$sql = "UPDATE $config[tablequiz] SET Question='$question', Answer='$choiceans', ChoiceA='$choice[1]', DescA='$choicedesc[1]', ChoiceB='$choice[2]', DescB='$choicedesc[2]', ChoiceC='$choice[3]', DescC='$choicedesc[3]', ChoiceD='$choice[4]', DescD='$choicedesc[4]', ChoiceE='$choice[5]', DescE='$choicedesc[5]', ChoiceF='$choice[6]', DescF='$choicedesc[6]', Type='$type' ";
			$sql .=" WHERE QuizID='$quizid' ";

			update_event($usersess->get_var("nickname"),"Modify quiz  $lessonid");
			$quizid="";
		}
		else {

			$sql = "INSERT INTO $config[tablequiz] (LessonID, Question, Answer, ChoiceA, DescA, ChoiceB, DescB, ChoiceC, DescC, ChoiceD, DescD, ChoiceE, DescE, ChoiceF, DescF, Type) ";
			$sql .= "VALUES ('$lessonid', '$question', '$choiceans', '$choice[1]', '$choicedesc[1]', '$choice[2]', '$choicedesc[2]', '$choice[3]', '$choicedesc[3]', '$choice[4]', '$choicedesc[4]', '$choice[5]', '$choicedesc[5]', '$choice[6]', '$choicedesc[6]', '$type')";

			update_event($usersess['nickname'],"Add Quiz $lessonid");
		}
			
		db_query($sql); // Insert or Update quiz choice
	}

	$sql = "UPDATE $config[tablelesson] SET QuizTitle='$quiztitle' WHERE LessonID='$lessonid'";

	db_query($sql); // Update quiz title;

	quiz();
}


/**
* Delete Quiz
*/
function deletequiz() {
	global $config,$usersess;
	global $lessonid,$quizid;

	$sql = "DELETE FROM $config[tablequiz] WHERE QuizID='$quizid' ";
	
	db_query($sql);
	update_event($usersess->get_var("nickname"),"Delete quiz $quizid of lesson $lessonid");
	$quizid='';
	quiz();
}


/**
* Add Assignment
*/
function assignment() {
	global $config,$lang, $usersess;
	global $lessonid,$subaction;

	$courseid = db_getvar($config['tablelesson'],"LessonID='$lessonid'","CourseID");
	$coursecode = db_getvar($config['tablecourse'],"CID='$courseid'","Code");
	$coursename = db_getvar($config['tablecourse'],"CID='$courseid'","CourseName");
	$lessontitle = db_getvar($config['tablelesson'],"LessonID='$lessonid'","LessonTitle");

	$sql = "SELECT Title, Question FROM $config[tableassignment] where LessonID='$lessonid'";
	$result=db_select($sql);
	list($title,$question) = mysql_fetch_row($result);
	$title=stripslashes($title);$title=htmlspecialchars($title);
	$question=stripslashes($question);
//	$question=nl2br($question);
	$question=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$question);
	$question=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$question);

?>
<HTML>
<HEAD>
<TITLE><?=$coursecode?>:<?=$coursename?></TITLE>
<LINK REL="STYLESHEET" HREF="theme/<?=$config['theme']?>/style/default.css" type="text/css">
<BODY BGCOLOR="#FFFFFF" topmargin=2 leftmargin=2>
<?
if (empty($title) || $subaction=="edit") {	
?>
 <script language="javaScript">
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.Assignment.action.value = val;
				return true
			}
			else {
				return false;
			}
		}
		
    	function checkFields() {
			var title = document.forms.Assignment.title.value;
			var question = document.forms.Assignment.question.value;
		
			if (title  == "" ) {
				alert("<?=$lang['alertassignmenttitle']?>");
				document.forms.Assignment.title.focus();
				return false;
			}
			if (question  == "" ) {
				alert("<?$lang['alertassignmentquestion']?>");
				document.forms.Assignment.question.focus();
				return false;
			}
			return true;
		}
</script>	


<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=1 class=form>
<FORM  METHOD=POST NAME="Assignment" ACTION="index.php" Onsubmit="return formSubmit('addassignment')">
<INPUT TYPE="hidden" NAME="action">
<INPUT TYPE="hidden" NAME="lessonid" VALUE="<?=$lessonid?>">
<TR>
	<TD colspan=2>
	<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=3>
	<TR valign=middle HEIGHT=18><TD class=head valign="top" align="left"> <B>&nbsp;<B><?=$lang['assignment']?> :  <?=$lessontitle?></B></TD></TR></TABLE>
	</TD>
</TR>
<TR  HEIGHT=18>
	<TD ALIGN="RIGHT"  VALIGN="MIDDLE" WIDTH="15%"><B><FONT COLOR="#000000"><?=$lang['assignmenttitle']?>:</FONT></TD>
	<TD><INPUT TYPE="text" NAME="title" size=40 VALUE="<?=$title?>" style="width: 90%;"></TD></TR>
</TR>
<TR  HEIGHT=18 VALIGN="TOP">
	<TD ALIGN="RIGHT"><B><FONT COLOR="#000000"><?=$lang['assignmentquestion']?>:</FONT></TD>
	<TD><TEXTAREA NAME="question" ROWS="10" COLS="80" wrap="soft" style="width: 90%;"><?=$question?></TEXTAREA></TD></TR>
</TR>
<TR VALIGN="TOP">
	<TD>&nbsp;</TD>
	<TD>
	<INPUT CLASS="button" TYPE="submit" VALUE=" <?=$lang['button_ok']?> ">
	<BR>&nbsp;
	<!-- <a href="javascript:formSubmit('addassignment')"><img src="images/button/submit.gif" border="0"></a> -->
	</TD>
</TR>
</TABLE>

</TD></TR>
</TABLE>
</FORM>
<?
}
else {
		$question=nl2br($question);
		echo "<TABLE WIDTH=100% cellspacing=1 cellpadding=5 bgcolor=#999999>";
		echo "<TR  valign=top bgcolor=#FFFFFF>";
		echo "<TD>";
		echo "<B>$lang[assignment] : <U>$title</U></B>";
		echo "<BR><BR> $question<BR>&nbsp;<BR>&nbsp;";
		?>
		<CENTER>
		<INPUT class="button" TYPE="button" VALUE="<?=$lang['button_edit']?>" onclick="javascript:window.open('index.php?action=assignment&subaction=edit&lessonid=<?=$lessonid?>','_self')">
		<INPUT class="button" TYPE="button" VALUE="<?=$lang['button_delete']?>" onclick="javascript:if(confirm('Are you sure?')) window.open('index.php?action=deleteassignment&lessonid=<?=$lessonid?>','_self')">
		</CENTER>
		<?
//		echo "<CENTER><A HREF=\"index.php?action=assignment&subaction=edit&lessonid=$lessonid\"><img src=images/button/edit.gif border=0></A>";
//		echo " <A HREF=\"\"><img src=images/button/delete.gif border=0></A>";
//		echo "</CENTER>";
		echo "</TD></TR>";
		echo "</TABLE>";
		echo "<CENTER><BR>";
	}


}


/**
* Add assignment 
*/
function addAssignment() {
	global $config,$usersess;
	global $lessonid,$question,$title;

	$question = addslashes($question);
	$title=addslashes($title);

	$lessonid_In_Assigment = db_getvar($config['tableassignment'],"LessonID='$lessonid'","Lessonid");
	if (empty($lessonid_In_Assigment)) {
		$sql = "INSERT INTO $config[tableassignment] (LessonID, Title, Question) ";
		$sql .= "VALUES ('$lessonid','$title','$question')";
		update_event($usersess->get_var("nickname"),"Add question $lessonid");
	}
	else {
		$sql = "UPDATE $config[tableassignment] SET Title='$title', Question='$question' WHERE LessonID='$lessonid' ";
		update_event($usersess->get_var("nickname"),"Update question  $lessonid");
	}
	db_query($sql);
	assignment();
}


/**
* Delete assignment 
*/
function deleteAssignment() {
	global $config,$usersess;
	global $lessonid;

	$sql = "DELETE FROM $config[tableassignment] WHERE LessonID='$lessonid'";
	db_query($sql);
	update_event($usersess->get_var("nickname"),"Delete assignment to $lessonid");
	assignment();
}


/**
* File manager 
*/
function fileMan() {
	global $config, $lang,$usersess;
	global $courseid;
	
	if (!($usersess->get_var("admin") ||  checkInst($courseid))) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}
	
	courseMenu("Directory",$courseid);	

	$coursecode = db_getvar($config['tablecourse'],"CID='$courseid'","Code");
	$coursename = db_getvar($config['tablecourse'],"CID='$courseid'","CourseName");

?>

<TABLE WIDTH=98% BORDER=0 CELLSPACING=0 CELLPADDING=1 CLASS="form">
<FORM  METHOD=POST ACTION="index.php" ENCTYPE="multipart/form-data">
<INPUT TYPE="hidden" NAME="MAX_FILE_SIZE" VALUE="<?=$config['uploadfilesize']?>">
<INPUT TYPE="hidden" NAME="action" VALUE="uploadfiles">
<INPUT TYPE="hidden" NAME="courseid" VALUE="<?=$courseid?>">

<TR>
	<TD colspan=2>
	<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=3>
	<TR valign=middle HEIGHT=18><TD class="head" valign="top" align="left"> <B>&nbsp;<?=$coursecode?>: <?=$coursename?></B></TD></TR></TABLE>
	</TD>
</TR>

<TR  HEIGHT=18 VALIGN="MIDDLE"><TD ALIGN="CENTER"><B>1. <INPUT TYPE="file" NAME="file[1]"></TD><TD ALIGN="CENTER"><B>2.<INPUT TYPE="file" NAME="file[2]"></TD></TR>
<TR  HEIGHT=18 VALIGN="MIDDLE"><TD ALIGN="CENTER"><B>3. <INPUT TYPE="file" NAME="file[3]"></TD><TD ALIGN="CENTER"><B>4. <INPUT TYPE="file" NAME="file[4]"></TD></TR>
<TR  HEIGHT=18 VALIGN="MIDDLE"><TD ALIGN="CENTER"><B>5. <INPUT TYPE="file" NAME="file[5]"></TD><TD ALIGN="CENTER"><B>6. <INPUT TYPE="file" NAME="file[6]"></TD></TR>
<TR  HEIGHT=18 VALIGN="MIDDLE"><TD ALIGN="CENTER"><B>7. <INPUT TYPE="file" NAME="file[7]"></TD><TD ALIGN="CENTER"><B>8. <INPUT TYPE="file" NAME="file[8]"></TD></TR>
</TR>
<TR VALIGN="TOP" ALIGN="CENTER">
	<TD COLSPAN=2 ALIGN="CENTER"><BR><INPUT CLASS="button" TYPE="submit" VALUE=" <?=$lang['button_upload']?> "><BR>&nbsp;</TD>
</TR>
</TABLE>
</FORM>
<?
	
	$list = '';
	$dir = @opendir("$config[coursedir]/$courseid");
	$i=1;
	while($file = @readdir($dir)) {
		if (($file != "..") and ($file != ".") and !is_dir($config['coursedir'].'/'.$courseid.'/'.$file)) {
			$filesize=filesize("$config[coursedir]/$courseid/$file");
			$filetime=strftime("%d-%m-%Y %H:%M:%S",filectime("$config[coursedir]/$courseid/$file"));
			$ext = pathinfo($config[coursedir].'/'.$courseid.'/'.$file);
			$ext = strtolower($ext['extension']);
			if (file_exists('images/ext/'.$ext.'.gif')) {
				$icon = '<IMG SRC="images/ext/'.$ext.'.gif"  BORDER=0 align=absmiddle>';
			}
			else if (is_dir($config['coursedir'].'/'.$courseid.'/'.$file)) {
				$icon = '<IMG SRC="images/ext/folder_small.gif"  BORDER=0 align=absmiddle>';
			}
			else {
				$icon = '<IMG SRC="images/ext/ntype.gif"  BORDER=0 align=absmiddle>';
			}
			$list .= "<tr bgcolor=".$config['colorn'][$i%2].">";
			$list .= "<td align=left>";
			$list .= "<a class=a href='$config[courseurl]/$courseid/$file' target='_blank'>$icon$file</a>";
			$list .="</td>";
			$list .="<td>";
			$list .="$filesize ";
			$list .= "</td>";
			$list .= "<td>";
			$list .= "$filetime";
			$list .= "</td>";
			$list .= "<td align=left width=50>";
			$list .= "<INPUT TYPE=\"button\" class=button value=\"$lang[button_delete]\"  onclick=\"if(confirm('Delete $file?')) window.open('index.php?action=deletefile&courseid=$courseid&file=$file','_self')\">";
			$list .= "</td>";
			$list .= "</tr>";
		}
		$i++;
	}
	
	if (!empty($list)) {
		echo "<BR><div align=left><IMG SRC='images/bul_or.jpg' width=10 BORDER=0> <B>Directory of  course</B></div>";
		echo "<table width=98% border=0 cellspacing=0 cellpadding=1>";
		echo $list;
		echo "</table><P>";
	}

	// directory of images
	$list = '';
	$dir = @opendir("$config[coursedir]/$courseid/images");
	$i=0;
	while($file = @readdir($dir)) {
		if (($file != "..") and ($file != ".") and !is_dir($config['coursedir'].'/'.$courseid.'/images/'.$file)) {
			$filesize=@filesize("$config[coursedir]/$courseid/images/$file");
			$filetime=@strftime("%d-%m-%Y %H:%M:%S",filectime("$config[coursedir]/$courseid/images/$file"));
			$ext = pathinfo($config[coursedir].'/'.$courseid.'/images/'.$file);
			$ext = strtolower($ext['extension']);
			if (file_exists('images/ext/'.$ext.'.gif')) {
				$icon = '<IMG SRC="images/ext/'.$ext.'.gif"  BORDER=0 align=absmiddle>';
			}
			else {
				$icon = '<IMG SRC="images/ext/ntype.gif"  BORDER=0 align=absmiddle>';
			}
			$list .= "<tr bgcolor=".$config['colorn'][$i%2].">";
			$list .= "<td align=left>";
			$list .= "<a href='$config[courseurl]/$courseid/images/$file' target='_blank'>$icon$file</a>";
			$list .="</td>";
			$list .="<td>";
			$list .="$filesize ";
			$list .= "</td>";
			$list .= "<td>";
			$list .= "$filetime";
			$list .= "</td>";
			$list .= "<td align=left width=50>";
			$list .= "<INPUT TYPE=\"button\" class=button value=\"$lang[button_delete]\"  onclick=\"if(confirm('Delete $file?')) window.open('index.php?action=deletefile&courseid=$courseid&file=$file','_self')\">";
			$list .= "</td>";
			$list .= "</tr>";
		}
		$i++;
	}

	if (!empty($list)) {
		echo "<div align=left><IMG SRC='images/bul_or.jpg' width=10 BORDER=0> <B>Directory of  images</B></div>";
		echo "<table width=98% border=0 cellspacing=0 cellpadding=1>";
		echo $list;
		echo "</table><P>";
	}

}


/**
* Upload files
*/
function uploadFiles() {
	global $config,$lang,$usersess;
	global $courseid;


	if ($usersess->get_var("admin") ||  checkInst($courseid)) {
		for ($i=1;$i<=8;$i++)
			if ($_FILES['file']['name'][$i])
				if(copy($_FILES['file']['tmp_name'][$i],$config['coursedir']."/".$courseid."/".$_FILES['file']['name'][$i])) {
					unlink($_FILES['file']['tmp_name'][$i]);
					update_event($usersess->get_var("nickname"),"Upload file ".$_FILES['file']['name'][$i]." to $config[coursedir]/$courseid");
				 }
				else {
					echo "Your file could not be uploaded '".$_FILES['file']['name'][$i]."'.\n";
				}
	}
	else {
		echo $lang['notauthorize'];
	}

	fileMan();
}


/**
* Delete files
*/
function deleteFile() {
	global $config,$lang,$usersess;
	global $courseid,$file;

	if ($usersess->get_var("admin") ||  checkInst($courseid)) {
		update_event($usersess->get_var("nickname"),"Delete file $config[coursedir]/$courseid/$file");
		unlink("$config[coursedir]/$courseid/$file");
	}
	else {
		echo $lang['notauthorize'];
	}
	fileMan();
}


/**
* Scheduling
*/
function scheduling() {
	global $config,$lang;
	global $order,$p;

?>
	<script language=JavaScript src="js/CalendarPopup.js"></script>
	<script language=JavaScript>document.write(getCalendarStyles());</script>

	<script language="javascript">
	var now = new Date();
	var cal = new CalendarPopup("div");
	</script>
<DIV id=div 
	style="VISIBILITY: hidden; POSITION: absolute; font-family:arial;font-size:8pt; BACKGROUND-COLOR: #CCCCFF; layer-background-color: #FFFFFF"></DIV>

<DIV ALIGN="LEFT">&nbsp;&nbsp;<IMG SRC='images/schedule.jpg' BORDER=0></DIV><BR>

<TABLE WIDTH=98% CELLPADDING=0 CELLSPACING=1 class=form>
<FORM  METHOD=POST NAME="schd" ACTION="index.php">

<INPUT TYPE="hidden" NAME="action" VALUE="addscheduling">

<TR valign=middle HEIGHT=18><TD class=head valign="middle" align="left"> <B>&nbsp;<?=$lang['addschedule']?></B></TD></TR>
<TR>
	<TD>
	<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=3>
		<TR  HEIGHT=18 VALIGN="MIDDLE">
		<TD ALIGN="RIGHT" WIDTH="100"><?=$lang['select_course']?>:</TD>
		<TD><SELECT NAME="courseid">
<?
	$sql = "SELECT CID,Code,CourseName FROM $config[tablecourse] WHERE Enable='1' AND CourseType=0 ORDER BY Code";
	$result=db_select($sql);
	for ($i=0;list($courseid,$code,$name) = mysql_fetch_row($result);$i++) {
		echo "<OPTION value=$courseid>$code - $name</OPTION>";
	}	
?>
</SELECT></TD></TR>
</TR>
<TR  HEIGHT=18>
	<TD ALIGN="RIGHT" WIDTH="100"><?=$lang['coach']?>:</TD>
	<TD>
<?
	$sql = "SELECT Nickname FROM $config[tableuser] WHERE Level=$config[instructor_level] ORDER BY Nickname";
	$result=db_select($sql);
	echo "<SELECT NAME='instructor'>";
	for ($i=0;list($name) = mysql_fetch_row($result);$i++) {
		echo "<OPTION value=$name>$name</OPTION>";
	}	
	echo "</SELECT>";
?>	
	</TD>
</TR>
<TR  HEIGHT=18>
	<TD ALIGN="RIGHT" WIDTH="100"><?=$lang['coursestart']?>:</TD>
	<TD><INPUT TYPE="text" NAME="start" SIZE="12"> 
	<A class=a id=anchor title="cal.select(document.forms[0].start,'anchor','dd-MM-yyyy'); return false;" onclick="javascript:  cal.select(document.forms[0].start,'anchor','dd-MM-yyyy'); return false;" href="#" name=anchor><IMG SRC="images/calendar.gif" WIDTH="24" HEIGHT="24" BORDER=0 ALT="Select Date" ALIGN="absmiddle">(dd-mm-yyyy)</A>
	</TD>
</TR>
<TR VALIGN="TOP">
	<TD></TD><TD><INPUT TYPE="submit" value="<?=$lang['button_addschedule']?>" class=button><BR>&nbsp;</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
<BR>
<?	

// Show pagelist //
	$sql = "SELECT count(*) ";
	$sql.= " FROM $config[tablecourse] c,$config[tablescheduling] s";
	$sql.= " WHERE c.CID=s.CourseID AND c.CourseType='0' AND Start <> '0000-00-00'";

	$result=db_select($sql);
	$data=mysql_fetch_row($result);
	$total=$data[0];
	$totalpages=ceil($total/$config['display_per_page']);
	
	if (!$p) 
			$p=1;

		if ($totalpages > 1 && $p != 1) {
			$back=$p-1;
			$pages .= "[<a href='$PHP_SELF?action=scheduling&order=$order&p=$back' class=active><<</a>] ";
		}
		for($i=1;$i<=$totalpages;$i++) {
			if ($i==$p)
				$pages .= "<b>$i</b> ";
			else
				$pages .= "<a href='$PHP_SELF?action=scheduling&order=$order&p=$i' class=active><u>$i</u></a> ";
		}

		if ($totalpages > 1 && $totalpages != $p) {
			$next=$p+1;
			$pages .= " [<a href='$PHP_SELF?action=scheduling&order=$order&p=$next' class=active>>></a>]";
		}

	$start=($p-1)*$config['display_per_page'];
	$pages="Pages: ".$pages;
	$totalrow="Total : <B>".$total."</B>";
	$note="<BR><BR>&nbsp;&nbsp;<B>Note:</B>";
	$note.="<BR>&nbsp;&nbsp;&nbsp;&nbsp;- Display ".$config['display_per_page']."  per page";
// End Show pagelist //

	$sql = "SELECT s.SchedulingID,s.CourseID,c.Code, c.CourseName, s.Start, l.LessonTitle,sum(l.Length),c.Manday, s.Instructor ";
	$sql.= " FROM $config[tablecourse] c,$config[tablescheduling] s, $config[tablelesson] l";
	$sql.= " WHERE l.CourseID=s.CourseID and c.CID=l.CourseID and c.CourseType='0' Group by s.CourseID,s.Start ORDER BY ";
	if ($order) 
		$sql .= "$order";
	else 
		$sql .= "s.Start desc ,s.CourseID ";

	$sql .= " Limit $start,$config[display_per_page] ";

//	echo $sql;

	$result=db_select($sql);
	
//	echo "$pages";
	if ($total>0) {
		echo "<TABLE WIDTH=98% cellspacing=0 cellpadding=1>";
		echo "<TR height=18 align=center>";
		echo "<TD width=70 class=head2><A class=invert HREF='index.php?action=scheduling&order=s.CourseID'><B>$lang[coursecode]</B></A></TD><TD class=head2><B>$lang[coursename]</B></FONT></TD><TD class=head2><A class=invert HREF='index.php?action=scheduling&order=s.Start'><B>$lang[coursestart]</B></A></TD>";
		echo "<TD class=head2><A HREF='index.php?action=scheduling&order=s.Instructor' class=invert><B>$lang[coach]</B></A></TD><TD class=head2>&nbsp;</TD></TR>";
		
		for($i=1;list($schid,$courseid, $coursecode, $coursename,$start,$coursetitle,$length,$manday,$instructor) = mysql_fetch_row($result);$i++) {
			echo "<TR bgcolor=".$config['colorn'][$i%2].">";
			$duration=thaiDateDuration($start,$length);

			echo "<TD align=center>$coursecode</TD>";
			echo "<TD><A class=b HREF='index.php?action=showrosteradmin&scheduleid=$schid&course=$courseid'>$coursename</A></TD>";
			echo "<TD width=120align=center>$duration</TD>";
			echo "<TD align=center>$instructor</TD>";
			echo "<TD width=50 align=center><INPUT TYPE=\"button\" class=button value=\"$lang[button_delete]\"  onclick=\"if(confirm('Are you sure?')) window.open('index.php?action=deletescheduling&scheduleid=$schid','_self')\"></TD></TR>";
		}
		echo "</TABLE><HR WIDTH=98% SIZE=1>";
		echo "<DIV ALIGN=LEFT>&nbsp;&nbsp;$pages<P>&nbsp;&nbsp;$totalrow&nbsp;&nbsp;$note</DIV>";
	}
	else {
		echo '<BR>'.$lang['noschedule'];
	}

}


/**
* Add schedule
*/
function addScheduling() {
	global $config,$usersess;
	global $courseid,$start,$instructor;
	
	if ($usersess->get_var("admin")) {
//		$startdate=B2C($start);
		list($d,$m,$y)=explode('-',$start);
		$startdate="$y-$m-$d";
		$has_schedule = db_getvar($config['tablescheduling'],"CourseID='$courseid' AND Start='$startdate'","SchedulingID");
		if (!$has_schedule) {
			if (!db_getvar($config['tablescheduling'],"CourseID='$course' and Start='$startdate' ","SchedulingID") && $start) {
				$sql = "INSERT INTO $config[tablescheduling] (CourseID, Start, Instructor) VALUES ('$courseid', '$startdate', '$instructor')";
				db_query($sql);
				update_event($usersess->get_var("nickname"),"Add schedule $course at $startdate");
			}
		}
	}

	scheduling();
}


/**
* Delete Schedule
*/
function deleteScheduling() {
	global $config,$usersess;
	global $scheduleid;
	
	if ($usersess->get_var("admin")) {
		$sql = "DELETE FROM $config[tablescheduling] WHERE SchedulingID='$scheduleid' ";
		db_query($sql);

		update_event($usersess->get_var("nickname"),"Delete schedule no.$schid");
	}

	scheduling();
}
?>