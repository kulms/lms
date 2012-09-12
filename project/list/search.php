<html>
<head>
<title>Project List</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#FFFFFF">
<font face="MS San Sarif">

<?
  require("../sql_password.php");
  $link = mysql_connect($server,$sql_username,$sql_password);
  $select = mysql_select_db("ieprojectdatabase",$link);

  if ($list=="subject")
  { $query = "select * from project where subid=\"$subject_id\" "; }
  elseif ($list=="company")
  { $query = "select * from project where comid=\"$company_id\" "; }
  elseif ($list=="topic")
  { $query = "select * from project where topid=\"$topic_id\" "; }
  elseif ($list=="student")
  {
    $query = "select prjid from users_prj where useid=\"$student_id\" ";
    $remain = mysql_query($query,$link);
    $count=0;
    print
    ("
      <table width=\"75%\" border=\"1\">
      <tr>
        <td><p align=center>ลำดับ</p></td>
        <td><p align=center>ชื่อโครงงาน</p></td>
      </tr>
    ");
    while ($row = mysql_fetch_row($remain))
    {
      $count=$count+1;
      $query = "select * from project where id=\"$row[0]\" ";
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      {
        print
        ("
          <tr>
            <td><p align=center>$count</p></td>
            <td><a href=detailproject.php?project_id=$row[0]>$row[1]</a></td>
          </tr>
        ");
      }
    }
    print ("</table>");
    exit;
  }
  elseif ($list=="adviser")
  {
    $query = "select prjid from users_prj where useid=\"$adviser_id\" ";
    $remain = mysql_query($query,$link);
    $count=0;
    print
    ("
      <table width=\"75%\" border=\"1\">
      <tr>
        <td><p align=center>ลำดับ</p></td>
        <td><p align=center>ชื่อโครงงาน</p></td>
      </tr>
    ");
    while ($row = mysql_fetch_row($remain))
    {
      $count=$count+1;
      $query = "select * from project where id=\"$row[0]\" ";
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      {
        print
        ("
          <tr>
            <td><p align=center>$count</p></td>
            <td><a href=detailproject.php?project_id=$row[0]>$row[1]</a></td>
          </tr>
        ");
      }
    }
    print ("</table>");
    exit;
  }
  else
  { print ("ERROR"); }
  $result = mysql_query($query,$link);
  print 
  ("
    <table width=\"75%\" border=\"1\">
    <tr>
      <td><p align=center>ลำดับ</p></td>
      <td><p align=center>ชื่อโครงงาน</p></td>
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
      </tr>
    ");
  }  
  print ("</table>");
    


?>

</font>
</body>
</html>