<?php      require("../include/global_login.php");
				    session_start();
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
				{	$dept_thai = trim($dept_thai);
					$dept_eng = trim($dept_eng);
					$url = trim($url);
					$id = $fac_id;
							if($dept_thai =="" || $dept_eng == "")
								{
									print("<script language='javascript'> alert('Please insert dept_thai and dept_eng!'); </script>");
									
								}else
								{			// check existing dep
											 $result=mysql_query("SELECT * from $table_dept  WHERE $field_thai = '$dept_thai' and $field_eng = '$dept_eng';");						
											if($row=mysql_fetch_array($result))
												{	// duplicate department
													print("<script language='javascript'> alert('There is same department occure. Please try again ! '); </script>");	
												 } 
											else
												{	// no existing dept then insert into database
												mysql_query("INSERT INTO $table_dept(id,$field_thai,$field_eng,$field_dept_fac_id,$field_url,$field_dep_edit_by,$field_dep_post_datetime) VALUES ('', '$dept_thai', '$dept_eng', $fac_id,'$url','".$person["id"]."',now());");
												}
								} 
				} 
			$see_dept=mysql_query("SELECT * FROM  $table_dept  WHERE  $field_dept_fac_id=$id ORDER BY $field_thai;");
?>
<html>
<head>
<title>.:: Department ::.</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language='javascript'> 
		function iconfirm(in_url){
			if( confirm("Do you really want to delete this Department and its major ?") )
			 	{   	document.location =in_url; 
				 }
		}
</script>
</head>

<body bgcolor="#EFEFDE"">
<table width="600" border="0" align="center">
  <tr> 
    <td height="33" bgcolor="#000000" class="headfac"><div align="center">
	<b><font color="#FFFFFF">.:: Faculty - Department - Major of Maxlearn ::.</font></b></div></td>
  </tr>
  <tr> 
    <td height="26"><div align="center">( รายละเอียดข้อมูล คณะ ภาควิชา และสาขาวิชา มหาวิทยาลัยเกษตรศาสตร์ )</div></td>
  </tr>
</table>

<font color="#EFEFDE">top</font><a name="top"></a> <br>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="5"><div align="center"><font color="#666600"><b><font color="#FF0000">***</font>Click 
        item <font color="#B3B300">Department name(Thai)</font> to see its Major 
        !<font color="#FF0000">***</font></b></font></div></td>
  </tr>
  <tr> 
    <td height="35" colspan="5">
	<?	$resFac = mysql_query("select * from $table_fac where $field_fac_id = $id");
			if($row=mysql_fetch_array($resFac))			
			{   		?>
      <div align="left"><b> <font color="#666600">Faculty of <? echo $row["$field_fac_thai"]." ( ".$row["$field_fac_eng"]." )"; ?> 
        </font> </b></div>
			<? } ?>
		<div align="right"><font color="#666600"><b> [ 
        <a href="insert_fac.php" target="_self">Faculty</a> ][ <a href="#dept">Add 
        Department</a> ]</b></font></div></td>
  </tr>
  <tr> 
    <td width="5%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>No.</b></font></div></td>
    <td width="25%" bgcolor="#666600"> <font color="#FFFFFF"><b>Department(Thai)</b></font></td>
	<!--<td width="6%" bgcolor="#666600"><div align="center"> <font color="#FFFFFF"><b>DEPT CODE</b></font></div></td> -->
    <td width="25%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>Department (English)</b></font></div></td>
	<td width="20%" bgcolor="#666600"><div align="center"> <font color="#FFFFFF"><b>Department URL</b></font></div></td>
    <td width="15%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>command</b></font></div></td>
  </tr>
  <?   $num=1;
  			if($see_dept!=0 || $see_dept!=none)
			{
			   while( $row=mysql_fetch_array($see_dept))
				 {     $name_thai=$row["$field_thai"];
						$name_eng=$row["$field_eng"];
						$dept_code=$row["$field_dept_code"];
						$url=$row["$field_url"];
						$d_id=$row["$field_dep_id"];
  ?>
  <tr> 
    <td bgcolor="#DBDBB7"><div align="center"><font color="#666600"><? echo $num++;?></font></div></td>
    <td bgcolor="#DBDBB7" ><font color="#666600"><a href="insert_major.php?id=<? echo $d_id; ?>" title="View more detail!"><? if($name_thai!=""  && $name_thai!=none ){ echo "ภาควิชา".$name_thai; }else {  echo $name_thai; } ?></a></font></td>
   <!-- <td bgcolor="#DBDBB7" align="center"><font color="#666600"><? echo $dept_code; ?></font></td> -->
    <td bgcolor="#DBDBB7"><font color="#666600"><? if($name_eng!=""  && $name_eng!=none ){ echo "Department of ".$name_eng; }else {  echo $name_eng; } ?></font></td>
	  <td bgcolor="#DBDBB7"><?  if($url!=""  &&  $url!=none ){ echo "<a href='http://".$url."'>http://".$url."</a>"; }else {  echo ""; } ?></td>
    <td bgcolor="#DBDBB7"> <div align="center"><font color="#666600">[ <a href="edit_dept.php?id=<? echo $d_id; ?>" target="_self">edit</a> 
        ] [ <a href="javascript:iconfirm('delete_dept.php?id=<? echo $d_id; ?>&fac_id=<? echo $id; ?>')">delete</a>]</font></div></td>
  </tr>
  <? 		} 
   		  }		?>
</table>
<div align="right"><br><font color="#666600"><a href="#top">Go to top</a></font></div>

<form name="insert_fac" method="post" action="insert_dept.php">
<input type = "hidden" name ="fac_id" value = "<? echo $id ?>">
  <table width="600" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#804000" bgcolor="#DBDBB7">
    <tr> 
      <td height="32" colspan="2" bgcolor="#666600"><div align="center"><b><a name="dept" id="dept"></a><font color="#FFFFFF">:-: 
          Add Department :-:</font></b></div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"><div align="right">&nbsp;</div></td>
    </tr>
    <tr> 
      <td width="190"><div align="right"><b><font color="#666600">ภาควิชา&nbsp; 
          </font></b></div></td>
      <td width="404"><input name="dept_thai" type="text" id="dept_thai" size="55" maxlength="200"></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><div align="right"><b><font color="#666600">Department 
          of&nbsp;&nbsp; </font></b></div></td>
      <td bgcolor="#FFFFFF"><input name="dept_eng" type="text" id="dept_eng" size="55" maxlength="200"></td>
    </tr>
    <tr> 
      <td><div align="right"><b><font color="#666600">URL : &nbsp; </font> </b></div></td>
      <td><b><font color="#666600"> 
        http://<input name="url" type="text" id="url" size="55" maxlength="100">
        </font></b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td><font color="#666600">&nbsp;</font></td>
      <td><input name="insert_dept" type="submit" id="insert_dept" value="S a v e"> 
        &nbsp;&nbsp;&nbsp; <input name="resetfac" type="reset" id="resetfac" value="R e s e t"> 
      </td>
    </tr>
  </table>
</form><br>
</body>
</html>