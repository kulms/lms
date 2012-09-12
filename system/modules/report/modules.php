<? 
require ("../include/global_login.php");
require "header.php";
$user_type=$report->getCatId();
if (empty($page)){
   $page=1;
}
if($courses != "")
	$course="&courses=$courses";

if($order=="")
	$order='time DESC';
else
	$order=$order;
	
if($filter=="")
	$filter="";
else
	$filter=$filter;
	
$action='modules';
?>
<SCRIPT LANGUAGE='javascript' src='popcalendar.js'></SCRIPT>
<SCRIPT LANGUAGE='javascript' src='verify.js'></SCRIPT>
<form name="allTime" method="post" action="?m=report&a=modules&filter='time'&user_type=<? echo $user_type?><? echo $course?>"onSubmit="return checkdate(this)">
<input type="hidden" name="filter" value="time" >
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr><td colspan="2">
<b><? echo $user->_($strSystem_RMenuModules);?></b>
</td></tr>
  <tr>
    <td height="28" colspan="2"><strong><? echo $user->_($strSystem_RHeader);?></strong> : <a href="?m=report&a=modules&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_RMenuAll);?></a> | 
	<a href="?m=report&a=modules&filter=folder&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_MReportFolder);?></a> | 
	<a href="?m=report&a=modules&filter=group&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_MReportGroup);?></a> | 
	<a href="?m=report&a=modules&filter=forum&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_MReportForum);?></a> | 
	<a href="?m=report&a=modules&filter=webboard&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_MReportWebboard);?></a> | 
	<a href="?m=report&a=modules&filter=resources&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_MReportResources);?></a> |
	 <a href="?m=report&a=modules&filter=quiz&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_MReportQuiz);?></a> | 
	 <a href="?m=report&a=modules&filter=hw&user_type=<? echo $user_type?><? echo $course?>"><? echo $user->_($strSystem_MReportHW);?></a> |
	 </td>
  </tr>
  <tr>
    <td><? echo $user->_($strSystem_LabReportTime);?>
      <input type="text" name="beTime" value="<? if($beTime!="") echo $beTime?>" class="text" size="10" onFocus="this.blur();">
      <script language='javascript'>
											<!--
											  if (!document.layers) {
												document.write("<img id=aa  src=images/date.gif align=absmiddle border=0 onClick='popUpCalendar(this, allTime.beTime, \"dd-mm-yyyy\")' style=cursor: pointer;>")
											}
											//-->
										  </script>
&nbsp;&nbsp; <? echo $user->_($strSystem_LabReportTo);?>&nbsp;&nbsp;
<input type="text" name="endTime" class="text" size="10" onFocus="this.blur();" value="<? if($endTime!="") echo $endTime?>">
&nbsp;&nbsp;
<script language='javascript'>
											<!--
											  if (!document.layers) {
												document.write("<img id=aa  src=images/date.gif align=absmiddle border=0 onClick='popUpCalendar(this, allTime.endTime, \"dd-mm-yyyy\")' style=cursor: pointer;>")
											}
											//-->
										  </script>
<input type="submit" value="<? echo $user->_($strSystem_RHeader);?>" name="submit" class="button"></td>
   <td align="right"><img src="./modules/report/images/print.gif" border="0"><a href="Javascript:NewWin('print_report','<? echo $filter?>','<? echo $beTime ?>','<? echo $endTime ?>','<? echo $order?>','<? echo $courses ?>','<? echo $user_type?>','<? echo $action?>')"><? echo $user->_($strSystem_LabUserPrint); ?></a></td>
  </tr>
</table>
</form>
<table width="90%"  border="0" cellspacing="1" cellpadding="0" align="center"  class="tdborder1">
  <tr class="boxcolor">
    <td width="23%" align="center"><a  class="a13" href="Javascript:OrderBy('modules','<? echo $filter?>','<? echo $beTime ?>','<? echo $endTime ?>','<? echo $page?>','time','<? echo $courses ?>','<? echo $user_type?>');"><? echo $user->_($strSystem_ListReportTime);?></a></td>
    <td width="29%" align="center"><a  class="a13" href="Javascript:OrderBy('modules','<? echo $filter?>','<? echo $beTime ?>','<? echo $endTime ?>','<? echo $page?>','login','<? echo $courses ?>','<? echo $user_type?>');"><? echo $user->_($strSystem_ListReportName);?></a></td>
    <td width="16%" align="center" class="main_white"><? echo $user->_($strSystem_ListReportAction);?></td>
    <td width="16%" align="center" class="main_white"><? echo $user->_($strSystem_ListReportModules);?></td>
    <td width="16%" align="center" class="main_white"><? echo $user->_($strSystem_ListReportCourses);?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="5" align="center" class="hilite">
      <?php
	  //echo $filter;
			$user=$person["id"];
			$row = $report->SelectReportAll($user,$filter,$order,$courses,$beTime,$endTime,$action,$user_type);
			$row_page = $report->SelectUsersPerPage($row,$page);
			$report->ShowTableAll($row_page,$order);
		?>
</td>
  </tr>
  <tr>
    <td colspan="5">
      <? $report->ShowSeqTable($row,$page,$action,$filter,$beTime,$endTime,$order,$courses,$user_type);?>
    </td>
  </tr>
</table>
<? mysql_close();?>