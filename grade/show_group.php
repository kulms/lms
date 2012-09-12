 <?
 if($action=="del" && $id) {
 
  mysql_query("delete from g_score_type_group where g_score_type_g_id = $id");
  mysql_query("delete from g_score_type where g_score_type_g_id = $id");
 
  echo "<script language='javascript'>opener.location.reload();</script>";
  }
 
 $sql = "select g_score_type_g_id,g_score_type_g_name from g_score_type_group where 
				g_users = ".$person["id"]." order by g_score_type_g_name ";

     
	$result = mysql_query($sql);
  
?>
	<html>
	<head>
	<title>Show Group</title>
	<link rel="STYLESHEET" type="text/css" href="../themes/<? echo $theme;?>/style/main.css">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	<SCRIPT LANGUAGE='javascript' src='validate.js'></SCRIPT>
	

	</head>
	<body bgcolor="#ffffff"><br>
	
    <form name="form1" method="post" action="?a=create_group">
    <table width="300" border="0" align="center" cellpadding="2" cellspacing="2" class="tdborder1">
  <tr  class="boxcolor">
    <td width="211" class="Bcolor" align="center"><strong><?=$strGrade_LabGroupName;?></strong></td>
	
    <td width="75" align="center" class="Bcolor">Action</td>
  </tr>
<?
while ($row = mysql_fetch_array($result)) { ?>
 <tr  bgcolor="#FFFFFF">
    <td width="211" class="hilite" align="center"><? echo $row[1];?></td>
	
    <td width="75" align="center"><a href="?a=edit_group&id=<? echo $row[0]; ?>" target="_self">
			<img src="images/icon/_edit-16.png" border="0" alt="edit">
		</a> 
        <a href="javascript: iconfirm('?a=show_group&action=del&id=<? echo $row[0]; ?>','Do you really want to delete ?')">
			
			<img src="images/icon/_cancel-16.png" border="0" alt="delete">
		</a></td>
  </tr>
<?
}
?>
</table>

	</form>
	<div align="center" class="news"><a href="#" onClick="javascript:window.close();"><b>Close window</b></a></div>
	</body>
	</html>

