<? // post modules id , resouce id , course id from pub_edit ?>
<? require("../include/global_login.php");
	if ($public)
	{	
		if ($lstCourse != 0) {
			$get_module = mysql_query("SELECT m.* FROM modules m WHERE m.refid = $modules AND m.courses = '$lstCourse';");
			$check = 0;
			//echo $check."<br>";
			// get module that exist in Table module
			if(mysql_num_rows($get_module)!=0) {
				//echo "get_module record : ".mysql_num_rows($get_module)."<br>";				
				while (($get_mod_id=mysql_fetch_array($get_module))!=0) {
					//echo "module will update : ".$get_mod_id["id"]."<br>";
					$mod_in_wp = mysql_query("SELECT * FROM wp WHERE modules=".$get_mod_id["id"]." AND courses='$lstCourse';");
					if (mysql_num_rows($mod_in_wp)!=0) {
						//echo "found record"."<br>";
						mysql_query("UPDATE modules set updated=".time().", users=".$person["id"]." WHERE refid = $modules AND courses = '$lstCourse';");
						$check = 0;
						break;
					}
					else {
						//echo "not found record"."<br>";
						$check = 1;
					}
				}//end while
				//$check = 1;
			}
			else {
				$check = 1;
			}			
			if ($check == 1) {
				$module_public = mysql_query("SELECT m.* FROM modules m WHERE m.id = $modules;");
				if(mysql_num_rows($module_public)!=0){
					$row=mysql_fetch_array($module_public);
					mysql_query("INSERT INTO modules (refid, modules_type, name, active, courses, users, created) VALUES (".$row["id"].", ".$row["modules_type"].", '".$row["name"]."', 1, '$lstCourse', ".$person["id"].",".time().");");
					$new_module = mysql_insert_id();
					//$get_n_module = mysql_query("SELECT m.* FROM modules m WHERE m.refid = $modules;");
					//$new_module = mysql_fetch_array($get_n_module);
					//echo mysql_num_rows($get_n_module);
					//echo "New Module : ".$new_module."<br>";
					//$new_module = $g_new_m["id"];
 					mysql_query("INSERT INTO wp (courses, modules, users) VALUES ('$lstCourse', '$new_module', ".$person["id"].");");
					//mysql_free_result($get_n_module);
				}
			}		
			//-----------------------------------------------------------------------------------//
			$get_new_module = mysql_query("SELECT m.* FROM modules m WHERE m.refid = $modules AND m.courses = $lstCourse;");
			$show = mysql_fetch_array($get_new_module); //get new module that come from insert public module
			$get_resource = mysql_query("SELECT r.* FROM resources r WHERE r.modules = $modules ORDER BY r.id;"); // get all resource that module equal module that not publil						
			//echo "Num get_resource : ".mysql_num_rows($get_resource)."<br>";
			$get_resource_p = mysql_query("SELECT r.* FROM resources r WHERE r.id = $id ORDER BY r.id;"); // get resouce id that click from previous page
			//echo "Num get_resource_p : ".mysql_num_rows($get_resource_p)."<br>";
			$resource_p = mysql_query("SELECT r.* FROM resources r WHERE r.modules = ".$show["id"]." AND r.public = 1 AND r.courses = '$lstCourse' ORDER BY r.id;");// get resource have been public .			
			//echo "Num resource_p : ".mysql_num_rows($resource_p)."<br>";
			//-----------------------------------------------------------------------------------//
			if(mysql_num_rows($resource_p)!=0){
				//echo "number resource_p : ".mysql_num_rows($resource_p)."<br>";
				$resource_up = mysql_fetch_array($get_resource_p);
				//add sql check $resource_up already in $resource ?
				//echo $resource_up["id"]."<br>";
				//echo "Number Record resoure_in_db : ".mysql_num_rows($resource_in_db)."<br>";
				$resource_in_db = mysql_query("SELECT r.* FROM resources r WHERE r.modules = ".$show["id"]." AND r.name = ".$resource_up["id"]." AND r.public = 1 AND r.courses = '$lstCourse';");
				//echo "show id : ".$show["id"]."<br>";
				//echo "resource_up : ".$resource_up["id"]."<br>";
				//echo mysql_num_rows($resource_in_db)."<br>"; 
				$get_in_db = mysql_fetch_array($resource_in_db);
				//echo "Resource in DB : ".$get_in_db["id"]."<br>";
				if(mysql_num_rows($resource_in_db)!= 0){					
					mysql_query("UPDATE resources set time=".time().", users=".$person["id"]." WHERE id = ".$get_in_db["id"].";");
				}
				else {
					//echo "course : ".$lstCourse."<br>";				
					//echo "module : ".$resource_up["modules"]."<br>";
					//echo "folder : ".$resource_up["folder"]."<br>";
					//echo "file : ".$resource_up["file"]."<br>";
					//echo "url : ".$resource_up["url"]."<br>";
					//echo "refid : ".$resource_up["refid"]."<br>";
					//echo "name : ".$resource_up["name"]."<br>";
					$r_id = $resource_up["id"];
					$r_module = $resource_up["modules"];
					$r_refid = $resource_up["refid"];
					$r_folder = $resource_up["folder"];
					$r_name =  $resource_up["name"];
					$r_file = $resource_up["file"];
					$r_url = $resource_up["url"];
					$get_module_refid = mysql_query("SELECT DISTINCT * FROM modules WHERE refid = '$r_module';");
					while (($module_refid = mysql_fetch_array($get_module_refid))!=0) {
						$refid_in_wp = mysql_query("SELECT * FROM wp WHERE modules=".$module_refid[id]." AND courses='$lstCourse';");
						if (mysql_num_rows($refid_in_wp)!=0){
							$r_modules_insert = $module_refid["id"];		
							//echo "modules to insert : ".$module_refid["id"]."<br>";
						}
						mysql_free_result($refid_in_wp);
					}//end while $module_refid
					if ($r_refid != 0) {
						$get_refid = mysql_query("SELECT * FROM resources WHERE modules='$r_modules_insert' AND folder=1;");
						//$get_refid = mysql_query("SELECT * FROM resources WHERE refid='$r_refid' and public = 0;");
							/*$get_ref_res = mysql_fetch_array($get_refid);
							$r_refid_insert = $get_ref_res["id"];
							echo "refid to insert : ".$get_ref_res["id"]."<br>";
							echo "resource name to insert : ".$get_ref_res["name"]."<br>";*/
							while ($ref_res=mysql_fetch_array($get_refid)) {
								//$get_ref_ins = mysql_query("SELECT * FROM resources WHERE folder=0 AND refid = ".$ref_res["ref_res"].";");
								if ($r_refid == $ref_res["ref_res"]) {
									$r_refid_insert = $ref_res["id"];
									break;
								}
							}
					}
					
					//-------- insert into resources ----------------//
					if ($r_folder != 0) {
						//insert folder
						//echo "Insert folder"."<br>";
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, modules, time, users, public) VALUES ('$r_name', 0, ".$resource_up["id"].", 1, '$lstCourse', '$r_modules_insert', ".time().", ".$person["id"].", 1);");
					}
					else {
						if ($r_url != "") {
							//insert url
							//echo "Insert url"."<br>";
							//echo "r_name : ".$r_name."<br>";
							//echo "r_refid_insert : ".$r_refid_insert."<br>";
							//echo "r_ref_res : ".$resource_up["id"]."<br>";
							//echo "course : ".$lstCourse."<br>";
							//echo "module : ".$r_modules_insert."<br>";
							//mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, url, modules, time, users, public) VALUES ('$r_name', '$r_refid_insert', ".$resource_up["id"].", 0, '$lstCourse', '$r_url', '$r_modules_insert', ".time().", ".$person["id"].", 1);");
						}
						else {
							if ($r_file != "") {
								//insert file
								//echo "Insert file"."<br>";
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, file, modules, time, users, public)VALUES ('$r_name', '$r_refid_insert', ".$resource_up["id"].", 0, '$lstCourse', '$r_file', '$r_modules_insert', ".time().", ".$person["id"].", 1);");
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
								$sourcepath=$realpath."/files/resources_files/".$r_id;
								mkdir($allpath,0777);
								chmod($allpath,0777);
								copy($sourcepath."/".$file,$allpath."/".$newfile_name);
							}
						}		
					}				
					//-------- insert into resources ----------------//					
				}//end Else mysql_num_rows($resource_p)				
        	}
			else {
				//echo "Not record have been public <br>";
				$resource_pub = mysql_fetch_array($get_resource_p); //resource will public.				
				//echo "course : ".$lstCourse."<br>";				
				//echo "module : ".$resource_pub["modules"]."<br>";
				//echo "folder : ".$resource_pub["folder"]."<br>";
				//echo "file : ".$resource_pub["file"]."<br>";
				//echo "url : ".$resource_pub["url"]."<br>";
				//echo "refid : ".$resource_pub["refid"]."<br>";
				//echo "name : ".$resource_pub["name"]."<br>";
				$r_id = $resource_pub["id"];
				$r_module = $resource_pub["modules"];
				$r_refid = $resource_pub["refid"];
				$r_folder = $resource_pub["folder"];
				$r_name =  $resource_pub["name"];
				$r_file = $resource_pub["file"];
				$r_url = $resource_pub["url"];
				$get_module_refid = mysql_query("SELECT DISTINCT * FROM modules WHERE refid = '$r_module';");
				while (($module_refid = mysql_fetch_array($get_module_refid))!=0) {
						$refid_in_wp = mysql_query("SELECT * FROM wp WHERE modules=".$module_refid[id]." AND courses='$lstCourse';");
						if (mysql_num_rows($refid_in_wp)!=0){
							$r_modules_insert = $module_refid["id"];		
							//echo "modules to insert : ".$module_refid["id"]."<br>";
						}
						mysql_free_result($refid_in_wp);
					}//end while $module_refid
				if ($r_refid != 0) {
						$get_refid = mysql_query("SELECT * FROM resources WHERE modules='$r_modules_insert' AND folder=1;");
						$get_ref_res = mysql_fetch_array($get_refid);
						$r_refid_insert = $get_ref_res["id"];
						//echo "refid to insert : ".$get_ref_res["id"];						
					}
				while (($resource_not_p=mysql_fetch_array($get_resource)) != 0){
					//echo "get_resource : ".mysql_num_rows($get_resource)."<br>";
					//echo "resource_id : ".$resource_not_p["id"]."<br>";
					//echo "resource_id : ".$resource_not_p["folder"]."<br>";
					if (($resource_not_p["folder"] == 1) and ($resource_not_p["id"] == $resource_pub["id"])) {
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, modules, time, users, public) VALUES ('".$resource_not_p["name"]."', '$r_refid', '$r_id', 1, '$lstCourse', '$r_modules_insert', ".time().", ".$person["id"].", 1);");
						$new_folder = mysql_insert_id();
					}
					else {
						$resource_new = mysql_query("SELECT r.* FROM resources r WHERE r.modules = ".$show["id"]." AND r.public = 1 AND r.folder = 0 ");
						//echo "Num resource_new : ".mysql_num_rows($resource_new)."<br>";
						$re_get_new = mysql_fetch_array($resource_new);
						if (mysql_num_rows($resource_new) != 0) {
							if ($resource_not_p["id"] == $resource_pub["id"]){
								if ($resource_not_p["url"] != ""){					
									//echo "update url"."<br>";
								} else {
									if ($resource_not_p["file"] != ""){																	
										//echo "update file"."<br>";										
									}
								}						
							}
						} else {
								if ($resource_not_p["id"] == $resource_pub["id"]){
									//echo "New Folder To insert : ".$new_folder."<br>";
									if ($resource_not_p["url"] != ""){
										if ($new_folder != 0) {
											mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, url, modules, time, users, public) VALUES ('$r_name', '$new_folder', ".$resource_not_p["id"].", 0, '$lstCourse', '$r_url', '$r_modules_insert', ".time().", ".$person["id"].", 1);");											
										} else {
											mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, url, modules, time, users, public) VALUES ('$r_name', '$r_refid_insert', ".$resource_not_p["id"].", 0, '$lstCourse', '$r_url', '$r_modules_insert', ".time().", ".$person["id"].", 1);");		
										}									
										//echo "insert url"."<br>";
									} else {
										if ($resource_not_p["file"] != ""){
											if ($new_folder != 0) {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, file, modules, time, users, public) VALUES ('$r_name', '$new_folder', ".$resource_not_p["id"].", 0, '$lstCourse', '$r_file', '$r_modules_insert', ".time().", ".$person["id"].", 1);");
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
												$sourcepath=$realpath."/files/resources_files/".$r_id;
												mkdir($allpath,0777);
												chmod($allpath,0777);
												copy($sourcepath."/".$file,$allpath."/".$newfile_name);
											} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, file, modules, time, users, public) VALUES ('$r_name', '$r_refid_insert', ".$resource_not_p["id"].", 0, '$lstCourse', '$r_file', '$r_modules_insert', ".time().", ".$person["id"].", 1);");
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
												$sourcepath=$realpath."/files/resources_files/".$r_id;
												mkdir($allpath,0777);
												chmod($allpath,0777);
												copy($sourcepath."/".$file,$allpath."/".$newfile_name);
											}											
											//echo "insert file"."<br>";
										}
									}
								} 
						}
					}	
				}// end while $resource
			}
		}// end if lstCourse		
	}
?>
<meta http-equiv="refresh" content="0;url=index.php?id=<? echo $modules ?>">