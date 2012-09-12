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
/*
* get start date 
*/
function getStartDate($courseid,$parent,$lessonid) {
	global $config,$start;

	// หาวันเปิดเรียนของ $scheduleid
	$sql = "SELECT LessonID, Length, LessonParentID FROM $config[tablelesson]";
	$sql .= " WHERE  CourseID='$courseid' AND LessonParentID='$parent' ORDER BY LessonParentID,Ordering";

	$result=db_select($sql);
	for($i=0;list($id,$length,$parent) = mysql_fetch_row($result);$i++) {
		if ($id != $lessonid) {
			$start=dateAdd($start,$length+1);
			if (getStartDate($courseid,$id,$lessonid) == false) {
				break;
			}
		}
		else {
			return false;
		}
	}
}


/**
* show LessonFrame 
*/
function lessonShowFrame() {
	global $config,$lang,$usersess;
	global $courseid,$scheduleid,$lessonid,$page;
	global $my_files,$start;

	$start = db_getvar($config['tablescheduling'],"SchedulingID='$scheduleid'","Start");
	getStartDate($courseid,0,$lessonid);

	if ( checkStarted($start) || $usersess->get_var('admin') ||  checkInst($courseid) || (!isScheduleBased($courseid) && $usersess->get_var("nickname"))) {

		$sql = "SELECT LessonTitle, Abstract, LessonFile,CourseID FROM $config[tablelesson] WHERE LessonID='$lessonid'";
		$result=db_select($sql);
		list($lessontitle,$abstract,$lessonfile,$courseid) = mysql_fetch_row($result);
		$lessontitle = stripslashes($lessontitle);
		$abstract = nl2br(stripslashes($abstract));
		$desc="<B>$lessontitle</B><BR>$abstract<BR>";

		viewMenu("Lesson",$courseid,$scheduleid,$desc);		

		echo "<TABLE cellpadding=0 cellspacing=0 width=98% class=form><TR><TD align=right>";
		echo "&nbsp;";
		gotoLesson($courseid,$schedulingid,$lessonid);
		echo "</TD></TR></TABLE>";

	
		$ext = pathinfo($config['coursedir'].'/'.$courseid.'/'.$lessonfile);
		$ext = $ext['extension'];

		if (strtolower($ext) == 'htm') {
			$object = $config['coursedir'].'/'.$courseid.'/'.$lessonfile;
		}
		else {
			$object = "index.php?action=lessonshowcontent&courseid=$courseid&lessonid=$lessonid&scheduleid=$scheduleid&page=$page";
		}	
		echo "<TABLE WIDTH=98% CELLSPACING=1 CELLPADDING=0 class=form><TR  height=320><TD bgcolor=#FFFFFF valign=top align=center>";

		echo "<IFRAME marginWidth=0 marginHeight=0 id=Content  scrolling=auto name=Content src=\"$object\" frameBorder=0 width=100% height=585>";

		echo "<BR><BR><CENTER>Alternate content for non-supporting browsers <P><A class=active HREF=$object><B>Click here!</B></A></CENTER></IFRAME>";
	
		echo "&nbsp;</TD></TR></TABLE>";
		
		
		viewLessonMenu($courseid,$scheduleid,$lessonid,"");
	}
}



