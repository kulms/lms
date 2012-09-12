<?  	
		session_start();
		$session_id = session_id();		

		//require ("../include/global_login.php");
		
		$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses;";
		$g_query = mysql_query($g_sql);
		$g_result = mysql_fetch_array($g_query);				
		//echo $g_eval_type;
		
		$g_score_level_sql = "SELECT distinct  g_eval_type_id, g_level_type_id 
													 FROM g_score_level 
													 WHERE g_grade_id = ".$g_result["g_grade_id"]."
													  AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type ORDER BY g_score_level_id
													 ;";
		$g_score_level_query = mysql_query($g_score_level_sql);
		$g_score_level_result = mysql_fetch_array($g_score_level_query);		
		//echo $g_score_level_result["g_eval_type_id"]."<br>".$g_score_level_result["g_level_type_id"];
		
		if($person["category"]==2){
		if($order == "") $order = "id";
						
		if($order=="id"){
		$g_std_grade_sql = "SELECT sg.g_std_users AS std_users, ld.g_level_detail_name AS grade_name, ss.g_std_score_total AS score_total, 
												  u.login, u.title, u.firstname, u.surname
												  FROM g_std_grade sg, g_level_detail ld , g_std_score ss, users u
												  WHERE sg.g_grade_id = ".$g_result["g_grade_id"]." AND
												  sg.g_grade_id = ss.g_grade_id AND
												  sg.g_eval_type_id = ".$g_score_level_result["g_eval_type_id"]." AND
												  sg.g_level_type_id = ".$g_score_level_result["g_level_type_id"]." AND
												  sg.g_level_detail_id = ld.g_level_detail_id AND 
												  sg.g_std_users = ss.g_std_users AND
												  sg.g_std_users = u.id
												  ORDER BY u.login, ss.g_std_score_total DESC
												  ;";
		}										  
		if($order=="name"){
		$g_std_grade_sql = "SELECT sg.g_std_users AS std_users, ld.g_level_detail_name AS grade_name, ss.g_std_score_total AS score_total, 
												  u.login, u.title, u.firstname, u.surname
												  FROM g_std_grade sg, g_level_detail ld , g_std_score ss, users u
												  WHERE sg.g_grade_id = ".$g_result["g_grade_id"]." AND
												  sg.g_grade_id = ss.g_grade_id AND
												  sg.g_eval_type_id = ".$g_score_level_result["g_eval_type_id"]." AND
												  sg.g_level_type_id = ".$g_score_level_result["g_level_type_id"]." AND
												  sg.g_level_detail_id = ld.g_level_detail_id AND 
												  sg.g_std_users = ss.g_std_users AND
												  sg.g_std_users = u.id
												  ORDER BY u.firstname DESC
												  ;";
		}								
		if($order=="score"){
		$g_std_grade_sql = "SELECT sg.g_std_users AS std_users, ld.g_level_detail_name AS grade_name, ss.g_std_score_total AS score_total, 
												  u.login, u.title, u.firstname, u.surname
												  FROM g_std_grade sg, g_level_detail ld , g_std_score ss, users u
												  WHERE sg.g_grade_id = ".$g_result["g_grade_id"]." AND
												  sg.g_grade_id = ss.g_grade_id AND
												  sg.g_eval_type_id = ".$g_score_level_result["g_eval_type_id"]." AND
												  sg.g_level_type_id = ".$g_score_level_result["g_level_type_id"]." AND
												  sg.g_level_detail_id = ld.g_level_detail_id AND 
												  sg.g_std_users = ss.g_std_users AND
												  sg.g_std_users = u.id
												  ORDER BY ss.g_std_score_total DESC
												  ;";
		}										  		  
		if($order=="grade"){
		$g_std_grade_sql = "SELECT sg.g_std_users AS std_users, ld.g_level_detail_name AS grade_name, ss.g_std_score_total AS score_total, 
												  u.login, u.title, u.firstname, u.surname
												  FROM g_std_grade sg, g_level_detail ld , g_std_score ss, users u
												  WHERE sg.g_grade_id = ".$g_result["g_grade_id"]." AND
												  sg.g_grade_id = ss.g_grade_id AND
												  sg.g_eval_type_id = ".$g_score_level_result["g_eval_type_id"]." AND
												  sg.g_level_type_id = ".$g_score_level_result["g_level_type_id"]." AND
												  sg.g_level_detail_id = ld.g_level_detail_id AND 
												  sg.g_std_users = ss.g_std_users AND
												  sg.g_std_users = u.id
												  ORDER BY ss.g_std_score_total DESC
												  ;";
		}										  		  

												  
		$g_std_grade_query = mysql_query($g_std_grade_sql);										  
		}
		
	if($person["category"]==3){
		$g_per_sql="SELECT * FROM g_grade  WHERE g_grade_id = ".$g_result["g_grade_id"]."";
		$g_per_query=mysql_query($g_per_sql);
		$g_grade_active=mysql_result($g_per_query,0,'g_grade_active');
		$g_view_raw=mysql_result($g_per_query,0,'g_view_raw');
		if($g_grade_active==1)
			$user=" AND u.id = ".$person["id"]."";
		else if($g_grade_active==2)
			$user="";
		else if($g_grade_active==0)
			$user="";
		$g_std_grade_sql = "SELECT sg.g_std_users AS std_users, ld.g_level_detail_name AS grade_name, ss.g_std_score_total AS score_total, 
												  u.login, u.title, u.firstname, u.surname
												  FROM g_std_grade sg, g_level_detail ld , g_std_score ss, users u
												  WHERE sg.g_grade_id = ".$g_result["g_grade_id"]." AND
												  sg.g_grade_id = ss.g_grade_id AND
												  sg.g_eval_type_id = ".$g_score_level_result["g_eval_type_id"]." AND
												  sg.g_level_type_id = ".$g_score_level_result["g_level_type_id"]." AND
												  sg.g_level_detail_id = ld.g_level_detail_id AND 
												  sg.g_std_users = ss.g_std_users AND
												  sg.g_std_users = u.id ".$user."
												  ORDER BY ss.g_std_score_total DESC
												  ;";
		$g_std_grade_query = mysql_query($g_std_grade_sql);										  
		}
		//print_progress("4", $g_result["g_grade_id"]);
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
    <td width="10%" valign="top" class="tdLine"><br>
	<? 
	if($person["category"]!=3){
	print_progress("4", $g_result["g_grade_id"],$strGrade_LabProgress,$strGrade_LabSetRatio,$strGrade_LabInputScore,$strGrade_LabSetLevelType,$strGrade_LabSetScoreType,$strGrade_LabReport);
	}
	?></td>
    <td width="75%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1><?=$strGrade_LabAnalysis;?> </h1></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="4" class="tdborder2">
  <tr class="boxcolor"> 
    <td class="main_white"><div align="center"><?=$strGrade_LabStdDvt;?></div></td>
    <td class="main_white"><div align="center"><?=$strGrade_LabMean;?></div></td>
    <td class="main_white"><div align="center"><?=$strGrade_LabMaxValue;?></div></td>
    <td class="main_white"><div align="center"><?=$strGrade_LabMinValue;?></div></td>
    <td class="main_white"><div align="center"><?=$strGrade_LabMedian;?></div></td>
	<?php
	if($g_eval_type==2){
	?>
	<td class="main_white"><div align="center"><?=$strGrade_LabStdscore;?></div></td>
	<?php
	}
	?>
  </tr>
  <?php 
  $sd_value_sql = "SELECT g_standard_value FROM g_standard_detail WHERE g_grade_id = ".$g_result["g_grade_id"]." AND g_standard_type_id = 3 AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type;";
  $sd_query = mysql_query($sd_value_sql);
  $max_value_sql = "SELECT g_standard_value FROM g_standard_detail WHERE g_grade_id = ".$g_result["g_grade_id"]." AND g_standard_type_id = 5 AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type;";
  $max_query = mysql_query($max_value_sql);
  $min_value_sql = "SELECT g_standard_value FROM g_standard_detail WHERE g_grade_id = ".$g_result["g_grade_id"]." AND g_standard_type_id = 6 AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type;";
  $min_query = mysql_query($min_value_sql);
  $mean_value_sql = "SELECT g_standard_value FROM g_standard_detail WHERE g_grade_id = ".$g_result["g_grade_id"]." AND g_standard_type_id = 4 AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type;";
  $mean_query = mysql_query($mean_value_sql);
  $median_value_sql = "SELECT g_standard_value FROM g_standard_detail WHERE g_grade_id = ".$g_result["g_grade_id"]." AND g_standard_type_id = 1 AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type;";
  $median_query = mysql_query($median_value_sql);
  if($g_eval_type==2){
  	$z_value_sql = "SELECT g_standard_value FROM g_standard_detail WHERE g_grade_id = ".$g_result["g_grade_id"]." AND g_standard_type_id = 2 AND g_eval_type_id = $g_eval_type
													 AND g_level_type_id = $g_level_type;";
  	$z_query = mysql_query($z_value_sql);
  }
  ?>
  <tr> 
    <td bgcolor="#FFFFFF"><div align="center"><?php echo @mysql_result($sd_query ,0,"g_standard_value");?></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><?php echo @mysql_result($mean_query ,0,"g_standard_value");?></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><?php echo @mysql_result($max_query ,0,"g_standard_value");?></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><?php echo @mysql_result($min_query ,0,"g_standard_value");?></div></td>
    <td bgcolor="#FFFFFF"><div align="center"><?php echo @mysql_result($median_query ,0,"g_standard_value");?></div></td>
	<?php
	if($g_eval_type==2){
	?>
	 <td bgcolor="#FFFFFF"><div align="center"><?php echo @mysql_result($z_query ,0,"g_standard_value");?></div></td>
	<?php
	}
	?>
  </tr>
