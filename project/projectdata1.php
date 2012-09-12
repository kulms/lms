<html>
<head>
<title>Projectdata</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#FFFFFF">
<font face="MS San Sarif"> 
<p>
  <center>
    <?
  require("sql_password.php");
  $link = mysql_connect($server,$sql_username,$sql_password);
  $select = mysql_select_db("ieprojectdatabase",$link);
?> 
    <form ENCTYPE="multipart/form-data" action="companydata.php" method="post">
      
    <table width="80%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#990000">ชื่อผู้ทำโครงงาน</font></td>
        <td><? echo $researchername; ?>ภาควิชา <?echo $deptname;?></td>
      </tr>
      <tr> 
        <td><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#990000">ชื่อโครงงาน</font></td>
        <td><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#990000"> 
          <input type="text" size ="32" name="p_name">
          </font></td>
      </tr>
      <tr> 
        <td><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#990000">ภาควิชา&nbsp;&nbsp;</font></td>
        <td><font face="MS Sans Serif, Microsoft Sans Serif" size="1" color="#990000"> 
          <select name="p_department">
            <option value ="">เลือกภาควิชา</option>
            <?
      $query = "select * from department";
      $result = mysql_query($query,$link);     
      while ($row = mysql_fetch_row($result))
      { print ("<option value=\"$row[0]\">$row[2]</option>"); }
    ?> 
          </select>
          </font></td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>ชื่อโรงงาน/บริษัทที่เกี่ยวข้อง 
        <select name="p_company">
          <option value="">เลือกบริษัทที่เกี่ยวข้อง</option>
          <option value="none">โครงงานที่ทำไม่เกี่ยวข้องกับบริษัท/หน่วยงาน</option>
          <?
      $query = "select * from company order by comname desc";
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      { print ("<option value=\"$row[0]\">$row[1]</option>"); }
    ?> 
        </select><a href="add/addcompany.php">
        เพิ่มชื่อโรงงาน<a> </p>
      <p>คำสำคัญ/Key word)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp 
        <select name="p_topic">
          <option value ="">เลือกคำสำคัญ</option>
          <?
      $query = "select * from topic order by topname desc";
      $result = mysql_query($query,$link);     
      while ($row = mysql_fetch_row($result))
      { print ("<option value=\"$row[0]\">$row[1]</option>"); }
    ?> 
        </select>
        <a href="add/addtopic.php">เพิ่มคำสำคัญ</a> </p>
      <p>ปีการศึกษา 
        <select name="p_year">
          <?
      $year=2531;
      for ($year=2531;$year<2600;$year++)
      { print ("<option value=$year>$year</option>"); }
    ?> 
        </select>
        ภาคการศึกษา 
        <input type="radio" name="p_term" value="ต้น">
        ต้น 
        <input type="radio" name="p_term" value="ปลาย">
        ปลาย </p>
      <p>วิชาที่เกี่ยวข้อง(มากที่สุด) 
        <select name="p_subject">
          <option value ="">เลือกวิชาที่เกี่ยวข้อง</option>
          <?
      $query = "select * from subject order by subcode";
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      { print ("<option value=\"$row[0]\">$row[1]&nbsp;&nbsp;$row[2]</option>"); }
    ?> 
        </select>
        <!--    <a href="/add/addsubject.php">เพิ่มชื่อวิชา<a>--> </p>
      <p>วิชาที่เกี่ยวข้อง(อื่น ๆ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp 
        <select name="p_subject2">
          <option value ="">เลือกวิชาที่เกี่ยวข้อง</option>
          <?
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      { print ("<option value=\"$row[0]\">$row[1]&nbsp;&nbsp;$row[2]</option>"); }
    ?> 
        </select>
      </p>
      <p>วิชาที่เกี่ยวข้อง(อื่น ๆ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp 
        <select name="p_subject3">
          <option value ="">เลือกวิชาที่เกี่ยวข้อง</option>
          <?
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      { print ("<option value=\"$row[0]\">$row[1]&nbsp;&nbsp;$row[2]</option>"); }
    ?> 
        </select>
      </p>
      <p>อาจารย์ที่ปรึกษาโครงงาน 
        <select name="p_adviser">
          <option value ="">เลือกอาจารย์ที่ปรึกษาโครงงาน</option>
          <?
      $query = "select * from users where category=\"2\"  order by ucode";
      $result = mysql_query($query,$link);
      while ($row = mysql_fetch_row($result))
      { print ("<option value=\"$row[0]\">$row[17]&nbsp;&nbsp;$row[16]$row[4]&nbsp;&nbsp;$row[5]</option>"); }
    ?> 
        </select>
        <!--    <a href="addadviser.php">เพิ่มชื่ออาจารย์<a>--> </p>
      <p>เลือกไฟล์บทคัดย่อ(.txt)&nbsp;&nbsp <!--<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="1024000">--> 
        <INPUT NAME="UploadedFile" TYPE="file">
      </p>
      <p>หมายเหตุ 
        <input type="text" name="p_note">
      </p>
      <p align="right"> 
        <input type="submit" name="Submit" value="Next">
      </p>
    </form>
  </center>
</p>
</font> 
</body>
</html>