<?  
		session_start();
		$session_id = session_id();		
				
		require("../include/global_login.php");
		require("../include/getsize.php");
		require("../include/online.php");
		require("syllabus.inc.php");
		online_courses($session_id,$person["id"],$courses,time(),1); 
		require_once ("./classes/User.php");
		require_once ("./classes/UserStorage.php");
		require_once( "./includes/main_functions.php" );
			
		$user = UserStorage::lookupById($person["login"]);
		
		//session_register( 'user' ); 
		$_SESSION['user'] = $user;
		
		//online_courses($session_id,$person["id"],$courses,time(),1);
		
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


		$check = mysql_query("SELECT * FROM wp WHERE courses=$courses AND users=".$person["id"]." AND admin=1;");
		$sel=mysql_query("SELECT * FROM syllabus WHERE courses=$courses;");
		$def = mysql_query("select su.* from syllabus_userdef su where courses = $courses order by id;" );
		if ((mysql_num_rows($sel) == 0) AND ($person["category"]==2 )) { ?>
		<META HTTP-EQUIV="Refresh" CONTENT="0;URL=setup_select.php?courses=<? echo $courses;?>">
		<?
		}
		$row=mysql_fetch_array($sel);
		$row_check=mysql_fetch_array($check);
		
		//$pat=":";		//suthee
		//$arr=split($pat,$row["grading"]);					//suthee
?>
<html>
<head>
<title>Course Syllabus</title>
<head>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php// echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php//echo $uistyle;?>/faq.css" media="all" />!-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<script language="javascript">
function delIt(id) {
	if (confirm( "doDelete this Syllabus File ?" )) {
		document.location="deletesyllabus.php?courses="+id;	}
}
</script>
<body bgcolor="#FFFFFF">
<?
		 if ((mysql_num_rows($sel) != 0) AND ($person["category"]==2 ) AND ($person["id"]==$row_check["users"]))
		{
			include("header.php");
		}
		else 
		{
?>
	<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" height="53" class="bg1">
  <tr>
    <td class="menu" align="center"><b><?php echo $strSyllabus_Header; ?></b></td>
  </tr>
</table><br>
<?		
		}
?>

