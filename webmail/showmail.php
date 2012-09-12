<?
require("../include/global_login.php");
require("../include/colors.php");
?>
<html>
<head>
	<title>Webmail</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../css.php">
</head>
<body bgcolor="<?echo $cBGcolor?>">
<div align="center" class="main">
	<table border="0" cellpadding="0" cellspacing="0" bgcolor="<?echo $cBorder?>" width="100%">
		<tr>
			<td>
				<table border="0" cellpadding="2" cellspacing="1" width="100%">
					<?
					mysql_query("UPDATE emailmsg set status=0 where id=$msg AND modules=$modules;");
					$msg=mysql_query("SELECT * from emailmsg where modules=$modules AND id=$msg;");
					$row=mysql_fetch_array($msg);
					?>
					<tr>
						<td colspan="2" bgcolor="<?echo $cBGMainFunc?>" class="mainwhite" align="left">
							&nbsp;
							<a href="sendmail.php?modules=<?echo $modules?>&replymail=<?echo $row["id"]?>"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Reply</u></b></a>
							&nbsp;&nbsp;&nbsp;
							<a href="index.php?id=<?echo $modules?>"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Back</u></b></a>
						</td>
					</tr>
					<tr>
						<td class="main" width="100" bgcolor="<?echo $cBGMainInfo[1]?>">
							<b>From:</b>
						</td>
						<td class="main" width="95%" bgcolor="<?echo $cBGMainInfo[1]?>">
							<?
							$check=mysql_query("SELECT * from emailaddresses WHERE id=".$row["addresses"].";");
							if($row2=mysql_fetch_array($check)){
								if(strlen($row2["name"])>1){
									echo $row2["name"]."&nbsp;&nbsp;&lt;".$row["fromemail"]."&gt;";
								}else{
									echo $row["fromemail"];
								}
							}else{
								echo $row["fromemail"];
							}
							?>
						</td>
					</tr>
					<tr>
						<td class="main" width="100" bgcolor="<?echo $cBGMainInfo[0]?>">
							<b>To:</b>
						</td>
						<td class="main" width="95%" bgcolor="<?echo $cBGMainInfo[0]?>">
							<?echo $row["toemail"];?>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="main" width="100" bgcolor="<?echo $cBGMainInfo[1]?>">
							<b>Subject:</b>
						</td>
						<td class="main" width="95%" bgcolor="<?echo $cBGMainInfo[1]?>">
							<?echo $row["subject"];?>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="main" width="100" bgcolor="<?echo $cBGMainInfo[0]?>">
							<b>Attachment</b>
						</td>
						<td class="main" width="95%" bgcolor="<?echo $cBGMainInfo[0]?>">
							<?
							$att=mysql_query("SELECT id,filename FROM emailattach WHERE emailmsg=".$row["id"].";");
							while($row2=mysql_fetch_array($att)){
								?> <a href="attach.php/<?echo $row2["filename"]?>?id=<?echo $row2["id"]?>"><?echo $row2["filename"]?></a><?
							}
							?>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="main" colspan="2" align="left" bgcolor="<?echo $cBGMainInfo[1]?>">
							<?echo $row["info"]?>&nbsp;
						</td>
					</tr>
					<tr>
						<td colspan="2" bgcolor="<?echo $cBGMainFunc?>" class="mainwhite" align="left">
							&nbsp;
							<a href="sendmail.php?modules=<?echo $modules?>&replymail=<?echo $row["id"]?>"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Reply</u></b></a>
							&nbsp;&nbsp;&nbsp;
							<a href="index.php?id=<?echo $modules?>"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Back</u></b></a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div><br>
</body>
</html>
