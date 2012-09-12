<?require ("../include/global_login.php");
	// $id = the author
$SQLStmt = "SELECT * FROM peer_comments WHERE author =$id AND modules=$modules;";
$oRS = mysql_query($SQLStmt);
if(mysql_num_rows($oRS)!=0){?>
	<html>
	<head>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
	<table width="100%" cellspacing="0" cellpadding="5">
	<? $name = mysql_query("SELECT * FROM users WHERE id =$id;"); 
	$fname = mysql_result($name,0,"firstname");
	$sname = mysql_result($name,0,"surname");
	$peer = mysql_query("SELECT title FROM peer WHERE users =$id AND modules = $modules;");?>
	<tr class="main" bgcolor="#808080">
		<td class="main"><b>Title:&nbsp; <i><?echo  mysql_result($peer,0,"title") ?></i></b></td>
		<td class="main" width="80%" align="center"><b>Author</b>: <b><font size="+1"><?echo $fname ?>&nbsp;<?echo $sname ?></font></b></td>
	</tr>
	<tr bgcolor="#808080">
		<td class="main"><b>Reviewer</b></td>
		<td class="main" align="center"><b>Comment</b></td>
	</tr>
	<?  
	$rownum=0;
	$block=0;
	while($row=mysql_fetch_array($oRS)){
		$reviewer = $row["reviewer"];
		$rs = mysql_query("SELECT * FROM users WHERE id =$reviewer;");
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
			<td class="small" valign="top"><?echo nl2br($comment) ?><br>
			<? if($person["id"]==$reviewer){ ?>
			<a class="small" href="ch_comments.php?id=<?echo $row["id"] ?>&modules=<?echo $modules ?>">Edit</a>
			<?}?>
			</td>
		 </tr>  
		 <?echo $spacer ?>
		<?
	}//end while
}//End If
?>
</table>
</body>
</html>