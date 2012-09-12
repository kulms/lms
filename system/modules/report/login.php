<? 
require ("../include/global_login.php");
require "header.php";
$user_type=$report->getCatId();
if (empty($page)){
   $page=1;
}
if($order=="")
	$order='time DESC';
else
	$order=$order;
$action='login';
?>
<SCRIPT LANGUAGE='javascript' src='popcalendar.js'></SCRIPT>
<SCRIPT LANGUAGE='javascript' src='verify.js'></SCRIPT>
<SCRIPT LANGUAGE='javascript'>
	function OrderBy(a,f,bt,et,p,o,c,ut){
	window.location="?m=report&a="+a+"&filter="+f+"&beTime="+bt+"&endTime="+et+"&page="+p+"&order="+o+"&courses="+c+"&user_type="+ut+" ";
	}
</SCRIPT>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<br>
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<form name="allTime" method="post" action="?m=report&a=login&filter='time'&user_type=<? echo $user_type?>" onSubmit="return checkdate(this)">
<input type="hidden" name="filter" value="time" >
<input type="hidden" name="BTime1" value="<? $beTime ?>" >
<input type="hidden" name="ETime1" value="<? $endTime?>" >
<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td colspan="2">
<b><? echo $user->_($strSystem_RMenuLogin);?></b>
</td></tr>
  <tr>
    <td><strong><? echo $user->_($strSystem_RHeader);?></strong> : <a href="?m=report&a=login&user_type=<? echo $user_type?>"><? echo $user->_($strSystem_RMenuAll);?></a> | <? echo $user->_($strSystem_LabReportTime);?><input type="text" name="beTime" value="<? if($beTime!="") echo $beTime?>" class="text" size="10" onFocus="this.blur();"> 
        <script language='javascript'>
											<!--
											  if (!document.layers) {
												document.write("<img id=aa  src=images/date.gif align=absmiddle border=0 onClick='popUpCalendar(this, allTime.beTime, \"dd-mm-yyyy\")' style=cursor: pointer;>")
											}
											//-->
										  </script>
	&nbsp;&nbsp; <? echo $user->_($strSystem_LabReportTo);?>&nbsp;&nbsp; 
	<input type="text" name="endTime" class="text" size="10" onFocus="this.blur();" value="<? if($endTime!="") echo $endTime?>">&nbsp;&nbsp;
	 <script language='javascript'>
											<!--
											  if (!document.layers) {
												document.write("<img id=aa  src=images/date.gif align=absmiddle border=0 onClick='popUpCalendar(this, allTime.endTime, \"dd-mm-yyyy\")' style=cursor: pointer;>")
											}
											//-->
										  </script>
										  <input type="submit" value="<? echo $user->_($strSystem_RHeader);?>" name="submit" class="button">	</td>
    <td align="right"><img src="./modules/report/images/print.gif" border="0"><a href="Javascript:NewWin('print_report','<? echo $filter?>','<? echo $beTime ?>','<? echo $endTime ?>','<? echo $order?>','<? echo $courses ?>','<? echo $user_type?>','<? echo $action?>')"><? echo $user->_($strSystem_LabUserPrint); ?></a></td>
  </tr>
</table>
</form>
<table width="90%"  border="0" cellspacing="1" cellpadding="0" align="center" class="tdborder1">
  <tr  class="boxcolor">
    <td width="23%" align="center"><a class="a13" href="Javascript:OrderBy('login','<? echo $filter?>','<? echo $beTime ?>','<? echo $endTime ?>','<? echo $page?>','time','<? echo $courses ?>','<? echo $user_type?>');"><? echo $user->_($strSystem_ListReportTime);?></a></td>
    <td width="29%" align="center"><a class="a13" href="Javascript:OrderBy('login','<? echo $filter?>','<? echo $beTime ?>','<? echo $endTime ?>','<? echo $page?>','login','<? echo $courses ?>','<? echo $user_type?>');"><? echo $user->_($strSystem_ListReportName);?></a></td>
    <td width="16%" align="center" class="main_white"><? echo $user->_($strSystem_ListReportAction);?></td>
    <td width="16%" align="center" class="main_white"><? echo $user->_($strSystem_ListReportModules);?></td>
    <td width="16%" align="center" class="main_white"><? echo $user->_($strSystem_ListReportCourses);?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="5" align="center" class="hilite">
      <?php
			$user=$person["id"];
			$row = $report->SelectReportAll($user,$filter,$order,$courses,$beTime,$endTime,$action,$user_type);
			$row_page = $report->SelectUsersPerPage($row,$page);
			$report->ShowTableAll($row_page,$order);
		?>	</td>
  </tr>
  <tr></tr>
    <td colspan="5">
	 <? $report->ShowSeqTable($row,$page,$action,$filter,$beTime,$endTime,$order,$courses,$user_type);	 ?>
	</td>
  </tr>
</table>
<? mysql_close();?>