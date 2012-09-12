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
* Contact us Form 
*/
function contactusForm() {
	global $lang;

?>
    <script language="javaScript">
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.contact.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
		function checkFields() {
			var name = document.forms.contact.firstname.value;
			var email = document.forms.contact.email.value;
			var message = document.forms.contact.message.value;
		
			if (name == "" ) {
				alert("<?=$lang['alertcontactname']?>");
				document.forms.contact.firstname.focus();
				return false;
			}
			if (email == "" ) {
				alert("<?=$lang['alertemail']?>");
				document.forms.contact.email.focus();
				return false;
			}
			if (message  == "" ) {
				alert("<?=$lang['alertmessage']?>");
				document.forms.contact.message.focus();
				return false;
			}

			return true;
		}
</script>

<TABLE width="90%"  border="0" cellpadding="3" cellspacing="0">

<!-- Contactus Form -->
<FORM NAME="contact" METHOD=POST ACTION="index.php" Onsubmit="return  formSubmit('sendcontactus')">
<INPUT TYPE="hidden" name="action">

<TR>
<TD  width="30%"  valign="middle" align="right">
<?=$lang['realname']?> : 
</TD>

<TD valign="middle" align="left">
<INPUT class=input TYPE="text" NAME="firstname">
</TD>
</TR>


<TR>
<TD  width="30%" valign="middle" align="right">
<?=$lang['email']?> :
</TD>

<TD valign="top" align="left">
<INPUT class=input TYPE="text" NAME="email">
</TD>
</TR>

<TR>
<TD  width="30%" valign="middle" align="right">
<?=$lang['contacttype']?> : 
</TD>

<TD valign="top" align="left">
<select name="subject" class="input">
<option value = "-"><?=$lang['select_contacttype']?></option>
<option value = "<?=$lang['contacttype1']?>"><?=$lang['contacttype1']?></option>
<option value = "<?=$lang['contacttype2']?>"><?=$lang['contacttype2']?></option>
<option value = "<?=$lang['contacttype3']?>"><?=$lang['contacttype3']?></option>
</select>
</TD>
</TR>


<TR>
<TD  width="30%" valign="top" align="right">
<?=$lang['contactmessage']?> :
</TD>

<TD valign="top" align="left">
<TEXTAREA NAME="message" ROWS="8" COLS="40" style='width=90%'></TEXTAREA>
</TD>
</TR>

<TR>
<TD  width="30%" valign="top" align="right">&nbsp;</TD>
<TD valign="top" align="left">

<INPUT TYPE="submit" class="button" VALUE="<?=$lang['button_contactus']?>">
</TD>
</TR>
</FORM>
</TABLE>

<?
}

/**
* Edit Overview Course Form
*/
function overviewCourseForm($code) {
	global $config, $lang, $usersess;

	if (!($usersess->get_var("admin") ||  checkInst($code))) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}

	$sql = "SELECT * FROM $config[tablecourse] WHERE CID='$code' ";
	$result=db_select($sql);
	list($courseid,$coursecode,$schoolid,$coursename,$creator,$description,$prerequisite,$objective,$coursemanday,$reference,$enable,$createon,$course_type) = mysql_fetch_row($result);		

	$sql = "SELECT sum(Length) FROM $config[tablelesson]  WHERE CourseID='$courseid'";
	$result=db_select($sql);
	list($courselength) = mysql_fetch_row($result);

	// strip slashes and remove special chars
	$coursename=stripslashes($coursename);
	$coursename=htmlspecialchars($coursename);
	$description=stripslashes($description);
	$objective=stripslashes($objective);
	$prequisite=stripslashes($prequisite);
	$reference=stripslashes($reference);

