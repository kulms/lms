<? 
	require("../include/global_login.php");
	//echo "folders : ".$folders."<br>";
	//echo "res_id : ".$res_id."<br>";	
	$have_folder = false;
	//$count = 0;
	if ($folder != "") { 
		$have_folder = true;
		while (list($key,$value) = each($folder)) { 
			//echo "Value Folder : ".$value."<br>";
			$folder_row = intval(substr($value,0,3));
			//echo "folder_row : ".$folder_row."<br>";			
			
			$row_folder = mysql_query("SELECT * FROM resources WHERE id=$folder_row;");
			$get_folder = mysql_fetch_array($row_folder);
			
			//echo "Folder"."<br>";
			//echo "name : ".$get_folder["name"]."<br>";
			//echo "Refid : ".$get_folder["refid"]."<br>";
			if ($get_folder["refid"] != 0) {
				$r_refid = 0;			
			} else {
				$r_refid = $get_folder["refid"];
			}
			//echo "Ref_res : ".$get_folder["ref_res"]."<br>";
			$r_ref_res = $get_folder["id"];
			//echo "Courses : ".$courses."<br>";
			//echo "Modules : ".$modules."<br>";
			//echo "User : ".$user."<br>";

			if ($isedit != 1) {		
			//================================
			 	mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, modules, time,users, public) 
			 								VALUES ('".$get_folder["name"]."', $r_refid, $r_ref_res, 1, $courses, $modules, ".time().", $user, 1);");
				
			} else {
			//================================
				mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, modules, time,users, public) 
			    							VALUES ('".$get_folder["name"]."', $res_id, $r_ref_res, 1, $courses, $modules, ".time().", $user, 1);");
				
			}
			//$count++;
			//$new_folder_id=mysql_insert_id();
			
			/*if ($file != "") {
				while (list($key,$value) = each($file)) {
					list($file_row, $file_row2) = split('/',$value);
					echo "file_row: $file_row; file_row2: $file_row2;<br>\n";											
				} // end while Loop file	
			} // end if check file that found in each folder
			if ($url != "") {
				while (list($key,$value) = each($url)) {
					list($url_row, $url_row2) = split('/',$value);
					echo "url_row: $url_row; url_row2: $url_row2;<br>\n";					
				} // end while Loop file	
			} // end if check url that found in each folder*/
			
		} // end while Loop folder
	}
	if ($file != "") {
		//echo "have_folder : ".$have_folder."<br>";
		while (list($key,$value) = each($file)) {
			//echo "Value file: ".$value."<br>";
			//$file_row = intval(substr($value,0,3));
			//echo "file_row : ".$file_row."<br>";
			//$file_row2 = intval(substr($value,3,3));
			//echo "file_row 2: ".$file_row2."<br>";
			
			list($file_row, $file_row2) = split('/',$value);
			//echo "file_row: $file_row; file_row2: $file_row2;<br>\n";
			
			$row_file = mysql_query("SELECT * FROM resources WHERE id=$file_row;");
			$get_file = mysql_fetch_array($row_file);
			
			$r_refid = $get_file["refid"];
			$r_ref_res = $get_file["id"];
			$r_file = $get_file["file"];
			
			if ($r_refid != 0) {
				$row_get_refid = mysql_query("SELECT * FROM resources WHERE ref_res=$r_refid AND modules=$modules;");
				$get_refid = mysql_fetch_array($row_get_refid);
				if (mysql_num_rows($row_get_refid) != 0) {
					$r_refid_ins = $get_refid["id"];	
				} 
				else {
					$r_refid_ins = 0;
				}
			} else {
				$r_refid_ins = 0;
			}
			//echo "File"."<br>";
			//echo "Refid to insert : ".$r_refid_ins."<br>";
			//echo "name : ".$get_file["name"]."<br>";
			//echo "Refid : ".$get_file["refid"]."<br>";
			//echo "Ref_res : ".$get_file["ref_res"]."<br>";
			//echo "File : ".$get_file["file"]."<br>";
			//echo "Courses : ".$courses."<br>";
			//echo "Modules : ".$modules."<br>";
			//echo "User : ".$user."<br>";
			
			if ($isedit != 1) {			
				mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
											VALUES ('".$get_file["name"]."', $r_refid_ins, $r_ref_res, 0, '$r_file', $courses,  $modules, ".time().", $user, 1);"); 
			} else {	
				if ($have_folder == true) {
					//echo "file_row2: ".$file_row2."<br>";
					
					$row_get_refid2 = mysql_query("SELECT * FROM resources WHERE ref_res=$file_row2 AND refid = $res_id AND modules=$modules AND public=1;");
					$get_refid2 = mysql_fetch_array($row_get_refid2);
					if (mysql_num_rows($row_get_refid2) != 0) {
						$r_refid_ins2 = $get_refid2["id"];
						//echo "r_refid_ins2 : ".$r_refid_ins2."<br>";
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
													VALUES ('".$get_file["name"]."', $r_refid_ins2, $r_ref_res, 0, '$r_file', $courses,  $modules, ".time().", $user, 1);");
					} else {
							mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
													VALUES ('".$get_file["name"]."', $res_id, $r_ref_res, 0, '$r_file', $courses,  $modules, ".time().", $user, 1);");
						}
					
				} else {		
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
													VALUES ('".$get_file["name"]."', $res_id, $r_ref_res, 0, '$r_file', $courses,  $modules, ".time().", $user, 1);"); 
							}
			}
			
			$new_id=mysql_insert_id();
								
			$newfile_name=strtolower($r_file);
			$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
			$newfile_name=str_replace(".php",".html",$newfile_name);
			$newfile_name=str_replace(".cgi",".html",$newfile_name);
			$newfile_name=str_replace(".pl",".html",$newfile_name);
			$newfile_name=str_replace(".phtml",".html",$newfile_name);
			$newfile_name=str_replace(".shtml",".html",$newfile_name);
			$newfile_name=str_replace("'","&#039;",$newfile_name);

			exec("rm -R -f $realpath/files/resources_files/$new_id");
			$allpath=$realpath."/files/resources_files/".$new_id;
			$sourcepath=$realpath."/files/resources_files/".$r_ref_res;
			mkdir($allpath,0777);
			chmod($allpath,0777);
			copy($sourcepath."/".$r_file,$allpath."/".$newfile_name);
		}
	}
	if ($url != "") {
		//echo "have_folder : ".$have_folder."<br>";
		while (list($key,$value) = each($url)) {
			//echo "Value Url : ".$value."<br>";
			//$url_row = intval(substr($value,0,3));			
			//echo "url_row : ".$url_row."<br>";
			//$url_row2 = intval(substr($value,3,3));			
			//echo "url_row 2: ".$url_row2."<br>";
			
			list($url_row, $url_row2) = split('/',$value);
			//echo "url_row: $url_row; url_row2: $url_row2;<br>\n";
			
			$row_url = mysql_query("SELECT * FROM resources WHERE id=$url_row;");
			$get_url = mysql_fetch_array($row_url);
			
			$r_refid = $get_url["refid"];
			$r_ref_res = $get_url["id"];
			$r_url = $get_url["url"];
			
			if ($r_refid != 0) {
				$row_get_refid = mysql_query("SELECT * FROM resources WHERE ref_res=$r_refid AND modules=$modules;");
				$get_refid = mysql_fetch_array($row_get_refid);
				if (mysql_num_rows($row_get_refid) != 0) {
					$r_refid_ins = $get_refid["id"];
				} 
				else {
					$r_refid_ins = 0;
				}
			} else {
				$r_refid_ins = 0;
			}
			//echo "Url"."<br>";
			//echo "Refid to insert : ".$r_refid_ins."<br>";			
			//echo "name : ".$get_url["name"]."<br>";
			//echo "Refid : ".$get_url["refid"]."<br>";
			//echo "Ref_res : ".$get_url["ref_res"]."<br>";
			//echo "URL : ".$get_url["url"]."<br>";
			//echo "Courses : ".$courses."<br>";
			//echo "Modules : ".$modules."<br>";
			//echo "User : ".$user."<br>";
			
			if ($isedit != 1) {
				mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
											VALUES ('".$get_url["name"]."', $r_refid_ins, $r_ref_res, 0, '$r_url', $courses,  $modules, ".time().", $user, 1);");
			} else {
				if ($have_folder == true) {
					//echo "url_row2: ".$url_row2."<br>";
					
					$row_get_refid2 = mysql_query("SELECT * FROM resources WHERE ref_res=$url_row2 AND refid = $res_id AND modules=$modules AND public=1;");
					$get_refid2 = mysql_fetch_array($row_get_refid2);
					if (mysql_num_rows($row_get_refid2) != 0) {
						$r_refid_ins2 = $get_refid2["id"];
						//echo "r_refid_ins2 : ".$r_refid_ins2."<br>";
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
											VALUES ('".$get_url["name"]."', $r_refid_ins2, $r_ref_res, 0, '$r_url', $courses,  $modules, ".time().", $user, 1);");
					} else {
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
											VALUES ('".$get_url["name"]."', $res_id, $r_ref_res, 0, '$r_url', $courses,  $modules, ".time().", $user, 1);");	
					}
				} else {	
				mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
											VALUES ('".$get_url["name"]."', $res_id, $r_ref_res, 0, '$r_url', $courses,  $modules, ".time().", $user, 1);");
							}
			}
		}
	}
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<script type="text/javascript" language="JavaScript">
function Update(modules){
	window.opener.location.reload("index.php?id="+modules);
	close();
}
</script>
<body onLoad="Javascript:Update(<? echo $modules;?>);">
<!--<body>-->
</body>
</html>
