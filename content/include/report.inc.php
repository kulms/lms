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
* Report Menu
*/
function reportMenu() {
	global $config;

	echo '<DIV ALIGN="LEFT">&nbsp;&nbsp;<IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/statistic.jpg" BORDER=0></DIV><BR>';

?>
		<TABLE WIDTH=98% CELLPADDING=0 CELLSPACING=0>
		<TR HEIGHT="20">
			<TD>
			REPORT MENU ::

			<!-- MENU -->
			<A HREF="index.php?action=report" class=active>Overview</A>&nbsp;
			|&nbsp;<A HREF="index.php?action=report2" class=active>Usage</A>&nbsp;
			<!-- MENU -->
			
			</TD>
			<TD ALIGN=RIGHT></TD>
		</TR>
			<TR HEIGHT="1">
			<TD COLSPAN="2" BACKGROUND="images/line2.gif"></TD>
		</TR>
		</TABLE>
<?
}


/**
* Report overview
*/
function report() {
	global $config, $lang;

	reportMenu();

// ผู้ใช้งานระบบทั้งหมด
	$sql = "SELECT count(*) FROM $config[tableuser]";
	$result=db_select($sql);
	$totalusers = mysql_fetch_row($result);

// ผู้ใช้งานระบบที่ถูกยกเลิกชั่วคราว
	$sql = "SELECT count(*) FROM $config[tableuser] WHERE Enabled <> '1'";
	$result=db_select($sql);
	$ltotalusers = mysql_fetch_row($result);

// จำนวนผู้สอน
	$sql = "SELECT count(*) FROM $config[tableuser] WHERE LEVEL='".$config['instructor_level']."' ";
	$result=db_select($sql);
	$instusers = mysql_fetch_row($result);

// จำนวนผู้ดูแลระบบ
	$sql = "SELECT count(*) FROM $config[tableuser] WHERE LEVEL='".$config['admin_level']."' ";
	$result=db_select($sql);
	$adminusers = mysql_fetch_row($result);

// จำนวนนักเรียน
	$sql = "SELECT count(*) FROM $config[tableuser] WHERE LEVEL='".$config['student_level']."' ";
	$result=db_select($sql);
	$studentusers = mysql_fetch_row($result);

// จำนวนหลักสูตร
	$sql = "SELECT count(*) FROM $config[tablecourse] WHERE Enable='1' ";
	$result=db_select($sql);
	$totalcourse = mysql_fetch_row($result);

	$sql = "SELECT count(*) FROM $config[tablecourse] WHERE Enable <> '1' ";
	$result=db_select($sql);
	$buildcourse = mysql_fetch_row($result);

	?>
	<TABLE WIDTH=98% CELLPADDING=0 CELLSPACING=0>
	<TR>
	<TD>
		<IMG SRC="images/bul_or.jpg" WIDTH="10" HEIGHT="10" BORDER="0" ALT=""> <B>Overview</B>
	</TD>
	</TR>
	</TABLE>

	<TABLE WIDTH=80% CELLPADDING=0 CELLSPACING=0>
	<TR>
	<TD ALIGN="LEFT">
	
		<UL>
		<IMG SRC="images/arrow.gif" WIDTH="7" HEIGHT="8" BORDER="0" ALT=""> <B><?=$lang['user']?></B><BR>&nbsp;
			<TABLE WIDTH=400 CELLPADDING=3 CELLSPACING=1 BORDER=0>
			<TR ALIGN=CENTER>
				<TD class="head"><B><?=$lang['usergroup']?></B></TD>
				<TD class="head" width=14%><B><?=$lang['user_unit']?></B></TD>
			</TR>
			<TR>
				<TD><?=$lang['admin']?></TD>
				<TD ALIGN=CENTER><B><?=$adminusers[0]?></B></TD>
			</TR>
			<TR>
				<TD><?=$lang['coach']?></TD>
				<TD ALIGN=CENTER><B><?=$instusers[0]?></B></TD>
			</TR>
			<TR>
				<TD><?=$lang['student']?></TD>
				<TD ALIGN=CENTER><B><?=$studentusers[0]?></B></TD>
			</TR>
			<TR>
				<TD colspan=2 bgcolor="#000000" height=1></TD>
			</TR>
			<TR>
				<TD align=right><?=$lang['user_total']?></TD>
				<TD ALIGN=CENTER><B><?=$totalusers[0]?></B></TD>
			</TR>
			</TABLE>


		<P>
		<IMG SRC="images/arrow.gif" WIDTH="7" HEIGHT="8" BORDER="0" ALT=""> <B><?=$lang['course_open']?></B><BR>&nbsp;
<?
		$sql = "SELECT School_name,count(*) FROM $config[tableschool] s, $config[tablecourse] c where c.School=s.School_Code AND c.Enable=1 Group by c.School";
		$result=db_select($sql);
		echo "<TABLE WIDTH=400 CELLPADDING=3 CELLSPACING=1 BORDER=0>";
		echo "<TR align=center><TD class=head><B>$lang[school]</B></TD><TD WIDTH=14% class=head><B>$lang[course]</B></TD></TR>";
		for($i=0;list($schoolname,$totalCourseInSchool) = mysql_fetch_row($result);$i++) {
			echo "<TR><TD>- $schoolname</TD><TD ALIGN=CENTER><B>$totalCourseInSchool</B></TD></TR>";
		}
		echo '<TR><TD colspan=2 bgcolor="#000000" height=1></TD></TR>';
		echo "<TR><TD align=right>$lang[course_total]&nbsp;</TD><TD ALIGN=CENTER><B>$totalcourse[0]</B> </TD></TR>";
		echo "</TABLE><P>";

		echo '<IMG SRC="images/arrow.gif" WIDTH="7" HEIGHT="8" BORDER="0" ALT=""><B>'.$lang['course_underconstruction'].'</B><BR>&nbsp;';
		$sql = "SELECT School_name,count(*) FROM $config[tableschool] s, $config[tablecourse] c where c.School=s.School_Code AND c.Enable <> 1 Group by c.School";
		$result=db_select($sql);
		echo "<TABLE WIDTH=400 CELLPADDING=3 CELLSPACING=1 BORDER=0>";
		echo "<TR align=center><TD class=head><B>$lang[school]</B></TD><TD class=head WIDTH=14%><B>$lang[course]</B></TD></TR>";
		for($i=0;list($schoolname,$totalCourseInSchool) = mysql_fetch_row($result);$i++) {
			echo "<TR><TD>- $schoolname</TD><TD ALIGN=CENTER><B>$totalCourseInSchool</B></TD></TR>";
		}
		echo '<TR><TD colspan=2 bgcolor="#000000" height=1></TD></TR>';
		echo "<TR><TD align=right>$lang[course_total]&nbsp;</TD><TD ALIGN=CENTER><B>$buildcourse[0]</B> </TD></TR>";
		echo "</TABLE><P>";
?>

</TD>
</TR>
</TABLE>

<?
}

