<?php      
	  $table_dept = "ku_department";
	  $field_dept_code = "DEPT_ID";
	  $field_thai = "NAME_THAI";
	  $field_eng = "NAME_ENG";
	  $field_url	= "URL";
	  $field_dept_fac_id = "FAC_ID";
	  $field_dep_id = "id";
	  $field_dep_edit_by= "edit_by";
	  $field_dep_post_datetime = "post_datetime";
	
	  $table_fac = "ku_faculty";
	  $field_fac_thai = "FAC_NAME";
	  $field_fac_eng = "NAME_ENG";	
	  $field_fac_id = "id";
	  $field_dep_edit_by= "edit_by";
	  $field_dep_post_datetime = "post_datetime"; 
	
		if($insert_dept)
		{	
			$dept_thai = trim($dept_thai);
			$dept_eng = trim($dept_eng);
			$url = trim($url);
			$id = $fac_id;
			if($dept_thai =="" || $dept_eng == "")
			{
				print("<script language='javascript'> alert('Please insert dept_thai and dept_eng!'); </script>");							
			}
			else
			{			
				// check existing dep
				$result=mysql_query("SELECT * from $table_dept  WHERE $field_thai = '$dept_thai' and $field_eng = '$dept_eng';");						
				if($row=mysql_fetch_array($result))
				{	
					// duplicate department
					print("<script language='javascript'> alert('There is same department occure. Please try again ! '); </script>");	
				} 
				else
				{	
					// no existing dept then insert into database
					mysql_query("INSERT INTO $table_dept(id,$field_thai,$field_eng,$field_dept_fac_id,$field_url,$field_dep_edit_by,$field_dep_post_datetime) 
								 VALUES ('', '$dept_thai', '$dept_eng', $fac_id,'$url','".$person["id"]."',now());");
					$new_id = mysql_insert_id();
					
					$sql_fac = mysql_query("SELECT * FROM resources_center WHERE faculty = '".$fac_id."' AND is_fac = 1 AND folder = 1;");
					$row_fac = mysql_fetch_array($sql_fac);
								 
					$sql = "INSERT INTO resources_center (name, refid, folder, is_dept, faculty, department, time, users) 
							VALUES ('$dept_thai', ".$row_fac["id"].", 1, 1, $fac_id, $new_id, ".time().", ".$user->getUserId().");";
					//echo $sql;
					mysql_query($sql);		
					
				}
			} 
		} 
		$see_dept=mysql_query("SELECT * FROM  $table_dept  WHERE  $field_dept_fac_id=$id ORDER BY $field_thai;");
?>
<script language='javascript'> 
function iconfirm(in_url){
	if( confirm("Do you really want to delete this Department and its major ?") )
		{   	
			document.location =in_url; 
		}
}
</script>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo //$uistyle;?>/faq.css" media="all" />!-->
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
    <td colspan="5" align="center"><font color="#666600"><b><font color="#FF0000">***</font></b></font> 
      <?php echo $user->_($strSystem_LabClickMajor);?><b> </b><font color="#666600"><b><font color="#FF0000">***</font></b></font></td>
  </tr>
  <tr> 
    <td height="35" colspan="5">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="60%">
		<?php	
			$resFac = mysql_query("select * from $table_fac where $field_fac_id = $id");
			if($row=mysql_fetch_array($resFac))			
			{   		
			?>     			
				<h1><? echo $row["$field_fac_thai"]." ( Faculty of ".$row["$field_fac_eng"]." )"; ?></h1>				
			<?php
			} 
			?>
		</td>
		<td width="40%" align="right">
		<input type="button" name="BFac" value="<?php echo $user->_($strSystem_LabFaculty);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_fac'">
		<input type="button" name="BDept" value="<?php echo $user->_($strSystem_BtnNewDept);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_dept&id=<?php echo $id;?>#dept'">		
		</td>
	  </tr>
	</table>
	
		
       </td>
  </tr>
  <tr align="center" class="boxcolor"> 
    <td width="3%" class="main_white" ><?php echo $user->_($strSystem_LabNo);?></td>
    <td width="25%"  class="main_white"><?php echo $user->_($strSystem_LabDeptNameTh);?></td>
    <td width="25%" class="main_white"><?php echo $user->_($strSystem_LabDeptNameEng);?></td>
	<td width="20%" class="main_white" ><?php echo $user->_($strSystem_LabDeptUrl);?></td>
    <td width="5%"   class="main_white"></td>
  </tr>
  <?php   
  		$num=1;
  			if($see_dept!=0 || $see_dept!=none)
			{
			   while($row=mysql_fetch_array($see_dept))
				 {     
				 	$name_thai	=$row["$field_thai"];
					$name_eng	=$row["$field_eng"];
					$dept_code	=$row["$field_dept_code"];
					$url		=$row["$field_url"];
					$d_id		=$row["$field_dep_id"];
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><? echo $num++;?></td>
    <td>
		<a href="./index.php?m=mdata&a=insert_major&id=<?php echo $d_id; ?>" title="View more detail!">
		<?php 
			if(($name_thai!="") && ($name_thai!=none))
			{ 
				echo "".$name_thai; 
			} else {  
				echo $name_thai; 
			} 
		?>
		</a>
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
		<a href="./index.php?m=mdata&a=edit_dept&id=<?php echo $d_id; ?>" target="_self">
			<img src="./images/icon/_edit-16.png" border="0" alt="<?php echo $user->_($strEdit);?>">
		</a> 
        <a href="javascript:iconfirm('./index.php?m=mdata&a=delete_dept&id=<?php echo $d_id; ?>&fac_id=<?php echo $id; ?>')">
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

<form name="insert_fac" method="post" action="./index.php?m=mdata&a=insert_dept">
<input type = "hidden" name ="fac_id" value = "<? echo $id ?>">
  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder2">
    <tr class="boxcolor"> 
      <th colspan="2"  class="Bcolor"><a name="dept"></a><?php echo $user->_($strSystem_BtnNewDept);?></th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" align="left" class="hilite"> 
	  	<input name="insert_dept" type="submit" id="insert_dept" value="<?php echo $user->_($strSave);?>" class="button"> 
      <input name="resetfac" type="reset" id="resetfac2" value="<?php echo $user->_($strReset);?>" class="button">	  </td>
    </tr>
    <tr> 
      <td width="190" align="right"><?php echo $user->_($strSystem_LabDeptNameTh);?>: 
      </td>
      <td width="404"><input name="dept_thai" type="text" id="dept_thai" size="55" maxlength="200" class="text"></td>
    </tr>
    <tr> 
      <td align="right"><?php echo $user->_($strSystem_LabDeptNameEng);?>:</td>
      <td><input name="dept_eng" type="text" id="dept_eng" size="55" maxlength="200" class="text"></td>
    </tr>
    <tr> 
      <td align="right"><?php echo $user->_($strSystem_LabDeptUrl);?>: <b>http://</b></td>
      <td> <input name="url" type="text" id="url" size="55" maxlength="100" class="text"> 
      </td>
    </tr>
  </table>
</form>
