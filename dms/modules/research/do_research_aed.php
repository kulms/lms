<?php 
/*
$research = new Research('', $user->getUserId(), $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
						$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_budget, 
						$research_reward1, $research_reward2, $research_isbn, $research_abstract, $research_picture, 
						$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
						);
*/
//echo $research->getResearchOwner()."<br>";												
//echo $research->getResearchNameTh()."<br>";
//echo $research->getResearchNameEng()."<br>";

if ($research_id == ''){
	$research = new Research('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
						$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_status, $research_budget, 
						$research_reward1, $research_reward2, $research_isbn, $research_abstract_name, $research_picture_name, $research_full_name, 
						$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
						);
	//echo $research_start_date;
	$research->create($research);
	
	$id = mysql_insert_id();	
	$research->log_insert($id, $user->getUserId());
	//echo $id;
	
	// upload Abstract	
	if(trim($research_abstract)!="") {
	$allpath=$realpath."/files/dms/research/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($research_abstract)=="" ||  $research_abstract == none)
		 {					
		 }
		 else
			{ // User input research abstract
				 if(strtolower($research_abstract_type)=="application/pdf" || strtolower($research_abstract_type)=="application/msword")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['research_abstract']['tmp_name'], "$allpath/$research_abstract_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update Abstract File.\"); </script>");
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
	if (trim($research_picture)!="") {
	// echo "upload picture";		
	// upload Picture
	$allpath=$realpath."/files/dms/picture/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($research_picture)=="" ||  $research_picture == none)
		 {					
		 }
		 else
			{ // User input research abstract
				 if(strtolower($research_picture_type)=="image/gif" || strtolower($research_picture_type)=="image/jpeg" || strtolower($research_picture_type)=="image/pjpeg" || strtolower($research_picture_type)=="image/png")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['research_picture']['tmp_name'], "$allpath/$research_picture_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update Picture File.\"); </script>");
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
	// upload Full File	
	if(trim($research_full)!="") {
	$allpath=$realpath."/files/dms/full_research/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($research_full)=="" ||  $research_full == none)
		 {					
		 }
		 else
			{ // User input research abstract
				 if(strtolower($research_full_type)=="application/pdf" || strtolower($research_full_type)=="application/msword")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['research_full']['tmp_name'], "$allpath/$research_full_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update Full File.\"); </script>");
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
	// end upload Full File					
	
} else {
	//echo $research_abstract."<br>"; 
	//echo $research_picture."<br>"; 
	if ($file_a == 1) {	
	
	$research = new Research($research_id, $research_owner_id, $research_owner_name, $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
						$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_status, $research_budget, 
						$research_reward1, $research_reward2, $research_isbn, $research_abstract_name, $research_picture, $research_full,
						$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
						);
	} else {
		if ($file_p == 1) {
		
		$research = new Research($research_id, $research_owner_id, $research_owner_name, $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
						$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_status, $research_budget, 
						$research_reward1, $research_reward2, $research_isbn, $research_abstract, $research_picture_name, $research_full,
						$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
						);			
		} else {
		
			if ($file_f == 1) {

			$research = new Research($research_id, $research_owner_id, $research_owner_name, $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
						$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_status, $research_budget, 
						$research_reward1, $research_reward2, $research_isbn, $research_abstract, $research_picture, $research_full_name,
						$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
						);			
			} else {
			
				$research = new Research($research_id, $research_owner_id, $research_owner_name, $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
							$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_status, $research_budget, 
							$research_reward1, $research_reward2, $research_isbn, $research_abstract, $research_picture, $research_full,
							$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
							);
			}
		}	
	}					
	
	//$research = Research::lookupResearch($research_id);					
	//echo $research->getResearchId()."<br>";
	if ($del == 1) {
		//echo "del record";
		$id = $research->getResearchId();
		$owner = $user->getUserId();
		
		$research->del($research);
		$research->log_del($id,$owner);
	} else {
		$research->update($research);
		$research->log_update($research);
		//echo "edit record"."<br>";	
		//echo $research->getResearchId()."<br>";
		//echo $research->getResearchAbstract()."<br>";
		//echo $research->getResearchNameEng()."<br>";
		$research2 = Research::lookupResearch($research_id);
					
		// upload Abstract	
		if($file_a == 1) {
		$allpath=$realpath."/files/dms/research/".$research->getResearchId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($research_abstract)=="" ||  $research_abstract == none)
			 {					
			 }
			 else
				{ // User input research abstract
					 if(strtolower($research_abstract_type)=="application/pdf" || strtolower($research_abstract_type)=="application/msword")
					 {					 	
						if($research2->getResearchId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['research_abstract']['tmp_name'], "$allpath/$research_abstract_name"))
								{
									//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");
						}			   			
						else
						{	if($research2->getResearchAbstract()!="" && $research2->getResearchAbstract()!=none)
							{	
								if(file_exists($allpath."/".$research2->getResearchAbstract()))
								{	
									//print($allpath."/".$research2->getResearchAbstract());
									unlink($allpath."/".$research2->getResearchAbstract());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['research_abstract']['tmp_name'], "$allpath/$research_abstract_name"))
									{
										//echo $allpath."/".$research_abstract_name;
										//echo "copy";																				
									} // end if copy
							
						} // end else
						print( "<script language=javascript> alert(\"Completely Update.....\"); </script>");						
					} // check type file
					else
					{ 
						print( "<script language=javascript> alert(\"Wrong type of Research.\"); </script>");	  
					}
				}
		}
		if ($file_p == 1) {
		// echo "upload picture";		
		// upload Picture
		$allpath=$realpath."/files/dms/picture/".$research->getResearchId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($research_picture)=="" ||  $research_picture == none)
			 {					
			 }
			 else
				{ // User input research abstract
					 if(strtolower($research_picture_type)=="image/gif" || strtolower($research_picture_type)=="image/jpeg" || strtolower($research_picture_type)=="image/pjpeg" || strtolower($research_picture_type)=="image/png")
					 {					 	
						if($research2->getResearchId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['research_picture']['tmp_name'], "$allpath/$research_picture_name"))
								{
									//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");
						}			   			
						else
						{	if($research2->getResearchAbstract()!="" && $research2->getResearchAbstract()!=none)
							{	
								if(file_exists($allpath."/".$research2->getResearchPicture()))
								{	
									//print($allpath."/".$research2->getResearchPicture());
									unlink($allpath."/".$research2->getResearchPicture());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['research_picture']['tmp_name'], "$allpath/$research_picture_name"))
									{
										//echo "copy";																				
									} // end if copy
							
						} // end else
						print( "<script language=javascript> alert(\"Completely Update.....\"); </script>");						
					} // check type file
					else
					{ 
						print( "<script language=javascript> alert(\"Wrong type of Research.\"); </script>");	  
					}
				}
			}
			
		if($file_f == 1) {
		$allpath=$realpath."/files/dms/full_research/".$research->getResearchId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($research_full)=="" ||  $research_full == none)
			 {					
			 }
			 else
				{ // User input research full file
					 if(strtolower($research_full_type)=="application/pdf" || strtolower($research_full_type)=="application/msword")
					 {					 	
						if($research2->getResearchId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['research_full']['tmp_name'], "$allpath/$research_full_name"))
								{									
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");
						}			   			
						else
						{	if($research2->getResearchFull()!="" && $research2->getResearchFull()!=none)
							{	
								if(file_exists($allpath."/".$research2->getResearchFull()))
								{	
									unlink($allpath."/".$research2->getResearchFull());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['research_full']['tmp_name'], "$allpath/$research_full_name"))
									{
										//echo $allpath."/".$research_abstract_name;
										//echo "copy";																				
									} // end if copy
							
						} // end else
						print( "<script language=javascript> alert(\"Completely Update.....\"); </script>");						
					} // check type file
					else
					{ 
						print( "<script language=javascript> alert(\"Wrong type of Research.\"); </script>");	  
					}
				}
		}					
							
	} // end if del
} // end if research id	
?>