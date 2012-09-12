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
* package
*/
function package() {
		global $config, $lang,$usersess;
		global $courseid,$lessonid;
	
		if (!($usersess->get_var("admin") ||  checkInst($courseid))) {
			echo '<BR>'.$lang['notauthorize'];
			return;
		}

		courseMenu("Package",$courseid);	

		$coursecode = db_getvar($config['tablecourse'],"CID='$courseid'","Code");
		$coursename = db_getvar($config['tablecourse'],"CID='$courseid'","CourseName");
		$lessonid=0;

		?>
		<TABLE WIDTH=98% BORDER=0 CELLSPACING=0 CELLPADDING=1 class="form">	
			<TR valign=middle HEIGHT=18>
				<TD bgcolor="#0066CC" valign="top" align="left">
				<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=3>
					<TR valign=middle HEIGHT=18><TD class="head" valign="top" align="left"> <B>&nbsp;<?=$coursecode?>: <?=$coursename?></B></TD></TR></TABLE>
				</TD>
		</TR>
		<TR>
			<TD>
			&nbsp;&nbsp;<IMG SRC="images/bul_or.jpg" WIDTH="10" HEIGHT="10" BORDER="0" ALT=""> <FONT COLOR="#336666"><B><?=$lang['importcourse']?> </B></FONT>
			<DD><?=$lang['importcourse_desc']?>
			<BR><BR>
			<CENTER>
			<FORM NAME="form1" METHOD="post" ACTION="import.php" ENCTYPE="multipart/form-data">
			<input type="hidden" name="cid" value="<?=$courseid?>">
			<input type="hidden" name="lid" value="<?=$lessonid?>">
			<TABLE>
			<TR>
				<TD><INPUT TYPE="file" NAME="file"></TD>
			</TR>
			<TR>
				<TD>
				<INPUT TYPE="submit" VALUE="<?=$lang['importcourse']?>" class="button"></TD>
			</TR>
			</TABLE>
			</FORM>
			</CENTER>
			<BR>
			</TD>
		</TR>
		
		
		
		<TR>
			<TD>
			&nbsp;&nbsp;<IMG SRC="images/bul_or.jpg" WIDTH="10" HEIGHT="10" BORDER="0" ALT=""> <FONT COLOR="#336666"><B><?=$lang['exportcourse']?> </B></FONT>
			<DD><?=$lang['exportcourse_desc']?>
			<BR>
			<FORM METHOD=POST ACTION="export.php">
			<INPUT TYPE="hidden" NAME="cid" VALUE="<?=$courseid?>">
			<BR><BR><CENTER><INPUT TYPE="submit" VALUE="<?=$lang['button_export_course']?>" class="button"></CENTER>
			</FORM>
			<BR><BR>
			</TD>
		</TR>

		</TABLE>
<?
	}


/**
* import Lesson package
*/
function importLesson() {
	global $config, $lang, $usersess;
	global $cid,$lid;

	if (!($usersess->get_var("admin") ||  checkInst($courseid))) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}

	echo "<html>";
	echo "<head><title>$lang[importlesson]</title>";
	echo "<LINK REL=STYLESHEET HREF='theme/$config[theme]/style/default.css' type='text/css'></head>";
	echo '<BODY TOPMARGIN="0" LEFTMARGIN="0" MARGINHEIGHT="0" MARGINWIDTH="0" LINK="#000000" ALINK="#000000" VLINK="#000000"><center>';

?>
<TABLE WIDTH=100%  HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=3 class="form">	
		<TR>
			<TD>
			<?=$lang['importcourse_desc']?>
			<CENTER>
			<FORM NAME="form1" METHOD="post" ACTION="import.php" ENCTYPE="multipart/form-data">
			<input type="hidden" name="cid" value="<?=$cid?>">
			<input type="hidden" name="lid" value="<?=$lid?>">
			<TABLE>
			<TR>
				<TD><INPUT TYPE="file" NAME="file"></TD>
			</TR>
			<TR>
				<TD>
				<INPUT TYPE="submit" VALUE="<?=$lang['button_import_lesson']?>" class="button"></TD>
			</TR>
			</TABLE>
			</FORM>
			</CENTER>
			<BR>
			</TD>
		</TR>
<?
}
?>