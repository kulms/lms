<?php    require("../include/global_login.php");  //  require("include/connectdb.inc");
				  session_start();
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
?>

<html>
<head>
<title>.:: Edit Department ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body bgcolor="#EFEFDE">
<table width="600" border="0" align="center">
  <tr> 
    <td height="33" bgcolor="#000000"><div align="center"><b><font color="#FFFFFF">.:: 
        Faculty - Department - Major of Maxlearn ::.</font></b></div></td>
  </tr>
  <tr> 
    <td height="26"><div align="center">( รายละเอียดข้อมูลของคณะ ภาควิชา และสาขาวิชา ของ ม.เกษตร )</div></td>
  </tr>
</table>
<br>

<table width="80%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="6"><div align="right"><font color="#666600"><b>[ <a href="insert_fac.php" target="_self">Faculty</a> 
        ][ <a href="insert_dept.php" target="_self"> Department</a> ]</b></font></div></td>

  </tr>
</table>
<? $row=mysql_fetch_array($result); ?>
<form name="edit_project" enctype="multipart/form-data" method="post" action="update_dept.php">

<input type="hidden" name="id" value="<? echo $id; ?>">
<input type="hidden" name="old_thai" value="<? echo trim($row["$field_thai"]); ?>">
<input type="hidden" name="old_eng" value="<? echo trim($row["$field_eng"]); ?>">
<input type="hidden" name="old_url" value="<? echo trim($row["$field_url"]); ?>">
<input type="hidden" name="fac_id" value="<? echo trim($row["$field_dept_fac_id"]); ?>">

  <table width="600" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#804000" bgcolor="#DBDBB7">
    <tr> 
      <td height="32" colspan="2" bgcolor="#666600"><div align="center"><b><font color="#FFFFFF">:-: 
          Edit Department of Faculty 
          <?	$resFac = mysql_query("select * from $table_fac where $field_fac_id = $id");
			if($rowFac=mysql_fetch_array($resFac))			
				 echo $rowFac["$field_fac_thai"]." ( ".$rowFac["$field_fac_eng"]." )";				
			
			?>
          :-:</font></b></div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"><div align="right"><a href="insert_dept.php?id=<? echo $row["FAC_ID"]; ?>"  target="_self"><font color="#666600">Back</font></a> 
        </div></td>
    </tr>
    <tr> 
      <td width="190"><div align="right"><b><font color="#666600">ภาควิชา : </font></b></div></td>
      <td width="421"><input name="dept_thai" type="text" id="dept_thai" size="55" maxlength="200" value="<? echo $row["$field_thai"]?>">	
        <? echo "<br> Current value : ".$row["$field_thai"];?> </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><div align="right"><b><font color="#666600">Department of&nbsp;  </font></b> </div></td>
      <td bgcolor="#FFFFFF"><input name="dept_eng" type="text" id="dept_eng" value="<? echo $row["$field_eng"]; ?>" size="55" maxlength="200"> 
        <? echo "<br> Current value : ".$row["$field_eng"]; ?> </td>
    </tr>
    <tr> 
      <td><div align="right"><b><font color="#666600">URL: &nbsp; </font></b> 
        </div></td>
      <td><font color="#666600"><b>http://</b></font> 
        <input name="url" type="text" id="url" value="<? echo $row["$field_url"]; ?>" size="55" maxlength="200"> 
        <? echo "<br> Current value : ".$row["$field_url"]; ?></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><b></b></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td><font color="#666600">&nbsp;</font></td>
      <td><input name="edit_fac" type="submit" id="edit_fac" value="S a v e"> 
        &nbsp;&nbsp;&nbsp; <input name="reset_fac" type="reset" id="reset_fac" value="R e s e t"> 
      </td>
    </tr>
  </table>
</form>

<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>