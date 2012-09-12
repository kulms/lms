<?php 
if ($permission_id == 0){
	//echo "insert";	
	switch ($permission_grant_on) {							
		case 0:
			$super 	 = 0;
			$courses = 0;
			$dms 	 = 0; 			
			$mdata 	 = 0; 
			$system  = 0;
			$users   = 0;
			break;
		case 1:
			$super 	 = 1;
			$courses = 0;
			$dms 	 = 0; 			
			$mdata 	 = 0; 
			$system  = 0;
			$users   = 0;						
			break;
		case 2:
			$super 	 = 0;
			$courses = 1;
			$dms 	 = 0; 			
			$mdata 	 = 0; 
			$system  = 0;
			$users   = 0;
			break;
		case 3:
			$super 	 = 0;
			$courses = 0;
			$dms 	 = 1; 			
			$mdata 	 = 0; 
			$system  = 0;
			$users   = 0;
			break;
		case 4:
			$super 	 = 0;
			$courses = 0;
			$dms 	 = 0; 			
			$mdata 	 = 1; 
			$system  = 0;
			$users   = 0;
			break;
		case 5:
			$super 	 = 0;
			$courses = 0;
			$dms 	 = 0; 			
			$mdata 	 = 0; 
			$system  = 1;
			$users   = 0;
			break;			
		case 6:
			$super 	 = 0;
			$courses = 0;
			$dms 	 = 0; 			
			$mdata 	 = 0; 
			$system  = 0;
			$users   = 1;
			break;				
	}
		
	$permission = new Permission('', $users_id, $courses, $dms, $system, $mdata, $users, $super);
	/*
	echo "Admin Users : ".$permission->getSysAdminUsers()."<br>";
	echo "Admin Super : ".$permission->getSysAdminSuper()."<br>";
	echo "Admin Courses : ".$permission->getSysAdminCourses()."<br>";
	echo "Admin DMS : ".$permission->getSysAdminDms()."<br>";
	echo "Admin MData : ".$permission->getSysAdminMData()."<br>";
	echo "Admin System : ".$permission->getSysAdminSystem()."<br>";
	*/
	if($permission->checkAdmin($users_id)) {
		$permission->create($permission);
	} else {
		print( "<script language=javascript> alert(\"Permission has not been added  \\nUser did not ADMIN !!!.\"); </script>");
	}
	
} else {
	$permission = Permission::lookupPermission($users_id);					
	if ($del == 1) {					
		//echo "del";
		switch ($permission_grant_on) {									
			case 1:
				$permission->sys_padmin_super   = 0;			
				break;
			case 2:
				$permission->sys_padmin_courses = 0;
				break;
			case 3:
				$permission->sys_padmin_dms 	= 0; 			
				break;
			case 4:
				$permission->sys_padmin_mdata 	= 0; 
				break;
			case 5:
				$permission->sys_padmin_system  = 0;
				break;			
			case 6:
				$permission->sys_padmin_users   = 0;
				break;				
		}
		if($permission->checkAdmin($users_id)) {
			$permission->update($permission);
		} else {
			print( "<script language=javascript> alert(\"Permission has not been added  \\nUser did not ADMIN !!!.\"); </script>");
		}	
	} else {
		//echo "update";
		switch ($permission_grant_on) {									
			case 1:
				$permission->sys_padmin_super   = 1;			
				break;
			case 2:
				$permission->sys_padmin_courses = 1;
				break;
			case 3:
				$permission->sys_padmin_dms 	= 1; 			
				break;
			case 4:
				$permission->sys_padmin_mdata 	= 1; 
				break;
			case 5:
				$permission->sys_padmin_system  = 1;
				break;			
			case 6:
				$permission->sys_padmin_users  = 1;
				break;				
		}
		if($permission->checkAdmin($users_id)) {
			$permission->update($permission);
		} else {
			print( "<script language=javascript> alert(\"Permission has not been added  \\nUser did not ADMIN !!!.\"); </script>");
		}	
	} // end if del		
} // end if permission id
?>