<html>
<head>
<title>Company List</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#99FFFF">
<font face="MS San Sarif" size = 3>
<p>
  <center>
    <img src = ../pic/kaset_small.jpg>
    <img src = ../pic/search_com.jpg>
    <img src = ../pic/kaset_small.jpg>
  </center>
</p>
<p>
  <center><img src = ../pic/newline.jpg></center>
</p>

<?
  require("../sql_password.php");
  $link = mysql_connect($server,$sql_username,$sql_password);
  $select = mysql_select_db("ieprojectdatabase",$link);
  $query = "select * from company order by comname";
  $result = mysql_query($query,$link);
  print 
  ("
    <table width=\"80%\" border=\"1\" align=\"center\">
    <tr>
      <td><p align=center><b>ลำดับ</b></p></td>
      <td><p align=center><b>ชื่อบริษัท</b></p></td>
      <td><p align=center><b>ประเภทธุรกิจ</b></p></td>
      <td><p align=center><b>สถานที่ตั้ง</b></p></td>
      <td><p align=center><b>เบอร์โทรศัพท์</b></p></td>
    </tr>
    <tr>
      <td><p align=center>0</p></td>
      <td><a href=search.php?company_id=none&list=company>โครงงานที่ทำไม่เกี่ยวข้องกับบริษัท/โรงงาน</a></td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
    </tr>
  ");
  $count=0;
  while ($row = mysql_fetch_row($result))
  {
    $count=$count+1;
    if ($row[2]=="")
      { $row[2]="&nbsp"; }
    if ($row[3]=="")
      { $row[3]="&nbsp"; }
    if ($row[4]=="")
      { $row[4]="&nbsp"; }
    print 
    ("
      <tr>
        <td><p align=center>$count</p></td>
        <td><a href=search.php?company_id=$row[0]&list=company>$row[1]</a></td>
        <td>$row[2]</td>
        <td>$row[3]</td>
        <td><p align=center>$row[4]</p></td> 
     </tr>
    ");
  }  
  print ("</table>");
?>

</font>
<br>
<p>
  <center><img src = ../pic/line.jpg></center>
</p>

<font face="MS San Sarif" size = 2 color = orange>
  <center>
    <a href = list.html><b>ค้นหาตาม</b></a>
  </center>
  <center>
    <a href = listproject.php>ชื่อโครงงาน</a>
    <a href = liststudent.php>ชื่อนักศึกษา</a>
    <a href = listadviser.php>ชื่ออาจารย์</a>
    <a href = listsubject.php>ชื่อวิชา</a>
    <a href = listcompany.php>ชื่อบริษัท</a>
    <a href = listtopic.php>คำสำคัญ</a>
  </center>
</font>

</body>
</html>