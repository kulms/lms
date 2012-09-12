<? require "../include/global_login.php"?>
<html>
<head>
	<title>Admin</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff" topmargin="0">
<div class="h3" align="center"><b>Misc administrative features</b></div><br>
<table cellpadding="3" cellspacing="1" align="center">
	<tr>
		<td class="main"><a href="admin_users.php?courses=<?echo $courses?>">Edit course members</a></td>
	</tr>
	<tr>
		<td class="main"><a href="../visualization.php?courses=<?echo $courses?>">View course activity</a></td>
	</tr>
	<tr>
		<td class="main"><a href="manage.php?courses=<?echo $courses?>">Manage Course Resource</a></td>
	</tr>
</table>
</body>
</html>
