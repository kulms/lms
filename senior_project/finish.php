<html>
<head>
<title>Finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#99FFFF">
<font face="MS San Sarif">

<?
  require("sql_password.php");
  $link = mysql_connect($server,$sql_username,$sql_password);
  if ($link)
  {
    $select = mysql_select_db("ieprojectdatabase",$link);
    if ($c_add=="new")
    { $query = "update company set comkind=\"$c_kind\",comaddress=\"$c_address\",comphone=\"$c_phone\",comfax=\"$c_fax\",comemail=\"$c_email\",comhomepage=\"$c_homepage\",comnote=\"$c_note\" where id=\"$c_id\" "; }
    elseif ($c_add=="old")
    { $query = "update company set comnote=\"$c_note\" where id=\"$c_id\" "; }
    else {print ("ERROR");}
    mysql_query($query,$link);
    mysql_close($link);
  }
  else { print ("ไม่สามารถติดต่อกับฐานข้อมูลได้"); }



?>

<p><center><h3><b>เสร็จสิ้นการกรอกข้อมูลโครงงาน</b></h3></center></p>
<br>
<p><center><a href="http://www.ku.ac.th">Go to KU Homepage</a></center></p>
<p><center><a href="/list/list.html"><b>ไปส่วนค้นหา</b></a></center></p>
</font>
</body>
</html>