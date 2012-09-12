<?     require("../include/global_login.php");
    	  session_start();
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
				{	$major_thai = trim($major_thai);
					$major_eng = trim($major_eng);
					$id = $dept_id;
							if($major_thai =="" || $major_eng == "")
								{
									print("<script language='javascript'> alert('Please insert Major name in Thai and Eng!'); </script>");
									
								}else
								{			// check existing dep
											 $result=mysql_query("SELECT * from $table_major  WHERE $field_thai = '$major_thai' and $field_eng = '$major_eng' and $field_maj_dep_id = $dept_id;");						
											 
											
											if($row=mysql_fetch_array($result))
												{	// duplicate department
													print("<script language='javascript'> alert('There is the same major in this department . Please try again ! '); </script>");	
												 } 
											else
												{	// no existing dept then insert into database
												mysql_query("INSERT INTO $table_major($field_maj_id,$field_thai,$field_eng,$field_maj_fac_id,$field_maj_dep_id,$field_url,edit_by,post_datetime) VALUES ('', '$major_thai', '$major_eng',$fac_id,$dept_id,'$url','".$person["id"]."',now());");
												}
								} 
				} 
															 
			$see_major=mysql_query("SELECT * FROM  $table_major  WHERE  $field_maj_dep_id=$id ORDER BY $field_thai;");			
?>
<html>
<head><title>.:: Major ::.</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language='javascript'> 
		function iconfirm(in_url){
			if( confirm("Do you really want to delete this Major?") )
			 	{   	document.location =in_url; 
				 }
		}
</script>
</head>

<body bgcolor="#EFEFDE"">
<table width="600" border="0" align="center">
  <tr> 
    <td height="22" bgcolor="#000000"  class="headfac"><div align="center"> <b> <font color="#FFFFFF">.:: 
        Faculty - Department - Major of Maxlearn ::.</font></b></div></td>
  </tr>
  <tr> 
    <td height="26"><div align="center">( รายละเอียดข้อมูล คณะ ภาควิชา และสาขาวิชา 
        มหาวิทยาลัยเกษตรศาสตร์ )</div></td>
  </tr>
</table>
<a name="top"></a><br>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td height="35" colspan="5">
	<?	$resFac = mysql_query("select tf.$field_fac_id as fac_id, tf.$field_fac_thai as fac_thai, tf.$field_fac_eng as fac_eng, td.$field_dept_thai as dept_thai, td.$field_dept_eng as dept_eng from $table_fac tf, $table_dept td where tf.$field_fac_id = td.$field_dept_fac_id and td.$field_dep_id = $id");

			if($row=mysql_fetch_array($resFac))			
			{	$fac_id =$row["fac_id"];
	?>	
		
      <div align="left"><b> <font color="#666600">Faculty of <? echo $row["fac_eng"]." ( ".$row["fac_thai"]." )";?><br>
        Department of <? echo $row["dept_eng"]." ( ".$row["dept_thai"]." )";?> 
        </font></b></div>
      <?
		    }    ?>
		<div align="right"><font color="#666600"><b> [ 
        <a href="insert_fac.php" target="_self">Faculty</a> ][ 
        <a href="insert_dept.php?id=<? echo $fac_id; ?>" target="_self">Department</a> ][ <a href="#major">Add 
        Major</a> ]</b></font></div></td>
  </tr>
  <tr> 
    <td width="5%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>No.</b></font></div></td>
    <td width="30%" bgcolor="#666600"><div align="center"> <font color="#FFFFFF"><b>Major 
        name(Thai)</b></font></div></td>
    <td width="30%" bgcolor="#666600"><div align="center"> <font color="#FFFFFF"><b>Major 
        name(English)</b></font></div></td>
	<td width="15%" bgcolor="#666600"><div align="center"> <font color="#FFFFFF"><b>Major URL</b></font></div></td>
    <td width="15%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>command</b></font></div></td>
  </tr>
  <?   $num=1;
  			if($see_major!=0 || $see_major!=none)
			{
			   while( $row=mysql_fetch_array($see_major))
				 {     $name_thai=$row["$field_thai"];
						$name_eng=$row["$field_eng"];
						$d_id=$row["$field_maj_id"];
						$url=$row["$field_url"];
  ?>
  <tr> 
    <td bgcolor="#DBDBB7"><div align="center"><font color="#666600"><? echo $num++;?></font></div></td>
    <td bgcolor="#DBDBB7"><font color="#666600"><? if($name_thai!=""  && $name_thai!=none ){ echo "สาขาวิชา".$name_thai; }else {  echo $name_thai; } ?></font></td>
    <td bgcolor="#DBDBB7"><font color="#666600"><? if($name_eng!=""  && $name_eng!=none ){ echo "Major of ".$name_eng; }else {  echo $name_eng; } ?></font></td>
 <td bgcolor="#DBDBB7"><?  if($url!=""  &&  $url!=none ){ echo "<a href='http://".$url."'>http://".$url."</a>"; }else {  echo ""; } ?></td>
    <td bgcolor="#DBDBB7"> <div align="center"><font color="#666600">[ <a href="edit_major.php?id=<? echo $d_id;?>&dept_id=<? echo $id;?>&fac_id=<? echo $fac_id;?>" target="_self">edit</a>
        ] [ <a href="javascript:iconfirm('delete_major.php?id=<? echo $d_id; ?>&dept_id=<? echo $id; ?>');">delete</a>]</font></div></td>
  </tr>
  <? 		} 
   		  }		?>
</table>
<div align="right"><br><font color="#666600"><a href="#top">Go to top</a></font></div>
<a name="major"></a>
<form name="insert_major_name" method="post" action="insert_major.php">
<input type = "hidden" name ="dept_id" value = "<? echo $id ?>">
<input type = "hidden" name ="fac_id" value = "<? echo $fac_id ?>">
  <table width="600" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#804000" bgcolor="#DBDBB7">
    <tr> 
      <td height="32" colspan="2" bgcolor="#666600"><div align="center"><b><a name="dept" id="dept"></a><font color="#FFFFFF">:-: 
          Add Major :-:</font></b></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2"><div align="right"></div></td>
    </tr>
    <tr> 
      <td width="190"><div align="right"><b><font color="#666600">สาขาวิชา&nbsp; 
          </font></b></div></td>
      <td width="404"><input name="major_thai" type="text" id="major_thai" size="55" maxlength="200"></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><div align="right"><b><font color="#666600">Major 
          of&nbsp;&nbsp; </font></b></div></td>
      <td bgcolor="#FFFFFF"><input name="major_eng" type="text" id="major_eng" size="55" maxlength="200"></td>
    </tr>
    <tr> 
      <td><div align="right"><b><font color="#666600">URL : &nbsp; </font></b> 
        </div></td>
      <td><font color="#666600"><b>http://</b></font> <input name="url" type="text" id="url" size="55" maxlength="100"></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><b></b></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td><font color="#666600">&nbsp;</font></td>
      <td><input name="insert_major" type="submit" id="major" value="S a v e"> 
        &nbsp;&nbsp;&nbsp; <input name="resetfac" type="reset" id="resetfac" value="R e s e t"> 
      </td>
    </tr>
  </table>
</form><br>
</body>
</html>