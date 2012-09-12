<?	 
session_start();
$session_id = session_id();
require ("../include/global_login.php");
require("../include/online.php");
require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );
	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 

online_courses($session_id,$person["id"],$courses,time(),1);

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

mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");
$check=mysql_query("SELECT name,info FROM modules WHERE id=$id;");
$getassg=mysql_query("SELECT * FROM homework WHERE modules=$id;");

//$rightcheck=mysql_query("SELECT id,users FROM modules WHERE users=".$person["id"]." AND id=$id;");
$rightcheck=mysql_query("SELECT m.id, m.users FROM modules m, wp WHERE m.id=$id and m.id=wp.modules AND wp.users=".$person["id"].";");

$userright=mysql_num_rows($rightcheck);
$getinfo = mysql_query("SELECT end_date FROM homework_prefs WHERE modules=$id;");

if(mysql_num_rows($getinfo)!=0)
{		//if prefs exists
        $end_date=mysql_result($getinfo,0,"end_date");
        $go=0;
        if($end_date!=0)
		{  if($end_date>time())
	   	   {      $go=1;
           }
		 }else{   $go=1;
              }
}		?>
<html>
<head>
<title>Homework</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<script LANGUAGE="JavaScript">
function show(id)
	{	
			window.open("showanswer.php?id=" + id + "", "show", "width=550,height=300,scrollbars=yes,resizable=yes ");			
	}
</script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<body bgcolor="#ffffff">
<div align="center"  class="info">
<? if($go==1 )
{	 ?>
<script language="javascript">
function delIt() {
	if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Homework').'?';?>" )) {
		document.frmDelete.submit();
	}
}
</script>
<script language="JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
<!-- homework Header-->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="50%"> 
      <h1><? echo $user->_($strHome_LabInfo);?></h1></td>    
  </tr>
</table>
  <table border="0" cellpadding="4" cellspacing="0" width="100%">
    <tr> 
      <? if(@$user->getCategory() == 2 && $userright == 1) {?>
      <td > <table width="80%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="16%" valign="middle"><img src="../images/_edit-16.png" border="0"><a href="admin.php?id=<? echo $id;?>&courses=<? echo $courses;?>"> 
              <? echo $user->_($strEdit);?></a> </td>
            <td width="84%" valign="middle">
                
                  <a href="javascript:delIt()"> <img src="../images/_trash_full-16.png" border="0"> 
              </a>
                  <a href="javascript:delIt()"><? echo $user->_($strDelete);?></a> 
                  
                
            </td>
          </tr>
        </table>
        

        
      </td>
      <td align="right"> 
	  <form name="frmDelete" action="deletehomework.php" method="post">		
		<input type="hidden" name="modules" value="<? echo $id?>" />
	  </form>	  
	  </td>
      <? }?>
    </tr>    
  </table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder2">
<tr>
<td>

</td>


<td>
</td>
</tr>
<tr>
	<td width="100%" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap class="hilite"><?php echo $user->_($strHome_LabDes);?>:</td>
            <td class="hilite" width="100%" bgcolor="#FFFFFF"> <? echo nl2br(mysql_result($check,0,"info")); ?> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap class="hilite"><?php echo $user->_($strHome_LabDate);?>:</td>
            <td bgcolor="#FFFFFF"> <font color="#FF0000"> 
              <? 
		  	if (mysql_result($getinfo,0,"end_date") != 0) 
			{	
				echo date("d/m/Y", mysql_result($getinfo,0,"end_date")); ?>
              &nbsp;&nbsp;เวลา&nbsp;<? echo date("H:i", mysql_result($getinfo,0,"end_date")); ?> 
              น. 
              <? 
			}
			else
			{  
				echo "None"; 
			}  
			?>
              </font> </td>
          </tr>                
        </table>
	</td>	 
</table>

