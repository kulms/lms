<?
require("../include/global_login.php");
require("../include/colors.php");

if($update!="true"){
	if($replymail==""){
	
	}else{
		$check=mysql_query("SELECT * from emailmsg WHERE id=$replymail;");
		if(mysql_num_rows($check)>0){
			$mail=mysql_fetch_array($check);
			$mail["subject"]="Re:".$mail["subject"];
			$mail["info"]=str_replace("<br>","",$mail["info"]);
			$mail["info"]="\n\n>".str_replace("\n","\n>",$mail["info"]);
		}
	}
?>
<html>
<head>
	<title>Webmail sendmail</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../css.php">
</head>
<body bgcolor="<?echo $cBGcolor?>">
<div align="center" class="main">
	<table border="0" cellpadding="0" cellspacing="0" bgcolor="<?echo $cBorder?>">
	<form action="sendmail.php" method="post">
	<input type="hidden" name="update" value="true">
	<input type="hidden" name="modules" value="<?echo $modules?>">
		<tr>
			<td>
				<table border="0" cellpadding="2" cellspacing="1" width="100%">
					<tr>
						<td class="main" width="100" bgcolor="<?echo $cBGMainInfo[0]?>">
							<b>From:</b>
						</td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>">
							<?
							$from=mysql_query("SELECT id,replymail from email WHERE modules=$modules AND replymail like '%@%';");
							if(mysql_num_rows($from)>1){
								?>
								<select name="fromemail" class="main">
									<?
									while($row=mysql_fetch_array($from)){
										?>
										<option value="<?echo $row["replymail"]?>">
										<?
										echo $row["replymail"];
									}
									?>
								</select>
								<?
							}else{
								?><input type="text" name="fromemail" value="<?if(mysql_num_rows($from)==1){echo mysql_result($from,0,"replymail");}?>"><?
							}
							?>
						</td>
					</tr>
					<tr>
						<td class="main" width="100" bgcolor="<?echo $cBGMainInfo[1]?>">
							<b>To:</b>
						</td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[1]?>">
							<input type="text" name="tomail" value="<?echo $mail["fromemail"]?>" class="main">
						</td>
					</tr>
					<tr>
						<td class="main" width="100" bgcolor="<?echo $cBGMainInfo[0]?>">
							<b>Subject:</b>
						</td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>">
							<input type="text" name="subject" value="<?echo $mail["subject"];?>" class="main">
						</td>
					</tr>
					<tr>
						<td class="main" colspan="2" align="left" bgcolor="<?echo $cBGMainInfo[1]?>">
							<textarea name="info" cols="60" rows="20" wrap="virtual" class="main"><?echo $mail["info"]?></textarea>
						</td>
					</tr>
					<tr>
						<td class="mainwhite" colspan="2" bgcolor="<?echo $cBGMainFunc?>" align="center">
							<a href="Javascript:document.forms[0].submit();"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Send</u></b></a>
							&nbsp;&nbsp;&nbsp;
							<a href="index.php?id=<?echo $modules?>"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Abort</u></b></a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><br><br>
</form>
</div><br>
</body>
</html>
<?
}else{
	mail($tomail,$subject,$info,"From: $fromemail\nReply-To: $fromemail\nX-Mailer: LearnLoop0.9b");
	header("Status: 302 Moved Temporarily");
	header("Location: index.php?id=".$modules);
}

?>

