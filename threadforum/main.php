<? 
require("../include/global_login.php");
include('classes/config.inc.php');

//===========Query======================
$webboard=new Webboard(0,0,'','','','',$person["id"],$id,$courses);
$row=$webboard->SelectReportAll($webboard,1,$search);
$result=$webboard->ListTopic($webboard,$row,$page,$search);
$num=$result->numRows();
@list($detail,$sort,$date,$thread,$mail)=$webboard->SelectPrefs($webboard);                         //select preferences
@list($a,$page,$totalpage)=$webboard->ShowSeqTable ($webboard,$row,$page,1);			//return action page and totalpage
$reply=0;
$topic=1;
$menu=1;
$color = array(COLOR1,COLOR2);

//==========Template====================
$template= new Template(C_SKIN);
$template->set_filenames(array('body' => 'main.html',
							));
		//Text
		$template->assign_vars(array('PAGE' =>($num !=0)?"<b>Page : </b>":"" ,
																	//'ERROR'=>($num ==0)?"No Data":"",
														));
		$template->assign_block_vars('Error',array('ERROR'=>($num ==0)?"No Data":"",));
		//Topic
		$i=0;
		while($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)){
			$icon=$rs['icon'].".gif";
			$posttime=$rs['time'];
			$lasttime=$rs['last'];
			$data=$rs['contrib'];
		//	echo $lastpoet=$rs['lastpost'];
			//	if($posttime==$lasttime){
			//			$time= "(".date("d/m/Y H:i",$posttime).")";
			//	 }else{
			//			$time= "(".date("d/m/Y H:i",$posttime)." updated ".date("d/m/Y H:i",$lasttime).")";
			//	 }
			$time= "(".date("d/m/Y H:i",$posttime).")";
			$sql=mysql_query("SELECT max(time) as lastpost FROM threadforum WHERE (refid=".$rs['id']." AND refid !=0 ) AND deleted !=1");
			$num_lastpost=mysql_num_rows($sql);
			if(mysql_result($sql,0,'lastpost') != ""){
				$lastpost=mysql_result($sql,0,'lastpost');
				$Lastpost= "(".date("d/m/Y H:i",$lastpost).")";
				$sql_user=mysql_query("SELECT users  FROM threadforum WHERE refid=".$rs['id']." AND time=".$lastpost);
				$sql_f=mysql_query("SELECT firstname,login FROM users WHERE id=".mysql_result($sql_user,0,'users'));
				if(mysql_result($sql_f,0,'firstname') !="")
					$lastpost_name=mysql_result($sql_f,0,'firstname');
				else
					$lastpost_name=mysql_result($sql_f,0,'login');
			}else{
				$lastpost_name="-";
				$Lastpost="";
			}

			$replies=$webboard->CountPost($rs['id']);
			$template->assign_block_vars('topiclist', array('NUM'=>$count.".",
															'SUBJECT'=>"<A HREF=\"?a=show_topic&topicid=".$rs["id"]."&refid=".$rs["refid"]."&id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&r=1&reply=1\">".$rs["subject"]."</a>",
															'BG_C'=>$color[$i%2] ,
															'ICON'=>($icon==null)?"":"<img src=./images/icons/".$icon.">" ,
															'CAM'=>($rs['img']=="")?"":"<img src=./images/camera.gif>",
															'NEW'=>(date("d/m/Y H:i")-date("d/m/Y H:i",$posttime)<=5)?"<img src=./images/new_day.gif>":"",
															'REPLY'=>$replies,
															'READ'=>$rs['read_topic'],
															'LOGIN'=>$rs['login'],
															'TIME'=>$time,
															'LASTPOST'=>$lastpost_name." ".$Lastpost,
										));
			if($detail==1){
				$template->assign_block_vars('topiclist.detail', array('DETAIL'=>$webboard->filter($data,1),
										));
			}
			$i++;
		}	
		
		if($num !=0){
		//Page
			$prevpage = $page-1;
			$nextpage = $page+1;
			$template->assign_block_vars('page', array(
			'PREV'=>($page>1 && $page<=$totalpage) ?"<a href=\" ?".$a."id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&page=".$prevpage."\"><img src=\"./images/back.gif\" border=0></a>":"",
			'NEXT'=>($page!=$totalpage)?"<a href=\"?".$a."id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&page=".$nextpage."\"><img src=\"./images/next.gif\" border=0></a>":"",
			'PAGE'=>"[$page/$totalpage]",
																		));
			
			//pagerows
			for ($i=1; $i<=$totalpage; $i++) {
				 if ($i == $page) {
					$template->assign_block_vars('pagerows',array(
																					'PAGE'=>$i
																				));
				 }
				 else {
				 $j= "<a href=\"?".$a."id=".$webboard->getWModules()."&courses=".$webboard->getWCourses()."&page=".$i."\">$i</a>&nbsp;";
				 $template->assign_block_vars('pagerows',array(
																					'PAGE'=>$j
																				));
				 }
			}
		}

$template->pparse('body');							
require("posttopic.php"); 
 mysql_close();?>