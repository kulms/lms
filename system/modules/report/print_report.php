<title>::<? echo $user->_($strSystem_LabUserPrintHeader);?>::</title>
<link rel="stylesheet" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<SCRIPT LANGUAGE='javascript' src='verify.js'></SCRIPT>
<? 
 $report = new Report('');
 if($order=="")
	$order='time DESC';
else
	$order=$order;
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5" align="center"><b><? echo $user->_($strSystem_LabUserPrintHeader);?></b>&nbsp;&nbsp; (<? echo date("d-m-Y");?>)</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
     <td align="right"><img src="./modules/report/images/print.gif" border="0"><a href="Javascript:Print();"><? echo $user->_($strSystem_LabUserPrint); ?></a></td>
  </tr>
  <tr>
    <td height="25" colspan="5"><b><? echo $user->_($strSystem_LabUserType);?> : 
	<? if($user_type=="" || $user_type==0) echo $user->_($strSystem_LabUserTypeAll);
	else if($user_type==1)  echo $user->_($strSystem_LabUserTypeAdmin);
	else if($user_type==2)  echo $user->_($strSystem_LabUserTypeInstructor);
	else if($user_type==3)  echo $user->_($strSystem_LabUserTypeStudent);
	?>
	</b></td>
  </tr>
  <tr>
    <td height="24" colspan="5"><b><? echo $user->_($strSystem_RMenuHeader);?> : 
	<?  if($action=="all" || $action=="") echo $user->_($strSystem_RMenuAll);
	else if($action=="courses")  echo $user->_($strSystem_RMenuCourse);
	else if($action=="modules")  echo $user->_($strSystem_RMenuModules);
	else if($action=="login")  echo $user->_($strSystem_RMenuLogin);
	else if($action=="logout")  echo $user->_($strSystem_RMenuLogout);
	?>
	</b></td>
  </tr>
  <tr>
    <td height="24" colspan="5"><b><? echo $user->_($strSystem_RHeader);?> :  
	<? if($filter == "") echo $user->_($strSystem_RMenuAll);
	else if($filter=="time") echo $user->_($strSystem_LabReportTime)." $beTime ".$user->_($strSystem_LabReportTo)." $endTime"; 
	else if($filter=="create")  echo $user->_($strSystem_CReportCreate);
	else if($filter=="update")  echo $user->_($strSystem_CReportUpdate);
	else if($filter=="delete")  echo $user->_($strSystem_CReportDelete);
	else if($filter=="apply")  echo $user->_($strSystem_CReportApply);
	else if($filter=="drop")  echo $user->_($strSystem_CReportDrop);
	else if($filter=="folder")  echo $user->_($strSystem_MReportFolder);
	else if($filter=="group")  echo $user->_($strSystem_MReportGroup);
	else if($filter=="forum")  echo $user->_($strSystem_MReportForum);
	else if($filter=="webboard")  echo $user->_($strSystem_MReportWebboard);
	else if($filter=="resources")  echo $user->_($strSystem_MReportResources);
	else if($filter=="quiz")  echo $user->_($strSystem_MReportQuiz);
	else if($filter=="hw")  echo $user->_($strSystem_MReportHW);
	?>
	</b></td>
  </tr>
  <tr>
    <td height="24" colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="23%" ><b><? echo $user->_($strSystem_ListReportTime);?></b></td>
    <td width="29%"><b><? echo $user->_($strSystem_ListReportName);?></b></td>
    <td width="16%" ><b><? echo $user->_($strSystem_ListReportAction);?></b></td>
    <td  width="16%"><b><? echo $user->_($strSystem_ListReportModules);?></b></td>
    <td  width="16%"><b><? echo $user->_($strSystem_ListReportCourses);?></b></td>
  </tr>
  <tr>
    <td colspan="5"  align="center">
	<?  //$order='time DESC';
 $row = $report->SelectReportAll('',$filter,$order,'',$beTime,$endTime,$action,$user_type);
$report->ShowTableAll($row,$order);
?></td>
  </tr>
</table>
