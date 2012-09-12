<?php    
require("../include/global_login.php");
include("../include/function.inc.php");
$server_path="/data/httpd_course";
echo $question_type."<--";
			$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
			$courses=mysql_result($courseid,0,"courses");
	 		//***********insert modules_history***************
			$action="Add question";
			Imodules_h($modules,$action,$person["id"],$courses);	
	if ($question_type=="text") {
		if ($sendtype == ""){   $sendtype=0;  }
		if($filetype == ""){    $filetype=0;    }
		if($filesize == ""){    $filesize=0;    }
		if(trim($score)!="" && trim($score)!=none )
		{
			//echo "INSERT INTO homework (name,modules,text,sendtype,filetype,filesize,users,time,points) values('$name',$modules,1,$sendtype,$filetype,$filesize,".$person["id"].",".time().",".trim($score).");";
			mysql_query("INSERT INTO homework (name,modules,text,sendtype,filetype,filesize,users,time,points) values('$name',$modules,1,$sendtype,$filetype,$filesize,".$person["id"].",".time().",".trim($score).");");
		}else{  
			//echo "INSERT INTO homework (name,modules,text,sendtype,filetype,filesize,users,time) values('$name',$modules,1,$sendtype,$filetype,filesize,".$person["id"].",".time().");";
			mysql_query("INSERT INTO homework (name,modules,text,sendtype,filetype,filesize,users,time) values('$name',$modules,1,$sendtype,$filetype,$filesize,".$person["id"].",".time().");");
		}
		$id=mysql_insert_id();
		mysql_query("UPDATE modules SET updated=".time().", updated_users=".$person["id"]." 
								  WHERE id=$modules;");
		if ($sendtype == 3)
		{  
			//exec("rm -R -f $realpath['/files/homework/ansfiles/$id");
			//$allpath=$realpath."/files/homework/ansfiles/".$id;	
			$allpath=$server_path."/files/homework/ansfiles/".$id;	
			mkdir($allpath,0777);
			chmod($allpath,0777);
		}
		//header("Status: 302 Moved Temporarily");
		//header("Location: index.php?id=$modules");
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?id=$modules\"/>";
	}
	
	if ($question_type=="url") {
		$textURL=explode("//",$url);
	//	if($textURL[1]==""){
		//	$Ass=$HTTP_COOKIE_VARS['Ass'];
		//	print( "<script language=javascript> alert(\"Empty URL Name !!!\"); </script>");
	//		print( "<script language=javascript> document.location='edit.php?id=0&modules=$modules&add=1&Ass=$Ass'; </script>");
	//		exit;
	//	}else{
		if($filetype == ""){    $filetype=0;    }
		if ($sendtype == ""){   $sendtype=0;  }
		if($filesize == ""){    $filesize=0;    }	
		if($id==0)
		{        
		 	if(trim($score)!="" && trim($score)!=none )
			{	//echo "INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,url,users,time,points) values('$name',0,$modules,$sendtype,$filetype,$filesize,'$url',".$person["id"].",".time().",".trim($score).");";
				mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,url,users,time,points) values('$name',0,$modules,$sendtype,$filetype,$filesize,'$url',".$person["id"].",".time().",".trim($score).");");
			}else{  
				//echo "INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,url,users,time) values('$name',0,$modules,$sendtype,$filetype,$filesize,'$url',".$person["id"].",".time().");";
				mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,url,users,time) values('$name',0,$modules,$sendtype,$filetype,$filesize,'$url',".$person["id"].",".time().");");				
			}
			$id=mysql_insert_id();


		}else{   
			$rs=mysql_query("SELECT * FROM homework WHERE id=$id;");
			$r=mysql_fetch_array($rs);
			if(trim($score)!="" && trim($score)!=none && trim($score)!=$r["points"])
			{            
				mysql_query("UPDATE homework SET url='$url', sendtype=$sendtype,points=".trim($score).", time=".time().", filetype=$filetype, filesize=$filesize WHERE id=$id;");
			}else{
				mysql_query("UPDATE homework SET url='$url', sendtype=$sendtype, time=".time().", filetype=$filetype, filesize=$filesize WHERE id=$id;");
			}
		}  
		mysql_query("UPDATE modules SET updated=".time().",  updated_users=".$person["id"].",
								 sendtype=$sendtype WHERE id=$modules;");
		if ($sendtype == 3)
		{			
					//exec("rm -R -f $realpath/files/homework/ansfiles/$id");
					$allpath=$realpath."/files/homework/ansfiles/".$id;
					mkdir($allpath,0777);
					chmod($allpath,0777);
		} 
		//header("Status: 302 Moved Temporarily");
		//header("Location: index.php?id=$modules&courses=$courses;");	
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?id=$modules&courses=$courses\"/>";
//		}
	}
	
	if ($question_type=="file") {
		if($sendtype == ""){   $sendtype=0;  }
		if($filetype == ""){    $filetype=0;    }
		if($filesize == ""){    $filesize=0;    }
		//echo $file."<br>";
		//echo $file_name."<br>";
	    $newfile_name=strtolower($file_name);
		$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
		$newfile_name=str_replace(".php",".htm",$newfile_name);
		$newfile_name=str_replace(".cgi",".htm",$newfile_name);
		$newfile_name=str_replace(".pl",".htm",$newfile_name);
		$newfile_name=str_replace(".phtml",".htm",$newfile_name);
		$newfile_name=str_replace(".shtml",".htm",$newfile_name);
		$newfile_name=str_replace("'","&#039;",$newfile_name);
		//echo $newfile_name;
		if ($_FILES['file']['size'] > (2*1024*1024)) { 						
			print( "<script language=javascript> alert(\"File upload too exceed.\"); </script>");
			print( "<script language=javascript> document.location='edit.php?courses=$courses&id=$id&modules=$modules'; </script>");
			exit;
		} 
		
		if($id==0)
		{ 	   
			if(trim($score)!="" && trim($score)!=none )
			{	//echo "INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,file,users,time,points) values('".str_replace("'","&#039;",$name)."',0,$modules,$sendtype,$filetype,$filesize,'$newfile_name',".$person["id"].",".time().",".trim($score).");";
				mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,file,users,time,points) values('".str_replace("'","&#039;",$name)."',0,$modules,$sendtype,$filetype,$filesize,'$newfile_name',".$person["id"].",".time().",".trim($score).");");
			}else{  
				//echo "INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,file,users,time) values('".str_replace("'","&#039;",$name)."',0,$modules,$sendtype,$filetype,$filesize,'$newfile_name',".$person["id"].",".time().");";
				mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,file,users,time) values('".str_replace("'","&#039;",$name)."',0,$modules,$sendtype,$filetype,$filesize,'$newfile_name',".$person["id"].",".time().");");
			}
			$id=mysql_insert_id();
		}else{    
			$rs=mysql_query("SELECT * FROM homework WHERE id=$id;");
			$r=mysql_fetch_array($rs);				
			mysql_query("UPDATE homework set text=0, time=".time().", file='$newfile_name', filetype=$filetype, filesize=$filesize WHERE id=$id;");
		}
		if ($sendtype == 3)
		{      
			//exec("rm -R -f $realpath/files/homework/ansfiles/$id");
			$allpath=$server_path."/files/homework/ansfiles/".$id;
			if(!(@opendir($allpath))) mkdir ($allpath, 0777);
			chmod($allpath,0777);
		}
		//exec("rm -R -f $realpath/files/homework/files/$id");
		$allpath=$server_path."/files/homework/files/".$id;
		if(!(@opendir($allpath))) mkdir ($allpath, 0777);
		chmod($allpath,0777);
		
		if(copy($file,$allpath."/".$newfile_name))
		{   
			mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
		}
		//header("Status: 302 Moved Temporarily");
		//header("Location: index.php?id=$modules&courses=$courses");
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?id=$modules&courses=$courses\" />";

	}		
?>