?>

    <script language="javaScript">
		function formSubmit(val) {
			if(val == "Clear") document.forms.Course.submit();
			else if(checkFields()) {
				document.forms.Course.action.value = val;
				return true;
			}

			return false;
		}
		
		function clearFields() {
			document.forms.Course.reset();
		}

    	function checkFields() {
			var code = document.forms.Course.coursecode.value;
			var name = document.forms.Course.cname.value;
			var creator = document.forms.Course.creator.value;
 			var description = document.forms.Course.description.value;
			var objective = document.forms.Course.objective.value;
		
			if (code  == "" ) {
				alert("<?=$lang['alertcode']?>");
				document.forms.Course.coursecode.focus();
				return false;
			}
			if (name  == "" ) {
				alert("<?=$lang['alertname']?>");
				document.forms.Course.cname.focus();
				return false;
			}
			if (creator  == "" ) {
				alert("<?=$lang['alertcreator']?>");
				document.forms.Course.creator.focus();
				return false;
			}
			if (description  == "" ) {
				alert("<?=$lang['alertdescription']?>");
				document.forms.Course.description.focus();
				return false;
			}
			if (objective  == "" ) {
				alert("<?=$lang['alertobjective']?>");
				document.forms.Course.objective.focus();
				return false;
			}
			if (description  == "" ) {
				alert("<?=$lang['alertdescription']?>");
				document.forms.Course.description.focus();
				return false;
			}

			return true; 
		}

		function isComposedOfChars(testSet, input) {
			for (var j=0; j<input.length; j++) {
				if (testSet.indexOf(input.charAt(j), 0) == -1){
					return true;
				}
			}
	return false;
}

</script>

	<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=1 CLASS="form">
	<FORM NAME="Course" METHOD=POST ACTION="index.php" Onsubmit="return formSubmit('submitcourse')">
	<INPUT TYPE="hidden" name="courseid" value="<?=$courseid?>">

	<TR>
	<TD colspan=2>
	<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=3>
	<TR valign=middle HEIGHT=18><TD class=head valign="top" align="left"> <B>&nbsp;<?=$coursecode?>: <?=$coursename?></B></TD></TR></TABLE>
	</TD>
	</TR>

	<TR>
	<TD ALIGN="RIGHT" width=20%><?=$lang['school']?>:</TD>
	<TD>
		<SELECT NAME="schoolid" onchange="document.forms.Course.coursecode.value=document.forms.Course.schoolid.options[this.selectedIndex].value;document.forms.Course.courseid.focus();">
	<?
		$sql = "SELECT * FROM $config[tableschool]  ORDER BY School_code";
		$result=db_select($sql);
		for ($i=0;list($id,$schoolcode,$schoolname) = mysql_fetch_row($result);$i++) {
			if ($id==$schoolid) {
				$ok=  "selected";
				$code=$schoolcode;
			}
			else {
				$ok = '';
			}
			echo "<OPTION VALUE=".$schoolcode." $ok> $schoolname </OPTION>";
		}
//		$courseid = str_replace($code,'',$courseid);
	?>
	</SELECT></TD>
</TR>
<TR>
	<TD ALIGN="RIGHT"><?=$lang['coursecode']?>:</TD>
	<TD><INPUT TYPE="text" NAME="coursecode" size=10 value="<?=$coursecode?>"></TD>
</TR>
<TR>
	<TD ALIGN="RIGHT"><?=$lang['coursename']?>:</TD>
	<TD><INPUT TYPE="text" NAME="cname" size=40 value="<?=$coursename?>" style="width: 90%;"></TD>
</TR>
 <TR VALIGN="TOP">
	<TD ALIGN="RIGHT"><?=$lang['courseabstract']?>:</TD>
	<TD><TEXTAREA NAME="description" ROWS="8" COLS="80" wrap="soft" style="width: 90%;"><?=$description?></TEXTAREA></TD>
</TR>
<TR VALIGN="TOP">
	<TD ALIGN="RIGHT"><?=$lang['courseobjective']?>:</TD>
	<TD><TEXTAREA NAME="objective" ROWS="8" COLS="80" wrap="soft" style="width: 90%;"><?=$objective?></TEXTAREA></TD>
