<html>
<head>
<title>Un title page</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>

<body bgcolor="#FFFFFF">
<form name="form1" method="post" action="add.php" enctype="multipart/form-data">
  <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center"  class="tborder">
    <tr> 
      <td colspan="2"  class="red"> 
        <div align="center"> 
          แบบฟอร์มสำหรับเพิ่ม-แก้ไขงานวิจัย / โครงงาน / การศึกษาค้นคว้าด้วยตนเอง 
            / วิทยานิพนธ์ <br>
            Add your Research / Project / Senior Project / Independent Study / 
            Thesis<br>
            ( File ที่จะ upload ควรเป็น PDF ไฟล์)
        </div>
      </td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="26%" valign="top"  class="bblack">ชื่องานวิจัย / โครงงาน</td>
      <td width="74%" class="main"> 
        <input type="text" name="rs_title_thai" size="50">
      </td>
    </tr>
    <tr> 
      <td width="26%" valign="top" class="bblack">ชื่องานวิจัย / โครงงาน (ภาษาอังกฤษ)</td>
      <td width="74%" class="main"> 
        <input type="text" name="rs_title_eng" size="50">
      </td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="26%" valign="top" class="bblack">Keywords ของงานวิจัยหรือโครงงาน 
        (สำหรับให้ผู้อื่นได้ค้นหาโครงงาน)</td>
      <td width="74%" class="main"> 
        <textarea name="rs_keyword" cols="50" rows="4" class="main"></textarea>
        เช่น html,web,xml ฯลฯ</td>
    </tr>
    <tr> 
      <td width="26%" valign="top"class="bblack">Introduction</td>
      <td width="74%" class="main"> 
        <input type="file" name="rs_intro">
      </td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="26%" valign="top" class="bblack">Objective and Scope</td>
      <td width="74%" class="main"> 
        <input type="file" name="rs_objective">
      </td>
    </tr>
    <tr> 
      <td width="26%" valign="top" class="bblack">Current Problem</td>
      <td width="74%" class="main"> 
        <input type="file" name="rs_problem">
      </td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="26%" valign="top" class="bblack">Literature Review</td>
      <td width="74%" class="main"> 
        <input type="file" name="rs_literature">
      </td>
    </tr>
    <tr> 
      <td width="26%" valign="top" class="bblack" >Design Approach</td>
      <td width="74%" class="main" > 
        <input type="file" name="rs_design">
      </td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="26%" valign="top" class="bblack">Development</td>
      <td width="74%" class="main"> 
        <input type="file" name="rs_development">
      </td>
    </tr>
    <tr> 
      <td width="26%" valign="top" class="bblack">Testing</td>
      <td width="74%" class="main"> 
        <input type="file" name="rs_testing">
      </td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="26%" valign="top" class="bblack">Result and Conclusion</td>
      <td width="74%" class="main"> 
        <input type="file" name="rs_result">
      </td>
    </tr>
    <tr>
      <td width="26%" valign="top" class="bblack">หัวข้ออื่น ๆ (หากต้องการเพิ่มเติม)</td>
      <td width="74%" class="main"> ชื่อหัวข้อที่ต้องการเพิ่ม 
        <input type="text" name="rs_other1_text">
        <br>
        เลือกไฟล์ 
        <input type="file" name="rs_other1">
      </td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="26%" class="bblack">&nbsp;</td>
      <td width="74%" class="main"> 
        <input type="Submit" name="Submit" value="Add">
        <input type="reset" name="Submit2" value="Clear">
      </td>
    </tr>
  </table>
</form>
</body>
</html>