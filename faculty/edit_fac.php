<?php     require("../include/global_login.php");
				  session_start();
				  $result=mysql_query("SELECT * FROM ku_faculty  WHERE id=$id ORDER BY FAC_NAME;");	
?>
<html>
<head>
<title>.:: Edit Faculty ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body bgcolor="#EFEFDE">
<table width="600" border="0" align="center">
  <tr> 
    <td height="33" bgcolor="#000000"><div align="center"> <b><font color="#FFFFFF">.:: 
        Faculty - Department - Major of Maxlearn ::.</font></b></div></td>
  </tr>
  <tr> 
    <td height="26"><div align="center">( รายละเอียดข้อมูล คณะ ภาควิชา และสาขาวิชา 
        มหาวิทยาลัยเกษตรศาสตร์ )</div></td>
  </tr>
</table>
<br>

<table width="600" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="6"><div align="right"><font color="#666600"><b>[ <a href="insert_fac.php">
        Faculty</a> ] </b></font></div></td>
  </tr>
</table>
<? $row=mysql_fetch_array($result); ?>
<form name="edit_project" enctype="multipart/form-data" method="post" action="update_fac.php">

<input type="hidden" name="id" value="<? echo $id; ?>">
<input type="hidden" name="old_thai" value="<? echo trim($row["FAC_NAME"]); ?>">
<input type="hidden" name="old_eng" value="<? echo trim($row["NAME_ENG"]); ?>">
<input type="hidden" name="old_url" value="<? echo trim($row["URL"]); ?>">
<input type="hidden" name="old_campus" value="<? echo trim($row["CAMPUS_ID"]); ?>">

  <table width="600" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#804000" bgcolor="#DBDBB7">
    <tr> 
      <td height="32" colspan="2" bgcolor="#666600"><div align="center"><b><font color="#FFFFFF">:-: 
          Edit Faculty :-:</font></b></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2"><div align="right"><a href="insert_fac.php" target="_self"><font color="#666600">Back</font></a> 
        </div></td>
    </tr>
    <tr> 
      <td width="190" height="26"><div align="right"><b><font color="#666600">วิทยาเขต&nbsp; 
          </font></b></div></td>
      <td width="421"> 
        <? $resCmp = mysql_query("select * from ku_campus order by id");
			  if($rowCmp = mysql_fetch_array($resCmp))
			  {				?>
        <select name="campus_id">
          <option value="<?echo $rowCmp["CAMPUS_ID"];?>" <? if($row["CAMPUS_ID"]==$rowCmp["CAMPUS_ID"]) 
					{ echo "selected"; 
					  $curval = $rowCmp["NAME_THAI"];
					}	
				?> ><? echo $rowCmp["NAME_THAI"]; ?></option>
          <?	while($rowCmp = mysql_fetch_array($resCmp))
				  {
				?>
          <option value="<?echo $rowCmp["CAMPUS_ID"];?>" 
				<? if($row["CAMPUS_ID"]==$rowCmp["CAMPUS_ID"]) 
						  { echo "selected";
							$curval = $rowCmp["NAME_THAI"];
						  }
					?> ><? echo $rowCmp["NAME_THAI"]; ?></option>
          <?
           		 }			?>
        </select> 
        <? } ?>
        <br>
        current value : <? echo $curval; ?> </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><b><font color="#666600">คณะ&nbsp; </font></b></div></td>
      <td><input name="fac_thai" type="text" id="fac_thai3" size="55" maxlength="200" value="<? echo $row["FAC_NAME"]; ?>"> 
        <? echo "<br> Current value : ".$row["FAC_NAME"];?></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><div align="right"><b><font color="#666600">Faculty 
          of&nbsp; </font></b> </div></td>
      <td bgcolor="#FFFFFF"><input name="fac_eng" type="text" id="fac_eng" value="<? echo $row["NAME_ENG"]; ?>" size="55" maxlength="200"> 
        <? echo "<br> Current value : ".$row["NAME_ENG"];?></td>
    </tr>
    <tr> 
      <td><div align="right"><b><font color="#666600">URL : &nbsp; </font></b> </div></td>
      <td><font color="#666600"><b>http://</b></font> <input name="url" type="text" id="url" value="<? echo $row["URL"]; ?>" size="55" maxlength="200"> 
        <? echo "<br> Current value : ".$row["URL"];?></td>
    </tr>
    <tr> 
      <td width="190" bgcolor="#FFFFFF"><div align="right"><b><font color="#666600"> 
          </font></b></div></td>
      <td width="421" bgcolor="#FFFFFF">&nbsp; </td>
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