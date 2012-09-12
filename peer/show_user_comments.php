<?require ("../include/global_login.php");
	// $id = the author
$SQLStmt = "SELECT * FROM peer_comments WHERE reviewer =$id AND modules=$modules;";
$oRS = mysql_query($SQLStmt);?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<?if(mysql_num_rows($oRS)!=0){
	$get_users_title=mysql_query("SELECT title,id,words FROM peer WHERE users=$id AND modules=$modules;");
	if(mysql_num_rows($get_users_title)!=0){
		$user_title=mysql_result($get_users_title,0,"title");
		$users_memo_id=mysql_result($get_users_title,0,"id");
		$users_memo_words=mysql_result($get_users_title,0,"words");
	}
?>
	<table width="100%" cellspacing="1" cellpadding="5">
<?	$name = mysql_query("SELECT * FROM users WHERE id =$id;"); 
	$fname = mysql_result($name,0,"firstname");
	$sname = mysql_result($name,0,"surname");
	$email=mysql_result($name,0,"email");
	?>
	<tr bgcolor="#808080">
		<td colspan="2" class="main"><b>Reviewer: <a href="mailto:<?echo $email?>"><?echo $fname."&nbsp;".$sname?></a></b></td>
		<td class="main" align="center"><b>Title: <a href="show.php?id=<?echo $id?>&modules=<?echo $modules?>"><?echo $user_title?></a> &nbsp; <?echo $users_memo_words?> words</b></td>
	</tr>
	<tr bgcolor="#808080">
		<td class="main"><b>Author</b></td>
		<td class="main"><b>Title</b></td>
		<td class="main" align="center"><b>Comments by <?echo $fname?></b></td>
	</tr>
	<?  
	$rownum=0;
	$block=0;
	while($row=mysql_fetch_array($oRS)){
		$reviewer = $row["reviewer"];
		$rs = mysql_query("SELECT * FROM users WHERE id =".$row["author"].";");
		$peer = mysql_query("SELECT title,id FROM peer WHERE users =".$row["author"]." AND modules = $modules;");
		if(mysql_num_rows($peer)!=0){
			$title=mysql_result($peer,0,"title");
			$memo_id=mysql_result($peer,0,"id");
		}else{
			$title="&nbsp;";
		}

		$rownum++;
		$block++;
		if($block==5){
			$spacer = "<tr><td colspan='3'><hr noshade></td></tr>";
			$block=0;
		}else{
			$spacer="";
		}
		if($rownum==1){
			$bgcol="#C0C0C0";
		}else{
			$bgcol="#D3D3D3";
			$rownum=0;
		}
		
		$comment = $row["comment"];
		$rs_name = mysql_result($rs,0,"firstname")."&nbsp;".mysql_result($rs,0,"surname");?>
		<tr bgcolor="<?echo $bgcol ?>">
		 	<td class="main" valign="top"><b><a href="mailto:<?echo mysql_result($rs,0,"email") ?>"><?echo $rs_name ?></a></b></td>
			<td class="main" valign="top"><a href="show.php?id=<?echo $row["author"]?>&modules=<?echo $modules?>"><?echo $title?></a></td>
			<td class="small" valign="top"><?echo nl2br($comment) ?><br>
			<? if($person["id"]==$reviewer){ ?>
			<a class="small" href="ch_comments.php?id=<?echo $row["id"] ?>&modules=<?echo $modules ?>">Edit</a>
			<?}?>
			</td>
		 </tr>  
		 <?echo $spacer ?>
		<?
	}//end while
?>
	</table>
<?}else{?>
	<p>&nbsp;</p>
	<p align="center" class="h5"><b>No comments for this user...</b></p>
<?}?>
</body>
</html>