<?
		$advisor_course = new Advisor_Course('', 'Advisor', -1, '', $user->getUserId(), '', '', 
					  '', 0, 0, 100, 
					  '', '', '', '', 1
					  );
		if($user->getCategory()==2){
			if($advisor_course->checkCreate($user->getUserId())) {
				//$advisor_course->SelectAdvisorCourse($user->getUserId());
				
				$sql = mysql_query("SELECT * FROM courses WHERE users=".$user->getUserId()." AND advisor = 1;");
				$result = mysql_fetch_array($sql);
				$ac_id = $result["id"];
				
				//$ac_id = $advisor_course->getAdvisorCourseId();
				//echo $ac_id;			
			} else {
				//echo "not found";
				$advisor_course->create($advisor_course);
				$ac_id = mysql_insert_id();
				mysql_query("INSERT INTO wp (courses,users,admin) values($ac_id,".$user->getUserId().",'1');");							
				//echo $ac_id;
				mysql_query("INSERT INTO modules (name,modules_type,users,updated,created,active) values('Webboard',4,".$user->getUserId().",".time().",".time().",1);");
				$modules=mysql_insert_id();
				mysql_query("INSERT INTO wp (courses,modules,folders,cases,groups,users) values($ac_id,".$modules.",0,0,0,".$user->getUserId().");");							
			}
		}
?>