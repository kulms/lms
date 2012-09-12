<? require ("../include/global.php");

function password()
{
        srand((double)microtime()*1000000);
        $numchar=rand(4,6);
        $temp="";
        for($b=0;$b<$numchar;$b++){
                $chrnum=rand(48,109);
                if($chrnum>57){
                        $chrnum+=7;
                }
                if($chrnum>90){
                        $chrnum+=6;
                }
                $temp=$temp.chr($chrnum);
        }
        return $temp;
}

if(!$login || $login=="")
{        ?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../../main.css">
<script type= "text/javascript"  language="javaScript" src="../check_pass.js"></script>
<title>Step 2 form For Staff</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>                
<body bgcolor="#0a39c7" leftmargin="0" topmargin="0">
<form action="../teacher_filling.php" method="post" name="create_login" onSubmit="return verify(this);">
                
  <table align="center" width="658">
    <tr bgcolor="#FFFFCC"> 
      <td class="main" align="center" colspan=2><b><font size="1" color="#0033CC">ขั้นตอนที่ 2 แบบฟอร์มกรอกรายละเอียด (สำหรับเจ้าหน้าหรือพนักงานของคณะ ฯ )</font></b></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#FFFFCC">คำนำหน้า :</font></b></td>
      <td class="main"> <font color="#FFFFCC"><input type="text" name="title" size="10">(นาย/นางสาว/ร.ต./ มล./ฯลฯ)</font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#FFFFCC">ชื่อ :</font></b></td>
      <td class="main"> <font color="#FFFFCC"><input type="text" name="firstname">(กรอกเป็นภาษาไทย)</font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#FFFFCC">นามสกุล</font></b></td>
      <td class="main"> <font color="#FFFFCC"><input type="text" name="surname">(กรอกเป็นภาษาไทย)</font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#FFFFCC">คณะหรือหน่วยงานต้นสังกัด:</font></b></td>
      <td class="main"><select name="select">
          <option>------- คณะหรือหน่วยงานต้นสังกัด -------------</option>
          <option>คณะวิศวกรรมศาสตร์</option>
          <option>สำนักอธิการบดี</option>
        </select></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#FFFFCC">ภาควิชาหรือฝ่ายที่สังกัด:</font></b></td>
      <td class="main"><select name="select2">
          <option>------- ภาควิชาหรือฝ่ายที่สังกัด -----------------</option>
          <option>วิศวกรรมเคมี</option>
          <option>วิศวกรรมเครื่องกล</option>
          <option>วิศวกรรมคอมพิวเตอร์</option>
          <option>วิศวกรรมทรัพยากรน้ำ</option>
          <option>วิศวกรรมเหมืองแร่</option>
          <option>วิศวกรรมไฟฟ้า</option>
          <option>วิศวกรรมโยธา</option>
          <option>กองกลาง</option>
          <option>กองการเจ้าหน้าที่</option>
          <option>กองกิจการนิสิต</option>
          <option>กองคลัง</option>
          <option>กองบริการการศึกษา</option>
          <option>กองแผนงาน</option>
          <option>กองวิเทศสัมพันธ์</option>
          <option>กองยานพาหนะอาคารและสถานที่ </option>
          <option>หน่วยตรวจสอบภายใน </option>
        </select></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#FFFFCC">สาขาวิชาหรือแผนกที่สังกัด:</font></b></td>
      <td class="main"> <font color="#FFFFCC"> 
        <select name="select3">
          <option>------- เลือกสาขาวิชาหรือแผนกที่สังกัด -------</option>
          <option>เทคโนโลยีสารสนเทศ</option>
          <option>วิศวกรรมคอมพิวเตอร์</option>
          <option>งานบริหารงานบุคคล </option>
          <option>งานวินัยและนิติการ</option>
          <option>งานทะเบียนประวัติ</option>
          <option>งานธุรการ</option>
          <option>งานสวัสดิการ </option>
        </select>
        <!--
        <select name="dept" >
          <? //$select=mysql_query("SELECT fullname FROM department;");?>
          <option value="no">-------------เลือกภาควิชาหรือหน่วยงาน------------</option>
          <? //while ($row=mysql_fetch_array($select))
		  //			{ ?>
          <option value="<?// echo $row["fullname"]; ?>"><?// echo $row["fullname"];  ?></option>
          <? // } ?>
        </select>
		-->
        </font></td>
    </tr>
    <tr> 
      <td><b><font color="#FFFFCC"></font></b></td>
      <td class="info"><font color="#FFFFCC"> เปลี่ยน mode การพิมพ์เป็นภาษาอังกฤษก่อนใส่ email</font></td>
    </tr>
    <tr> 
      <td class="info" align="right"><b><font color="#FFFFCC">Email:</font></b></td>
      <td class="main"> <font color="#FFFFCC"><input type="text" name="login" maxlength="8" size="10">@ku.ac.th </font>
		<font color="#CCCC00">( @ku.ac.th หรือ @nontri.ku.ac.th คือ email ที่เดียวกัน)</font></td>
    </tr>
    <tr> 
      <td class="main" align="center" colspan=2> <input type="submit" name="subm" value="Submit"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFCC"> 
      <td class="main" align="center" colspan=2>
	  <font color="#FFFF00"><b><font size="1" color="#0033CC"><a href="../create_login.php">ย้อนกลับไปขั้นตอนที่ 1</a></font></b></font></td>
    </tr>
    <tr> 
      <td class="main" align="center" colspan=2>&nbsp;</td>
    </tr>
  </table>
</form>
</center>
</body>
</html>
<?
}
else{
        $err=0;
        $users=mysql_query("SELECT id from users WHERE login='".$login."';");
        if($check=mysql_fetch_array($users)){        // if user exists
                ?>
                <html>
                <head>
                        <link rel="STYLESHEET" type="text/css" href="../../main.css">
                </head>
                <body>
                <p>&nbsp;</p>
                <div class="h3" align="center">บัญชีรายชื่อของท่าน  มีอยู่ในฐานข้อมูลแล้ว หากชื่อนี้ เป็นชื่อบัญชีผู้ใช้ของท่านจริง ๆ ให้ click ที่ ลืมรหัสผ่าน หรือ <a href="../forgot_login.php"> click ที่นี่ </a> เพื่อส่งรหัสผ่านใหม่ให้ท่าน</div>
                <p>
                <div class="main"
align="center">หากมีปัญหาเกี่ยวกับบัญชีรายชื่อของท่าน ให้ส่ง email มาที่ <a href="mailto:courseadmin@course.eng.ku.ac.th">courseadmin@course.eng.ku.ac.th</a></div>

                </body>
                </html>
                <?
        }else{        // no existing user with that login and password
                $passwd=password();
                $emailhost="@nontri.ku.ac.th";
                $email="$login$emailhost";
                mysql_query("INSERT INTO users (active,login,password,email,firstname,surname,dept,category,title) 
											VALUES (1,'".$login."','".$passwd."','".$email."','$firstname','$surname','$dept',4,'$title');");
                $id=mysql_insert_id();
                $mailbody = "Hi!\n\nUse this login information:\nUser Name:".$login."\nPassword:".$passwd."\n\nWelcome to Classroom Support at Faculty of Engineering , KU";
                if(mail($email,"Welcome to Classroom Support",$mailbody,"From:courseadmin@$SERVER_NAME"))
				{
                        ?>
                        <html>
                        <head>
                                <link rel="STYLESHEET" type="text/css" href="../../main.css">
                        </head>
                         <body bgcolor="#0a39c7" text="#FFFFCC" link="#FFFF99" vlink="#FFFFCC" alink="#FFFFCC">
                        <p>&nbsp;</p>
                        <div class="h3" align="center">บัญชีรายชื่อใหม่ของท่านได้ถูกสร้างเรียบร้อยแล้ว</div>
                        <p>
                        <div class="main" align="center"> รับ login และ password ได้ที่ email ของท่าน ( <font color="red"><? echo $login; ?>@nontri.ku.ac.th </font>)</div>
                        <p>
						 <p>
                        <div class="main" align="center">  เมื่อได้ loginname และ password แล้ว นำมาใช้งานกับระบบ ฯ สนับสนุนการเรียนการสอนผ่านเว็บที่ website <a href="http://course.eng.ku.ac.th">http://course.eng.ku.ac.th</a> ได้ทันที</div>
                        <p>
                        <hr width="50%">
                        <p>&nbsp;</p>
                        <div class="h3" align="center">OK, created new login.</div>
                        <p>
                        <div class="main" align="center">Please check  loginname and password  from your email ( <font color="red"><? echo $login; ?>@nontri.ku.ac.th </font> )</div>
                        <p> <div class="h3" align="center">After you've got your login name and password. Please use that information at  website<a href="http://course.eng.ku.ac.th"> http://course.eng.ku.ac.th </a></div>
                        <p>      
					</body>
                        </html>
                        <?
                }else{
                        ?>
                        <html>
                        <head>
                                <link rel="STYLESHEET" type="text/css" href="../../main.css">
                        </head>
                        <body>
                        <p>&nbsp;</p>
                        <div class="h3" align="center">Error sending email.</div>
                        <p>
                        <div class="main" align="center">Did you write a valid email?<br>Contact the administrator <a href="mailto:courseadmin@<? echo $SERVER_NAME; ?>">courseadmin@<? echo $SERVER_NAME; ?></a>.</div>
                        </body>
                        </html>
                        <?
                }
        }
}
mysql_close();
?>