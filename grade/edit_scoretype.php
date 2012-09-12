<?
@setcookie('ModuleID');
//echo $ModuleID;
//echo "old".$m_id;
 if (isset($update) && strlen($g_score_name)!=0) {	 

	 if($mid != ""){
		if($ModuleName !="")
			$g_modules_id=$m_id;
		else
			$g_modules_id=$mid;
	 }else{
		if($ModuleName !="")
			$g_modules_id=$m_id;
		else
			$g_modules_id=0;
	 }
	mysql_query("UPDATE g_score_type SET
		                        g_score_type_g_id = ".$g_name.",
								 g_score_type_name = '".$g_score_name."',
								g_max_score = ".$g_score.",
								g_modules_id = ".$g_modules_id.",
							   g_lastupdate = ".time()."
						       WHERE g_score_type_id=$id ;");


  if($g_name!=0) {
 
     mysql_query("UPDATE g_score_type SET
		                      g_max_score = ".$g_score.",
							   g_lastupdate = ".time()."
						       WHERE g_score_type_g_id=$g_name and g_grade_id = $gid;");

 }
 echo "<script language='javascript'>document.location='?id=$gid&courses=$courses';</script>";
} //End submit
else {
?>


<html>
<title>
</title>
<head>

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<SCRIPT LANGUAGE='javascript' src='validate.js'></SCRIPT>
</head>
<body>
<br>
<form name="edit_gname" method="post" action="?a=edit_scoretype&courses=<? echo $courses?>" onsubmit=" return validateForm(this);">
<input type="hidden" name="id" value = "<? echo $id?>">
<input type="hidden" name="gid" value = "<? echo $gid?>">
<table width="603" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder2">
    <tr class="boxcolor"> 
      <th colspan="2"  class="Bcolor"><?=$strEdit;?></th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td  align="left" class="hilite"> 
	  	<input name="update" type="submit" value="<?=$strUpdate;?>" class="button"> 
      <input  type="button"  value="<?=$strCancel;?>" class="button" onclick = "location.href='?id=<? echo $gid;?>&courses=<? echo $courses?>'">	  
	  
	  </td>
   <td align="right">&nbsp;</td>
	</tr>
    
	 
	 <tr> 
      <td align="right"><?=$strGrade_LabGroup;?> :</td>
      <td>
	     <?
	$sql = "SELECT t.g_score_type_name,t.g_max_score,t.g_score_type_g_id ,t.g_modules_id,t.g_grade_id
	FROM g_score_type t
	 WHERE  t.g_score_type_id = $id";
	$result = mysql_query($sql);
  	$g_id = @mysql_result($result,0,"g_score_type_g_id");
	
	$sql_group= "select g_score_type_g_id,g_score_type_g_name from g_score_type_group 
								where g_users = ".$person["id"]." order by g_score_type_g_name ";
    
	$result_group = mysql_query($sql_group);
  
					echo "<select name=\"g_name\" >";
		            echo "<option value=\"0\">Select group</option>";
                  while ($row = mysql_fetch_array($result_group)) {
                     $selection = '';
		             if ($row[0]==$g_id) {
				     
				$selection = 'selected';
			}
					 echo "<option value=\"$row[0]\" $selection>$row[1]</option>";
	
		     
                              }
		echo "</select>";
                  
			
			
			?>	  
	  </td>
    </tr>
    <tr> 
      <td align="right"><?=$strGrade_LabScoreName;?> :</td>
      <td><input name="g_score_name" type="text" size="35" maxlength="200" class="text" value="<? echo @mysql_result($result,0,"g_score_type_name")?>"></td>
    </tr>
    <tr> 
      <td align="right"><?=$strGrade_LabMaxScore;?>  : </td>
      <td> <input name="g_score" type="text"  size="5" maxlength="3" class="text" value="<? echo @mysql_result($result,0,"g_max_score")?>"> 
      </td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><a href="#" onClick="newWindow('?a=sel_module&courses=<? echo $courses?>&form=edit_gname&mid=<? echo @mysql_result($result,0,"g_modules_id") ?>&id=<? echo $id ?>',600,580,'no','no','yes')">
        <input name="ModuleName" type="text"  value="" class="text" onFocus="blur();">
        <input type="hidden" name="m_id">
        <?=$strGrade_SelectModule;?></a>
        
</td>
    </tr>
	<? if(mysql_result($result,0,"g_modules_id") !=0){ 
		$module_id=mysql_result($result,0,"g_modules_id");
		$sql1="SELECT * FROM modules WHERE  id =".$module_id." ";
		$result1=mysql_query($sql1);
		$qname=mysql_result($result1,0,'name');
	?>
    <tr>
      <td align="right">&nbsp;</td>
      <td valign="top"><b>Old :</b> <? echo $qname;?>&nbsp;&nbsp;<a href="#" onclick = "iconfirm('?a=del_scoretype&id=<? echo $id ?>&del=modules&gid=<? echo mysql_result($result,0,'g_grade_id')  ?>','Do you want delete module?')"><img src="../images/stop_sign.gif" alt="delete" width="14" height="14" border="0"></a><input type="hidden" name="mid" value="<? echo @mysql_result($result,0,"g_modules_id") ?>"></td>
    </tr>
	<? }?>
  </table>

</form>
</body>
</html>


<?
}	

?>