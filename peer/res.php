<?require("../include/global_login.php");
$check=mysql_query("SELECT m.name,m.users,pp.reports_to_review FROM modules m, peer_prefs pp WHERE pp.modules=$modules AND m.id=$modules;");
$check_course=mysql_query("SELECT courses FROM wp WHERE modules=$modules;");
$check_cadmin=mysql_query("SELECT id FROM wp WHERE admin=1 AND users=".$person["id"]." AND courses=".mysql_result($check_course,0,"courses").";");
if(mysql_num_rows($check_cadmin)!=0){
	$cadmin=1;
}else{
	$cadmin=0;
}
?>
<html>
<head>
	<title>Results by user</title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<p class="h3" align="center">Results by user for <?echo mysql_result($check,0,"name")?></p>
<?if(mysql_result($check,0,"users")==$person["id"] || $person["admin"]==1 || $cadmin==1){
		//OK, user has access to this script
	$reports=mysql_result($check,0,"reports_to_review");
	$br_str=explode(";",$HTTP_USER_AGENT);
	$t=trim($br_str[1]);
		//check if user has msie>3 simply because a black border looks better in explorer
		//Not sure how msie 3 treats tables...
	if(strstr($t,"MSIE")){
		if($t[5]>3){	
			$black_border=1;?>
			<table bgcolor="black" width="100%" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td>
		<?}
	}?>
	<table width="100%" cellpadding="4" cellspacing="1" align="center">
		<tr bgcolor="#808080">
			<td class="main"><b>Name</b></td>
			<td class="main"><b>Title</b></td>
			<td class="main" align="right"><b>Comments</b></td>
			<td class="main" align="right"><b>Finished?</b></td>
		</tr>
	<?$get_peer=mysql_query("SELECT
u.firstname,u.surname,u.email,p.users,p.title,p.id,p.words FROM users u, peer p WHERE
p.modules=$modules AND u.id=p.users ORDER BY u.firstname,u.surname ASC;");
		$participants=array();
		$rownum=0;
		$block=0;
		while($row=mysql_fetch_array($get_peer)){
			$rownum++;
			$get_corr=mysql_query("SELECT count(id) as comm FROM peer_comments WHERE modules=$modules AND reviewer=".$row["users"]." AND comment <>'';");
			if(mysql_num_rows($get_corr)!=0){
				$comments=mysql_result($get_corr,0,"comm");
			}else{
				$comments=0;
			}
			if($rownum==1){
				$bgcol="#C0C0C0";
			}else{
				$bgcol="#D3D3D3";
				$rownum=0;
			}//end if
		//echo $row["firstname"]." ".$row["surname"]."<br>";
			$corrs=mysql_query("SELECT count(id) as corrcount FROM peer_comments WHERE reviewer=".$row["users"]." AND modules=$modules;");
			if(mysql_num_rows($corrs)!=0){
				$corrcnt=mysql_result($corrs,0,"corrcount");
			}else{
				$corrcnt=0;
			}
			if($corrcnt<$reports){
				$finished="No";
				$extra="";
			}else{
				$finished="Yes";
				if($corrcnt>$reports){
					$extra="<i>(+".($corrcnt-$reports).")</i>";
				}else{
					$extra="";
				}
			}
			$block++;
			if($block==5){
				$spacer="<tr bgcolor=\"white\"><td colspan='4'><hr noshade color=\"silver\"></td></tr>";
				$block=0;
			}else{
				$spacer="";
			}//end if
?>		<tr bgcolor="<?echo $bgcol?>">
			<td class="main"><?echo $row["firstname"]."&nbsp;".$row["surname"]?></td>
			<td class="main"><a href="show.php?id=<?echo $row["users"]?>&modules=<?echo $modules?>"><?echo $row["title"]?></a></td>
			<td align="right" class="main"><a href="show_user_comments.php?id=<?echo $row["users"]?>&modules=<?echo $modules?>"><?echo $comments?></a></td>
			<td align="right" class="main"><?echo $finished?><?echo $extra?></td>
		</tr>
<?		$participants[]=$row["users"];
		echo $spacer;
		}//end while
		$get_lurkers=mysql_query("SELECT DISTINCT u.firstname,u.surname,u.email,u.id FROM users u,peer p, peer_comments pc WHERE p.modules=$modules AND pc.reviewer NOT IN(".implode($participants,",").") AND pc.modules=$modules AND u.id=pc.reviewer;");
?>	</table>
	<?if($black_border==1){?>	</td>
	</tr>
	</table><?}?>
	
	<?if(mysql_num_rows($get_lurkers)!=0){?>
		<p>&nbsp;</p>
		<table width="100%" align="center" cellpadding="4" cellspacing="1">
			<tr>
				<td colspan="4" class="h5"><b>The following participants didn't submit any report but made comments on the others'.</b></td>
			</tr>
			<tr bgcolor="#808080">
				<td class="main"><b>Name</b></td>
				<td class="main" align="right"><b>Comments</b></td>
			</tr>
		<?	$rownum=0;
			$block=0;
			while($e_row=mysql_fetch_array($get_lurkers)){
				$rownum++;
				$corrs=mysql_query("SELECT count(id) as corrcount FROM peer_comments WHERE reviewer=".$e_row["id"]." AND modules=$modules;");
				if(mysql_num_rows($corrs)!=0){
					$corrcnt=mysql_result($corrs,0,"corrcount");
				}else{
					$corrcnt=0;
				}
				if($rownum==1){
					$bgcol="#C0C0C0";
				}else{
					$bgcol="#D3D3D3";
					$rownum=0;
				}//end if
				$block++;
				if($block==5){
					$spacer="<tr><td colspan='4'><hr noshade></td></tr>";
					$block=0;
				}else{
					$spacer="";
				}//end if
			?>
			<tr bgcolor="<?echo $bgcol?>">
				<td class="main"><?echo $e_row["firstname"]."&nbsp;".$e_row["surname"]?></td>
				<td align="right" class="main"><a href="show_user_comments.php?id=<?echo $e_row["id"]?>&modules=<?echo $modules?>"><?echo $corrcnt?></a></td>
			</tr>
		<?}?>
		</table>
	<?}?>
<?}else{//no access...
?>
<p class="h5" align="center"><b>You don't have access to this script...</b></p>
<?}?>
</body>
</html>
