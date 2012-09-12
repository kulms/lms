<?php    
				  //session_start();
				  $table_dept = "ku_department";
				  $field_thai = "NAME_THAI";
				  $field_eng = "NAME_ENG";
				  $field_dept_fac_id = "FAC_ID";
				  $field_url	= "URL";
				  $field_dep_id = "id";

				  $table_fac = "ku_faculty";
				  $field_fac_thai = "FAC_NAME";
				  $field_fac_eng = "NAME_ENG";	
				  $field_fac_id = "id";
				  
				  $result=mysql_query("SELECT * FROM $table_dept  WHERE $field_dep_id =$id ORDER BY $field_thai;");		
				  $row=mysql_fetch_array($result); 				  
?>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->

<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="6" align="right">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabFaculty);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_fac'">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabDept);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_dept&id=<?php echo $row["FAC_ID"]; ?>'">
	</td>
  </tr>
</table>

<form name="edit_project" enctype="multipart/form-data" method="post" action="./index.php?m=mdata&a=update_dept">

<input type="hidden" name="id" value="<? echo $id; ?>">
<input type="hidden" name="old_thai" value="<? echo trim($row["$field_thai"]); ?>">
<input type="hidden" name="old_eng" value="<? echo trim($row["$field_eng"]); ?>">
<input type="hidden" name="old_url" value="<? echo trim($row["$field_url"]); ?>">
<input type="hidden" name="fac_id" value="<? echo trim($row["$field_dept_fac_id"]); ?>">

  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder2">
    <tr class="boxcolor"> 
      <th  colspan="2"  class="Bcolor"><?php echo $user->_($strEdit.$strSystem_LabDept);?> - <?php echo $user->_($strSystem_LabFaculty);?>
        <?php	
		  	$resFac = mysql_query("select * from $table_fac where $field_fac_id = ".$row["FAC_ID"].";");
			if($rowFac=mysql_fetch_array($resFac))	 echo $rowFac["$field_fac_thai"]." ( ".$rowFac["$field_fac_eng"]." )";				
			?>
      </th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td  align="left" class="hilite"> 
	  	<input name="edit_fac" type="submit" id="edit_fac" value="<?php echo $user->_($strSave);?>" class="button">
      <input class="button" type="button" name="cancel" value="<?php echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=mdata&a=insert_dept&id=<?php echo $row["FAC_ID"]; ?>';}" />	  </td>
      <td align="right" class="hilite">&nbsp; </td>
    </tr>
    <tr> 
      <td width="190" align="right" valign="top"><?php echo $user->_($strSystem_LabDeptNameTh);?>:</td>
      <td width="421"><input name="dept_thai" type="text" id="dept_thai" size="55" maxlength="200" value="<? echo $row["$field_thai"]?>" class="text">	
        <? echo "<br> Current value : ".$row["$field_thai"];?> </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabDeptNameEng);?>:</td>
      <td><input name="dept_eng" type="text" id="dept_eng" value="<? echo $row["$field_eng"]; ?>" size="55" maxlength="200" class="text"> 
        <? echo "<br> Current value : ".$row["$field_eng"]; ?> </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabDeptUrl);?>: 
        <b>http://</b></td>
      <td>
		<input name="url" type="text" id="url" value="<? echo $row["$field_url"]; ?>" size="55" maxlength="200" class="text"> 
        <? echo "<br> Current value : ".$row["$field_url"]; ?></td>
    </tr>
  </table>
</form>
