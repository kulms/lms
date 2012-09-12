<?  
	session_start();  
	require("../include/global_login.php");
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );
		
	$user = UserStorage::lookupById($person["login"]);
	
	session_register( 'user' ); 
	
	switch ($user->getCategory()) {
		case 0:
			$uistyle = "admin";
			break;
		case 1:
			$uistyle = "admin";
			break;
		case 2:
			$uistyle = "teacher";
			break;
		case 3:
			$uistyle = "student";
			break;
		default:
			$uistyle = "guest";
		}
	
	require "./style/$uistyle/header.php";
	require "./style/$uistyle/footer.php";	

	if($desc==1){
		$descend = ", sendtype DESC";
	}else{
		$descend = "";
	}

		//$info=mysql_query("SELECT id,users,name FROM modules WHERE users=".$person["id"]." AND id=$id;");
		$info=mysql_query("SELECT m.id,m.users,m.name FROM modules m, wp WHERE m.id=$id and m.id=wp.modules AND wp.users=".$person["id"].";");
		
		$userinfo=mysql_query("SELECT login,firstname,surname,email FROM users WHERE id=".$users.";"); 
		
		$hw_pref=mysql_query("SELECT * FROM homework_prefs WHERE modules=$id;");
		$end_date = @mysql_result($hw_pref,0,end_date);
		
		$userright=mysql_num_rows($info);
		
if ($userright==1)
{  ?><html>
        <head>
        <title></title>
        <link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
		<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
        </head>
		<script LANGUAGE="JavaScript">
		var win = null;
		function edit(id,hw_id)
			{	
					LeftPosition = (screen.width) ? (screen.width-550)/2 : 0;
					TopPosition = (screen.height) ? (screen.height-400)/2 : 0;
					settings =
					'height='+400+',width='+550+',top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,resizable=yes';		
					window.open("showtext.php?id=" + id + "&hw_id="+hw_id, "edit", settings);
			}
		</script>
		<script language="JavaScript">
		function mouseOverRow(gId, onOver){	
			if(document.getElementById){
				if(onOver==1)
					//eval("document.getElementById('trE" + gId + "')").bgColor="#FFF5E8";
					eval("document.getElementById('trE" + gId + "')").bgColor="#B3F2EF";
					//eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";					
				else
					eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";		
			}//end if
		}//end function
		</script>
        <body bgcolor="#ffffff">
        <div align="center"></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="2">
    <tr valign="top">
      <td><h1>Results in <? echo @mysql_result($info,0,"name"); ?><br>
        user : <? echo @mysql_result($userinfo,0,"title").@mysql_result($userinfo,0,"firstname")." ".@mysql_result($userinfo,0,"surname");?> 
      </h1></td>
    </tr>   
  </table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="tdborder2">
  <tr>
    <td>
	<table width="100%" cellspacing="1" cellpadding="3" border="0" align="center" >
        <tr class="boxcolor"> 
          <td width="7%" align="center"  class="Bcolor"><b>No.</b></td>
          <td width="35%" align="center" class="Bcolor" ><b>Assignment</b></td>
          <td width="15%" align="center"  class="Bcolor"><b>Participation Type</b></td>
		  <td width="22%" align="center"  class="Bcolor"><b>Date-Time</b></td>
          <td width="21%" align="center"  class="Bcolor"><b>Score</b></td>
        </tr>
        <?	   
	$number=1;
			//echo "SELECT * FROM homework WHERE modules=$id ORDER BY id ".$descend.";";
    $assginfo=mysql_query("SELECT * FROM homework WHERE modules=$id ORDER BY id;");
    while($info=mysql_fetch_array($assginfo))
	  {  
	  $sql = mysql_query("SELECT * FROM homework_ans WHERE refid=".$info["id"]." AND modules=$id AND users=$users;");
	 ?>
        <tr id="trE<? echo $number;?>" onMouseOver="mouseOverRow('<? echo $number;?>', 1);" onMouseOut="mouseOverRow('<? echo $number;?>', 0);" bgcolor="#FFFFFF"> 
          <td   align="center"><? echo $number; ?></td>
          <td  ><? echo nl2br($info["name"]); ?></td>
          <td  align="center">
            <?
			   switch ($info["sendtype"]) 
				{	   case 1:
						   echo "Text";    break;
					   case 2:
							echo "URL";   break;
					   case 3:
						   echo "File";      break;
				}  /*  if ($info["sendtype"] == 1){ echo "Text"; } if($info["sendtype"] == 2){ echo "URL";} if ($info["sendtype"] == 3){ echo "File"; } */  
		    //$count=mysql_query("SELECT count(id) as cnt FROM homework_ans WHERE refid=".$info["id"]." AND modules=$id;");
			?>
            
		  </td>
		  <td align="center"  class="red">
            <?
				if(@mysql_result($sql,0,"time") != 0) {
					if(@mysql_result($sql,0,"time") > $end_date) {
				?>
            <? echo  date("d-m-Y H:i",@mysql_result($sql,0,"time")); ?>
            <? 	} else {?>
            <? echo  date("d-m-Y H:i",@mysql_result($sql,0,"time")); ?>
            <? 	}
				} else {
					echo "-";
				}
			?>
			
          </td>
          <td align="center">
            <? 
			if(@mysql_result($sql,0,"time") != 0) {
				if (@mysql_result($sql,0,"marks") != 0){
				?>
            <a href="JavaScript:edit(<? echo @mysql_result($sql,0,"id").",".$info["id"]; ?>)">
            <?
					echo @mysql_result($sql,0,"marks");
				?>
            </a> 
            <?	
				} else {
				?>
            <a href="JavaScript:edit(<? echo @mysql_result($sql,0,"id").",".$info["id"]; ?>)"> 
            <?
					echo "no score";
				?>
            </a> 
            <?	
				}
			} else {				
				echo "-";			
			}
			?>
			
          </td>
        </tr>
        <?      $number++;    
       }	?>
      </table>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td align="center"><input type="button" value="Back" onClick="history.back()" class="button"></td>
  </tr>
</table>

                
<br>
<?        
}else{      
echo "Permission Deny!!!";      
}   ?>
</body>
</html>