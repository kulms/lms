<?require ("include/global.php");

// Complete this script with mail function!

if((!$forgot) || ($forgot=="")){
?>
<html>
<head>
	<link rel="STYLESHEET" type="text/css" href="main.css">
	<script type="text/javascript" language="JavaScript" src="check_pass.js"></script>	
</head>
<body bgcolor="#ffffff">
<p>&nbsp;</p>
<div class="h3" align="center">กรณีลืม password</div>
<div class="h5" align="center"></div>
<p>
<div class="main" align="center">ให้ใส่ Username ที่ท่านใช้อยู่ <br>
password ของท่านจะถูกส่งกลับไปยัง <font
color="cc0099">(your-account)@nontri.ku.ac.th</font> ทันที</div>
<form action="forgot_login.php" method="post" onSubmit="return checkmail(this);">
	<table align="center">
		<tr>
			<td class="info">User Name  </td>
			<td class="main"><input type="text" name="loginname" size="25"></td>
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
}
else{
$emailhost="@nontri.ku.ac.th";
$email="$loginname$emailhost";
	$userinfo=mysql_query("SELECT login,password,email,firstname FROM users WHERE email='".$email."';");
	if($row=mysql_fetch_array($userinfo)){
		$mailbody = "Hi ".$row["firstname"]."!\n\n User Name และ Password ของท่าน
\nlogin:".$row["login"]."\nPassword:".$row["password"]."\n\n
Course on Web , คณะวิศวกรรมศาสตร์ , มหาวิทยาลัยเกษตรศาสตร์";
		if($a=mail($row["email"],"Your login
information",$mailbody,"From:courseadmin@$SERVER_NAME")){
			?>
			<html>
			<head>
				<link rel="STYLESHEET" type="text/css" href="main.css">
			</head>
			<body bgcolor="#ffffff"><p>&nbsp;</p>
				 <div class="main"
align="center"><font size=+2 color="#cc0099">พบบัญชีรายชื่อของท่านอยู่ในฐานข้อมูลจริง <br>
				Check Password in your Mail!!!
</font></div>
			 </body>
			</html>
	<?
		}
		else{?>
			<html>
			<head>
				<link rel="STYLESHEET" type="text/css" href="main.css">
			</head>
			<body bgcolor="#ffffff"><p>&nbsp;</p>
				 <div class="main" align="center">Sorry, an internal error occured. Please try again later...</div>
			 </body>
			</html>
		<?}
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
}?>
