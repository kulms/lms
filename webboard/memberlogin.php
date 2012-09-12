<html>
<head>
<title>ระบบจัดการข้อมูลสมาชิก </title>
</head>

<style type="text/css">
<!-- 
BODY {font-family:;font-size="10"}
A:link {text-decoration: none; color: blue }
A:visited {text-decoration: none; color: blue }
A:hover {text-decoration: none; color: darkorange }
A:active {text-decoration: none; color: blue }
p, div, td, ul li, ol li { font-family:  MS Sans Serif, Microsoft Sans Serif;  font-size: 10pt }
-->
</style>

<body bgcolor=#FFFFE0>
	<font size=2 face="Arial,MS Sans Serif">
    
<h2><font color=blue>Alumni Discussion Board</font></h2>
	</font>
	<center>
	<font size=3 color=#9400D3><b>แก้ไขข้อมูลสมาชิกเว็บบอร์ด</b></font>
	</font>
	<br>

	<form method=post action="editprofile.php?action=login">
	<table border=1 width=230 bordercolor=#1E90FF bgcolor=E0FFFF cellpadding=2 cellspacing=0>
	<tr><td>Username</td><td><input type=text name="uid" size=20 maxlength=20></td></tr>
	<tr><td>Password</td><td><input type=password name="pwd" size=20 maxlength=20></td></tr>
	</table>
	<br>
	<input type="hidden" name="Category" value=<?echo $Category;?>>
	<input type="hidden" name="page" value=<?echo $page;?>>
	<input type=submit value="Log in"> 
	</form>

	<hr color=1E90FF>
	</center>
</body>
</html>
