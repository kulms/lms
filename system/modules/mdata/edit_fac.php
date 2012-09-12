<?php    
				  //session_start();
				  $result=mysql_query("SELECT * FROM ku_faculty  WHERE id=$id ORDER BY FAC_NAME;");	
?>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->

<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="6" align="right">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabFaculty);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_fac'">
	</td>
  </tr>
</table>
<?php $row=mysql_fetch_array($result); ?>
<form name="edit_project" enctype="multipart/form-data" method="post" action="./index.php?m=mdata&a=update_fac">

<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="old_thai" value="<?php echo trim($row["FAC_NAME"]); ?>">
<input type="hidden" name="old_eng" value="<?php echo trim($row["NAME_ENG"]); ?>">
<input type="hidden" name="old_url" value="<?php echo trim($row["URL"]); ?>">
<input type="hidden" name="old_campus" value="<?php echo trim($row["CAMPUS_ID"]); ?>">

  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder1">
    <tr class="boxcolor"> 
      <th colspan="2" class="Bcolor"><?php echo $user->_($strEdit.$strSystem_LabFaculty);?></th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td class="hilite"> <input name="edit_fac" type="submit" id="edit_fac" value="<?php echo $user->_($strSave);?>" class="button">
      <input class="button" type="button" name="cancel" value="<?php echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=mdata&a=insert_fac';}" />      </td>
      <td align="right" class="hilite">&nbsp; </td>
    </tr>
    <tr> 
      <td width="190" align="right" valign="top"><?php echo $user->_($strSystem_LabCampus);?>:</td>
      <td width="421"> 
        <?php 
			  $resCmp = mysql_query("select * from ku_campus order by id");
			  if($rowCmp = mysql_fetch_array($resCmp))
			  {				
		?>
          <select name="campus_id" style="font-size:10px">
          <option value="<?php echo $rowCmp["CAMPUS_ID"];?>" 
		  <?php 
		  			if($row["CAMPUS_ID"]==$rowCmp["CAMPUS_ID"]) 
					{ 
						echo "selected"; 
					  	$curval = $rowCmp["NAME_THAI"];
					}	
				?> ><?php echo $rowCmp["NAME_THAI"]; ?>
			</option>
          <?php	
		  		while($rowCmp = mysql_fetch_array($resCmp))
				  {
			?>
          <option value="<?php echo $rowCmp["CAMPUS_ID"];?>" 
				<?php 
						if($row["CAMPUS_ID"]==$rowCmp["CAMPUS_ID"]) 
						  { 
						  	echo "selected";
							$curval = $rowCmp["NAME_THAI"];
						  }
					?> ><?php echo $rowCmp["NAME_THAI"]; ?>
			</option>
          <?php
           		 }			
			?>
        </select> 
        <?php 
		} 
		?>
        <br>
        current value : <?php echo $curval; ?> </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabFacNameTh);?>:
      </td>
      <td>
	  	<input name="fac_thai" type="text" id="fac_thai3" size="55" maxlength="200" value="<?php echo $row["FAC_NAME"]; ?>" class="text"> 
        <?php echo "<br> Current value : ".$row["FAC_NAME"];?>
	  </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabFacNameEng);?>:</td>
      <td>
	  	<input name="fac_eng" type="text" id="fac_eng" value="<?php echo $row["NAME_ENG"]; ?>" size="55" maxlength="200" class="text"> 
        <?php echo "<br> Current value : ".$row["NAME_ENG"];?>
	  </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabFacUrl);?>: <b>http://</b></td>
      <td>
		<input name="url" type="text" id="url" value="<? echo $row["URL"]; ?>" size="55" maxlength="200" class="text"> 
        <? echo "<br> Current value : ".$row["URL"];?></td>
    </tr>
  </table>
</form>