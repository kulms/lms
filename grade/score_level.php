<?  	
		session_start();
		$session_id = session_id();		

		//require ("../include/global_login.php");
		
		$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses;";
		$g_query = mysql_query($g_sql);
		$g_result = mysql_fetch_array($g_query);				
		//echo $g_eval_type;
		
		$g_score_level_sql = "SELECT distinct  g_eval_type_id, g_level_type_id FROM g_score_level 
													 WHERE g_grade_id = ".$g_result["g_grade_id"]."
													 AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type ORDER BY g_score_level_id
													 ;";
													 
		$g_score_level_query = mysql_query($g_score_level_sql);
		$g_score_level_result = mysql_fetch_array($g_score_level_query);
		
		//echo $g_score_level_result["g_eval_type_id"]."<br>".$g_score_level_result["g_level_type_id"];				
		
		//$g_result["g_grade_id"]
		//SELECT distinct  g_eval_type_id, g_level_type_id FROM g_score_level
		//print_progress("3", $g_result["g_grade_id"]);
?>		
<html>
<title>
</title>
<head>

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language="javascript">
<!--
function newWindow(url,w,h,r,s)
 {
   var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
  var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		
   var options = "width="+w+",height="+h+",";
   options += "resizable="+r+",scrollbars="+s+",status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left="+LeftPosition+",top="+TopPosition;
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }
//-->

</script>
</head>
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="4" class="tdborder1">
  <tr>
    <td width="10%" valign="top" class="tdLine"><br><? print_progress("3", $g_result["g_grade_id"],$strGrade_LabProgress,$strGrade_LabSetRatio,$strGrade_LabInputScore,$strGrade_LabSetLevelType,$strGrade_LabSetScoreType,$strGrade_LabReport);?></td>
    <td width="75%">
	<form name="select_type" method="post" action="?a=show_grade">
		<input type = "hidden" name ="grade_id" value = "<? echo $g_result["g_grade_id"] ?>">
		<input type = "hidden" name ="g_eval_type" value = "<? echo $g_score_level_result["g_eval_type_id"] ?>">
		<input type = "hidden" name ="g_level_type" value = "<? echo $g_score_level_result["g_level_type_id"] ?>">
		<input type="hidden" name="dosql" value="do_grade_select_level" />
	  <table width="603" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder2">
		<tr class="boxcolor"> 
		  <th colspan="3"  class="Bcolor"><?=$strGrade_LabSelectType;?></th>
		</tr>
		<tr bgcolor="#FFFFFF"> 
		  <td  align="left" nowrap class="hilite"> <input name="save" type="submit" id="save" value="<?=$strGrade_BtnCalgrade;?>" class="button"> 
			<input name="reset" type="reset" id="reset" value="<?=$strReset;?>" class="button">		  </td>
		  <td align="right">&nbsp;</td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr> 
		  <td align="right">&nbsp;</td>
		  <td colspan="2" ><div align="center"></div></td>
		</tr>
		<tr  class="boxcolor"> 
		  <td width="149" align="right" class="Bcolor"><div align="center"><?=$strGrade_LabGradeLevel;?>
			</div></td>
		  <td width="208" class="Bcolor"><div align="center"><?=$strGrade_LabMinScore;?></div></td>
		  <td width="234" class="Bcolor"><div align="center"><?=$strGrade_LabMaxScore1;?></div></td>
		</tr>
		<?php
		$score_level_sql = "SELECT * FROM g_score_level 
												WHERE 
												g_grade_id = ".$g_result["g_grade_id"]." 
												AND g_eval_type_id = ".$g_score_level_result["g_eval_type_id"] ."
												AND g_level_type_id = ".$g_score_level_result["g_level_type_id"]." ORDER BY g_score_level_id;";
		//echo mysql_num_rows(mysql_query($score_level_sql));
		$score_level_q = mysql_query($score_level_sql);										
		While($score_level_r = mysql_fetch_array($score_level_q)){
		?>	
		<tr> 
		  <td align="right">
		  <div align="center">
		  <?
		  
		  $level_detail_sql = "SELECT * FROM g_level_detail 
												  WHERE 
												  g_level_detail_id = ".$score_level_r["g_level_detail_id"].";";
		  $level_detail_q = mysql_query($level_detail_sql);									  
		  $level_detail_row = mysql_fetch_array($level_detail_q);
		  echo $level_detail_row["g_level_detail_name"];
		  
		  //echo $score_level_r["g_level_detail_id"];
		  ?>
		  </div>
		  </td>
		  <td><div align="center"> 
			  <input type="text" name="min[]" maxlength="3" size="3" value="<?php if($score_level_r["g_min_score"]!=0) { echo $score_level_r["g_min_score"];}else{ echo "0";}?>">
			</div></td>
		  <td><div align="center"> 
			  <input type="text" name="max[]" maxlength="3" size="3"  value="<?php if($score_level_r["g_max_score"]!=0) { echo $score_level_r["g_max_score"];}else{ echo "0";}?>">
			</div></td>
		</tr>
		<?php
		}
		?>
		<tr> 
		  <td align="right">&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
	  </table>
	</form>
	</td>
  </tr>
</table>


</body>
</html>