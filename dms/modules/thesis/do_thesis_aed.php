<?php 
/*
$thesis = new Thesis('', $user->getUserId(), $thesis_advisor_id, $thesis_co1_name, $thesis_co2_name, $thesis_co3_name, $thesis_co4_name, 
						$thesis_co5_name, $thesis_name_th, $thesis_name_eng, $thesis_year, $thesis_encourage, $thesis_budget, 
						$thesis_reward1, $thesis_reward2, $thesis_no, $thesis_isbn, $thesis_abstract, $thesis_picture, 
						$thesis_keyword1, $thesis_keyword2, $thesis_keyword3, $thesis_keyword4, $thesis_keyword5
						);
*/
//echo $thesis->getThesisOwner()."<br>";												
//echo $thesis->getThesisNameTh()."<br>";
//echo $thesis->getThesisNameEng()."<br>";

if ($thesis_id == ''){
	$thesis = new Thesis('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), $thesis_advisor, $thesis_co1_name, $thesis_co2_name, $thesis_co3_name, $thesis_co4_name, 
						$thesis_co5_name, $thesis_name_th, $thesis_name_eng, $thesis_year, $thesis_encourage, $thesis_type, $thesis_budget, 
						$thesis_reward1, $thesis_reward2, $thesis_no, $thesis_isbn, $thesis_abstract_name, $thesis_picture, $thesis_full_name, 
						$thesis_keyword1, $thesis_keyword2, $thesis_keyword3, $thesis_keyword4, $thesis_keyword5
						);

	$thesis->create($thesis);
	$id = mysql_insert_id();
	$thesis->log_insert($id, $user->getUserId());
	//echo $thesis_abstract_type;	
	//echo $id;
	
	// upload Abstract	
	if(trim($thesis_abstract)!="") {
	$allpath=$realpath."/files/dms/thesis/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($thesis_abstract)=="" ||  $thesis_abstract == none)
		 {					
		 }
		 else
			{ // User input thesis abstract
			//echo $thesis_abstract_type;
			
				 if(strtolower($thesis_abstract_type)=="application/pdf" || strtolower($thesis_abstract_type)=="application/msword")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['thesis_abstract']['tmp_name'], "$allpath/$thesis_abstract_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
							}
						else
							print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");					
				} // check type file
				else
				{ 
					print( "<script language=javascript> alert(\"Wrong type of Thesis.\"); </script>");	  
				}
				
			}			
	}
	// end upload abstract
	// upload Full	
	if(trim($thesis_full)!="") {
	$allpath=$realpath."/files/dms/full_thesis/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($thesis_full)=="" ||  $thesis_full == none)
		 {					
		 }
		 else
			{ // User input thesis abstract
			//echo $thesis_abstract_type;
			
				 if(strtolower($thesis_full_type)=="application/pdf" || strtolower($thesis_full_type)=="application/msword")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['thesis_full']['tmp_name'], "$allpath/$thesis_full_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
							}
						else
							print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");					
				} // check type file
				else
				{ 
					print( "<script language=javascript> alert(\"Wrong type of Thesis.\"); </script>");	  
				}
				
			}			
	}
	// end upload full
	
} else {
	//echo $thesis_abstract."<br>"; 
	//echo $thesis_picture."<br>"; 
	if ($file_a == 1) {	
	
	$thesis = new Thesis($thesis_id, $thesis_owner_id, $thesis_owner_name, $thesis_advisor, $thesis_co1_name, $thesis_co2_name, $thesis_co3_name, $thesis_co4_name, 
						$thesis_co5_name, $thesis_name_th, $thesis_name_eng, $thesis_year, $thesis_encourage, $thesis_type, $thesis_budget, 
						$thesis_reward1, $thesis_reward2, $thesis_no, $thesis_isbn, $thesis_abstract_name, $thesis_picture, $thesis_full, 
						$thesis_keyword1, $thesis_keyword2, $thesis_keyword3, $thesis_keyword4, $thesis_keyword5
						);

	} else {
		if ($file_f == 1) {	
		
			$thesis = new Thesis($thesis_id, $thesis_owner_id, $thesis_owner_name, $thesis_advisor, $thesis_co1_name, $thesis_co2_name, $thesis_co3_name, $thesis_co4_name, 
								$thesis_co5_name, $thesis_name_th, $thesis_name_eng, $thesis_year, $thesis_encourage, $thesis_type, $thesis_budget, 
								$thesis_reward1, $thesis_reward2, $thesis_no, $thesis_isbn, $thesis_abstract, $thesis_picture, $thesis_full_name, 
								$thesis_keyword1, $thesis_keyword2, $thesis_keyword3, $thesis_keyword4, $thesis_keyword5
								);

		} else {
				//echo "hi";
				$thesis = new Thesis($thesis_id, $thesis_owner_id, $thesis_owner_name, $thesis_advisor, $thesis_co1_name, $thesis_co2_name, $thesis_co3_name, $thesis_co4_name, 
									$thesis_co5_name, $thesis_name_th, $thesis_name_eng, $thesis_year, $thesis_encourage, $thesis_type, $thesis_budget, 
									$thesis_reward1, $thesis_reward2, $thesis_no, $thesis_isbn, $thesis_abstract, $thesis_picture, $thesis_full, 
									$thesis_keyword1, $thesis_keyword2, $thesis_keyword3, $thesis_keyword4, $thesis_keyword5
									);
		}					
	}					
	//echo $thesis->getThesisId()."<br>";
	//echo $thesis->getThesisOwnerName()."<br>";
	if ($del == 1) {
		//echo "del record";
		$id = $thesis->getThesisId();
		$owner = $user->getUserId();
				
		$thesis->del($thesis);
		$thesis->log_del($id,$owner);
	} else {
		
		$thesis->update($thesis);
		$thesis->log_update($thesis);
		
		//echo "edit record";	
		//echo $thesis->getThesisId()."<br>";
		//echo $thesis->getThesisAbstract()."<br>";
		//echo $thesis->getThesisNameEng()."<br>";
		
		$thesis2 = Thesis::lookupThesis($thesis_id);
					
		// upload Abstract	
		if($file_a == 1) {
		$allpath=$realpath."/files/dms/thesis/".$thesis->getThesisId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($thesis_abstract)=="" ||  $thesis_abstract == none)
			 {					
			 }
			 else
				{ // User input project abstract
					 if(strtolower($thesis_abstract_type)=="application/pdf" || strtolower($thesis_abstract_type)=="application/msword")
					 {					 	
						if($thesis2->getThesisId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['thesis_abstract']['tmp_name'], "$allpath/$thesis_abstract_name"))
								{
									//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload syllabus file. Try again.\"); </script>");
						}			   			
						else
						{	if($thesis2->getThesisAbstract()!="" && $thesis2->getThesisAbstract()!=none)
							{	
								if(file_exists($allpath."/".$thesis2->getThesisAbstract()))
								{	
									//print($allpath."/".$thesis2->getThesisAbstract());
									unlink($allpath."/".$thesis2->getThesisAbstract());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['thesis_abstract']['tmp_name'], "$allpath/$thesis_abstract_name"))
									{
										//echo $allpath."/".$thesis_abstract_name;
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
		// end upload abstract
		// upload full	
		if($file_f == 1) {
		$allpath=$realpath."/files/dms/full_thesis/".$thesis->getThesisId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($thesis_full)=="" ||  $thesis_full == none)
			 {					
			 }
			 else
				{ // User input project full
					 if(strtolower($thesis_full_type)=="application/pdf" || strtolower($thesis_full_type)=="application/msword")
					 {					 	
						if($thesis2->getThesisId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['thesis_full']['tmp_name'], "$allpath/$thesis_full_name"))
								{
									//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload syllabus file. Try again.\"); </script>");
						}			   			
						else
						{	if($thesis2->getThesisFull()!="" && $thesis2->getThesisFull()!=none)
							{	
								if(file_exists($allpath."/".$thesis2->getThesisFull()))
								{	
									//print($allpath."/".$thesis2->getThesisAbstract());
									unlink($allpath."/".$thesis2->getThesisFull());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['thesis_full']['tmp_name'], "$allpath/$thesis_full_name"))
									{
										//echo $allpath."/".$thesis_abstract_name;
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
		// end upload abstract		
	}
}	
?>