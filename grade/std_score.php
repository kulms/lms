<?php
		require("classes/grade.class.php");
		$grade=New Grade();
		
		session_start();
		$session_id = session_id();		

		//require ("../include/global_login.php");
		
		$gd_score= $grade->check_score($gid);
		
		if($gd_score !=100) { 
		
		echo "<script language='javascript'>alert('total score not equal 100');location.href='?id=$gid&courses=$g_courses';</script>";
		exit();
		}
		
		$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses;";
		$g_query = mysql_query($g_sql);
		$g_result = @mysql_fetch_array($g_query);
		//echo $g_eval_type;
		//print_progress("1", $g_result["g_grade_id"]);
?>

<html>
<title>
</title>
<head>

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<SCRIPT LANGUAGE='javascript' src='validate.js'></SCRIPT>
<script LANGUAGE="javascript">

function check(step)
{
  
	 if (step ==1 ) {
	
			alert("Error input score");
			
			return false;		
	 
			}
	
	
		location.href="?a=frequency&gid=<? echo $gid;?>";
	
	return true;

}

</script>



</head>
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="4" class="tdborder1">
  <tr>
    <td width="10%" valign="top" class="tdLine"><br><? print_progress("1", $g_result["g_grade_id"],$strGrade_LabProgress,$strGrade_LabSetRatio,$strGrade_LabInputScore,$strGrade_LabSetLevelType,$strGrade_LabSetScoreType,$strGrade_LabReport);?></td>
    <td width="75%">	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="50%">	
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>			
				<td ><h1><?=$strGrade_LabInputScore ;?></h1></td>
			  </tr>
			</table>
		</td>
		<td align="right" width="25%" valign="bottom">
			
		</td>	
	  </tr>  
	</table>
	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tdborder1">
	  <tr> 
		<td colspan="7" align="left">
		<? 
		$result = mysql_query("select g_score_type_id,g_score_type_name,g_max_score,g_score_type_g_id
					   from g_score_type where  g_grade_id = ".$gid." order by g_score_type_name");
		
		while ($row = @mysql_fetch_array($result)) {
		
		$score_name[] = $row["g_score_type_name"];
		$score_id[] = $row["g_score_type_id"];
		$group_id[] = $row["g_score_type_g_id"];
		$max_score[] = $row["g_max_score"];
		
		echo "<a href=\"?a=std_rawscore&id=".$row["g_score_type_id"]."&gid=".$gid."\"><b>".$row["g_score_type_name"]."</b></a>\t | ";
		
		}
		?>
		
		</td>
	  </tr>
	  <tr align="center" class="boxcolor"> 
		<td width="5%" class="main_white" ><?=$strGrade_LabNo;?></td>
		<td width="15%"  class="main_white"><?=$strGrade_LabID;?></td>
		<td width="50%"  class="main_white"><?=$strGrade_LabNameLastname;?></td>
		<?
		
		
		foreach($score_name as $value) {
				
		echo "<td width=\"6%\" class=\"main_white\">";
		echo $value ;
		echo "</td>";
		
		
		}
		
		?>
	  <td width="12%"   class="main_white"><?=$strGrade_LabTotal;?></td>
	  </tr>
	<?
	  
	   $Getlist=mysql_query("SELECT DISTINCT u.id as uid,u.login,u.firstname,u.surname
																									 FROM wp,users u,g_grade g 
																									 WHERE wp.users=u.id AND wp.courses=g.g_courses And g.g_grade_id = ".$gid."
																									 AND wp.cases=0 AND wp.modules=0 AND wp.groups=0 
																									 AND u.active=1  and wp.admin = 0 ORDER BY u.login");
	  
	  $i=1;
	 
	
	 
	 while ($row = @mysql_fetch_array($Getlist)) { ?>
	  <tr bgcolor="#FFFFFF"> 
		<td align="center"><? echo $i;?></td>
		<td align="center">
			<? echo $row["login"];?>
			
		</td>
	   <td align="center">
			<? 
		echo $row["firstname"]."\t".$row["surname"];
			?>
		</td>
		
	   <?
		$total = 0;
		
		for ($j=0; $j<sizeof($score_id); $j++) {
			echo "<td align=\"center\">";
		
		$std_score = mysql_query("select g_std_raw_score from g_std_raw_score where g_score_type_id=".$score_id[$j]." and g_std_users= ".$row["uid"]."
										 and g_grade_id = ".$gid."");
		
		$check = mysql_query("select sum(g_std_raw_score) as total from g_std_raw_score 
													st,g_score_type t where  st.g_score_type_id = t.g_score_type_id 
													and g_std_users= ".$row["uid"]." and st.g_grade_id = ".$gid." and g_score_type_g_id = ".$group_id[$j]."");
	
		$total_group = @mysql_result($check,0,"total");
		
		$raw=@mysql_result($std_score,0,"g_std_raw_score");
		   
		 $chkscr =true;
		 
		 if($group_id[$j]==0) {
			  
			 if( $raw > $max_score[$j]) {
				  
				  $chkscr = false;
			  
			  }
		   
		   }else{	
		
		
		if( $total_group > $max_score[$j]) {
			
			 $chkscr = false;
	
				}
		
		   }	
		
		$num= mysql_num_rows($std_score);
		if ($num==0) {
		  echo "0.00";
		}else {
		 
		 
		 $total = $total + $raw;
		 
		 if(!$chkscr){echo "<font color = \"red\">".$raw."</font>";$step=1;}else{ echo $raw;}
		 
		 
		 }
		
		
		echo "</td>";
	  } // end for
	 
	 
	 echo "<td align=\"center\">";
	 printf("%.2f", $total); 
	 echo "</td>";
	 
	
	  
	  
	  ?>
	 
	  </tr>
	<?
	$i++;
	
	
	}
	
	?>
	</table><br>
	<table width="100%"><tr><td><input name="button" type="button" class="button" onClick="location.href='?id=<? echo $gid;?>'" value="<?=$strGrade_BtnBack;?>"></td><td align="right">
	  <input name="button" type="button" class="button"  value="<?=$strGrade_BtnNext?>" onclick="return check(<? echo $step;?>);"></td></tr></table>
	
	<br>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 
	</table>
	</td>
  </tr>
</table>




</body>
</html>