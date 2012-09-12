<?php
	  	$table_major = "ku_major";
	  	$field_thai = "NAME_THAI";
	  	$field_eng = "NAME_ENG";
	  	$field_maj_dep_id = "DEPT_ID";
	  	$field_maj_fac_id = "FAC_ID";	
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

		if($insert_major)
		{	
			$major_thai = trim($major_thai);
			$major_eng = trim($major_eng);
			$id = $dept_id;
			if($major_thai =="" || $major_eng == "")
			{
				print("<script language='javascript'> alert('Please insert Major name in Thai and Eng!'); </script>");					
			}
			else
			{			
				// check existing dep
				$result=mysql_query("SELECT * FROM $table_major  
									 WHERE $field_thai = '$major_thai' AND $field_eng = '$major_eng' 
									 AND $field_maj_dep_id = $dept_id;");											 
				
				if($row=mysql_fetch_array($result))
				{	
					// duplicate department
					print("<script language='javascript'> alert('There is the same major in this department . Please try again ! '); </script>");	
				} 
				else
				{	
					// no existing dept then insert into database
					mysql_query("INSERT INTO $table_major($field_maj_id,$field_thai,$field_eng,$field_maj_fac_id,$field_maj_dep_id,$field_url,edit_by,post_datetime) 
								 VALUES ('', '$major_thai', '$major_eng', $fac_id, $dept_id, '$url', '".$person["id"]."', now());");
					$new_id = mysql_insert_id();
					
					$sql_dept = mysql_query("SELECT * FROM resources_center WHERE faculty = '".$fac_id."' AND department = '".$dept_id."' AND is_dept = 1 AND folder = 1;");
					$row_dept = mysql_fetch_array($sql_dept);
								 
					$sql = "INSERT INTO resources_center (name, refid, folder, is_major, faculty, department, major, time, users) 
							VALUES ('$major_thai', ".$row_dept["id"].", 1, 1, $fac_id, $dept_id, $new_id, ".time().", ".$user->getUserId().");";
					//echo $sql;
					mysql_query($sql);			 
				}
			} 
		} 
															 
		$see_major=mysql_query("SELECT * FROM  $table_major  WHERE  $field_maj_dep_id=$id ORDER BY $field_thai;");			
?>
<script language='javascript'> 
		function iconfirm(in_url){
			if( confirm("Do you really want to delete this Major?") )
			 	{   	document.location =in_url; 
				 }
		}
</script>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php // echo $uistyle;?>/faq.css" media="all" />!-->

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
	<td align="right" width="25%" valign="bottom">&nbsp; </td>	
  </tr>  
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tdborder1"> 
  <tr> 
    <td height="35" colspan="5">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php	
			$resFac = mysql_query("SELECT tf.$field_fac_id as fac_id, tf.$field_fac_thai as fac_thai, tf.$field_fac_eng as fac_eng, 
								   td.$field_dept_thai as dept_thai, td.$field_dept_eng as dept_eng 
								   FROM $table_fac tf, $table_dept td 
								   WHERE tf.$field_fac_id = td.$field_dept_fac_id and td.$field_dep_id = $id");
			if($row=mysql_fetch_array($resFac))			
			{	
				$fac_id =$row["fac_id"];
	?>
	  <tr>	  
		<td width="60%">		
		<h1><?php echo $row["fac_eng"]." ( ".$row["fac_thai"]." )";?></h1>
		</td>
		<td width="40%">		
		</td>		
	  </tr>
	  <tr>
		<td>
		<h1><?php echo $row["dept_eng"]." ( ".$row["dept_thai"]." )";?></h1> 
		</td>
		<td align="right">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabFaculty);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_fac'">
        <input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabDept);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_dept&id=<?php echo $fac_id; ?>'">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_BtnNewMajor);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_major&id=<?php echo $id; ?>#major'">
		</td>
	  </tr>
	  <?php
		    }    
		?>
	</table>			            		
	</td>
  </tr>
  <tr align="center" class="boxcolor"> 
    <td width="3%" class="main_white"><?php echo $user->_($strSystem_LabNo);?></td>
    <td width="30%" class="main_white"><?php echo $user->_($strSystem_LabMajorNameTh);?></td>
    <td width="30%" class="main_white"><?php echo $user->_($strSystem_LabMajorNameEng);?></td>
	<td width="15%" class="main_white"><?php echo $user->_($strSystem_LabMajorUrl);?></td>
    <td width="5%" class="main_white"></td>
  </tr>
  <?php   $num=1;
  			if($see_major!=0 || $see_major!=none)
			{
			   while($row=mysql_fetch_array($see_major))
				 {     
				 	$name_thai=$row["$field_thai"];
					$name_eng=$row["$field_eng"];
					$d_id=$row["$field_maj_id"];
					$url=$row["$field_url"];
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
		<?php echo $num++;?>
	</td>
    <td >
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
		<a href="./index.php?m=mdata&a=edit_major&id=<?php echo $d_id;?>&dept_id=<?php echo $id;?>&fac_id=<?php echo $fac_id;?>" target="_self">
			<img src="./images/icon/_edit-16.png" border="0" alt="<?php echo $user->_($strEdit);?>">
		</a>
        <a href="javascript:iconfirm('./index.php?m=mdata&a=delete_major&id=<?php echo $d_id; ?>&dept_id=<?php echo $id; ?>');">
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

<a name="major"></a>
<form name="insert_major_name" method="post" action="./index.php?m=mdata&a=insert_major">
<input type = "hidden" name ="dept_id" value = "<? echo $id ?>">
<input type = "hidden" name ="fac_id" value = "<? echo $fac_id ?>">
  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder1">
    <tr class="boxcolor"> 
      <th colspan="2"  class="Bcolor"><a name="dept" id="dept"></a><?php echo $user->_($strSystem_BtnNewMajor);?></th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" align="left" class="hilite"> <input name="insert_major" type="submit" id="major" value="<?php echo $user->_($strSave);?>" class="button"> 
      <input name="resetfac" type="reset" id="resetfac2" value="<?php echo $user->_($strReset);?>" class="button">      </td>
    </tr>
    <tr> 
      <td width="190" align="right"><?php echo $user->_($strSystem_LabMajorNameTh);?>:</td>
      <td width="404"><input name="major_thai" type="text" id="major_thai" size="55" maxlength="200" class="text"></td>
    </tr>
    <tr> 
      <td align="right"><?php echo $user->_($strSystem_LabMajorNameEng);?>:</td>
      <td><input name="major_eng" type="text" id="major_eng" size="55" maxlength="200" class="text"></td>
    </tr>
    <tr> 
      <td align="right"><?php echo $user->_($strSystem_LabMajorUrl);?>: <b>http://</b></td>
      <td> <input name="url" type="text" id="url" size="55" maxlength="100" class="text"></td>
    </tr>
  </table>
</form><br>
</body>
</html>