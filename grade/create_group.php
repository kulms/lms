 <?
 if ($Create && $g_name!="") {

 mysql_query("INSERT INTO g_score_type_group(g_score_type_g_name,g_users,g_lastupdate) 
												 VALUES ('$g_name',".$person["id"].",".time().")");
								
echo "<script language='javascript'>opener.location.reload();</script>";
	
 }
?>
	<html>
	<head>
	<title>Create Group</title>
	<link rel="STYLESHEET" type="text/css" href="../themes/<? echo $theme;?>/style/main.css">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	

	</head>
	<body bgcolor="#ffffff"><br>
	
    <form name="form1" method="post" action="?a=create_group">
    <table width="300" border="0" align="center" cellpadding="2" cellspacing="2" class="tdborder1">
 
  <tr class="boxcolor">
    <td colspan="2" class="Bcolor"><?=$strGrade_LabCreateGroup;?></td>
    
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="132" class="hilite"><strong><?=$strGrade_LabGroupName;?> :</strong></td>
	
    <td width="154" align="center"><input name="g_name" type="text" size="30" maxlength="50" class="text" value=""></td>
  </tr>
  <tr >
    <td colspan="2">
	
	<input type="hidden" name="modules" value="<?echo $modules?>">
	<input type="hidden" name="courses" value="<?echo $courses?>">
	<input type="hidden" name="id" value="<?echo $prefsid?>">
	<input type="submit" value="<?=$strCreate;?>" class="button" name="Create">	</td>
    
  </tr>
</table>

	</form>
	<div align="center" class="news"><a href="#" onClick="javascript:window.close();"><b>Close window</b></a></div>
	</body>
	</html>

