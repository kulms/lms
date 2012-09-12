<?php
$score_level_check = "SELECT * FROM g_score_level WHERE g_grade_id = $grade_id 
					  AND g_eval_type_id = $g_eval_type AND g_level_type_id = $g_level_type;";					  

if($save){
	echo "save";	
	if(@mysql_num_rows(mysql_query($score_level_check))!=0){
		$g_score_level_query = mysql_query($score_level_check);
		
		$g_std_score_sql = "SELECT * FROM g_std_score WHERE g_grade_id = $grade_id;";
		$g_std_score_query = mysql_query($g_std_score_sql);
		
		while($row_g_score_level=mysql_fetch_array($g_score_level_query)){
			$max[] = $row_g_score_level["g_max_score"];
			$min[] = $row_g_score_level["g_min_score"];
			$score_level_id[] = $row_g_score_level["g_score_level_id"];
			$level_detail[] = $row_g_score_level["g_level_detail_id"];
			
		}
		
		while($row_std_score=mysql_fetch_array($g_std_score_query)){
			$std_score_total = $row_std_score["g_std_score_total"];
			$std_users = $row_std_score["g_std_users"];
			$num = count($max);
			for($i=0;i<$num-1;$i++)
			{
				if(($std_score_total <= $max[$i]) && ($std_score_total >= $min[$i])){
					$g_std_grade_sql = "INSERT INTO g_std_grade (g_grade_id, g_eval_type_id, g_score_level_id, 
																 g_level_type_id, g_level_detail_id, g_std_users, g_users, g_lastupdate)
										VALUES
										($grade_id, $g_eval_type, ".$score_level_id["$i"].", 
										$g_level_type, ".$level_detail["$i"].", $std_users, ".$person["id"].", ".time().")
										;";
					echo $g_std_grade_sql."<br>";					
				}
			}
			reset($max); 
		}
		
	}

} else {					  
	if(@mysql_num_rows(mysql_query($score_level_check))==0){
	
		switch ($g_eval_type) {
			case 1:
				switch ($g_level_type) {
					case 1:
						$level_detial_sql = "SELECT * FROM g_level_detail WHERE g_level_type_id = $g_level_type;";
						$level_detial_query = mysql_query($level_detial_sql);
						$max = array(1 => 100, 79, 74, 69, 64, 59, 54, 49);
						$min = array(1 => 80, 75, 70, 65, 60, 55, 50, 0);
						$i=1;
						while($level_detial_row = mysql_fetch_array($level_detial_query)){
							$insert_g_score_level_sql = "INSERT INTO g_score_level 
														(g_grade_id, g_eval_type_id, g_level_type_id, g_level_detail_id, g_min_score, g_max_score, g_users, g_lastupdate)
														VALUES
														($grade_id, $g_eval_type, $g_level_type, ".$level_detial_row["g_level_detail_id"].", ".$min[$i].", ".$max[$i].", ".$person["id"].", ".time().");";				
							//echo $insert_g_score_level_sql."<br>";							
							mysql_query($insert_g_score_level_sql);
							$i++;
						}
						break;
					case 2:
						$level_detial_sql = "SELECT * FROM g_level_detail WHERE g_level_type_id = $g_level_type;";
						$level_detial_query = mysql_query($level_detial_sql);
						$max = array(1 => 100, 79, 69, 59, 49);
						$min = array(1 => 80, 70, 60, 50, 0);
						$i=1;
						while($level_detial_row = mysql_fetch_array($level_detial_query)){
							$insert_g_score_level_sql = "INSERT INTO g_score_level 
														(g_grade_id, g_eval_type_id, g_level_type_id, g_level_detail_id, g_min_score, g_max_score, g_users, g_lastupdate)
														VALUES
														($grade_id, $g_eval_type, $g_level_type, ".$level_detial_row["g_level_detail_id"].", ".$min[$i].", ".$max[$i].", ".$person["id"].", ".time().");";				
							//echo $insert_g_score_level_sql."<br>";							
							mysql_query($insert_g_score_level_sql);
							$i++;
						}
						break;
					case 3:
						print "3 levels";
						break;
					case 4:
						print "2 levels";
						break;	
				}		
				break;
			case 2:
				print "Group";
				break;
			case 3:
				print "3";
				break;
		}
	
	} else {
		echo "This condition'd already exist.";
	}
}
?>
