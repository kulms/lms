<?require("include/global_login.php");
$query=mysql_query("SELECT * FROM faculty ORDER BY name;");

?>
<html>
<head>
        <title>Mailtoall</title>
<link rel="STYLESHEET" type="text/css" href="main.css">
</head>

<body>
<table bgcolor="AntiqueWhite" cellpadding="5" cellspacing="0" border="1 width="75%" align="center">
<tr><td colspan="2" class="info" align="center">
E-Mail of all staff in our faculty ( <a href="mailto.php">click here for sending mail</a> )
</td></tr>
<tr><td class="info" width="80%" align="center">Name-Surname</td>
<td class="info" width="20%" align="center">E-mail</td>
</tr>
<?
while($row=mysql_fetch_array($query)){ ?>
<tr>
<td class="info"><?echo $row["name"]." ".$row["surname"]?></td>
<td class="info"><a href="mailto:<?echo $row["login"]?>@nontri.ku.ac.th"><?echo $row["login"]?></td>
</tr>
<? } ?>
</table>
</body>
</html>