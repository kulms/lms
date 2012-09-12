<?require("../include/global_login.php");
$SQLStmt = "SELECT m.name,p.* FROM modules m,peer_prefs p WHERE m.id = $modules AND p.modules=$modules;";
$oRS = mysql_query($SQLStmt);
$get_corr=mysql_query("SELECT corr FROM peer_corr WHERE modules=$modules AND users=".$person["id"].";");

?><html>
<head>
	<title>Meny</title>
<LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
</head>
<body bgcolor="#cccccc">
<table align="center">
<tr>
	<?$cnt=1;
	while($row=mysql_fetch_array($get_corr)){?>
	<td>&nbsp;</td>
	<td class="menu"><a href="show.php?id=<?echo $row["corr"]?>&modules=<?echo $modules ?>" target="p_main"><b># <?echo $cnt?></b></a><br></td>
	<?$cnt++;
	}?>
	<td>&nbsp;</td>
	<td class="menu"><a href="all.php?modules=<?echo $modules ?>" target="p_main"><b>All reports</b></a></td>
	<td>&nbsp;</td>
	<td class="menu"><a href="ch_comments.php?modules=<?echo $modules ?>" target="p_main"><b>Change comments</b></a></td>
	<td>&nbsp;</td>
	<td class="menu"><a href="main.php?modules=<?echo $modules ?>" target="p_main"><b>Instructions</b></a></td>
</tr>
</table>
</body>
</html>
