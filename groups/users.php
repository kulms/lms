<?require ("../include/global_login.php");?>
<html>
<head>
	<title>Users</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<div align="center">
<table cellpadding="10" cellspacing="0" bgcolor="#ffffff">
	<tr>
		<td align="center">
		<?
		if(!settype($groups,"integer") || settype($courses,"integer")){
			$Getlist=mysql_query("SELECT
u.id,u.firstname,u.surname,u.email,u.homepage,u.info,u.address,u.picture FROM wp,users u
WHERE wp.users=u.id and wp.courses=".$courses." and wp.cases=0 and wp.modules=0 and
wp.groups=0 and u.active=1 ORDER BY u.firstname");
			$course=mysql_query("SELECT * from courses where id=".$courses);?>
			<h3 class="h3"><?echo mysql_result($course,0,"name");?></h3><?
		}else{
			$Getlist=mysql_query("SELECT
u.id,u.email,u.firstname,u.surname,u.homepage,u.info,u.address,u.picture FROM wp,users u
WHERE wp.users=u.id and wp.groups=".$groups." and wp.cases=0 and wp.modules=0 and
wp.courses=0 and u.active=1 ORDER BY u.firstname");
			$group=mysql_query("SELECT * from groups where id=".$groups);
			?><h3 class="h3"><?echo mysql_result($group,0,"name");?></h3><?
		}
		?>
<table border=1 cellpadding="2" cellspacing="0">
<?
$email_list="";

while($row=mysql_fetch_array($Getlist)){
	$email=$row["email"];
	if($email_list!=""){
		$email_list.=",";
	}
	$email_list.=$email;
	$homepage=$row["homepage"];
	$address=$row["address"];
	$info=$row["info"];
	?>
	<tr>
		<td valign="top">
			<span class="info"><?echo $row["firstname"]." ".$row["surname"];?></span>
			<?if($show=="all" && strlen($address)>3){?>
				<br><br><span class="small"><b>Address:</b><br>
				<?echo nl2br($address);?></span>
			<?}?>		
		</td>
		<td valign="top">
			<span class="small"><a href="mailto:<?echo $email;?>"><img src="../images/mail.gif" width=20 height=16 border="0"><?echo $email;?></a>
			<?if($show=="all" && strlen($homepage)>3){
				$homepage=str_replace("http://","",$homepage)
			?>
				<br><a href="http://<?echo $homepage;?>" target="new_"><img src="../images/home-blues.gif" width=11 height=16 alt="" border="0">
				<?echo $homepage;?>
				</a>
			<?}
			if($show=="all"){
			?>		
			<p>	<?echo nl2br($info);?>
			<?}?>
			</span>
		</td>
		<?if($show=="all"){?>
		<td class="small" valign="top">&nbsp;
			<?
			if(strlen($row["picture"])>3){
				?><img src="../users/picture/<?echo $row["id"]."/".$row["picture"]?>" height="150"><?	
			}
			?>			
		</td>
		<?}?>
	</tr>
	<?
}	
?>
</table>
</td></tr></table>
<br>
<a href="users.php?courses=<?echo $courses?>&groups=<?echo $groups?>&show=all" class="main">Show full info</a><br>
<a href="mailto:<?echo $email_list?>" class="main">Mail to all</a><br>
<?
$check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=$courses AND admin=1;");
if($person["admin"]==1 || (mysql_num_rows($check)!=0 && $courses!=0)){
	?><a href="admin_users.php?courses=<?echo $courses?>" class="main">Edit coursemembers</a><?
}
mysql_close();
?>
</div>
</body>
</html>
