<?
	    include("../include/global_login.php");
		 require_once ("config.inc.php"); 
	// require_once ("global.inc.php"); 
	// require_once ("include/variables.inc.php"); 
	// require_once ("include/mysql.inc.php"); 
		include('include/config.inc.php');
		include("include/content.class.php");
	require_once("include/lesson.inc.php");  //
	require_once ("include/classes/XML/XML_HTMLSax/XML_HTMLSax.php");	/* for XML_HTMLSax */
		session_start();
		//echo $course;
		//echo $module_id;
		
$content= new Content($module_id,$course,$person['id']);
@list($cid,$cname,$mod_name) = $content->GetCosModName($content);
		

		
if($filename !=""){
	$htmltext = showContent($filename,$dir);
@list(,,,$LessTitle,$LessAbstract,$LessFile,$Length,$LessOrder) = $content->GetLesson($content,$less_id);

}

		
//===========================Template============================
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'showLesson.html',
										));   
										
			$template->assign_vars(array('CID'=>$cid,
										'CNAME'=>$cname,
										'MOD_NAME'=>$mod_name,
										'THEME_NAME'=>$theme,
										'Content_LessNum'=>$Content_LessNum,
										'LESSONNAME'=>$LessOrder[0].". ".$LessTitle[0]."  [ ".$Length[0]." ".$Content_TimeUnit." ]",
										'DETAIL'=>$LessAbstract[0],
										'LESSON'=>$htmltext,
										'EDIT'=>"javascript:popup2('t_index.php?action=editcontent&subaction=editor&filename=$filename&dir=$dir&imgdir=$imgdir','editpg', '800','600')",
										'BACK'=>"t_index.php",
										'DEL'=>"javascript:iconfirmdel('deleteLess.php?less_id=$less_id')",
										));

$template->pparse('body');							


?>