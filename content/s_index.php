<?
	    include("../include/global_login.php");
		 require_once ("config.inc.php"); 
		 require_once ("global.inc.php"); 
		include('include/config.inc.php');
		include("include/content.class.php");
		require_once("include/lesson.inc.php"); 
		require_once ("include/classes/XML/XML_HTMLSax/XML_HTMLSax.php");
		session_start();
		$strFileName = "Save content";
				

		
$content= new Content($module_id,$course,$person['id']);
@list($cid,$cname,$mod_name) = $content->GetCosModName($content);

/*
if($load==1){
//echo $file;

		header("Content-disposition: attachment; filename=content.html"); //
		header("content-type: text/html"); 
		header("Pragma: no-cache"); 
		header("Pragma: public"); 
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
		header("Expires: 0"); 
	readfile($file);
	exit();
}
*/
//===========================Template================================================

 $template= new Template(C_SKIN);
 
 if($show ==1){
 
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
										
			$template->assign_vars(array('CID'=>$cid,
										'CNAME'=>$cname,
										'MOD_NAME'=>$mod_name,
										'THEME_NAME'=>$theme,
										'Content_LessNum'=>$Content_LessNum,
										'LESSONNAME'=>$LessOrder[0].". ".$LessTitle[0]."  [".$Length[0]." ".$Content_TimeUnit."]",
										'DETAIL'=>$LessAbstract[0],
										'LESSON'=>$htmltext,
										'LESSTITLE'=>$Content_Lesson,
										'BUTT'=>" <a href=\"s_index.php\"><img src=\"images/home_bt.gif\"  border=\"0\"></a>",
										));
										
		for($i=0;$i<count($id);$i++){
						$dir = $config['homepath']."/".$content->getModule();
						$imgdir = $content->getModule()."/images";
						$filename =$config['homepath']."/".$content->getModule()."/".$l_file[$i];
						if($id[$i] ==$less_id){
								$link .= "<span class=\"gray\">$l_order[$i]</span>  ";
							}else{
								$link .= "<a href=\"s_index.php?less_id=$id[$i]&filename=$filename&dir=$dir&imgdir=$imgdir&show=1&page=$page\">$l_order[$i]</a> ";
							}
			} // for

										
@list($LessID,,,$LessTitle,$LessAbstract,$LessFile,$Length,$LessOrder) = $content->GetLesson($content,'');
				$total_p = ceil(count($LessID)/$pagesize);
				$prevpage = $page-1;
				$nextpage = $page+1;
				$template->assign_vars(array('LESSLINK'=>$link,
																	'NEXT'=>($total_p>=1 && $page<$total_p)?"<a href=\"s_index.php?page=$nextpage&show=1\">  >>  </a>":"",
																	'BACK'=>($page>1 &&$page<=$total_p)?"<a href=\"s_index.php?page=$prevpage&show=1\">  <<  </a>":"",

								));


 }else{
 
$template->set_filenames(array('body' =>'s_index.html',
										));   

@list($LessID,$CoursesID,$ModulesID,$LessTitle,$LessAbstract,$LessFile,$Length,$LessOrder) = $content->GetLesson($content,'');// for ALL

for($i=0;$i<count($LessID);$i++){
$dir = $config['homepath']."/".$ModulesID[$i]; 
$imgdir = $ModulesID[$i]."/images";
$filename = $config['homepath']."/".$ModulesID[$i]."/".$LessFile[$i];

			$template->assign_block_vars('LESS', array(
																	'LessID'=>$LessID[$i],
																	'LessTitle'=>$LessTitle[$i],
																	'LessAbstract'=>$LessAbstract[$i],
																	'LessOrder'=>$LessOrder[$i],
																	'LessTimes'=>$Length[$i],
																	'SHOWLINK'=>"s_index.php?less_id=$LessID[$i]&filename=$filename&dir=$dir&imgdir=$imgdir&show=1",
																	//LINKTOFILE'=>$filename,
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
														'NODATA'=>$nodata,
											));
}

$template->pparse('body');							

	?>