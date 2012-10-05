<?require("../include/global_login.php");
$modules=mysql_query("SELECT * from modules WHERE id=".$module);
$row=mysql_fetch_array($modules);
?>
<html>
<head>
	<title>Forum menu</title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<script language="JavaScript">
	<!--
	var isopen=0
	function po()
	{
	if(isopen==0){
		nyk=window.open("new.php?module=<?echo $module;?>", "nyk", "width=530,height=160,status=no,toolbar=no,menubar=no,scrollbars=yes");
		isopen=1;
	}
	else
	{
		if(nyk.closed)
		{
			nyk=window.open('new.php?module=<?echo $module;?>', "nyk", "width=530,height=160,status=no,toolbar=no,menubar=no,scrollbars=yes");
			isopen=1;
		}
		else
		{
		nyk.focus();
		}
	}
	}
	//-->
</script>
<center>
	<table border="0" cellpadding="3" cellspacing="0">
		<tr valign="middle">
			<td align="right" class="menu">&nbsp;</td>
			<td align="left" class="menu">
				<a href="JavaScript:po()"><img src="../images/postit.gif" border=0 align="middle" alt="New Contribution" height="25" width="25"></a> &nbsp; <a href="search.php?module=<?echo $module?>" target="head_2"><img src="../images/search.gif" border=0 align="middle" alt="Search" height="25" width="25"></a>
				&nbsp; <a href="prefs.php?modules=<?echo $module?>" target="head_2"><img src="../images/prefs.gif" width=20 height=16 alt="Edit preferences for <?echo $row["name"]?>" border="0" align="middle"></a>
			</td>
		</tr>
	</table>
</center>
</body>
</html>
<?mysql_close();?>