</TR>
<TR VALIGN="TOP">
	<TD ALIGN="RIGHT"><?=$lang['courseprerequisite']?>:</TD>
	<TD><TEXTAREA NAME="prerequisite" ROWS="3" COLS="80" wrap="soft" style="width: 90%;"><?=$prerequisite?></TEXTAREA></TD>
</TR>
<TR VALIGN="TOP">
	<TD ALIGN="RIGHT"><?=$lang['coursereference']?>:</TD>
	<TD><TEXTAREA NAME="reference" ROWS="3" COLS="80" wrap="soft" style="width: 90%;"><?=$reference?></TEXTAREA></TD>
</TR>
<TR>
	<TD ALIGN="RIGHT"><?=$lang['coursecreator']?>:</TD>
	<TD>
	<?
	$sql = "SELECT Nickname FROM $config[tableuser] WHERE Level='$config[admin_level]' OR Level='$config[instructor_level]' ORDER BY Nickname";
	$result=db_select($sql);
	echo "<SELECT NAME='creator'>";
	for ($i=0;list($name) = mysql_fetch_row($result);$i++) {
		 if ($name==$creator)
			echo "<OPTION value=$name selected>$name</OPTION>";
		else
			echo "<OPTION value=$name>$name</OPTION>";
	}	
	echo "</SELECT>";
	?>	
	</TD>
</TR>
<TR>
	<TD ALIGN="RIGHT"><?=$lang['coursecredit']?> :</TD>
	<TD><INPUT TYPE="text" NAME="manday" Value="<?=$coursemanday?>" size=3> 
<? if (!empty($courselength)) { ?>
	 (<?=$lang['courselength']?> <B><?=$courselength?></B> <?=$lang['courselength_unit']?>)
<? } ?>
	</TD>
</TR>

<TR>
	<TD ALIGN="RIGHT" VALIGN="TOP"><?=$lang['coursesequence']?>:</TD>
	<TD><INPUT TYPE="radio" NAME="course_type" VALUE="0" <? if ($course_type=='0') echo "checked"; ?>><?=$lang['coursesequence1']?> &nbsp;&nbsp;&nbsp;&nbsp;<BR><INPUT TYPE="radio" NAME="course_type" VALUE="1" <? if ($course_type=='1') echo "checked"; ?>><?=$lang['coursesequence2']?></TD>
</TR>
<TR>
	<TD ALIGN="RIGHT" ><?=$lang['courseactive']?>:</TD>
	<TD><INPUT TYPE="checkbox" NAME="enable" Value="1" size=1 <? if ($enable) echo "checked"; ?>>&nbsp;</TD>
</TR>

<TR VALIGN="TOP">
	<TD>&nbsp;</TD>
	<TD><BR>
	<input type="hidden" name="action">
	<INPUT class="button" TYPE="submit" value="<?=$lang['button_editcourse']?>">&nbsp;
	<INPUT class="button" TYPE="submit" value="<?=$lang['button_clear']?>" Onclick="javascript:clearFields()">
	<BR>&nbsp;
</TD>
</TR>
</TABLE></FORM>
<BR>
<?

}


/**
* Add Lesson Form
*/
function lessonCourseForm($code,$lessonid) {
	global $config,$lang,$usersess;

	if (!($usersess->get_var("admin") ||  checkInst($code))) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}

	$coursetype = db_getvar($config['tablecourse'],"CID='$code'","CourseType");

	if (empty($lessonid)) {
		$coursename = db_getvar($config['tablecourse'],"CID='$code'","CourseName");
		$coursecode = db_getvar($config['tablecourse'],"CID='$code'","Code");
		$coursename=stripslashes($coursename);
		$coursename=htmlspecialchars($coursename);
//		$lessonno = db_getvar($config['tablelesson'],"CourseID='$code'","MAX(Ordering)") + 1;
	}
	else {
		$sql = "SELECT LessonID, Code, CourseName, LessonTitle, Abstract, LessonFile, Length, Manday,LessonParentID,Ordering FROM $config[tablelesson], $config[tablecourse] where CourseID = CID and LessonID = '$lessonid' ";
		$result=db_select($sql);
		list($lessonid,$coursecode, $coursename,$lessontitle,$lessonabstract,$lessonfile,$length,$manday,$parent,$ordering) = mysql_fetch_row($result);
		$coursename=stripslashes($coursename); $coursename=htmlspecialchars($coursename);
		$lessontitle=stripslashes($lessontitle); $lessontitle=htmlspecialchars($lessontitle);
		$lessonabstract=stripslashes($lessonabstract);
		ob_start();
		getLessonno($lessonid,0,array());
		$lessonno = ob_get_contents();
		ob_clean();
		$lessonnos=explode('.',$lessonno);
		for($i=0,$lns=array();$i<count($lessonnos);$i++) {
			if (!empty($lessonnos[$i]))
				$lns[]=$lessonnos[$i];
		}
		$lessonno=join('.',$lns);
	}

