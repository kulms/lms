<html>
<head>
<title>Companydata</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#99FFFF">
<font face="MS San Sarif">

<?
# /*
  if ($p_name=="")
  {
    print ("<div align=center><b>ไม่ได้รับข้อมูล\"ชื่อโครงงาน\"  กรุณาตรวจสอบอีกครั้ง</b></div>");
    print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
    exit();
  }
  elseif ($p_department=="")
  {
    print ("<div align=center><b>ไม่ได้รับข้อมูล\"ภาควิชา\"  กรุณาตรวจสอบอีกครั้ง</b></div>");
    print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
    exit();
  }
  elseif ($p_company=="")
  {
    print ("<div align=center><b>ไม่ได้รับข้อมูล\"ชื่อโรงงาน\"  กรุณาตรวจสอบอีกครั้ง</b></div>");
    print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
    exit();
  }
  elseif ($p_term=="")
  {
    print ("<div align=center><b>ไม่ได้รับข้อมูล\"ภาคการศึกษา\"  กรุณาตรวจสอบอีกครั้ง</b></div>");
    print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
    exit();
  }
  elseif ($p_subject=="")
  {
    print ("<div align=center><b>ไม่ได้รับข้อมูล\"วิชาที่เกี่ยวข้อง(มากที่สุด)\"  กรุณาตรวจสอบอีกครั้ง</b></div>");
    print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
    exit();
  }
  elseif ($p_adviser=="")
  {
    print ("<div align=center><b>ไม่ได้รับข้อมูล\"อาจารย์ที่ปรึกษาโครงงาน\"  กรุณาตรวจสอบอีกครั้ง</b></div>");
    print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
    exit();
  }
  elseif ($UploadedFile_name=="")
  {
    print ("<div align=center><b>ไม่ได้รับข้อมูล\"ไฟล์บทคัดย่อ\"  กรุณาตรวจสอบอีกครั้ง</b></div>");
    print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
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
        if ($row[5]==$UploadedFile_name)
        { 
          print ("<center><b>ชื่อไฟล์บทคัดย่อซ้ำ กรุณาตรวจสอบอีกครั้ง</center></b>"); 
          print ("<form><div align=right><input type=button value=Back onclick='history.back() ; '></div></form>");
          exit(); 
        }
      }
      $query = "insert into project (prjname,prjyear,prjterm,prjnote,prjabstract,topID,subID,subID2,subID3,comID,depID) values (\"$p_name\",\"$p_year\",\"$p_term\",\"$p_note\",\"$UploadedFile_name\",\"$p_topic\",\"$p_subject\",\"$p_subject2\",\"$p_subject3\",\"$p_company\",\"$p_department\")";
      mysql_query($query,$link);
      $prjID = mysql_insert_id();
      $query = "insert into users_prj (useid,prjID) values (\"$p_adviser\",\"$prjID\")";
      mysql_query($query,$link);


      $query = "insert into users_prj (useid,prjID) values (\"$p_student\",\"$prjID\")";
      mysql_query($query,$link);


    }
    else { print ("ไม่สามารถติดต่อกับฐานข้อมูลได้"); }
  }
  $path="E:/Project/pon/upload";
  if( $UploadedFile != none )
  {
#    print ("Local File: $UploadedFile <BR>\n");
#    print ("Name: $UploadedFile_name <BR>\n");
#    print ("Size: $UploadedFile_size <BR>\n");
#    print ("Type: $UploadedFile_type <BR>\n");
#    print ("<HR>");
    if (copy( $UploadedFile , "$path/$UploadedFile_name" ))
    {
#      print "$UploadedFile has been copy to $path/$UploadFile_name<br>"; 
    }
    else { print "Error.. can't upload<br>"; }
#    unlink($UploadedFile);
  }
  else { print "Error.. no file.<br>"; }

# */

