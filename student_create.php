<?
require ("include/global.php");

function password(){
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

if(!$login || $login==""){
        ?>
                <html>
                <head>
                <link rel="STYLESHEET" type="text/css" href="main.css">
                <script type="text/javascript" language="JavaScript" src="check_pass.js"></script>
                </head>
                <body bgcolor="#ffffff" leftmargin="0" topmargin="0">
                <center>
                <h1 class="h3">สร้างบัญชีรายชื่อใหม่(สำหรับนิสิต)</h3>
                <form action="student_create.php" method="post" name="create_login" onSubmit="return verify(this);">
                <table>
                       <tr>
                                <td class="info" align="right">คำนำหน้า :</td>
                                <td class="main"><input type="text" name="title"> (นาย นางสาว ร.ต. มล. ฯลฯ)</td>
                        </tr>
                       <tr>
                                <td class="info" align="right">ชื่อ :</td>
                                <td class="main"><input type="text" name="firstname"> (ไทย)</td>
                        </tr>
                        <tr>
                                <td class="info" align="right">นามสกุล</td>
                                <td class="main"><input type="text" name="surname"> (ไทย)</td>
                        </tr>
                        <tr>
                                <td class="info" align="right">ภาควิชา:</td>
                                <td class="main">
                                  <select name="dept" >
          <option value="no">-------เลือกภาควิชา---------</option>
          <option value="none">ยังไม่แยกภาควิชา</option>
          <option value="Aerospace">Aerospace</option>
          <option value="Agricultural">Agricultural</option>
          <option value="Architecture">Architecture</option>
          <option value="Chemical">Chemical</option>
          <option value="Civil ">Civil </option>
          <option value="Computer ">Computer </option>
          <option value="Electrical">Electrical</option>
          <option value="Environmental">Environmental</option>
          <option value="Food">Food</option>
          <option value="Industrail">Industrail</option>
          <option value="Irregation">Irregation</option>
          <option value="Material">Material</option>
          <option value="Mechanical">Mechanical</option>
          <option value="Water resource">Water resource</option>
                  </select></td>
                        </tr>
                          <tr><td></td><td class="info"><font color="#cc3300"> อย่าลืมเปลี่ยน mode การพิมพ์เป็นภาษาอังกฤษก่อนใส่ user name พร้อมทั้งอ่านคำแนะนำด้านล่าง !!</font></td>
                          </tr>
                           <tr>
                                <td class="info" align="right">User Name:</td>
                                <td class="main"><input type="text" name="login" maxlength="8">English</td>
</tr>
<tr><td class="info">วิธีการกรอกในช่อง username : </td>
                                <td class="info">ผู้ที่จะสร้างบัญชีรายชื่อใหม่จะต้องมี email address ของมหาวิทยาลัยเกษตรศาสตร์ อยู่แล้ว
<br>โดยให้กรอกเฉพาะชื่อ email เช่น email ของท่านเป็น b4123456@nontri.ku.ac.th <font color="#ff00cc"><b>ให้ใส่เฉพาะ b4123456 </font></b>เท่านั้น
<br>ท่านจะได้รับ password จะส่งกลับไปยัง email address
ของท่านที่ <font color="#cc0099">(your-account)@nontri.ku.ac.th </font>ทันที <br><br></td></tr>
<tr><td class="info">
ตัวอย่าง mail ที่ได้รับจะระบุดังนี้ :<br>
</td><td class="info">
 Username = b4123456  <br>
 password = xxxxxx    <br>
หมายเหตุ <br>
สำหรับ username ท่านไม่สามารถเปลี่ยนแปลงได้<br>  แต่สำหรับ password  สามารถเข้าไปในส่วนของ personal เพื่อทำการเปลี่ยนแปลงได้ภายหลัง</td></tr>


                        <tr>
                                <td class="main" align="center" colspan=2><input type="submit" name="subm" value="Create login"></td>
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
                        <link rel="STYLESHEET" type="text/css" href="main.css">
                </head>
                <body>
                <p>&nbsp;</p>
                <div class="h3"
align="center">บัญชีรายชื่อของท่าน  มีอยู่ในฐานข้อมูลแล้ว</div>
                <p>
                <div class="main"
align="center">ไม่สามารถสร้างบัญชีรายชื่อใหม่ให้กับท่านได้
หากมีปัญหาเกี่ยวกับบัญชีรายชื่อของท่าน ให้ส่ง email มาที่ <a
href="mailto:courseadmin@www2.eng.ku.ac.th">courseadmin@www2.eng.ku.ac.th</a></div>

                </body>
                </html>
                <?
        }else{                                                                                        // no existing user with that login and password
                $passwd=password();
                $emailhost="@nontri.ku.ac.th";
                $email="$login$emailhost";
                mysql_query("INSERT INTO users (active,login,password,email,firstname,surname,dept,category,title) VALUES (1,'".$login."','".$passwd."','".$email."','$firstname','$surname','$dept',3,'$title');");
                $id=mysql_insert_id();
                $mailbody = "Hi!\n\nUse this login information:\nUser
Name:".$login."\nPassword:".$passwd."\n\nWelcome to Classroom Support at Faculty of
Engineering , KU";
                if(mail($email,"Welcome to
Classroom Support",$mailbody,"From:courseadmin@$SERVER_NAME")){
                        ?>
                        <html>
                        <head>
                                <link rel="STYLESHEET" type="text/css" href="main.css">
                        </head>
                        <body>
                        <p>&nbsp;</p>
                        <div class="h3" align="center">OK, created new login.</div>
                        <p>
                        <div class="main" align="center">Please check your email for password and further instructions.</div>

                        </body>
                        </html>
                        <?
                }else{
                        ?>
                        <html>
                        <head>
                                <link rel="STYLESHEET" type="text/css" href="main.css">
                        </head>
                        <body>
                        <p>&nbsp;</p>
                        <div class="h3" align="center">Error sending email.</div>
                        <p>
                        <div class="main" align="center">Did you write a valid
email?<br>Contact the administrator <a href="mailto:courseadmin@<?echo
$SERVER_NAME?>">courseadmin@<?echo $SERVER_NAME?></a>.</div>
                        </body>
                        </html>
                        <?
                }
        }
}
mysql_close();
?>