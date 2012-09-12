<html>
<head>
<title>Webboard </title>
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
    
<h2><font color=blue>Alumni<font color=red></font></font></h2>
	<center>
	<font size=3 color=#9400D3><b>สมัครสมาชิกเว็บบอร์ด</b></font>
	</font>
	<br>

	<form method=post action="register.php" name="webForm" onsubmit="return check()">
	<table border=1 bordercolor=#1E90FF bgcolor=E0FFFF cellpadding=3 cellspacing=0>
	<tr><td align=left>Username</td><td><input type=text name="User" size=20 maxlength=10><font color=red>**</font></td></tr>
	<tr><td align=left>Password</td><td><input type=password name="Pass1" size=20 maxlength=10><font color=red>**</font></td></tr>
	<tr><td align=left>Re-Password</td><td><input type=password name="Pass2" size=20 maxlength=10><font color=red>**</font></td></tr>
	<tr><td align=left>E-mail</td><td><input type=text name="Email" size=20 maxlength=30><font color=red>**</font></td></tr>
	<tr><td align=left>ICQ</td><td><input type=text name="ICQ" size=20 maxlength=15><font color=red>(Option)</font></td></tr>
	<tr><td align=left>Web Name</td><td><input type=text name="WebName" size=40 maxlength=80><font color=red>(Option)</font></td></tr>
	<tr><td align=left>URL</td><td><input type=text name="URL" size=40 maxlength=80 value="http://"><font color=red>(Option)</font></td></tr>
	</table>
	<br>
	<input type="hidden" name="Category" value=<?echo $Category;?>>
	<input type="hidden" name="page" value=<?echo $page;?>>
	<input type=submit value="สมัครสมาชิก"> 
    <input type=reset value="ยกเลิก">
	</form>

	<font size=2 face="MS Sans Serif">
	[ <a href="../webboard/webboard.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>">ไปหน้าเว็บบอร์ด</a> | 
	<a href="../webboard/memberlogin.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>">แก้ไขข้อมูลสมาชิก</a> ]
	<font>

	<hr color=1E90FF width=600>
</center>

<script language="JavaScript">
<!--
function check()
{
      var v1 = document.webForm.User.value;
      var v2 = document.webForm.Pass1.value;
      var v3 = document.webForm.Pass2.value;
	  var v4 = document.webForm.Email.value;
        if ( v1.length==0)
           {
           alert("กรุณากำหนด Username");
           document.webForm.User.focus();           
           return false;
           }
        else if (v2.length==0)
           {
           alert("กรุณากำหนด Password");
           document.webForm.Pass1.focus();           
		   return false;
           }
        else if (v3.length==0)
           {
           alert("กรุณาป้อน Password อีกครั้ง");
           document.webForm.Pass2.focus();           
		   return false;
           }
		else if (v4.length==0)
           {
           alert("กรุณาป้อน Email Address");
           document.webForm.Email.focus();           
		   return false;
           }
        else
           return true;
}
//-->
</script>
</body>
</html>
