<?php 
if ($users_id == ''){
	$users = new Users('', $users_active, $users_login, $users_password, 
					    $users_firstname, $users_surname, $users_email, $users_homepage, 
					    $users_category, $users_title, $users_email2, 
					    $users_id_number, $users_admin
					   );
					   
	if($users->lookupUsersName($users_login)){		
		$users->create($users);
		echo "<script language=\"javascript\">
		alert(\"UserName added successful.\");
		</script>";		
		$id = mysql_insert_id();
	} else {
		echo "<script language=\"javascript\">
		alert(\"UserName has already existed.\");
		</script>";
	}		
	//echo $id;			
} else {
	
	$users = new Users($users_id, $users_active, $users_login, $users_password, 
				   $users_firstname, $users_surname, $users_email, $users_homepage, 
				   $users_category, $users_title, $users_email2, 
				   $users_id_number, $users_admin
				);
		
	if ($del == 1) {
		//echo "del record";				
		$users->del($users);
		//$research->log_del($id,$owner);
	} else {
		$users->update($users);
		//$research->log_update($research);
		//echo "edit record"."<br>";	
		//echo $research->getResearchId()."<br>";
		//echo $research->getResearchAbstract()."<br>";
		//echo $research->getResearchNameEng()."<br>";
							
	} // end if del
} // end if users id	
?>