#    require("sql_password.php");
#    $link = mysql_connect($server,$sql_username,$sql_password);
#      $select = mysql_select_db("ieprojectdatabase",$link);




  if ($p_company=="none")
  {
    print ("<p><center><h3><b>เสร็จสิ้นการกรอกข้อมูลโครงงาน</b></h3></center></p>");
    print ("<br>");
    print ("<p><center><a href=\"http://www.ku.ac.th\">Go to KU Homepage</a></center></p>");
  }
  else
  {
    print ("<p><center><img src = pic/kaset_small.jpg><img src = pic/companydata.jpg><img src = pic/kaset_small.jpg></center></p>");
    print ("<p><center><img src = pic/newline.jpg></center></p>");
    print ("<br>");
    $query = "select * from company";
    $result = mysql_query($query,$link);
    while ($row = mysql_fetch_row($result))
    {
      if ( ($row[0]==$p_company) && ($row[2]!="") )
      {  
        if ($row[2]=="")
          { $row[2]="&nbsp"; }
        if ($row[3]=="")
          { $row[3]="&nbsp"; }
        if ($row[4]=="")
          { $row[4]="&nbsp"; }
        if ($row[5]=="")
          { $row[5]="&nbsp"; }
        if ($row[6]=="")
          { $row[6]="&nbsp"; }
        if ($row[7]=="")
          { $row[7]="&nbsp"; }
        print ("<form method=\"post\" action=\"finish.php\">");
        print ("<table width=\"80%\" border=\"1\" align=\"center\">");
        print ("<tr><td width=\"55%\">ชื่อโรงงาน/บริษัท</td><td width=\"45%\">$row[1]</td></tr> ");
        print ("<tr><td width=\"55%\">ประเภทธุรกิจ(ที่เกี่ยวข้องกับโครงงานมากที่สุด)</td><td width=\"45%\">$row[2]</td></tr> ");
        print ("<tr><td width=\"55%\">ที่ตั้งโรงงาน/บริษัท</td><td width=\"45%\">$row[3]</td></tr>");
        print ("<tr><td width=\"55%\">เบอร์โทรศัพท์</td><td width=\"45%\">$row[4]</td></tr>");
        print ("<tr><td width=\"55%\">Fax</td><td width=\"45%\">$row[5]</td></tr>");
        print ("<tr><td width=\"55%\">E-Mail</td><td width=\"45%\">$row[6]</td></tr>");
        print ("<tr><td width=\"55%\">Homepage</td><td width=\"45%\">$row[7]</td></tr>");
        print ("<tr><td width=\"55%\">หมายเหตุ</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_note\" value=$row[8]></td></tr>");
        print ("</table>");
        print ("<p align=\"center\"><img src=\"pic/newline.jpg\" width=\"690\" height=\"18\"></p>");
        print ("<p align=\"center\">*** ถ้ามีข้อมูลใดไม่ถูกต้องกรุณาใส่เพิ่มเติมในช่องหมายเหตุ ***</p>");
        print ("<p><input type=\"hidden\" name=\"c_id\" value=\"$p_company\"</p> ");
        print ("<p><input type=\"hidden\" name=\"c_add\" value=\"old\"</p> ");
        print ("<p align=\"right\"><input type=\"submit\" name=\"Submit\" value=\"Finish\"></p>");
        print ("</form>");
        mysql_close($link);
        exit();
      }
      elseif ($row[0]==$p_company)
      {
        print ("<form method=\"post\" action=\"finish.php\">");
        print ("<table width=\"80%\" border=\"1\" align=\"center\">");
        print ("<tr><td width=\"55%\">ชื่อโรงงาน/บริษัท</td><td width=\"45%\">$row[1]</td></tr>");
        print ("<tr><td width=\"55%\">ประเภทธุรกิจ(ที่เกี่ยวข้องกับโครงงานมากที่สุด)</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_kind\"></td></tr>");
        print ("<tr><td width=\"55%\">ที่ตั้งโรงงาน/บริษัท</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_address\"></td></tr>");
        print ("<tr><td width=\"55%\">เบอร์โทรศัพท์</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_phone\"></td></tr>");
        print ("<tr><td width=\"55%\">Fax</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_fax\"></td></tr>");
        print ("<tr><td width=\"55%\">E-Mail</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_email\"></td></tr>");
        print ("<tr><td width=\"55%\">Homepage</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_homepage\"></td></tr>");
        print ("<tr><td width=\"55%\">หมายเหตุ</td><td width=\"45%\"><input type=\"text\" size=45 name=\"c_note\"></td></tr>");
        print ("</table>");
        print ("<p align=\"center\"><img src=\"pic/newline.jpg\" width=\"690\" height=\"18\"></p>");
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