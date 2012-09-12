<html>
<head>
<title>Companydata</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#99FFFF">
<font face="MS San Sarif">

<?
  if ( ($p_name=="") || ($p_topic=="") || ($p_company=="") || ($p_year=="") || ($p_term=="") || ($p_subject=="") || ($p_subject2=="") || ($p_subject3=="") || ($p_adviser=="") || ($UploadedFile_name=="") )
  {
    print ("<div align=center><b>กรุณากรอกข้อมูลให้ครบ(ยกเว้นช่องหมายเหตุจะใส่หรือไม่ใส่ก็ได้)</b></div>");
#    print ("<a href = \"../projectdata.php\"><img src = ../pic/back-s.gif border = 0 align = right></a> ");
    print ("<form>");
    print ("<div align=right><input type=button value=Back onclick='history.back() ; '></div>" );
    print ("</form>");
    exit();
  }
  else
  {
    require("sql_password.php");
    $link = mysql_connect($server,$sql_username,$sql_password);
    if ($link)
    {
      $select = mysql_select_db("ieprojectdatabase",$link);
      $query = "select * from project";
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      {
        if ( ($row[1]==$p_name) || ($row[5]==$UploadedFile_name) )
        {
          print ("<p>ไม่สามารถบันทึกข้อมูลลงในฐานข้อมูลลงได้  สาเหตุอาจเกิดจาก</p>");
          print ("<p>1. ชื่อหัวข้อโครงงานซ้ำ</p>");
          print ("<p>2. ชื่อไฟล์บทคัดย่อซ้ำ</p>");
          exit();
        }
      }
      $query = "insert into project (prjname,prjyear,prjterm,prjnote,prjabstract,topID,subID,subID2,subID3,comID,depID) values (\"$p_name\",\"$p_year\",\"$p_term\",\"$p_note\",\"$UploadedFile_name\",\"$p_topic\",\"$p_subject\",\"$p_subject2\",\"$p_subject3\",\"$p_company\",\"$p_department\")";
      mysql_query($query,$link);
      $prjID = mysql_insert_id();
      $query = "insert into users_prj (prjID) values (\"$prjID\")";
      mysql_query($query,$link);
    }
    else { print ("ไม่สามารถติดต่อกับฐานข้อมูลได้"); }
  }
  $path="../files/stdproject";
  if( $UploadedFile != none )
  {
    print ("Local File: $UploadedFile <BR>\n");
    print ("Name: $UploadedFile_name <BR>\n");
    print ("Size: $UploadedFile_size <BR>\n");
    print ("Type: $UploadedFile_type <BR>\n");
    print ("<HR>");
    if (copy( $UploadedFile , "$path/$UploadedFile_name" ))
    { print "$UploadedFile has been copy to $path/$UploadFile_name<br>"; }
    else { print "Error.. can't upload<br>"; }
    # unlink($UploadedFile);
  }
  else { print "Error.. no file.<br>"; }





  if ($p_company==1)
  {
    print ("<p><center><h3><b>เสร็จสิ้นการกรอกข้อมูลโครงงาน</b></h3></center></p>");
    print ("<br>");
    print ("<p><center><a href=\"http://www.ku.ac.th\">Go to KU Homepage</a></center></p>");
  }
  else
  {
    print ("<p><center><img src = /pic/kaset_small.jpg><img src = /pic/><img src = /pic/kaset_small.jpg></center></p>");
    print ("<p><center><img src = /pic/newline.jpg></center></p>");
    print ("<br>");
    $query = "select * from company";
    $result = mysql_query($query,$link);
    while ($row = mysql_fetch_row($result))
    {
      if ( ($row[0]==$p_company) && ($row[2]!="") )
      {
        print ("<div align=\"center\"><p>ข้อมูลโรงงาน</p></div>");
        print ("<form method=\"post\" action=\"finish.php\">");
        print ("<p>ชื่อโรงงาน/บริษัท : $row[1] </p>");
        print ("<p>ประเภทธุรกิจ(ที่เกี่ยวข้องกับโครงงานมากที่สุด) : $row[2] </p>");
        print ("<p>ที่ตั้งโรงงาน/บริษัท : $row[3] </p>");
        print ("<p>เบอร์โทรศัพท์ : $row[4] </p>");
        print ("<p>Fax : $row[5] </p>");
        print ("<p>E-Mail : $row[6] </p>");
        print ("<p>Homepage : $row[7] </p>");
        print ("<p>หมายเหตุ<input type=\"text\" name=\"c_note\" value=$row[8]></p>");
        print ("<p>*** ถ้ามีข้อมูลใดไม่ถูกต้องกรุณาใส่เพิ่มเติมในช่องหมายเหตุ ***</p>");
        print ("<p><input type=\"hidden\" name=\"c_id\" value=\"$p_company\"</p> ");
        print ("<p><input type=\"hidden\" name=\"c_add\" value=\"old\"</p> ");
        print ("<p align=\"right\"><input type=\"submit\" name=\"Submit\" value=\"Finish\"></p>");
        print ("</form>");
        mysql_close($link);
        exit();
      }
      elseif ($row[0]==$p_company)
      {
        print ("<div align=\"center\"><p>ข้อมูลโรงงาน</p></div>");
        print ("<form method=\"post\" action=\"finish.php\">");
        print ("<p>ชื่อโรงงาน/บริษัท : $row[1] </p>");
        print ("<p>ประเภทธุรกิจ(ที่เกี่ยวข้องกับโครงงานมากที่สุด) : <input type=\"text\" name=\"c_kind\"></p>");
        print ("<p>ที่ตั้งโรงงาน/บริษัท : <input type=\"text\" name=\"c_address\"></p>");
        print ("<p>เบอร์โทรศัพท์ : <input type=\"text\" name=\"c_phone\"></p>");
        print ("<p>Fax : <input type=\"text\" name=\"c_fax\"></p>");
        print ("<p>E-Mail : <input type=\"text\" name=\"c_email\"></p>");
        print ("<p>Homepage : <input type=\"text\" name=\"c_homepage\"></p>");
        print ("<p>หมายเหตุ <input type=\"text\" name=\"c_note\"></p>");
        print ("<p><input type=\"hidden\" name=\"c_id\" value=\"$p_company\"</p> ");
        print ("<p><input type=\"hidden\" name=\"c_add\" value=\"new\"</p> ");
        print ("<p align=\"right\"><input type=\"submit\" name=\"Submit\" value=\"Finish\"></p>");
        print ("</form>");
        mysql_close($link);
        exit();
      }
    }
  }
?>

</font>
</body>
</html>