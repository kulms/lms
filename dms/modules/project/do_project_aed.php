<?php 
/*
$project = new Project('', $user->getUserId(), $project_advisor_id, $project_co1_name, $project_co2_name, $project_co3_name, $project_co4_name, 
						$project_co5_name, $project_name_th, $project_name_eng, $project_year, $project_encourage, $project_budget, 
						$project_reward1, $project_reward2, $project_no, $project_isbn, $project_abstract, $project_picture, 
						$project_keyword1, $project_keyword2, $project_keyword3, $project_keyword4, $project_keyword5
						);
*/
//echo $project->getProjectOwner()."<br>";												
//echo $project->getProjectNameTh()."<br>";
//echo $project->getProjectNameEng()."<br>";

if ($project_id == ''){
	$project = new Project('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), $project_advisor, $project_co1_name, $project_co2_name, $project_co3_name, $project_co4_name, 
						$project_co5_name, $project_name_th, $project_name_eng, $project_year, $project_encourage, $project_budget, 
						$project_reward1, $project_reward2, $project_no, $project_isbn, $project_abstract_name, $project_picture, $project_full_name,
						$project_keyword1, $project_keyword2, $project_keyword3, $project_keyword4, $project_keyword5
						);

	$project->create($project);
	$id = mysql_insert_id();
	$project->log_insert($id, $user->getUserId());	
	//echo $id;
	
	// upload Abstract	
	if(trim($project_abstract)!="") {
	$allpath=$realpath."/files/dms/project/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($project_abstract)=="" ||  $project_abstract == none)
		 {					
		 }
		 else
			{ // User input project abstract
				 if(strtolower($project_abstract_type)=="application/pdf" || strtolower($project_abstract_type)=="application/msword")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['project_abstract']['tmp_name'], "$allpath/$project_abstract_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
							}
						else
							print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");					
				} // check type file
				else
				{ 
					print( "<script language=javascript> alert(\"Wrong type of Research.\"); </script>");	  
				}
			}
	}
	// end upload abstract
	
	// upload Full	
	if(trim($project_full)!="") {
	$allpath=$realpath."/files/dms/full_project/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($project_full)=="" ||  $project_full == none)
		 {					
		 }
		 else
			{ // User input project abstract
				 if(strtolower($project_full_type)=="application/pdf" || strtolower($project_full_type)=="application/msword")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['project_full']['tmp_name'], "$allpath/$project_full_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
							}
						else
							print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");					
				} // check type file
				else
				{ 
					print( "<script language=javascript> alert(\"Wrong type of Research.\"); </script>");	  
				}
			}
	}
	// end upload abstract
} else {
	//echo $project_abstract."<br>"; 
	//echo $project_picture."<br>"; 
	if ($file_a == 1) {	
	//echo "1<br>";
	$project = new Project($project_id, $project_owner_id, $project_owner_name, $project_advisor, $project_co1_name, $project_co2_name, $project_co3_name, $project_co4_name, 
						$project_co5_name, $project_name_th, $project_name_eng, $project_year, $project_encourage, $project_budget, 
						$project_reward1, $project_reward2, $project_no, $project_isbn, $project_abstract_name, $project_picture, $project_full, 
						$project_keyword1, $project_keyword2, $project_keyword3, $project_keyword4, $project_keyword5
						);
	} else {
		if ($file_f == 1) {	
		//echo "1<br>";
		$project = new Project($project_id, $project_owner_id, $project_owner_name, $project_advisor, $project_co1_name, $project_co2_name, $project_co3_name, $project_co4_name, 
							$project_co5_name, $project_name_th, $project_name_eng, $project_year, $project_encourage, $project_budget, 
							$project_reward1, $project_reward2, $project_no, $project_isbn, $project_abstract, $project_picture, $project_full_name, 
							$project_keyword1, $project_keyword2, $project_keyword3, $project_keyword4, $project_keyword5
							);
		} else {
			$project = new Project( $project_id, $project_owner_id, $project_owner_name, $project_advisor, $project_co1_name, $project_co2_name, $project_co3_name, $project_co4_name, 
								$project_co5_name, $project_name_th, $project_name_eng, $project_year, $project_encourage, $project_budget, 
								$project_reward1, $project_reward2, $project_no, $project_isbn, $project_abstract, $project_picture, $project_full, 
								$project_keyword1, $project_keyword2, $project_keyword3, $project_keyword4, $project_keyword5
								);
	}
	//echo $project->getProjectId()."<br>";
	if ($del == 1) {
		//echo "del record";
		$id = $project->getProjectId();
		$owner = $user->getUserId();
		
		$project->del($project);
		$project->log_del($id,$owner);
	} else {
		$project->update($project);
		$project->log_update($project);
		//echo "edit record";	
		//echo $project->getProjectId()."<br>";
		//echo $project->getProjectAbstract()."<br>";
		//echo $project->getProjectOwnerName()."<br>";
		
		$project2 = Project::lookupProject($project_id);
					
		// upload Abstract	
		if($file_a == 1) {
		$allpath=$realpath."/files/dms/project/".$project->getProjectId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($project_abstract)=="" ||  $project_abstract == none)
			 {					
			 }
			 else
				{ // User input project abstract
					 if(strtolower($project_abstract_type)=="application/pdf" || strtolower($project_abstract_type)=="application/msword")
					 {					 	
						if($project2->getProjectId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['project_abstract']['tmp_name'], "$allpath/$project_abstract_name"))
								{
									//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload syllabus file. Try again.\"); </script>");
						}			   			
						else
						{	if($project2->getProjectAbstract()!="" && $project2->getProjectAbstract()!=none)
							{	
								if(file_exists($allpath."/".$project2->getProjectAbstract()))
								{	
									//print($allpath."/".$project2->getProjectAbstract());
									unlink($allpath."/".$project2->getProjectAbstract());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['project_abstract']['tmp_name'], "$allpath/$project_abstract_name"))
									{
										//echo $allpath."/".$project_abstract_name;
										//echo "copy";																				
									} // end if copy
							
						} // end else
						print( "<script language=javascript> alert(\"Completely Update.....\"); </script>");						
					} // check type file
					else
					{ 
						print( "<script language=javascript> alert(\"Wrong type of Project.\"); </script>");	  
					}
				}
			}			
			
			// upload Full			
			if($file_f == 1) {
			$allpath=$realpath."/files/dms/full_project/".$project->getProjectId();
			if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
				 if(trim($project_full)=="" ||  $project_full == none)
				 {					
				 }
				 else
					{ // User input project abstract
						 if(strtolower($project_full_type)=="application/pdf" || strtolower($project_full_type)=="application/msword")
						 {					 	
							if($project2->getProjectId()==0)
							{   
								if(move_uploaded_file($HTTP_POST_FILES['project_full']['tmp_name'], "$allpath/$project_full_name"))
									{
										//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
										print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
									}
								else
									print( "<script language=javascript> alert(\"Can not upload syllabus file. Try again.\"); </script>");
							}			   			
							else
							{	if($project2->getProjectFull()!="" && $project2->getProjectFull()!=none)
								{	
									if(file_exists($allpath."/".$project2->getProjectFull()))
									{	
										//print($allpath."/".$project2->getProjectAbstract());
										unlink($allpath."/".$project2->getProjectFull());
									 }
								}
										if(move_uploaded_file($HTTP_POST_FILES['project_full']['tmp_name'], "$allpath/$project_full_name"))
										{
											//echo $allpath."/".$project_abstract_name;
											//echo "copy";																				
										} // end if copy
								
							} // end else
							print( "<script language=javascript> alert(\"Completely Update.....\"); </script>");						
						} // check type file
						else
						{ 
							print( "<script language=javascript> alert(\"Wrong type of Project.\"); </script>");	  
						}
					}
				}
				//end upload full
				
				}
		}
}	
?>