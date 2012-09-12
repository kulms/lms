<?    	
		require("../include/global_login.php");
		include("../include/function.inc.php");
		//echo $ans_type."<br>";
		
		if ($ans_type==1){
			mysql_query("UPDATE homework set answer_type=$ans_type, time=".time().", answer='$answer' WHERE id=$id;");
		}
		if ($ans_type==2){
			mysql_query("UPDATE homework set answer_type=$ans_type, time=".time().", answer='$answer' WHERE id=$id;");
		}
		if ($ans_type==3){
			//echo $_FILES['answer']['tmp_name'];
			if($answer != ""){
				$newfile_name=strtolower($_FILES['answer']['name']);
				$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
				$newfile_name=str_replace(".php",".htm",$newfile_name);
				$newfile_name=str_replace(".cgi",".htm",$newfile_name);
				$newfile_name=str_replace(".pl",".htm",$newfile_name);
				$newfile_name=str_replace(".phtml",".htm",$newfile_name);
				$newfile_name=str_replace(".shtml",".htm",$newfile_name);
				$newfile_name=str_replace("'","&#039;",$newfile_name);
				$filename=$newfile_name;
			}else{
				$filename=$old_file;
			}
			mysql_query("UPDATE homework set answer_type=$ans_type, time=".time().", answer='$filename' WHERE id=$id;");
			//exec("rm -R -f $realpath/files/homework/solutions/$id");
			$allpath=$realpath."/files/homework/solutions/".$id;
			if(!(@opendir($allpath))) mkdir ($allpath, 0777);
			chmod($allpath,0777);

			if($answer !=""){
				if(copy($_FILES['answer']['tmp_name'],$allpath."/".$filename))
				{   
					mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
				}
			}
			
		}
		
	

header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules&courses=$courses");
?>