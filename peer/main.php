<?require("../include/global_login.php");
$get_instr = mysql_query("SELECT * FROM peer_prefs WHERE modules=$modules;");

function fixday($s,$i){
	return $n = mktime(0,0,0,date("m",$s)  ,date("d",$s)+$i,date("Y",$s));
}?>
<html>
<head>
<title>Memo's to review </title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff" topmargin="0">
<table>
<tr>
	<td height="80">&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td width="20%">&nbsp;</td>
	<td class="main">
	<? if(time()<= fixday(mysql_result($get_instr,0,"review_end"),1)){?>
		<?echo  mysql_result($get_instr,0,"instructions") ?>
	<?}else{ ?><div align="center"><b>
		The time is up.<br>
		You can't post your comments anymore but you still <br>
		have the possibilty to read what everybody has written.<br></b></div>
	<?} ?>
</td>
<td width="20%">&nbsp;</td>
</tr>
</table>

</body>
</html>
