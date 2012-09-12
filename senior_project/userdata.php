<html>
<head>
<title>Projectdata</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#99FFFF">
<font face="MS San Sarif">
<p>
  <center>
    <img src = "pic/kaset_small.jpg">
    <img src = "pic/userdata.jpg">
    <img src = "pic/kaset_small.jpg">
  </center>
</p>
<p>
  <center><img src = "pic/newline.jpg"></center>
</p>


<?
  require("sql_password.php");
?>
</font></p>
<form  method="post" action="projectdata.php">
  <table width="75%" border="1" align="center">
    <tr>
      <td width="30%">ภาควิชา</td>
      <td width="70%">
        <select name="u_dept">
          <option value ="">เลือกภาควิชา</option>
          <?
            $query = "select * from department";
            $result = mysql_query($query,$link);
            while ($row = mysql_fetch_row($result))
              { print ("<option value=\"$row[0]\">$row[2]</option>"); }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td width="30%">ประเภทผู้ใช้</td>
      <td width="70%">
        <select name="u_category">
          <option value ="">เลือกประเภทผู้ใช้</option>
          <?
            $query = "select * from users_type where id !=0 ";
            $result = mysql_query($query,$link);
            while ($row = mysql_fetch_row($result))
              { print ("<option value=\"$row[0]\">$row[1]</option>"); }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td width="30%">คำนำหน้า</td>
      <td width="70%">
        <select name="u_title">
          <option value ="">เลือกคำนำหน้า</option>
          <option value ="นาย">นาย</option>
          <option value ="น.ส.">น.ส.</option>
          <option value ="อ.">อาจารย์</option>
          <option value ="ดร.">ดร.</option>
          <option value ="ผศ.">ผศ.</option>
          <option value ="ผศ.ดร.">ผศ.ดร.</option>
          <option value ="รศ.">รศ.</option>
          <option value ="รศ.ดร.">รศ.ดร.</option>
        </select>
<!--        <input type="text" name="u_title"> -->
      </td>
    </tr>
    <tr>
      <td width="30%">ชื่อ</td>
      <td width="70%">
        <input type="text" name="u_firstname">
      </td>
    </tr>
    <tr>
      <td width="30%">นามสกุล</td>
      <td width="70%">
        <input type="text" name="u_surname">
      </td>
    </tr>
    <tr>
      <td width="30%">รหัสประจำตัว</td>
      <td width="70%">
        <input type="text" name="u_ucode">
      </td>
    </tr>
    <tr>
      <td width="30%">เบอร์โทรศัพท์</td>
      <td width="70%">
        <input type="text" name="u_telephone">
      </td>
    </tr>
    <tr>
      <td width="30%">ที่อยู่</td>
      <td width="70%">
        <input type="text" name="u_address">
      </td>
    </tr>
    <tr>
      <td width="30%">E-Mail Address</td>
      <td width="70%">
        <input type="text" name="u_email">
      </td>
    </tr>
    <tr>
      <td width="30%">Homepage</td>
      <td width="70%">
        <input type="text" name="u_homepage">
      </td>
    </tr>
  </table>
  <p align="center"><img src="pic/newline.jpg" width="690" height="18"></p>
  <p align="right">
    <input type="submit" name="Submit" value="Next">
  </p>
</form>

</font>
</html>