<?php
$score_level_check = "SELECT * FROM g_score_level WHERE g_grade_id = $grade_id 
					  AND g_eval_type_id = $g_eval_type AND g_level_type_id = $g_level_type ORDER BY g_score_level_id ;";					  

if($save){
	//echo "save"."<br>";		
	if(@mysql_num_rows(mysql_query($score_level_check))!=0){
			
		$g_score_level_query = mysql_query($score_level_check);
		
		while (list($key,$value) = each($max)) { 			
			$max_value[] = intval(substr($value,0,3));
		}		
		while (list($key,$value) = each($min)) { 			
			$min_value[] = intval(substr($value,0,3));
		}		
		$i=0;
		while($row_g_score_level=mysql_fetch_array($g_score_level_query)){		
			$sql = "UPDATE g_score_level SET 
						g_min_score = ".$min_value[$i].",
						g_max_score = ".$max_value[$i].",
						g_lastupdate = ".time()."
					WHERE g_score_level_id = ".$row_g_score_level["g_score_level_id"]."
					;";					
			mysql_query($sql);
			$i++;
		}
										
		mysql_free_result($g_score_level_query);
		
		$g_score_level_query = mysql_query($score_level_check);						
		
		$g_std_score_sql = "SELECT * FROM g_std_score WHERE g_grade_id = $grade_id;";
		$g_std_score_query = mysql_query($g_std_score_sql);
		
		while($row_g_score_level=mysql_fetch_array($g_score_level_query)){
			$max[] = $row_g_score_level["g_max_score"];
			$min[] = $row_g_score_level["g_min_score"];
			$score_level_id[] = $row_g_score_level["g_score_level_id"];
			$level_detail[] = $row_g_score_level["g_level_detail_id"];
			
		}
		$g_std_grade_check = "SELECT * FROM g_std_grade 
							  WHERE g_grade_id = ".$grade_id." 
							  AND g_eval_type_id = ".$g_eval_type."
							  AND g_level_type_id = ".$g_level_type."
							  ;";
		if(@mysql_num_rows(mysql_query($g_std_grade_check))!=0){
			$del_sql = "DELETE FROM g_std_grade
						WHERE g_grade_id = ".$grade_id." 
						AND g_eval_type_id = ".$g_eval_type."
						AND g_level_type_id = ".$g_level_type."
						;";
			mysql_query($del_sql);					
		}					  
							  
		while($row_std_score=mysql_fetch_array($g_std_score_query)){
			$std_score_total = $row_std_score["g_std_score_total"];
			$arr_std_score_total[] = $row_std_score["g_std_score_total"];
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
					mysql_query($g_std_grade_sql);
					break;					
				}
			}
			reset($max); 
			reset($min); 
			reset($level_detail); 
			reset($score_level_id); 			
		}		
		
		
	}

} else {					  
	if(@mysql_num_rows(mysql_query($score_level_check))==0){
	
		switch ($g_eval_type) {
			case 1:
				$g_std_score_sql = "SELECT * FROM g_std_score WHERE g_grade_id = $grade_id;";
				$g_std_score_query = mysql_query($g_std_score_sql);
				
				while($row_std_score=mysql_fetch_array($g_std_score_query)){
					$arr_std_score_total[] = $row_std_score["g_std_score_total"];
				}
				// insert Statistic Values
				$standard_value_check = "SELECT * FROM g_standard_detail WHERE g_grade_id = $grade_id AND g_eval_type_id = $g_eval_type AND g_level_type_id = $g_level_type;";
				if(@mysql_num_rows(mysql_query($standard_value_check))==0){
		
					$sd_value = standard_deviation($arr_std_score_total);
					$sd_value = round($sd_value, 2);
					$sd_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 3, $sd_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($sd_insert_sql);
					//echo "SD = ".$sd_value."<br>";
					$max_value = maximum($arr_std_score_total);		
					$max_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 5, $max_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($max_insert_sql);				 
					//echo "Max = ".$max_value."<br>";			
					$min_value = minimum($arr_std_score_total);
					$min_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 6, $min_value, ".$person["id"].", ".time()."
									  )	 
									 ;";	
					mysql_query($min_insert_sql);				 
					//echo "Min = ".$min_value."<br>";
					$mean_value = mean($arr_std_score_total);
					$mean_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 4, $mean_value, ".$person["id"].", ".time()."
									  )	 
									 ;";					
					mysql_query($mean_insert_sql);				 
					//echo "Mean = ".$mean_value."<br>";
					$median_value = median($arr_std_score_total);
					$median_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 1, $median_value, ".$person["id"].", ".time()."
									  )	 
									 ;";													
					mysql_query($median_insert_sql);				 
					echo "Median = ".$median_value."<br>";
				}
				// end insert statistic values
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
				//print "Group";
				$g_std_score_sql = "SELECT * FROM g_std_score WHERE g_grade_id = $grade_id;";
				$g_std_score_query = mysql_query($g_std_score_sql);
				
				while($row_std_score=mysql_fetch_array($g_std_score_query)){
					$arr_std_score_total[] = $row_std_score["g_std_score_total"];
				}
				// insert Statistic Values
				$standard_value_check = "SELECT * FROM g_standard_detail WHERE g_grade_id = $grade_id AND g_eval_type_id = $g_eval_type AND g_level_type_id = $g_level_type ;";
				if(@mysql_num_rows(mysql_query($standard_value_check))==0){
		
					$sd_value = standard_deviation($arr_std_score_total);
					$sd_value = round($sd_value, 2);
					$sd_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 3, $sd_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($sd_insert_sql);
					//echo "SD = ".$sd_value."<br>";
					$max_value = maximum($arr_std_score_total);		
					$max_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 5, $max_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($max_insert_sql);				 
					//echo "Max = ".$max_value."<br>";			
					$min_value = minimum($arr_std_score_total);
					$min_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 6, $min_value, ".$person["id"].", ".time()."
									  )	 
									 ;";	
					mysql_query($min_insert_sql);				 
					//echo "Min = ".$min_value."<br>";
					$mean_value = mean($arr_std_score_total);
					$mean_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 4, $mean_value, ".$person["id"].", ".time()."
									  )	 
									 ;";					
					mysql_query($mean_insert_sql);				 
					//echo "Mean = ".$mean_value."<br>";
					$median_value = median($arr_std_score_total);
					$median_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 1, $median_value, ".$person["id"].", ".time()."
									  )	 
									 ;";													
					mysql_query($median_insert_sql);				 
					//echo "Median = ".$median_value."<br>";
					$z_value = $z;
					$median_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 2, $z_value, ".$person["id"].", ".time()."
									  )	 
									 ;";													
					mysql_query($median_insert_sql);				 
					//echo "Z = ".$z_value."<br>";
				}
				// end insert statistic values
				switch ($g_level_type) {
					case 1:
						$level_detial_sql = "SELECT * FROM g_level_detail WHERE g_level_type_id = $g_level_type;";
						$level_detial_query = mysql_query($level_detial_sql);
						
						$min_a = $median_value+($z*$sd_value);
						$min_a = round($min_a);						
						$min_b_p = $min_a-($sd_value/2);
						$min_b_p = round($min_b_p);
						$min_b = $min_b_p-($sd_value/2);
						$min_b = round($min_b);
						$min_c_p = $min_b-($sd_value/2);
						$min_c_p = round($min_c_p);
						$min_c = $min_c_p-($sd_value/2);
						$min_c = round($min_c);
						$min_d_p = $min_c-($sd_value/2);
						$min_d_p = round($min_d_p);
						$min_d = $min_d_p-($sd_value/2);
						$min_d = round($min_d);
						
						$max_b_p = $min_a -1;
						$max_b = $min_b_p -1;
						$max_c_p = $min_b -1;
						$max_c = $min_c_p -1;
						$max_d_p = $min_c -1;
						$max_d = $min_d_p -1;
						$max_f = $min_d -1;
						
						$max = array(1 => 100, $max_b_p, $max_b, $max_c_p, $max_c, $max_d_p, $max_d, $max_f);
						//print_r($max);
						$min = array(1 => $min_a, $min_b_p, $min_b, $min_c_p, $min_c, $min_d_p, $min_d, 0);
						//print_r($min);
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
						//$max = array(1 => 100, 79, 69, 59, 49);
						//$min = array(1 => 80, 70, 60, 50, 0);
						
						$min_a = $median_value+($z*$sd_value);
						$min_a = round($min_a);						
						$min_b = $min_a-($sd_value);
						$min_b = round($min_b);
						$min_c = $min_b-($sd_value);
						$min_c = round($min_c);
						$min_d = $min_c-($sd_value);
						$min_d = round($min_d);
						
						$max_b = $min_a -1;
						$max_c = $min_b -1;
						$max_d = $min_c -1;
						$max_f = $min_d -1;
						
						$max = array(1 => 100, $max_b, $max_c, $max_d, $max_f);
						//print_r($max);
						$min = array(1 => $min_a, $min_b, $min_c, $min_d, 0);
						//print_r($min);
						
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
			case 3:
				//print "variable grading";
				$g_std_score_sql = "SELECT * FROM g_std_score WHERE g_grade_id = $grade_id;";
				$g_std_score_query = mysql_query($g_std_score_sql);
				
				while($row_std_score=mysql_fetch_array($g_std_score_query)){
					$arr_std_score_total[] = $row_std_score["g_std_score_total"];
				}
				// insert Statistic Values
				$standard_value_check = "SELECT * FROM g_standard_detail WHERE g_grade_id = $grade_id AND g_eval_type_id = $g_eval_type AND g_level_type_id = $g_level_type;";
				if(@mysql_num_rows(mysql_query($standard_value_check))==0){
		
					$sd_value = standard_deviation($arr_std_score_total);
					$sd_value = round($sd_value, 2);
					$sd_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 3, $sd_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($sd_insert_sql);
					//echo "SD = ".$sd_value."<br>";
					$max_value = maximum($arr_std_score_total);		
					$max_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 5, $max_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($max_insert_sql);				 
					//echo "Max = ".$max_value."<br>";			
					$min_value = minimum($arr_std_score_total);
					$min_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 6, $min_value, ".$person["id"].", ".time()."
									  )	 
									 ;";	
					mysql_query($min_insert_sql);				 
					//echo "Min = ".$min_value."<br>";
					$mean_value = mean($arr_std_score_total);
					$mean_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 4, $mean_value, ".$person["id"].", ".time()."
									  )	 
									 ;";					
					mysql_query($mean_insert_sql);				 
					//echo "Mean = ".$mean_value."<br>";
					$median_value = median($arr_std_score_total);
					$median_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 1, $median_value, ".$person["id"].", ".time()."
									  )	 
									 ;";													
					mysql_query($median_insert_sql);				 
					//echo "Median = ".$median_value."<br>";
				}
				// end insert statistic values
				switch ($g_level_type) {
					case 1:
						$level_detial_sql = "SELECT * FROM g_level_detail WHERE g_level_type_id = $g_level_type;";
						$level_detial_query = mysql_query($level_detial_sql);
						$max = array(1 => 100, 0, 0, 0, 0, 0, 0, 0);
						$min = array(1 => 0, 0, 0, 0, 0, 0, 0, 0);
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
						$max = array(1 => 100, 0, 0, 0, 0);
						$min = array(1 => 0, 0, 0, 0, 0);
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
						$level_detial_sql = "SELECT * FROM g_level_detail WHERE g_level_type_id = $g_level_type;";
						$level_detial_query = mysql_query($level_detial_sql);
						$max = array(1 => 100, 0, 0);
						$min = array(1 => 0, 0, 0);
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
					case 4:
						$level_detial_sql = "SELECT * FROM g_level_detail WHERE g_level_type_id = $g_level_type;";
						$level_detial_query = mysql_query($level_detial_sql);
						$max = array(1 => 100, 0);
						$min = array(1 => 0, 0);
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
				}		
				break;
			case 4:
				//print "T Score";								
				$g_std_score_sql = "SELECT * FROM g_std_score WHERE g_grade_id = $grade_id;";
				$g_std_score_query = mysql_query($g_std_score_sql);
				
				while($row_std_score=mysql_fetch_array($g_std_score_query)){
					$arr_std_score_total[] = $row_std_score["g_std_score_total"];
				}
				// insert Statistic Values
				$standard_value_check = "SELECT * FROM g_standard_detail WHERE g_grade_id = $grade_id AND g_eval_type_id = $g_eval_type AND g_level_type_id = $g_level_type ;";
				if(@mysql_num_rows(mysql_query($standard_value_check))==0){
		
					$sd_value = standard_deviation($arr_std_score_total);
					$sd_value = round($sd_value, 2);
					$sd_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 3, $sd_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($sd_insert_sql);
					//echo "SD = ".$sd_value."<br>";
					$max_value = maximum($arr_std_score_total);		
					$max_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 5, $max_value, ".$person["id"].", ".time()."
									  )	 
									 ;";
					mysql_query($max_insert_sql);				 
					//echo "Max = ".$max_value."<br>";			
					$min_value = minimum($arr_std_score_total);
					$min_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 6, $min_value, ".$person["id"].", ".time()."
									  )	 
									 ;";	
					mysql_query($min_insert_sql);				 
					//echo "Min = ".$min_value."<br>";
					$mean_value = mean($arr_std_score_total);
					$mean_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 4, $mean_value, ".$person["id"].", ".time()."
									  )	 
									 ;";					
					mysql_query($mean_insert_sql);				 
					//echo "Mean = ".$mean_value."<br>";
					$median_value = median($arr_std_score_total);
					$median_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 1, $median_value, ".$person["id"].", ".time()."
									  )	 
									 ;";													
					mysql_query($median_insert_sql);				 
					//echo "Median = ".$median_value."<br>";
					$z_value = $z;
					$median_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 2, $z_value, ".$person["id"].", ".time()."
									  )	 
									 ;";													
					mysql_query($median_insert_sql);				 
					//echo "Z = ".$z_value."<br>";
					
					$tmax_value = (10*(($max_value-$min_value)/$sd_value))+50;
					$mean_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 7, $tmax_value, ".$person["id"].", ".time()."
									  )	 
									 ;";					
					mysql_query($mean_insert_sql);				 
					
					$tmin_value = (10*(($min_value-$mean_value)/$sd_value))+50;
					$mean_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 8, $tmin_value, ".$person["id"].", ".time()."
									  )	 
									 ;";					
					mysql_query($mean_insert_sql);
					
					switch ($g_level_type) {
						case 1:
							$gnum = 8;
							break;						
						case 2:
							$gnum = 5;
							break;
					}
							
					$k_value = (($tmax_value-$tmin_value)+1)/$gnum;
					
					$mean_insert_sql = "INSERT INTO g_standard_detail (g_grade_id, g_eval_type_id, g_level_type_id, g_standard_type_id, 
																	g_standard_value, g_users, g_lastupdate)
									  VALUES	
									  ($grade_id, $g_eval_type, $g_level_type, 9, $k_value, ".$person["id"].", ".time()."
									  )	 
									 ;";					
					mysql_query($mean_insert_sql);				 				 
					
				}
				// end insert statistic values
				switch ($g_level_type) {
					case 1:
						$level_detial_sql = "SELECT * FROM g_level_detail WHERE g_level_type_id = $g_level_type;";
						$level_detial_query = mysql_query($level_detial_sql);
						
						$min_a = $mean_value+((0.15*$k_value)*$sd_value);
						$min_a = round($min_a);						
						$min_b_p = $mean_value+((0.1*$k_value)*$sd_value);
						$min_b_p = round($min_b_p);
						$min_b = $mean_value+((0.05*$k_value)*$sd_value);
						$min_b = round($min_b);
						$min_c_p = $mean_value;
						$min_c_p = round($min_c_p);
						$min_c = $mean_value-((0.05*$k_value)*$sd_value);
						$min_c = round($min_c);
						$min_d_p = $mean_value-((0.1*$k_value)*$sd_value);
						$min_d_p = round($min_d_p);
						$min_d = $mean_value-((0.15*$k_value)*$sd_value);
						$min_d = round($min_d);
						
						$max_b_p = $min_a -1;
						$max_b = $min_b_p -1;
						$max_c_p = $min_b -1;
						$max_c = $min_c_p -1;
						$max_d_p = $min_c -1;
						$max_d = $min_d_p -1;
						$max_f = $min_d -1;
						
						$max = array(1 => 100, $max_b_p, $max_b, $max_c_p, $max_c, $max_d_p, $max_d, $max_f);
						//print_r($max);
						$min = array(1 => $min_a, $min_b_p, $min_b, $min_c_p, $min_c, $min_d_p, $min_d, 0);
						//print_r($min);
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
						//$max = array(1 => 100, 79, 69, 59, 49);
						//$min = array(1 => 80, 70, 60, 50, 0);
						
						$min_a = $mean_value+((0.15*$k_value)*$sd_value);
						$min_a = round($min_a);						
						$min_b = $mean_value+((0.05*$k_value)*$sd_value);
						$min_b = round($min_b);
						$min_c = $mean_value-((0.05*$k_value)*$sd_value);
						$min_c = round($min_c);
						$min_d = $mean_value-((0.15*$k_value)*$sd_value);
						$min_d = round($min_d);
						
						$max_b = $min_a -1;
						$max_c = $min_b -1;
						$max_d = $min_c -1;
						$max_f = $min_d -1;
						
						$max = array(1 => 100, $max_b, $max_c, $max_d, $max_f);
						//print_r($max);
						$min = array(1 => $min_a, $min_b, $min_c, $min_d, 0);
						//print_r($min);
						
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
		}
	
	} else {
		echo "This condition'd already exist.";
	}
}
?>
