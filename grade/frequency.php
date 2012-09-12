<?

for ($i=0;$i<=100;$i++) {
	
	$sql=mysql_query("select sum(g_std_raw_score) as totalscore from g_std_raw_score where g_grade_id =".$gid." group by g_std_users having round(totalscore) = ".$i."");


$num = mysql_num_rows($sql);
$users[$i] = 0;

  
if ($num!=0) {
//echo @mysql_result($sql,0,"totalscore");
//echo $num;
//select g_std_freq_score,g_std_score_total  from g_

$check = mysql_query("select g_std_freq_score_id from g_std_freq_score
                                              where g_grade_id = ".$gid." and g_std_freq_score = ".$i."
											  and g_users = ".$person["id"]."");

 


if (@mysql_num_rows($check) == 0 ) {

mysql_query("INSERT INTO g_std_freq_score (g_grade_id,g_std_freq_score,g_std_freq_score_total,g_users,g_lastupdate) 
					 VALUES (".$gid.",".$i.",".$num." ,".$person["id"].", ".time().")");

}else {

$id= @mysql_result($check,0,"g_std_freq_score_id");

mysql_query("UPDATE g_std_freq_score set
		                       g_std_freq_score_total = ".$num.",
							   g_lastupdate = ".time()."
						       WHERE g_std_freq_score_id=".$id."");

		}





$users[$i] = $num;
	
	}else {

mysql_query("delete from g_std_freq_score where g_grade_id = ".$gid." 
							 and  g_std_freq_score = ".$i." and g_users = ".$person["id"]."");




	}





}// End for



//Insert student score

$std_sql =mysql_query("select round(sum(g_std_raw_score)) as total_stdscore,g_std_users from g_std_raw_score where g_grade_id =".$gid."  group by g_std_users");

while ($rs = mysql_fetch_array($std_sql)) { 

$std_check = mysql_query("select g_std_score_id from g_std_score where g_std_users
                                                       = ".$rs[1]." and   g_grade_id =".$gid."");

$std_num = mysql_num_rows($std_check);

if($std_num==0) {

mysql_query("INSERT INTO g_std_score (g_grade_id,g_std_users,g_std_score_total,g_users,g_lastupdate) 
					 
					 VALUES (".$gid.",".$rs[1].",".$rs[0]." ,".$person["id"].", ".time().")");

}else {
      
$std_id= @mysql_result($std_check,0,"g_std_score_id");
			
			mysql_query("UPDATE g_std_score set
		                       g_std_score_total = ".$rs[0].",
							   g_lastupdate = ".time()."
						       WHERE g_std_score_id=".$std_id."");


		}


}
		
		$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses;";
		$g_query = mysql_query($g_sql);
		$g_result = mysql_fetch_array($g_query);
		//echo $g_eval_type;
		print_progress("1", $g_result["g_grade_id"],$strGrade_LabProgress,$strGrade_LabSetRatio,$strGrade_LabInputScore,$strGrade_LabSetLevelType,$strGrade_LabSetScoreType,$strGrade_LabReport);
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="8%" nowrap>
			<?
	
	echo "<h1>".$strGrade_LabFrequency."</h1>";
	
	

	?>
	
			</td>
			<td width="92%">
			
			</td>
		  </tr>
	  </table>
	</td>
	<td align="right" width="25%" valign="bottom">
		
	</td>	
  </tr>  
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tdborder1">
  
  
    <?
	for($i=0;$i<10;$i++) {;
	    
		 echo "<tr align=\"center\">";
     
	  for($j=0;$j<10;$j++) {
          
		  $fscore = $j+($i*10);
		 // $sql = mysql_query("select  count(distinct g_std_users) as amount from g_std_raw_score where g_grade_id =2 
						//		and g_std_raw_score = $fscore");
          //  $std_user = @mysql_result($sql,0,amount);
		  
		  echo "<td  class=\"hilite\" >".$fscore. " <input type=\"text\" size=3 class=\"text\" readonly value=\"$users[$fscore]\"></td>";
          
		  if ($fscore ==99) {
		  echo "<td  class=\"hilite\" >".($fscore+=1). " <input type=\"text\" size=3 class=\"text\" readonly value=\"$users[$fscore]\"></td>";
         
			}
		 
		 }
   echo "</tr>";
   }
   ?>

</table>


<div align="left"><input name="button" type="button" class="button" onClick="location.href='?a=std_score&gid=<? echo $gid;?>'" value="<?=$strGrade_BtnBack;?>"></div>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
</table>


</body>
</html>