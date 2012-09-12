<?php
require ("../include/global_login.php");

if($add_member){ // not have in classlist
	
	$sec = str_replace(" ", "", $sec);
	$array = explode(",", $sec);
	if(count($array) > 1)
	{
		$str = "(";
		for($i=0; $i < count($array); $i++) 
		{
			if ($i !=0 ) {
				$str .=  " OR LC_SECTION = ".$array[$i];
			} else {
				$str .=  "LC_SECTION = ".$array[$i];
			}
		}
		$str .= ")";			
	} else {
		$str = "LC_SECTION = ".$array[0];
	}
			
		
	if($students != ""){

		for($i=0; $i < count($students); $i++) 
		{				
			$sql_student = mysql_query("SELECT distinct * FROM ku_student WHERE STD_ID = $students[$i]");	

			$insert_class = "INSERT INTO ku_classlist (STD_ID, SM_SEM, SM_YR, RG_TYPE, CS_CODE, LC_SECTION, LC_CREDIT, LB_SECTION, LB_CREDIT, TT_CREDIT) 
							 VALUES (".$students[$i].", ".$semester.", ".$year.", '".$rg_type[$i]."', '".$name."', '".$lc_section[$i]."', ".$lc_credit[$i].", '".$lb_section[$i]."',".$lb_credit[$i].", ".$tt_credit[$i].");"; 
			//echo $insert_class."<br>";
			mysql_query($insert_class);

			if($idcode[$i] == ""){
				$idcode = 0;
			} else {
				$idcode = $idcode[$i];
			}			
			if (mysql_num_rows($sql_student) == 0) {
				$insert_student = "INSERT INTO ku_student (STD_ID, STD_TITLE, STD_NAME, STD_SURNAME, MAJOR_ID, ADVISOR_ID, CAMPUS_ID, STD_SEX, IDCODE) 
								   VALUES (".$students[$i].", '".$std_title[$i]."', '".$std_name[$i]."', '".$std_surname[$i]."', '".$major_id[$i]."', '".$advisor_id[$i]."', '".$campus_id[$i]."', '".$std_sex[$i]."',".$idcode.");"; 
				//echo $insert_student."<br>";
				mysql_query($insert_student);
			} else {
				echo "Already add in ku_student... "."<br>";				
			}
			
			$check_ex=mysql_query("SELECT id FROM users WHERE login like '".$login[$i]."';");
			if(mysql_num_rows($check_ex)==0){
									
				$ins = "INSERT INTO users (active,login,title,firstname,surname,password,category,email) 
						VALUES (1,'".$login[$i]."','".$std_title[$i]."','".$std_name[$i]."','".$std_surname[$i]."',
						'asd323',3,'".$email[$i]."');";						
				echo $ins."<br>";
		  		mysql_query($ins);
				$got_id=mysql_insert_id();
				mysql_query("INSERT INTO users_info(id) values ($got_id);");

				mysql_query("INSERT INTO wp (courses,users) values($courses,$got_id);");
			
			} else {
				$row_user = mysql_fetch_array($check_ex);
				mysql_query("INSERT INTO wp (courses,users) values($courses,".$row_user["id"].");");
			}														
			
		} // end for($i=0; $i < count($students); $i++) 
						
		print( "<meta http-equiv=\"refresh\" content=\"2;url=users.php?courses=$courses\">");
		
	} // end if($students != "")
} // end if($add_member)
else {
	print( "<meta http-equiv=\"refresh\" content=\"0;url=users.php?courses=$courses\">");
}

if($drop_member){ //classlist have in maxlearn delete from maxlearn must delete in classlist and wp

	if($drops != ""){		
	
		$sec= str_replace(" ", "", $sec);
		$array = explode(",", $sec);
		if(count($array) > 1)
		{
			$str = "(";
			for($i=0; $i < count($array); $i++) 
			{
				if ($i !=0 ) {
					if($stype == 1){
						$str .=  " OR LC_SECTION = ".$array[$i];
					} else {
						$str .=  " OR LB_SECTION = ".$array[$i];
					}	
				} else {
					if($stype == 1){
						$str .=  "LC_SECTION = ".$array[$i];
					} else {
						$str .=  "LB_SECTION = ".$array[$i];
					}	
				}
			}
			$str .= ")";			
		} else {
			if($stype == 1){
				$str = "LC_SECTION = ".$array[0];
			} else {
				$str = "LB_SECTION = ".$array[0];
			}
		}
				
			
		while (list($key,$value) = each($drops)) {		

			$gsql2=mysql_query("SELECT distinct * FROM ku_student WHERE STD_ID = $value");
			if(mysql_num_rows($gsql2)==1)
			{
				$row4=mysql_fetch_array($gsql2);
				$major= substr($row4["MAJOR_ID"], 0,1);
				if($major=="X"){$std_title="g";}else{$std_title="b";}
				$s=substr($row4["STD_ID"],0,7);
				$login=$std_title.$s;
				$email=$login."@ku.ac.th";
			}
			$del_classlist = "DELETE FROM ku_classlist WHERE STD_ID = $value AND SM_SEM = $semester AND SM_YR = $year 
							  AND ".$str." AND CS_CODE = '".$name."';"; 
			//echo $del_classlist."<br>";
			mysql_query($del_classlist);
							  
			$search_std = mysql_query("SELECT DISTINCT id
						  FROM  users
						  WHERE login = '".$login."';");
			$r_std = mysql_fetch_array($search_std);			  
			
			$del_wp = "DELETE FROM wp WHERE courses = $courses AND users = ".$r_std["id"].";";
			//echo $del_wp."<br>";
			mysql_query($del_wp);						  								 
			
							  			
		} // end while 
		//echo "<center>Drop Member ...</center>";
		print( "<meta http-equiv=\"refresh\" content=\"2;url=users.php?courses=$courses\">");
	}
} else {
		print( "<meta http-equiv=\"refresh\" content=\"0;url=users.php?courses=$courses\">");
}
?>