/**
* show Lesson (html)
*/
function lessonShow() {
	global $config,$lang,$usersess;
	global $courseid,$scheduleid,$lessonid,$page;
	global $my_files,$start;

	$start = db_getvar($config['tablescheduling'],"SchedulingID='$scheduleid'","Start");
	getStartDate($courseid,0,$lessonid);

	if ( checkStarted($start) || $usersess->get_var('admin') ||  checkInst($courseid) || (!isScheduleBased($courseid) && $usersess->get_var("nickname"))) {

		update_event($usersess->get_var('nickname'),"Reading $courseid-$scheduleid: Lesson $i page $page");

		$sql = "SELECT LessonTitle, Abstract, LessonFile,CourseID FROM $config[tablelesson] WHERE LessonID='$lessonid'";
		$result=db_select($sql);
		list($lessontitle,$abstract,$lessonfile,$courseid) = mysql_fetch_row($result);

		$ext = pathinfo($config['coursedir'].'/'.$courseid.'/'.$lessonfile);
		$ext = $ext['extension'];


		if (strtolower($ext) == 'html' || strtolower($ext) == 'htm') {
			$FILE=@file($config['coursedir'].'/'.$courseid.'/'.$lessonfile);
			for ($i=0;$i<count($FILE);$i++) 
				$texthtml .= $FILE[$i];
		}

		if (ereg('{PAGE}',$texthtml) || ereg('{PDF}',$texthtml) || ereg('{SWF}',$texthtml)) {
		
			$lessonhtml = showContent("$config[coursedir]/$courseid/$lessonfile","$config[courseurl]/$courseid");
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?=$lang['site_title']?></TITLE>
<META NAME="Author" CONTENT="S.Kongdej">
<META NAME="Keywords" CONTENT="<?=$lang['site_keywords']?>">
<META NAME="Description" CONTENT="<?=$lang['site_description']?>">
<META http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK REL="STYLESHEET" HREF="theme/<?=$config['theme']?>/style/default.css" type="text/css">
</HEAD>
<BODY BGCOLOR="#FFFFFF" TOPMARGIN="0" LEFTMARGIN="0" MARGINHEIGHT="0" MARGINWIDTH="0">
<?
	

/* Replace EEL TAG */
//- - PDF format.. {PDF}file.pdf{/PDF}
		$pdfObjBegin="<OBJECT id='Acrobat Control for ActiveX' height=550 width=100% border=1 classid=CLSID:CA8A9780-280D-11CF-A24D-444553540000><PARAM NAME='_Version' VALUE='327680'><PARAM NAME='_ExtentX' VALUE='18812'><PARAM NAME='_ExtentY' VALUE='14552'><PARAM NAME='_StockProps' VALUE='0'><PARAM NAME='SRC' VALUE=\"".$config['courseurl'].'/'.$courseid.'/';
		$pdfObjEnd="></OBJECT>";
		$lessonhtml = preg_replace("/{pdf}(.*?){\/pdf}/si", "$pdfObjBegin\\1\"$pdfObjEnd", $lessonhtml) ;
		$lessonhtml = preg_replace("/{PDF}(.*?){\/PDF}/si", "$pdfObjBegin\\1\"$pdfObjEnd", $lessonhtml) ;

//- - Flash {SWF}file.swff{/SWF}
		$swfObjBegin1="<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'  id='Lesson'> <PARAM NAME=movie VALUE=\"".$config['courseurl'].'/'.$courseid.'/';
		$swfObjBegin2="> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src=\"".$config['courseurl'].'/'.$courseid.'/';
		$swfObjEnd=" quality=high bgcolor=#FFFFFF  NAME='Lesson' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED>";
		$lessonhtml = preg_replace("/{swf}(.*?){\/swf}/si", "$swfObjBegin1\\1\"$swfObjBegin2\\1\"$swfObjEnd", $lessonhtml) ;
		$lessonhtml = preg_replace("/{SWF}(.*?){\/SWF}/si", "$swfObjBegin1\\1\"$swfObjBegin2\\1\"$swfObjEnd", $lessonhtml);

// - - WMV - live
		$wmvObjBegin="<object id=MediaPlayer type=application/x-oleobject height=252 width=320 classid=CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6><param name=\"URL\" value=\"";
		$wmvObjEnd='"><param name="AutoStart" value="true"><param name="ShowControls" value="false"><param name="ShowStatusBar" value="true"><param name="AutoSize" value="ture"><param name="uiMode" value="mini"></object>';
		$lessonhtml = preg_replace("/{wml}(.*?){\/wml}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $lessonhtml) ;
		$lessonhtml = preg_replace("/{WML}(.*?){\/WML}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $lessonhtml) ;
//- -  WMV
		$wmvObjBegin="<object id=MediaPlayer type=application/x-oleobject height=252 width=320 classid=CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6><param name=\"URL\" value=\"".$config['courseurl'].'/'.$courseid.'/';
		$wmvObjEnd='"><param name="AutoStart" value="true"><param name="ShowControls" value="false"><param name="ShowStatusBar" value="true"><param name="AutoSize" value="ture"><param name="uiMode" value="mini"></object>';
		$lessonhtml = preg_replace("/{wmv}(.*?){\/wmv}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $lessonhtml) ;
		$lessonhtml = preg_replace("/{WMV}(.*?){\/WMV}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $lessonhtml) ;

			if ($page=="") $page=1;
			$output = gotoPage($lessonhtml,$page);		

			
			echo "<DIV ALIGN=RIGHT>";
			menuPageNext($lessonhtml,$courseid,$scheduleid,$lessonid,$page);
			echo "</DIV>";
			
			echo $output;
			
			echo "<BR><TABLE WIDTH=100%><TR><TD ALIGN=center>";
			menuPage($lessonhtml,$courseid,$scheduleid,$lessonid,$page);
			echo "&nbsp;</TD></TR></TABLE><BR>";
		}

		// PDF extension
		else if (strtolower($ext) == 'pdf') {
			$pdfObj="<CENTER><OBJECT id='Acrobat Control for ActiveX' height=550 width=100% border=1 classid=CLSID:CA8A9780-280D-11CF-A24D-444553540000><PARAM NAME='_Version' VALUE='327680'><PARAM NAME='_ExtentX' VALUE='18812'><PARAM NAME='_ExtentY' VALUE='14552'><PARAM NAME='_StockProps' VALUE='0'><PARAM NAME='SRC' VALUE=\"".$config['courseurl'].'/'.$courseid.'/'.$lessonfile."\"></OBJECT></CENTER>";
			echo $pdfObj;
		}
		
		// Image extension
		else if (strtolower($ext) == 'jpg' || strtolower($ext) == 'gif' || strtolower($ext) == 'png') {
			$imageObj="<CENTER><img src=\"".$config['courseurl'].'/'.$courseid.'/'.$lessonfile."\" border=0></OBJECT></CENTER>";
			echo $imageObj;
		}

		// windown movie extension
		else if (strtolower($ext) == 'wmv' || strtolower($ext) == 'asf' || strtolower($ext) == 'mpg' || strtolower($ext) == 'avi' || strtolower($ext) == 'mp3' || strtolower($ext) == 'wav' ) {

			?>
			<!-- Check Media Player Version -->

			<CENTER><BR><BR>
			<TABLE cellpadding=0 cellspacing=10 border=0 bgcolor="#CCCCCC">
			<TR>
				<TD bgcolor="#FFFFFF">
				<SCRIPT LANGUAGE="JavaScript">

			var WMP7;

			if ( navigator.appName != "Netscape" ){   
				 WMP7 = new ActiveXObject('WMPlayer.OCX');
			}

			// Windows Media Player 7 Code
			if ( WMP7 )
			{
				 document.write ('<OBJECT ID=MediaPlayer ');
				 document.write (' CLASSID=CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6');
				 document.write (' standby="Loading Microsoft Windows Media Player components..."');
				 document.write (' TYPE="application/x-oleobject" width="320" height="290">');
				 document.write ('PARAM NAME="stretchToFit" VALUE="true"><PARAM NAME="url" VALUE="<? echo $config['courseurl'].'/'.$courseid.'/'.$lessonfile; ?>">');
				 document.write ('<PARAM NAME="AutoStart" VALUE="true">');
				 document.write ('<PARAM NAME="ShowControls" VALUE="1">');
				 document.write ('<PARAM NAME="uiMode" VALUE="mini">');
				 document.write ('</OBJECT>');
			}

			// Windows Media Player 6.4 Code
			else
			{
				 //IE Code
				 document.write ('<OBJECT ID=MediaPlayer ');
				 document.write ('CLASSID=CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95 ');
				 document.write ('CODEBASE=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715 ');
				 document.write ('standby="Loading Microsoft Windows Media Player components..." ');
				 document.write ('TYPE="application/x-oleobject">');
				 document.write ('<PARAM NAME="FileName" VALUE="<? echo $config['courseurl'].'/'.$courseid.'/'.$lessonfile; ?>">');
				 document.write ('<PARAM NAME="AutoStart" VALUE="true">');
				 document.write ('<PARAM NAME="ShowControls" VALUE="1">');

				 //Netscape code
				 document.write ('    <Embed type="application/x-mplayer2"');
				 document.write ('        pluginspage="http://www.microsoft.com/windows/windowsmedia/"');
				 document.write ('        filename="<? echo $config['courseurl'].'/'.$courseid.'/'.$lessonfile; ?>"');
				 document.write ('        src="<? echo $config['courseurl'].'/'.$courseid.'/'.$lessonfile; ?>"');
				 document.write ('        Name=MediaPlayer');
				 document.write ('        ShowControls=1');
				 document.write ('        ShowDisplay=1');
				 document.write ('        ShowStatusBar=1');
				 document.write ('        ');
				 document.write ('        >');
				 document.write ('    </embed>');

				 document.write ('</OBJECT>');
			}

			</SCRIPT></TD>
			</TR>
			</TABLE>
			<BR><BR><FONT face="ms sans serif" SIZE="1"><B><A HREF="<? echo $config['courseurl'].'/'.$courseid.'/'.$lessonfile; ?>" target="_blank">Click here to open new window</A></B></FONT>
			</CENTER>

			<?
			}	
			
		// others format
		else {
			header("location:$config[homeurl]/$config[courseurl]/$courseid/$lessonfile");
		}
	}
}


class MyHandler {
    function MyHandler(){}
    function openHandler(& $parser,$name,$attrs) {
		global $my_files;

		$elements = array(	'img'		=> 'src',
							'a'			=> 'href',
							'object'	=> 'data',
							'applet'	=> 'classid',
							'link'		=> 'href',
							'script'	=> 'src',
							'form'		=> 'action',
							'input'		=> 'src',
							'iframe'	=> 'src',
							'frame'	=> 'src',
							'embed'	=> 'src',
							'param'		=> 'value');

		if (isset($elements[strtolower($name)])) { // set name to lower
				if (strtolower($name) == 'param' && $attrs['NAME'] != 'SRC') {
					return;
				}
				if ($attrs[$elements[strtolower($name)]] != '') { //lowercase attribute
					$my_files[] = $attrs[$elements[strtolower($name)]];
//						$my_files = array_intersect($my_files,$attrs[$elements[strtolower($name)]]);
				}
				else if ($attrs[strtoupper($elements[strtolower($name)])] != ''){	//uppercase attribute
					$my_files[] = $attrs[strtoupper($elements[strtolower($name)])];
//						$my_files = array_intersect($my_files,$attrs[strtoupper($elements[strtolower($name)])]);
				}
		}
    }

    function closeHandler(& $parser,$name) { }
}


/**
* show content
*/
function showContent($file,$path) {
//echo $file,$path;
		global $my_files;

		$FILE=@file($file);
		for ($i=0;$i<count($FILE);$i++) {
			$texthtml .= $FILE[$i];
		}

		$handler=new MyHandler();
		$parser =& new XML_HTMLSax();
		$parser->set_object($handler);
		$parser->set_element_handler('openHandler','closeHandler');
		$parser->parse($texthtml);

		$files=array();
		$my_files = @array_unique($my_files);
		if (!empty($my_files[0])) {
			foreach ($my_files as $file) {
				/* filter out full urls */
				 $url_parts = @parse_url($file);
				if (isset($url_parts['scheme'])) {
					continue;
				}
				if (eregi('editor/',$url_parts['path'])) {
					continue;
				}
				$scourl = $url_parts['path'].'"';
				$newscourl = $scourl;  // echo $path.'/'.$scourl; 
				//echo  $newscourl;      
				if ($scourl != "t_index.php") {
					$texthtml = str_replace($scourl,$newscourl,$texthtml);
				}

				$scourl = $url_parts['path']."'";
				$newscourl = $scourl;            //      $path.'/'.$scourl;
				if ($scourl != "t_index.php") {
					 $texthtml = str_replace($scourl,$newscourl,$texthtml);
				} 

			}
		}
		
		$my_files =  array();
		$path = '';
		return $texthtml;
}


/**
* Find Lesson Order
*/
function lessonOrder($id,$courseid) {
	global $config;

	$sql = "select LessonID FROM $config[tablelesson]" ;
	$sql .=" WHERE CourseID='$courseid' ORDER BY LessonID";
	$result=db_select($sql);
	for($i=1;list($lessonidorder) = mysql_fetch_row($result);$i++) {
		if ($lessonidorder==$id)
			return $i;
	}
}


/**
* break page
*/
function gotoPage($lessonhtml,$page) {
	global $config;
	
	$pagehtml=explode($config['breakpage'],$lessonhtml);
	if (count($pagehtml) <= 1) {
		$pagehtml=explode('<!--BREAK-->',$lessonhtml);
	}
	return $pagehtml[$page-1];
}


/**
* show page
*/
function menuPage($lessonhtml,$courseid,$schedulingid,$lessonid,$page) {
	global $config;

	$pagehtml=explode($config['breakpage'],$lessonhtml);
	if (count($pagehtml) <= 1) {
		$pagehtml=explode('<!--BREAK-->',$lessonhtml);
	}
	if (count($pagehtml) > 1) {
		$prepage=$page-1;
		$nextpage=$page+1;
		echo "&nbsp;<B>Page :</B> ";
		if ($page != 1)
			echo "[<A class=active HREF=\"index.php?action=lessonshowcontent&scheduleid=$schedulingid&lessonid=$lessonid&courseid=$courseid&page=$prepage\" title=\"Back\">&lt;&lt;</A>]&nbsp;";
		
		for ($i=1; $i <= count($pagehtml); $i++) {
			if ($i == $page) 
				echo"$i&nbsp;&nbsp;";
			else
				echo "<A class=active HREF=\"index.php?action=lessonshowcontent&scheduleid=$schedulingid&lessonid=$lessonid&courseid=$courseid&page=$i\" title=\"Page $i\">$i</A>&nbsp;&nbsp;";
		}

		if ($nextpage < $i)
		echo "[<A class=active HREF=\"index.php?action=lessonshowcontent&scheduleid=$schedulingid&lessonid=$lessonid&courseid=$courseid&page=$nextpage\" title=\"Next\">&gt;&gt;</A>]&nbsp;&nbsp;";
	}	
}


/**
* show page next
*/
function menuPageNext($lessonhtml,$courseid,$schedulingid,$lessonid,$page) {
	global $config;

	
	$pagehtml=explode($config['breakpage'],$lessonhtml);
	if (count($pagehtml) <= 1) {
		$pagehtml=explode('<!--BREAK-->',$lessonhtml);
	}
	$totalpage = count($pagehtml);
	if (count($pagehtml) > 1) {
		$prepage=$page-1;
		$nextpage=$page+1;
		if ($page != 1) {
			echo "<A HREF=\"index.php?action=lessonshowcontent&scheduleid=$schedulingid&lessonid=$lessonid&courseid=$courseid&page=$prepage\"><IMG  align=absmiddle SRC='images/previous.gif' WIDTH=28 HEIGHT=25 ALT='Previous' BORDER=0></A>";
		}

		if ($page !=1 && $page != $totalpage){
			echo "<B> -$page- </B>";
		}

		if ($nextpage <= count($pagehtml)) {
			echo "<A HREF=\"index.php?action=lessonshowcontent&scheduleid=$schedulingid&lessonid=$lessonid&courseid=$courseid&page=$nextpage\"><IMG SRC='images/next.gif' WIDTH=28 HEIGHT=25 ALT='Next' BORDER=0 align=absmiddle></A>&nbsp;&nbsp;";
		}
	}	
}

/*- - - แสดงบทเรียนที่เปิดสอนแล้ว - - - -*/
function	gotoLesson($courseid,$schedulingid,$lessonid) {
	global $config,$lang,$usersess;
	
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

	echo "<B>".$lang['gotolesson']."</B>: <SELECT NAME=lessonid onchange=\"window.open(this.options[this.selectedIndex].value,'_self')\">";
	printLesson3($courseid,0,array(),$lessonid);
	echo "</SELECT>";

}


/**
* print tree
*/
function printLesson3($courseid,$parent,$orderings=array(),$lid) {
	global $config,$lang, $usersess;
	global $start,$scheduleid;
	static $cnt=0;

// List lessons	
	$sql = "SELECT LessonID,LessonTitle,Abstract,Length,LessonParentID,Ordering FROM $config[tablelesson]";
	$sql .= " WHERE CourseID='$courseid' AND LessonParentID='$parent' ORDER BY LessonParentID,Ordering";
	$result=db_select($sql);
	$select[$lid]='selected';
	for($i=1;list($lessonid,$title,$abstract,$length,$parent,$ordering) = mysql_fetch_row($result);$i++) {
		$title=stripslashes($title); $title=htmlspecialchars($title);
		$abstract=stripslashes($abstract); $abstract=nl2br($abstract);
		array_push($orderings,$ordering);
		$show_item=join('.',$orderings);
		for($blank='',$j=0;$j<strlen($show_item);$j++) $blank .= '&nbsp;&nbsp;';

		if (($scheduleid && CheckStarted($start))  || $usersess->get_var("admin") || checkInst($courseid)  || (!isScheduleBased($courseid) && $usersess->get_var("nickname"))) { 
			echo "<OPTION ".$select[$lessonid]." VALUE=index.php?action=lessonshow&scheduleid=$scheduleid&lessonid=$lessonid>$blank$show_item. $title</OPTION>";
		}

		// shift start date with lesson length
		$start=dateAdd($start,$length+1);

		printLesson3($courseid,$lessonid,$orderings,$lid);
		
		array_pop($orderings);
	}

}



/**
* Quiz Show
*/
function quizShow() {
	global $config,$lang,$usersess;
	global $scheduleid,$lessonid,$courseid,$printversion;

	// หาวันเปิดเรียนของ $scheduleid
	$sql = "SELECT s.Start, l.LessonID,l.Length,l.Quiztitle FROM $config[tablelesson] l, $config[tablescheduling] s";
	$sql .= " WHERE  l.CourseID=s.CourseID and s.SchedulingID='$scheduleid' order by l.LessonID";
	$result=db_select($sql);
	for($i=0;list($begin,$lesson,$length,$mquestion) = mysql_fetch_row($result);$i++) {
		if (!$i) $start=$begin;

		if ($lesson == $lessonid)
			break;
		else 
			$start=dateAdd($start,$length+1);
	}

	if ( checkStarted($start) || $usersess->get_var('admin') ||  checkInst($courseid)) {

		$desc="<B>$lang[quiz]: $title</B><BR>$lang[quizdesc]";
		viewMenu("Lesson",$courseid,$scheduleid,$desc);

	// LIST Question

		$quiztitle = db_getvar($config['tablelesson'],"LessonID='$lessonid'","QuizTitle");
		$quiztitle = stripslashes($quiztitle);
		$quiztitle = nl2br($quiztitle);

		$sql = "SELECT * FROM $config[tablequiz] where LessonID='$lessonid' ORDER BY QuizID";
		$result=db_select($sql);
		
		echo "<TABLE WIDTH=98%  height=320 cellspacing=1 celpadding=0 class=form>";
		echo "<TR VALIGN=TOP><TD bgcolor=#FFFFFF><BR>&nbsp;";
		echo "<B>".$quiztitle."</B><P>";
		echo "<TABLE WIDTH=100% cellspacing=0 celpadding=0>";
		echo "<FORM METHOD=POST ACTION=\"index.php\">";
		echo "<INPUT TYPE=\"hidden\" name=action value=quizcheck>";
		echo "<INPUT TYPE=\"hidden\" name=courseid value=$courseid>";
		echo "<INPUT TYPE=\"hidden\" name=scheduleid value=$scheduleid>";
		echo "<INPUT TYPE=\"hidden\" name=lessonid value=$lessonid>";
	
		
		for($n=1;list($quizid, $lessonid_temp, $question, $answer, $text[1], $desc[1], $text[2], $desc[2], $text[3], $desc[3],$text[4], $desc[4], $text[5], $desc[5], $text[6], $tdesc[6], $type) = mysql_fetch_row($result);$n++) {
			$squestion=stripslashes($question);
			$squestion=nl2br($squestion);
			$squestion=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$squestion);
			$squestion=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$squestion);

			echo "<INPUT TYPE=hidden name=quizid value=$quizid>";
			echo "<TR bgcolor=#FFFFFF><TD valign=top width=20>&nbsp;</TD><TD><B>$squestion</B></TD>";
			echo "<TR bgcolor=#FFFFFF><TD></TD><TD>";
			echo "<TABLE>";
			for ($i=1;$i<=$config['choice'];$i++)
				if ($text[$i]) {
					$showtext=stripslashes($text[$i]);
					$showtext=nl2br($showtext);
					$showtext=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$showtext);
					$showtext=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$showtext);

					echo "<TR><TD>";
					if ($type =="checkbox") 
						echo "<INPUT TYPE=$type name=ans[$quizid][$i] value=".pow(2,$i-1).">". $lang['choice'][$i].". $showtext";
					elseif ($type=="radio")
						echo "<INPUT TYPE=$type name=ans[$quizid][0] value=".pow(2,$i-1).">". $lang['choice'][$i].". $showtext";
					echo "</TD></TR>";
				}
			echo "</TABLE><P>";
			echo "</TD></TR>";
		}
		echo "</TABLE><P>";
		echo "</TD></TR></TABLE>";
		echo "<BR><CENTER><INPUT TYPE=submit VALUE='$lang[button_checkscore]' CLASS=button></CENTER></FORM><P> ";
	}
//	echo "<P>";
	viewLessonMenu($courseid,$scheduleid,$lessonid,"");
}


