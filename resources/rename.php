<? require("../include/global_login.php");
	if ($Rename=1) 
	{
		if($zip==1){

			//check foldername
			$dir=opendir($allpath);
			$allpath =$realpath."/files/resources_files/".$id;
			$i=0;
			while(($data=readdir($dir)) != false){
				if ($data != "." && $data != "..") { 
					if(is_file($allpath."/".$index))
						$i++;
				}
			}

			if($i ==0){
				print( "<script language=javascript> alert(\"Can't find indexname in zip file. Please check your zip file and tryagin\");</script>");
				print( "<script language=javascript> document.location='edit.php?courses=$courses&modules=$modules&id=$id&folder=true&action=edit'; </script>");
				//header("Status: 302 Moved Temporarily");
				//header("Location: edit.php?modules=$modules&courses=$courses&id=$id&folder=true&action=edit");
			}else{
					$java="no";
					$sql=mysql_query("UPDATE resources set name='$name',index_name='$index' WHERE id=$id AND modules=$modules");
					$sql = mysql_query("SELECT * FROM resources WHERE ref_res=$id;");
					if ((mysql_num_rows($sql)) != 0) {
						mysql_query("UPDATE resources set time=".time()." WHERE ref_res=$id;");
					}
					header("Status: 302 Moved Temporarily");
					header("Location: index.php?id=$modules&courses=$courses");
			}
		}else{
			mysql_query("UPDATE resources set name='$name' WHERE id=$id AND modules=$modules;");
			$sql = mysql_query("SELECT * FROM resources WHERE ref_res=$id;");
			if ((mysql_num_rows($sql)) != 0) {
				mysql_query("UPDATE resources set name='$name', time=".time()." WHERE ref_res=$id;");
			}
		header("Status: 302 Moved Temporarily");
		header("Location: index.php?id=$modules&courses=$courses");
		}
	
	}else {
		header("Status: 302 Moved Temporarily");
		header("Location: pub_course.php?id=$modules&courses=$courses");
	}

?>
