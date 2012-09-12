<?
/* 
 * **********************************************
 * **     PHP - WebBoard : Member Register     **
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


<?
	$User = trim(htmlspecialchars($User));
	$Pass1 = trim(htmlspecialchars($Pass1));
	$Pass2 = trim(htmlspecialchars($Pass2));
	$Email = trim(htmlspecialchars($Email));
	$ICQ = trim(htmlspecialchars($ICQ));
	$WebName = trim(htmlspecialchars($WebName));
	$URL = trim(htmlspecialchars($URL));

	// ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
	$n_pw1 = strlen($Pass1);
	if($Pass1!=$Pass2 || $n_pw1<4) {
		echo "<center>";
		echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
		echo "<tr><td align=center>";
		echo "<font size=2 face='MS Sans Serif'>";
        echo "<font size=3 color=red><b>รหัสผ่านไม่ตรงกัน</b></font><br><br>";
		echo "หรือน้อยกว่า 4 หลัก กรุณาตรวจสอบให้ถูกต้องด้วยครับ : )";
		echo "</font></td></tr></table>";
		echo "<br><hr width=500 color=blue>";
		echo "<font size=2 face='MS Sans Serif'>";
		echo "[<a href='javascript:history.back(1)'>Back</a>]";
		echo "</center>";
		exit();
	}

	if($action!="edit") {
	// ตรวจสอบว่า user ที่รับมาเคยลงทะเบียนไปหรือยัง
	mysql_connect($host,$user,$passwd);
	$sql = "select User from webboard_member where User='$User'";
	$result = mysql_db_query($dbname,$sql);
	$NRow = mysql_num_rows($result);

	// ถ้าเคยลงทะเบียนแล้ว ให้แจ้งข้อผิดพลาด
	if($NRow!=0) {
		echo "<center>";
		echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
		echo "<tr><td align=center>";
		echo "<font size=2 face='MS Sans Serif'>";
        echo "<font size=3 color=red><b>Username [$User] ได้ถูกใช้ไปแล้ว</b></font><br><br>";
		echo "กรุณาเปลี่ยน Username ด้วยครับ";
		echo "</font></td></tr></table>";
		echo "<br><hr width=500 color=blue>";
		echo "<font size=2 face='MS Sans Serif'>";
		echo "[<a href='javascript:history.back(1)'>Back</a>]";
		echo "</center>";
		exit();
	}
	mysql_close(); 
	}

	// ป้องกันการแทรก html กับ ละเครื่องหมาย ' "
	$User = htmlspecialchars($User);
	$Password = htmlspecialchars($Pass1);
	$Email = htmlspecialchars($Email);
	$ICQ = htmlspecialchars($ICQ);
	$WebName = htmlspecialchars($WebName);
	$URL = htmlspecialchars($URL);

	// ปรับเวลาให้ตรงกับเวลาเมืองไทย กรณีที่ server อยู่ที่เมืองนอก
	$mdate = date("j M Y H:i",mktime( date("H")+$p_hour, date("i")+$p_min ));

	// บันทึกข้อมูลลงฐานข้อมูล
	mysql_connect($host,$user,$passwd);
	if($action=="edit") {
		$sql = "update webboard_member set Password='$Password' , Email='$Email' , ICQ='$ICQ' , WebName='$WebName' , URL='$URL' where User='$User'";
	}
	else {
		$sql = "insert into webboard_member (User,Password,Email,ICQ,WebName,URL,Date) values ('$User','$Password','$Email','$ICQ','$WebName','$URL','$mdate')";
	}
	$result = mysql_db_query($dbname,$sql);

	if($result==0) {
		echo "<center>";
		echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
		echo "<tr><td align=center>";
		echo "<font size=2 face='MS Sans Serif'>";
        echo "<font size=3 color=red><b>มีข้อผิดพลาดที่ระบบ</b></font><br><br>";
		echo "กรุณาแจ้ง admin ให้ตรวจสอบด้วยครับ";
		echo "</font></td></tr></table>";
		echo "<br><hr width=500 color=blue>";
		echo "<font size=2 face='MS Sans Serif'>";
		echo "[<a href='javascript:history.back(1)'>Back</a>]";
		echo "</center>";
		exit();
	}
	mysql_close(); 

	if($action=="edit") {
		echo "<center>";
		echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
		echo "<tr><td align=center>";
		echo "<font size=2 face='MS Sans Serif'>";
		echo "<font size=3 color=red><b>ได้แก้ไขข้อมูลของ $User </b></font><br><br>";
		echo "และบันทึกลงในฐานข้อมูลแล้ว";
		echo "</font></td></tr></table>";
		echo "<br><hr width=500 color=blue>";
		echo "<font size=2 face='MS Sans Serif'>";
	}
	else {
		echo "<center>";
		echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
		echo "<tr><td align=center>";
		echo "<font size=2 face='MS Sans Serif'>";
		echo "<font size=3 color=red><b>ได้เพิ่มข้อมูลของ $User </b></font><br><br>";
		echo "ลงในฐานข้อมูลแล้ว";
		echo "</font></td></tr></table>";
		echo "<br><hr width=500 color=blue>";
		echo "<font size=2 face='MS Sans Serif'>";
	}

?>
	<br>
	<font size=2 face="MS Sans Serif">
	[<a href="../webboard/webboard.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>">ไปหน้าเว็บบอร์ด</a>]
	<font>
</center>