/*- - - เฉลยคำตอบและให้คะแนน - - -*/
function quizCheck () {
	global $config,$lang,$usersess;
	global $scheduleid,$lessonid,$courseid,$printversion,$ans;

	$qdesc="<B>$lang[quiz]:</B> $lang[result]";
	viewMenu("Lesson",$courseid,$scheduleid,$qdesc);

	$sql = "SELECT * FROM $config[tablequiz] where LessonID='$lessonid'";
	$result=db_select($sql);
	
	echo "<TABLE WIDTH=98% cellspacing=1 celpadding=0 class=form>";
	
	for($sum=0, $n=1;list($quizid, $lessonid_temp, $question, $answer, $text[1], $desc[1], $text[2], $desc[2], $text[3], $desc[3],$text[4], $desc[4], $text[5], $desc[5], $text[6], $tdesc[6], $type) = mysql_fetch_row($result);$n++) {
		$showquestion=stripslashes($question);
		$showquestion=nl2br($showquestion);
		$showquestion=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$showquestion);
		$showquestion=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$showquestion);
		echo "<TR height=18><TD class=head><B>$showquestion</B></TD>";
		echo "<TR bgcolor=#FFFFFF>";
		echo "<TD>";
		echo "<TABLE>";
		$correct_answer="";
		for ($i=1;$i<=$config['choice'];$i++) {
			if ($answer & pow(2,($i-1))) {
				$bold="<font color=#009900><B>";
				$correct_answer .=$lang['choice'][$i];
			}
			else
				$bold="";

			if ($text[$i]) {
				$showtext=stripslashes($text[$i]);
				$showtext=nl2br($showtext);
				$showtext=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$showtext);
				$showtext=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$showtext);
				echo "<TR><TD>$bold". $lang['choice'][$i].". $showtext </B></font>";
			}
			if ($desc[$i]) {
					$showdesc=stripslashes($desc[$i]);
					$showdesc=nl2br($showdesc);
					$showdesc=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$showdesc);
					$showdesc=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$showdesc);
					echo " - <FONT SIZE=1 COLOR=#009900>$showdesc</FONT>";
			}
			if ($text[$i]) {
				echo "</TD></TR>";
			}
		}
		echo "</TABLE>";

		$youchoose="";

		// for multiple choice test
		for ($choose=0,$i=0;$i<=$config['choice'];$i++){
			$choose += $ans[$quizid][$i];
			
			if ($ans[$quizid][$i] & pow(2,$i-1)) 
					$youchoose .= $lang['choice'][$i] ." ";  // for multiple choice test
			else if ($ans[$quizid][0] & pow(2,$i-1))
					$youchoose = $lang['choice'][$i] ; // for sigle choice test
		}

		if ($youchoose == "") {
			echo "<FONT COLOR=#FF0000><B>? $lang[noanswer]</B></FONT>";
		}
		else {
			if ($answer == $choose) {
				echo "<img src='images/passed.gif'> <font color=#009900><B>$lang[correct]";
				$sum++;
			}
			else 
				echo "<img src='images/wrong.gif'> <font color=#FF0033><B>$lang[youchoose] '$youchoose' $lang[incorrect]!! ";
		}

		echo "<P>";
		echo "</TD></TR>";
	}
	
	echo "</TABLE><P>";

	$score = $sum/($n-1)*100;
	$score = number_format($score,"2",".",",");
	echo "$lang[yourscore] <B>$score %</B><P>";
	if ($score < $config['highscore']) {
		echo "<FONT COLOR=#FF0000>$lang[notpass]</FONT><P>";
	}
	// insert quiz score
	$sql = "INSERT INTO $config[tablescore] (Nickname, LessonID, SchedulingID, Score) ";
	$sql .= "VALUES ('".$usersess->get_var("nickname")."','$lessonid','$scheduleid','$score')";
	db_query($sql);
	
	$i=lessonOrder($lessonid,$courseid);
	update_event($usersess->get_var("nickname"),"Quiz $courseid-$scheduleid: Lesson $i score $score %");

	viewLessonMenu($courseid,$scheduleid,$lessonid,"");

}


