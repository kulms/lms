<?require("../include/global_login.php");
if($update==1){
	$comment=str_replace("'","&#039;",$comment);
	$upd = mysql_query("UPDATE peer_comments SET comment = '".$comment."' WHERE id =$upd_id;");
	?>
	<html>
	<head>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body bgcolor="#ffffff">
	<div align="center" class="h1">Your comments are updated...</div>	
	</body>
	</html>
	<?  
}else{
	$comment = str_replace("'","&#039;",$comment);
	$SQLStmt = "INSERT INTO peer_comments (modules,reviewer,author,comment) VALUES($modules,".$person["id"].",$author,'".$comment."');";
	$check=mysql_query("SELECT id FROM peer_comments WHERE modules=$modules AND reviewer=".$person["id"]." AND author=$author;");
	if(mysql_num_rows($check)!=0){
		$SQLStmt="UPDATE peer_comments SET comment='".$comment."' WHERE id=".mysql_result($check,0,"id").";";
	}
	$oRS = mysql_query($SQLStmt);?>
		<html>
		<head>
			<link rel="STYLESHEET" type="text/css" href="../main.css">
			<title>Comment</title>
		</head>
		<body bgcolor="#ffffff">
		<p>&nbsp;</p>
		<div align="center" class="h3">Your comments have been registered.</div><br>
		</body>
		</html>
	<?
	//'---------------------------
	//'	Skicka mail 
	//'---------------------------
	//'	Set jmail = Server.CreateObject("JMail.SMTPMail")
	//'	jmail.serveraddress="hobbe.informatik.gu.se"
	//'	jmail.sender	= "per.asberg@hgus.gu.se"
	//'	jmail.subject	= "dKurs: comment på PM"
	
	//'Här sätter jag alltså emailadresserna
	//'Skickar ett mail för varje uppsats
	//'	jmail.AddRecipient "per.asberg@hgus.gu.se"
	//'	jmail.body	= medd & " -> " & gransk("fnamn")
	
	//'	jmail.priority	= 3
	//'	JMail.AddHeader "Originating-IP",Request.ServerVariables("REMOTE_ADDR")
	//'	jmail.execute
	//'---------------------------
	//'	Slut mail
	//'---------------------------
	?>
<?}//End If ?>
