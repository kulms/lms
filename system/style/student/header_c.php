<? 
require "../include/global_login.php"; 
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />!-->
<link rel="stylesheet" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css" >

</head>
<body>
<?
$get_course=mysql_query("SELECT name FROM courses  WHERE id=$courses");
?>
<input type="hidden" name="courses" value="<? echo $courses?>">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
  <tr>
    <td  align="center" class="menu"><b><? echo $strSystem_LabReport;?><br>
          <?php echo $strCourses_LabCourseId;?> <? echo mysql_result($get_course,0,"name")?></b> </td>
  </tr>
</table>
</body>
</html>
