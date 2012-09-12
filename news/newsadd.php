<?require("../include/global_login.php");


?>
<html>
<head>
        <title>Add NEWS</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<div class="info" align="center">
<center>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
background="../images/headerbg.gif" height="53">
  <tr><td class="menu" align="center">
        <b>เพิ่มหัวข้อข่าว ประจำวันที่ <?echo date("d-m-Y",time()) ?> </b>

</td></tr>
</table>
<hr width="50%">

           <form action="send.php" method="post" enctype="multipart/form-data">
<table width="45%" border="0" cellspacing="5" cellpadding="0" align="center">
  <tr>
    <td class="info">
      <div align="right">หัวข้อเรื่อง</div>
    </td>
    <td class="info">
      <input type="text" name="name" size="40">
    </td>
  </tr>
  <tr>
    <td class="info">
      <div align="right">ประเภทของข่าว</div>
    </td>
    <td class="info">
      <select name="news_type">
        <option>------เลือกประเภทของข่าว----</option>
        <option value="public">ประชาสัมพันธ์</option>
        <option value="info">เรื่องแจ้งเพื่อทราบ</option>
        <option value="feedback">เรื่องเพื่อพิจารณา</option>
        <option value="anno">ประกาศ/คำสั่ง/แต่งตั้ง</option>
        <option value="report">รายงานการประชุม</option>
        <option value="finance">ระเบียบการเงิน</option>
        <option value="store">ระเบียบพัสดุ</option>
        <option value="research">งานบริการวิชาการและวิจัย</option>
        <option value="training">ทุนการศึกษา ฝึกอบรม ดูงาน</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="info">
      <div align="right">File</div>
    </td>
    <td class="info">
      <input type="file" name="file">
    </td>
  </tr>
<tr>
    <td class="res">
      <div align="right"></div>
    </td>
    <td class="res">
      <input type="submit" name="Submit" value="Submit">
      <input type="reset" name="Submit2" value="Reset">
    </td>
  </tr>

</table>                                  </form>

</body>
</html>