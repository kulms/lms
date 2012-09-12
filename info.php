<?php 	
	require("include/global_login.php");
	
	if ($person["firstname"] =="" ||  $person["firstname"] ==none )
	{ 
		header("Location: personal/prefs.php");
	}
	/*
	// Check E-mail Nontri KU Only	
	//===============================================================		
	if (!isset($just_login)){
			$just_login=0;
			session_register("just_login");
			$nontri=split('@',$person["email"]);
			
			if ($nontri[1]=="ku.ac.th"){
				//$mbox=imap_open("{nontri.ku.ac.th:993/imap/ssl/novalidate-cert}INBOX",$username,$password,OP_HALFOPEN);
				//$mbox = @imap_open("{nontri.ku.ac.th}INBOX","$slogin","$spassword",OP_HALFOPEN);
				$mbox = @imap_open("{nontri.ku.ac.th:993/imap/ssl/novalidate-cert}INBOX","$slogin","$spassword",OP_HALFOPEN);
				$status = @imap_status($mbox,"{nontri.ku.ac.th}INBOX",SA_ALL);
				
				if($status) {
				 $unseen=$status->unseen;
			}	
			@imap_close($mbox);
		}						
	}
	//===============================================================
	*/
?>
<html>
<head>
<title>Classroom Support</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="themes/<?php echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
<!--
function on3(){
        document.images[0].src="top-images/myinext.gif";
        document.images[1].src="top-images/spacer.gif";
        document.images[2].src="top-images/off-l.gif";
        document.images[3].src="top-images/starttab.gif";
        document.images[4].src="top-images/off-lr.gif";
        document.images[5].src="top-images/personaltab.gif";
        document.images[6].src="top-images/off-lr.gif";
        document.images[7].src="top-images/newstab.gif";
        document.images[8].src="top-images/on-rl.gif";
        document.images[9].src="top-images/coursetabon.gif";
        document.images[10].src="top-images/on-r.gif";
}
-->
</script>
<script language="JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script type="text/javascript" language="JavaScript" src="calendar/cal.js"></script>
</head>
<!--
<body bgcolor="White"  <? //if( @$person["id_number"]==""  ||  @$person["id_number"]==null ){ ?>onLoad="MM_openBrWindow('personal/checkinfo.php','checkinfo','status=no,resizable=yes,scrollbars=yes,width=600,height=550')"<? //} ?>>
-->
<body bgcolor="White">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
	    height="53" class="bg1">
          <tr> 
            <td class="menu" align="center"> <b>&nbsp;<?php echo $strStart_Header;?></b> 
            </td>
          </tr>
        </table>
        <br />
        <iframe src="https://course.ku.ac.th/maxlife/facebook_wallpost/index.php?user=<? echo $person["login"];?>" width="100%" height="440" frameborder="0">
                  <p>Your browser does not support iframes.</p>
               </iframe>
<br>
</body>
</html>