<!--  Homework Detail-->
  <table width="100%" border="0" cellpadding="0" cellspacing="2">
    <tr valign="top">
      <td> <h1> <? echo $user->_($strHome_LabDetail);?> </h1></td>
    </tr>   
  </table>
  <table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder2">
    <tr> 
      <td> </td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> 
        <table cellspacing="1" cellpadding="2" border="0" width="100%">
          <tr class="boxcolor"> 
            <td align="right" nowrap width="3%" class="Bcolor"><strong><? echo $user->_($strHome_LabNo);?></strong></td>
            <td width="23%" align="center" class="Bcolor"><strong><? echo $user->_($strHome_LabQuestion);?></strong> 
            </td>
            <td width="6%" align="center" class="Bcolor"><strong><? echo $user->_($strHome_LabAttach);?></strong></td>
            <td width="7%" align="center" class="Bcolor"><strong><? echo $user->_($strHome_LabAction);?></strong></td>
          </tr>
          <? 	
		 		$rs=mysql_query("SELECT  r.name,r.text,r.id,r.url,r.file,r.modules,r.time,u.firstname,u.firstname,u.surname FROM homework r,users u WHERE r.modules='$id' AND r.users=u.id ORDER BY r.id ASC;");
				$number=1;
				while($row=mysql_fetch_array($rs))
				{ 				
		?>		
          <!--<tr id="trE<? echo $number;?>" onMouseOver="mouseOverRow('<? echo $number;?>', 1);" onMouseOut="mouseOverRow('<? echo $number;?>', 0);" bgcolor="#FFFFFF">-->
		  <tr bgcolor="#FFFFFF">
		 
            <? 
	  			if($row["text"]==1)
	   			{ 
			?>
            <td width="3%" align="right" nowrap class="hilite"><?php echo $user->_($number);?>:</td>
            <td width="23%" class="hilite">               
              <?  echo nl2br($row["name"]); ?>
            </td>
            <td width="8%" align="center" nowrap class="hilite"> -</td>
            <?     
				}else{  
					if(strlen($row["url"])!=0)
			   		{ 
			  ?>
            <td width="3%" align="right" nowrap class="hilite"><?php echo $user->_($number);?>:</td>
            <td  width="23%" class="hilite"> <?  echo nl2br($row["name"]); ?>
            </td>
			<td width="8%" align="center" nowrap class="hilite"> <a href="<? echo $row["url"]?>" target="_blank"> 
              <img src="../images/www.gif" width="16" height="16" border="0"><?php echo $user->_($strLink);?></a> 
            </td>
            <?        }else{  ?>
            <td width="3%" align="right" nowrap class="hilite"><?php echo $user->_($number);?>:</td>
            <td width="23%" class="hilite">  <?  echo nl2br($row["name"]); ?>
            </td>
			<td width="6%" align="center" nowrap class="hilite">
              <?	
						  $filetype = strtolower(substr($row["file"], strrpos($row["file"],".")+1 ) );  
						  $filesize = @filesize("../files/homework/files/".$row["id"]."/".$row["file"]."");
						  $file = "../files/homework/files/".$row["id"]."/".$row["file"]."";
			?>&nbsp;
              <a href="../download.php?m=hw&courses=<?php echo $courses; ?>&id=<?php echo $row["id"] ?>&filename=<?php echo $row["file"];?>"><img src="../images/save2.gif" width="16" height="16" border="0"> 
              <?php echo $user->_($strSave);?></a> </td>
            <? 					}
						}						
			?>
            <?			
          if ($userright == 1)
	{ ?>
            <td width="7%" align="center" class="hilite"> <a href="edit.php?modules=<? echo $id; ?>&id=<? echo $row["id"]; ?>"><img src="../images/_edit-16.png" alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"]); ?>" border="0" align="top"> 
              <?php echo $user->_($strEdit);?> </a> <a onClick="if(confirm('Realy delete?')){location='delete.php?modules=<? echo $id; ?>&id=<? echo $row["id"]; ?>';}" style="cursor:hand;color:red;text-decoration:underline;"> 
              <img src="../images/_delete.gif" alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"]); ?>" border="0" align="top"><?php echo $user->_($strDelete);?></a> 
            </td>
          </tr>
          <? 
	$number++; 
	} else {  
			if ($user->getCategory() == 3 || $user->getCategory() == 2)   {
				  $anscheck=mysql_query("SELECT * FROM homework_ans WHERE refid=".$row["id"]." AND users=".$person["id"].";");
				  $i=mysql_num_rows($anscheck);
					  switch ($i):
						  case 0: 
						      ?>
            <td width="6%" align="center" class="hilite"><a href="send_form.php?modules=<? echo $id; ?>&id=<? echo $row["id"]; ?>"><img src="../images/reply.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"]); ?>" border="0" align="top"><?php echo $user->_($strSend);?></a></td>
          </tr>
          <? 
							  $number++; 
						      break;
						  case 1:
							  ?>
            <td width="6%" align="center"  class="hilite"><a href="send_form.php?modules=<? echo $id; ?>&id=<? echo $row["id"]; ?>"><img src="../images/_edit-16.png" width="16" height="16" border="0" align="top"> 
              <?php echo $user->_($strEdit);?></a></td>
          </tr>
          <? 
							  $number++;
							  break;
						  default:
							  ?>
          <td width="6%" height="24" align="center" >&nbsp;</td>
          </tr>
          <? 
      						  $number++;
					   endswitch; 
					} else {
		 ?>
		   <td width="6%" align="center" class="hilite">-</td>
          </tr>
		 <?		
		 			}		
						
			  }		// end else			  
			  
			  ?>
          <? 
		  } // end while
		  ?>
        </table>
        <table width="60%" border="0" cellspacing="2" cellpadding="1">
          <tr>
            <td><?
				if ($userright == 1)
				{	?>
          <input type="button" name="new_home" value="<?php echo $user->_($strHome_BtnNewQuestion);?>" class="button" onClick="{location='edit.php?modules=<? if($modules != 0) { echo $modules;} else { echo $id;}?>&id=0&add=1';}">
          <input type="button" name="result" value="<?php echo $user->_($strResult);?>" class="button" onClick="{location='showall.php?id=<? echo $id; ?>&courses=<? echo $courses;?>';}">
          <?
		  //echo $courses;
			}
			?>
		</td>
          </tr>
        </table></td>    
  </table>
