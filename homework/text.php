<?    require("../include/global_login.php");
		if ($sendtype == ""){   $sendtype=0;  }
		if($filetype == ""){    $filetype=0;    }
	   if(trim($score)!="" && trim($score)!=none )
	   {
		   		mysql_query("INSERT INTO homework (name,modules,text,sendtype,filetype,filesize,users,time,points) values('$name',$modules,1,$sendtype,$filetype,filesize,".$person["id"].",".time().",".trim($score).");");
	   }else{  
				   mysql_query("INSERT INTO homework (name,modules,text,sendtype,filetype,filesize,users,time) values('$name',$modules,1,$sendtype,$filetype,filesize,".$person["id"].",".time().");");
				}
		$id=mysql_insert_id();
		mysql_query("UPDATE modules SET updated=".time().", updated_users=".$person["id"]." 
								  WHERE id=$modules;");
		if ($sendtype == 3)
		{   exec("rm -R -f $realpath/files/homework/ansfiles/$id");
			$allpath=$realpath."/files/homework/ansfiles/".$id;
/*- - -COMMENT AT 1 April 03 - - -
// mkdir($allpath,0711);
// chmod($allpath,0711);     */		
			mkdir($allpath,0777);
			chmod($allpath,0777);
		}
		header("Status: 302 Moved Temporarily");
		header("Location: index.php?id=$modules");
?>