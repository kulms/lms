<?
$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses;";
$g_query = mysql_query($g_sql);
$g_result = mysql_fetch_array($g_query);

$cat_lev_sql = "SELECT DISTINCT sl.g_eval_type_id, sl.g_level_type_id, et.g_eval_type_name, lt.g_level_type_name, lt.g_level_type_desc,sl.g_active
									   FROM g_score_level sl, g_eval_type et, g_level_type lt
									   WHERE sl.g_grade_id = ".$g_result["g_grade_id"]."
									   AND sl.g_eval_type_id = et.g_eval_type_id
									   AND sl.g_level_type_id = lt.g_level_type_id AND sl.g_active=1
									   ;";
$cat_lev_query = mysql_query($cat_lev_sql);
$cat_lev_result=@mysql_fetch_array($cat_lev_query);
$cat_name=$cat_lev_result["g_eval_type_name"];
$level_name=$cat_lev_result["g_level_type_name"];


$g_score_level_sql = "SELECT distinct  g_eval_type_id, g_level_type_id 
													 FROM g_score_level 
													 WHERE g_grade_id = ".$g_result["g_grade_id"]."
													  AND g_eval_type_id =".$cat_lev_result["g_eval_type_id"]."
													 AND g_level_type_id =".$cat_lev_result["g_level_type_id"]." ORDER BY g_score_level_id
													 ;";
$g_score_level_query = mysql_query($g_score_level_sql);
$g_score_level_result = mysql_fetch_array($g_score_level_query);

$g_std_grade_sql = "SELECT sg.g_std_users AS std_users, ld.g_level_detail_name AS grade_name, ss.g_std_score_total AS score_total, 
												  u.login, u.title, u.firstname, u.surname,u.id
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
$g_std_grade_query = mysql_query($g_std_grade_sql);	

switch ($action){
	case 'excel' :
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="grade.csv"'); 
		echo "Grade Report : Category Type:".$cat_lev_result["g_eval_type_name"]."    Level Type:(".$cat_lev_result["g_level_type_name"].") \n\n";
		echo "ÅÓ´Ñº,ª×èÍ-¹ÒÁÊ¡ØÅ,¤Ðá¹¹,à¡Ã´\n";
		 $i=1;
		while($row_g_std_grade=@mysql_fetch_array($g_std_grade_query)){
			$title=$row_g_std_grade['title'];
			$Fname=$row_g_std_grade['firstname'];
			$Lname=$row_g_std_grade['surname'];
			$score=$row_g_std_grade['score_total'];
			$grade=$row_g_std_grade['grade_name'];
			echo "$i,$title$Fname   $Lname,$score,$grade\n";
		$i++;
		}
	break;
	case 'xml' :
		header('Content-type: application/xml');
		header('Content-Disposition: attachment; filename="grade.xml"'); 
		$br=chr(10).chr(13);
		$sql_courses=mysql_query("SELECT name FROM courses WHERE id=".$g_courses." ");
		$courses_name=mysql_result($sql_courses,0,'name');
		
		$xml="<?xml version = \"1.0\" encoding =\"UTF-8\"?>".$br;
		$xml=$xml.$br."<Grades Course=\"$courses_name\" Category_type=\"$cat_name\" Level_type=\"$level_name\">".$br;
		while($row_g_std_grade=@mysql_fetch_array($g_std_grade_query)){
			$id=$row_g_std_grade['id'];
			$title=$row_g_std_grade['title'];
			$Fname=$row_g_std_grade['firstname'];
			$Lname=$row_g_std_grade['surname'];
			$score=$row_g_std_grade['score_total'];
			$grade=$row_g_std_grade['grade_name'];
			$xml=$xml.$br."<Student ID=\"$id\" Title=\"$title\" FName=\"$Fname\" LName=\"$Lname\">".$br;
				$xml=$xml.$br."<Score>$score</Score>".$br;
				$xml=$xml.$br."<Grade>$grade</Grade>".$br;
			$xml=$xml.$br."</Student>".$br;
		}
		$xml=$xml.$br."</Grades>".$br;
		echo $xml;
	break;
}
exit;
?>