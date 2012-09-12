<? 
	require("../include/global_login.php");
	//echo "folders : ".$folders."<br>";
	//echo "res_id : ".$res_id."<br>";
	echo $isedit;	
	$have_folder = false;

	if ($folder != "") { 
		$have_folder = true;
		while (list($key,$value) = each($folder)) { 
			//echo "Value Folder : ".$value."<br>";
			$folder_row = intval(substr($value,0,3));
			//echo "folder_row : ".$folder_row."<br>";			
			
			$row_folder = mysql_query("SELECT * FROM resources_center WHERE id=$folder_row;");
			$get_folder = mysql_fetch_array($row_folder);
			
			//echo "Folder"."<br>";
			//echo "name : ".$get_folder["name"]."<br>";
			//echo "Refid : ".$get_folder["refid"]."<br>";
			
			/*if ($get_folder["refid"] != 0) {
				$r_refid = 0;			
			} else {
				$r_refid = $get_folder["refid"];
			}
			//echo "Ref_res : ".$get_folder["ref_res"]."<br>";
			$r_ref_res = $get_folder["id"];*/
			
			//echo "Courses : ".$courses."<br>";
			//echo "Modules : ".$modules."<br>";
			//echo "User : ".$user."<br>";

			if ($isedit != 1) {		
			//================================
				if ($courses != 0) {
			 	mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses,modules, time,users, public) 
			 								VALUES ('".$get_folder["name"]."', 0, 0, 1, $courses, $modules, ".time().", ".$person["id"].", 1);");
				} else {
				mysql_query("INSERT INTO resources (name, refid, ref_res, folder, modules, time,users, public) 
			 								VALUES ('".$get_folder["name"]."', 0, 0, 1, $modules, ".time().", ".$person["id"].", 1);");
				}				
			} else {
			//================================
				//echo "insert 2"."<br>";
				if ($courses!=0) {
				mysql_query("INSERT INTO resources (name, refid, ref_res, folder, courses, modules, time,users, public) 
			    							VALUES ('".$get_folder["name"]."', $res_id, 0, 1, $courses, $modules, ".time().", ".$person["id"].", 1);");
				} else {
				mysql_query("INSERT INTO resources (name, refid, ref_res, folder, modules, time,users, public) 
			    							VALUES ('".$get_folder["name"]."', $res_id, 0, 1, $modules, ".time().", ".$person["id"].", 1);");
				}
				
			}			
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
			
			$row_file = mysql_query("SELECT * FROM resources_center WHERE id=$file_row;");
			$get_file = mysql_fetch_array($row_file);
			
			$r_refid = $get_file["refid"];
			//$r_ref_res = $get_file["id"];
			$r_file = $get_file["file"];
			
			/*if ($r_refid != 0) {
				$row_get_refid = mysql_query("SELECT * FROM resources_center WHERE ref_res=$r_refid AND modules=$modules;");
				$get_refid = mysql_fetch_array($row_get_refid);
				if (mysql_num_rows($row_get_refid) != 0) {
					$r_refid_ins = $get_refid["id"];
				} 
				else {
					$r_refid_ins = 0;
				}
			} else {
				$r_refid_ins = 0;
			}*/
			
			//echo "File"."<br>";
			//echo "Refid to insert : ".$r_refid_ins."<br>";
			//echo "name : ".$get_file["name"]."<br>";
			//echo "Refid : ".$get_file["refid"]."<br>";
			//echo "Ref_res : ".$get_file["ref_res"]."<br>";
			//echo "File : ".$get_file["file"]."<br>";
			//echo "Courses : ".$courses."<br>";
			//echo "Modules : ".$modules."<br>";
			//echo "User : ".$user."<br>";
			$link = "http://".$_SERVER["HTTP_HOST"]."/".$_SESSION['path']."/files/resources_center_files/";
			
			if ($isedit == 1) {			
						
				if ($have_folder == true) {
					//echo "file_row2: ".$file_row2."<br>";
					
					$row_get_refid2 = mysql_query("SELECT * FROM resources_center WHERE id=$file_row2 ;");
					$get_refid2 = mysql_fetch_array($row_get_refid2);
					if (mysql_num_rows($row_get_refid2) != 0) {
						//$r_refid_ins2 = $get_refid2["id"];  
						//echo "r_refid_ins2 : ".$r_refid_ins2."<br>";
						$row_cmp = mysql_query("SELECT * FROM resources WHERE STRCMP(name, '".$get_refid2["name"]."')=0 AND modules=$modules AND refid=$res_id;");
						$row_cmp2 =  mysql_fetch_array($row_cmp);
						if (STRCMP($get_refid2["name"], $row_cmp2["name"])==0) {
							//echo " File equal"."<br>";
							if ($courses!=0) {
										if($get_file["index_name"] == ""){
											mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																		VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
											} else {
											mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																		VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
											}							
									} else {
											if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
									}														
							} else {
								if ($courses!=0) {
												if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
							
								} else {
									if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}																
								}							
							}
					} else {
					
							if ($courses != 0) {
												if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
							} else {
												if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
							}
						}
					
				} else {	
						if ($courses!=0) {	
												if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
						} else {
												if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$res_id."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
						}
				}
							
			} else {	
				if ($have_folder == true) {
					//echo "file_row2: ".$file_row2."<br>";
					
					$row_get_refid2 = mysql_query("SELECT * FROM resources_center WHERE id=$file_row2 ;");
					$get_refid2 = mysql_fetch_array($row_get_refid2);
					if (mysql_num_rows($row_get_refid2) != 0) {
						//$r_refid_ins2 = $get_refid2["id"];  
						//echo "r_refid_ins2 : ".$r_refid_ins2."<br>";
						$row_cmp = mysql_query("SELECT * FROM resources WHERE STRCMP(name, '".$get_refid2["name"]."')=0 AND modules=$modules;");
						$row_cmp2 =  mysql_fetch_array($row_cmp);
						if (STRCMP($get_refid2["name"], $row_cmp2["name"])==0) {
							//echo " File equal"."<br>";
							if ($courses!=0) {
							if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
							//$r_ref_res = $row_cmp2["id"];
							} else {
							if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', '".$row_cmp2["id"]."', 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}							
							}
						} else {
							if ($courses != 0) {
								if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}														
								//$r_ref_res = $row_cmp2["id"];
							} else {
								if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}														
							}
						}
					} else {
						if ($courses!=0) {
							if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}														
							//$r_ref_res = $row_cmp2["id"];
							} else {
							if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}														
							}
					}
					
				} else {	
					if ($courses!=0) {	
						if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}														
							//$r_ref_res = $row_cmp2["id"];
					} else {
					if($get_file["index_name"] == ""){
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, file, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '$r_file', $courses, $modules, ".time().",".$person["id"].", 1);");
												} else {
												mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
																			VALUES ('".$get_file["name"]."', 0, 0, 0, '".$link.$get_file["id"]."/".$get_file["index_name"]."', $courses, $modules, ".time().",".$person["id"].", 1);");
												}														
					}
				}
			}
			
			
			$new_id=mysql_insert_id();
			
			if($get_file["index_name"]=="") {					
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
			$sourcepath=$realpath."/files/resources_center_files/".$file_row;
			mkdir($allpath,0777);
			chmod($allpath,0777);
			copy($sourcepath."/".$r_file,$allpath."/".$newfile_name);
			}
		}
	}
	
	if ($url != "") {
		echo "have_folder : ".$have_folder."<br>";
		while (list($key,$value) = each($url)) {
			echo "Value Url : ".$value."<br>";
			
			//$url_row = intval(substr($value,0,3));			
			//echo "url_row : ".$url_row."<br>";
			//$url_row2 = intval(substr($value,3,3));			
			//echo "url_row 2: ".$url_row2."<br>";
			
			list($url_row, $url_row2) = split('/',$value);
			//echo "url_row: $url_row; url_row2: $url_row2;<br>\n";
			
			$row_url = mysql_query("SELECT * FROM resources_center WHERE id=$url_row;");
			$get_url = mysql_fetch_array($row_url);
			
			$r_refid = $get_url["refid"];
			//$r_ref_res = $get_url["id"];
			$r_url = $get_url["url"];
			
			/*if ($r_refid != 0) {
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
			}*/
			
			//echo "Url"."<br>";
			//echo "Refid to insert : ".$r_refid_ins."<br>";			
			//echo "name : ".$get_url["name"]."<br>";
			//echo "Refid : ".$get_url["refid"]."<br>";
			//echo "Ref_res : ".$get_url["ref_res"]."<br>";
			//echo "URL : ".$get_url["url"]."<br>";
			//echo "Courses : ".$courses."<br>";
			//echo "Modules : ".$modules."<br>";
			//echo "User : ".$user."<br>";
			
			if ($isedit == 1) {
			//echo "qqq";
				
				if ($have_folder == true) {
					//echo "url_row2: ".$url_row2."<br>";
					
					$row_get_refid2 = mysql_query("SELECT * FROM resources_center WHERE id=$url_row2;");
					$get_refid2 = mysql_fetch_array($row_get_refid2);
					if (mysql_num_rows($row_get_refid2) != 0) {
						//$r_refid_ins2 = $get_refid2["id"];
						//echo "r_refid_ins2 : ".$r_refid_ins2."<br>";
						$row_cmp = mysql_query("SELECT * FROM resources WHERE STRCMP(name, '".$get_refid2["name"]."')=0 AND modules=$modules AND refid=$res_id;");
						$row_cmp2 =  mysql_fetch_array($row_cmp);
						if (STRCMP($get_refid2["name"], $row_cmp2["name"])==0) {
						//echo "Url equal"."<br>";
							if ($courses != 0) {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");
							} else {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");
							}
						} else {
							if ($courses!=0) {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', $res_id, 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");
							} else {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', $res_id, 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");
							}
						}
					} else {
						if ($courses!=0) {
							mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
													VALUES ('".$get_url["name"]."', $res_id, 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");	
						} else {
							mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
													VALUES ('".$get_url["name"]."', $res_id, 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");	
						}
					}
				} else {
						//echo "teqqqee";
					if ($courses!=0) {
						echo $courses;
						echo $res_id;
						$sql = "INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
													VALUES ('".$get_url["name"]."', $res_id, 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);";
						echo $sql."<br>";							
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
													VALUES ('".$get_url["name"]."', $res_id, 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");
					} else {
						mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
													VALUES ('".$get_url["name"]."', $res_id, 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");
					}
				}
							
			} else {
				if ($have_folder == true) {
					//echo "url_row2: ".$url_row2."<br>";
					
					$row_get_refid2 = mysql_query("SELECT * FROM resources_center WHERE id=$url_row2;");
					$get_refid2 = mysql_fetch_array($row_get_refid2);
					if (mysql_num_rows($row_get_refid2) != 0) {
						//$r_refid_ins2 = $get_refid2["id"];
						//echo "r_refid_ins2 : ".$r_refid_ins2."<br>";
						$row_cmp = mysql_query("SELECT * FROM resources WHERE STRCMP(name, '".$get_refid2["name"]."')=0 AND modules=$modules;");
						$row_cmp2 =  mysql_fetch_array($row_cmp);
						if (STRCMP($get_refid2["name"], $row_cmp2["name"])==0) {
						//echo "Url equal"."<br>";
							if ($courses!=0) {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");
							} else {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', '".$row_cmp2["id"]."', 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");
							}							
						} else {
							if ($courses!=0) {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', 0, 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");
							} else {
								mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
															VALUES ('".$get_url["name"]."', 0, 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");
							}
						}
					} else {
						if ($courses!= 0) {
							mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
														VALUES ('".$get_url["name"]."', 0, 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");	
						} else {
							mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
														VALUES ('".$get_url["name"]."', 0, 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");	
						}
					}
				} else {	
				if ($courses!=0) {
					mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, courses, modules, time,users, public) 
												VALUES ('".$get_url["name"]."', 0, 0, 0, '$r_url', $courses, $modules, ".time().", ".$person["id"].", 1);");
					} else {
					mysql_query("INSERT INTO resources (name, refid, ref_res, folder, url, modules, time,users, public) 
												VALUES ('".$get_url["name"]."', 0, 0, 0, '$r_url', $modules, ".time().", ".$person["id"].", 1);");
					}
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
function Update(modules,courses){
	window.opener.location.reload("index.php?id="+modules+"&courses="+courses);
	close();
}
</script>
<body onLoad="Javascript:Update(<? echo $modules;?>,<? echo $courses;?>);">
<!--<body>-->
</body>
</html>
