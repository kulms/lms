<?
require("../include/global_login.php");
require("../include/colors.php");

mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");
?>
<html>
<head>
	<title>Webmail</title>
<script language="javascript">
	function updatewindow(){
		self.location.reload();
	}
	function check(acc){
		checkmail=window.open('checkconfirm.php?id=<?echo $id?>&acc='+acc,'checkmail','width=350,height=180,status=yes,toolbar=no,menubar=no,scrollbars=no,dependent=yes');
	}
	function del(acc){
		if(confirm('Are you sure you want to remove account?')){
			location.href='accdel.php?id=<?echo $id?>&acc='+acc;
		}
	}
	function mark(what){
		for(a=0;a<document.mess.elements["msg[]"].length;a++){
			document.mess.elements["msg[]"][a].checked=what;
		}
	}
	function delmsg(){
		noneselected=true;
		for(a=0;a<document.mess.elements["msg[]"].length;a++){
			if(document.mess.elements["msg[]"][a].checked){
				noneselected=false;
			}
		}
		if(noneselected){
			alert("No messages where selected.");
		}else{
			if(confirm("Are you sure you want to delete the selected messages?")){
				document.mess.task.value="del";
				document.mess.submit();
			}
		}
	}
	
</script>
<link rel="STYLESHEET" type="text/css" href="../css.php">
</head>
<body bgcolor="<?echo $cBGcolor?>" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
<h1 class="h1">
<img src="../images/email.gif" width="16" height="16" border="0"> Webmail
<hr noshade size="1" width="100%">
</h1>
<div align="center" class="main">
	<table border="0" cellpadding="0" cellspacing="0" bgcolor="<?echo $cBorder?>">
		<form action="action.php" method="post" name="mess">
		<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="1">
					<tr>
						<td class="main" colspan="4" bgcolor="<?echo $cBGMainFunc?>" height="20">
							<table border=0 cellpadding="2" cellspacing="0" width="100%">
								<tr>
								<?
								$acc=mysql_query("SELECT * from email WHERE modules=$id;");
								while($row=mysql_fetch_array($acc)){
									?>
										<td class="mainwhite" nowrap height="20">
											<a href="Javascript:check(<?echo $row["id"]?>);"><img src="../images/check_mail.gif" alt="" border="0" align="top"><b class="mainwhite"><u>Check <?echo $row["accountname"]?></u></b></a><a href="accedit.php?modules=<?echo $id?>&acc=<?echo $row["id"]?>" class="mini"><img src="../images/tool.gif" alt="" border="0" align="top"></a>
											&nbsp;&nbsp;
										</td>
									<?
								}
								?>
									<td class="mainwhite" align="right" nowrap><a href="accedit.php?modules=<?echo $id?>&acc=0"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Add new account!</u></b></a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="main" colspan="4" bgcolor="<?echo $cBGMainFunc?>" height="20">
							&nbsp;<a href="sendmail.php?modules=<?echo $id?>"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>Compose new mail</u></b></a>
						</td>
					</tr>
					<tr>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>" height="20">&nbsp;</td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>">&nbsp;<b>Date & Time:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>">&nbsp;<b>Subject:</b></td>
						<td class="main" bgcolor="<?echo $cBGMainInfo[0]?>">&nbsp;<b>From:</b></td>
					</tr>
				<?
				$msg=mysql_query("SELECT * from emailmsg where modules=$id order by time desc;");
				$bgcolor=0;
				while($row=mysql_fetch_array($msg)){
					$start='<td class="main" nowrap bgcolor="'.$cBGMulti[$bgcolor].'">';
					$stop='</td>';
					if($row["status"]==1){
						$start='<td class="main" nowrap bgcolor="'.$cBGMulti[$bgcolor].'"><b>';
						$stop='</b></td>';
					}
					?>
					<tr>
						<?
						echo $start.'<input type="checkbox" style="font-size:3pt;"  name="msg[]" value="'.$row["id"].'" class="main">'.$stop;
						echo $start."&nbsp;".date("Y-m-d H:i",$row["time"])."&nbsp;".$stop;
						echo $start.'&nbsp;<a href="showmail.php?msg='.$row["id"].'&modules='.$id.'">'.$row["subject"].'</a>'.$stop;
						$check=mysql_query("SELECT * from emailaddresses WHERE id=".$row["addresses"].";");
						if($row2=mysql_fetch_array($check)){
							if(strlen($row2["name"])>1){
								echo $start."&nbsp;".$row2["name"].$stop;
							}else{
								echo $start."&nbsp;".$row["fromemail"].$stop;
							}
						}else{
							echo $start."&nbsp;".$row["fromemail"].$stop;
						}
//						echo $start.$row["toemail"].$stop;
						?>
					</tr>
					<?
					$bgcolor=(++$bgcolor)%count($cBGMulti);
				}
				?>
				<tr>
					<td class="main" colspan="4" bgcolor="<?echo $cBGMainInfo[0]?>" align="left">
						<input type="checkbox" name="all" onClick="mark(this.checked)"> Select all
					</td>
				</tr>
				<tr>
					<td class="mainwhite" colspan="4" bgcolor="<?echo $cBGMainFunc?>" height="24" valign="middle">
						<input type="hidden" name="modules" value="<?echo $id?>">
						<input type="hidden" name="task" value="">
						&nbsp;<a href="javascript:delmsg();"><img src="../images/arrow.gif" alt="" border="0"> <b class="mainwhite"><u>delete selected messeges.</u></b></a>
					</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
<br>
<br>
<span class="main">This Webmailmodule uses class.POP3.php3 written by CDI at thewebmasters.net<br>
The class is published under the Artistic License</span></div>

</body>
</html>