<?
if (mysql_num_rows($sel) != 0) {
 if (($person["category"]==2 ) && ($person["id"]==$row_check["users"]))
		{
?>
<table width="90%" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr> 
    <td height="35" class="mini" width="50%"> 
      <?php
	if(  $row["syllabus_upload"]!="" && $row["syllabus_upload"]!=none  ) 
	{    
	?>
      <strong><?php echo $strSyllabus_LabBasic;?> >></strong> <a href="setup_file.php?courses=<? echo $courses;?>"><?php echo $strSyllabus_LabEditFile;?></a> 
	  <strong>&gt;&gt;</strong><a href="javascript:delIt(<? echo $courses;?>)"> 
      <?php echo $strSyllabus_LabDelFile;?></a> 
      <?
	}
	?>
    </td>
    <td height="35" class="mini" width="50%" align="left"> 
      <?	
	if (mysql_num_rows($def) > 0) {
	?>
      <strong><?php echo $strSyllabus_LabAdvance;?> &gt;&gt;</strong> 
      <? 
				 if (mysql_num_rows($check)>0)
					 { 		 ?>
      <a href="edit.php?courses=<? echo $courses; ?>"> <?php echo $strSyllabus_LabEditAdvance;?></a> 
      <? 
					}  
		}			
					?>
    </td>
  </tr>
</table>
<?php
}
if(  $row["syllabus_upload"]!="" && $row["syllabus_upload"]!=none  ) 
{    ?>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center"   class="tdborder1">
  <tr>
    <td>
	  <table cellspacing="1" cellpadding="3" width="90%" align="center">
        <tr> 
          <td width="19%" align="right" nowrap="nowrap"><?php echo $strSyllabus_LabFileName;?>:</td>
          <td width="81%" align="left" class="hilite">

			  <a href="<? echo "../download.php?m=syllabus&id=".$courses."&filename=".$row["newuploadfilename"]."&courses=".$courses."&req=".$person["id"]; //echo "../files/syllabus/$courses/".$row["newuploadfilename"]; ?>" 
					target="<? if($row["new_window"]==0) 
												echo "_self";
										else 
												echo "_blank"; 	?>"> 
				<?php 
					  $syllabus_filetype = strtolower(substr($row["newuploadfilename"], strrpos($row["newuploadfilename"],".")+1 ) );  
					  //$syllabus_filesize = filesize("../files/syllabus/$courses/".$row["newuploadfilename"]);
			
					 if(strtolower($syllabus_filetype)=="pdf") 
					 {		?>
				</a><a href="<? echo "../download.php?m=syllabus&id=".$courses."&filename=".$row["newuploadfilename"]."&courses=".$courses."&req=".$person["id"];//echo 	"../files/syllabus/$courses/".$row["newuploadfilename"];?>" 
					target="<? if($row["new_window"]==0) 
												echo "_self";
										else 
												echo "_blank"; 	?>"> 
				<? 
					 }else if(strtolower($syllabus_filetype)=="doc")
										 {   
												  ?>				 
				<?  
										  }  echo $row["syllabus_upload"];  
				  ?>
				</a>
		  </td>
        </tr>
        <tr valign="top"> 
          <td align="right" valign="middle"><?php echo $strSyllabus_LabFileType;?>:</td>
          <td align="left" class="hilite" valign="middle">
		  <?
		   if(strtolower($syllabus_filetype)=="pdf") 
		   {
		   ?>
		   <img src="pdf.gif" width="18" height="18" border="0">
		   <?		   
			   echo "application/pdf";
		   } else {
		   ?>
		   <img src="msword.gif" width="20" height="20" border="0">
		   <?
			   echo "application/msword";
		   }		
		  ?>
		  </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $strSyllabus_LabFileSize;?>:</td>
          <td align="left" class="hilite"><? echo $syllabus_filesize; ?> bytes; ( <? echo GetSize($syllabus_filesize); ?>) </td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
  
<? }   ?>
<br>
<?
if (mysql_num_rows($def) > 0) {
?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0"   class="tdborder1">		  
		  <tr>
			
    <td>&nbsp;</td>
		  </tr>
		  <? $userdef = mysql_query("select su.* from syllabus_userdef su where courses = $courses order by id;" );
		
				while($userrow = mysql_fetch_array($userdef))
				{		?>
		  <tr> 
			<td height="30" colspan="2"><table width="559" border="0" align="center" cellpadding="3" cellspacing="5">
				<tr> 
				  <td width="543" valign="top"  background="../themes/<?php echo $theme;?>/images/bar.gif" class="news">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../themes/<?php echo $theme;?>/images/bulleti.gif" width="11" height="11"> 
					&nbsp;<b><? echo $userrow["topic_name"]; ?></b> </td>
				</tr>
			  </table></td>
		  </tr>
		  <? 
			if ($userrow["topic_name"] != $t[12]) {
		  ?>
		  <tr> 
			<td colspan="2"><table width="559" border="0" align="center" cellpadding="3" cellspacing="5">
				<tr> 
				  <td width="5%" class="info">&nbsp;</td>
				  <td width="91%"  class="hilite"><? echo nl2br($userrow["details"]); ?></td>
				  <td width="4%"  class="info">&nbsp;</td>
				</tr>
			  </table></td>
		  </tr>
		  <?
		  } else { ?>
		  <tr> 
			<td colspan="2"> 
			<table width="95%" border="0" align="center" class="tdborder1" cellpadding="2" cellspacing="1">
				<tr  class="boxcolor"> 
				  <th width="6%" align="center"  class="Bcolor"><?php echo $strSyllabus_LabNo;?></th>
				  <th width="14%" align="center"  class="Bcolor"><?php echo $strSyllabus_LabDate;?></th>
				  <th width="14%" align="center"  class="Bcolor"><?php echo $strSyllabus_LabTime;?></th>
				  <th width="51%" align="center"  class="Bcolor"><?php echo $strSyllabus_LabTopic?></th>
				  <th width="15%" align="center" class="Bcolor"><?php echo $strSyllabus_LabWay;?></th>
				</tr>
				<?
						$activity = mysql_query("SELECT * FROM syllabus_activity WHERE courses=$courses ORDER BY id;");
						$i = 0;
						while ($row_activity = mysql_fetch_array($activity))
						{ 				
						?>
				<tr bgcolor="#FFFFFF"> 
				  <td align="center" class="hilite"><b><? echo $i+1;?></b>&nbsp;</td>
				  <td class="hilite"><? echo date("Y-m-d",$row_activity["date"]);?>&nbsp;</td>
				  <td class="hilite"><? echo $row_activity["time"];?>&nbsp;</td>
				  <td class="hilite"><? echo $row_activity["topic"];?>&nbsp;</td>
				  <td  class="hilite"> 
					<? if ($row_activity["method"] == 0) { echo "--";}?>
					<? if ($row_activity["method"] == 1) { echo "บรรยาย";}?>
					<? if ($row_activity["method"] == 2) { echo "ปฏิบัติ";}?>
					<? if ($row_activity["method"] == 3) { echo "บรรยาย/ปฏิบัติ";}?>
					<? if ($row_activity["method"] == 4) { echo "สอบ";}?>
					&nbsp; </td>
				</tr>
				<? 
					$i++;
					}
					?>
			  </table></td>
		  </tr>
		  <?
		  }
		  ?>
		  <?    }  
		  
				//	$ddot	=":::::::";   //suthee
				//	echo  (trim($row["grading"])!=":::::::" || trim($row["grading"])!=$ddot || trim($row["grading"])!="" || trim($row["grading"])!=none );   //suthee
					//exit();
		 /*			
					if(trim($row["grading"])!=":::::::" && trim($row["grading"])!=$ddot && trim($row["grading"])!=""  && trim($row["grading"])!=none)
					{			?>
		  <tr> 
			<td colspan="2"> <table width="700" border="0" cellspacing="5" cellpadding="3">
				<tr>
				  <td  background="bg2.jpg" class="blue"> <img src="../images/bullet.gif" width="11" height="11">&nbsp;&nbsp;&nbsp; 
					<b><? echo "Grading Policy"; ?></b> </td>
				</tr>
			  </table></td>
		  </tr>
		  <tr> 
			<td colspan="2"> <table width="100%" height="89" border="0" cellpadding="15">
				<tr> 
				  <td height="22"><table width="80%" border="0" cellspacing="0" cellpadding="3" align="center">
					  <tr> 
						<td bgcolor="#339900" class="small" width="20" align="center"> 
						  <div align="center">A</div></td>
						<td bgcolor="#66CC00" class="small" width="20" align="center"> 
						  <div align="center">B+</div></td>
						<td bgcolor="#CCFF33" class="small" width="20" align="center"> 
						  <div align="center">B</div></td>
						<td bgcolor="#FFFF66" class="small" width="20" align="center"> 
						  <div align="center">C+</div></td>
						<td bgcolor="#FFCC66" class="small" width="20" align="center"> 
						  <div align="center">C</div></td>
						<td bgcolor="#FF9999" class="small" width="20" align="center"> 
						  <div align="center">D+</div></td>
						<td bgcolor="#FF6666" class="small" width="20" align="center"> 
						  <div align="center">D</div></td>
						<td bgcolor="#CC0033" class="small" width="20" align="center">F</td>
					  </tr>
					  <tr> 
						<td bgcolor="#339900"> <div align="center" class="small"><? echo $arr[0]; ?></div></td>
						<td bgcolor="#66CC00"> <div align="center" class="small"><? echo $arr[1]; ?></div></td>
						<td bgcolor="#CCFF33"> <div align="center" class="small"><? echo $arr[2]; ?></div></td>
						<td bgcolor="#FFFF66"> <div align="center" class="small"><? echo $arr[3]; ?></div></td>
						<td bgcolor="#FFCC66"> <div align="center" class="small"><? echo $arr[4]; ?></div></td>
						<td bgcolor="#FF9999"> <div align="center" class="small"><? echo $arr[5]; ?></div></td>
						<td bgcolor="#FF6666"> <div align="center" class="small"><? echo $arr[6]; ?></div></td>
						<td bgcolor="#CC0033"> <div align="center" class="small"><? echo $arr[7]; ?></div></td>
					  </tr>
					</table></td>
				</tr>
			  </table></td>
		  </tr>
		  <?  }  
		*/
		?>
		</table>
<?
	}
} else {
?>
<div align="center"><img src="../images/warning.gif" width="14" height="14"> <strong><font color="#FF0000">No 
  Syllabus for this course.</font></strong> <img src="../images/warning.gif" width="14" height="14"></div>
<?
}
?>
</body>
</html>