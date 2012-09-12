<?require("../include/global.php");

?>
<html>
<head>
<title>สถิติการใช้งาน Course ของนักศึกษา</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../themes/<?php echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}

-->
</style>

</head>

<body bgcolor="#FFFFFF">
<br>
<br>
<table width="75%"  align="center" cellspacing="1" cellpadding="2" class="tdborder1">
  <tr class="boxcolor">
    <td class="Bcolor" nowrap>
      <div align="center">ลำดับที่</div>
    </td>

    <td class="Bcolor">
      <div align="center">รหัสวิชา</div>
    </td>
    <td class="Bcolor">
      <div align="center">ชื่อวิชา</div>
    </td>
    <td class="Bcolor" nowrap>
      <div align="center">เจ้าของวิชา</div>
    </td>
    <td class="Bcolor">
      <div align="center">จำนวนครั้งเข้าใช้งานโดยเรียงจาก
        <a href="statistic.php?sort=up" class="a11">น้อย -->มาก </a> หรือ <a href="statistic.php?sort=down" class="a11">มาก
        --> น้อย</a></div>
    </td>
  </tr>
  <?
$n=0;
$number=1;
$qcourses=mysql_query("SELECT id from courses where name<>'';");
//echo "จำนวนวิชาทั้งหมด..".mysql_num_rows($qcourses)."<br>";
while($row=mysql_fetch_array($qcourses)){
$qnumcourse=mysql_query("SELECT id from login_course WHERE courses=".$row["id"].";" );
$i=mysql_num_rows($qnumcourse);
$eachcourse[$n]=array($i,$row["id"]);
$n++;
}
if ($sort=="up")
     {
     sort($eachcourse);
     }
else
    {
     rsort($eachcourse);
    }
$nume=count($eachcourse);
//echo $nume;
for($idx=0; $idx<$nume; ++$idx)
     {
     $courseid=$eachcourse[$idx][1];
     $course=mysql_query("SELECT id,name,fullname,users from courses where id='$courseid';");
     $user=mysql_query("SELECT id,firstname,surname,email from users where id='".mysql_result($course,0,"users")."';");
     $rowuser=mysql_fetch_array($user);
?>
  <tr bgcolor="#FFFFFF">
    <td>
      <div align="center"><?echo $number;?></div>
    </td>

    <td>
      <div align="center"><?echo mysql_result($course,0,"name");?></div>
    </td>
    <td>
      <div align="center"><?echo mysql_result($course,0,"fullname");?></div>
    </td>
    <td>
      <div align="center"><a href="mailto:<?echo $rowuser["email"];?>"><?echo $rowuser["title"]." ".$rowuser["firstname"]." ".$rowuser["surname"];?></a></div>
    </td>
    <td>
      <div align="center"><?echo $eachcourse[$idx][0];?></div>
    </td>
  </tr>
<?
  $number++;   }

?>
</table>
</body>
</html>