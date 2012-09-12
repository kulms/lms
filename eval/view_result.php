<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);
//echo "Qid===".$qid."+ STD==+".$std."+GID==+".$gid ;
$sql=mysql_query("SELECT question FROM eval_usrd_questions WHERE q_id=".$qid."");
 $question=mysql_result($sql,0,"question");

// get Question Title
if($std !=1){
	$ques_id = $qid;
	$sql="SELECT * FROM eval_usrd_answers  WHERE q_id=".$qid." AND modules_id ='$_SESSION[module_id]'";
}else{
	$ques_id = $gid;
	$sql="SELECT * FROM eval_usrd_answers  WHERE q_id=".$gid." AND modules_id ='$_SESSION[module_id]'";
}

$data_sql=mysql_query($sql);
$num=mysql_num_rows($data_sql);
$pagesize=20;
$result=$evaluate->SelectAnswer($ques_id,$page,$pagesize,$std,$_SESSION[module_id]);
@list($page,$totalpage)=$evaluate->Page($sql,$page,$pagesize);



//=========================================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'view_result.html',));
$template->assign_vars(array('Ques'=>$strEvalQuestion,
															'Question'=>$question,
															'Page'=>$strPage,
															'Close'=>$strClose,
															'THEME_NAME'=>$theme,
															'QUES_NAME'=>$Eval_Question,
															'ANS_NAME'=>$strHome_LabAnswer,
												));
			$x=0;
			while($rs=@$result->fetchRow(DB_FETCHMODE_ASSOC)){
				$template->assign_block_vars('list',array('Q_NAME'=>$rs['txt_answer'],  
																						'COL'=>($x%2==0)?"bgcolor class=\"tdbackground3\" ":"bgcolor class=\"tdbackground_white\"",
																
																));
																$x++;
			}


		if($num !=0){
			//Page
				$prevpage = $page-1;
				$nextpage = $page+1;
				$template->assign_block_vars('page', array(
				'PREV'=>($page>1 && $page<=$totalpage) ?"<a href=\"view_result?qid=".$qid."&page=".$prevpage."&gid=".$gid."&std=".$std."\"><img src=\"../images/back.gif\" border=0></a>":"",
				'NEXT'=>($page!=$totalpage)?"<a href=\"view_result?qid=".$qid."&page=".$nextpage."&gid=".$gid."&std=".$std."\"><img src=\"../images/next.gif\" border=0></a>":"",
				'PAGE'=>"[$page/$totalpage]",
																			));
				//pagerows
				for ($i=1; $i<=$totalpage; $i++) {
								 if ($i == $page) {
									$template->assign_block_vars('pagerows',array(
																									'PAGE'=>$i
																								));
								 }else {
											 $j= "<a href=\"view_result?qid=".$qid."&page=".$i."&gid=".$gid."&std=".$std."\">$i</a>&nbsp;";
													 $template->assign_block_vars('pagerows',array(
																												'PAGE'=>$j
																											));
								 }
					}
			}
			
			
$template->pparse('body');		
																				
?>