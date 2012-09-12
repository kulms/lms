<html>
<head>
<title>Project List</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#99FFFF">
<font face="MS San Sarif">
<p>
  <center>
    <img src = ../pic/kaset_small.jpg>
    <img src = ../pic/search_prj.jpg>
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
  $query = "select * from project order by prjname";
  $result = mysql_query($query,$link);
  print 
  ("
    <table width=\"75%\" border=\"1\" align=\"center\">
    <tr>
      <td><p align=center><b>ลำดับ</b></p></td>
      <td><p align=center><b>ชื่อโครงงาน</b></p></td>
      <td><p align=center><b>ปีที่ทำ</b></p></td>
    </tr>
  ");
  $count=0;
  while ($row = mysql_fetch_row($result))
  {
    $count=$count+1;
    print 
    ("
      <tr>
        <td><p align=center>$count</p></td>
        <td><a href=detailproject.php?project_id=$row[0]>$row[1]</a></td>
        <td><p align=center>$row[2]</td>
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