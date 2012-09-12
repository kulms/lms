<?require ("include/global_login.php");
switch($sortby){
	case "1":
		$orderstring="u.surname";
		break;
	case "2":
		$orderstring="m.name";
		break;
	case "3":
		$orderstring="c.name";
		break;
	default:
		$orderstring="lm.time";
		break;
}//end switch

switch($sortorder){
	case "1":
		$order="ASC";
		break;
	case "2":
		$order="DESC";
		break;
	default:
		$order="ASC";
		break;
}//ens switch

$sql="SELECT lm.*,u.firstname,u.surname,m.name,c.name AS coursename FROM login_modules lm, users u, modules m, courses c, wp WHERE m.id=lm.modules AND u.id=lm.users AND wp.modules=lm.modules AND c.id=wp.courses ORDER BY ".$orderstring." $order;";
$l_modules=mysql_query($sql);
?>
<html>
<head>
	<title>Module statistics</title>
	<link rel="STYLESHEET" type="text/css" href="main.css">
</head>
<body bgcolor="#ffffff">
<h3 class="h3" align="center">Module statistics</h3>
<?if(mysql_num_rows($l_modules)!=0){?>
<table bgcolor="#000000" align="center" border="0">
<tr>
	<td>
	<table cellpadding="5" cellspacing="1" border="0" width="100%" bgcolor="#ffffff">
		<tr bgcolor="#CACFF4">
			<td class="main"><b>User</b> <?if($sortorder==1 || $sortorder==""){?><a href="module_activity.php?sortby=1&sortorder=2"><img src="images/up.gif" width=10 height=9 alt="Sort Descending by user" border="0"></a><?}else{?><a href="module_activity.php?sortby=1&sortorder=1"><img src="images/dn.gif" width=10 height=9 alt="Sort ascending by user" border="0"></a><?}?></td>
			<td class="main"><b>Modulename</b> <?if($sortorder==1 || $sortorder==""){?><a href="module_activity.php?sortby=2&sortorder=2"><img src="images/up.gif" width=10 height=9 alt="Sort Descending by modulename" border="0"></a><?}else{?><a href="module_activity.php?sortby=2&sortorder=1"><img src="images/dn.gif" width=10 height=9 alt="Sort ascending by modulename" border="0"></a><?}?></td>
			<td class="main"><b>Course</b> <?if($sortorder==1 || $sortorder==""){?><a href="module_activity.php?sortby=3&sortorder=2"><img src="images/up.gif" width=10 height=9 alt="Sort Descending by Course" border="0"></a><?}else{?><a href="module_activity.php?sortby=3&sortorder=1"><img src="images/dn.gif" width=10 height=9 alt="Sort ascending by Course" border="0"></a><?}?></td>
			<td class="main"><b>Time</b> <?if($sortorder==1 || $sortorder==""){?><a href="module_activity.php?sortorder=2"><img src="images/up.gif" width=10 height=9 alt="Sort Descending by time" border="0"></a><?}else{?><a href="module_activity.php?sortorder=1"><img src="images/dn.gif" width=10 height=9 alt="Sort ascending by time" border="0"></a><?}?></td>
		</tr>
	<?while($row=mysql_fetch_array($l_modules)){?>
		<tr bgcolor="<?if($cnt==0){?>AntiqueWhite<?}?>">
			<td class="main"><?echo $row["firstname"]."&nbsp;".$row["surname"]?></td>
			<td class="main"><?echo $row["name"]?></td>
			<td class="main"><?echo $row["coursename"]?></td>
			<td class="main"><?echo date("Y-m-d, H:i",$row["time"])?></td>
		</tr>
		<?if($cnt==0){
			$cnt=1;
		}else{
			$cnt=0;
		}?>
<?
}?>	</table>
	</td>
</tr>
</table>

	<?}?>
</body>
</html>
