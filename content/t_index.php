<?
	    include("../include/global_login.php");
		 require_once ("config.inc.php"); 
	 require_once ("global.inc.php"); 
	// require_once ("include/variables.inc.php"); 
	// require_once ("include/mysql.inc.php"); 
		include('include/config.inc.php');
		include("include/content.class.php");
		
//================
			/*
			require_once ("include/register.inc.php");
	require_once("include/forms.inc.php");
	require_once("include/mail.inc.php");
	require_once("include/course.inc.php");
	require_once("include/enroll.inc.php");  */
	require_once("include/lesson.inc.php"); /*
	require_once("include/classroom.inc.php");
	require_once("include/folder.inc.php");
	require_once("include/report.inc.php");
	require_once("include/util.inc.php");
	require_once("include/certificate.inc.php"); 
	require_once("include/package.inc.php");
	require_once("include/school.inc.php");
	require_once ("include/user.inc.php");       */
	require_once ("include/classes/XML/XML_HTMLSax/XML_HTMLSax.php");	/* for XML_HTMLSax */
session_start();
		
//=========		
		
$content= new Content($module_id,$course,$person['id']);
@list($cid,$cname,$mod_name) = $content->GetCosModName($content);
		
		
//$path ="upload/";
if(isset($module_id)){   // Create  directory of module 

$dir =  $config['homepath']."/".$module_id;
		  if(!file_exists($dir)){
			  mkdir($dir, 0777);  
		 }
$open_dir=opendir($dir);
		 if(!file_exists($dir."/images")){
			  mkdir($dir."/images", 0777);    //create  Image directory
		 }
}

switch($action){
							case "lessonshow":	 lessonShowFrame();break;
							case "editcontent": 
																require_once( "editor/editor.php" );
																initEditor();
																showEditorContent($action,$filename,$dir,$imgdir);exit;	//+ edit.php
			}

		//=====================================================
		
if(isset($Add)){  //ADD NEW LESSON
			$sql ="INSERT INTO con_lesson (LessID,CoursesID,ModulesID,LessTitle, LessAbstract,LessFile,Length,LessOrder) 
								VALUES ('', '$course','$module_id','$less_name', '$less_abstract', '', '$less_times', '$less_no');";
					$rs = mysql_query($sql);				
					$less_id=mysql_insert_id();
$content->UpdateFilename($less_id);
$fileName =$dir."/".$less_id.".html";
$title ="$less_no. $less_name";
$content->FileWrite($content,$fileName,$title,"w");
header("Location:t_index.php");
	
	
}else if(isset($Update)){   // EDIT LESSON
		$sql="UPDATE con_lesson
								SET LessTitle='$less_name',
								LessAbstract='$less_abstract',
								Length='$less_times',
								LessOrder='$less_no' 
								 WHERE LessID ='$less_id' ";
					$rs = mysql_query($sql);				
		header("Location:t_index.php");
}
		
