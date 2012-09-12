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
    <img src = ../pic/>
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
  $query = "select * from project where id=\"$project_id\" ";
  $result = mysql_query($query,$link);
  $row = mysql_fetch_row($result);
  print ("<center>");
  print
  ("
    <table  border=\"1\">
    <tr>
      <td>ชื่อโครงงาน</td>
      <td>$row[1]</td>
    </tr>
  ");
  $q_users_prj = "select useid from users_prj where prjid=\"$row[0]\" ";
  $r_users_prj = mysql_query($q_users_prj,$link);
  while ($row_users_prj = mysql_fetch_row($r_users_prj))
  {
    $q_users = "select * from users where id=\"$row_users_prj[0]\" and category=\"3\" ";
    $r_users = mysql_query($q_users,$link);
    $row_users=mysql_fetch_row($r_users);
    if ($row_users[0] != "")
    {
      print
      ("
        <tr>
          <td>รหัสประจำตัวนิสิต</td>
          <td>$row_users[17]</td>
        </tr>
        <tr>
          <td>ชื่อ-นามสกุลนิสิต</td>
          <td>$row_users[16]$row_users[4] $row_users[5]</td>
        </tr>
        <tr>
          <td>E-mail นิสิตที่ทำโครงงาน</td>
          <td>$row_users[6]</td>
        </tr>
      ");
    }
    $q_users = "select * from users where id=\"$row_users_prj[0]\" and category=\"2\" ";
    $r_users = mysql_query($q_users,$link);
    $row_users=mysql_fetch_row($r_users);
    if ($row_users[0] != "")
    {
      print
      ("
        <tr>
          <td>อาจารย์ที่ปรึกษาโครงงาน</td>
          <td>$row_users[16]$row_users[4] $row_users[5]</td>
        </tr>
      ");
    }
  }
  $q_department = "select fullname from department where id=\"$row[10]\" ";
  $r_department = mysql_query($q_department,$link);
  $row_department = mysql_fetch_row($r_department);
  print
  ("
    <tr>
      <td>ภาควิชา</td>
      <td>$row_department[0]</td>
    </tr>
  ");
  print
  ("
    <tr>
      <td>ปีการศึกษา</td>
      <td>$row[2]</td>
    </tr>
    <tr>
      <td>ภาคการศึกษา</td>
      <td>ตอน$row[3]</td>
    </tr>
  ");
  $q_topic = "select topname from topic where id=\"$row[7]\" ";
  $r_topic = mysql_query($q_topic,$link);
  $row_topic = mysql_fetch_row($r_topic);
  print
  ("
    <tr>
      <td>คำสำคัญ/Key word</td>
      <td>$row_topic[0]</td>
    </tr>
  ");
  $q_company = "select comname from company where id=\"$row[9]\" ";
  if ($q_company = "none")
  {
    print
    ("
      <tr>
        <td>บริษัท/โรงงานที่เกี่ยวข้อง</td>
        <td>โครงงานที่ทำไม่เกี่ยวข้องกับบริษัท/หน่วยงาน</td>
      </tr>
    ");
  }
  else
  {
    $r_company = mysql_query($q_company,$link);
    $row_company = mysql_fetch_row($r_company);
    print
    ("
      <tr>
        <td>บริษัท/โรงงานที่เกี่ยวข้อง</td>
        <td>$row_company[0]</td>
      </tr>
    ");
  }
  $q_subject = "select * from subject where id=\"$row[8]\" ";
  $r_subject = mysql_query($q_subject,$link);
  $row_subject = mysql_fetch_row($r_subject);
  print
  ("
    <tr>
      <td>วิชาที่เกี่ยวข้องที่สุด</td>
      <td>$row_subject[1] $row_subject[2]</td>
    </tr>
  ");
  $q_subject2 = "select * from subject where id=\"$row[11]\" ";
  $r_subject2 = mysql_query($q_subject2,$link);
  $row_subject2 = mysql_fetch_row($r_subject2);
  print
  ("
    <tr>
      <td>วิชาที่เกี่ยวข้องอื่น ๆ</td>
      <td>$row_subject2[1] $row_subject2[2]</td>
    </tr>
  ");
  $q_subject3 = "select * from subject where id=\"$row[12]\" ";
  $r_subject3 = mysql_query($q_subject3,$link);
  $row_subject3 = mysql_fetch_row($r_subject3);
  print
  ("
    <tr>
      <td>วิชาที่เกี่ยวข้องอื่น ๆ</td>
      <td>$row_subject3[1] $row_subject3[2]</td>
    </tr>
    <tr>
      <td>บทคัดย่อ</td>
      <td><a href=\"../../files/stdproject/$row[5]\" target=\"_blank\">ดูบทคัดย่อ</a></td>
    </tr>
  ");
  print ("</center>");
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