/*- - - แสดงแบบฝึกหัด - - -*/
function assignmentshow() {
	global $config,$lang;
	global $lessonid,$scheduleid,$courseid,$printversion;

	$sql = "SELECT Title, Question FROM $config[tableassignment] where LessonID='$lessonid'";
	$result=db_select($sql);
	list($title,$question) = mysql_fetch_row($result);
	$title = stripslashes($title);
	$question = stripslashes($question);
	$question=nl2br($question);
	$question=str_replace('src="','src="'.$config['courseurl'].'/'.$courseid.'/',$question);
	$question=str_replace('SRC="','SRC="'.$config['courseurl'].'/'.$courseid.'/',$question);

	$desc="<B>$lang[assignment] $title</B><BR>$lang[assdesc]";
	viewMenu("Lesson",$courseid,$scheduleid,$desc);

	echo "<TABLE WIDTH=98% HEIGHT=320 CELLSPACING=1 CELLPADDING=5 class=form><TR VALIGN=TOP><TD bgcolor=#FFFFFF>";
	echo "$question";
	echo "</TD></TR></TABLE>";


	viewLessonMenu($courseid,$scheduleid,$lessonid,"");
}


/*- - - เมนูของบทเรียน- - - -*/
function viewLessonMenu($courseid,$scheduleid,$lessonid,$helpdesc) {
	global $config,$action;

		echo "<TABLE WIDTH=98% CELLPADDING=0 CELLSPACING=0><TR><TD ALIGN=RIGHT>";
		echo "<A HREF=\"index.php?action=viewlesson&courseid=$courseid&scheduleid=$scheduleid\"><img src=theme/".$config['theme']."/button/".$config['language']."/back_content.jpg border=0 ></A>";
		echo "<A HREF=\"index.php?action=lessonshow&lessonid=$lessonid&scheduleid=$scheduleid\"><img src=theme/".$config['theme']."/button/".$config['language']."/lesson.jpg border=0 ></A>";
		if (isScheduleBased($courseid)) { 		
				$asstitle = db_getvar($config['tableassignment'],"LessonID='$lessonid'","Title");
				if ($asstitle) {
					echo "&nbsp;<A HREF=\"index.php?action=assignmentshow&courseid=$courseid&scheduleid=$scheduleid&lessonid=$lessonid\"><img src=theme/".$config['theme']."/button/".$config['language']."/exercise.jpg border=0 ><A>";
				}
				$has_quiz = db_getvar($config['tablequiz'],"LessonID=$lessonid","QuizID");
				if ($has_quiz) {
					echo "&nbsp;<A HREF=\"index.php?action=quizshow&courseid=$courseid&scheduleid=$scheduleid&lessonid=$lessonid\"><img src=theme/".$config['theme']."/button/".$config['language']."/test.jpg border=0 ></A>";
				}
		}
		echo "</TD></TR></TABLE><P>";
}

?>