//===========================Template================================================

 $template= new Template(C_SKIN);
 
 if($show ==1){  // show Lesson
		 $pagesize=10;
		 if($page ==""){
				$page =1;
			}

@list($id,$l_file,$l_order)=$content->ListTopic($content,$page,$pagesize);

 if($less_id==""){
		 $less_id=$id[0];
 }
 if($dir == null) $dir = $config['homepath']."/".$content->getModule();
if($filename==null) $filename =$config['homepath']."/".$content->getModule()."/".$l_file[0];
						

 	$htmltext = showContent($filename,$dir);
	@list(,,,$LessTitle,$LessAbstract,$LessFile,$Length,$LessOrder) = $content->GetLesson($content,$less_id);

$template->set_filenames(array('body' =>'showLesson.html',
										));   
	$editLink ="javascript:popup2('t_index.php?action=editcontent&subaction=editor&filename=$filename&dir=$dir&imgdir=$imgdir','editpg', '800','600')";

			$template->assign_vars(array('CID'=>$cid,
										'CNAME'=>$cname,
										'MOD_NAME'=>$mod_name,
										'THEME_NAME'=>$theme,
										'LESSTITLE'=>$Content_Lesson,
										'Content_LessNum'=>$Content_LessNum,
										'LESSONNAME'=>$LessOrder[0].". ".$LessTitle[0]."  [".$Length[0]." ".$Content_TimeUnit."]",
										'DETAIL'=>$LessAbstract[0],
										'LESSON'=>$htmltext,
										'BUTT'=>" <a href=\"$editLink\"><img src=\"images/edit_bt.gif\"  border=\"0\"></a>&nbsp;
														  <a href=\"javascript:iconfirmdel('deleteLess.php?less_id=$less_id&pop=1')\"><img src=\"images/delete_bt.gif\"  border=\"0\"></a>&nbsp;
														 <a href=\"t_index.php\" onClick=\"window.close()\"><img src=\"images/home_bt.gif\"  border=\"0\"></a>",
										));
			for($i=0;$i<count($id);$i++){
				
						$dir = $config['homepath']."/".$content->getModule();
						$imgdir = $content->getModule()."/images";
						$filename =$config['homepath']."/".$content->getModule()."/".$l_file[$i];
						if($id[$i] ==$less_id){
								$link .= "<span class=\"gray\">$l_order[$i]</span>  ";
							}else{
								$link .= "<a href=\"javascript:downloadme('t_index.php?less_id=$id[$i]&filename=$filename&dir=$dir&imgdir=$imgdir&show=1&page=$page')\">$l_order[$i]</a> ";
							}
			} // for
				
@list($LessID,,,$LessTitle,$LessAbstract,$LessFile,$Length,$LessOrder) = $content->GetLesson($content,'');
				$total_p = ceil(count($LessID)/$pagesize);
				$prevpage = $page-1;
				$nextpage = $page+1;
				$template->assign_vars(array('LESSLINK'=>$link,
																	'NEXT'=>($total_p>=1 && $page<$total_p)?"<a href=\"javascript:downloadme('t_index.php?page=$nextpage&show=1')\">  >>  </a>":"",
																	'BACK'=>($page>1 &&$page<=$total_p)?"<a href=\"javascript:downloadme('t_index.php?page=$prevpage&show=1')\">  <<  </a>":"",

								));

				
 }else{
 
$template->set_filenames(array('body' =>'t_index.html',
										));   

if($less_id !=""){
@list($LessID,$CoursesID,$ModulesID,$LessTitle,$LessAbstract,$LessFile,$Length,$LessOrder) = $content->GetLesson($content,$less_id);// for update
				$template->assign_vars(array('LESSID'=>$LessID[0],
																		'LESSNO'=>$LessOrder[0],
																		'LESSNAME'=>$LessTitle[0],
																		'ABTRACT'=>$LessAbstract[0],
																		'LESSTIMES'=>$Length[0],
															));
			}
			
@list($LessID,$CoursesID,$ModulesID,$LessTitle,$LessAbstract,$LessFile,$Length,$LessOrder) = $content->GetLesson($content,'');// for ALL

for($i=0;$i<count($LessID);$i++){
//$config['homepath']."/".
	 $dir =$config['homepath']."/".$ModulesID[$i];  // echo "<br>";// $config['homepath']."/".
	 $imgdir = $ModulesID[$i]."/images";     
	 $filename =$config['homepath']."/".$ModulesID[$i]."/".$LessID[$i].".html";  
			$template->assign_block_vars('LESS', array(
																	'LessID'=>$LessID[$i],
																	'LessTitle'=>$LessTitle[$i],
																	'LessAbstract'=>$LessAbstract[$i],
																	'LessOrder'=>$LessOrder[$i],
																	'LessTimes'=>$Length[$i],
																	//url, name, width, height)
																	'EDITLINK'=>"javascript:popup2('t_index.php?action=editcontent&subaction=editor&filename=$filename&dir=$dir&imgdir=$imgdir','editpg', '800','600')",
																	'SHOWLINK'=>"t_index.php?less_id=$LessID[$i]&filename=$filename&dir=$dir&imgdir=$imgdir&show=1",
																	'EDITNAMELINK'=>"t_index.php?less_id=$LessID[$i]",
																	'EDIT'=>"<a href=\"t_index.php?less_id=$LessID[$i]\"><img src=\"images/edit.png\" alt=\"$strEdit\" border=\"0\"></a>",
																	'DELETE'=>"<a href=\"javascript:iconfirmdel('deleteLess.php?less_id=$LessID[$i]')\"><img src=\"images/delete.png\" alt=\"$strDelete\" border=\"0\"></a>",
																	'Content_LessNmEdit'=>$Content_LessNmEdit,
																	'Content_LessEdit'=>$Content_LessEdit,
																	'Content_LessShow'=>$Content_LessShow,

															
															));
}

	if(count($LessID)==0){
				$nodata = "<tr class=\"tdbackground3\"><td colspan=\"3\" align=\"center\">$Content_NOTHAVE</td></tr>";
	}

$template->assign_vars(array('CID'=>$cid,
														'CNAME'=>$cname,
														'MOD_NAME'=>$mod_name,
														'THEME_NAME'=>$theme,
														'Content_Content' =>$Content_Content ,
														'Content_LessNum'=>$Content_LessNum,
														'Content_LessName'=>$Content_LessName,
														'Content_Abstract'=>$Content_Abstract,
														'Content_Times'=>$Content_Times,
														'Content_AddLess'=>$Content_AddLess,
														'Content_TimeUnit'=>$Content_TimeUnit,
														'CANCLE'=>$strCancel,
														'NODATA'=>$nodata,
														'BUTTON'=>($less_id !='')?"name=\"Update\"  value=\"$Content_UpdateLess\"":"name=\"Add\"  value=\"$Content_AddLess\"",
											
											));
}


$template->pparse('body');							

	?>