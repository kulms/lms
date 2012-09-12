<?
require("../include/global_login.php");
require("../include/colors.php");
include("class.pop3.php");
?>
<html>
<head>
	<title>Checkmail</title>
<script language="javascript">
function startup(){
	self.opener.updatewindow();
	setTimeout('self.close()',1000);
}
</script>
</head>
<body bgcolor="<?echo $cBGcolor?>">
checking email....<br>
<?
$mailc=mysql_query("SELECT * from email WHERE modules=$id AND id=$acc;");
$err=0;
while($row=mysql_fetch_array($mailc)){
	echo "Checking ".$row["accountname"]."<br>";
 	$pop3 = new POP3();
	if(!$pop3->connect($row["server"],110)){
        echo "Cant connect to ".$row["server"]." $pop3->ERROR <BR>\n";
		$err=1;
        break;
    }
    $Count = $pop3->login($macc,$mpas);
    if( (!$Count) or ($Count == -1) ){
        echo "Login Failed: $pop3->ERROR <br>\n";
		$err=1;
        break;
    }
//    register_shutdown_function($pop3->quit());

    if ($Count < 1)
    {
        echo "Login OK: Inbox EMPTY<BR>\n";
    } else {
        echo "Login OK: Inbox contains [$Count] messages<BR>\n";
    }
	for($a=1;$a<=$Count;$a++){
	    $MsgOne = $pop3->get($a);
	    if( (!$MsgOne) or (gettype($MsgOne) != "array") )
	    {
	        echo "oops, $pop3->ERROR<BR>\n";
			$err=1;
	        break;
	    }
		$msg="";
		$subject="";
		$from="";
		$to="";
		$email=0;
		$bound=" ";
		$msgid="";
		$everything="";
		mysql_query("INSERT INTO emailmsg (subject,modules) values('undef',".$id.");");
		$emailid=mysql_insert_id();
	    while ( list ( $lineNum,$line ) = each ($MsgOne) )
	    {
			$everything.=$line;
			if(eregi("Subject:(.*)",$line,$temp) && $subject==""){
				$subject=str_replace("=?iso-8859-1?Q?","",quoted_printable_decode($temp[1]));
				$subject=str_replace("?=","",$subject);
			}

//			if(eregi("From (.*)\n",$line,$temp) && $from==""){
//				$from=explode(" ",$temp[1]);
//				$from=quoted_printable_decode($from[0]);
//			}
			if($from=="" && (eregi("^From",$line) || eregi("^Return-Path:",$line))){
				if(eregi('([a-z0-9_]|\\-|\\.)+@([a-z0-9_]|\\-|\\.)+',$line,$temp)){
					$from=$temp[0];
				}
			}
			if(eregi("To:",$line) && $to==""){
				if(eregi('([a-z0-9_]|\\-|\\.)+@([a-z0-9_]|\\-|\\.)+',$line,$temp)){
					$to=$temp[0];
				}
			}
			if(eregi("Message-Id:(.*)\n",$line,$temp) && $msgid==""){
				$msgid=$temp[1];
			}
			if(eregi("boundary=\"(.*)\"",$line,$temp) && $bound==" "){
				$bound=$temp[1];
//				echo $bound;
			}
			if($bound!=" " && eregi("--".$bound,$line)){
//				echo "Attach{";
				$email=0;
				$attach=0;
				$att="";
				$started=0;
				$filename="";
				$mimetype="text/html";
				while(list ( $lineNum,$line ) = each ($MsgOne)){
					$everything.=$line;
					if(eregi("--".$bound,$line)){
						break;
					}
					if(eregi("Content-Type: (.*);",$line,$temp)){
						$mimetype=$temp[1];
						if(eregi("text/html",$mimetype) || eregi("text/plain",$mimetype)){
							$email=1;
							if(eregi("text/plain",$mimetype)){
								$nl=1;
							}else{
								$nl=0;
							}
						}else{
							$attach=1;
						}
					}
					if(eregi("filename=\"(.*)\"",$line,$temp)){
						$filename=$temp[1];
					}
					if($started && $email){
						if($nl){
							$msg.=nl2br(quoted_printable_decode($line));
						}else{
							$msg.=str_replace("=\n","",quoted_printable_decode($line));
						}
					}
					if($started && $attach){
						$att.=$line;
					}
					if($line=="\r\n"){
						$started=1;
					}
				}
				$line=prev($MsgOne);
				if($started && $attach){
					mysql_query("insert into emailattach (emailmsg,mime,filename,encode,cont) values($emailid,'$mimetype','$filename','$encode','$att');");
				}
				$email=0;
//				echo " }";
			}
			if($email==1 && $bound==" "){
				$msg.=nl2br(str_replace("=\n","",quoted_printable_decode($line)));
			}
			if($line=="\r\n"){
				$email=1;
			}
			echo ". ";
	    }
		if(!eregi("([[:alnum:]])",$subject)){
			$subject="[no subject]";
		}
		$check=mysql_query("SELECT * from emailaddresses WHERE email='$from';");
		if(mysql_num_rows($check)==0){
			mysql_query("INSERT INTO emailaddresses (name,email) values('','$from')");
			$address=mysql_insert_id();
		}else{
			$address=mysql_result($check,0,"id");
		}
		$check=mysql_query("SELECT * from email_mod_add WHERE emailaddresses=$address AND modules=$id;");
		if(mysql_num_rows($check)==0){
			mysql_query("INSERT INTO email_mod_add (modules,emailaddresses) values($id,$address);");
		}
		
		$check=mysql_query("SELECT id from emailmsg where msgid='$msgid' and modules=".$id." and subject='".$subject."' and fromemail='".$from."' and toemail='".$to."';");
		if(mysql_num_rows($check)==0){
			mysql_query("UPDATE emailmsg set time=".time().",info='".str_replace("'","&#039;",$msg)."',modules=$id,subject='$subject',fromemail='$from',toemail='$to',msgid='$msgid',addresses=$address WHERE id=$emailid;");
		}else{
			mysql_query("DELETE from emailmsg WHERE id=$emailid;");
			mysql_query("DELETE from emailattach WHERE emailmsg=$emailid;");
		}
		if($row["delmsg"]==1){
			if(!$pop3->delete($a)){
				$err=1;
				$pop3->reset();
				break;
			}
		}
	}
	$pop3->quit();
}
if($err==1){
	?>
	<br><b>Error cant check mail<br>or mailbox is empty.</b>
	<?
}else{
	?>
	<br><b>Email checked.</b>
	<?

}
?>
<script language="javascript">
startup();
</script>
</body>
</html>