</table>
<?
if($person["category"]!=3){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1><?=$strGrade_LabHeadSummary;?> </h1></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="4" class="tdborder2">
  <tr class="boxcolor"> 
    <td width="10%">&nbsp;</td>
    <td width="14%" class="main_white"><div align="center"><?=$strGrade_LabGrade;?></div></td>
    <td width="29%" class="main_white"><div align="center"><?=$strGrade_LabScoreLevel;?></div></td>
    <td width="22%" class="main_white"><div align="center"><?=$strGrade_LabAmountSt;?></div></td>
    <td width="15%" class="main_white"><div align="center"> <?=$strGrade_LabPercent;?> (%)</div></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <?php
  $score_level_check = "SELECT DISTINCT sl.*, ld.g_level_detail_name FROM g_score_level sl, g_level_detail ld 
  												WHERE sl.g_grade_id = ".$g_result["g_grade_id"]." 
					  							AND sl.g_eval_type_id =  ".$g_score_level_result["g_eval_type_id"]." 
												AND sl.g_level_type_id = ".$g_score_level_result["g_level_type_id"]."
												AND sl.g_level_detail_id = ld.g_level_detail_id ORDER BY sl.g_score_level_id
												;";
	//echo $score_level_check	."<br>";

	$g_score_level_query = mysql_query($score_level_check);	
			
	while($row_g_score_level=mysql_fetch_array($g_score_level_query)){
			$max[] = $row_g_score_level["g_max_score"];
			$min[] = $row_g_score_level["g_min_score"];
			$score_level_id[] = $row_g_score_level["g_score_level_id"];
			$level_detail[] = $row_g_score_level["g_level_detail_id"];
			$level_name[] = $row_g_score_level["g_level_detail_name"];						
	}
	
	$num_level = count($level_detail);	
	$j=0;
	
	while($j<$num_level){
		$std_count_sql  = "SELECT COUNT(g_std_users) AS c_std FROM g_std_grade 
											WHERE g_grade_id = ".$g_result["g_grade_id"]." 
											AND g_eval_type_id =  ".$g_score_level_result["g_eval_type_id"]." 
											AND g_level_type_id = ".$g_score_level_result["g_level_type_id"]."
											AND g_level_detail_id = ".$level_detail[$j].";";										
		
		$std_count_query = mysql_query($std_count_sql);
		$std_count_row = mysql_fetch_array($std_count_query);
		$std_count[] = mysql_result($std_count_query,0,"c_std");		
		$j++;
	}
	reset($level_detail); 
	
	
	
	$std_total = @mysql_num_rows($g_std_grade_query);
	//reset($max); 
	//$num = count($max);	  	
	$num = mysql_num_rows($g_score_level_query);
	//$num = count($row_g_score_level);	  		
	//echo $num;
	$i=0;
	While($i<$num)
	{	 	
  ?>
  <tr> 
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#ffffff"><?php echo $level_name[$i];?></td>
    <td align="center" bgcolor="#ffffff"><?php echo $min[$i]." - ".$max[$i];?></td>
    <td align="center" bgcolor="#ffffff"><?php echo $std_count[$i];?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo ($std_count[$i]/$std_total)*100;?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <?php  
  $i++;
  }
  	reset($max); 
	//reset($min); 
	//reset($level_detail); 
	reset($std_count);
	reset($level_name); 
	//reset($score_level_id); 
  ?>
  <tr class="boxcolor">
    <td >&nbsp;</td>
    <td align="center"  class="main_white"><strong><?=$strGrade_LabSummary;?></strong></td>
    <td align="center">&nbsp;</td>
    <td align="center"  class="main_white"><strong><?php echo $std_total;?></strong></td>
    <td align="center"  class="main_white"><strong>100</strong></td>
    <td >&nbsp;</td>
  </tr>
</table>
<?
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1><?=$strGrade_LabReport;?> </h1></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="tdborder2">
  <tr class="boxcolor"> 
    <td width="8%" height="25" class="main_white">
<div align="center"><?=$strGrade_LabNo;?></div></td>
    <td width="17%" class="main_white"><div align="center"><a class="a13" href="?a=show_grade&order=id&g_eval_type=<? echo $g_eval_type?>&g_level_type=<? echo $g_level_type;?>"><?=$strGrade_LabID;?></a></div></td>
    <td width="50%" class="main_white"><div align="center"><a class="a13" href="?a=show_grade&order=name&g_eval_type=<? echo $g_eval_type?>&g_level_type=<? echo $g_level_type;?>"><?=$strGrade_LabNameLastname;?></a></div></td>
    <? if($g_view_raw ==1 || $person["category"]!=3){?>
	<td width="12%" class="main_white"><div align="center"><a class="a13" href="?a=show_grade&order=score&g_eval_type=<? echo $g_eval_type?>&g_level_type=<? echo $g_level_type;?>"><?=$strGrade_LabScore;?></a></div></td>
   <? } ?>
    <td width="13%" class="main_white"><div align="center"><a class="a13" href="?a=show_grade&order=grade&g_eval_type=<? echo $g_eval_type?>&g_level_type=<? echo $g_level_type;?>"><?=$strGrade_LabGrade;?></a></div></td>
  </tr>
  <?
  $i=1;
  
  while($row_g_std_grade=@mysql_fetch_array($g_std_grade_query)){
	  if(($i%2) == 0){
		$bg="";
	  } else {
		$bg = "bgcolor=\"#FFFFFF\"";  
	  }
  ?>
  <tr> 
    <td align="center" class="tdBotred" <?php echo $bg;?>><?php echo $i;?></td>
    <td align="center" class="tdBotred" <?php echo $bg;?>><?php echo $row_g_std_grade["login"];?></td>
    <td class="tdBotred" <?php echo $bg;?>><img src="../images/space.gif" width="30" height="5"><?php echo $row_g_std_grade["title"].$row_g_std_grade["firstname"]."  ".$row_g_std_grade["surname"];?></td>
     <? if($g_view_raw ==1|| $person["category"] !=3){?>
	<td align="center" class="tdBotred" <?php echo $bg;?>><?php echo $row_g_std_grade["score_total"];?></td>
   <? }?> 
	<td align="center" class="tdBotred" <?php echo $bg;?>><?php echo $row_g_std_grade["grade_name"];?></td>
  </tr>
  <?
  $i++;
  }
  ?>
</table>
<?
if($person["category"]!=3){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1><?=$strGrade_LabGraph;?></h1></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tdborder2">
  <tr>
    <td align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
          <td><?=$strGrade_LabGraphBar;?></td>
  </tr>
</table>
<? 

$a = $std_count;
rsort($std_count);
$max_std_score = $std_count["0"];

?>
<?
if($g_level_type == 1) {
?>
	<span >
	<img src="./std_graph1.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_ba=<?php echo $a["1"];?>&num_bb=<?php echo $a["2"];?>&num_ca=<?php echo $a["3"];?>&num_cc=<?php echo $a["4"];?>&num_da=<?php echo $a["5"];?>&num_dd=<?php echo $a["6"];?>&num_ff=<?php echo $a["7"];?>" align="center">
	</span>
<?
}
if($g_level_type == 2) {
?>	
	<span >
	<img src="./std_graph3.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_bb=<?php echo $a["1"];?>&num_cc=<?php echo $a["2"];?>&num_dd=<?php echo $a["3"];?>&num_ff=<?php echo $a["4"];?>" align="center">
	</span>
<?
}
if($g_level_type == 3) {
?>	
	<span >
	<img src="./std_graph5.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_bb=<?php echo $a["1"];?>&num_cc=<?php echo $a["2"];?>" align="center">
	</span>
<?
}
if($g_level_type == 4) {
?>	
	<span >
	<img src="./std_graph7.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_bb=<?php echo $a["1"];?>" align="center">
	</span>
<?
}
?>	
	<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
			  <td><?=$strGrade_LabGraphCircle;?></td>
	  </tr>
	</table>
	<?
	if($g_level_type == 1) {
	?>
	<span >
	<img src="./std_graph2.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_ba=<?php echo $a["1"];?>&num_bb=<?php echo $a["2"];?>&num_ca=<?php echo $a["3"];?>&num_cc=<?php echo $a["4"];?>&num_da=<?php echo $a["5"];?>&num_dd=<?php echo $a["6"];?>&num_ff=<?php echo $a["7"];?>" align="center">
	</span>
	<?
	}
	if($g_level_type == 2) {	
	?>
	<span >
	<img src="./std_graph4.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_bb=<?php echo $a["1"];?>&num_cc=<?php echo $a["2"];?>&num_dd=<?php echo $a["3"];?>&num_ff=<?php echo $a["4"];?>" align="center">
	</span>
	<?
	}
	if($g_level_type == 3) {	
	?>
	<span >
	<img src="./std_graph6.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_bb=<?php echo $a["1"];?>&num_cc=<?php echo $a["2"];?>" align="center">
	</span>
	<?
	}
	if($g_level_type == 4) {	
	?>
	<span >
	<img src="./std_graph8.php?rec_num=<?php echo $std_total;?>&max_num=<?php echo $max_std_score;?>&num_aa=<?php echo $a["0"];?>&num_bb=<?php echo $a["1"];?>" align="center">
	</span>
	<?
	}
	?>
	</td>
  </tr>
</table>
<? } ?>
	</td>
  </tr>
</table>
</body>
</html>