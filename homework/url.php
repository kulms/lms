<? require("../include/global_login.php");
  	 if($filetype == ""){    $filetype=0;    }	
	 if($id==0)
  	 {        if(trim($score)!="" && trim($score)!=none )
	           {
		           mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,url,users,time,points) values('$name',0,$modules,$sendtype,$filetype,$filesize,'$url',".$person["id"].",".time().",".trim($score).");");
			   }else{  
				           mysql_query("INSERT INTO homework (name,text,modules,sendtype,filetype,filesize,url,users,time) values('$name',0,$modules,$sendtype,$filetype,$filesize,'$url',".$person["id"].",".time().");");
 			            }
				  $id=mysql_insert_id();
	 }else{   $rs=mysql_query("SELECT * FROM homework WHERE id=$id;");
			      $r=mysql_fetch_array($rs);
		          if(trim($score)!="" && trim($score)!=none && trim($score)!=$r["points"])
				 {            mysql_query("UPDATE homework SET url='$url', sendtype=$sendtype,points=".trim($score).", time=".time().", filetype=$filetype, filesize=$filesize WHERE id=$id;");
				 }else{
                               mysql_query("UPDATE homework SET url='$url', sendtype=$sendtype, time=".time().", filetype=$filetype, filesize=$filesize WHERE id=$id;");
						 }
			  }  
	mysql_query("UPDATE modules SET updated=".time().",  updated_users=".$person["id"].",
	                         sendtype=$sendtype WHERE id=$modules;");
    header("Status: 302 Moved Temporarily");
	header("Location: index.php?id=$modules&courses=$courses;");
	if ($sendtype == 3)
	{			exec("rm -R -f $realpath/files/homework/ansfiles/$id");
				$allpath=$realpath."/files/homework/ansfiles/".$id;
/*- - -COMMENT AT 1 April 03 - - -
// mkdir($allpath,0711);
// chmod($allpath,0711);     */
				mkdir($allpath,0777);
				chmod($allpath,0777);
	}     ?>