<?
require("../include/global_login.php");
require("../include/colors.php");

if($update!="true"){
	$a=mysql_query("SELECT * from email WHERE modules=$modules AND id=$acc;");
	if($acc=mysql_fetch_array($a)){
	}else{
		$acc["id"]=0;
		$acc["userid"]=$person["id"];
	}
?>
<html>
<head>
	<title>Edit account prefs</title>
<script language="javascript">
	function del(acc){
		if(confirm('Are you sure you want to remove account?')){
			location.href='accdel.php?id=<?echo $modules?>&acc='+acc;
		}
	}
</script>
<link rel="STYLESHEET" type="text/css" href="../css.php">
</head>
<body bgcolor="<?echo $cBGcolor?>">
<div align="center" class="main">
	<table border="0" cellpadding="0" cellspacing="0" bgcolor="<?echo $cBorder?>">
		<form action="accedit.php" method="post" name="accprefs">
		<input type="hidden" name="update" value="true">
		<input type="hidden" name="modules" value="<?echo $modules?>">
		<input type="hidden" name="acc" value="<?echo $acc["id"]?>">
		<tr>
			<td>
				<table border="0" cellpadding="2" cellspacing="1">
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><b>Account name:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><input type="text" name="accountname" value="<?echo $acc["accountname"]?>" class="main"></td>
					</tr>
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[1]?>"><b>Email-address:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[1]?>"><input type="text" name="replymail" value="<?echo $acc["replymail"]?>" class="main"></td>
					</tr>
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><b>Mailserver name (POP3):</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><input type="text" name="server" value="<?echo $acc["server"]?>" class="main"></td>
					</tr>
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[1]?>"><b>Mailserver login:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[1]?>"><input type="text" name="mailid" value="<?echo $acc["mailid"]?>" class="main"></td>
					</tr>
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><b>Mailserver password:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><input type="password" name="mailpasswd" value="<?echo $acc["mailpasswd"]?>" class="main"></td>
					</tr>
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[1]?>"><b>Remember password:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[1]?>"><input type="checkbox" name="remember" value="true" <?if($acc["remember"]==1){echo "checked";}?> class="main"></td>
					</tr>
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><b>Delete messages:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>"><input type="checkbox" name="delmsg" value="true" <?if($acc["delmsg"]==1){echo "checked";}?> class="main">
						<b>Removes the messages from the server after retrieval.</b>
						</td>
					</tr>
					<tr>
						<td class="mainwhite" bgcolor="<?echo $cBGMainFunc?>" colspan="2" align="left" height="18">
							&nbsp;
							<a href="Javascript:document.forms[0].submit();"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Save</u></b></a>
							&nbsp;&nbsp;&nbsp;
							<?
							if($acc["id"]!=0){
								?>
								<a href="Javascript:del(<?echo $acc["id"]?>);"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Delete account</u></b></a>
								<?
							}
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
</div></body>
</html>
<?
}else{
	if($acc==0){
		mysql_query("INSERT INTO email (accountname,modules,userid) values('undef',$modules,".$person["id"].");");
		$acc=mysql_insert_id();
	}
	if($remember=="true"){
		$remember=1;
	}else{
		$remember=0;
		$mailpasswd="";
	}
	if($delmsg=="true"){
		$delmsg=1;
	}else{
		$delmsg=0;
	}
	mysql_query("UPDATE email set accountname='$accountname', server='$server', mailid='$mailid', mailpasswd='$mailpasswd',remember=$remember,delmsg=$delmsg,replymail='$replymail' WHERE id=$acc AND modules=$modules;");
	header("Status: 302 Moved Temporarily");
	header("Location: index.php?id=".$modules);			
}

?>

