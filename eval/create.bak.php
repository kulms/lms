<?
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include("./include/function.php");
?>
<html>
<head>
<title>e-Evaluation for M@xlearn / KU-LMS</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta name="Author" CONTENT="นางสาวชิดชนก วรรณกูล(MissChitchanok Wannakul)">
<meta name="keywords" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ]">
<meta name="description" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ] เป็นระบบประเมินการเรียนการสอนออนไลน์(ผ่านเครือข่ายคอมพิวเตอร์) มหาวิทยาลัยเกษตรศาสตร์ เน้นผู้เรียนเป็นศูนย์กลาง ผู้เรียนสามารถศึกษาและทบทวนบทเรียนได้ด้วยตนเอง">
<script type="text/javascript" language="JavaScript" src="./js/fieldLimiter.js"></script>
<script language="javascript" src="./calendar/cal.js"></script>
<script language="javascript" src="./calendar/cal_conf.js"></script>
<link href="./include/main.css" rel="stylesheet" type="text/css">
</head>

<body>
 <form name="createFrm" method="post" action="create.php">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td valign="top" align="right">&nbsp;</td>
      <td><b><font size="3">สร้างแบบประเมิน</font></b><br>
        &nbsp; </td>
    </tr>
    <tr> 
      <td width="20%" align="right" valign="top">&nbsp; <b>ชื่อแบบประเมิน : </b>&nbsp;</td>
      <td width="70%"><input name="eval_name" type="text" id="eval_name" size="20" maxlength="20"></td>
    </tr>
    <tr> 
      <td valign="top" align="right">&nbsp; <b>รายละเอียดของแบบประเมิน : </b>&nbsp;</td>
      <td><textarea name="comment" cols="80" rows="5" wrap="VIRTUAL" id="comment"></textarea> 
        &nbsp; <br> &nbsp; <script>displaylimit("document.createFrm.comment",255)</script> 
        <br>
        &nbsp; </td>
    </tr>
    <tr>
      <td align="right"><b>Active :</b> &nbsp;</td>
      <td><input name="active_eval" type="checkbox" id="active_eval" value="1"></td>
    </tr>
    <tr> 
      <td align="right">&nbsp; <b>วันเริ่มต้นการประเมิน : </b>&nbsp;</td>
      <td><div id="cal1">
          <input type="text" name="start_date" size="10" value="<? if($start_date!=0){ echo date("Y-m-d",$start_date); } ?>" onFocus="this.blur(); showCal('Date1')" maxlength="10">
          <a href="javascript:showCal('Date1')"><img src="calendar/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onMouseOut="window.status='';return true"  width="19" height="17" border="0"></a></div></td>
    </tr>
    <tr> 
      <td align="right">&nbsp; <b>วันสิ้นสุดการประเมิน : </b>&nbsp; </td>
      <td><div id="cal2">
          <input  type="text" name="end_date" size="10" value="<? if($end_date!=0){ echo date("Y-m-d",$end_date); } ?>" onFocus="this.blur(); showCal('Date2')" maxlength="10">
          <a href="javascript:showCal('Date2')" ><img src="calendar/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onMouseOut="window.status='';return true"  width="19" height="17" border="0"></a></div></td>
    </tr>
    <tr> 
      <td align="right">&nbsp;</td>
      <td><br> <input type="submit" name="Submit" value="C R E A T E"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
 /*  
$HTTP_POST_VARS[]; 
 $HTTP_GET_VARS[]; 
$HTTP_SESSION_VARS[];
 $HTTP_COOKIE_VARS[]; 
*/ 
?>