?>
	    <script language="javaScript">
		function formSubmit(val) {
			if (checkFields()) {
				document.forms.Lesson.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
    	function checkFields() {
			var title = document.forms.Lesson.title.value;
			var lessonno = document.forms.Lesson.lessonno.value;
		
			if (lessonno  == "" ) {
				alert("<?=$lang['alertlessonno']?>");
				document.forms.Lesson.lessonno.focus();
				return false;
			}
			if (title  == "" ) {
				alert("<?=$lang['alertlessontitle']?>");
				document.forms.Lesson.title.focus();
				return false;
			}
			return true;
		}
	</script>	

<TABLE WIDTH="98%" CELLSPACING="0" CELLPADDING="1" BORDER="0" CLASS="form">
<FORM NAME="Lesson" METHOD=POST ACTION="index.php" Onsubmit="return formSubmit('submitlesson')">
<INPUT TYPE="hidden" NAME="courseid" VALUE="<?=$code?>">
<INPUT TYPE="hidden" NAME="lessonid" VALUE="<?=$lessonid?>">
<TR>
	<TD colspan=2>
	<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=3>
	<TR valign=middle HEIGHT=18><TD class="head" valign="top" align="left"> <B>&nbsp;<?=$coursecode?>: <?=$coursename?></B></TD></TR></TABLE>
	</TD>
</TR>

<TR>
	<TD ALIGN="RIGHT" WIDTH="15%"><?=$lang['lessonno']?>:</TD>
	<TD><INPUT TYPE="text" NAME="lessonno" size="5" value=<?=$lessonno?>></TD>
</TR>

<TR>
	<TD ALIGN="RIGHT" WIDTH="15%"><?=$lang['lessontitle']?>:</TD>
	<TD><INPUT TYPE="text" NAME="title" size=40 value="<?=$lessontitle?>"></TD>
</TR>

<TR VALIGN="TOP">
	<TD ALIGN="RIGHT"><?=$lang['lessonabstract']?>:</TD>
	<TD><TEXTAREA NAME="abstract" ROWS="5" COLS="30" wrap="soft" style="width: 90%;"><?=$lessonabstract?></TEXTAREA></TD>
</TR>
<? if ($coursetype == '0') { ?>
<TR>
	<TD ALIGN="RIGHT"><?=$lang['lessonlength']?>:</TD>
	<TD><INPUT TYPE="text" NAME="length" size=1 value="<?=$length?>"> <?=$lang['lessonlength_unit']?></TD>
</TR>
<? } ?>
<? if ($lessonfile) {?>
<TR>
	<TD ALIGN="RIGHT"><?=$lang['lessonfile']?>:</TD>
	<TD><INPUT TYPE="text" NAME="lessonfile" size=20 value="<?=$lessonfile?>"></TD>
</TR>
<? } ?>

<TR VALIGN="TOP">
	<TD>&nbsp;</TD>
	<TD>
	<BR>
	<input type="hidden" name="action">
	<? if (empty($lessonid)) { ?>
		<INPUT class="button" TYPE="submit" VALUE="<?=$lang['button_addlesson']?>">
	<? } else {?>
		<INPUT class="button" TYPE="submit" VALUE="<?=$lang['button_editlesson']?>">
		<INPUT class="button" TYPE="submit" VALUE="<?=$lang['button_cancel']?>" onclick="javascript:window.open('index.php?action=editlesson&courseid=<?=$code?>','_self')">
	<? } ?>
	<BR>&nbsp;
 </TD>
</TR>
</TABLE>
</FORM>
<BR>
<?
	// Browse Lesson ====>>>>>>

	echo '<TABLE WIDTH="98%" CELLSPACING="0" BORDER="0">';
	echo '<TR valign=middle HEIGHT=18><TD class=head2 valign="top" align="left"> <B>&nbsp;'.$lang['table_of_content'].'</B></TD></TR></TABLE>';

	printLesson($code,0,$orderings=array());
}


function getLessonno($id,$path,$orderings=array()) {
	global $config, $lang, $usersess;

	$sql = "SELECT LessonParentID,Ordering FROM $config[tablelesson] WHERE LessonID='$id'";
	$result=db_select($sql);
	list($parent,$ordering) = mysql_fetch_row($result);
	if ($parent !=0) {
		getLessonno($parent,$orderings);
	}

	echo $ordering.'.';

}

function printLesson($code,$parent,$orderings=array()) {
	global $config, $lang, $usersess;
	static $cnt=0;


	$sql = "SELECT LessonID,  LessonTitle, Abstract, LessonFile, Length,LessonParentID,Ordering FROM $config[tablelesson] WHERE CourseID='$code' AND LessonParentID='$parent' ORDER BY LessonParentID,Ordering";

	$result=db_select($sql);
	
	for ($i=1;list($lessonid,$lessontitle,$lessonabstract,$lessonfile,$length,$parent,$ordering) = mysql_fetch_row($result);$i++) {
		$lessontitle=stripslashes($lessontitle);
		$lessontitle=htmlspecialchars($lessontitle);
		$lessontitle=str_replace("'","\'",$lessontitle);
		
		$lessonabstract=stripslashes($lessonabstract);$lessonabstract=nl2br($lessonabstract);
		$dfile=$config['courseurl']."/".$code;
		if (empty($lessonfile)) {
				$lessonfile=$lessonid.".html";	
		}
		$ufile=$dfile."/".$lessonfile;

		array_push($orderings,$ordering);
		$show_item=join('.',$orderings);


		if ($parent==0) {
			$cnt++;
			$color = $cnt%2 ? '#FAFEED':'#FFFFFF';
		}
		else {
			$color = $cnt%2 ? '#FAFEED':'#FFFFFF';
		}
		echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=0 BGCOLOR=$color BORDER=0>";
		echo "<TR valign=top>";
		echo "<TD valign=\"middle\" align=\"left\" width=10>";
		for($j=0;$j<strlen($show_item);$j++) echo '&nbsp;&nbsp;';
		echo "</TD>";
		echo "<TD valign=\"top\" align=\"left\">";
		$lesson_subtitle = $lessontitle;

		$ext = pathinfo($ufile);
		$ext = $ext['extension'];

		if ($parent==0) {
			$lessontitle = "<FONT COLOR=#800000>$show_item. $lessontitle</FONT>";
		}
		else  {
			$lessontitle = "<FONT COLOR=#000000>$show_item. $lessontitle</FONT>";
		}

?>		
<SCRIPT LANGUAGE="JavaScript">
<!--
var myMenu<?=$lessonid?> =
[
[null,'<?=$lessontitle?>',null,null,'<?=$lesson_subtitle?>',
	['<img src="js/ThemeOffice/config.png" />','<?=$lang['menu_lesson_edit']?>','index.php?action=editlesson&courseid=<?=$code?>&lessonid=<?=$lessonid?>',null,'<?=$lang['menu_lesson_edit']?>'],
	_cmSplit,<?
	
	
	if (strtolower($ext) == 'html') {
	
	?>['<img src="js/ThemeOffice/mainmenu.png" />','<?=$lang['menu_lesson_content']?>','javascript:popup2("index.php?action=editcontent&subaction=editor&filename=<?=$ufile?>&dir=<?=$dfile?>&imgdir=<?=$dfile?>/images", "<?=$lessonid_lesson?>", 800, 600)',null,'<?=$lang['menu_lesson_content']?>'],<?
	}

	?>['<img src="js/ThemeOffice/help.png" />','<?=$lang['menu_lesson_quiz']?>','javascript:popup("index.php?action=quiz&lessonid=<?=$lessonid?>","<?=$lessonid_quiz?>", 650, 550)',null,'<?=$lang['menu_lesson_quiz']?>'],
	['<img src="js/ThemeOffice/content.png" />','<?=$lang['menu_lesson_ex']?>','javascript:popup("index.php?action=assignment&lessonid=<?=$lessonid?>","<?=$lessonid_ass?>", 650, 550)',null,'<?=$lang['menu_lesson_ex']?>'],
	_cmSplit,
	['<img src="js/ThemeOffice/preview.png" />','<?=$lang['menu_lesson_preview']?>','index.php?action=lessonshow&lessonid=<?=$lessonid?>',null,'<?=$lang['menu_lesson_preview']?>'],
	_cmSplit,
	['<img src="js/ThemeOffice/install.png" />','<?=$lang['menu_lesson_import']?>','javascript:popup("index.php?action=importlesson&cid=<?=$code?>&lid=<?=$lessonid?>","_import_form",400,150)',null,'<?=$lang['menu_lesson_import']?>'],
	['<img src="js/ThemeOffice/backup.png" />','<?=$lang['menu_lesson_export']?>','export.php?cid=<?=$code?>&lid=<?=$lessonid?>',null,'<?=$lang['menu_lesson_export']?>'],
	_cmSplit,
	['<img src="js/ThemeOffice/db.png" />','<?=$lang['menu_lesson_delete']?>','javascript:if(confirm("Delete lesson ?\\nWARNING: you will lose all data in lesson")) window.open("index.php?action=deletelesson&courseid=<?=$code?>&lessonid=<?=$lessonid?>","_self")',null,'<?=$lang['menu_lesson_delete']?>']
]
];
//-->
</SCRIPT>
<span id="myMenuID<?=$lessonid?>"></span><script language="JavaScript" type="text/javascript">
		cmDraw ('myMenuID<?=$lessonid?>', myMenu<?=$lessonid?>, 'hbr', cmThemeOffice, 'ThemeOffice');
</script>
<?
	echo "</TD>";

	echo '</TD></TR>';

	echo "<TR valign=top>";
	echo "<TD valign=\"top\" align=\"left\" width=10>&nbsp;</TD>";
	echo "<TD valign=\"top\" align=\"left\" colspan=2>";
	echo "$lessonabstract";
	if ($length > 0) {
		echo " ($length $lang[lessonlength_unit])<BR>&nbsp;";
	}


		//¡’‰«È∂È“∫—ß‡Õ‘≠‰ª≈∫‰ø≈Ï ®–‰¥È √È“ß‰ø≈Ï„ÀÈ„À¡Ë 
		if (!file_exists($ufile)) {
				$fp=@fopen($ufile,"w");
				@fwrite($fp,$lessontitle);
				@fclose($fp);
				
				// add new lesson file to database
				$sql1 = "UPDATE $config[tablelesson] SET LessonFile='$lessonfile' WHERE LessonID='$lessonid'";
				db_query($sql1);
		}
		echo "</TD>";
		echo "</TR>";
		echo "</TABLE>";
		printLesson($code,$lessonid,$orderings);
		array_pop($orderings);
		if ($parent == 0) {
			echo "<TABLE WIDTH=98% CELLSPACING=0 BGCOLOR=#EAEAEA BORDER=0>";
			echo "<TR HEIGHT=1><TD background='images/line2.gif' valign=\"middle\" ></TD></TR></TABLE>";
		}
	}
}
?>