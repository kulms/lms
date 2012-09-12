<?
 
require("../include/global_login.php");
require('filemanager.inc.php'); /* for clr_dir() and preImportCallBack and dirsize() */
require('pclzip.lib.php');	  /* zip class */ 

if($rename ==1){
	mysql_query("UPDATE resources_center set index_name='$index' WHERE id=$id;");
} else {

		$newfile_name=strtolower($file_name);
		$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
		$newfile_name=str_replace(".php",".html",$newfile_name);
		$newfile_name=str_replace(".cgi",".html",$newfile_name);
		$newfile_name=str_replace(".pl",".html",$newfile_name);
		$newfile_name=str_replace(".phtml",".html",$newfile_name);
		$newfile_name=str_replace(".shtml",".html",$newfile_name);
		$newfile_name=str_replace("'","&#039;",$newfile_name);
		
		if($id==0){
			mysql_query("INSERT INTO resources_center (name,index_name,folder,refid,faculty,department,major,file,users,time) 
						 VALUES('".str_replace("'","&#039;",$name)."','".$index."',0,$refid,'$fac','$dept','$major','$newfile_name',".$person["id"].",".time().");");
			$id=mysql_insert_id();
		}else{
			mysql_query("UPDATE resources_center set file='$newfile_name' WHERE id=$id;");
		}
		exec("rm -R -f $realpath/files/resources_center_files/$id");
		$allpath=$realpath."/files/resources_center_files/".$id;
		mkdir($allpath,0777);
		chmod($allpath,0777);
		copy($file,$allpath."/".$newfile_name);	
			
			$zipfile = $allpath."/".$newfile_name;	
			//echo $zipfile;
			//	exec("pkunzip -d -o ".$zipfile." ".$allpath);	
		
			//$import_path .= $cid.'/';
			
			$import_path = $allpath;
			
			/*
				if (!is_dir($import_path)) {
					if (!@mkdir($import_path, 0700)) {
						echo 'Cannot make import for a course directory.';
						exit;
					}
				}
			*/	
				
			/* extract the entire archive into $allpath */
			
			//$archive = new PclZip($_FILES['file']['tmp_name']);
			$archive = new PclZip($zipfile);
			
			if ($archive->extract(	PCLZIP_OPT_PATH,	$import_path) == 0) 
			{
				echo 'Cannot extract to $import_path';
				//clr_dir($import_path);
				exit;
			}
			
			unlink($zipfile);
	
}			
			
//mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");

//header("Status: 302 Moved Temporarily");
//header("Location: show_res.php?fac=$fac&dept=$dept&major=$major");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body >
<? 

if ($chk==0) { ?>
	<meta http-equiv="refresh" content="0;url=show_res.php?fac=-1&dept=-1&major=no"><?
} elseif ($chk==1) { ?>
		<meta http-equiv="refresh" content="0;url=show_res.php?fac=<? echo $fac?>&dept=-1&major=no"><? 
	} elseif ($chk==2) { ?>
			<meta http-equiv="refresh" content="0;url=show_res.php?fac=<? echo $fac?>&dept=<? echo $dept?>&major=no"><?
		} elseif ($chk==3) { ?>
				<meta http-equiv="refresh" content="0;url=show_res.php?fac=<? echo $fac?>&dept=<? echo $dept?>&major=<? echo $major?>"> <?				
			} 
?>
</body>
</html>