<?		
}else{  // - - - - -$go!=1 - - - - - 
				echo "<img src=\"../images/stop_sign.gif\" border=\"0\" align=\"top\">";
				echo "<font color=\"red\"><b> ".$strHome_LabHomeClose." </b></font>"; 
				echo "<img src=\"../images/stop_sign.gif\" border=\"0\" align=\"top\"><br>";
?>
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
<? if (($user->getCategory() == 3) && ($userright != 1)) {
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="50%"> 
      <h1><? echo $user->_($strHome_LabScore);?></h1></td>    
  </tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder2">
    <tr> 
      <td> </td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="1" cellpadding="2" border="0" width="100%">
          <tr class="boxcolor"> 
            <td align="right" nowrap width="3%" class="Bcolor"><strong><? echo $user->_($strHome_LabNo);?></strong></td>
            <td width="82%" align="center" class="Bcolor"><strong> </strong><strong><? echo $user->_($strHome_LabQuestion);?></strong></td>
            <td width="25%" class="Bcolor"><strong><? echo $user->_($strHome_LabScore);?></strong></td>
          </tr>
          <? 	
		 		$rs=mysql_query("SELECT  r.name,r.text,r.id,r.url,r.file,r.modules,r.time,r.points,u.firstname,u.firstname,u.surname FROM homework r,users u WHERE r.modules='$id' AND r.users=u.id ORDER BY r.id ASC;");
				$number=1;
				while($row=mysql_fetch_array($rs))
				{ 				
		?>
          <tr id="trE<? echo $number;?>" onMouseOver="mouseOverRow('<? echo $number;?>', 1);" onMouseOut="mouseOverRow('<? echo $number;?>', 0);" bgcolor="#FFFFFF">
            <? 
	  			if($row["text"]==1)
	   			{ 
			?>
            <td align="right" nowrap width="3%" ><?php echo $user->_($number);?>:</td>
            <td width="82%"> 
              <?php //echo $book->getBookNameTh();?>
              <?  echo nl2br($row["name"]); ?>
            </td>
            <?     
				}else{  
					if(strlen($row["url"])!=0)
			   		{ 
			  ?>
            <td align="right" nowrap width="3%"><?php echo $user->_($number);?>:</td>
            <td  width="75%"> 
              <?php //echo $book->getBookNameTh();?>
              <a href="<? echo $row["url"]?>" target="_blank"><? echo $row["name"]?></a> 
            </td>
            <?        }else{  ?>
            <td align="right" nowrap width="3%"><?php echo $user->_($number);?>:</td>
            <td  width="75%"> 
              <?php //echo $book->getBookNameTh();?>
              <a href="../files/homework/files/<? echo $row["id"]."/".$row["file"]; ?>" target="_blank"><? echo $row["name"]; ?></a> 
            </td>
            <? 					}
						}						
			?>
            <?			
          if ($userright == 1)
	{ ?>
            <td  width="25%"> 10</td>
          </tr>
          <? 
	$number++; 
	} else {      
				  $anscheck=mysql_query("SELECT * FROM homework_ans WHERE refid=".$row["id"]." AND users=".$person["id"].";");
				  $i=mysql_num_rows($anscheck);
				  $row_ans = mysql_fetch_array($anscheck);
					  switch ($i):
						  case 0: 
						      ?>
            <td  width="25%"><a href="send_form.php?modules=<? echo $id; ?>&id=<? echo $row["id"]; ?>"><? echo "no score";?></a></td>
          </tr>
          <? 
							  $number++; 
						      break;
						  case 1:
							  ?>
            <td   width="25%"><? echo $row_ans["marks"];?> (Max 
              = <? echo $row["points"];?>) </td>
          </tr>
          <? 
							  $number++;
							  break;
						  default:
							  ?>
          <td width="25%" height="24" align="center" >&nbsp;</td>
          </tr>
          <? 
      						  $number++;
					   endswitch; 			
			  }		// end else			  
			  ?>
          <? 
		  } // end while
		  ?>
        </table></td>    
  </table>
<?
}
?>		
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="50%"> 
      <h1><? echo $user->_($strHome_LabSolution);?></h1></td>    
  </tr>
</table>
  <table border="0" cellpadding="4" cellspacing="0" width="100%">
    <tr> 
      <? if(@$user->getCategory() == 2) {?>
	  <script language="javascript">
		function delIt() {
			if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Homework').'?';?>" )) {
				document.frmDelete.submit();
			}
		}
		</script>
      <td nowrap="nowrap"> <table width="90%" border="0" cellspacing="2" cellpadding="1">          
          <tr> 
            <td width="10%"><img src="../images/_edit-16.png" border="0"> <a href="admin.php?id=<? echo $id;?>&courses=<? echo $courses;?>"><? echo $user->_($strEdit);?></a> 
            </td>
            <td width="90%"><a href="javascript:delIt()"> <img src="../images/_trash_full-16.png" border="0"> 
              </a><a href="javascript:delIt()"><? echo $user->_($strDelete);?></a></td>
          </tr>
        </table>
        
      </td>
      <td align="right" nowrap="nowrap"> 
	  <form name="frmDelete" action="deletehomework.php" method="post">		
		<input type="hidden" name="modules" value="<? echo $id?>" />
	  </form>	  
	  <table cellspacing="0" cellpadding="0" border="0">
          <tr> 
            <td> <a href="javascript:delIt()"> </a> </td>
            <td>&nbsp; </td>
          </tr>
        </table></td>
      <? }?>
    </tr>    
  </table>
  <table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder2">
    <tr> 
      <td> </td>
    </tr>
    <tr> 
      <td width="50%" valign="top"> <table cellspacing="1" cellpadding="2" border="0" width="100%">
          <tr class="boxcolor"> 
            <td align="right" nowrap width="3%" class="Bcolor"><strong><? echo $user->_($strHome_LabNo);?></strong></td>
            <td width="23%" align="center" class="Bcolor"><strong> </strong><strong><? echo $user->_($strHome_LabQuestion);?></strong></td>
			 
            <td width="6%" align="center" class="Bcolor"><strong><? echo $user->_($strHome_LabAttach);?></strong></td>
            <td width="7%" class="Bcolor"><strong><? echo $user->_($strHome_LabAnswer);?></strong></td>
          </tr>
          <? 	
		 		$rs=mysql_query("SELECT  r.name,r.text,r.id,r.url,r.file,r.modules,r.time,r.answer_type,r.answer,u.firstname,u.firstname,u.surname FROM homework r,users u WHERE r.modules='$id' AND r.users=u.id ORDER BY r.id ASC;");
				$number=1;
				while($row=mysql_fetch_array($rs))
				{ 				
		?>
          <!--<tr id="trE<? echo $number+1000;?>" onMouseOver="mouseOverRow('<? echo $number+1000;?>', 1);" onMouseOut="mouseOverRow('<? echo $number+1000;?>', 0);" bgcolor="#FFFFFF">-->
		  <tr bgcolor="#FFFFFF">
            <? 
	  			if($row["text"]==1)
	   			{ 
			?>
            <td width="5%" align="right" nowrap class="hilite"><?php echo $user->_($number);?>:</td>
            <td  width="43%" class="hilite"> 
              <?php //echo $book->getBookNameTh();?>
              <?  echo nl2br($row["name"]); ?>
            </td>
			 <td width="11%" align="center" nowrap class="hilite"> -</td>
            <?     
				}else{  
					if(strlen($row["url"])!=0)
			   		{ 
			  ?>			  
            <td width="7%" align="right" nowrap class="hilite"><?php echo $user->_($number);?>:</td>
            <td  width="4%" class="hilite"> 
              <?php //echo $book->getBookNameTh();?>
              <a href="<? echo $row["url"]?>" target="_blank"><? echo $row["name"]?></a> 
            </td>
			<td width="5%" align="center" nowrap class="hilite"> <a href="<? echo $row["url"]?>" target="_blank"> 
              <img src="../images/www.gif" width="16" height="16" border="0"><?php echo $user->_($strLink);?></a> 
            </td>
            <?        }else{  ?>
            <td width="3%" align="right" nowrap class="hilite"><?php echo $user->_($number);?>:</td>
            <td  width="2%" class="hilite">               
              <a href="../files/homework/files/<? echo $row["id"]."/".$row["file"]; ?>" target="_blank"><? echo $row["name"]; ?></a> 
            </td>
			<td width="14%" align="center" nowrap class="hilite"> 
			<a href="javascript:NewWindow('../files/homework/files/<? echo $row["id"]."/".$row["file"]; ?>','name','screen.availWidth','screen.availHeight','yes');">
			
			<img src="../images/view.gif" width="16" height="16" border="0"><?php echo $user->_($strView);?></a>
              <?	
						  $filetype = strtolower(substr($row["file"], strrpos($row["file"],".")+1 ) );  
						  $filesize = @filesize("../files/homework/files/".$row["id"]."/".$row["file"]."");
						  $file = "../files/homework/files/".$row["id"]."/".$row["file"]."";
			?>&nbsp;
              <a href="download_file.php?filename=<? echo $file;?>"><img src="../images/save2.gif" width="16" height="16" border="0"> 
              <?php echo $user->_($strSave);?></a>
		    </td>
            <? 					}
						}						
			?>			
            <?			
          if ($userright == 1)
	{ ?>
            <td  width="6%" class="hilite"> <a href="edit.php?modules=<? echo $id; ?>&id=<? echo $row["id"]; ?>&courses=<? echo $courses; ?>"><img src="../images/_edit-16.png" alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"]); ?>" border="0" align="top"> 
              <?php echo $user->_($strEdit);?></a></td>
          </tr>
          <? 
			$number++; 
	} else {      
			$number++; 
			?>
            <td   width="5%" class="hilite">
			<?	
					switch ($row["answer_type"]){
					case 1:
							//echo "view";
							?>
							<a href="javascript:NewWindow('showanswer.php?id=<? echo $row["id"]; ?>','name','400','400','yes');"><img src="../images/view.gif" width="16" height="16" border="0"><?php echo $user->_($strView);?></a>							
							<?
							break;
					case 2:
							//echo "view";
							?>
							<a href="javascript:NewWindow('showanswer.php?id=<? echo $row["id"]; ?>','name','400','400','yes');"><img src="../images/view.gif" width="16" height="16" border="0"><?php echo $user->_($strView);?></a>							
							<?
							break;
					case 3:
							?>					
							<a href="../files/homework/solutions/<? echo $row["id"]."/".$row["answer"]; ?>" target="_blank"><img src="../images/view.gif" width="16" height="16" border="0">view</a>
							<?
							break;
					default;
							echo "-";
							break;		
					}					
			?>			
			</td>
          </tr>          
          <? 
			  }		// end else			  
			  ?>
          <? 
		  } // end while
		  ?>
        </table>
        <table width="60%" border="0" cellspacing="2" cellpadding="1">
          <tr>
            <td>
			<?
				if ($userright == 1)
				{	?>
		          <input type="button" name="result" value="<?php echo $user->_($strResult);?>" class="button" onClick="{location='showall.php?id=<? echo $id; ?>&courses=<? echo $courses;?>';}">
         		 <?
				}
				?>
			</td>
          </tr>
        </table></td>    
  </table>
  <?				
}	 
?>
</div>
</body>
</html>
<?		mysql_close();		?>