<? 
require("../include/global_login.php");
require("../include/getsize.php");
require("../filemanager.inc.php");

$filepath = "/data/httpd_course/files/";

function delete_files($target, $exceptions, $output=true)
	{
	   $sourcedir = opendir($target);
	   while(false !== ($filename = readdir($sourcedir)))
	   {
		   if(!in_array($filename, $exceptions))
		   {
			   if(is_dir($target."/".$filename))
			   {
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
	   rmdir($target);
	}

//$get_file = mysql_query("SELECT id, file from resources WHERE modules=$modules AND users=".$person["id"].";");
if ($courses != 0) {
	$get_file = mysql_query("SELECT id, file,index_name from resources WHERE courses=$courses AND LENGTH(file) != 0 AND users=".$person["id"].";");	
} else {
	$get_file = mysql_query("SELECT id, file,index_name from resources WHERE courses=0 AND LENGTH(file) != 0 AND users=".$person["id"].";");
}

$sum_filesize = 0;
while ($row_file=mysql_fetch_array($get_file)){
	if($row_file["index_name"]=="" || $row_file["index_name"]==null){
		//$sum_filesize = (filesize("../files/resources_files/".$row_file["id"]."/".$row_file["file"])) + $sum_filesize;	
	}else{
	   $allpath = "../files/resources_files/".$row_file["id"] ;	
	   //$sum_filesize=dirsize($allpath);
	}
}

//echo GetSize ($sum_filesize);
if ($courses!=0) {
	$q = mysql_query("SELECT quota FROM courses WHERE id=$courses;");
	$row_q = mysql_fetch_array($q);
	$quota = ($row_q["quota"])*1024*1024;
	if ($quota >= $sum_filesize) {
		$check = true;
	} else {
		$check = false;
		$check_after = false;
	}
	
} else {
	$quota = ($person["quota"])*1024*1024;
	if ($quota >= $sum_filesize) {
		$check = true;
	} else {
		$check = false;
		$check_after = false;
	}
}

if ($check=true) {
	$newfile_name=strtolower($file_name);
	$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
	$newfile_name=str_replace(".php",".html",$newfile_name);
	$newfile_name=str_replace(".cgi",".html",$newfile_name);
	$newfile_name=str_replace(".pl",".html",$newfile_name);
	$newfile_name=str_replace(".phtml",".html",$newfile_name);
	$newfile_name=str_replace(".shtml",".html",$newfile_name);
	$newfile_name=str_replace("'","&#039;",$newfile_name);
	
	if($id==0){	
		//insert
		if ($courses!=0) {
		mysql_query("INSERT INTO resources (name,folder,modules,refid,file,courses,new_window,users,time) values('".str_replace("'","&#039;",$name)."',0,$modules,$refid,'$newfile_name','$courses','$file_target',".$person["id"].",".time().");");
		$id=mysql_insert_id();
		}else {
			mysql_query("INSERT INTO resources (name,folder,modules,refid,file,new_window,users,time) values('".str_replace("'","&#039;",$name)."',0,$modules,$refid,'$newfile_name','$file_target',".$person["id"].",".time().");");
			$id=mysql_insert_id();
		}

			//exec("rm -R -f $realpath/files/resources_files/$id");
			//$allpath=$realpath."/files/resources_files/".$person["id"]."/";

			$allpath=$filepath."/resources_files/".$person["id"]."/";
			if(!(@opendir($allpath))) mkdir ("$allpath", 0777);			
			//$allpath=$realpath."/files/resources_files/".$person["id"]."/".$id;		
			$allpath=$filepath."/resources_files/".$person["id"]."/".$id;
			if(!(@opendir($allpath))) mkdir ("$allpath", 0777);			
			//mkdir($allpath,0777);
			chmod($allpath,0777);
			copy($file,$allpath."/".$newfile_name);
			mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");

			 //$sum_filesize = (filesize("../files/resources_files/".$id."/".$newfile_name)) + $sum_filesize;

			if ($quota >= $sum_filesize) {
				$check_after = true;
			} else {
				$check_after = false;
				mysql_query("DELETE FROM resources WHERE id=$id AND modules=$modules;");
				//exec("rm -R -f $realpath/files/resources_files/$id");
				$exceptions = array(".", "..");
				delete_files($allpath, $exceptions, true);
			}

	}else{
		//update
		if($file==""){
			mysql_query("UPDATE resources set  new_window='$file_target' WHERE id=$id;");
			$check_after = true;
		}else{
			//$allpath =$realpath."/files/resources_files/".$person["id"]."/".$id;
			$allpath =$filepath."/resources_files/".$person["id"]."/".$id;
			$exceptions = array(".", "..");
			delete_files($allpath, $exceptions, true);
			
			//$allpath=$realpath."/files/resources_files/".$person["id"]."/";
			$allpath=$filepath."/resources_files/".$person["id"]."/";
			if(!(@opendir($allpath))) mkdir ("$allpath", 0777);			
			//$allpath=$realpath."/files/resources_files/".$person["id"]."/".$id;		
			$allpath=$filepath."/resources_files/".$person["id"]."/".$id;		
			if(!(@opendir($allpath))) mkdir ("$allpath", 0777);			
			
			//mkdir($allpath,0777);
			chmod($allpath,0777);
			copy($file,$allpath."/".$newfile_name);
			
			if ($quota >= $sum_filesize) {
				$check_after = true;
				mysql_query("UPDATE resources SET file='$newfile_name',new_window='$file_target' WHERE id =$id ");
			} else {
				$check_after = false;
				mysql_query("DELETE FROM resources WHERE id=$id_up AND modules=$modules;");

				$exceptions = array(".", "..");
				delete_files($allpath, $exceptions, true);
			}//end if		
		}
	} //end update
} //end if $check=true

?>

<? if ($check_after == true) { ?>
	<meta http-equiv="refresh" content="0;url=index.php?id=<? echo $modules;?>&courses=<? echo $courses?>">
<? } else {?>
<table width="500" align="center">
  <tr> 
    <td colspan="2"><div align="center"><font color="#FF0000" size="4">Your Quota 
        was insufficient.</font></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">
	<form>
        <div align="center">
          <input type="button" name="Submit2" value="Back" onClick="{location='index.php?id=<?echo $modules?>&courses=<? echo $courses?>';}" class="button">
        </div>
      </form>
	</td>
  </tr>
</table>
<? } ?>



