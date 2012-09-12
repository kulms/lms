<?php 

require("include/function.php");
				
				if($Submit)
					{	
									$inputSubject=htmlspecialchars($inputSubject);
									$inputTitle=htmlspecialchars($inputTitle);
									srand(make_seed());
									$myrand = date("Ymdhis").rand(11111,99999);

									// Check to create module data directory. ---------
									if(!is_dir($System_RelativePath_Upload."/".$user_id)) { mkdir($System_RelativePath_Upload."/".$user_id,0777); }
									if(!is_dir($myModule_Path_ThumbnailPicture)) { mkdir($myModule_Path_ThumbnailPicture,0777); }
									if(!is_dir($myModule_Path_HTMLFiles)) { mkdir($myModule_Path_HTMLFiles,0777); }
									if(!is_dir($myModule_Path_ImageLibrary)) { mkdir($myModule_Path_ImageLibrary,0777); }
									// ------------------------------------------------
	
									if(is_file($inputThumbnailPicture)) {
										$ImageData = getimagesize($inputThumbnailPicture);
										if($ImageData!=NULL) {
											if($ImageData[2]==1) { 
												$ImageType="gif";
											} elseif($ImageData[2]==2) {
												$ImageType="jpg";
											}
											
											$ThumbnailPictureName = "$myrand.$ImageType";
											if(file_exists($myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName)) {
												unlink($myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName);
											}
											if(copy($inputThumbnailPicture,$myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName)) {
												chmod($myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName,0777);
											}
											
										}
									}
									
									$HTMLFileName = "$myrand.html";
									$HTMLToolContent=stripslashes($HTMLToolContent);
									$fp = fopen ($myModule_Path_HTMLFiles."/".$HTMLFileName, "w+");
									fwrite($fp,$HTMLToolContent);
									fclose($fp);
							
							if ($id=="" || $id == none)
							{ 
								
									

							if($expired_date)
									mysql_query("INSERT INTO news_system(users,category,subject,title,picture,htmlfile, post_date, expired_date, news_area) VALUES ($user_id,$category,\"$inputSubject\",\"$inputTitle\",\"$ThumbnailPictureName\",\"$HTMLFileName\", now(),'$expired_date',$news_area);");
								else
									mysql_query("INSERT INTO news_system(users,category,subject,title,picture,htmlfile, post_date, expired_date, news_area) VALUES ($user_id,$category,\"$inputSubject\",\"$inputTitle\",\"$ThumbnailPictureName\",\"$HTMLFileName\", now(),(DATE_ADD(now(), INTERVAL 7 DAY)),$news_area);");
							}
							else
							{
								
								$sql = "SELECT id,htmlfile,picture FROM news_system WHERE id=$id";
									
								$Query=MYSQL_QUERY($sql) OR DIE("Error: เกิดความผิดพลาด <br>$sql<br>\n");
								 $row=MYSQL_FETCH_ARRAY($Query);

									$htmlold = $row["htmlfile"];		
									$picold    = $row["picture"];	
									
									
									
									
									
									if(file_exists($myModule_Path_HTMLFiles."/".$htmlold)) {
										unlink($myModule_Path_HTMLFiles."/".$htmlold);
									}
															
								 
								 if ($ThumbnailPictureName !="" && $ThumbnailPictureName !=none){ 
										
										if(file_exists($myModule_Path_ThumbnailPicture."/".$picold) && $picold !="") {
											unlink($myModule_Path_ThumbnailPicture."/".$picold);
											}
										$pic = ",picture=\"$ThumbnailPictureName\"";
										
									}
								
								if($expired_date)
									mysql_query("UPDATE news_system SET subject=\"$inputSubject\",title=\"$inputTitle\"$pic,htmlfile=\"$HTMLFileName\",post_date=now(),expired_date='$expired_date', news_area=$news_area,category=$category  WHERE id=$id and users=$user_id ");
								else 								
									mysql_query("UPDATE news_system SET subject=\"$inputSubject\",title=\"$inputTitle\"$pic,htmlfile=\"$HTMLFileName\",post_date=now(),expired_date=(DATE_ADD(now(), INTERVAL 7 DAY)), news_area=$news_area,category=$category  WHERE id=$id and users=$user_id");
							}
							
								echo "<meta http-equiv=\"refresh\" content=\"0;URL=?m=system&a=news\">";
					}



?>