<?
require("../include/global_login.php");
require('../filemanager.inc.php'); /* for clr_dir() and preImportCallBack and dirsize() */
require('pclzip.lib.php');	  /* zip class */ 
function delete_files($target, $exceptions, $output=true)
	{
	   $sourcedir = opendir($target);
	   while(false !== ($filename = readdir($sourcedir)))
	   {
		   if(!in_array($filename, $exceptions))
		   {
			//   if($output)
			  // { echo "Processing: ".$target."/".$filename."<br>"; }
			   if(is_dir($target."/".$filename))
			   {
				   // recurse subdirectory; call of function recursive
				   delete_files($target."/".$filename, $exceptions);
			   }
			   else if(is_file($target."/".$filename))
			   {
				   // unlink file
				   unlink($target."/".$filename);
			   }
		   }
	   }
	   closedir($sourcedir);
	  @ rmdir($target);
	}
$newfile_name=strtolower($file_name);
$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
$newfile_name=str_replace(".php",".html",$newfile_name);
$newfile_name=str_replace(".cgi",".html",$newfile_name);
$newfile_name=str_replace(".pl",".html",$newfile_name);
$newfile_name=str_replace(".phtml",".html",$newfile_name);
$newfile_name=str_replace(".shtml",".html",$newfile_name);
$newfile_name=str_replace("'","&#039;",$newfile_name);
//echo $rename;
if($rename ==1){
	if($file=="" ){
		$sql=mysql_query("UPDATE resources set new_window ='$file_target' WHERE id =$id");
	}else{ 
		$allpath =$realpath."/files/resources_files/".$id;
		$exceptions = array(".", "..");
		delete_files($allpath, $exceptions, true);
		
		mkdir($allpath,0777);
		chmod($allpath,0777);
		copy($file,$allpath."/".$newfile_name);	
		$zipfile = $allpath."/".$newfile_name;	
		$import_path = $allpath;
		$archive = new PclZip($zipfile);
			
		if ($archive->extract(	PCLZIP_OPT_PATH,	$import_path) == 0) 
		{
				echo 'Cannot extract to $import_path';
				exit;
		}
		unlink($zipfile);
		
		$sql=mysql_query("SELECT index_name FROM resources WHERE id=$id");
			$index_name=mysql_result($sql,0,'index_name');
			$dir=opendir($allpath);
			$i=0;
			while(($data=readdir($dir)) != false){
				if ($data != "." && $data != "..") { 
					if(is_file($allpath."/".$index_name))
						$i++;
				}
			}

			if($i ==0){
					//$java="yes";
					print( "<script language=javascript> alert(\"Can't find indexname in zip file. Please check your zip file and tryagin\");</script>");
					print( "<script language=javascript> document.location='edit.php?courses=$courses&modules=$modules&id=$id&folder=true&action=edit'; </script>");
			}else{
					$java="no";
					mysql_query("UPDATE resources SET file='$newfile_name' WHERE id =$id ");
			}

		
	}//end if file
} /*  end update*/else {
		if($id==0){
			$sql="INSERT INTO resources (name,index_name,folder,modules,refid,file,courses,new_window,users,time) values('".str_replace("'","&#039;",$name)."','".str_replace("'","&#039;",$index)."',0,$modules,$refid,'$newfile_name','$courses','$file_target',".$person["id"].",".time().");";
			$data_sql=mysql_query($sql);
			$id=mysql_insert_id();
			$allpath=$realpath."/files/resources_files/".$id;
			mkdir($allpath,0777);
			chmod($allpath,0777);
			copy($file,$allpath."/".$newfile_name);	
			$zipfile = $allpath."/".$newfile_name;	
			$import_path = $allpath;
			$archive = new PclZip($zipfile);
			
			if ($archive->extract(	PCLZIP_OPT_PATH,	$import_path) == 0) 
			{
					echo 'Cannot extract to $import_path';
					exit;
				}
			unlink($zipfile);
			
		//	$exceptions = array(".", "..");
		//	delete_files($allpath, $exceptions, true);

			$sql=mysql_query("SELECT index_name FROM resources WHERE id=$id");
			$index_name=mysql_result($sql,0,'index_name');
			$dir=opendir($allpath);
			$i=0;
			while(($data=readdir($dir)) != false){
				if ($data != "." && $data != "..") { 
					if(is_file($allpath."/".$index_name))
						$i++;
				}
			}

			if($i ==0){
					$java="yes";
					$exceptions = array(".", "..");
					delete_files($allpath, $exceptions, true);
					mysql_query("DELETE FROM resources WHERE id=$id");
					//print( "<script language=javascript> alert(\"wwwwwwwww\");</script>");
					//print( "<script language=javascript>
			}else{
					$java="no";
			}

		}//else{
		//}  //end if $id==0;
	
}	//end insert 		


header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules&courses=$courses&folderid=$id&java=$java");
?>

