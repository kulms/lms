<?require("../include/global_login.php");
function fixday($s,$i){
	return $n = mktime(0,0,0,date("m",$s)  ,date("d",$s)+$i,date("Y",$s));
}
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
	<title></title>
	<script language="JavaScript">
		<!-- hide
		function DeleteIt(id){
			if(confirm('Really delete this comment?'))
			{	
				window.location="del.php?del=1&del_id=" + id;
			}
		}
		// -->
	</script>	
</head>
<body topmargin="0" leftmargin="0" bgcolor="#ffffff">
<? if($id=="" && $comment==""){?>
	<table align="center" width="100%" cellspacing="0" cellpadding="3"><?  
	$flag=1;
	$SQLStmt = "SELECT * FROM peer_comments WHERE reviewer=".$person["id"]." AND modules=$modules;";  
	$oRS = mysql_query($SQLStmt);
	if(mysql_num_rows($oRS)!=0){
		?><tr bgcolor="#808080" class="main">
			<td class="main" width="20%"><b><font face="Arial">Author</font></b></td>
			<td class="main" width="15%"><b><font face="Arial">Title</font></b></td>
			<td class="main"><b><font face="Arial">Your comment</font></b></td>
		</tr><?
		$rownr=0;
		$block=0;
		while($row=mysql_fetch_array($oRS)){
			$flag = 0;
			$author = $row["author"];
			$who = mysql_query("SELECT * FROM users WHERE id =$author;");
			$comment = $row["comment"];
			$comment = nl2br($comment);
			$rownr++;
			$block++;
			if($block==5){
				$spacer="<tr><td colspan='3'><hr noshade></td></tr>";
				$block=0;
			}else{
				$spacer="";
			}//end if
			if($rownr==1){
				$bgcol="#C0C0C0";
			}else{
				$bgcol="#D3D3D3";
				$rownr=0;
			}//end if
			$peer = mysql_query("SELECT * FROM peer WHERE users =$author AND modules = $modules;");
			?>
			<tr class="main" bgcolor="<?echo $bgcol ?>">
				<td class="main" valign="top"><b><a href="mailto:<?echo mysql_result($who,0,"email") ?>"><?echo mysql_result($who,0,"firstname") ?>&nbsp;<?echo mysql_result($who,0,"surname") ?></a></b></td>
				<td class="main" valign="top"><a href="show.php?id=<?echo mysql_result($who,0,"id") ?>&modules=<?echo $modules ?>"><i><?echo mysql_result($peer,0,"title") ?></i></a></td>
				<td class="small" valign="top"><?echo $comment ?> <p><a href="ch_comments.php?id=<?echo $row["id"] ?>&modules=<?echo $modules ?>">Edit</a></td>
			</tr>
			<?echo $spacer ?>
			<?
		}//end while
	}//End If
	if($flag==1){?>
		<tr>
			<td>&nbsp;</td>
			<td class="h3" align="center">You haven't registrered any comments yet...</td>
			<td>&nbsp;</td>
		</tr>
	<? }?>
	</table>
<?}else{ 
	if($comment==""){
			//r_id = request.querystring("id")
			$peer_comm = mysql_query("SELECT * FROM peer_comments WHERE id = $id AND modules = $modules;");
			if(mysql_num_rows($peer_comm)){
				$comm_row=mysql_fetch_array($peer_comm);
				$reviewer=$comm_row["reviewer"];
				$author = $comm_row["author"];
				//$name = mysql_query("SELECT * FROM users WHERE id =$id;");
				$author_info = mysql_query("SELECT * FROM users WHERE id =$author;");
				$peer = mysql_query("SELECT * FROM peer WHERE users=$author AND modules = $modules;");
				$check = mysql_query("SELECT review_end FROM peer_prefs WHERE modules =$modules;");
				if(mysql_num_rows($check)!=0){
					$stopdate = mysql_result($check,0,"review_end");
					$stopdate=fixday($stopdate,1);
					if(time()>$stopdate){
						$stopit=1;
					}
				}
				$comment = $comm_row["comment"];
				$comm = $comment;
				$comment = nl2br($comment);
			?>
			<table align="center" width="100%" cellspacing="0" cellpadding="3">
				<tr bgcolor="#C0C0C0" class="small">
					<td class="small" height="40" align="center"><?echo $person["firstname"] ?>&nbsp;<?echo $person["surname"] ?>s comment on <a href="mailto:<?echo mysql_result($author_info,0,"email") ?>"><?echo mysql_result($author_info,0,"firstname") ?>&nbsp;<?echo mysql_result($author_info,0,"surname") ?>s</a> article: <i><a href="show.php?id=<?echo mysql_result($peer,0,"id") ?>"><?echo $comm_row["title"] ?></a></i></td>
				</tr>
				<tr>
					<td class="main"><br><?echo nl2br($comment) ?><p>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<form action="ch_comments.php" method="POST">
							<textarea name="comment" cols="50" rows="20" wrap="PHYSICAL"><?echo $comm ?></textarea><br>
							<input type="Hidden" name="id" value="<?echo $id ?>">
							<? if($stopit==0){ ?><input type="Submit" name="s1" value="Submit comment">
							<input type="Button" name="delete" value="Delete comment" onClick="DeleteIt(<?echo $id ?>)"><? }else{ ?><b>Posting is closed...</b><?}?>
						</form>
					</td>
				</tr>
				</table>
			<?
			}//End If
		}else{
			$comment = str_replace("'","&#039;",$comment);
			$oRS = mysql_query("UPDATE peer_comments set comment = '".$comment."', time =".time()." WHERE id = $id;"); 
			?>
				<p>&nbsp;<br></p>
				<div align="center" class="h3">Your comments have been changed.</div>
			<?
		}//end if
		?>
<?}// End If ?>
</body>
</html>
