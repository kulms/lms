<?
/* 
 * **********************************************
 * **     PHP - WebBoard : Install Database    **
 * **********************************************
 * *                                            *
 * * Developed By : Sansak Chairattanatrai      *
 * * E-mail :  sansak@engineer.com              *
 * * UIN : 5590582                              *
 * * License : SamChai Public Soft Group(tm).   *
 * *                                            *
 * **********************************************
 */  

	include("config.inc.php");

	mysql_connect($host,$user,$passwd) or die("Unable to Connect");

	$sql1 = "CREATE TABLE webboard_data (No int(5) DEFAULT '0' NOT NULL auto_increment, Category varchar(50) NOT NULL, Question varchar(100) NOT NULL, Note text NOT NULL, Name varchar(50) NOT NULL, Member tinyint(1) DEFAULT '0' NOT NULL, IP varchar(15) NOT NULL, Email varchar(50) NOT NULL, Date varchar(20) NOT NULL, Reply int(5) DEFAULT '0' NOT NULL, ReplyDate varchar(20) NOT NULL, Image blob, PRIMARY KEY (No))";

	$sql2 = "CREATE TABLE webboard_ans (No int(5) DEFAULT '0' NOT NULL auto_increment, QuestionNo int(5) DEFAULT '0' NOT NULL, Name varchar(50) NOT NULL, Member tinyint(1) DEFAULT '0' NOT NULL, IP varchar(15) NOT NULL, Email varchar(50) NOT NULL, Msg text NOT NULL, Date varchar(20) NOT NULL, Image blob, PRIMARY KEY (No))";

	$sql3 = "CREATE TABLE webboard_member (User char(10) NOT NULL, Password char(10) NOT NULL, Email char(30), ICQ char(15), WebName char(80), URL char(80), Date char(20) NOT NULL, PRIMARY KEY (User))";

	$result1 = mysql_db_query($dbname,$sql1);
	$result2 = mysql_db_query($dbname,$sql2);
	$result3 = mysql_db_query($dbname,$sql3);
	if($result1!=0 && $result2!=0 && $result3!=0) {
		echo "<center>";
		echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
		echo "<tr><td align=center>";
		echo "<font size=2 face='MS Sans Serif'>";
        echo "<font size=3 color=red><b>ได้สร้างฐานข้อมูลแล้ว</b></font><br><br>";
		echo "<font color=blue>webboard_ans , webboard_data , webboard_member</font>";
		echo "</font></td></tr></table>";
		echo "<br><hr width=500 color=blue>";
		echo "</center>";
		exit();
	}
	else {
		echo "<center>";
		echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
		echo "<tr><td align=center>";
		echo "<font size=2 face='MS Sans Serif'>";
        echo "<font size=3 color=red><b>ได้สร้างฐานข้อมูลไปแล้ว</b></font><br><br>";
		echo "หรือมีข้อผิดพลาดที่ระบบ<br><br>";
		echo "กรุณาแจ้ง <font color=blue>admin</font> ให้ตรวจสอบด้วยครับ";
		echo "</font></td></tr></table>";
		echo "<br><hr width=500 color=blue>";
		echo "</center>";
		exit();
	}
?>