<?php      
	
		if($insert_campus)
		{				
			$cam_thai = trim($cam_thai);
			$cam_eng = trim($cam_eng);
			$url = trim($url);
			if($cam_thai =="" || $cam_eng == "")
			{
				print("<script language='javascript'> alert('Please insert campus_thai and campus_eng!'); </script>");							
			}
			else
			{			
				// check existing dep
				$result=mysql_query("SELECT * from ku_campus  WHERE NAME_THAI = '$cam_thai' and NAME_ENG = '$cam_eng';");
				$result2=mysql_query("SELECT * from ku_campus  WHERE CAMPUS_ID = '$cam_id';");						
				if($row=mysql_fetch_array($result) || $row2=mysql_fetch_array($result2))
				{	
					// duplicate department
					print("<script language='javascript'> alert('There is same campus occure. Please try again ! '); </script>");	
				} 
				else
				{	
					// no existing dept then insert into database
					mysql_query("INSERT INTO ku_campus(CAMPUS_ID,NAME_ENG,NAME_THAI,URL,edit_by,post_datetime) 
								 VALUES ( '$cam_id','$cam_eng', '$cam_thai','$url','".$person["id"]."',now());");
					$new_id = mysql_insert_id();					
				}
			} 
		} 
		$see_dept=mysql_query("SELECT * FROM  ku_campus;");
?>
<script language='javascript'> 
function iconfirm(in_url){
	if( confirm("Do you really want to delete this Department and its major ?") )
		{   	
			document.location =in_url; 
		}
}
</script>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<a name="top"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="8%"><img src="./modules/mdata/images/my_sub_master.png" border="0"></td>
			<td width="92%"><h1><?php echo $user->_($strSystem_LabAcademic);?></h1></td>
		  </tr>
		</table>
	</td>
	<td align="right" width="25%" valign="bottom">
		
	</td>	
  </tr>  
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tdborder1">
  <tr> 
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr> 
    <td height="35" colspan="5">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="60%">		
		</td>
		  <td width="40%" align="right"><input type="button" name="Submit" value="<?php echo $user->_($strSystem_LabFaculty);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_fac'"> </td>
	  </tr>
	</table>
	
		
       </td>
  </tr>
  <tr align="center" class="Boxcolor"> 
    <td width="3%"  class="main_white"><?php echo $user->_($strSystem_LabNo);?></td>
    <td width="25%"  class="main_white"><?php echo $user->_($strSystem_LabCamNameTh);?></td>
    <td width="25%" class="main_white"><?php echo $user->_($strSystem_LabCamNameEng);?></td>
	<td width="20%"  class="main_white"><?php echo $user->_($strSystem_LabCamUrl);?></td>
    <td width="5%"  class="main_white"></td>
  </tr>
  <?php   
  		$num=1;
  			if($see_dept!=0 || $see_dept!=none)
			{
			   while($row=mysql_fetch_array($see_dept))
				 {     
				 	$name_thai	=$row["NAME_THAI"];
					$name_eng	=$row["NAME_ENG"];
					$url		=$row["URL"];
					$d_id		=$row["id"];
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><? echo $num++;?></td>
    <td>		
		<?php 
			if(($name_thai!="") && ($name_thai!=none))
			{ 
				echo "".$name_thai; 
			} else {  
				echo $name_thai; 
			} 
		?>		
	</td>
    <td>
		<?php 
			if(($name_eng!="") && ($name_eng!=none))
			{ 
				echo "".$name_eng; 
			} else {  
				echo $name_eng; 
			} 
		?>
	</td>
	<td>
		<?php  
			if(($url!="") && ($url!=none))
			{ 
				echo "<a href='http://".$url."'>http://".$url."</a>"; 
			} else {  
				echo ""; 
			} 
		?>
	</td>
    <td align="center">
		<a href="./index.php?m=mdata&a=edit_cam&id=<?php echo $d_id; ?>" target="_self">
			<img src="./images/icon/_edit-16.png" border="0" alt="<?php echo $user->_($strEdit);?>">
		</a> 
        <a href="javascript:iconfirm('./index.php?m=mdata&a=delete_cam&id=<?php echo $d_id; ?>')">
			<img src="./images/icon/_cancel-16.png" border="0" alt="<?php echo $user->_($strDelete);?>">
		</a>
	</td>
  </tr>
<?php 		
  		} 
   	}		
?>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><a href="#top">Go to top</a></td>
  </tr>
</table>

<form name="insert_fac" method="post" action="./index.php?m=mdata&a=insert_cam">
  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder2">
    <tr class="boxcolor"> 
      <th colspan="2"  class="Bcolor"><a name="dept"></a><?php echo $user->_($strSystem_BtnNewCam);?></th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" align="left" class="hilite"> 
	  	<input name="insert_campus" type="submit" id="insert_cam" value="<?php echo $user->_($strSave);?>" class="button"> 
        <input name="resetfac" type="reset" value="<?php echo $user->_($strReset);?>" class="button">
	  </td>
    </tr>
	<tr> 
      <td width="190" align="right" class="hilite"><?php echo $user->_($strSystem_LabCamId);?>: 
      </td>
      <td width="404"><input name="cam_id" type="text"  size="1" maxlength="1" class="text"></td>
    </tr>
    <tr> 
      <td width="190" align="right" class="hilite"><?php echo $user->_($strSystem_LabCamNameTh);?>: 
      </td>
      <td width="404"><input name="cam_thai" type="text" size="55" maxlength="200" class="text"></td>
    </tr>
    <tr> 
      <td align="right" class="hilite"><?php echo $user->_($strSystem_LabCamNameEng);?>:</td>
      <td><input name="cam_eng" type="text" size="3" maxlength="3" class="text"></td>
    </tr>
    <tr> 
      <td align="right" class="hilite"><?php echo $user->_($strSystem_LabCamUrl);?>: <b>http://</b></td>
      <td> <input name="url" type="text" id="url" size="55" maxlength="100" class="text"> 
      </td>
    </tr>
  </table>
</form>
