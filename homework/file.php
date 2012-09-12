<?    	
		require("../include/global_login.php");
		if($filetype == ""){    $filetype=0;    }
		if($filesize == ""){    $filesize=0;    }
	    $newfile_name=strtolower($file_name);
		$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
		$newfile_name=str_replace(".php",".htm",$newfile_name);
		$newfile_name=str_replace(".cgi",".htm",$newfile_name);
		$newfile_name=str_replace(".pl",".htm",$newfile_name);
		$newfile_name=str_replace(".phtml",".htm",$newfile_name);
		$newfile_name=str_replace(".shtml",".htm",$newfile_name);
		$newfile_name=str_replace("'","&#039;",$newfile_name);
		
		if ($_FILES['file']['size'] > (2*1024*1024)) { 						
			print( "<script language=javascript> alert(\"File upload too exceed.\"); </script>");
			print( "<script language=javascript> document.location='edit.php?courses=$courses&id=$id&modules=$modules'; </script>");
			exit;
		} 
		
		
if($id==0)
{ 	   if(trim($score)!="" && trim($score)!=none )
	   {
		   		 mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,file,users,time,points) values('".str_replace("'","&#039;",$name)."',0,$modules,$sendtype,$filetype,$filesize,'$newfile_name',".$person["id"].",".time().",".trim($score).");");
	   }else{  
				    mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,file,users,time) values('".str_replace("'","&#039;",$name)."',0,$modules,$sendtype,$filetype,$filesize,'$newfile_name',".$person["id"].",".time().");");
				}
     $id=mysql_insert_id();
}else{    
			$rs=mysql_query("SELECT * FROM homework WHERE id=$id;");
			$r=mysql_fetch_array($rs);				
            mysql_query("UPDATE homework set text=0, time=".time().", file='$newfile_name', filetype=$filetype, filesize=$filesize WHERE id=$id;");
			//$sql = "UPDATE homework set text=0, time=".time().", file='$newfile_name', filetype=$filetype, filesize=$filesize WHERE id=$id;";
			//echo $sql;
}
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

if(copy($file,$allpath."/".$newfile_name))
{   
	mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
}
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules&courses=$courses");
?>