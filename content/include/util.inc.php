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
//
function B2C($date) {  // เปลี่ยนจาก พ.ศ เป็น ค.ศ.
	list($d,$m,$y)=explode("-",$date);
	$y-=543;
	$convertdate=$y.'-'.$m.'-'.$d;
	return $convertdate;
}

//============================================================================
function C2TH($date,$type) { 
	list($y,$m,$d)=explode("-",$date);
	$months=array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$y+=543-2500;
	if ($type) 
		$convertdate=(int)$d.' '.$months[(int)$m].' '.$y;
	else
		$convertdate=(int)$d.' '.$months[(int)$m].' ';

	return $convertdate;
}

//=============================================================================
function dateAdd($date, $length){  // DP
	$length-=1;
	$timestamp = strtotime($date);
	$enddate = strtotime("+$length day",$timestamp);
	$d = strftime("%d",$enddate);
	$m = strftime("%m",$enddate);
	$y = strftime("%Y",$enddate);
	$a=$y.'-'.$m.'-'.$d;
	return $a;
}

//=============================================================================
function thaiDateDuration($start,$length) { //THDP
	$enddate=dateADD($start,$length);
	$thstartdate=C2TH($start,0);
	$thenddate=C2TH($enddate,1);
	$ret=$thstartdate." - ".$thenddate;

	return $ret;
}

//=============================================================================
function thaiDateStart($start,$length) { 
	$enddate=dateADD($start,$length);
	$thenddate=C2TH($enddate,1);

	return $thenddate;
}

//=============================================================================
function checkStarted($date) { //POSTED
	$curtimestamp = strtotime(date(0));
	$datetimestamp = strtotime($date);
	if ($curtimestamp >= $datetimestamp) 
		return 1;
	else
		return 0;
}


/*- - - ตรวจสอบว่าเป็นผู้สอนในหลักสูตร - - - -*/
function checkInst($cid) {
	global $usersess,$config;
	
	$sql="SELECT count(*) FROM $config[tablescheduling] WHERE instructor='".$usersess->get_var("nickname")."' and CourseID='$cid'";
	$result=db_select($sql);
	$schedulecount = mysql_fetch_row($result);

	$sql="SELECT count(*) FROM $config[tablecourse] WHERE Creator='".$usersess->get_var("nickname")."' and CID='$cid'";
	$result=db_select($sql);
	$coursecount = mysql_fetch_row($result);

	if ($coursecount[0] !=0)
		return 1;
	if ($schedulecount[0] !=0)
		return 1;
	else 
		return 0;
}

/*- - - ตรวจสอบว่าเป็นผู้เรียนให้ตารางสอนนั้น - - - -*/
function checkauth($sch) {
	global $config,$usersess;
	
	$sql="SELECT e.Nickname, e.Status, u.level From $config[tableenroll] e, $config[tableuser] u ";
	$sql .=" WHERE e.SchedulingID='$sch' and e.Nickname='".$usersess->get_var("nickname")."' ";
	$sql .=" and e.Nickname=u.Nickname";
	$result=db_select($sql);
	list($nickname,$status,$level) = mysql_fetch_row($result);
	if ($nickname != "" && $status == 0)
		 return 1;
	else
		 return 0;

}

/* check schedule base */
function isScheduleBased($courseid) {
	global $config;

	$ret = db_getvar($config['tablecourse'],"CID='$courseid' AND CourseType='0'","CID");
	
	return $ret;
}


//###################################################################################
function sql_to_unix_time($timeString) { 
	return mktime(substr($timeString, 8,2), substr($timeString, 10,2), substr($timeString, 12,2), substr($timeString,4,2), substr($timeString, 6,2), substr($timeString, 0,4)); 
}

?>