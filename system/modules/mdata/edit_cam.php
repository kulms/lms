<?php    
				  //session_start();
				  $result=mysql_query("SELECT * FROM ku_campus WHERE id=$id ;");	
?>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->

<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="6" align="right">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabCampus);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_cam'">
	</td>
  </tr>
</table>
<?php $row=mysql_fetch_array($result); ?>
<form name="edit_project" enctype="multipart/form-data" method="post" action="./index.php?m=mdata&a=update_cam">

<input type="hidden" name="id" value="<?php echo $id; ?>">
  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder1">
    <tr class="boxcolor"> 
      <th colspan="2" class="Bcolor"><?php echo $user->_($strEdit.$strSystem_LabCampus);?> </th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="190" class="hilite"> <input name="edit_cam" type="submit" value="<?php echo $user->_($strSave);?>" class="button"> 
      <input class="button" type="button" name="cancel" value="<?php echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=mdata&a=insert_fac';}" />      </td>
      <td width="421" align="right" class="hilite">&nbsp; </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabCamNameTh);?>: 
      </td>
      <td> <input name="cam_thai" type="text" size="55" maxlength="200" value="<?php echo $row["NAME_THAI"]; ?>" class="text"> 
        <?php echo "<br> Current value : ".$row["NAME_THAI"];?> </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabCamNameEng);?>:</td>
      <td> <input name="cam_eng" type="text" value="<?php echo $row["NAME_ENG"]; ?>" size="3" maxlength="3" class="text"> 
        <?php echo "<br> Current value : ".$row["NAME_ENG"];?> </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabCamUrl);?>: 
        <b>http://</b></td>
      <td> <input name="url" type="text" id="url" value="<? echo $row["URL"]; ?>" size="55" maxlength="200" class="text"> 
        <? echo "<br> Current value : ".$row["URL"];?></td>
    </tr>
  </table>
</form>