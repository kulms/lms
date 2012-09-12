<?
/* 
 * **********************************************
 * **    PHP - WebBoard : Edit User Profile    **
 * **********************************************
 * *                                            *
 * * Developed By : Sansak Chairattanatrai      *
 * * E-mail :  sansak@engineer.com              *
 * * UIN : 5590582                              *
 * * License : SamChai Public Soft Group(tm).   *
 * *                                            *
 * **********************************************
 */  

	require("config.inc.php");
	
?>

<html>
<head>
<title>ระบบจัดการข้อมูลสมาชิก PHP - Ultimate Webboard 2.00</title>
<head>

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
    <h2><font color=blue>PHP - Ultimate Webboard <font color=red>2.00</font></font></h2>
	</font>
	<center>
	<font size=3 color=#9400D3><b>แก้ไขข้อมูลสมาชิกเว็บบอร์ด</b></font>
	</font>
	<br><br>

<?
	// ตรวจสอบว่ามี username หรือไม่
	mysql_connect($host,$user,$passwd);
	$sql = "select * from webboard_member where User='$uid'";
	$result = mysql_db_query($dbname,$sql);
	$NRow = mysql_num_rows($result);

	if($NRow==0) { 
		err_msg("Error : Username and Password","กรุณาตรวจสอบอีกครั้ง","");
		echo "<br><br><br><br><br><br><br><br><br>\n";
		exit(); 
	}

	$row = mysql_fetch_array($result);
	$User = $row["User"];
	$Password = $row["Password"];
	$Email = $row["Email"];
	$ICQ = $row["ICQ"];
	$WebName = $row["WebName"];
	$URL = $row["URL"];

	// ตรวจสอบการ login
	if($action=="login") {
		if($uid!=$User || $pwd!=$Password) {
			err_msg("Error : Username and Password","กรุณาตรวจสอบอีกครั้ง","");
		}
	}
	else {
		err_msg("Error : Method","กรุณา Login ก่อนเข้าระบบ","login.php");
	}

?>

	<form method=post action="register.php" name="webForm" onsubmit="return check()">
	<table border=1 bordercolor=#1E90FF bgcolor=E0FFFF cellpadding=3 cellspacing=0>
	<tr><td align=left>Username</td><td><b><? echo $User;?></b></td></tr>
	<tr><td align=left>Password</td><td><input type=password name="Pass1" size=20 maxlength=10><font color=red>**</font></td></tr>
	<tr><td align=left>Re-Password</td><td><input type=password name="Pass2" size=20 maxlength=10><font color=red>**</font></td></tr>
	<tr><td align=left>E-mail</td><td><input type=text name="Email" size=20 maxlength=30 value="<? echo $Email;?>"><font color=red>**</font></td></tr>
	<tr><td align=left>ICQ</td><td><input type=text name="ICQ" size=20 maxlength=15 value="<? echo $ICQ;?>"><font color=red>(Option)</font></td></tr>
	<tr><td align=left>Web Name</td><td><input type=text name="WebName" size=40 maxlength=80 value="<? echo $WebName;?>"><font color=red>(Option)</font></td></tr>
	<tr><td align=left>URL</td><td><input type=text name="URL" size=40 maxlength=80 value="<? echo $URL;?>"><font color=red>(Option)</font></td></tr>
	</table>
	<br>
	<input type="hidden" name="Category" value="<?echo $Category;?>">
	<input type="hidden" name="page" value="<?echo $page;?>">
	<input type="hidden" name="User" value="<?echo $User;?>">
	<input type="hidden" name="action" value="edit">
	<input type=submit value="บันทึกข้อมูล"> 
    </form>

	<font size=2 face="MS Sans Serif">
	[ <a href="../webboard/webboard.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>">ไปหน้าเว็บบอร์ด</a> | 
	<a href="../webboard/addmember.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>">สมัครสมาชิก</a> ]
	<font>

<script language="JavaScript">
<!--
function check()
{
	var v1 = document.webForm.Pass1.value;
	var v2 = document.webForm.Pass2.value;
	var v3 = document.webForm.Email.value;
        if (v1.length==0)
           {
           alert("กรุณากำหนด Password");
           document.webForm.Pass1.focus();           
		   return false;
           }
        else if (v2.length==0)
           {
           alert("กรุณาป้อน Password อีกครั้ง");
           document.webForm.Pass2.focus();           
		   return false;
           }
		else if (v3.length==0)
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

	<? footer(); ?>

	</center>
</body>
</html>

<?
function err_msg($topic,$detial,$url) {
	echo "<center>";
	echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
	echo "<tr><td align=center>";
	echo "<font size=2 face='MS Sans Serif'>";
	echo "<font size=3 color=red><b>$topic</b></font><br><br>";
	echo $detial;
	echo "</font></td></tr></table>";
	echo "<br>";
	echo "<font size=2 face='MS Sans Serif'>";
	if(!$url) {
		echo "[<a href='javascript:history.back(1)'>Back</a>]";
	} 
	else {
		echo "[<a href='$url'>Back</a>]";
	}
	echo "</font><br><br>";
	footer();
	echo "</center>";
	exit();
}

function footer() {
	echo "<br><br>";
	echo "<hr color=1E90FF>";
	echo "<font size=1 face='MS Sans Serif'>";
	echo "<b>Copy<font color=FF1493>LEFT</font> and Powered By : <a href='http://sansak.saxen.net/' target='php'>Sansak</a></b>";
	echo "</font>";
}
?>