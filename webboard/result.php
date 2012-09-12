<? require("conn.php");
$se=mysql_query("select * from courses where temp <> 1;");
?>
<html>
<title>Result</title>
<body bgcolor="#FFFFFF">

<?
while($row=mysql_fetch_array($se)){
$no=0;?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr bgcolor="#CCCCFF"><td colspan="9" align="center"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2"><? echo $row["longname"] ?></b></font></td></tr>
  <tr>
    <td width="5%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">ลำดับที่</font></b></font></div>
    </td>
    <td width="19%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">ชื่อ-สกุล</font></b></font></div>
    </td>
    <td width="19%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">บริษัท</font></b></font></div>
    </td>
    <td width="10%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">โทรศัพท์</font></b></font></div>
    </td>
    <td width="10%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">โทรศัพท์มือถือ</font></b></font></div>
    </td>
    <td width="10%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">โทรสาร</font></b></font></div>
    </td>
    <td width="15%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">E-Mail</font></b></font></div>
    </td>
    <td width="8%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">ตอบกลับ</font></b></font></div>
    </td>
    <td width="8%" height="22" bgcolor="#CCCCFF">
      <div align="center"><font color="#990000"><b><font face="MS Sans Serif, Microsoft Sans Serif" size="2">ยืนยัน</font></b></font></div>
    </td>
  </tr>

  <?
$count=0;
$select=mysql_query("SELECT * FROM apply WHERE course=".$row["id"].";");
while ($row1=mysql_fetch_array($select)){
$userse=$row1["applicant"];
//echo $userse;
$seu=mysql_query("SELECT * FROM register WHERE id=$userse;");
while ($row3=mysql_fetch_array($seu)){
$count++;
$no++;
?>
  <tr bgcolor=<? if($count==1){echo "\"lightcyan\"" ;} else { echo "\"powderblue\""; }?>>
    <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><? echo $no ?></font></div>
    </td>
    <td>
      <div align="left"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><?echo $row3["title"].$row3["name"]."  ".$row3["surname"]; ?></font></div>
    </td>
    <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><? echo $row3["company"] ?></font></div>
    </td>
    <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><? echo $row3["tel"] ?></font></div>
    </td>
    <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><? echo $row3["fax"] ?></font></div>
    </td>
      <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><? echo $row3["mobile"] ?></font></div>
    </td>
      <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><a href="mailto:<? echo $row3["email"] ?>"><? echo $row3["email"] ?></font></div>
    </td>
    <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><a href="refcon.php?reply=<? if($row1["replied"] == "1"){echo "no";}else{echo "yes";}?>&id=<?echo $row1["id"]?>"><? if($row1["replied"] == "1"){echo "<b><font color=red>YES</b></font>";}else{echo "NO";}?></font></div>
    </td>
   <td>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#000099"><a href="refcon.php?confirm=<? if($row1["confirm"] == "1"){echo "no";}else{echo "yes";}?>&id=<?echo $row1["id"]?>"><? if($row1["confirm"] == "1"){echo "<b><font color=red>YES</b></font>";}else{echo "NO";}?></font></div>
    </td>
    </tr>
<? if ($count==2){ $count=0; }
}
}
echo "</table><br><center><hr width=\"50%\"><center>";
}
?>
      <div align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="2" color="red"><a href="webboard/"><b>GOTO Thaicool WEBBOARD</b></font></div>
</html>
