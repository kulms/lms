<html>
<head>
<title>Project List</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#99FFFF">
<font face="MS San Sarif">

<?
  require("../sql_password.php");
  $Temp=" '%".$searchtext."%' ";

  if ($searchtopic=="none")
  {
    print ("<p align=center>กรุณาเลือก<b>\"หัวข้อที่ต้องการค้นหา\"</b></p>");
    print ("<form>");
    print ("<p align=right><input type=button value=Back onclick='history.back() ; '></p>" );
    print ("</form>");
    exit();
  }
  elseif ($searchtext=="")
  {
    print ("<p align=center><b>ไม่ได้รับข้อมูลที่ต้องการค้นหา  กรุณาตรวจสอบอีกครั้ง</b></p>");
    print ("<form>");
    print ("<p align=right><input type=button value=Back onclick='history.back() ; '></p>" );
    print ("</form>");
    exit();
  }
  elseif  ($searchtopic=="s_project")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>ชื่อโครงงาน</b></p></td>
        <td><p align=center><b>ปีที่ทำ</b></p></td>
      </tr>
    ");
    $query = "select * from project where prjname Like $Temp order by prjname";
    $result = mysql_query($query,$link);
    $count=0;
    while ($row = mysql_fetch_row($result))
    {
      $count=$count+1;
      print
      ("
        <tr>
          <td><p align=center>$count</p></td>
          <td><a href=detailproject.php?project_id=$row[0]>$row[1]</a></td>
          <td><p align=center>$row[2]</p></td>
        </tr>
      ");
    }
  }
  elseif  ($searchtopic=="s_subject")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>รหัสวิชา</b></p></td>
        <td><p align=center><b>ชื่อวิชา</b></p></td>
      </tr>
    ");
    $query = "select * from subject where subname Like $Temp order by subcode ";
    $result = mysql_query($query,$link);
    $count=0;
    while ($row = mysql_fetch_row($result))
    {
      $count=$count+1;
      print
      ("
        <tr>
          <td><p align=center>$count</p></td>
          <td><a href=search.php?subject_id=$row[0]&list=subject>$row[1]</a></td>
          <td><p align=center>$row[2]</p></td>
        </tr>
      ");
    }
  }
  elseif  ($searchtopic=="s_keyword")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>คำสำคัญ</b></p></td>
      </tr>
    ");
    $query = "select * from topic where topname Like $Temp order by topname";
    $result = mysql_query($query,$link);
    $count=0;
    while ($row = mysql_fetch_row($result))
    {
      $count=$count+1;
      print
      ("
        <tr>
          <td><p align=center>$count</p></td>
          <td><a href=search.php?topic_id=$row[0]&list=topic>$row[1]</a></td>
         </tr>
      ");
    }
  }
  elseif  ($searchtopic=="s_company")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>ชื่อบริษัท</b></p></td>
        <td><p align=center><b>ประเภทธุรกิจ</b></p></td>
        <td><p align=center><b>สถานที่ตั้ง</b></p></td>
        <td><p align=center><b>เบอร์โทรศัพท์</b></p></td>      </tr>
    ");
    $query = "select * from company where comname Like $Temp order by comname";
    $result = mysql_query($query,$link);
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
  }

  elseif  ($searchtopic=="s_comkind")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>ชื่อบริษัท</b></p></td>
        <td><p align=center><b>ประเภทธุรกิจ</b></p></td>
        <td><p align=center><b>สถานที่ตั้ง</b></p></td>
        <td><p align=center><b>เบอร์โทรศัพท์</b></p></td>      </tr>
    ");
    $query = "select * from company where comkind Like $Temp order by comname";
    $result = mysql_query($query,$link);
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
  }

  elseif  ($searchtopic=="s_comaddress")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>ชื่อบริษัท</b></p></td>
        <td><p align=center><b>ประเภทธุรกิจ</b></p></td>
        <td><p align=center><b>สถานที่ตั้ง</b></p></td>
        <td><p align=center><b>เบอร์โทรศัพท์</b></p></td>      </tr>
    ");
    $query = "select * from company where comaddress Like $Temp order by comname";
    $result = mysql_query($query,$link);
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
  }

  elseif  ($searchtopic=="s_name")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>รหัสประจำตัวนิสิต</b></p></td>
        <td><p align=center><b>ชื่อ-นามสกุล</b></p></td>
      </tr>
    ");
    $query = "select * from users where category=\"3\" and firstname Like $Temp order by ucode";
    $result = mysql_query($query,$link);
    $count=0;
    while ($row = mysql_fetch_row($result))
    {
      $count=$count+1;
      print
      ("
        <tr>
          <td><p align=center>$count</p></td>
          <td><p align=center><a href=search.php?student_id=$row[0]&list=student>$row[17]</a></center></td>
          <td>$row[16] $row[4] $row[5]</td>
        </tr>
      ");
    }
  }
  elseif  ($searchtopic=="s_adviser")
  {
    print
    ("
      <table width=\"75%\" border=\"1\" align=center>
      <tr>
        <td><p align=center><b>ลำดับ</b></p></td>
        <td><p align=center><b>รหัสประจำตัว</b></p></td>
        <td><p align=center><b>ชื่อ-นามสกุล</b></p></td>
      </tr>
    ");
    $query = "select * from users where category=\"2\" and firstname Like $Temp order by ucode";
    $result = mysql_query($query,$link);
    $count=0;
    while ($row = mysql_fetch_row($result))
    {
      $count=$count+1;
      print
      ("
        <tr>
          <td><p align=center>$count</p></td>
          <td><p align=center><a href=search.php?adviser_id=$row[0]&list=adviser>$row[17]</a></p></td>
          <td>$row[16] $row[4] $row[5]</td>
        </tr>
      ");
    }
  }
  print ("</table>");
?>
</font>
</body>
</html>