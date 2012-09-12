<?
require("../include/global_login.php");
?>
<html>
<head>
<title>Members Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../images/style.css" type=text/css rel=stylesheet>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>

<body>
		<table width=300 cellpadding=0 cellspacing=0 border=0 ALIGN="center">
		<tr align="center" bgcolor="#336699"> 
		  
    <td height="21" colspan=5 valign="middle"><strong><font color="#FFFFFF"><img src="../images/bulleti.gif" width=8 height=8 alt="" border="0"><img src="../images/bulleti.gif" width=8 height=8 alt="" border="0"> 
      Members Online <img src="../images/bulleti.gif" width=8 height=8 alt="" border="0"><img src="../images/bulleti.gif" width=8 height=8 alt="" border="0"></font></strong></td>
		</tr>
		<tr width=300> 
		  <td width=1 bgcolor="#0099FF"><spacer type="block" height=2 width=1></td>
		  <td valign="top" width=298> <table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr bordercolor="#99CCFF" bgcolor="#FFFFFF"> 
				<td width="21%" align="center"><strong><u>ลำดับที่</u></strong></td>
				<td width="33%" align="center"><strong><u>Login</u></strong></td>
				<td width="46%" align="center"><strong><u>ชื่อ - สกุล</u></strong></td>
			  </tr>
			  <?
					$number=1;
					$color = 0;
					$member=mysql_query("SELECT lc.users, u.login, u.firstname, u.surname 
																	  FROM users u, login_courses lc WHERE lc.users = u.id AND lc.courses = $courses
																	  ORDER BY u.login")					
					or die("Invalid query");
					while($row=mysql_fetch_array($member)){					
					if ($color == 0) {
				?>
			  <tr bgcolor="#EEEEEE"> 
				<td>&nbsp;<img src="../images/bulleti.gif" width=8 height=8 alt="" border="0">&nbsp;<? echo $number;?></td>
				<td align="center"><? echo $row["login"];?></td>
				<td align="center" bgcolor="#EEEEEE"><? echo $row["firstname"]."  ".$row["surname"];?></td>
			  </tr>
			  <?
					$color = 1;
				} else {
				?>
			  <tr bgcolor="#FDFDFD"> 
				<td>&nbsp;<img src="../images/bulleti.gif" width=8 height=8 alt="" border="0">&nbsp;<? echo $number;?></td>
				<td align="center"><? echo $row["login"];?></td>
				<td align="center"><? echo $row["firstname"]."  ".$row["surname"];?></td>			  
			  </tr>
			  <?
						$color = 0;
					}
					$number++;   
				}
			   ?>
			</table></td>
		  <td width=1 bgcolor="#0099FF"><spacer type="block" height=2 width=1></td>
		</tr>
		<tr bgcolor="#0099FF"> 
		  <td width=1 colspan=5><spacer type="block" height=1 width=300></td>
		</tr>
	  </table>
</body>
</html>
