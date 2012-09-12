<?
/* 
 * **********************************************
 * **      PHP - WebBoard : Member Profile     **
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

	// ติดต่อ database เพื่ออ่านข้อมูล
	mysql_connect($host,$user,$passwd);
	$sql = "select * from webboard_member where User='$Name'";
	$result = mysql_db_query($dbname,$sql);
	$NRow = mysql_num_rows($result);
	
	if($NRow==0) { echo "Error"; exit(); }

	$row = mysql_fetch_array($result);
	// กำหนดค่าตัวแปร เพื่อนำไปแสดง
	$User = $row["User"];
	$Email = $row["Email"];
	$ICQ = $row["ICQ"];
	$WebName = $row["WebName"];
	$URL = $row["URL"];
?>
<html>
<head>
<title>PHP - Ultimate Webboard 2.00</title>
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
</head>

<body bgcolor=#FFFFE0>
	<font size=2 face="Arial,MS Sans Serif">
    <h2><font color=blue>PHP - Ultimate Webboard <font color=red>2.00</font></font></h2>
	<center>
	<br>

	<table border=1 width=60% bgcolor=blue bordercolor=blue cellspacing=0 cellpadding=3>
	<tr><td align=center bgcolor=blue>
	<font size=3 color=#FFF5EE><b>ข้อมูลสมาชิก</b></font>
	</td></tr>
	<tr><td>
		<table border=1 width=100% bgcolor=white bordercolor=blue cellspacing=0 cellpadding=5>
		<tr>
			<td align=left width=25%>Username</td>
			<td align=left><?echo $User;?></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?
				// เลือกระบบการส่งอีเมล์
				switch ($s_mail) {
					case "1" : 	echo "<a href=\"mail2me.php?wemail=$Email&name=$Name&question=$Question\" target=\"mail2me$No\">$Email</a> \n"; break;
					case "2" : echo "<a href=mailto:$Email>$Email</a> \n"; break;
					default : echo "<a href=\"mail2me.php?wemail=$Email&name=$Name&question=$Question\" target=\"mail2me\">$Email</a> \n";
				}
				?>
			</td>
		</tr>
		<tr>
			<td>ICQ</td>
			<td><?
				if($ICQ) {
					echo "$ICQ <img src=\"http://online.mirabilis.com/scripts/online.dll?icq=$ICQ&img=$ICQ_Image_Type"."online.gif\" alt='ICQ - $ICQ'>\n";
				}
				else {
					echo "--";
				}
				?>
			</td>
		</tr>
		<tr>
			<td>Web Name</td>
			<td><?
				if(!$WebName) {
					echo "--";
				}
				echo $WebName;
				?>
			</td>
		</tr>
		<tr>
			<td>URL</td>
			<td><?
				if($URL!="http://") {
					echo "<a href=\"$URL\" target=\"$URL\">$URL</a>";
				}
				else {
					echo "--";
				}
				?>
			</td>
		</tr>
		</table>
	</table>

	<br><br>
	<hr color=1E90FF width=60%>
	<font size=1 face="MS Sans Serif">
	<b>Copy<font color=FF1493>LEFT</font> and Powered By : <a href=mailto:sansak@engineer.com>Sansak</a></b>
	</font>
	</center>

</body>
</html>