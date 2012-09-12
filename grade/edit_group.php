 <?
 
if(!$Update && $id) {
   
 
 $sql = "select g_score_type_g_id,g_score_type_g_name from g_score_type_group where g_score_type_g_id = $id order by g_score_type_g_name ";
    
	$result = mysql_query($sql);
  

?>
	<html>
	<head>
	<title>Show Group</title>
	<link rel="STYLESHEET" type="text/css" href="../themes/<? echo $theme;?>/style/main.css">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	

	</head>
	<body bgcolor="#ffffff"><br>
	
    <form name="form1" method="post" action="?a=edit_group">
    <table width="300" border="0" align="center" cellpadding="2" cellspacing="2" class="tdborder1">
  <tr  class="boxcolor">
    <td width="211" class="Bcolor" align="left" colspan="2"><strong><?=$strGrade_LabGroupName;?></strong></td>
	
   
  </tr>
<?
while ($row = mysql_fetch_array($result)) { ?>
 <tr  bgcolor="#FFFFFF">
    <td width="211" class="hilite" align="left" colspan="2"><input type="text" value="<? echo $row[1];?>" class="text" name="g_name"></td>
	
    
  </tr>
<?
}
?>
<tr><td colspan="2"><input type="submit" value="<?=$strUpdate?>" class="button" name="Update">	
<input type="button" value="<?=$strCancel?>" class="button" onClick="history.back()">
<input type="hidden" name="id" value = "<? echo $id?>">
</td></tr>
</table>

	</form>
	<div align="center" class="news"><a href="#" onClick="javascript:window.close();"><b>Close window</b></a></div>
	</body>
	</html>

<?
 } else {
  if ($g_name!="") {
 
 mysql_query("UPDATE g_score_type_group SET
		                       g_score_type_g_name = '".$g_name."',
		                       g_lastupdate = ".time()."
						       WHERE g_score_type_g_id=$id;");
 
echo "<script language='javascript'>opener.location.reload();location.href='?a=show_group'</script>";
 
     }else {
          echo "<script language='javascript'>alert('please enter group name');window.history.back();</script>";
		  
		  }
		  
		  
		  }



?>