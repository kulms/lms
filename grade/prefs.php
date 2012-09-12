<?
$prefs=mysql_query("SELECT g_grade_active,g_view_raw FROM g_grade WHERE g_users=".$person["id"]." AND g_courses=$g_courses;");
		
		if(@mysql_num_rows($prefs)!=0){
			
			$vraw_score=mysql_result($prefs,0,"g_view_raw");
			$g_active=mysql_result($prefs,0,"g_grade_active");
		
			
		}
?>
<SCRIPT LANGUAGE="JavaScript">
	function check() {
		/*
		
		if(view_all.checked=true)
			g_active.checked=true;
	else
		view_all.checked=false;*/
		var view_all = document.forms['form1'].elements['vgrade_all'];
		var g_active = document.forms['form1'].elements['g_active'];
		for (var i=0;i<document.forms[0].elements.length;i++)
		{
			var e=document.forms[0].elements[i];
			if ((e.name != 'g_active') && (e.type=='checkbox'))
				{
					if(g_active.checked== true)
						view_all.disabled=false;
					else{
						view_all.checked=false;
						view_all.disabled=true;
						}
				}
		}
	}
</SCRIPT>
	<html>
	<head>
	<title>Preference Grade</title>
	<link rel="STYLESHEET" type="text/css" href="../themes/<? echo $theme;?>/style/main.css">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	

	</head>
	<body bgcolor="#ffffff">
	
    <form name="form1" method="post" action="?">
    <table width="300" border="0" align="center" cellpadding="2" cellspacing="2" class="tdborder1">
 
  <tr class="boxcolor">
    <td colspan="2" class="Bcolor"><?=$strGrade_LabPreference;?> </td>
    
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="243"  class="hilite"> <strong><?=$strGrade_PrefRawscore;?> : </strong> </td>
    <td width="41"  align="center"><input type="checkbox" name="vraw_score" <?if($vraw_score==1){?> checked<?}?>></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td class="hilite"><strong><strong>
      <?=$strGrade_Prefactive;?>
:</strong>
      </strong></td>
    <td align="center"><input type="checkbox" name="g_active" <? if($g_active==1 || $g_active==2){?> checked<? } ?>  onClick="check();">
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td class="hilite"><strong>
      <?=$strGrade_PrefviewAll;?>
:</strong></td>
	
    <td align="center"><input type="checkbox" name="vgrade_all"  <?if($g_active==2){?> checked<? }?> <? if($g_active==0) echo "disabled";?>></td>
  </tr>
  <tr  class="boxcolor">
    <td colspan="2">
	

	<input type="hidden" name="dosql" value="do_grade_prefs" />
	<input type="submit" value="<?=$strUpdate;?>" class="button">	</td>
    
  </tr>
</table>

	</form>
	<div align="center" class="news"><a href="#" onClick="javascript:window.close();"><b>Close window</b></a></div>
	</body>
	</html>

