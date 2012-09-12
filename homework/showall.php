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
		$userright=mysql_num_rows($info);
if ($userright==1)
{  ?><html>
        <head>
        <title></title>
        <link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
		<!--<link rel="stylesheet" type="text/css" href="./style/<?php// echo $uistyle;?>/faq.css" media="all" />-->
        </head>
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
		<script LANGUAGE="JavaScript">
		var win = null;
		function showgraph(id,num)
			{	
					LeftPosition = (screen.width) ? (screen.width-700)/2 : 0;
					TopPosition = (screen.height) ? (screen.height-400)/2 : 0;
					settings =
					'height='+400+',width='+700+',top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,resizable=yes';		
					window.open("main.php?modules=" + id + "&num="+num, "edit", settings);
			}
		</script>
        <body bgcolor="#ffffff">
        <div align="center"></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="2">
    <tr valign="top">
      <td><h1><? echo $user->_($strHome_LabResultForAll);?> <? echo @mysql_result($info,0,"name"); ?></h1></td>
    </tr>   
  </table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="tdborder2">
  <tr>
    <td>
	<table width="100%" cellspacing="1" cellpadding="2" border="0" align="center" >
        <tr class="boxcolor"> 
          <td width="5%" align="center"  class="Bcolor"><b><? echo $user->_($strHome_LabNo);?></b></td>
          <td width="53%" align="center"  class="Bcolor"><b><? echo $user->_($strHome_LabQuestion);?></b></td>
          <td width="14%" align="center"  class="Bcolor"><b><? echo $user->_($strHome_LabPartType);?></b></td>
          <td width="13%" align="center"  class="Bcolor"><b><? echo $user->_($strHome_LabNoSender);?></b></td>
          <td width="7%" align="center"  class="Bcolor" nowrap><b><? echo $user->_($strHome_LabDetail);?></b></td>
          <td width="8%" align="center"  class="Bcolor"><b><? echo $user->_($strHome_LabGraph);?></b></td>
        </tr>
        <?	   
	$number=1;
			//echo "SELECT * FROM homework WHERE modules=$id ORDER BY id ".$descend.";";
    $assginfo=mysql_query("SELECT * FROM homework WHERE modules=$id ORDER BY id;");
    while($info=mysql_fetch_array($assginfo))
	  {                 ?>
        <tr id="trE<? echo $number;?>" onMouseOver="mouseOverRow('<? echo $number;?>', 1);" onMouseOut="mouseOverRow('<? echo $number;?>', 0);" bgcolor="#FFFFFF"> 
          <td   align="center"><? echo $number; ?></td>
          <td >            <? $q=$number-1;?>            <? echo nl2br($info["name"]); ?>            </td>
          <td  align="center">            <?
										   switch ($info["sendtype"]) 
											{	   case 1:
													   echo "Text";    break;
												   case 2:
														echo "URL";   break;
												   case 3:
													   echo "File";      break;
												}  /*  if ($info["sendtype"] == 1){ echo "Text"; } if($info["sendtype"] == 2){ echo "URL";} if ($info["sendtype"] == 3){ echo "File"; } */  
		    $count=mysql_query("SELECT count(id) as cnt FROM homework_ans WHERE refid=".$info["id"]." AND modules=$id;");         ?>            </td>
          <td align="center"  ><? echo  @mysql_result($count,0,"cnt"); ?></td>
          <td   align="center"><a href="showdetail.php?courses=<?php echo $courses; ?>&modules=<? echo $id; ?>&num=<? echo $number-1; ?>"><img src="../images/icon_go_up.gif" width="15" height="15" border="0"></a></td>
          <td   align="center">	        <? if(@mysql_result($count,0,"cnt") != 0){?>		  		<a href="JavaScript:showgraph(<? echo $id.",$q"; ?>)"><img src="../images/graph.gif" width="14" height="17" border="0"></a>            <? } else {
		  		echo "-";
		   	 } 
		  ?>		    </td>
        </tr>
        <?      $number++;    
       }	?>
      </table>
	  <table width="100%" border="0" cellspacing="2" cellpadding="1">
  		<tr>
    		<td>
			<input type="button" value="<? echo $user->_($strHome_LabIndex);?>" onClick="{location='index.php?id=<? echo $id; ?>';}" class="button">
			</td>
  		</tr>
	</table>
	</td>
  </tr>
</table>

                
<br>
<?         if ($pascal==1)
		       {   ?><table><tr><td   align="center"><a href="convert.php?id=<? echo $id; ?>">Fill header information to all file </a></td></tr></table>
<?           }  ?><?
  }else{      echo "Permission Deny!!!";      }   ?>
        </body>
        </html>