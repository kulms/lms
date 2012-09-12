<?php 
if ($book_id == ''){
	$book = new Book('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), $book_name_th, $book_name_eng, $book_type, $book_volume, 
				     $book_press, $book_press_country, $book_year, $book_abstract_name, $book_picture_name, $book_isbn, 
				 	 $book_keyword1, $book_keyword2, $book_keyword3, $book_keyword4, $book_keyword5
				 );					
	//echo $book_press;
	//echo $book->getBookPress();
	$book->create($book);
	$id = mysql_insert_id();
	$book->log_insert($id, $user->getUserId());	
	//echo $id;
	
	// upload Abstract	
	if(trim($book_abstract)!="") {
	$allpath=$realpath."/files/dms/book/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($book_abstract)=="" ||  $book_abstract == none)
		 {					
		 }
		 else
			{ // User input book abstract
				 if(strtolower($book_abstract_type)=="application/pdf" || strtolower($book_abstract_type)=="application/msword")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['book_abstract']['tmp_name'], "$allpath/$book_abstract_name"))
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
	if (trim($book_picture)!="") {
	// echo "upload picture";		
	// upload Picture
	$allpath=$realpath."/files/dms/picture_book/".$id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
		 if(trim($book_picture)=="" ||  $book_picture == none)
		 {					
		 }
		 else
			{ // User input book picture
				 if(strtolower($book_picture_type)=="image/gif" || strtolower($book_picture_type)=="image/jpeg" || strtolower($book_picture_type)=="image/pjpeg" || strtolower($book_picture_type)=="image/png")
				 {					 						
						if(move_uploaded_file($HTTP_POST_FILES['book_picture']['tmp_name'], "$allpath/$book_picture_name"))
							{								
								print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
							}
						else
							print( "<script language=javascript> alert(\"Can not upload file. Try again.\"); </script>");					
				} // check type file
				else
				{ 
					print( "<script language=javascript> alert(\"Wrong type of Picture.\"); </script>");	  
				}
			}
		}
} else {
	if ($file_a == 1) {	
		$book = new Book($book_id, $book_owner_id, $book_owner_name, $book_name_th, $book_name_eng, $book_type, $book_volume, 
				 $book_press, $book_press_country, $book_year, $book_abstract_name, $book_picture, $book_isbn, 
				 $book_keyword1, $book_keyword2, $book_keyword3, $book_keyword4, $book_keyword5
			 );
			//echo $book->getBookOwner()."<br>";	 
			//echo $book->getBookOwnerName()."<br>";									 
	} else {
		if ($file_p == 1) {
		//echo "2<br>";
		$book = new Book($book_id, $book_owner_id, $book_owner_name, $book_name_th, $book_name_eng, $book_type, $book_volume, 
				 $book_press, $book_press_country, $book_year, $book_abstract, $book_picture_name, $book_isbn, 
				 $book_keyword1, $book_keyword2, $book_keyword3, $book_keyword4, $book_keyword5
				 );			
			//echo $book->getBookOwner()."<br>";	 
			//echo $book->getBookOwnerName()."<br>";										 
		} else {
		//echo "3<br>";
			//echo $book_owner_name."<br>";
			
			$book = new Book($book_id, $book_owner_id, $book_owner_name, $book_name_th, $book_name_eng, $book_type, $book_volume, 
					 $book_press, $book_press_country, $book_year, $book_abstract, $book_picture, $book_isbn, 
					 $book_keyword1, $book_keyword2, $book_keyword3, $book_keyword4, $book_keyword5
				 );
			//echo $book->getBookOwner()."<br>";	 
			//echo $book->getBookOwnerName()."<br>";								
		}
	}					
	//echo $research->getResearchId()."<br>";	
	if ($del == 1) {
		//echo "del record";
		$id = $book->getBookId();
		$owner = $user->getUserId();
		
		$book->del($book);
		$book->log_del($id,$owner);
	} else {
		$book->update($book);
		$book->log_update($book);
		//echo "edit record";	
		$book2 = Book::lookupBook($book_id);		
		if($file_a == 1) {
		$allpath=$realpath."/files/dms/book/".$book->getBookId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($book_abstract)=="" ||  $book_abstract == none)
			 {					
			 }
			 else
				{ // User input research abstract
					 if(strtolower($book_abstract_type)=="application/pdf" || strtolower($book_abstract_type)=="application/msword")
					 {					 	
						if($book2->getBookId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['book_abstract']['tmp_name'], "$allpath/$book_abstract_name"))
								{
									//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload abstract file. Try again.\"); </script>");
						}			   			
						else
						{	if($book2->getBookAbstract()!="" && $book2->getBookAbstract()!=none)
							{	
								if(file_exists($allpath."/".$book2->getBookAbstract()))
								{	
									//print($allpath."/".$research2->getResearchAbstract());
									unlink($allpath."/".$book2->getBookAbstract());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['book_abstract']['tmp_name'], "$allpath/$book_abstract_name"))
									{
										//echo $allpath."/".$research_abstract_name;
										//echo "copy";																				
									} // end if copy
							
						} // end else
						print( "<script language=javascript> alert(\"Completely Update.....\"); </script>");						
					} // check type file
					else
					{ 
						print( "<script language=javascript> alert(\"Wrong type of Book.\"); </script>");	  
					}
				}
			} // end if file_a
		if($file_p == 1) {
		$allpath=$realpath."/files/dms/picture_book/".$book->getBookId();
		if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
			 if(trim($book_picture)=="" ||  $book_picture == none)
			 {					
			 }
			 else
				{ // User input research abstract
					 if(strtolower($book_picture_type)=="image/gif" || strtolower($book_picture_type)=="image/jpeg" || strtolower($book_picture_type)=="image/pjpeg" || strtolower($book_picture_type)=="image/png")
					 {					 	
						if($book2->getBookId()==0)
						{   
							if(move_uploaded_file($HTTP_POST_FILES['book_picture']['tmp_name'], "$allpath/$book_picture_name"))
								{
									//mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
									print( "<script language=javascript> alert(\"Completely Update.\"); </script>");
								}
							else
								print( "<script language=javascript> alert(\"Can not upload abstract file. Try again.\"); </script>");
						}			   			
						else
						{	if($book2->getBookPicture()!="" && $book2->getBookPicture()!=none)
							{	
								if(file_exists($allpath."/".$book2->getBookPicture()))
								{	
									//print($allpath."/".$research2->getResearchAbstract());
									unlink($allpath."/".$book2->getBookPicture());
								 }
							}
									if(move_uploaded_file($HTTP_POST_FILES['book_picture']['tmp_name'], "$allpath/$book_picture_name"))
									{
										//echo $allpath."/".$research_abstract_name;
										//echo "copy";																				
									} // end if copy
							
						} // end else
						print( "<script language=javascript> alert(\"Completely Update.....\"); </script>");						
					} // check type file
					else
					{ 
						print( "<script language=javascript> alert(\"Wrong type of Book.\"); </script>");	  
					}
				}
			} // end if file_p
		} // end else del != 1			
}	
?>