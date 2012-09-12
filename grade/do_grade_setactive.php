<? 


switch ($cmd) {
	case 'setactive':
		$active=1-$setactive;
		if ($active == '') { $active = 0;}
			$sql = "SELECT DISTINCT sl.g_active
										   FROM g_score_level sl, g_eval_type et, g_level_type lt
										   WHERE sl.g_grade_id = ".$grade_id."
										   AND sl.g_eval_type_id = et.g_eval_type_id
										   AND sl.g_level_type_id = lt.g_level_type_id
										   ;";
			$data_sql = mysql_query($sql);
			if(mysql_num_rows($data_sql)==1){
				$sql1="UPDATE g_score_level  SET g_active=".$active." 
							WHERE g_eval_type_id=".$eval_id." AND g_level_type_id=".$level_id." AND g_grade_id = ".$grade_id." ";
				$data_sql1 = mysql_query($sql1);
			}else{
				$sql1="UPDATE g_score_level  SET g_active=0
							WHERE  g_grade_id = ".$grade_id." ";
				$data_sql1 = mysql_query($sql1);
				
				$sql1="UPDATE g_score_level  SET g_active=".$active." 
							WHERE g_eval_type_id=".$eval_id." AND g_level_type_id=".$level_id." AND g_grade_id = ".$grade_id."  ";
				$data_sql1 = mysql_query($sql1);
			}
		break;
		case 'delete':
			$sql="SELECT g_score_level_id 
			FROM g_score_level 
			WHERE g_grade_id=".$grade_id." AND  g_eval_type_id=".$eval_id." AND g_level_type_id=".$level_id." ";
			$result=mysql_query($sql);
			while($rs=mysql_fetch_array($result)){
				//delete g_score_level
				mysql_query("DELETE FROM g_score_level WHERE g_score_level_id=".$rs['g_score_level_id']."");
				//delete g_std_grade
				mysql_query("DELETE FROM g_std_grade WHERE g_score_level_id=".$rs['g_score_level_id']." AND g_grade_id=".$grade_id." ");
			}
		 //delete g_standard_detail
		 mysql_query("DELETE FROM g_standard_detail  WHERE g_grade_id=".$grade_id." AND g_eval_type_id=".$eval_id." AND g_level_type_id=".$level_id." ");

			
		break;
}//end switch
?>