<?php     
		//require("../include/global_login.php");

		  session_start();
		  $table_major = "ku_major";
		  $field_thai = "NAME_THAI";
		  $field_eng = "NAME_ENG";
		  $field_maj_dep_id = "DEPT_ID";
		  $field_url	= "URL";
		  $field_maj_id = "id";

		  $table_dept = "ku_department";
		  $field_dept_thai = "NAME_THAI";
		  $field_dept_eng = "NAME_ENG";
		  $field_dept_fac_id = "FAC_ID";
		  $field_dep_id = "id";

		  $table_fac = "ku_faculty";
		  $field_fac_thai = "FAC_NAME";
		  $field_fac_eng = "NAME_ENG";	
		  $field_fac_id = "id";		  
				  
				  $result=mysql_query("SELECT * FROM $table_major  WHERE $field_maj_id =$id ORDER BY $field_thai;");
				  $row=mysql_fetch_array($result); 				  
?>
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->

<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="6" align="right">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabFaculty);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_fac'">
        <input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabDept);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_dept&id=<?php echo $fac_id; ?>'">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabMajor);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_major&id=<?php echo $dept_id;?>'">	
  </tr>
</table>
<form name="edit_project" enctype="multipart/form-data" method="post" action="./index.php?m=mdata&a=update_major">

<input type="hidden" name="id" value="<? echo $id; ?>">
<input type="hidden" name="old_thai" value="<? echo trim($row["$field_thai"]); ?>">
<input type="hidden" name="old_eng" value="<? echo trim($row["$field_eng"]); ?>">
<input type="hidden" name="old_url" value="<? echo trim($row["$field_url"]); ?>">
<input type="hidden" name="dept_id" value="<? echo trim($row["$field_maj_dep_id"]); ?>">

  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder1">
    <tr class="boxcolor"> 
      <th colspan="2" class="Bcolor"> 
        <?php	  										  																  
		  	$resFac = mysql_query("SELECT tf.$field_fac_thai as fac_thai, tf.$field_fac_eng as fac_eng, 
															  td.$field_dept_thai as dept_thai, td.$field_dept_eng as dept_eng 
															  FROM $table_fac tf, $table_dept td 
															  WHERE tf.$field_fac_id = td.$field_dept_fac_id and td.$field_dep_id = ".$row["$field_maj_dep_id"].";");
			if($rowFac=mysql_fetch_array($resFac))			
			{	
			?>
				<?php echo $user->_($strSystem_LabFaculty);?> : <?php echo $rowFac["fac_thai"]." ( ".$rowFac["fac_eng"]." )";?> 
				<br>
				<?php echo $user->_($strSystem_LabDept);?> : <?php echo $rowFac["dept_thai"]." ( ".$rowFac["dept_eng"]." )";?> 
        	<?php 
		  	} 
			?>
      </th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td class="hilite">
	  	<input name="edit_fac" type="submit" id="edit_fac" value="<?php echo $user->_($strSave);?>" class="button">
      <input class="button" type="button" name="cancel" value="<?php echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=mdata&a=insert_major&id=<?php echo $dept_id;?>';}" />	  </td>
      <td align="right" class="hilite">&nbsp; </td>
    </tr>
    <tr> 
      <td width="190" align="right" valign="top"><?php echo $user->_($strSystem_LabMajorNameTh);?>:</td>
      <td width="421">
	  	<input name="major_thai" type="text" id="major_thai" size="55" maxlength="200" value="<? echo $row["$field_thai"]; ?>" class="text">	
        <? echo "<br> Current value : ".$row["$field_thai"];?> </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabMajorNameEng);?>:</td>
      <td><input name="major_eng" type="text" id="major_eng" value="<? echo $row["$field_eng"]; ?>" size="55" maxlength="200" class="text"> 
        <? echo "<br> Current value : ".$row["$field_eng"]; ?> </td>
    </tr>
    <tr> 
      <td align="right" valign="top"><?php echo $user->_($strSystem_LabMajorUrl);?>: 
        <b>http://</b></td>
      <td>
		<input name="url" type="text" id="url" value="<? echo $row["$field_url"]; ?>" size="55" maxlength="200" class="text"> 
        <? echo "<br> Current value : ".$row["$field_url"];?></td>
    </tr>
  </table>
</form>