/**
* Report Activities 
*/
function reportActivities() {
	global $config;
	
	reportMenu();

?>
<TABLE WIDTH=98% CELLPADDING=0 CELLSPACING=0>
<TR>
<TD>
	<IMG SRC="images/bul_or.jpg" WIDTH="10" HEIGHT="10" BORDER="0" ALT=""> <B>Usage</B>
</TD>
</TR>
</TABLE>

<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=0 BORDER=0 class=form>
<TR>
	<TD>
<TABLE  CELLPADDING="3" CELLSPACING="0" BORDER="0">
<TR>
	<TD class=head><B>Activities per day</B></TD>
</TR>
<TR>
	<TD  ALIGN="RIGHT">
		<TABLE  CELLPADDING="0" CELLSPACING="0" BORDER="0">
			<TR ALIGN="CENTER" VALIGN="BOTTOM">
				<?
					for($max=0,$j=0, $i=26;$i>-2;$i--,$j++) {
						$dayrun=dateAdd($date[0],-$i);
						list($y,$m,$d)=explode("-",$dayrun);
						$sql="SELECT count(*) FROM $config[tablelog] WHERE year(Eventtime)='$y' and month(Eventtime)='$m' and dayofmonth(Eventtime)='$d'";
						$result=db_select($sql);
						$actno = mysql_fetch_row($result);
						if ($actno[0] > $max) 
							$max=$actno[0];
						$actlist[$j]=$actno[0];
					}

					for($j=0,$i=26;$i>-2;$i--,$j++) {
						$dayrun=dateAdd($date[0],-$i);
						list($y,$m,$d)=explode("-",$dayrun);
						$height=$actlist[$j]/$max*150;
						echo "<TD WIDTH=70><FONT SIZE=1><FONT SIZE=1 COLOR=#FF9900>".$actlist[$j]."</FONT><BR><IMG SRC=images/orange.jpg WIDTH=12 HEIGHT=".$height." BORDER=0>";
						echo "<BR>".(int)$d."</FONT></TD>";
					}
				
				?>
			</TR>
		</TABLE>
		<FONT SIZE="1" COLOR="#336666"> Day  (<?=C2TH(date('Y-m-d'),1)?>)</FONT>
	</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</CENTER>
<P>
<CENTER>

<TABLE WIDTH="98%" CELLSPACING=0 CELLPADDING=0 BORDER=0 class=form>
<TR>
	<TD>
<TABLE  CELLPADDING="3" CELLSPACING="0" BORDER="0">
<TR>
	<TD class=head><B>Activities per hour</B></TD>
</TR>
<TR>
	<TD ALIGN="RIGHT">
		<TABLE  CELLPADDING="0" CELLSPACING="0" BORDER="0">
			<TR ALIGN="CENTER" VALIGN="BOTTOM">
				<?					
					for($max=0, $i=0; $i<24; $i++) {
						$sql="SELECT count(*) FROM $config[tablelog] WHERE hour(Eventtime)='$i'";
						$result=db_select($sql);
						$actno = mysql_fetch_row($result);
						if ($actno[0] > $max) 
							$max=$actno[0];
						$actlist[$i]=$actno[0];
					}

					for($i=0; $i<24;$i++) {
						$dayrun=dateAdd($date[0],-$i);
						list($y,$m,$d)=explode("-",$dayrun);
						$height=$actlist[$i]/$max*150;
						echo "<TD WIDTH=70><FONT SIZE=1><FONT SIZE=1 COLOR=#FF9900>".$actlist[$i]."</FONT><BR><IMG SRC=images/orange.jpg WIDTH=12 HEIGHT=".$height." BORDER=0>";
						echo "<BR>".$i."</FONT></TD>";
					}
				?>
			</TR>
		</TABLE>
		<FONT SIZE="1">Hour</FONT>
	</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</CENTER>
<P>
<?
}


/**
* How to create report?
* 1. add actionat line 214 of index.php
*			case "report2":		report3(); break;
*  2. add reportmenu line 44 of report.inc.php
*			|&nbsp;<A HREF="index.php?action=report3" class=active>_ _ _</A>&nbsp;
* 3 . add report3 function
* Template fuction 
* Report #3 
*/
function report3() {
	global $config;
	
	reportMenu();
	
	// Do something
	// ..
	//...
}

?>