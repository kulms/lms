<?  require ("../include/global.php");  ?>
<html>
<head>
<title>.:: Trainee or other apply system ::.</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body  bgcolor="#0a39c7" leftmargin="0" topmargin="0" text="#FFFF00">

<form action="trainee_create.php" method="post" name="create_login";">

  <table align="center" width="550">
    <tr><td class="info" align="right" colspan="2">&nbsp;</td></tr>
    <tr bgcolor="#FFFFCC"> 
      <td colspan="2" align="center" class="info"><font size="1" color="#0033CC"><b>ขั้นตอนที่ 
          2 แบบฟอร์มกรอกรายละเอียด(สำหรับผู้เข้าอบรมหรือบุคคลภายนอก)</b></font></td>
    </tr>
    <tr>
      <td align="right" class="info"><b><font color="#CCCC00">Login :</font></b></td>
      <td class="main"><input name="login" type="text" id="login" maxlength="255">
        ( Case sensitive and English ONLY)</td>
    </tr>
	<!--<tr> 
      <td align="right" class="info"><b><font color="#CCCC00">Password :</font></b></td>
      <td class="main"><input name="password" type="text" id="password" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="info"><b><font color="#CCCC00">Confirm password :</font></b></td>
      <td class="main"><input name="password2" type="text" id="password2" maxlength="255"></td>
    </tr> -->
    <tr> 
      <td align="right" class="info"><b><font color="#CCCC00">คำนำหน้าชื่อ :</font></b></td>
      <td class="main"> <font color="#CCCC00"> 
        <input name="title" type="text" size="8" maxlength="32">
        ( นาย/นางสาว/ร.ต./มล./ฯลฯ)</font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">ชื่อ :</font></b></td>
      <td class="main"> <font color="#CCCC00"> 
        <input name="firstname" type="text" maxlength="255">
        ( กรอกเป็นภาษาไทย)</font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">นามสกุล :</font></b></td>
      <td class="main"> <font color="#CCCC00"> 
        <input name="surname" type="text" maxlength="255">
        ( กรอกเป็นภาษาไทย)</font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">โฮมเพจ :</font></b></td>
      <td class="main"><input name="homepage" type="text" id="homepage" maxlength="255"></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">ที่ตั้งสำนักงาน :</font></b></td>
      <td class="main"><font color="#CCCC00">
<textarea name="office_address" rows="4" wrap="PHYSICAL" id="office_address" cols="80"></textarea>
        </font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">โทรศัพท์ :</font></b></td>
      <td class="main"><input name="office_telephone" type="text" id="telephone3">
        ( โทรศัพท์ที่ทำงาน)</td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00"> ที่อยู่ :</font></b></td>
      <td class="main"><font color="#CCCC00"> 
        <input name="address" type="text" id="address">
        ( ที่อยู่ตามทะเบียนบ้านหรือที่พักปัจจุบัน) </font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">โทรศัพท์ :</font></b></td>
      <td class="main"><input name="telephone" type="text" id="telephone">
        ( โทรศัพท์ที่พัก/ส่วนตัว) </td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">มือถือ :</font></b></td>
      <td class="info"><input name="mobile" type="text" id="mobile"></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#CCCC00">ความสนใจ :</font></b></td>
      <td class="info"><input name="skill_interest" type="text" id="skill_interest"></td>
    </tr>
    <tr> 
      <td><b><font color="#CCCC00"></font></b></td>
      <td class="info"><font color="#CCCC00"> อย่าลืม!!เปลี่ยน mode การพิมพ์เป็นภาษา<font color="#FF99FF"> 
        <b>อังกฤษตัวเล็ก</b></font>ก่อนกรอกในช่อง E-Mail </font></td>
    </tr>
    <tr> 
      <td class="info" align="right" height="2"><b><font color="#CCCC00">E-Mail :</font></b></td>
      <td class="main"> <font color="#CCCC00"> 
        <input type="text" name="email2" maxlength="255">
        ( ที่สามารถให้จัดส่ง password ไปให้ท่านได้)</font></td>
    </tr>
    <tr> 
      <td class="main" align="center" colspan=2> <input type="submit" name="subm" value="Submit"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFCC"> 
      <td class="main" align="center" colspan=2><font color="#FFFF00"><b><font size="1" color="#0033CC"> 
        <a href="create_login.php">ย้อนกลับไปขั้นตอนที่ 1</a></font></b></font></td>
    </tr>
  </table>

  </form>
  
</body>
</html>