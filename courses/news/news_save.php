<?php 

require("include/function.php");
//   Add Wall Post ====================================================================================
$userip = $_SERVER['REMOTE_ADDR'];

function checkValues($value)
{
	$value = trim($value);
	 
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	
	 $value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
	
	$value = strip_tags($value);
	$value = mysql_real_escape_string($value);
	$value = htmlspecialchars ($value);
	return $value;
	
}									
//   Add Wall Post ====================================================================================
				 				 
				
				
				
				if($Submit)
					{	
									//$filepath = "/data/httpd_course/files/";
									
									
									$inputSubject=htmlspecialchars($inputSubject);
									$inputTitle=htmlspecialchars($inputTitle);
									
									srand(make_seed());
									$myrand = date("Ymdhis").rand(11111,99999);

									// Check to create module data directory. ---------
									//$System_FullPath_Upload	
									//if(!is_dir($System_RelativePath_Upload."/".$courses)) { mkdir($System_RelativePath_Upload."/".$courses,0777); }
									if(!is_dir($System_FullPath_Upload."/".$courses)) { mkdir($System_FullPath_Upload."/".$courses,0777); }
									//$myModule_FullPath_ThumbnailPicture
									//if(!is_dir($myModule_Path_ThumbnailPicture)) { mkdir($myModule_Path_ThumbnailPicture,0777); }
									if(!is_dir($myModule_FullPath_ThumbnailPicture)) { mkdir($myModule_FullPath_ThumbnailPicture,0777); }
									//$myModule_FullPath_HTMLFiles
									//if(!is_dir($myModule_Path_HTMLFiles)) { mkdir($myModule_Path_HTMLFiles,0777); }
									if(!is_dir($myModule_FullPath_HTMLFiles)) { mkdir($myModule_FullPath_HTMLFiles,0777); }
									//$myModule_FullPath_ImageLibrary
									//if(!is_dir($myModule_Path_ImageLibrary)) { mkdir($myModule_Path_ImageLibrary,0777); }
									if(!is_dir($myModule_FullPath_ImageLibrary)) { mkdir($myModule_FullPath_ImageLibrary,0777); }									
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
											/*
											if(file_exists($myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName)) {
												unlink($myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName);
											}
											if(copy($inputThumbnailPicture,$myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName)) {
												chmod($myModule_Path_ThumbnailPicture."/".$ThumbnailPictureName,0777);
											}
											*/
											if(file_exists($myModule_FullPath_ThumbnailPicture."/".$ThumbnailPictureName)) {
												unlink($myModule_FullPath_ThumbnailPicture."/".$ThumbnailPictureName);
											}
											if(copy($inputThumbnailPicture,$myModule_FullPath_ThumbnailPicture."/".$ThumbnailPictureName)) {
												chmod($myModule_FullPath_ThumbnailPicture."/".$ThumbnailPictureName,0777);
											}
										}
									}
									
									$HTMLFileName = "$myrand.html";
									$HTMLToolContent=stripslashes($HTMLToolContent);
									//$fp = fopen ($myModule_Path_HTMLFiles."/".$HTMLFileName, "w+");
									$fp = fopen ($myModule_FullPath_HTMLFiles."/".$HTMLFileName, "w+");
									fwrite($fp,$HTMLToolContent);
									fclose($fp);
							
							if ($id=="" || $id == none)
							{ 
								
									

							if($expired_date)
									mysql_query("INSERT INTO news_courses(subject,title,picture,htmlfile,courses, post_date, expired_date, news_area) VALUES (\"$inputSubject\",\"$inputTitle\",\"$ThumbnailPictureName\",\"$HTMLFileName\",$courses, now(),'$expired_date',$news_area);");
								else
									mysql_query("INSERT INTO news_courses(subject,title,picture,htmlfile,courses, post_date, expired_date, news_area) VALUES (\"$inputSubject\",\"$inputTitle\",\"$ThumbnailPictureName\",\"$HTMLFileName\",$courses, now(),(DATE_ADD(now(), INTERVAL 7 DAY)),$news_area);");
			
							//   Add Wall Post ====================================================================================
							$postv=$inputSubject."-".$inputTitle;
							$qcourse=mysql_query("SELECT name,section FROM courses WHERE id=".$courses."");
							$cname = mysql_result($qcourse,0,"name");
							$csection= mysql_result($qcourse,0,"section");
							$postname= $cname." [".$csection."]";
				
							mysql_query("INSERT INTO facebook_posts (post,f_name,userip,date_created,userid,courseid) VALUES('".checkValues($postv)."','".$postname."','".$userip."','".strtotime(date("Y-m-d H:i:s"))."',".$person["id"].",".$courses.")");
							//   Add Wall Post ====================================================================================
							}
							else
							{
								
								$sql = "SELECT id,htmlfile,picture FROM news_courses WHERE id=$id";
									
								$Query=MYSQL_QUERY($sql) OR DIE("Error: เกิดความผิดพลาด <br>$sql<br>\n");
								 $row=MYSQL_FETCH_ARRAY($Query);

									$htmlold = $row["htmlfile"];		
									$picold    = $row["picture"];	
									
									
									
								/*	
									
									if(file_exists($myModule_Path_HTMLFiles."/".$htmlold)) {
										unlink($myModule_Path_HTMLFiles."/".$htmlold);
									}
															
								 
								 if ($ThumbnailPictureName !="" && $ThumbnailPictureName !=none){ 
										
										if(file_exists($myModule_Path_ThumbnailPicture."/".$picold) && $picold !="") {
											unlink($myModule_Path_ThumbnailPicture."/".$picold);
											}
										$pic = ",picture=\"$ThumbnailPictureName\"";
										
									}
								*/	
									if(file_exists($myModule_FullPath_HTMLFiles."/".$htmlold)) {
										unlink($myModule_FullPath_HTMLFiles."/".$htmlold);
									}
															
								 
								 if ($ThumbnailPictureName !="" && $ThumbnailPictureName !=none){ 
										
										if(file_exists($myModule_FullPath_ThumbnailPicture."/".$picold) && $picold !="") {
											unlink($myModule_FullPath_ThumbnailPicture."/".$picold);
											}
										$pic = ",picture=\"$ThumbnailPictureName\"";
										
									}
								
								if($expired_date)
									mysql_query("UPDATE news_courses SET subject=\"$inputSubject\",title=\"$inputTitle\"$pic,htmlfile=\"$HTMLFileName\",post_date=now(),expired_date='$expired_date', news_area=$news_area  WHERE id=$id ");
								else 								
									mysql_query("UPDATE news_courses SET subject=\"$inputSubject\",title=\"$inputTitle\"$pic,htmlfile=\"$HTMLFileName\",post_date=now(),expired_date=(DATE_ADD(now(), INTERVAL 7 DAY)), news_area=$news_area  WHERE id=$id ");
							}
							
							header("Location: ?courses=$courses"); 		  		  
					}



?>