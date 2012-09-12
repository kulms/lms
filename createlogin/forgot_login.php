<? require ("../include/global.php");

// Complete this script with mail function!
function password()
{
        srand((double)microtime()*1000000);
        $numchar=rand(4,6);
        $temp="";
        for($b=0;$b<$numchar;$b++)
		{
                $chrnum=rand(48,109);
                if($chrnum>57)
                        $chrnum+=7;

                if($chrnum>90)
                        $chrnum+=6;
            
                $temp=$temp.chr($chrnum);
        }
        return $temp;
}
if((!$forgot) || ($forgot==""))
{
?>
<html>
<head>
        <link rel="STYLESHEET" type="text/css" href="../main.css">
        <script type="text/javascript" language="JavaScript" src="check_pass.js"></script>
</head>
<body bgcolor="#0033CC">
<p>&nbsp;</p>
<div  align="center"><font face="MS Sans Serif, Microsoft Sans Serif" size="1"><b><font color="#FFCCFF">กรณีลืมรหัสผ่าน
  (Forgotten Your Password)</font></b></font></div>
<div  align="center"></div>
<form action="forgot_login.php" method="post" onSubmit="return checkmail(this);">

  <table align="center" width="333">
    <tr>

      <td class="info"><font color="#FFFFCC"><b>Your E-Mail :</b></font></td>
                        <td class="main"><input type="text" name="loginname" size="10">
        <b><font face="MS Sans Serif, Microsoft Sans Serif" color="#FFFFCC" size="1">
        @ku.ac.th </font></b></td>
                </tr>
                <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="forgot" value="Send me my password!"></td>
                </tr>
        </table>
</form>
</body>
</html>
<?
}else{
//$passwd=password();
$emailhost="@nontri.ku.ac.th";
$email="$loginname$emailhost";
$selectpwd=mysql_query("SELECT password FROM users WHERE email='".$email."';");
$passwd=mysql_result($selectpwd,0,"password");
//mysql_query("UPDATE users set password='".$passwd."'  WHERE email='".$email."';");
        $userinfo=mysql_query("SELECT login,password,email,firstname FROM users WHERE email='".$email."';");
        if($row=mysql_fetch_array($userinfo)){
                $mailbody = "Hi ".$row["firstname"]."!\n\n These are your UserName and Password
\nusername : ".$row["login"]."\nPassword : ".$row["password"]."\n\n
Classroom Support , Faculty of Engineering Courseware, KU";
                if($a=mail($row["email"],"Your forgotten password",$mailbody,"FROM:admin@$SERVER_NAME")){
                        ?>
                        <html>
                        <head>
                                <link rel="STYLESHEET" type="text/css" href="../main.css">
                        </head>
                        <body bgcolor="#ffffff"><p>&nbsp;</p>
                                 <div class="main"
align="center"><font size=+2 color="#cc0099">พบบัญชีรายชื่อของท่านอยู่ในฐานข้อมูลจริงและได้ส่งรหัสผ่านชุดใหม่กลับไปยัง <font color="green"><b><?echo $loginname;?>@ku.ac.th </font></b>แล้ว<br>
                                Check Password in your Mail !!!<br>
<a href="https://webmail.ku.ac.th"><div class="main">ไปเช็คเมลล์<img
src="../images/nontri_mail.jpg" border="0"></font></div>
                         </body>
                        </html>
        <?
                }else{   ?>
                        <html>
                        <head>
                                <link rel="STYLESHEET" type="text/css" href="main.css">
                        </head>
                        <body bgcolor="#ffffff"><p>&nbsp;</p>
                                 <div class="main" align="center">Sorry, an internal error occured. Please try again .......</div>
                         </body>
                        </html>
                <?     }
        }
        else{
?>
                <html>
                <head>
                        <link rel="STYLESHEET" type="text/css" href="main.css">
                        <script type="text/javascript" language="JavaScript" src="check_pass.js"></script>
                </head>
                <body bgcolor="#ffffff">
                <p>&nbsp;</p>
                        <div class="h3" align="center">ไม่พบรายชื่อ (User Name
ของท่านในฐานข้อมูล :-( <br>
โปรดตรวจสอบว่าท่านได้ใส่ถูกต้องหรือไม่ และใส่เฉพาะ user name เท่านั้น <br>
เช่น <font color="#cc0099">g4165265 , fengsnc </font>เป็นต้น</div>
                </body>
                </html>
<?
        }
}              ?>
