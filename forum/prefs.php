
<?
  
  
   $forum=new Forum('',$person["id"],$modules,'','');
	
	$names=$forum->select_modulename();
	
	if (isset($names)) {
		
		$result=$forum->get_prefs();
			
			
			if (isset($result)) {
			
				$sort = $result[0]['orders'];
				$showonline = $result[0]['show_online'];
				$timedelay = $result[0]['time_delay'];
				$prefsid= $result[0]['id'];
			    $begindate = $result[0]['begin_date'];
			    $enddate  = $result[0]['end_date'];
				$refresh  = $result[0]['refresh'];
				if ($begindate=="0000-00-00") $begindate="";
				if ($enddate=="0000-00-00") $enddate="";
			}
	        
			$forumname = $names[0]['name'];
	        $username = $names[0]['firstname']."\t".$result[0]['surname'];

 }
?>
	<html>
	<head>
	<title>Preferrence Forum</title>
	<link rel="STYLESHEET" type="text/css" href="../themes/<? echo $theme;?>/style/main.css">
	<link rel="stylesheet" type="text/css" href="lib/myCalendarStyle.css">

	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	  <SCRIPT LANGUAGE='javascript' src='popcalendar.js'></SCRIPT>

	</head>
	<body bgcolor="#ffffff"><br>
	
    <form name="form1" method="post" action="index.php?a=do_prefs_aed">
    <table width="300" border="0" align="center" cellpadding="2" cellspacing="2" class="tdborder1">
 
  <tr class="boxcolor">
    <td colspan="2" class="Bcolor">Preferences for <?echo $username?> in <?echo $forumname?></td>
    
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="139"  class="hilite"> <strong>Sort descending: </strong> </td>
    <td width="147"  align="center"><input type="checkbox" name="sort" <?if($sort==1){?> checked<?}?>></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td class="hilite"><strong>Show system online :</strong></td>
    <td align="center"><input type="checkbox" name="showonline" <?if($showonline==1){?> checked<?}?>></td>
  </tr>
   <tr bgcolor="#FFFFFF">
    <td class="hilite"><strong>Refresh message :</strong></td>
    <td align="center"><input type="checkbox" name="refresh" <?if($refresh==1){?> checked<?}?>></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td class="hilite"><strong>Time Refresh:</strong> (default =5)</td>
	
    <td align="center"><input name="timedelay" type="text" size="4" maxlength="2" class="text" value="<? echo $timedelay?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td class="hilite"><strong>Show message:</strong></td>
	
    <td align="center"><input name="begin_date" type="text" size="8" class="text"  value="<? echo $begindate?>" onclick="popUpCalendar(this,this,'yyyy-mm-dd');" readonly> to
	<input name="end_date" type="text" size="8"  class="text" value="<? echo $enddate?>" onclick="popUpCalendar(this,this,'yyyy-mm-dd');" readonly>
	
	</td>
  </tr>
  
  <tr  class="boxcolor">
    <td colspan="2">
	
	<input type="hidden" name="modules" value="<?echo $modules?>">
	<input type="hidden" name="courses" value="<?echo $courses?>">
	<input type="hidden" name="id" value="<?echo $prefsid?>">
	<input type="submit" value="Update" class="button">	</td>
    
  </tr>
</table>

	</form>
	<div align="center" class="news"><a href="#" onClick="javascript:window.close();"><b>Close window</b></a></div>
	</body>
	</html>

