<? require("../include/global_login.php");
 include("../include/function.inc.php");

$showassg=mysql_query("SELECT * FROM homework WHERE id=$id;");
$check=mysql_query("SELECT * FROM homework_ans WHERE modules=$modules AND refid=$id AND users=".$person["id"].";");
$server_path="/data/httpd_course";
	//Courses_id
$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
$courses=mysql_result($courseid,0,"courses");
?><? if (mysql_num_rows($check) == 0) {

	//***********insert modules_history***************
	$action="Send";
	Imodules_h($modules,$action,$person["id"],$courses);

 if(mysql_result($showassg,0,"sendtype") == 1)
   {
    mysql_query("INSERT INTO homework_ans (name,refid,modules,text,users,time)
    values('$name',$id,$modules,1,".$person["id"].",".time().");");
    mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
 //   header("Status: 302 Moved Temporarily");
 //   header("Location: index.php?id=$modules");
   }?>

<? if(mysql_result($showassg,0,"sendtype") == 2 )
   {
    mysql_query("INSERT INTO homework_ans (name,refid,text,modules,url,users,time)
    values('$name',$id,0,$modules,'$url',".$person["id"].",".time().");");
    mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
  //  header("Status: 302 Moved Temporarily");
   // header("Location: index.php?id=$modules");
    }
?>

<? if(mysql_result($showassg,0,"sendtype") == 3)
   {
   	switch (mysql_result($showassg,0,"filesize")) {
		case 1:
			$f_size = 100*1024;
			break;
		case 2:
			$f_size = 500*1024;
			break;
		case 3:
			$f_size = 1*1024*1024;
			break;
		case 4:
			$f_size = 1.5*1024*1024;
			break;
		case 5:
			$f_size = 2*1024*1024;
			break;
		case 6:
			$f_size = 10*1024*1024;
			break;
	}
   	if ($_FILES['file']['size'] > $f_size) { 						
			print( "<script language=javascript> alert(\"File upload too exceed.\"); </script>");
			print( "<script language=javascript> document.location='send_form.php?id=$id&modules=$modules'; </script>");
			exit;
	}	
     $newfile_name=strtolower($file_name);
     $newfile_name=strtr($newfile_name,"? ","aaoq_");
     $newfile_name=str_replace(".php",".htm",$newfile_name);
     $newfile_name=str_replace(".cgi",".htm",$newfile_name);
     $newfile_name=str_replace(".html",".htm",$newfile_name);
     $newfile_name=str_replace(".pl",".htm",$newfile_name);
     $newfile_name=str_replace(".phtml",".htm",$newfile_name);
     $newfile_name=str_replace(".shtml",".htm",$newfile_name);
     $newfile_name=str_replace("'","&#039;",$newfile_name);
     $yourlogin=$person["login"];
     $newfile_name=$yourlogin."-".$newfile_name;	
       //        $id=mysql_insert_id();
//         exec("rm -R -f $realpath/homework/ansfiles/$id");
//         $allpath=$realpath."/homework/ansfiles/".$id;
		$ftype = mysql_result($showassg,0,"filetype");
		switch ($ftype) {
		case 1:
			$ftype_name = "gif";
			break;
		case 2:
			$ftype_name = "jpg";
			break;
		case 3:
			$ftype_name = "jpeg";
			break;
		case 4:
			$ftype_name = "png";
			break;
		case 5:
			$ftype_name = "all_image";
			break;
		case 6:
			$ftype_name = "doc";
			break;
		case 7:
			$ftype_name = "pdf";
			break;
		case 8:
			$ftype_name = "all_doc";
			break;
		case 9:
			$ftype_name = "any_type";
			break;								
		}
		
		//echo filesize($file);
		$pos = strrpos($newfile_name, ".");
		$rest = substr($newfile_name, $pos+1);
		
		if(($ftype_name != $rest) && ($ftype_name != "any_type")){
			if($ftype_name == "all_image") {
				if($rest != "gif" && $rest != "jpg" && $rest != "jpeg" && $rest != "png") {
					print( "<script language=javascript> alert(\"Wrong type to send.\"); </script>");
					print( "<script language=javascript> location='index.php?id=$modules'; </script>");
					exit;	
				}			
			}
			if($ftype_name == "all_doc") {
				if($rest != "doc" && $rest != "pdf") {
					print( "<script language=javascript> alert(\"Wrong type to send.\"); </script>");
					print( "<script language=javascript> location='index.php?id=$modules'; </script>");
					exit;
				}
			}
			if($ftype_name != "all_doc" && $ftype_name != "all_image") {
				print( "<script language=javascript> alert(\"Wrong type to send.\"); </script>");
				print( "<script language=javascript> location='index.php?id=$modules'; </script>");
				exit;
			}			
		}		
		
		//if ($rest == "doc") echo "application/msword";
		//if ($rest == "pdf") echo "application/pdf";	
		//if ($rest == "gif") echo "image/gif";
		//if ($rest == "jpg") echo "image/jpg";
		//if ($rest == "jpeg") echo "image/jpeg";
		//if ($rest == "png") echo "image/png";
			
		


	//  $allpath=$realpath."/files/homework/ansfiles/$id";
	  $allpath=$server_path."/files/homework/ansfiles/$id";
	  if(!(@opendir($allpath))) mkdir ($allpath, 0777);
	  //mkdir($allpath,0777);
	  chmod($allpath,0777);

	  if(copy($file,$allpath."/".$newfile_name)){
	  	mysql_query("INSERT INTO homework_ans (name,refid,text,modules,file,users,time) 
	  	values('".str_replace("'","&#039;",$name)."',$id,0,$modules,'$newfile_name',".$person["id"].",".time().");");
	  	mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
	   }
		 
     		//    header("Status: 302 Moved Temporarily");
      		//    header("Location: index.php?id=$modules");
     } //end if send type == 3 
 } // end if $check 
?>
<? if (mysql_num_rows($check) == 1) { 
	//***********insert modules_history***************
	$action="Edit";
	Imodules_h($modules,$action,$person["id"],$courses);	
?>
   <? if(mysql_result($showassg,0,"sendtype") == 1)
      {
        mysql_query("UPDATE homework_ans set name='".str_replace("'","&#039;",$name)."', time=".time()."  WHERE refid=$id AND modules=$modules AND users=".$person["id"].";");
//       header("Status: 302 Moved Temporarily");
//       header("Location: index.php?id=$modules");
      }
?>
<?
   if(mysql_result($showassg,0,"sendtype") == 2 )
   {
    mysql_query("UPDATE homework_ans set url='$url',  time=".time()."  WHERE refid=$id AND modules=$modules AND users=".$person["id"].";");
   }
?>

<? if(mysql_result($showassg,0,"sendtype") == 3)
      {
	  	switch (mysql_result($showassg,0,"filesize")) {
			case 1:
				$f_size = 100*1024;
				break;
			case 2:
				$f_size = 500*1024;
				break;
			case 3:
				$f_size = 1*1024*1024;
				break;
			case 4:
				$f_size = 1.5*1024*1024;
				break;
			case 5:
				$f_size = 2*1024*1024;
				break;
			case 6:
				$f_size = 10*1024*1024;
				break;
		}
	  	if ($_FILES['file']['size'] > $f_size) { 						
			print( "<script language=javascript> alert(\"File upload too exceed.\"); </script>");
			print( "<script language=javascript> document.location='send_form.php?id=$id&modules=$modules'; </script>");
			exit;
		}
        $newfile_name=strtolower($file_name);
        $newfile_name=strtr($newfile_name,"? ","aaoq_");
        $newfile_name=str_replace(".php",".htm",$newfile_name);
        $newfile_name=str_replace(".cgi",".htm",$newfile_name);
        $newfile_name=str_replace(".html",".htm",$newfile_name);
        $newfile_name=str_replace(".pl",".htm",$newfile_name);
        $newfile_name=str_replace(".phtml",".htm",$newfile_name);
        $newfile_name=str_replace(".shtml",".htm",$newfile_name);
        $newfile_name=str_replace("'","&#039;",$newfile_name);
        $yourlogin=$person["login"];
        $newfile_name=$yourlogin."-".$newfile_name;
		
		$ftype = mysql_result($showassg,0,"filetype");
		switch ($ftype) {
		case 1:
			$ftype_name = "gif";
			break;
		case 2:
			$ftype_name = "jpg";
			break;
		case 3:
			$ftype_name = "jpeg";
			break;
		case 4:
			$ftype_name = "png";
			break;
		case 5:
			$ftype_name = "all_image";
			break;
		case 6:
			$ftype_name = "doc";
			break;
		case 7:
			$ftype_name = "pdf";
			break;
		case 8:
			$ftype_name = "all_doc";
			break;							
		case 9:
			$ftype_name = "any_type";
			break;								
		}
		
		
		$pos = strrpos($newfile_name, ".");
		$rest = substr($newfile_name, $pos+1);
		
		if(($ftype_name != $rest) && ($ftype_name != "any_type")){
			if($ftype_name == "all_image") {
				if($rest != "gif" && $rest != "jpg" && $rest != "jpeg" && $rest != "png") {
				print( "<script language=javascript> alert(\"Wrong type to send.\"); </script>");
				print( "<script language=javascript> location='index.php?id=$modules'; </script>");
				exit;	
				}			
			}
			if($ftype_name == "all_doc") {
				if($rest != "doc" && $rest != "pdf") {
					print( "<script language=javascript> alert(\"Wrong type to send.\"); </script>");
					print( "<script language=javascript> location='index.php?id=$modules'; </script>");
					exit;
				}
			}
			if($ftype_name != "all_doc" && $ftype_name != "all_image") {
				print( "<script language=javascript> alert(\"Wrong type to send.\"); </script>");
				print( "<script language=javascript> location='index.php?id=$modules'; </script>");
				exit;
			}			
		}
		

        mysql_query("UPDATE homework_ans set text=0, time=".time().", file='$newfile_name'  WHERE refid=$id AND modules=$modules AND users=".$person["id"].";");
        exec("rm -f $server_path/files/homework/ansfiles/$id/$oldfile");
        $allpath=$server_path."/files/homework/ansfiles/$id";

 	if(copy($file,$allpath."/".$newfile_name)){
        mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
	}

		      //  header("Status: 302 Moved Temporarily");
       // header("Location: index.php?id=$modules");
       }

 }
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="refresh" content="1;url=index.php?id=<?echo $modules ?>">
</head>
<div align="center" class="main">Assignment updated...</div>
</body>
</html>
