<? require ("../include/global_login.php");
function fixday($s,$i){
	return $n = mktime(0,0,0,date("m",$s)  ,date("d",$s)+$i,date("Y",$s));
}
if($id!=""){
	$SQLStmt = "SELECT * FROM peer WHERE users=$id AND modules=$modules;";
	$oRS = mysql_query($SQLStmt);
	if(mysql_num_rows($oRS)!=0){
		while($row=mysql_fetch_array($oRS)){
			$memo=$row["memo"];
			$words=$row["words"];
			$title=$row["title"];
			$pm_id=$row["id"];
		}
	  }//End If
}//end if
//end if	
$memo=nl2br($memo);

		//plocka fram studentens fnamn o enamn ur db
//	if($corr = ""){
//		n_id = id
//	else
//		n_id = corr
//	end if
$name = mysql_query("SELECT firstname,surname,email FROM users WHERE id =$id;");
//echo "SELECT * FROM peer_comments WHERE reviewer = ".$person["id"]." AND author=$n_id;";
$check = mysql_query("SELECT * FROM peer_comments WHERE reviewer = ".$person["id"]." AND author=$id AND modules=$modules;");
if(mysql_num_rows($check)!=0){
	$comm = mysql_result($check,0,"comment");
	$upd_id = mysql_result($check,0,"id");
}
$getdates = mysql_query("SELECT review_end FROM peer_prefs WHERE modules =$modules;");
if(mysql_num_rows($getdates)!=0){
	$stopdate = fixday(mysql_result($getdates,0,"review_end"),1);
	if(time() > $stopdate){
		$stopit=1;
	}
}
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="JavaScript">
		<!-- hide
		function DeleteIt(id){
			if(confirm('Really delete this comment?'))
			{
				window.location="del.asp?del=true&del_id=" + id;
			}
		}
		// -->
</script>	
</head>
<body bgcolor="white" topmargin="0" leftmargin="0">
<table cellspacing="2" cellpadding="2" width="100%">
<tr bgcolor="#808080">
	<td class="main"><b>&nbsp;Author</b></td>
	<td class="main">&nbsp;<b>Title</b></td>
	<td class="main">&nbsp;<b>Wordcount</b></td>
</tr>
<tr class="main">
	<td class="main"><b><?echo mysql_result($name,0,"firstname") ?> <? if(mysql_result($name,0,"surname")!=""){?>&nbsp;<?echo  mysql_result($name,0,"surname") ?></b><?}?></td>
	<td class="main"><b><i><?echo $title ?></i></b></td>
	<td class="main"><font face="Arial"><?echo $words ?> words</font></td>
</tr>
<tr>
	<td class="main" colspan="3"><br><?echo $memo ?><p>&nbsp;<br></p></td>
</tr>
<tr class="main">
	<td colspan="3"><p>&nbsp;</p>
		<form action="comments.php" method="POST">
			<textarea name="comment" cols="60" rows="20" wrap="PHYSICAL"><? if($comm!=""){ ?><?echo $comm ?><?}else{?>Write (or paste) your comments on <?echo mysql_result($name,0,"firstname") ?><? if(mysql_result($name,0,"surname")!=""){ ?>&nbsp;<?echo mysql_result($name,0,"surname") ?><?}?>s report here...<?echo "\n"?>(Please erase this first :)<?}?></textarea>
			<br><? if($stopit!=1){ ?><input type="Submit" value="<? if($comm!=""){?>Update comment<? }else{?>Submit comment<?}?>" name="s1">
			<input type="Hidden" name="modules" value="<?echo $modules ?>">
			<input type="Hidden" name="author" value="<?echo $id ?>">
			<? if($comm!=""){ ?>
				<input type="hidden" name="update" value="1">
				<input type="hidden" name="upd_id" value="<?echo $upd_id ?>">
				<input type="button" name="del" value="Delete comment" onClick="DeleteIt(<?echo $upd_id ?>)">
			<?}?><input type="Reset" value="Clear"><? }else{ ?><b>Posting is closed...</b><?}?>
		</form>
	</td>
</tr>
</table>
</body>
</html>