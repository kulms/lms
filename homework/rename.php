<?    require("../include/global_login.php");
		 include("../include/function.inc.php");
			 //Courses_id
			$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
			//echo "SELECT courses FROM wp WHERE modules=".$modules.";";
			$courses=mysql_result($courseid,0,"courses");
		//***********insert modules_history***************
			$action="Edit question";
			Imodules_h($modules,$action,$person["id"],$courses);		

	//	if ($sendtype == ""){   
	//		$sendtype=0;  
	//	}
	//	if ($sendtype2 != ""){   
	//		$sendtype=$sendtype2;  
	//	}
	//	if ($sendtype3 != ""){   
	//		$sendtype=$sendtype3;  
	//	}
		
		//echo $url;
		//echo $sendtype;
		if($filetype == ""){   $filetype=0;    }
		if($filesize == ""){    $filesize=0;    }
		
	//	echo $q_type;
		if($q_type1 !=""){
			$q_type=$q_type1;
		}
	/*	if(trim($score)!="" && trim($score)!=none)
		{   
		//	echo "UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', 
		//		 		time=".time().",sendtype=$sendtype, points=$score, filetype=$filetype, filesize=$filesize WHERE id=$id AND modules=$modules;";
			mysql_query("UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', 
				 		time=".time().",sendtype=$sendtype, points=$score, filetype=$filetype, filesize=$filesize,url=$url WHERE id=$id AND modules=$modules;");
		}else{ 
			//echo "UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', 
		//				time=".time().",sendtype=$sendtype, filetype=$filetype, filesize=$filesize WHERE id=$id AND modules=$modules;";
			mysql_query("UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', 
						time=".time().",sendtype=$sendtype, filetype=$filetype, filesize=$filesize,url=$url WHERE id=$id AND modules=$modules;");
		}
	*/
		//	header("Status: 302 Moved Temporarily");
	//		header("Location: index.php?id=$modules&courses=$courses");

	switch ($q_type){
		case 1:
			if ($sendtype == ""){   
				$sendtype=0;  
			}
			if ($sendtype2 != ""){   
				$sendtype=$sendtype2;  
			}
			if(trim($score)!="" && trim($score)!=none){
				$sql="UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', time=".time().",sendtype=$sendtype, points=$score, filetype=$filetype, filesize=$filesize,text=1 WHERE id=$id AND modules=$modules " ;
			}else{
				$sql="UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', time=".time().",sendtype=$sendtype,filetype=$filetype, filesize=$filesize,text=1 WHERE id=$id AND modules=$modules " ;
			}
			mysql_query($sql);
			if ($sendtype == 3)
				{      
					//exec("rm -R -f $realpath/files/homework/ansfiles/$id");
					$allpath=$realpath."/files/homework/ansfiles/".$id;
					if(!(@opendir($allpath))) mkdir ($allpath, 0777);
					chmod($allpath,0777);
				}
		//	exec("rm -R -f $realpath/files/homework/files/$id");
		//	$allpath=$realpath."/files/homework/files/".$id;
		//	if(!(@opendir($allpath))) mkdir ($allpath, 0777);
	//			chmod($allpath,0777);
		//	if(copy($file,$allpath."/".$filename))
		//	{   
				mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
		//	}
		break;
		case 2:    //insert url
			if ($sendtype == ""){   
				$sendtype=0;  
			}
			if ($sendtype != ""){   
				$sendtype2=$sendtype;  
			}
			if(trim($score)!="" && trim($score)!=none){
				$sql="UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', time=".time().",sendtype=$sendtype2, points=$score, filetype=$filetype, filesize=$filesize,url='$url',text=0 WHERE id=$id AND modules=$modules " ;
			}else{
				$sql="UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', time=".time().",sendtype=$sendtype2,filetype=$filetype, filesize=$filesize,url='$url',text=0 WHERE id=$id AND modules=$modules " ;
			}
			mysql_query($sql);
			mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
			if ($sendtype == 3)
				{      
					//exec("rm -R -f $realpath/files/homework/ansfiles/$id");
					$allpath=$realpath."/files/homework/ansfiles/".$id;
					if(!(@opendir($allpath))) mkdir ($allpath, 0777);
					chmod($allpath,0777);
				}
		break;
		case 3: // file
			if($sendtype == ""){   $sendtype=0;  }
			if($filetype == ""){    $filetype=0;    }
			if($filesize == ""){    $filesize=0;    }
			if ($sendtype == ""){   
				$sendtype=0;  
			}
			if ($sendtype2 != ""){   
				$sendtype=$sendtype2;  
			}
	
			//echo "dd".$xxx;
		//	echo $modules;
			//echo $file;
			/*if($file != ""){
				$old_file=$file;
				if ($_FILES['file']['size'] > (2*1024*1024)) { 						
					print( "<script language=javascript> alert(\"File upload too exceed.\"); </script>");
					print( "<script language=javascript> document.location='edit.php?courses=$courses&id=$id&modules=$modules'; </script>");
					exit;
				} 
			}*/
			//echo $old_file."<br>"
			if($file != ""){
				$newfile_name=strtolower($file_name);
				$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
				$newfile_name=str_replace(".php",".htm",$newfile_name);
				$newfile_name=str_replace(".cgi",".htm",$newfile_name);
				$newfile_name=str_replace(".pl",".htm",$newfile_name);
				$newfile_name=str_replace(".phtml",".htm",$newfile_name);
				$newfile_name=str_replace(".shtml",".htm",$newfile_name);
				$newfile_name=str_replace("'","&#039;",$newfile_name);
				$filename=$newfile_name;
				if ($_FILES['file']['size'] > (2*1024*1024)) { 						
					print( "<script language=javascript> alert(\"File upload too exceed.\"); </script>");
					print( "<script language=javascript> document.location='edit.php?courses=$courses&id=$id&modules=$modules'; </script>");
					exit;
				} 
			}else{
				$filename=$old_file;
			}
			if(trim($score)!="" && trim($score)!=none){
				$sql="UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', time=".time().",sendtype=$sendtype, points=$score, filetype=$filetype, filesize=$filesize,url='$url',file='$filename',text=0 WHERE id=$id AND modules=$modules " ;
			}else{
				$sql="UPDATE homework set name='".addslashes(str_replace("'","&#039;",$name))."', time=".time().",sendtype=$sendtype,filetype=$filetype, filesize=$filesize,url='$url',file='$filename',text=0 WHERE id=$id AND modules=$modules " ;
			}
			mysql_query($sql);
				if ($sendtype == 3)
				{      
					//exec("rm -R -f $realpath/files/homework/ansfiles/$id");
					$allpath=$realpath."/files/homework/ansfiles/".$id;
					if(!(@opendir($allpath))) mkdir ($allpath, 0777);
					chmod($allpath,0777);
				}
				//exec("rm -R -f $realpath/files/homework/files/$id");
				$allpath=$realpath."/files/homework/files/".$id;
				if(!(@opendir($allpath))) mkdir ($allpath, 0777);
				chmod($allpath,0777);
				if($file !=""){
					if(copy($_FILES['file']['tmp_name'],$allpath."/".$filename))
					{   
						mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
					}
				}
		break; //end clase 3
	}
	header("Status: 302 Moved Temporarily");
	header("Location: index.php?id=$modules&courses=$courses");
/*	if ($sendtype == 3)
		{      
			exec("rm -R -f $realpath/files/homework/ansfiles/$id");
			$allpath=$realpath."/files/homework/ansfiles/".$id;
			if(!(@opendir($allpath))) mkdir ($allpath, 0777);
			chmod($allpath,0777);
		}
		exec("rm -R -f $realpath/files/homework/files/$id");
		$allpath=$realpath."/files/homework/files/".$id;
		if(!(@opendir($allpath))) mkdir ($allpath, 0777);
		chmod($allpath,0777);
		
		if(copy($file,$allpath."/".$newfile_name))
		{   
			mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
		}*/
	
?>