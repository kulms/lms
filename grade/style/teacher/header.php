<? 
session_start();
$session_id = session_id();
$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses";
		$g_query = mysql_query($g_sql);
		$g_result = mysql_fetch_array($g_query);
		
$cat_lev_sql = "SELECT DISTINCT sl.g_eval_type_id, sl.g_level_type_id, et.g_eval_type_name, lt.g_level_type_name, lt.g_level_type_desc,sl.g_active
									   FROM g_score_level sl, g_eval_type et, g_level_type lt
									   WHERE sl.g_grade_id = ".$g_result["g_grade_id"]."
									   AND sl.g_eval_type_id = et.g_eval_type_id
									   AND sl.g_level_type_id = lt.g_level_type_id AND sl.g_active=1
									   ;";
$cat_lev_query = mysql_query($cat_lev_sql);
$num_cat_lev=mysql_num_rows($cat_lev_query);
?>
<html>
<head>
	<meta name="Version" content="<?php //echo @$AppUI->getConfig( 'version' );?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=tis-620" />
	<title><?php echo @$user->_('M@xLearn');?></title>
<!--	<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />!-->
<link rel="stylesheet" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css" >
<SCRIPT LANGUAGE='javascript' src='validate.js'></SCRIPT>
</head>

<body>
<div id="object1" style="position:absolute; background-color:FFFFDD;color:black;border-color:black;border-width:20; visibility:show; left:25px; top:-100px; z-index:+1" onmouseover="overdiv=1;"  onmouseout="overdiv=0; setTimeout('hideLayer()',1000)">
pop up description layer
</div>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
<tr>
	<th background="../themes/<?php echo $theme;?>/images/titlegrad.jpg"  align="left" class="Bcolor"><?php echo $user->_($strSystem_Header);?></th>
</tr>
<tr>
	<td class="nav" align="left">
	<table width="100%" cellpadding="0" cellspacing="0" >
<tr>	
    <td><a href="index.php?a=select_level"><?php echo $strGrade_LabShowGrade;?></a>&nbsp;|&nbsp;
	<a href="#" onClick="newWindow('index.php?a=prefs&id=<?echo $id;?>&courses=<?echo $g_courses;?>',400,250,'no','no')"><?php echo $strGrade_LabPreference;?></a>&nbsp;|
	<? if($num_cat_lev ==0){?>
	<?php echo $strGrade_LabExport ."(Excel)";?>&nbsp;|&nbsp;<?php echo $strGrade_LabExport  ."(xml)";?>&nbsp;|
	<? }else{?>
	<a href="index.php?a=select_level&dosql=do_export&action=excel"><?php echo $strGrade_LabExport ."(Excel)";?></a>&nbsp;|
	<a href="index.php?a=select_level&dosql=do_export&action=xml"><?php echo $strGrade_LabExport  ."(xml)";?></a>&nbsp;|
	<? } ?><a href="#" onClick="newWindow('help.htm',650,250,'no','yes')"><?php echo $strGrade_Labhelp;?></a>
</td>		
		</td>
  </tr>
	</table>
	</td>
</tr>
<tr>
</table>
  <td>&nbsp; </td>
</tr>
<?
//print_progress("1");
?>
